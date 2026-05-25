<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('game', 'user')
            ->whereNull('pandascore_id')
            ->orderByRaw("FIELD(approval_status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = $events->where('approval_status', 'pending')
            ->whereNotNull('user_id')
            ->count();

        return view('admin.events.index', compact('events', 'pendingCount'));
    }

    public function show(Event $event)
    {
        $event->load(['game', 'user']);
        $matches = $event->matches()->with(['teamA', 'teamB', 'result'])->latest('scheduled_at')->get();

        return view('admin.events.show', compact('event', 'matches'));
    }

    public function create()
    {
        $games = Game::all();
        return view('admin.events.create', compact('games'));
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();

        Event::create([
            ...$validated,
            'slug' => Str::slug($validated['name']) . '-' . time(),
            'user_id' => auth()->id(),
            'approval_status' => 'approved',
            'type' => $validated['type'] ?? 'local',
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        $games = Game::all();
        return view('admin.events.edit', compact('event', 'games'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $validated = $request->validated();

        $event->update([
            ...$validated,
            'slug' => Str::slug($validated['name']) . '-' . time(),
            'type' => $validated['type'] ?? $event->type,
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
