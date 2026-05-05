<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Game;

class MatchesPublicController extends Controller
{
    public function index()
    {
        $status = request('status');
        $gameId = request('game');
        $search = request('search');

        $matches = Matches::with('teamA', 'teamB', 'event.game', 'result')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($gameId, fn($q) => $q->whereHas('event', fn($q) => $q->where('game_id', $gameId)))
            ->when($search, fn($q) => $q->whereHas('teamA', fn($q) => $q->where('name', 'like', "%{$search}%"))
                                        ->orWhereHas('teamB', fn($q) => $q->where('name', 'like', "%{$search}%")))
            ->orderBy('scheduled_at', 'desc')
            ->paginate(20);

        $games = Game::orderBy('name')->get();

        return view('public.matches.index', compact('matches', 'status', 'gameId', 'games', 'search'));
    }
}