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
            'events'        => Event::count(),
            'teams'         => Team::count(),
            'players'       => Player::count(),
            'matches'       => Matches::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
