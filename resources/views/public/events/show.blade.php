@extends('layouts.public')
@section('title', $event->name . ' — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">
<!-- this is for games with event -->
    {{-- Back --}}
    <a href="{{ route('events.index') }}"
       class="text-gray-400 hover:text-orange-500 text-sm transition mb-6 inline-flex items-center gap-1">
        ← Back to Events
    </a>

    {{-- Event Header --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    @if($event->status === 'live')
                        <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                            LIVE
                        </span>
                    @elseif($event->status === 'upcoming')
                        <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">UPCOMING</span>
                    @else
                        <span class="text-xs bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full">COMPLETED</span>
                    @endif

                    @if($event->pandascore_id)
                        <span class="text-xs bg-purple-500/10 text-purple-400 px-2 py-0.5 rounded-full border border-purple-500/20">Pro</span>
                    @elseif($event->type)
                        <span class="text-xs bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded-full border border-blue-500/20">{{ ucfirst($event->type) }}</span>
                    @endif

                    <span class="text-xs text-gray-500">{{ $event->game?->name }}</span>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ $event->name }}</h1>
                <p class="text-gray-400 text-sm mt-1">
                    @if($event->start_date)
                        {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                        @if($event->end_date)
                            — {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                        @endif
                    @else
                        Date TBD
                    @endif
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
    <h2 class="text-lg font-bold mb-4">
        Matches
        <span class="text-gray-600 text-sm font-normal ml-2">{{ $event->matches->count() }} total</span>
    </h2>

    @if($event->matches->count() > 0)
        <div class="flex flex-col gap-3">
            @foreach($event->matches->sortByDesc('scheduled_at') as $match)
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
                    <div class="flex items-center gap-4">

                        {{-- Left: Status + Stage --}}
                        <div class="flex flex-col gap-1 w-36 flex-shrink-0">
                            @if($match->status === 'live')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                    LIVE
                                </span>
                            @elseif($match->status === 'upcoming')
                                <span class="text-xs font-semibold text-blue-400">UPCOMING</span>
                            @else
                                <span class="text-xs font-semibold text-gray-500">COMPLETED</span>
                            @endif
                            @if($match->stage)
                                <span class="text-xs text-gray-600 truncate">{{ $match->stage }}</span>
                            @endif
                            @if($match->scheduled_at)
                                <span class="text-xs text-gray-600">
                                    {{ \Carbon\Carbon::parse($match->scheduled_at)->format('M d · H:i') }}
                                </span>
                            @endif
                        </div>

                        {{-- Center: Teams + Score --}}
                        <div class="flex-1 flex items-center justify-center">

                            {{-- Team A --}}
                            <div class="flex items-center gap-3 flex-1 justify-end">
                                <span class="font-semibold text-sm text-right
                                    {{ $match->result?->winner_team_id === $match->team_a_id ? 'text-orange-500' : 'text-white' }}">
                                    {{ $match->teamA?->name ?? 'TBD' }}
                                </span>
                                @if($match->teamA?->logo_url)
                                    <img src="{{ $match->teamA->logo_url }}"
                                         class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-gray-800 border border-gray-700
                                                flex items-center justify-center text-xs font-bold text-orange-500 flex-shrink-0">
                                        {{ strtoupper(substr($match->teamA?->name ?? 'A', 0, 2)) }}
                                    </div>
                                @endif
                            </div>

                            {{-- Score / VS --}}
                            <div class="w-24 flex items-center justify-center flex-shrink-0">
                                @if($match->status === 'completed' && $match->result)
                                    <div class="flex items-center gap-1">
                                        <span class="text-xl font-bold w-8 text-center
                                            {{ $match->result->winner_team_id === $match->team_a_id ? 'text-orange-500' : 'text-gray-400' }}">
                                            {{ $match->result->score_a ?? 0 }}
                                        </span>
                                        <span class="text-gray-600 text-sm">:</span>
                                        <span class="text-xl font-bold w-8 text-center
                                            {{ $match->result->winner_team_id === $match->team_b_id ? 'text-orange-500' : 'text-gray-400' }}">
                                            {{ $match->result->score_b ?? 0 }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs font-bold text-gray-500 border border-gray-700
                                                 rounded-lg px-3 py-1.5">VS</span>
                                @endif
                            </div>

                            {{-- Team B --}}
                            <div class="flex items-center gap-3 flex-1 justify-start">
                                @if($match->teamB?->logo_url)
                                    <img src="{{ $match->teamB->logo_url }}"
                                         class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-gray-800 border border-gray-700
                                                flex items-center justify-center text-xs font-bold text-orange-500 flex-shrink-0">
                                        {{ strtoupper(substr($match->teamB?->name ?? 'B', 0, 2)) }}
                                    </div>
                                @endif
                                <span class="font-semibold text-sm
                                    {{ $match->result?->winner_team_id === $match->team_b_id ? 'text-orange-500' : 'text-white' }}">
                                    {{ $match->teamB?->name ?? 'TBD' }}
                                </span>
                            </div>

                        </div>

                        {{-- Right: Winner badge --}}
                        <div class="w-28 flex-shrink-0 text-right">
                            @if($match->result?->winner_team_id)
                                @php
                                    $winnerName = $match->result->winner_team_id === $match->team_a_id
                                        ? $match->teamA?->name
                                        : $match->teamB?->name;
                                @endphp
                                <p class="text-xs text-gray-500 mb-1">Winner</p>
                                <p class="text-xs font-bold text-orange-500 truncate">{{ $winnerName }}</p>
                            @endif
                        </div>

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