<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function store(Request $request, Event $event)
    {
        // Only owner can add matches
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'team_a_id'    => 'required|exists:teams,id|different:team_b_id',
            'team_b_id'    => 'required|exists:teams,id',
            'stage'        => 'required|string|max:100',
            'scheduled_at' => 'required|date|after_or_equal:now',
        ]);

        $validated['event_id'] = $event->id;
        $validated['status']   = 'upcoming';

        Matches::create($validated);

        return redirect()->route('user.events.show', $event)
            ->with('success', 'Match scheduled!');
    }

    public function destroy(Event $event, Matches $match)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $match->delete();

        return redirect()->route('user.events.show', $event)
            ->with('success', 'Match removed.');
    }
}