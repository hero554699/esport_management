<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function store(Request $request, Team $team)
    {
        // Make sure user owns this team
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nickname'   => 'required|string|max:255',
            'real_name'  => 'nullable|string|max:255',
            'role'       => 'nullable|string|max:100',
            'country'    => 'nullable|string|max:60',
            'avatar_url' => 'nullable|url|max:500',
        ]);

        $validated['team_id'] = $team->id;

        Player::create($validated);

        return redirect()->route('user.teams.show', $team)
            ->with('success', 'Player added successfully!');
    }

    public function destroy(Team $team, Player $player)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        // Make sure player belongs to this team
        if ($player->team_id !== $team->id) {
            abort(403);
        }

        $player->delete();

        return redirect()->route('user.teams.show', $team)
            ->with('success', 'Player removed.');
    }
}