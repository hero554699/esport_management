@extends('layouts.public')
@section('title', 'EsportsTrack — Home')
@section('content')

{{-- HERO --}}
<section class="bg-gray-900 border-b border-gray-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5"
        style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 40px 40px;">
    </div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                <span class="text-red-400 text-sm font-medium">
                    {{ $liveMatches->count() }} matches live right now
                </span>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">
                Track Every <br><span class="text-orange-500">Esports</span> Moment.
            </h1>
            <p class="text-gray-400 text-lg mb-8 max-w-xl">
                Follow live tournaments, track your favorite teams, and never miss a
                match result across PC and mobile games.
            </p>
            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('events.index') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition">
                    View Events
                </a>
                <a href="{{ route('matches.index') }}"
                    class="border border-gray-700 hover:border-orange-500 text-white px-6 py-3 rounded-xl transition">
                    Live Matches
                </a>
            </div>
        </div>
    </div>
</section>

{{-- STATS BAR --}}
<section class="border-b border-gray-800 bg-gray-900/50">
    <div class="max-w-7xl mx-auto px-4 py-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="py-3">
                <p class="text-2xl font-bold text-orange-500">{{ $totalEvents }}</p>
                <p class="text-gray-500 text-xs mt-1">Total Events</p>
            </div>
            <div class="py-3">
                <p class="text-2xl font-bold text-orange-500">{{ $totalTeams }}</p>
                <p class="text-gray-500 text-xs mt-1">Teams</p>
            </div>
            <div class="py-3">
                <p class="text-2xl font-bold text-orange-500">{{ $totalPlayers }}</p>
                <p class="text-gray-500 text-xs mt-1">Players</p>
            </div>
            <div class="py-3">
                <p class="text-2xl font-bold text-orange-500">{{ $totalOrgs }}</p>
                <p class="text-gray-500 text-xs mt-1">Organizations</p>
            </div>
        </div>
    </div>
</section>

{{-- LIVE MATCHES --}}
@if($liveMatches->count() > 0)
<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            <h2 class="text-xl font-bold">Live Matches</h2>
        </div>
        <a href="{{ route('matches.index') }}?status=live"
           class="text-orange-500 hover:text-orange-400 text-sm transition">View all →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($liveMatches as $match)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                        LIVE
                    </span>
                    <span class="text-xs text-gray-500">{{ $match->event?->game?->name ?? '' }}</span>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 flex-1 justify-end">
                        @if($match->teamA?->logo_url)
                            <img src="{{ $match->teamA->logo_url }}"
                                 class="w-6 h-6 rounded object-cover">
                        @endif
                        <span class="font-semibold text-sm text-right">{{ $match->teamA?->name }}</span>
                    </div>
                    <span class="text-orange-500 text-xs font-bold flex-shrink-0">VS</span>
                    <div class="flex items-center gap-2 flex-1">
                        <span class="font-semibold text-sm">{{ $match->teamB?->name }}</span>
                        @if($match->teamB?->logo_url)
                            <img src="{{ $match->teamB->logo_url }}"
                                 class="w-6 h-6 rounded object-cover">
                        @endif
                    </div>
                </div>
                <p class="text-gray-500 text-xs mt-2 truncate">{{ $match->event?->name }}</p>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- LIVE EVENTS --}}
