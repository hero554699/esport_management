<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Game;
use App\Models\Organization;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('game', 'organization')->orderBy('name')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $games = Game::all();
        $organizations = Organization::all();
        return view('admin.teams.create', compact('games', 'organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'tag'             => 'required|string|max:10',
            'game_id'         => 'required|exists:games,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'country'         => 'nullable|string|max:60',
            'logo_url'        => 'nullable|url',
        ]);

        Team::create($request->only([
            'name',
            'tag',
            'game_id',
            'organization_id',
            'country',
            'logo_url'
        ]));

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team created successfully!');
    }

    public function edit(Team $team)
    {
        $games = Game::all();
        $organizations = Organization::all();
        return view('admin.teams.edit', compact('team', 'games', 'organizations'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'tag'             => 'required|string|max:10',
            'game_id'         => 'required|exists:games,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'country'         => 'nullable|string|max:60',
            'logo_url'        => 'nullable|url',
        ]);

        $team->update($request->only([
            'name',
            'tag',
            'game_id',
            'organization_id',
            'country',
            'logo_url'
        ]));

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
