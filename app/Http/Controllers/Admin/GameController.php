<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::withCount('teams', 'events')->orderBy('name')->get();
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'platform' => 'required|in:pc,mobile,console',
            'logo_url' => 'nullable|url',
        ]);

        Game::create([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'platform' => $request->platform,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game created successfully!');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'platform' => 'required|in:pc,mobile,console',
            'logo_url' => 'nullable|url',
        ]);

        $game->update([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'platform' => $request->platform,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game updated successfully!');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')
            ->with('success', 'Game deleted!');
    }
}
