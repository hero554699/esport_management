<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        // whereNull('pandascore_id') = only user/admin created events, hides PandaScore tournaments
        $events = Event::with('game', 'user')
            ->whereNull('pandascore_id')
            ->orderByRaw("FIELD(approval_status, 'pending', 'approved', 'rejected')")
            ->orderBy('start_date', 'desc')
            ->get();

        $pendingCount = $events->where('approval_status', 'pending')
            ->whereNotNull('user_id')
            ->count();

        return view('admin.events.index', compact('events', 'pendingCount'));
    }

    public function create()
    {
        $games = Game::all();
        return view('admin.events.create', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'game_id'    => 'required|exists:games,id',
            'status'     => 'required|in:upcoming,live,completed',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'prize_pool' => 'nullable|string',
            'banner_url' => 'nullable|url',
        ]);

        Event::create([
            'name'            => $request->name,
            'slug'            => Str::slug($request->name) . '-' . time(),
            'game_id'         => $request->game_id,
            'user_id'         => auth()->id(),
            'status'          => $request->status,
            'approval_status' => 'approved', // Admin created = auto approved
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'prize_pool'      => $request->prize_pool,
            'banner_url'      => $request->banner_url,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        $games = Game::all();
        return view('admin.events.edit', compact('event', 'games'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'game_id'    => 'required|exists:games,id',
            'status'     => 'required|in:upcoming,live,completed',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'prize_pool' => 'nullable|string',
            'banner_url' => 'nullable|url',
        ]);

        $event->update([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name) . '-' . time(),
            'game_id'    => $request->game_id,
            'status'     => $request->status,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'prize_pool' => $request->prize_pool,
            'banner_url' => $request->banner_url,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted!');
    }

    public function approve(Event $event)
    {
        $event->update([
            'approval_status'  => 'approved',
            'rejection_reason' => null,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', "Tournament '{$event->name}' approved!");
    }

    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $event->update([
            'approval_status'  => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', "Tournament '{$event->name}' rejected.");
    }
}