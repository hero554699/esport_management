<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreMatchRequest;
use App\Http\Requests\User\UpdateMatchRequest;
use App\Models\Event;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index(Event $event)
    {
        $this->authorize('view', $event);

        $matches = $event->matches()->with(['teamA', 'teamB', 'result'])->latest('scheduled_at')->get();

        return view('user.matches.index', compact('event', 'matches'));
    }

    public function create(Event $event)
    {
        $this->authorize('create', [Matches::class, $event]);

        // Get only teams from the same game as the tournament
        $teams = Team::where('game_id', $event->game_id)
            ->where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('user.matches.create', compact('event', 'teams'));
    }

    public function store(StoreMatchRequest $request, Event $event)
    {
        $this->authorize('create', [Matches::class, $event]);

        $validated = $request->validated();

        // Verify both teams belong to the same game as tournament
        $teamAValid = Team::where('id', $validated['team_a_id'])
            ->where('game_id', $event->game_id)
            ->where('user_id', Auth::id())
            ->exists();

        $teamBValid = Team::where('id', $validated['team_b_id'])
            ->where('game_id', $event->game_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$teamAValid || !$teamBValid) {
            return back()->withErrors(['team_a_id' => 'Both teams must be from the same game as this tournament.'])->withInput();
        }

        $validated['event_id'] = $event->id;
        $validated['status'] = 'scheduled';

        Matches::create($validated);

        return redirect()->route('user.events.matches.index', $event)
            ->with('success', 'Match scheduled successfully!');
    }

    public function show(Event $event, Matches $match)
    {
        $this->authorize('view', $event);
        $this->authorize('view', $match);
        abort_if($match->event_id !== $event->id, 404);

        $match->load(['teamA', 'teamB', 'result']);

        return view('user.matches.show', compact('event', 'match'));
    }

    public function edit(Event $event, Matches $match)
    {
        $this->authorize('update', $match);
        abort_if($match->event_id !== $event->id, 404);

        // Get only teams from the same game as the tournament
        $teams = Team::where('game_id', $event->game_id)
            ->where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('user.matches.edit', compact('event', 'match', 'teams'));
    }

    public function update(UpdateMatchRequest $request, Event $event, Matches $match)
    {
        $this->authorize('update', $match);
        abort_if($match->event_id !== $event->id, 404);

        $validated = $request->validated();

        // Verify both teams belong to the same game as tournament
        $teamAValid = Team::where('id', $validated['team_a_id'])
            ->where('game_id', $event->game_id)
            ->where('user_id', Auth::id())
            ->exists();

        $teamBValid = Team::where('id', $validated['team_b_id'])
            ->where('game_id', $event->game_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$teamAValid || !$teamBValid) {
            return back()->withErrors(['team_a_id' => 'Both teams must be from the same game as this tournament.'])->withInput();
        }

        $match->update($validated);

        return redirect()->route('user.events.matches.index', $event)
            ->with('success', 'Match updated successfully!');
    }

    public function destroy(Event $event, Matches $match)
    {
        $this->authorize('delete', $match);
        abort_if($match->event_id !== $event->id, 404);

        $match->delete();

        return redirect()->route('user.events.matches.index', $event)
            ->with('success', 'Match deleted.');
    }
}
