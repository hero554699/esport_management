@extends('layouts.public')
@section('title', 'My Dashboard')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-white">Welcome, {{ $user->name }}</h1>
            <p class="text-gray-400 mt-2">Manage your tournaments, teams, and players</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Tournaments</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['tournaments'] }}</p>
                <p class="text-xs text-gray-600 mt-1">{{ $stats['pending'] }} pending</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Teams</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['teams'] }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Players</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['players'] }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Matches</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['matches'] }}</p>
            </div>
        </div>
    </div>

    <!-- Actions & Notifications -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-4 flex-wrap mb-8">
            <a href="{{ route('user.events.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition">
                + Create Tournament
            </a>
            <a href="{{ route('user.teams.index') }}" class="border border-gray-700 hover:border-orange-500 text-white px-6 py-3 rounded-xl transition">
                Manage Teams
            </a>
        </div>

        <!-- Rejections Alert -->
        @if($recentRejections->count() > 0)
        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-8">
            <div class="flex items-start gap-3">
                <span class="text-red-500 text-xl">⚠️</span>
                <div>
                    <p class="text-red-400 font-semibold">Tournament(s) Rejected</p>
                    @foreach($recentRejections as $event)
                    <p class="text-red-300 text-sm mt-1">
                        <strong>{{ $event->name }}</strong>: {{ $event->rejection_reason ?? 'No reason provided' }}
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Tournaments -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-white mb-6">My Tournaments</h2>

        @forelse($myEvents as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 mb-4 hover:border-orange-500/50 transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-xl font-bold text-white">{{ $event->name }}</h3>

                        <!-- Status Badges -->
                        @if($event->approval_status === 'pending')
                        <span class="bg-yellow-500/20 text-yellow-400 text-xs px-3 py-1 rounded-full">PENDING</span>
                        @elseif($event->approval_status === 'approved')
                        <span class="bg-green-500/20 text-green-400 text-xs px-3 py-1 rounded-full">APPROVED</span>
                        @else
                        <span class="bg-red-500/20 text-red-400 text-xs px-3 py-1 rounded-full">REJECTED</span>
                        @endif

                        @if($event->status === 'live')
                        <span class="bg-red-500/20 text-red-400 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                            LIVE
                        </span>
                        @elseif($event->status === 'upcoming')
                        <span class="bg-blue-500/20 text-blue-400 text-xs px-3 py-1 rounded-full">UPCOMING</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mt-3">
                        <div>
                            <p class="text-gray-400">Game</p>
                            <p class="text-white font-semibold">{{ $event->game?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Start Date</p>
                            <p class="text-white font-semibold">{{ $event->start_date?->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Matches</p>
                            <p class="text-white font-semibold">{{ $event->matches_count }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Prize Pool</p>
                            <p class="text-orange-500 font-semibold">{{ $event->prize_pool ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 ml-4">
                    @if($event->approval_status === 'approved')
                    <a href="{{ route('user.events.show', $event) }}" class="text-orange-500 hover:text-orange-400 text-sm font-semibold transition">
                        Manage →
                    </a>
                    @endif
                    <a href="{{ route('user.events.edit', $event) }}" class="text-blue-400 hover:text-blue-300 text-sm transition">
                        Edit
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
            <p class="text-gray-400 mb-4">No tournaments yet. Create your first one!</p>
            <a href="{{ route('user.events.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg transition inline-block">
                Create Tournament
            </a>
        </div>
        @endforelse
    </div>

    <!-- Teams -->
    <div class="max-w-7xl mx-auto px-4 py-8 border-t border-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">My Teams</h2>
            <a href="{{ route('user.teams.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg transition text-sm">
                + Create Team
            </a>
        </div>

        @forelse($myTeams as $team)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 mb-4 hover:border-orange-500/50 transition">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4 flex-1">
                    @if($team->logo_url)
                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" class="w-16 h-16 rounded-lg object-cover">
                    @else
                    <div class="w-16 h-16 rounded-lg bg-orange-500/20 border border-orange-500/30 flex items-center justify-center">
                        <span class="text-orange-500 font-bold text-xl">{{ strtoupper(substr($team->name, 0, 2)) }}</span>
                    </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $team->name }}</h3>
                        <p class="text-gray-400 text-sm">{{ $team->players_count }} players</p>
                    </div>
                </div>
                <a href="{{ route('user.teams.show', $team) }}" class="text-orange-500 hover:text-orange-400 font-semibold transition">
                    Manage →
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
            <p class="text-gray-400 mb-4">No teams yet.</p>
            <a href="{{ route('user.teams.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg transition inline-block">
                Create Team
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection