@extends('layouts.public')
@section('title', $event->name . ' — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Back --}}
    <a href="{{ route('events.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">
        &larr; Back to Events
    </a>

    {{-- Event Header --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    @if($event->status === 'live')
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>LIVE
                    </span>
                    @elseif($event->status === 'upcoming')
                    <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">UPCOMING</span>
                    @else
                    <span class="text-xs bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full">COMPLETED</span>
                    @endif
                    <span class="text-xs text-gray-500">{{ $event->game->name }}</span>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ $event->name }}</h1>
                <p class="text-gray-400 text-sm mt-1">
                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                    — {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                </p>
            </div>
            @if($event->prize_pool)
            <div class="text-right">
                <p class="text-xs text-gray-500 mb-1">Prize Pool</p>
                <p class="text-2xl font-bold text-orange-500">{{ $event->prize_pool }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Matches --}}
    <h2 class="text-lg font-bold mb-4">Matches</h2>
    @if($event->matches->count() > 0)
    <div class="space-y-3">
        @foreach($event->matches as $match)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-4">
                    <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded capitalize">{{ $match->stage }}</span>
                    @if($match->status === 'live')
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full">LIVE</span>
                    @elseif($match->status === 'upcoming')
                    <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">UPCOMING</span>
                    @else
                    <span class="text-xs bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full">COMPLETED</span>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-semibold text-sm">{{ $match->teamA->name }}</span>
                    <span class="text-orange-500 font-bold text-xs">VS</span>
                    <span class="font-semibold text-sm">{{ $match->teamB->name }}</span>
                </div>
                @if($match->result)
                <div class="text-right">
                    <p class="text-xs text-gray-500">Winner</p>
                    <p class="text-sm font-bold text-orange-500">{{ $match->result->winner->name ?? '—' }}</p>
                    <p class="text-xs text-gray-500">{{ $match->result->score_a }} — {{ $match->result->score_b }}</p>
                </div>
                @else
                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($match->scheduled_at)->format('M d, H:i') }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 text-center text-gray-500">
        No matches scheduled yet.
    </div>
    @endif
</div>
@endsection