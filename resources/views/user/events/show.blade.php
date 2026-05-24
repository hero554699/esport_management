@extends('layouts.public')
@section('title', $event->name . ' — EsportsTrack')
@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">
    <a href="{{ route('user.events.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 text-sm transition mb-6 font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Tournaments
    </a>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
    @endif

    <!-- Tournament Header -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-white">{{ $event->name }}</h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 text-sm">{{ $event->game?->name ?? 'N/A' }}</span>
                    <span class="text-gray-600">•</span>
                    <span class="text-orange-500 font-semibold text-sm">{{ ucfirst($event->type) }} Tournament</span>
                    <span class="text-gray-600">•</span>
                    <span class="text-gray-400 text-sm">{{ ucfirst($event->approval_status) }}</span>
                </div>
            </div>
            <a href="{{ route('user.events.edit', $event) }}" class="text-blue-400 hover:text-blue-300 transition">
                Edit
            </a>
        </div>

        <!-- Prize Pool -->
        @if($event->prize_pool)
        <div class="bg-gray-800 rounded-lg p-3 mb-4">
            <p class="text-gray-400 text-sm">Prize Pool</p>
            <p class="text-orange-500 font-bold text-lg">{{ $event->prize_pool }}</p>
        </div>
        @endif

        <!-- Certification Info -->
        @if($event->hasCertification())
        <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-3 mb-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-green-400 text-sm"><strong>Certification Verified</strong> - This tournament is officially certified</p>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex gap-3 text-sm">
            <a href="{{ route('user.events.matches.index', $event) }}" class="text-orange-400 hover:text-orange-300">Manage Matches</a>
            <a href="{{ route('user.events.matches.create', $event) }}" class="text-blue-400 hover:text-blue-300">Schedule Match</a>
        </div>
    </div>

    <!-- Matches Section -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="px-6 py-4 bg-gray-800 border-b border-gray-700 font-semibold text-white">
            Matches ({{ $event->matches->count() }})
        </div>

        @forelse($event->matches->sortBy('scheduled_at') as $match)
        <div class="px-6 py-4 border-b border-gray-800/50 last:border-b-0 hover:bg-gray-800/50 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-white font-semibold">{{ $match->teamA?->name ?? 'TBD' }} vs {{ $match->teamB?->name ?? 'TBD' }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $match->stage }} • {{ strtoupper($match->status) }} • {{ optional($match->scheduled_at)->format('M d, Y H:i') }}</p>
                </div>
                <div class="flex gap-3 text-sm">
                    <a href="{{ route('user.events.matches.show', [$event, $match]) }}" class="text-blue-400 hover:text-blue-300">View</a>
                    <a href="{{ route('user.events.matches.edit', [$event, $match]) }}" class="text-orange-400 hover:text-orange-300">Edit</a>
                    <a href="{{ route('user.matches.results.index', $match) }}" class="text-green-400 hover:text-green-300">Results</a>
                </div>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-gray-500">
            <p>No matches scheduled yet.</p>
            <a href="{{ route('user.events.matches.create', $event) }}" class="text-orange-400 hover:text-orange-300 text-sm mt-2 inline-block">
                Schedule your first match →
            </a>
        </div>
        @endforelse
    </div>
</div>

@endsection