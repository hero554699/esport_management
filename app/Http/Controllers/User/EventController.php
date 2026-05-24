<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreEventRequest;
use App\Http\Requests\User\UpdateEventRequest;
use App\Models\Event;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->with(['game', 'teamA', 'teamB'])
            ->withCount('matches')
            ->latest()
            ->get();

        return view('user.events.index', compact('events'));
    }

    public function create()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();
        $teams = Team::where('user_id', Auth::id())->orderBy('name')->get();

        return view('user.events.create', compact('games', 'teams'));
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $validated['slug']            = Str::slug($validated['name']) . '-' . time();
        $validated['user_id']         = Auth::id();
        $validated['status']          = 'upcoming';
        $validated['approval_status'] = 'pending';

        Event::create($validated);

        return redirect()->route('user.events.index')
            ->with('success', 'Tournament created! Waiting for admin approval.');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $event->load(['matches.teamA', 'matches.teamB', 'matches.result', 'game', 'teamA', 'teamB']);

        $teams = Team::where('user_id', Auth::id())->orderBy('name')->get();

        return view('user.events.show', compact('event', 'teams'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $games = Game::where('is_active', true)->orderBy('name')->get();
        $teams = Team::where('user_id', Auth::id())->orderBy('name')->get();

        return view('user.events.edit', compact('event', 'games', 'teams'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return redirect()->route('user.events.index')
            ->with('success', 'Tournament updated successfully!');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('user.events.index')
            ->with('success', 'Tournament deleted.');
    }
}
