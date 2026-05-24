@extends('layouts.public')
@section('title', $team->name . ' — EsportsTrack')
@section('content')

<div class="min-h-screen bg-gray-900">
    <!-- Header Section -->
    <div class="border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Back Link -->
            <a href="{{ route('user.teams.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition mb-6 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Teams
            </a>

            <!-- Team Header with Title & Button -->
            <div class="flex items-end justify-between gap-6">
                <!-- Team Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <h1 class="text-4xl font-bold text-white">{{ $team->name }}</h1>
                        <span class="bg-orange-500/20 text-orange-400 text-xs px-3 py-1 rounded-full font-semibold">
                            {{ $team->tag }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Manage and organize your team's players</p>
                    <div class="flex items-center gap-4 text-sm text-gray-400">
                        @if($team->country)
                        <span>{{ $team->country }}</span>
                        <span class="text-gray-700">•</span>
                        @endif
                        @if($team->game)
                        <span>{{ $team->game->name }}</span>
                        <span class="text-gray-700">•</span>
                        @endif
                        <span class="text-orange-500 font-medium">{{ $team->players->count() }} players</span>
                    </div>
                </div>

                <!-- Add Player Button -->
                <a href="{{ route('user.teams.players.create', $team) }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg transition flex items-center gap-2 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Player
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Players Grid -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        @forelse($team->players as $player)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 mb-4 hover:border-gray-600 transition">
            <div class="flex items-center justify-between gap-6">
                <!-- Player Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-xl font-semibold text-white">{{ $player->nickname }}</h3>
                        @if($player->role)
                        <span class="bg-blue-500/20 text-blue-400 text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $player->role }}
                        </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-400">
                        @if($player->real_name)
                        <span>{{ $player->real_name }}</span>
                        @endif
                        @if($player->country)
                        <span class="text-gray-600">•</span>
                        <span>{{ $player->country }}</span>
                        @endif
                    </div>
                </div>

                <!-- Action Icons with Tooltips -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <!-- View Icon -->
                    <div class="relative group">
                        <a href="{{ route('user.teams.players.show', [$team, $player]) }}"
                            class="text-gray-400 hover:text-blue-400 transition p-2.5 rounded-lg hover:bg-blue-500/20 block">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <div class="absolute bottom-full right-0 mb-2 px-3 py-1.5 bg-gray-900 text-gray-200 text-xs rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none border border-gray-700 font-medium">
                            View Details
                        </div>
                    </div>

                    <!-- Edit Icon -->
                    <div class="relative group">
                        <a href="{{ route('user.teams.players.edit', [$team, $player]) }}"
                            class="text-gray-400 hover:text-orange-400 transition p-2.5 rounded-lg hover:bg-orange-500/20 block">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <div class="absolute bottom-full right-0 mb-2 px-3 py-1.5 bg-gray-900 text-gray-200 text-xs rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none border border-gray-700 font-medium">
                            Edit Player
                        </div>
                    </div>

                    <!-- Delete Icon -->
                    <form method="POST" action="{{ route('user.teams.players.destroy', [$team, $player]) }}"
                        onsubmit="return confirm('Are you sure? This action cannot be undone.');"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <div class="relative group">
                            <button type="submit" class="text-gray-400 hover:text-red-400 transition p-2.5 rounded-lg hover:bg-red-500/20 block">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <div class="absolute bottom-full right-0 mb-2 px-3 py-1.5 bg-gray-900 text-gray-200 text-xs rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none border border-gray-700 font-medium">
                                Delete Player
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-12 text-center">
            <div class="mb-4 flex justify-center">
                <div class="bg-gray-700/50 p-4 rounded-2xl">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
            <p class="text-gray-300 text-lg font-semibold mb-2">No players yet</p>
            <p class="text-gray-400 text-sm mb-6">Start building your team by adding your first player</p>
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

@endsection