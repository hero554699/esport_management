@extends('layouts.public')
@section('title', 'Dashboard — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Welcome --}}
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold">
                Welcome back, <span class="text-orange-500">{{ $user->name }}</span>!
            </h1>
            <p class="text-gray-400 text-sm mt-1">
                Manage your tournaments, teams and players from here.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs bg-gray-800 border border-gray-700 text-gray-400 px-3 py-1.5 rounded-lg">
                {{ $user->username ?? $user->name }}
            </span>
            <span class="text-xs bg-orange-500/10 border border-orange-500/30 text-orange-500 px-3 py-1.5 rounded-lg">
                {{ ucfirst($user->role) }}
            </span>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
            <p class="text-3xl font-bold text-orange-500">{{ $stats['tournaments'] }}</p>
            <p class="text-gray-500 text-xs mt-1 uppercase tracking-wide">My Tournaments</p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
            <p class="text-3xl font-bold text-orange-500">{{ $stats['teams'] }}</p>
            <p class="text-gray-500 text-xs mt-1 uppercase tracking-wide">My Teams</p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
            <p class="text-3xl font-bold text-orange-500">{{ $stats['players'] }}</p>
            <p class="text-gray-500 text-xs mt-1 uppercase tracking-wide">My Players</p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
            <p class="text-3xl font-bold text-orange-500">{{ $stats['matches'] }}</p>
            <p class="text-gray-500 text-xs mt-1 uppercase tracking-wide">My Matches</p>
        </div>
    </div>

    {{-- My Tournaments --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold">My Tournaments</h2>
                <p class="text-gray-600 text-xs mt-0.5">Tournaments you have created</p>
            </div>
            <a href="{{ route('user.events.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Tournament
            </a>
        </div>

        @if($myEvents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($myEvents as $event)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-white text-sm leading-tight flex-1 pr-2">
                        {{ $event->name }}
                    </h3>
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-xs px-2 py-0.5 rounded-full flex-shrink-0
        {{ $event->status === 'live' ? 'bg-red-500/20 text-red-400' :
           ($event->status === 'upcoming' ? 'bg-blue-500/20 text-blue-400' : 'bg-gray-700 text-gray-400') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        {{-- Approval status --}}
                        @if($event->approval_status === 'pending')
                        <span class="text-xs px-2 py-0.5 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/30">
                            ⏳ Pending Approval
                        </span>
                        @elseif($event->approval_status === 'approved')
                        <span class="text-xs px-2 py-0.5 rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                            ✓ Approved
                        </span>
                        @elseif($event->approval_status === 'rejected')
                        <span class="text-xs px-2 py-0.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                            ✕ Rejected
                        </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-1 mb-4">
                    <p class="text-gray-500 text-xs flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m-6-2v2M5 9h14M5 19h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        {{ $event->game?->name ?? 'No game' }}
                    </p>
                    @if($event->start_date)
                    <p class="text-gray-600 text-xs flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}
                        @if($event->end_date)
                        — {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                        @endif
                    </p>
                    @endif
                    @if($event->prize_pool)
                    <p class="text-orange-500 text-xs font-medium">{{ $event->prize_pool }}</p>
                    @endif
                    @if($event->approval_status === 'rejected' && $event->rejection_reason)
                    <div class="mt-2 bg-red-500/10 border border-red-500/20 rounded-lg px-3 py-2">
                        <p class="text-xs text-red-400">
                            <span class="font-semibold">Rejection reason:</span>
                            {{ $event->rejection_reason }}
                        </p>
                    </div>
                    @endif
                    @if($event->type)
                    <span class="inline-block text-xs bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded-full border border-blue-500/20">
                        {{ ucfirst($event->type) }}
                    </span>
                    @endif
                </div>

                <div class="flex items-center gap-2 pt-3 border-t border-gray-800">
                    <a href="{{ route('user.events.show', $event) }}"
                        class="flex-1 text-center text-xs bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Manage
                    </a>
                    <a href="{{ route('user.events.edit', $event) }}"
                        class="text-xs bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1.5 rounded-lg transition">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('user.events.destroy', $event) }}"
                        onsubmit="return confirm('Delete {{ addslashes($event->name) }}?')"
                        class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400 px-3 py-1.5 rounded-lg transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-gray-900 border border-dashed border-gray-700 rounded-xl">
            <div class="w-14 h-14 rounded-full bg-gray-800 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="text-gray-500 text-sm mb-1 font-medium">No tournaments yet</p>
            <p class="text-gray-600 text-xs mb-4">Create your first tournament to get started</p>
            <a href="{{ route('user.events.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + Create Tournament
            </a>
        </div>
        @endif
    </div>

    {{-- My Teams --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold">My Teams</h2>
                <p class="text-gray-600 text-xs mt-0.5">Teams you manage</p>
            </div>
            <a href="{{ route('user.teams.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Team
            </a>
        </div>

        @if($myTeams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($myTeams as $team)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
                <div class="flex items-center gap-3 mb-4">
                    @if($team->logo_url)
                    <img src="{{ $team->logo_url }}"
                        class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                    @else
                    <div class="w-12 h-12 rounded-xl bg-orange-500/20 border border-orange-500/30
                                            flex items-center justify-center font-bold text-orange-500 flex-shrink-0">
                        {{ strtoupper(substr($team->name, 0, 2)) }}
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-white truncate">{{ $team->name }}</h3>
                        <div class="flex items-center gap-2 mt-0.5">
                            @if($team->tag)
                            <span class="text-xs text-gray-600 font-mono">{{ $team->tag }}</span>
                            @endif
                            <span class="text-xs text-gray-500">
                                {{ $team->players_count }} {{ $team->players_count == 1 ? 'player' : 'players' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($team->game)
                <p class="text-xs text-gray-600 mb-3">{{ $team->game->name }}</p>
                @endif

                <div class="flex items-center gap-2 pt-3 border-t border-gray-800">
                    <a href="{{ route('user.teams.show', $team) }}"
                        class="flex-1 text-center text-xs bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Manage Players
                    </a>
                    <a href="{{ route('user.teams.edit', $team) }}"
                        class="text-xs bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1.5 rounded-lg transition">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('user.teams.destroy', $team) }}"
                        onsubmit="return confirm('Delete {{ addslashes($team->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400 px-3 py-1.5 rounded-lg transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-gray-900 border border-dashed border-gray-700 rounded-xl">
            <div class="w-14 h-14 rounded-full bg-gray-800 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-gray-500 text-sm mb-1 font-medium">No teams yet</p>
            <p class="text-gray-600 text-xs mb-4">Create your first team and add players</p>
            <a href="{{ route('user.teams.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + Create Team
            </a>
        </div>
        @endif
    </div>

</div>
@endsection