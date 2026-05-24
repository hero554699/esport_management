<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Team;
use App\Models\Player;
use App\Models\Matches;
use App\Models\Organization;
use App\Models\Game;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $stats = [
                'games' => Game::count(),
                'organizations' => Organization::count(),
                'user_events' => Event::whereNull('pandascore_id')->count(),
                'user_teams' => Team::whereNull('pandascore_id')->count(),
                'players' => Player::count(),
                'matches' => Matches::count(),
                'pending_approvals' => Event::where('approval_status', 'pending')
                    ->whereNotNull('user_id')
                    ->count(),
            ];

            // Pending tournaments waiting for approval
            $pendingEvents = Event::where('approval_status', 'pending')
                ->whereNotNull('user_id')
                ->with('game', 'user')
                ->orderBy('created_at', 'desc')
                ->get();

            // Recent approved tournaments
            $recentApproved = Event::where('approval_status', 'approved')
                ->whereNotNull('user_id')
                ->with('game', 'user')
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();

            // Recent rejected tournaments
            $recentRejected = Event::where('approval_status', 'rejected')
                ->whereNotNull('user_id')
                ->with('game', 'user')
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();

            return view('admin.dashboard', compact('stats', 'pendingEvents', 'recentApproved', 'recentRejected'));
        } catch (\Exception $e) {
            Log::error('Error loading admin dashboard: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load dashboard.');
        }
    }
}
