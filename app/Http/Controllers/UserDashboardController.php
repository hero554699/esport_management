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

            // User's tournaments
            $myEvents = Event::where('user_id', $user->id)
                ->withCount('matches')
                ->orderBy('created_at', 'desc')
                ->get();

            // User's teams
            $myTeams = Team::where('user_id', $user->id)
                ->withCount('players')
                ->orderBy('created_at', 'desc')
                ->get();

            // Count statistics
            $stats = [
                'tournaments' => $myEvents->count(),
                'pending' => $myEvents->where('approval_status', 'pending')->count(),
                'approved' => $myEvents->where('approval_status', 'approved')->count(),
                'rejected' => $myEvents->where('approval_status', 'rejected')->count(),
                'teams' => $myTeams->count(),
                'players' => Player::whereHas('team', fn($q) => $q->where('user_id', $user->id))->count(),
                'matches' => $myEvents->sum('matches_count'),
            ];

            // Recent notifications
            $recentRejections = $myEvents->where('approval_status', 'rejected');

            return view('user.dashboard', compact('user', 'myEvents', 'myTeams', 'stats', 'recentRejections'));
        } catch (\Exception $e) {
            Log::error('Error loading user dashboard: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load dashboard.');
        }
    }
}
