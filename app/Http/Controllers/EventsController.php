<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;

class EventsController extends Controller
{
    public function index()
    {
        $status = request('status');
        $gameId = request('game');
        $type   = request('type');
        $search = request('search');

        $events = Event::with('game')
            ->where('approval_status', 'approved') 
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($gameId, fn($q) => $q->where('game_id', $gameId))
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('start_date', 'desc')
            ->paginate(18);

        $games = Game::orderBy('name')->get();

        return view('public.events.index', compact('events', 'games', 'status', 'gameId', 'type', 'search'));
    }

    public function show(Event $event)
    {
        $event->load('game', 'matches.teamA', 'matches.teamB', 'matches.result');
        return view('public.events.show', compact('event'));
    }
}