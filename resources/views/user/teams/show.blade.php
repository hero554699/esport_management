@extends('layouts.public')
@section('title', $team->name . ' — EsportsTrack')
@section('content')

<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <a href="{{ route('user.teams.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition mb-4 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Teams
            </a>

            <div class="flex items-start justify-between gap-6">
                <!-- Team Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-2">
                        <h1 class="text-3xl font-bold text-white">{{ $team->name }}</h1>
                        <span class="bg-orange-500/20 text-orange-400 text-xs px-3 py-1 rounded-full font-semibold">
                            {{ $team->tag }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-400">
                        @if($team->country)
                        <span>{{ $team->country }}</span>
                        <span class="text-gray-700">•</span>
                        @endif
                        @if($team->game)
                        <span>{{ $team->game->name }}</span>
                        <span class="text-gray-700">•</span>
                        @endif
                        <span>{{ $team->players_count ?? 0 }} Players</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 flex-shrink-0">
                    <a href="{{ route('user.teams.players.create', $team) }}"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Player
                    </a>
                    <a href="{{ route('user.teams.players.index', $team) }}"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg transition border border-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Manage
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="max-w-6xl mx-auto px-4 py-4">
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Players Section -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
            <!-- Section Header -->
            <div class="px-6 py-4 bg-gray-900 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500/20 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v2h2v-2a11 11 0 10-20 0v2h2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Team Players</h2>
                        <p class="text-xs text-gray-400">{{ $team->players_count ?? 0 }} players total</p>
                    </div>
                </div>
            </div>

            <!-- Players List -->
            @forelse($team->players as $player)
            <div class="px-6 py-4 border-b border-gray-700/50 last:border-b-0 hover:bg-gray-700/30 transition">
                <div class="flex items-start justify-between gap-4">
                    <!-- Player Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <h3 class="text-white font-semibold">{{ $player->nickname }}</h3>
                            @if($player->role)
                            <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-0.5 rounded">
                                {{ $player->role }}
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-400">
                            @if($player->real_name)
                            <span>{{ $player->real_name }}</span>
                            @endif
                            @if($player->country)
                            <span class="text-gray-700">•</span>
                            <span>{{ $player->country }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('user.teams.players.show', [$team, $player]) }}"
                            class="text-gray-400 hover:text-blue-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('user.teams.players.edit', [$team, $player]) }}"
                            class="text-gray-400 hover:text-orange-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('user.teams.players.destroy', [$team, $player]) }}"
                            onsubmit="return confirm('Are you sure? This action cannot be undone.');"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-400 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="px-6 py-16 text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <p class="text-gray-400 text-lg mb-4">No players yet</p>
                <p class="text-gray-500 text-sm mb-6">Start building your team by adding players</p>
                <a href="{{ route('user.teams.players.create', $team) }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg transition inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Your First Player
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection