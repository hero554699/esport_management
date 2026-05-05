<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $myEvents = Event::where('user_id', $user->id)
            ->withCount('matches')
            ->latest()
            ->get();

        $myTeams = Team::where('user_id', $user->id)
            ->withCount('players')
            ->latest()
            ->get();

        $stats = [
            'tournaments' => $myEvents->count(),
            'teams'       => $myTeams->count(),
            'players'     => Player::whereHas('team', fn($q) => $q->where('user_id', $user->id))->count(),
            'matches'     => $myEvents->sum('matches_count'),
        ];

        return view('user.dashboard', compact('user', 'myEvents', 'myTeams', 'stats'));
    }
}