<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Team;
use App\Models\Player;
use App\Models\Matches;
use App\Models\Organization;
use App\Models\Game;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'games'         => Game::count(),
            'organizations' => Organization::count(),
            'events'        => Event::whereNull('pandascore_id')->count(),
            'teams'         => Team::whereNull('pandascore_id')->count(),
            'players'       => Player::whereNull('pandascore_id')->count(),
            'matches'       => Matches::count(),
        ];


        $pendingEvents = Event::whereNull('pandascore_id')
            ->where('approval_status', 'pending')
            ->whereNotNull('user_id')
            ->with('game', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingEvents'));
    }
}
