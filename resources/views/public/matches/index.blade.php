@extends('layouts.public')
@section('title', 'Matches — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-2xl font-bold">Matches</h1>
        <p class="text-gray-400 text-sm mt-1">Browse all esports matches</p>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('matches.index') }}" class="flex gap-2 mb-6">
        <input type="text" name="search" value="{{ $search ?? '' }}"
            placeholder="Search by team name..."
            class="flex-1 bg-gray-900 border border-gray-700 text-white text-sm rounded-lg px-4 py-2
                   focus:outline-none focus:border-orange-500 placeholder-gray-600 transition">
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
        @if(request('game'))   <input type="hidden" name="game"   value="{{ request('game') }}">   @endif
        <button type="submit"
            class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('matches.index', array_filter(['status' => request('status'), 'game' => request('game')])) }}"
               class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm px-4 py-2 rounded-lg transition">
                Clear
            </a>
        @endif
    </form>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3 mb-8">

        {{-- Status filters --}}
        <a href="{{ route('matches.index', array_filter(['game' => $gameId, 'search' => $search])) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition
                {{ !$status ? 'bg-orange-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
            All
        </a>
        <a href="{{ route('matches.index', array_filter(['status' => 'live', 'game' => $gameId, 'search' => $search])) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition flex items-center gap-1.5
                {{ $status === 'live' ? 'bg-orange-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
            Live
        </a>
        <a href="{{ route('matches.index', array_filter(['status' => 'upcoming', 'game' => $gameId, 'search' => $search])) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition
                {{ $status === 'upcoming' ? 'bg-orange-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
            Upcoming
        </a>
        <a href="{{ route('matches.index', array_filter(['status' => 'completed', 'game' => $gameId, 'search' => $search])) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition
                {{ $status === 'completed' ? 'bg-orange-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
            Completed
        </a>

        {{-- Game filter --}}
        <select onchange="window.location='{{ route('matches.index') }}?game='+this.value+'{{ $status ? '&status='.$status : '' }}{{ $search ? '&search='.$search : '' }}'"
            class="bg-gray-900 border border-gray-700 text-gray-400 text-sm rounded-lg px-3 py-2
                   focus:outline-none focus:border-orange-500 ml-auto">
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
        Showing {{ $matches->firstItem() ?? 0 }}–{{ $matches->lastItem() ?? 0 }} of {{ $matches->total() }} matches
    </p>

    {{-- Match list --}}
    <div class="flex flex-col gap-3">
        @forelse($matches as $match)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
                <div class="flex items-center justify-between gap-4">

                    {{-- Status + Event --}}
                    <div class="flex flex-col gap-1 min-w-[160px]">
                        @if($match->status === 'live')
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                LIVE
                            </span>
                        @elseif($match->status === 'upcoming')
                            <span class="text-xs font-semibold text-blue-400">UPCOMING</span>
                        @else
                            <span class="text-xs font-semibold text-gray-500">COMPLETED</span>
                        @endif
                        <span class="text-xs text-gray-500 truncate">
                            {{ $match->event?->name ?? 'Unknown Event' }}
                        </span>
                        @if($match->scheduled_at)
                            <span class="text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($match->scheduled_at)->format('M d, Y · H:i') }}
                            </span>
                        @endif
                    </div>

                    {{-- Teams + Score --}}
                    <div class="flex items-center gap-4 flex-1 justify-center">

                        {{-- Team A --}}
                        <div class="flex items-center gap-2 justify-end flex-1">
                            <span class="font-semibold text-white text-sm text-right">
                                {{ $match->teamA?->name ?? 'TBD' }}
                            </span>
                            @if($match->teamA?->logo_url)
                                <img src="{{ $match->teamA->logo_url }}"
                                     class="w-8 h-8 rounded object-cover flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded bg-gray-800 border border-gray-700
                                            flex items-center justify-center text-xs font-bold text-orange-500 flex-shrink-0">
                                    {{ strtoupper(substr($match->teamA?->name ?? 'A', 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Score / VS --}}
                        <div class="flex items-center gap-1 text-center min-w-[60px] justify-center">
                            @if($match->status === 'completed' && $match->result)
                                <span class="text-lg font-bold
                                    {{ $match->result->winner_team_id === $match->team_a_id ? 'text-orange-500' : 'text-white' }}">
                                    {{ $match->result->score_a ?? 0 }}
                                </span>
                                <span class="text-gray-600 text-sm">:</span>
                                <span class="text-lg font-bold
                                    {{ $match->result->winner_team_id === $match->team_b_id ? 'text-orange-500' : 'text-white' }}">
                                    {{ $match->result->score_b ?? 0 }}
                                </span>
                            @else
                                <span class="text-xs font-bold text-gray-500 border border-gray-700
                                             rounded px-2 py-0.5">VS</span>
                            @endif
                        </div>

                        {{-- Team B --}}
                        <div class="flex items-center gap-2 flex-1">
                            @if($match->teamB?->logo_url)
                                <img src="{{ $match->teamB->logo_url }}"
                                     class="w-8 h-8 rounded object-cover flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded bg-gray-800 border border-gray-700
                                            flex items-center justify-center text-xs font-bold text-orange-500 flex-shrink-0">
                                    {{ strtoupper(substr($match->teamB?->name ?? 'B', 0, 2)) }}
                                </div>
                            @endif
                            <span class="font-semibold text-white text-sm">
                                {{ $match->teamB?->name ?? 'TBD' }}
                            </span>
                        </div>
                    </div>

                    {{-- Game --}}
                    <div class="text-right min-w-[100px]">
                        @if($match->event?->game)
                            <span class="text-xs text-gray-500">{{ $match->event->game->name }}</span>
                        @endif
                        @if($match->stage)
                            <div class="text-xs text-gray-600 mt-0.5">{{ $match->stage }}</div>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="text-center py-20 text-gray-500">
                <p class="text-lg mb-2">No matches found</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($matches->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $matches->appends(request()->query())->links() }}
        </div>
    @endif

</div>
@endsection