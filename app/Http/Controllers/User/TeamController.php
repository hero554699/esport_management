<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreTeamRequest;
use App\Http\Requests\User\UpdateTeamRequest;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::where('user_id', Auth::id())
            ->with(['game'])
            ->withCount('players')
            ->latest()
            ->get();

        return view('user.teams.index', compact('teams'));
    }

    public function create()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('user.teams.create', compact('games'));
    }

    public function store(StoreTeamRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('logos', 'public');
            $validated['logo_url'] = asset('storage/' . $path);
        }

        $validated['slug']    = Str::slug($validated['name']) . '-' . time();
        $validated['user_id'] = Auth::id();

        unset($validated['logo_file']);

        Team::create($validated);

        return redirect()->route('user.teams.index')
            ->with('success', 'Team created successfully!');
    }

    public function show(Team $team)
    {
        $this->authorize('view', $team);

        $team->load(['players', 'game']);

        return view('user.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $this->authorize('update', $team);

        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('user.teams.edit', compact('team', 'games'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->authorize('update', $team);

        $team->update($request->validated());

        return redirect()->route('user.teams.index')
            ->with('success', 'Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        $team->delete();

        return redirect()->route('user.teams.index')
            ->with('success', 'Team deleted.');
    }
}
