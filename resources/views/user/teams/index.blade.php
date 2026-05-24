@extends('layouts.public')
@section('title', 'My Teams — EsportsTrack')
@section('content')

<div class="min-h-screen bg-gray-900">
    <!-- Header with Back Button -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition mb-4 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">My Teams</h1>
                    <p class="text-gray-400 mt-2">Manage and organize your esports teams</p>
                </div>
                <a href="{{ route('user.teams.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    + Create Team
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- Teams Grid -->
        <div class="space-y-4">
            @forelse($teams as $team)
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <div class="flex items-start justify-between">
                    <!-- Team Info -->
                    <div class="flex items-start gap-4 flex-1">
                        @if($team->logo_url)
                        <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" class="w-20 h-20 rounded-lg object-cover">
                        @else
                        <div class="w-20 h-20 rounded-lg bg-orange-500/20 border border-orange-500/30 flex items-center justify-center flex-shrink-0">
                            <span class="text-orange-500 font-bold text-2xl">{{ strtoupper(substr($team->name, 0, 2)) }}</span>
                        </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white">{{ $team->name }}</h3>
                            @if($team->tag)
                            <p class="text-gray-400 text-sm">{{ $team->tag }}</p>
                            @endif
                            <div class="flex items-center gap-4 mt-2 text-sm">
                                <span class="text-gray-400">
                                    <span class="font-semibold text-white">{{ $team->players_count }}</span> players
                                </span>
                                @if($team->game)
                                <span class="text-gray-400">
                                    <span class="font-semibold text-white">{{ $team->game->name }}</span>
                                </span>
                                @endif
                                @if($team->country)
                                <span class="text-gray-400">
                                    {{ $team->country }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('user.teams.show', $team) }}"
                            class="text-orange-500 hover:text-orange-400 font-semibold transition whitespace-nowrap">
                            Manage
                        </a>
                        <a href="{{ route('user.teams.edit', $team) }}"
                            class="text-blue-400 hover:text-blue-300 transition whitespace-nowrap">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('user.teams.destroy', $team) }}"
                            onsubmit="return confirm('Are you sure? This action cannot be undone.')"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 transition whitespace-nowrap">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 bg-gray-800 border border-gray-700 rounded-xl">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </div>
                <p class="text-gray-400 mb-4 text-lg">No teams yet</p>
                <p class="text-gray-500 text-sm mb-6">Start building your esports team by creating one now</p>
                <a href="{{ route('user.teams.create') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition inline-block">
                    + Create Your First Team
                </a>
            </div>
            @endforelse
        </div>

        <!-- Info Box -->
        <div class="mt-12 bg-blue-500/10 border border-blue-500/30 rounded-xl p-6">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 7a1 1 0 000 2h6a1 1 0 000-2H8z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-blue-400 font-semibold">Team Management Tips</p>
                    <p class="text-blue-300 text-sm mt-1">After creating a team, you can manage players, edit team details, and assign them to tournaments.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection