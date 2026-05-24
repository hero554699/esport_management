<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Game;
use App\Models\Team;
use App\Models\Player;

class DashboardController extends Controller
{
    public function index()
    {
        // Only show pending events that are USER-submitted (not from PandaScore)
        $pendingEvents = Event::where('approval_status', 'pending')
            ->whereNull('pandascore_id')  // Only user-submitted events
            ->with('user', 'game')
            ->orderBy('created_at', 'desc')
            ->get();

        // Recently approved - user submitted only
        $recentApproved = Event::where('approval_status', 'approved')
            ->whereNull('pandascore_id')  // Only user-submitted events
            ->with('user', 'game')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Recently rejected - user submitted only
        $recentRejected = Event::where('approval_status', 'rejected')
            ->whereNull('pandascore_id')  // Only user-submitted events
            ->with('user', 'game')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'pending_approvals' => $pendingEvents->count(),
            'user_events'       => Event::whereNull('pandascore_id')->count(),  // User tournaments
            'user_teams'        => Team::whereNull('pandascore_id')->count(),    // User teams
            'players'           => Player::count(),                               // All players
            'pandascore_events' => Event::whereNotNull('pandascore_id')->count(), // PandaScore tournaments
            'pandascore_teams'  => Team::whereNotNull('pandascore_id')->count(),  // PandaScore teams
        ];

        return view('admin.dashboard', compact('pendingEvents', 'recentApproved', 'recentRejected', 'stats'));
    }
}