@if($liveEvents->count() > 0)
<section class="max-w-7xl mx-auto px-4 py-12 border-t border-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Live Events</h2>
        <a href="{{ route('events.index') }}?status=live"
           class="text-orange-500 hover:text-orange-400 text-sm transition">View all →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($liveEvents as $event)
            <a href="{{ route('events.show', $event) }}"
                class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition block">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                        LIVE
                    </span>
                    <span class="text-xs text-gray-500">{{ $event->game?->name }}</span>
                </div>
                <h3 class="font-semibold text-white">{{ $event->name }}</h3>
                @if($event->prize_pool)
                    <p class="text-orange-500 text-sm mt-1">{{ $event->prize_pool }}</p>
                @endif
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- UPCOMING EVENTS --}}
@if($upcomingEvents->count() > 0)
<section class="max-w-7xl mx-auto px-4 py-12 border-t border-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Upcoming Events</h2>
        <a href="{{ route('events.index') }}?status=upcoming"
           class="text-orange-500 hover:text-orange-400 text-sm transition">View all →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($upcomingEvents as $event)
            <a href="{{ route('events.show', $event) }}"
                class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition block">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">UPCOMING</span>
                    <span class="text-xs text-gray-500">{{ $event->game?->name }}</span>
                </div>
                <h3 class="font-semibold text-white">{{ $event->name }}</h3>
                <p class="text-gray-400 text-xs mt-1">
                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                </p>
                @if($event->prize_pool)
                    <p class="text-orange-500 text-sm">{{ $event->prize_pool }}</p>
                @endif
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- RECENT RESULTS --}}
@if($recentMatches->count() > 0)
<section class="max-w-7xl mx-auto px-4 py-12 border-t border-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Recent Results</h2>
        <a href="{{ route('matches.index') }}?status=completed"
           class="text-orange-500 hover:text-orange-400 text-sm transition">View all →</a>
    </div>
    <div class="flex flex-col gap-3">
        @foreach($recentMatches as $match)
            <div class="bg-gray-900 border border-gray-800 rounded-xl px-5 py-4
                        hover:border-orange-500/50 transition">
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-600 min-w-[80px]">
                        {{ $match->scheduled_at
                            ? \Carbon\Carbon::parse($match->scheduled_at)->format('M d')
                            : '' }}
                    </span>
                    <div class="flex items-center gap-3 flex-1 justify-center">
                        <div class="flex items-center gap-2 flex-1 justify-end">
                            @if($match->teamA?->logo_url)
                                <img src="{{ $match->teamA->logo_url }}"
                                     class="w-6 h-6 rounded object-cover">
                            @endif
                            <span class="font-semibold text-sm
                                {{ $match->result?->winner_team_id === $match->team_a_id ? 'text-orange-500' : 'text-white' }}">
                                {{ $match->teamA?->name }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1 min-w-[50px] justify-center">
                            @if($match->result)
                                <span class="font-bold text-sm
                                    {{ $match->result->winner_team_id === $match->team_a_id ? 'text-orange-500' : 'text-white' }}">
                                    {{ $match->result->score_a ?? 0 }}
                                </span>
                                <span class="text-gray-600 text-xs">:</span>
                                <span class="font-bold text-sm
                                    {{ $match->result->winner_team_id === $match->team_b_id ? 'text-orange-500' : 'text-white' }}">
                                    {{ $match->result->score_b ?? 0 }}
                                </span>
                            @else
                                <span class="text-gray-600 text-xs">FT</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 flex-1">
                            <span class="font-semibold text-sm
                                {{ $match->result?->winner_team_id === $match->team_b_id ? 'text-orange-500' : 'text-white' }}">
                                {{ $match->teamB?->name }}
                            </span>
                            @if($match->teamB?->logo_url)
                                <img src="{{ $match->teamB->logo_url }}"
                                     class="w-6 h-6 rounded object-cover">
                            @endif
                        </div>
                    </div>
                    <span class="text-xs text-gray-600 min-w-[80px] text-right">
                        {{ $match->event?->game?->name }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- POPULAR GAMES --}}
<section class="max-w-7xl mx-auto px-4 py-12 border-t border-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Popular Games</h2>
        <a href="{{ route('games.index') }}"
           class="text-orange-500 hover:text-orange-400 text-sm transition">View all →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($games as $game)
            <a href="{{ route('events.index') }}?game={{ $game->id }}"
                class="bg-gray-900 border border-gray-800 rounded-xl p-4
                       hover:border-orange-500/50 transition text-center group">
                @if($game->logo_url)
                    <img src="{{ $game->logo_url }}" alt="{{ $game->name }}"
                         class="w-12 h-12 rounded-lg object-cover mx-auto mb-3">
                @else
                    <div class="w-12 h-12 rounded-lg bg-orange-500/20 border border-orange-500/30
                                flex items-center justify-center mx-auto mb-3">
                        <span class="text-orange-500 font-bold text-sm">
                            {{ strtoupper(substr($game->name, 0, 2)) }}
                        </span>
                    </div>
                @endif
                <p class="font-semibold text-sm text-white group-hover:text-orange-500 transition">
                    {{ $game->name }}
                </p>
                <div class="flex items-center justify-center gap-3 mt-2">
                    @if($game->platform === 'mobile')
                        <span class="text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full">Mobile</span>
                    @elseif($game->platform === 'pc')
                        <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">PC</span>
                    @else
                        <span class="text-xs bg-purple-500/20 text-purple-400 px-2 py-0.5 rounded-full">Console</span>
                    @endif
                    <span class="text-xs text-gray-600">{{ $game->events_count }} events</span>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- FAMOUS TEAMS --}}
@if($famousTeams->count() > 0)
<section class="max-w-7xl mx-auto px-4 py-12 border-t border-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Top Teams</h2>
        <a href="{{ route('teams.index') }}"
           class="text-orange-500 hover:text-orange-400 text-sm transition">View all →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($famousTeams as $team)
            <a href="{{ route('teams.index') }}"
                class="bg-gray-900 border border-gray-800 rounded-xl p-4
                       hover:border-orange-500/50 transition text-center group">
                @if($team->logo_url)
                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}"
                         class="w-12 h-12 rounded-lg object-cover mx-auto mb-3">
                @else
                    <div class="w-12 h-12 rounded-lg bg-orange-500/20 border border-orange-500/30
                                flex items-center justify-center mx-auto mb-3">
                        <span class="text-orange-500 font-bold text-sm">
                            {{ strtoupper(substr($team->name, 0, 2)) }}
                        </span>
                    </div>
                @endif
                <p class="font-semibold text-xs text-white group-hover:text-orange-500 transition truncate">
                    {{ $team->name }}
                </p>
                <p class="text-gray-600 text-xs mt-1">{{ $team->players_count }} players</p>
            </a>
        @endforeach
    </div>
</section>
@endif

@endsection