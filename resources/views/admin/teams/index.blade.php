@extends('layouts.admin')
@section('title', 'Teams & Players')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-lg font-semibold">Teams & Players</h2>
        <p class="text-xs text-gray-500 mt-0.5">User-created teams only — click a team to manage its players</p>
    </div>
    <a href="{{ route('admin.teams.create') }}"
        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Team
    </a>
</div>

@if($teams->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @foreach($teams as $team)
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/40 transition">
        <div class="flex items-center gap-3 mb-4">
            @if($team->logo_url)
            <img src="{{ $team->logo_url }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
            @else
            <div class="w-12 h-12 rounded-xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center font-bold text-orange-500 flex-shrink-0">
                {{ strtoupper(substr($team->name, 0, 2)) }}
            </div>
            @endif
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white truncate">{{ $team->name }}</p>
                <div class="flex items-center gap-2 mt-0.5">
                    @if($team->tag)
                    <span class="text-xs text-gray-600 font-mono">{{ $team->tag }}</span>
                    @endif
                    @if($team->country)
                    <span class="text-xs text-gray-500">{{ $team->country }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between text-xs text-gray-500 mb-4 py-3 border-t border-b border-gray-800">
            <span>{{ $team->game?->name ?? 'No game' }}</span>
            <span class="text-orange-500 font-medium">{{ $team->players_count }} players</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.teams.show', $team) }}"
                class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                Manage Players
            </a>
            <a href="{{ route('admin.teams.edit', $team) }}"
                class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs px-3 py-2 rounded-lg transition">
                Edit
            </a>
            <form method="POST" action="{{ route('admin.teams.destroy', $team) }}"
                onsubmit="return confirm('Delete {{ addslashes($team->name) }}?')">
                @csrf @method('DELETE')
                <button class="bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs px-3 py-2 rounded-lg transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="bg-gray-900 border border-dashed border-gray-700 rounded-xl p-12 text-center">
    <div class="w-14 h-14 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </div>
    <p class="text-gray-500 text-sm font-medium">No teams yet</p>
    <p class="text-gray-600 text-xs mt-1 mb-4">Teams created by users will appear here</p>
    <a href="{{ route('admin.teams.create') }}"
        class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
        + Add First Team
    </a>
</div>
@endif

@endsection