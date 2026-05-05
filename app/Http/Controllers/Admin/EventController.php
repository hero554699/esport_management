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
        $events = Event::with('game')->orderBy('start_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
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
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'prize_pool' => 'nullable|string',
            'banner_url' => 'nullable|url',
        ]);

        Event::create([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'game_id'    => $request->game_id,
            'user_id'    => auth()->id(),
            'status'     => $request->status,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'prize_pool' => $request->prize_pool,
            'banner_url' => $request->banner_url,
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
            'slug'       => Str::slug($request->name),
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
}
