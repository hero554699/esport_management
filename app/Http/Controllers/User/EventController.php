<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreEventRequest;
use App\Http\Requests\User\UpdateEventRequest;
use App\Models\Event;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->with(['game'])
            ->withCount('matches')
            ->latest()
            ->get();

        return view('user.events.index', compact('events'));
    }

    public function create()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();

        return view('user.events.create', compact('games'));
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'upcoming';
        $validated['approval_status'] = 'pending';
        $validated['is_certification_public'] = $request->boolean('is_certification_public', false);

        // Handle certification file upload
        if ($request->hasFile('certification')) {
            $file = $request->file('certification');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tournaments/certifications', $filename, 'public');
            $validated['certification_path'] = $path;
        }

        Event::create($validated);

        return redirect()->route('user.events.index')
            ->with('success', 'Tournament created! Waiting for admin approval.');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $event->load(['matches.teamA', 'matches.teamB', 'matches.result', 'game']);

        return view('user.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $games = Game::where('is_active', true)->orderBy('name')->get();

        return view('user.events.edit', compact('event', 'games'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validated();
        $validated['is_certification_public'] = $request->boolean('is_certification_public', false);

        // Handle certification file upload
        if ($request->hasFile('certification')) {
            // Delete old certification if exists
            if ($event->certification_path && Storage::disk('public')->exists($event->certification_path)) {
                Storage::disk('public')->delete($event->certification_path);
            }

            $file = $request->file('certification');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tournaments/certifications', $filename, 'public');
            $validated['certification_path'] = $path;
        }

        $event->update($validated);

        return redirect()->route('user.events.index')
            ->with('success', 'Tournament updated successfully!');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        // Delete certification if exists
        if ($event->certification_path && Storage::disk('public')->exists($event->certification_path)) {
            Storage::disk('public')->delete($event->certification_path);
        }

        $event->delete();

        return redirect()->route('user.events.index')
            ->with('success', 'Tournament deleted.');
    }
}
