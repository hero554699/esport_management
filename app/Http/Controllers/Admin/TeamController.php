<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamRequest;
use App\Http\Requests\Admin\UpdateTeamRequest;
use App\Models\Game;
use App\Models\Organization;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('game', 'organization')
            ->whereNull('pandascore_id')
            ->withCount('players')
            ->orderBy('name')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $team->load(['players', 'game']);
        return view('admin.teams.show', compact('team'));
    }

    public function create()
    {
        $games = Game::all();
        $organizations = Organization::all();
        return view('admin.teams.create', compact('games', 'organizations'));
    }

    public function store(StoreTeamRequest $request)
    {
        Team::create($request->validated());

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team created successfully!');
    }

    public function edit(Team $team)
    {
        $games = Game::all();
        $organizations = Organization::all();
        return view('admin.teams.edit', compact('team', 'games', 'organizations'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team->update($request->validated());

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')
            ->with('success', 'Team deleted!');
    }
}
