<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreMatchRequest;
use App\Http\Requests\User\UpdateMatchRequest;
use App\Models\Event;
use App\Models\Matches;

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

        $event->load(['teamA', 'teamB']);

        return view('user.matches.create', compact('event'));
    }

    public function store(StoreMatchRequest $request, Event $event)
    {
        $this->authorize('create', [Matches::class, $event]);

        $validated = $request->validated();

        if (!in_array((int) $validated['team_a_id'], [(int) $event->team_a_id, (int) $event->team_b_id], true)
            || !in_array((int) $validated['team_b_id'], [(int) $event->team_a_id, (int) $event->team_b_id], true)) {
            return back()->withErrors(['team_a_id' => 'Match teams must belong to the selected tournament teams.'])->withInput();
        }

        $validated['event_id'] = $event->id;
        $validated['status'] = $validated['status'] ?? 'scheduled';

        Matches::create($validated);

        return redirect()->route('user.events.matches.index', $event)
            ->with('success', 'Match scheduled!');
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

        $event->load(['teamA', 'teamB']);

        return view('user.matches.edit', compact('event', 'match'));
    }

    public function update(UpdateMatchRequest $request, Event $event, Matches $match)
    {
        $this->authorize('update', $match);
        abort_if($match->event_id !== $event->id, 404);

        $validated = $request->validated();

        if (!in_array((int) $validated['team_a_id'], [(int) $event->team_a_id, (int) $event->team_b_id], true)
            || !in_array((int) $validated['team_b_id'], [(int) $event->team_a_id, (int) $event->team_b_id], true)) {
            return back()->withErrors(['team_a_id' => 'Match teams must belong to the selected tournament teams.'])->withInput();
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
            ->with('success', 'Match removed.');
    }
}
