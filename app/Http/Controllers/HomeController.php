<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Game;
use App\Models\Matches;
use App\Models\Player;
use App\Models\Organization;

class HomeController extends Controller
{
    public function index()
    {
        // Only approved events show on public side
        $liveEvents = Event::where('status', 'live')
            ->where('approval_status', 'approved')
            ->with('game')
            ->take(4)
            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
            ->where('approval_status', 'approved')
            ->with('game')
            ->orderBy('start_date')
            ->take(4)
            ->get();

        // Popular games — ordered by most events
        $games = Game::withCount(['events', 'teams'])
            ->having('events_count', '>', 0)
            ->orderByDesc('events_count')
            ->take(12)
            ->get();

        // Famous teams — ordered by most players
        $famousTeams = Team::withCount('players')
            ->having('players_count', '>', 0)
            ->orderByDesc('players_count')
            ->take(6)
            ->get();

        $liveMatches = Matches::where('status', 'live')
            ->with('teamA', 'teamB', 'event.game')
            ->take(4)
            ->get();

        $recentMatches = Matches::where('status', 'completed')
            ->with('teamA', 'teamB', 'event.game', 'result')
            ->orderByDesc('scheduled_at')
            ->take(5)
            ->get();

        $totalTeams   = Team::count();
        $totalEvents  = Event::where('approval_status', 'approved')->count();
        $totalPlayers = Player::count();
        $totalOrgs    = Organization::count();

        return view('home', compact(
            'liveEvents',
            'upcomingEvents',
            'games',
            'famousTeams',
            'liveMatches',
            'recentMatches',
            'totalTeams',
            'totalEvents',
            'totalPlayers',
            'totalOrgs'
        ));
    }
}
