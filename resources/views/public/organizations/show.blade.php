@extends('layouts.public')
@section('title', '{{ $organization->name }} — EsportsTrack')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <!-- Header with back button -->
    <div class="mb-8">
        <a href="{{ route('organizations.index') }}" class="text-orange-500 hover:text-orange-400 text-sm transition mb-4 inline-block">
            ← Back to Organizations
        </a>
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">{{ $organization->name }}</h1>
                <p class="text-gray-400 text-sm mt-2">{{ $organization->country ?? 'Unknown Location' }}</p>
            </div>
        </div>
    </div>

    <!-- Website Link -->
    @if($organization->website)
    <div class="mb-8">
        <a href="{{ $organization->website }}" target="_blank" rel="noopener noreferrer"
            class="inline-flex items-center gap-2 bg-orange-500/20 hover:bg-orange-500/30 border border-orange-500/50 text-orange-400 px-4 py-2 rounded-lg transition">
            <span>Visit Official Website</span>
            <span>↗</span>
        </a>
    </div>
    @endif

    <!-- Teams Section -->
    <div class="border-t border-gray-800 pt-8">
        <h2 class="text-2xl font-bold text-white mb-6">Teams ({{ $organization->teams_count }})</h2>

        @if($organization->teams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($organization->teams as $team)
            <a href="{{ route('teams.index') }}"
                class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition block group">
                <div class="flex items-center gap-3 mb-3">
                    @if($team->logo_url)
                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}"
                        class="w-10 h-10 rounded object-cover">
                    @else
                    <div class="w-10 h-10 rounded bg-orange-500/20 border border-orange-500/30
                                    flex items-center justify-center">
                        <span class="text-orange-500 font-bold text-xs">
                            {{ strtoupper(substr($team->name, 0, 2)) }}
                        </span>
                    </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-white group-hover:text-orange-500 transition">
                            {{ $team->name }}
                        </h3>
                        <p class="text-gray-500 text-xs">{{ $team->tag ?? $team->acronym ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs mt-3">
                    <span class="text-gray-500">{{ $team->players_count ?? 0 }} players</span>
                    <span class="text-gray-600">{{ $team->country ?? 'Unknown' }}</span>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
            <p class="text-gray-400">No teams found for this organization</p>
        </div>
        @endif
    </div>
</div>
@endsection