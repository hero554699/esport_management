<?php

namespace App\Http\Controllers;

use App\Models\Game;

class GamesController extends Controller
{
    public function index()
    {
        $platform = request('platform');

        $games = Game::withCount('teams', 'events')
            ->when($platform, fn($q) => $q->where('platform', $platform))
            ->orderBy('name')
            ->get();

        return view('public.games.index', compact('games', 'platform'));
    }
}
