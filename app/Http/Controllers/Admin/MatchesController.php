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
        // whereNull('pandascore_id') = only user/admin created matches
        $matches = Matches::with('event', 'teamA', 'teamB')
            ->whereNull('pandascore_id')
            ->orderBy('scheduled_at', 'desc')
            ->get();
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        // Only user-created events and teams in dropdowns
        $events = Event::whereNull('pandascore_id')->orderBy('name')->get();
        $teams  = Team::whereNull('pandascore_id')->orderBy('name')->get();
        return view('admin.matches.create', compact('events', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id'     => 'required|exists:events,id',
            'team_a_id'    => 'required|exists:teams,id',
            'team_b_id'    => 'required|exists:teams,id|different:team_a_id',
            'stage'        => 'required|string|max:100',
            'status'       => 'required|in:upcoming,live,completed',
            'scheduled_at' => 'required|date|after_or_equal:today',
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
        // Only user-created events and teams in dropdowns
        $events = Event::whereNull('pandascore_id')->orderBy('name')->get();
        $teams  = Team::whereNull('pandascore_id')->orderBy('name')->get();
        return view('admin.matches.edit', compact('match', 'events', 'teams'));
    }

    public function update(Request $request, Matches $match)
    {
        $request->validate([
            'event_id'     => 'required|exists:events,id',
            'team_a_id'    => 'required|exists:teams,id',
            'team_b_id'    => 'required|exists:teams,id|different:team_a_id',
            'stage'        => 'required|string|max:100',
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
