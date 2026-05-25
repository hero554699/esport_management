@extends('layouts.public')
@section('title', $event->name)

@section('content')
<div class="min-h-screen bg-gray-900">

    {{-- Header --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <button onclick="window.history.back()"
                class="inline-flex items-center gap-1.5 text-gray-400 hover:text-orange-500 transition mb-4 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </button>

            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-4xl font-bold text-white">{{ $event->name }}</h1>
                        @if($event->approval_status === 'pending')
                        <span class="bg-yellow-500/20 text-yellow-400 text-sm px-3 py-1 rounded-full font-medium">PENDING</span>
                        @elseif($event->approval_status === 'approved')
                        <span class="bg-green-500/20 text-green-400 text-sm px-3 py-1 rounded-full font-medium">APPROVED</span>
                        @else
                        <span class="bg-red-500/20 text-red-400 text-sm px-3 py-1 rounded-full font-medium">REJECTED</span>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm">Manage and schedule matches for your tournament</p>
                </div>
                <a href="{{ route('user.events.edit', $event) }}"
                    class="text-orange-400 hover:text-orange-300 font-semibold">
                    Edit Tournament
                </a>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Tournament Info Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-4">
                <p class="text-gray-500 text-xs mb-1">Game</p>
                <p class="text-white font-semibold">{{ $event->game->name ?? 'N/A' }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-4">
                <p class="text-gray-500 text-xs mb-1">Type</p>
                <p class="text-orange-400 font-semibold uppercase">{{ $event->type }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-4">
                <p class="text-gray-500 text-xs mb-1">Matches</p>
                <p class="text-white font-semibold">{{ $matches->count() }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-4">
                <p class="text-gray-500 text-xs mb-1">Prize Pool</p>
                <p class="text-orange-500 font-semibold">{{ $event->prize_pool ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Certification Status --}}
        @if($event->hasCertification())
        <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 mb-8 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-green-400 font-semibold text-sm">Certification Verified</p>
                <p class="text-green-300 text-xs">{{ basename($event->certification_path) }}</p>
            </div>
        </div>
        @endif

        {{-- Matches Section --}}
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Matches</h2>
                @if($event->approval_status === 'approved')
                <a href="{{ route('user.events.matches.create', $event) }}"
                    class="relative overflow-hidden bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg transition btn-shine inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Match
                </a>
                @else
                <p class="text-yellow-400 text-sm">⚠️ Tournament must be approved to create matches</p>
                @endif
            </div>

            @if($matches->isEmpty())
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-12 text-center">
                <p class="text-gray-400 mb-4">No matches scheduled yet.</p>
                @if($event->approval_status === 'approved')
                <a href="{{ route('user.events.matches.create', $event) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg inline-block">
                    + Schedule First Match
                </a>
                @endif
            </div>
            @else
            <div class="space-y-3">
                @foreach($matches->sortBy('scheduled_at') as $match)
                <div class="bg-gray-800 border border-gray-700 hover:border-orange-500/40 rounded-xl p-5 transition">
                    <div class="flex items-center justify-between gap-4">

                        {{-- Match Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-white font-semibold">
                                    {{ $match->teamA->name ?? 'TBD' }}
                                    <span class="text-gray-500">vs</span>
                                    {{ $match->teamB->name ?? 'TBD' }}
                                </h3>
                                @if($match->result)
                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-0.5 rounded">
                                    Completed
                                </span>
                                @elseif($match->status === 'live')
                                <span class="bg-red-500/20 text-red-400 text-xs px-2 py-0.5 rounded flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Live
                                </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 text-xs">Stage</p>
                                    <p class="text-gray-300">{{ $match->stage }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Scheduled</p>
                                    <p class="text-gray-300">{{ $match->scheduled_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Status</p>
                                    <p class="text-gray-300 uppercase text-xs font-medium">{{ $match->status }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if($match->result)
                            <a href="{{ route('user.matches.results.show', $match) }}"
                                class="text-green-400 hover:text-green-300 text-sm font-semibold">
                                Result
                            </a>
                            @else
                            <a href="{{ route('user.matches.results.create', $match) }}"
                                class="text-green-400 hover:text-green-300 text-sm font-semibold">
                                Add Result
                            </a>
                            @endif
                            <a href="{{ route('user.events.matches.edit', [$event, $match]) }}"
                                class="text-blue-400 hover:text-blue-300 text-sm">Edit</a>
                            <form method="POST" action="{{ route('user.events.matches.destroy', [$event, $match]) }}"
                                onsubmit="return confirm('Delete this match?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
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