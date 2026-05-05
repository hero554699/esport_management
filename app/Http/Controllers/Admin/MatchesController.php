<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    public function index()
    {
        $matches = Matches::with('event', 'teamA', 'teamB')->orderBy('scheduled_at', 'desc')->get();
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $events = Event::orderBy('name')->get();
        $teams  = Team::orderBy('name')->get();
        return view('admin.matches.create', compact('events', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id'     => 'required|exists:events,id',
            'team_a_id'    => 'required|exists:teams,id',
            'team_b_id'    => 'required|exists:teams,id|different:team_a_id',
            'stage'        => 'required|in:group,quarterfinal,semifinal,final',
            'status'       => 'required|in:upcoming,live,completed',
            'scheduled_at' => 'required|date',
        ]);

        Matches::create($request->only([
            'event_id',
            'team_a_id',
            'team_b_id',
            'stage',
            'status',
            'scheduled_at'
        ]));

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match created successfully!');
    }

    public function edit(Matches $match)
    {
        $events = Event::orderBy('name')->get();
        $teams  = Team::orderBy('name')->get();
        return view('admin.matches.edit', compact('match', 'events', 'teams'));
    }

    public function update(Request $request, Matches $match)
    {
        $request->validate([
            'event_id'     => 'required|exists:events,id',
            'team_a_id'    => 'required|exists:teams,id',
            'team_b_id'    => 'required|exists:teams,id|different:team_a_id',
            'stage'        => 'required|in:group,quarterfinal,semifinal,final',
            'status'       => 'required|in:upcoming,live,completed',
            'scheduled_at' => 'required|date',
        ]);

        $match->update($request->only([
            'event_id',
            'team_a_id',
            'team_b_id',
            'stage',
            'status',
            'scheduled_at'
        ]));

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match updated successfully!');
    }

    public function destroy(Matches $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')
            ->with('success', 'Match deleted!');
    }
}
