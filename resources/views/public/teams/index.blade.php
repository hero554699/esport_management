@extends('layouts.public')
@section('title', 'Teams — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Teams</h1>
        <p class="text-gray-400 text-sm mt-1">Browse all esports teams</p>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('teams.index') }}"
            class="px-4 py-2 rounded-lg text-sm transition
                {{ !$platform ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            All Platforms
        </a>
        <a href="{{ route('teams.index') }}?platform=pc"
            class="px-4 py-2 rounded-lg text-sm transition
                {{ $platform === 'pc' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            PC
        </a>
        <a href="{{ route('teams.index') }}?platform=mobile"
            class="px-4 py-2 rounded-lg text-sm transition
                {{ $platform === 'mobile' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            Mobile
        </a>

        {{-- Search --}}
        <form method="GET" action="{{ route('teams.index') }}" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search teams..."
                class="flex-1 bg-gray-900 border border-gray-700 text-white text-sm rounded-lg px-4 py-2
                       focus:outline-none focus:border-orange-500 placeholder-gray-600 transition">
            @if($platform)
                <input type="hidden" name="platform" value="{{ $platform }}">
            @endif
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('teams.index') }}"
                   class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm px-4 py-2 rounded-lg transition">
                    Clear
                </a>
            @endif
        </form>

        <select onchange="window.location='{{ route('teams.index') }}?game='+this.value+'{{ $platform ? '&platform='.$platform : '' }}'"
            class="bg-gray-900 border border-gray-700 text-gray-400 text-sm rounded-lg px-3 py-2
                   focus:outline-none focus:border-orange-500">
            <option value="">All Games</option>
            @foreach($games as $game)
                <option value="{{ $game->id }}" {{ $gameId == $game->id ? 'selected' : '' }}>
                    {{ $game->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Results count --}}
    <p class="text-gray-500 text-sm mb-4">
        Showing {{ $teams->firstItem() }}–{{ $teams->lastItem() }} of {{ $teams->total() }} teams
    </p>

    @if($teams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($teams as $team)
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            @if($team->logo_url)
                                <img src="{{ $team->logo_url }}" alt=""
                                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-orange-500/20 border border-orange-500/30
                                            flex items-center justify-center font-bold text-orange-500 text-sm flex-shrink-0">
                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-white">{{ $team->name }}</h3>
                                <p class="text-gray-500 text-xs mt-0.5">
                                    {{ $team->organization?->name ?? 'Independent' }}
                                </p>
                            </div>
                        </div>
                        @if($team->tag)
                            <span class="bg-gray-800 text-gray-300 px-2 py-1 rounded text-xs font-mono flex-shrink-0">
                                {{ $team->tag }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-800">
                        <span class="text-xs text-gray-500">
                            {{ $team->location ?? $team->country ?? 'Unknown' }}
                        </span>
                        <span class="text-xs text-orange-500">
                            {{ $team->players_count }} players
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $teams->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-20 text-gray-500">
            <p class="text-lg mb-2">No teams found</p>
            <p class="text-sm">Try changing the filters</p>
        </div>
    @endif
</div>
@endsection