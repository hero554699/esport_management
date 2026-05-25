<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserDashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            // User's tournaments (limit to 5 for dashboard)
            $myEvents = Event::where('user_id', $user->id)
                ->withCount('matches')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Total tournaments count
            $totalEvents = Event::where('user_id', $user->id)->count();

            // User's teams (limit to 5 for dashboard)
            $myTeams = Team::where('user_id', $user->id)
                ->withCount('players')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Total teams count
            $totalTeams = Team::where('user_id', $user->id)->count();

            // Count statistics - Load ALL events with matches count for stats
            $allEvents = Event::where('user_id', $user->id)
                ->withCount('matches')
                ->get();

            $stats = [
                'tournaments' => $allEvents->count(),
                'pending' => $allEvents->where('approval_status', 'pending')->count(),
                'approved' => $allEvents->where('approval_status', 'approved')->count(),
                'rejected' => $allEvents->where('approval_status', 'rejected')->count(),
                'teams' => Team::where('user_id', $user->id)->count(),
                'players' => Player::whereHas('team', fn($q) => $q->where('user_id', $user->id))->count(),
                'matches' => $allEvents->sum('matches_count'),
            ];

            // Recent notifications
            $recentRejections = $allEvents->where('approval_status', 'rejected');

            return view('user.dashboard', compact(
                'user',
                'myEvents',
                'myTeams',
                'stats',
                'recentRejections',
                'totalEvents',
                'totalTeams'
            ));
        } catch (\Exception $e) {
            Log::error('Error loading user dashboard: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load dashboard.');
        }
    }
}
