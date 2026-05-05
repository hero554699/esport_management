<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;

class PlayersController extends Controller
{
    public function index()
    {
        $teamId = request('team');
        $search = request('search');

        $players = Player::with('team')
            ->when($teamId, fn($q) => $q->where('team_id', $teamId))
            ->when($search, fn($q) => $q->where('nickname', 'like', "%{$search}%")
                                        ->orWhere('real_name', 'like', "%{$search}%")
                                        ->orWhere('first_name', 'like', "%{$search}%")
                                        ->orWhere('last_name', 'like', "%{$search}%"))
            ->whereNotNull('nickname')
            ->orderBy('nickname')
            ->paginate(24);

        // Only load teams that actually have players
        $teams = Team::whereHas('players')
                     ->orderBy('name')
                     ->get();

        return view('public.players.index', compact('players', 'teams', 'teamId', 'search'));
    }
}