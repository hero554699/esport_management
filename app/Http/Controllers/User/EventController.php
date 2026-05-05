<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('user.events.create', compact('games'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'game_id'    => 'required|exists:games,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'prize_pool' => 'nullable|string|max:100',
            'status'     => 'required|in:upcoming,live,completed',
        ]);

        $validated['slug']    = Str::slug($validated['name']) . '-' . time();
        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Tournament created successfully!');
    }

    public function show(Event $event)
    {
        return redirect()->route('dashboard');
    }

    public function edit(Event $event)
    {
        // Make sure user owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('user.events.edit', compact('event', 'games'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'game_id'    => 'required|exists:games,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'prize_pool' => 'nullable|string|max:100',
            'status'     => 'required|in:upcoming,live,completed',
        ]);

        $event->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Tournament updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Tournament deleted.');
    }
}