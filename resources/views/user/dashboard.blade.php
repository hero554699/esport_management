@extends('layouts.public')
@section('title', 'My Dashboard')

@section('content')
<div class="min-h-screen bg-gray-900">

    {{-- Header --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="text-2xl font-medium text-white">Welcome, {{ $user->name }}</h1>
            <p class="text-gray-400 mt-1 text-sm">Manage your tournaments, teams, and players</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col gap-10">

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
                <p class="text-gray-400 text-xs mb-2">Tournaments</p>
                <p class="text-2xl font-medium text-orange-500">{{ $stats['tournaments'] }}</p>
                <p class="text-xs text-gray-600 mt-1">{{ $stats['pending'] }} pending</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
                <p class="text-gray-400 text-xs mb-2">Teams</p>
                <p class="text-2xl font-medium text-orange-500">{{ $stats['teams'] }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
                <p class="text-gray-400 text-xs mb-2">Players</p>
                <p class="text-2xl font-medium text-orange-500">{{ $stats['players'] }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
                <p class="text-gray-400 text-xs mb-2">Matches</p>
                <p class="text-2xl font-medium text-orange-500">{{ $stats['matches'] }}</p>
            </div>
        </div>

        {{-- Rejection Alert --}}
        @if($recentRejections->count() > 0)
        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <span class="text-red-500 mt-0.5">⚠️</span>
                <div>
                    <p class="text-red-400 font-medium text-sm">Tournament(s) Rejected</p>
                    @foreach($recentRejections as $event)
                    <p class="text-red-300 text-sm mt-1">
                        <strong>{{ $event->name }}</strong>: {{ $event->rejection_reason ?? 'No reason provided' }}
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Tournaments Section --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-white">My Tournaments</h2>
                <a href="{{ route('user.events.create') }}"
                    class="relative overflow-hidden bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition btn-shine">
                    + Create Tournament
                </a>
            </div>

            @forelse($myEvents as $event)
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 mb-3 hover:border-orange-500/40 transition">

                {{-- Title row --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-base font-medium text-white">{{ ucwords($event->name) }}</h3>

                        @if($event->approval_status === 'pending')
                        <span class="bg-yellow-500/15 text-yellow-500 text-xs px-2.5 py-0.5 rounded-full font-medium">Pending</span>
                        @elseif($event->approval_status === 'approved')
                        <span class="bg-green-500/15 text-green-400 text-xs px-2.5 py-0.5 rounded-full font-medium">Approved</span>
                        @else
                        <span class="bg-red-500/15 text-red-400 text-xs px-2.5 py-0.5 rounded-full font-medium">Rejected</span>
                        @endif

                        @if($event->status === 'live')
                        <span class="bg-red-500/15 text-red-400 text-xs px-2.5 py-0.5 rounded-full font-medium flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Live
                        </span>
                        @elseif($event->status === 'upcoming')
                        <span class="bg-blue-500/15 text-blue-400 text-xs px-2.5 py-0.5 rounded-full font-medium">Upcoming</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                        @if($event->approval_status === 'approved')
                        <a href="{{ route('user.events.show', $event) }}"
                            class="text-orange-500 hover:text-orange-400 text-sm font-medium transition whitespace-nowrap">
                            Manage →
                        </a>
                        @endif
                        <a href="{{ route('user.events.edit', $event) }}"
                            class="text-blue-400 hover:text-blue-300 text-sm transition">Edit</a>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-700 mb-4"></div>

                {{-- Meta info --}}
                <div class="grid grid-cols-3 divide-x divide-gray-700">
                    <div class="pr-6">
                        <p class="text-gray-500 text-xs mb-1">Game</p>
                        <p class="text-white text-sm font-medium">{{ $event->game?->name ?? 'N/A' }}</p>
                    </div>
                    <div class="px-6">
                        <p class="text-gray-500 text-xs mb-1">Matches</p>
                        <p class="text-white text-sm font-medium">{{ $event->matches_count ?? 0 }}</p>
                    </div>
                    <div class="pl-6">
                        <p class="text-gray-500 text-xs mb-1">Prize Pool</p>
                        <p class="text-orange-500 text-sm font-medium">{{ $event->prize_pool ?? 'N/A' }}</p>
                    </div>
                </div>

            </div>
            @empty
            <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
                <p class="text-gray-400 text-sm mb-4">No tournaments yet. Create your first one!</p>
                <a href="{{ route('user.events.create') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition inline-block">
                    + Create Tournament
                </a>
            </div>
            @endforelse
        </div>

        {{-- Teams Section --}}
        <div class="border-t border-gray-800 pt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-white">My Teams</h2>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.teams.index') }}"
                        class="border border-gray-700 hover:border-orange-500 text-gray-300 hover:text-orange-500 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                        Manage Teams
                    </a>
                    <a href="{{ route('user.teams.create') }}"
                        class="relative overflow-hidden bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition btn-shine">
                        + Create Team
                    </a>
                </div>
            </div>

            @forelse($myTeams as $team)
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-4 mb-3 flex items-center gap-4 hover:border-orange-500/40 transition cursor-pointer group"
                onclick="window.location.href='{{ route('user.teams.show', $team) }}'">
                @if($team->logo_url)
                <img src="{{ $team->logo_url }}" alt="{{ $team->name }}"
                    class="w-11 h-11 rounded-lg object-cover flex-shrink-0">
                @else
                <div class="w-11 h-11 rounded-lg bg-orange-500/15 border border-orange-500/30 flex items-center justify-center flex-shrink-0">
                    <span class="text-orange-500 font-medium text-sm">{{ strtoupper(substr($team->name, 0, 2)) }}</span>
                </div>
                @endif
                <div>
                    <h3 class="text-base font-medium text-white group-hover:text-orange-400 transition">{{ $team->name }}</h3>
                    <p class="text-gray-400 text-xs mt-0.5">{{ $team->players->count() }} {{ Str::plural('player', $team->players->count()) }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
                <p class="text-gray-400 text-sm mb-4">No teams yet. Create your first one!</p>
                <a href="{{ route('user.teams.create') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition inline-block">
                    + Create Team
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>

<style>
    .btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.18), transparent);
        transform: skewX(-20deg);
        transition: left 0.5s ease;
    }

    .btn-shine:hover::after {
        left: 150%;
    }
</style>
@endsection