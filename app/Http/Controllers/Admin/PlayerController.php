<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        // whereNull('pandascore_id') = only user/admin created players, not PandaScore
        $players = Player::with('team')
            ->whereNull('pandascore_id')
            ->orderBy('username')->get();
        return view('admin.players.index', compact('players'));
    }

    public function create()
    {
        // Only show user/admin created teams in dropdown, not PandaScore teams
        $teams = Team::whereNull('pandascore_id')->orderBy('name')->get();
        return view('admin.players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'   => 'required|string|max:255',
            'real_name'  => 'nullable|string|max:255',
            'team_id'    => 'required|exists:teams,id',
            'country'    => 'nullable|string|max:60',
            'role'       => 'nullable|string|max:100',
            'avatar_url' => 'nullable|url',
        ]);

        Player::create($request->only([
            'username',
            'real_name',
            'team_id',
            'country',
            'role',
            'avatar_url'
        ]));

        return redirect()->route('admin.players.index')
            ->with('success', 'Player created successfully!');
    }

    public function edit(Player $player)
    {
        // Only show user/admin created teams in dropdown, not PandaScore teams
        $teams = Team::whereNull('pandascore_id')->orderBy('name')->get();
        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        $request->validate([
            'username'   => 'required|string|max:255',
            'real_name'  => 'nullable|string|max:255',
            'team_id'    => 'required|exists:teams,id',
            'country'    => 'nullable|string|max:60',
            'role'       => 'nullable|string|max:100',
            'avatar_url' => 'nullable|url',
        ]);

        $player->update($request->only([
            'username',
            'real_name',
            'team_id',
            'country',
            'role',
            'avatar_url'
        ]));

        return redirect()->route('admin.players.index')
            ->with('success', 'Player updated successfully!');
    }

    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('admin.players.index')
            ->with('success', 'Player deleted!');
    }
}