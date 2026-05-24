<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePlayerRequest;
use App\Http\Requests\User\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\Team;

class PlayerController extends Controller
{
    public function index(Team $team)
    {
        $this->authorize('view', $team);

        $players = $team->players()->latest()->get();

        return view('user.players.index', compact('team', 'players'));
    }

    public function create(Team $team)
    {
        $this->authorize('create', [Player::class, $team]);

        return view('user.players.create', compact('team'));
    }

    public function store(StorePlayerRequest $request, Team $team)
    {
        $this->authorize('create', [Player::class, $team]);

        $validated = $request->validated();
        $validated['team_id'] = $team->id;

        Player::create($validated);

        return redirect()->route('user.teams.players.index', $team)
            ->with('success', 'Player added successfully!');
    }

    public function show(Team $team, Player $player)
    {
        $this->authorize('view', $team);
        $this->authorize('view', $player);
        abort_if($player->team_id !== $team->id, 404);

        return view('user.players.show', compact('team', 'player'));
    }

    public function edit(Team $team, Player $player)
    {
        $this->authorize('update', $player);
        abort_if($player->team_id !== $team->id, 404);

        return view('user.players.edit', compact('team', 'player'));
    }

    public function update(UpdatePlayerRequest $request, Team $team, Player $player)
    {
        $this->authorize('update', $player);
        abort_if($player->team_id !== $team->id, 404);

        $player->update($request->validated());

        return redirect()->route('user.teams.players.index', $team)
            ->with('success', 'Player updated successfully!');
    }

    public function destroy(Team $team, Player $player)
    {
        $this->authorize('delete', $player);
        abort_if($player->team_id !== $team->id, 404);

        $player->delete();

        return redirect()->route('user.teams.players.index', $team)
            ->with('success', 'Player removed.');
    }
}
