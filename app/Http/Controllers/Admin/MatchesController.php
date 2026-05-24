<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMatchRequest;
use App\Http\Requests\Admin\UpdateMatchRequest;
use App\Models\Event;
use App\Models\Matches;
use App\Models\Team;

class MatchesController extends Controller
{
    public function index()
    {
        $matches = Matches::with('event', 'teamA', 'teamB')
            ->whereNull('pandascore_id')
            ->orderBy('scheduled_at', 'desc')
            ->get();
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $events = Event::whereNull('pandascore_id')->orderBy('name')->get();
        $teams  = Team::whereNull('pandascore_id')->orderBy('name')->get();
        return view('admin.matches.create', compact('events', 'teams'));
    }

    public function store(StoreMatchRequest $request)
    {
        Matches::create($request->validated());

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match created successfully!');
    }

    public function edit(Matches $match)
    {
        $events = Event::whereNull('pandascore_id')->orderBy('name')->get();
        $teams  = Team::whereNull('pandascore_id')->orderBy('name')->get();
        return view('admin.matches.edit', compact('match', 'events', 'teams'));
    }

    public function update(UpdateMatchRequest $request, Matches $match)
    {
        $match->update($request->validated());

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
