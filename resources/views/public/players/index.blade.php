@extends('layouts.public')
@section('title', 'Players — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Players</h1>
        <p class="text-gray-400 text-sm mt-1">Browse all esports players</p>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3 mb-8">
        {{-- Search --}}
        <form method="GET" action="{{ route('players.index') }}" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Search players..."
                class="flex-1 bg-gray-900 border border-gray-700 text-white text-sm rounded-lg px-4 py-2
                    focus:outline-none focus:border-orange-500 placeholder-gray-600 transition">
            @if(request('team'))
            <input type="hidden" name="team" value="{{ request('team') }}">
            @endif
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
                Search
            </button>
            @if(request('search') || request('team'))
            <a href="{{ route('players.index') }}"
                class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm px-4 py-2 rounded-lg transition">
                Clear
            </a>
            @endif
        </form>

        {{-- Team filter --}}
        <select onchange="window.location='{{ route('players.index') }}?team='+this.value+'{{ request('search') ? '&search='.request('search') : '' }}'"
            class="bg-gray-900 border border-gray-700 text-gray-400 text-sm rounded-lg px-3 py-2
                focus:outline-none focus:border-orange-500">
            <option value="">All Teams</option>
            @foreach($teams as $team)
            <option value="{{ $team->id }}" {{ $teamId == $team->id ? 'selected' : '' }}>
                {{ $team->name }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- Results count --}}
    <p class="text-gray-500 text-sm mb-4">
        Showing {{ $players->firstItem() }}–{{ $players->lastItem() }} of {{ $players->total() }} players
    </p>

    @if($players->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($players as $player)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
            <div class="flex items-center gap-3 mb-3">
                @if($player->avatar_url)
                <img src="{{ $player->avatar_url }}" alt=""
                    class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                @else
                <div class="w-10 h-10 bg-orange-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-orange-500 font-bold text-sm">
                        {{ strtoupper(substr($player->nickname ?? $player->username ?? '??', 0, 2)) }}
                    </span>
                </div>
                @endif
                <div>
                    <p class="font-semibold text-white">
                        {{ $player->nickname ?? $player->username ?? 'Unknown' }}
                    </p>
                    <p class="text-gray-500 text-xs">
                        {{ $player->real_name ?? trim(($player->first_name ?? '') . ' ' . ($player->last_name ?? '')) ?: 'Unknown' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-between pt-3 border-t border-gray-800">
                <span class="text-xs text-gray-400">
                    {{ $player->team?->name ?? 'Free Agent' }}
                </span>
                <div class="flex items-center gap-2">
                    @if($player->country)
                    <span class="text-xs text-gray-500">{{ $player->country }}</span>
                    @endif
                    @if($player->role)
                    <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">
                        {{ $player->role }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $players->appends(request()->query())->links() }}
    </div>
    @else
    <div class="text-center py-20 text-gray-500">
        <p class="text-lg mb-2">No players found</p>
        @if(request('search'))
        <p class="text-sm">Try a different search term</p>
        @endif
    </div>
    @endif
</div>
@endsection