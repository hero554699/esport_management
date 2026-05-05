<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Game;

class TeamsController extends Controller
{
    public function index()
    {
        $gameId   = request('game');
        $platform = request('platform');
        $search   = request('search');

        $teams = Team::with('organization')
            ->withCount('players')
            ->when($gameId, fn($q) => $q->where('game_id', $gameId))
            ->when($platform, fn($q) => $q->whereHas('game', fn($q) => $q->where('platform', $platform)))
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(24);

        $games = Game::orderBy('name')->get();

        return view('public.teams.index', compact('teams', 'games', 'gameId', 'platform', 'search'));
    }
}