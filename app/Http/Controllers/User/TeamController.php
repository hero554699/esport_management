<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('user.teams.create', compact('games'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'game_id'  => 'nullable|exists:games,id',
            'tag'      => 'nullable|string|max:10',
            'country'  => 'nullable|string|max:60',
            'logo_url' => 'nullable|url|max:500',
        ]);

        $validated['slug']    = Str::slug($validated['name']) . '-' . time();
        $validated['user_id'] = Auth::id();

        Team::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Team created successfully!');
    }

    public function show(Team $team)
    {
        return redirect()->route('dashboard');
    }

    public function edit(Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('user.teams.edit', compact('team', 'games'));
    }

    public function update(Request $request, Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'game_id'  => 'nullable|exists:games,id',
            'tag'      => 'nullable|string|max:10',
            'country'  => 'nullable|string|max:60',
            'logo_url' => 'nullable|url|max:500',
        ]);

        $team->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $team->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Team deleted.');
    }
}