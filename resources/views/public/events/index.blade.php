@extends('layouts.public')
@section('title', 'Events — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-2xl font-bold">Events</h1>
        <p class="text-gray-400 text-sm mt-1">Browse all esports tournaments and events</p>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('events.index') }}" class="flex gap-2 mb-6">
        <input type="text" name="search" value="{{ $search ?? '' }}"
            placeholder="Search tournaments..."
            class="flex-1 bg-gray-900 border border-gray-700 text-white text-sm rounded-lg px-4 py-2
                   focus:outline-none focus:border-orange-500 placeholder-gray-600 transition">
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
        @if(request('game')) <input type="hidden" name="game" value="{{ request('game') }}"> @endif
        @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
        <button type="submit"
            class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
            Search
        </button>
        @if(request('search'))
        <a href="{{ route('events.index', array_filter(['status' => request('status'), 'game' => request('game'), 'type' => request('type')])) }}"
            class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm px-4 py-2 rounded-lg transition">
            Clear
        </a>
        @endif
    </form>

    {{-- Status Filters --}}
    <div class="flex flex-wrap gap-3 mb-4">
        <a href="{{ route('events.index', array_filter(['game' => $gameId, 'type' => $type, 'search' => $search])) }}"
            class="px-4 py-2 rounded-lg text-sm transition {{ !$status ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            All
        </a>
        <a href="{{ route('events.index', array_filter(['status' => 'live', 'game' => $gameId, 'type' => $type, 'search' => $search])) }}"
            class="px-4 py-2 rounded-lg text-sm transition flex items-center gap-1.5
                {{ $status === 'live' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            @if($status === 'live')
            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
            @else
            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
            @endif
            Live
        </a>
        <a href="{{ route('events.index', array_filter(['status' => 'upcoming', 'game' => $gameId, 'type' => $type, 'search' => $search])) }}"
            class="px-4 py-2 rounded-lg text-sm transition {{ $status === 'upcoming' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            Upcoming
        </a>
        <a href="{{ route('events.index', array_filter(['status' => 'completed', 'game' => $gameId, 'type' => $type, 'search' => $search])) }}"
            class="px-4 py-2 rounded-lg text-sm transition {{ $status === 'completed' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            Completed
        </a>
    </div>

    {{-- Game filter --}}
    <div class="flex justify-end mb-8">
        <select onchange="window.location='{{ route('events.index') }}?game='+this.value+'{{ $status ? '&status='.$status : '' }}{{ $search ? '&search='.$search : '' }}'"
            class="bg-gray-900 border border-gray-700 text-gray-400 text-sm rounded-lg px-3 py-2
               focus:outline-none focus:border-orange-500">
            <option value="">All Games</option>
            @foreach($games as $game)
            <option value="{{ $game->id }}" {{ $gameId == $game->id ? 'selected' : '' }}>
                {{ $game->name }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- Results count --}}
    <p class="text-gray-500 text-sm mb-4">
        Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} of {{ $events->total() }} events
    </p>

    {{-- Events Grid --}}
    @if($events->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($events as $event)
        <a href="{{ route('events.show', $event) }}"
            class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition block group">

            <div class="flex items-center justify-between mb-4">
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

                <div class="flex items-center gap-2">
                    @if($event->pandascore_id)
                    <span class="text-xs bg-purple-500/10 text-purple-400 px-2 py-0.5 rounded-full border border-purple-500/20">
                        Pro
                    </span>
                    @elseif($event->type)
                    <span class="text-xs bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded-full border border-blue-500/20">
                        {{ ucfirst($event->type) }}
                    </span>
                    @endif
                    <span class="text-xs text-gray-500">{{ $event->game?->name ?? '' }}</span>
                </div>
            </div>

            <h3 class="font-semibold text-white group-hover:text-orange-500 transition mb-2">
                {{ $event->name }}
            </h3>

            <div class="flex items-center justify-between mt-3">
                <p class="text-gray-500 text-xs">
                    @if($event->start_date)
                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}
                    @if($event->end_date)
                    — {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                    @endif
                    @endif
                </p>
                @if($event->prize_pool)
                <p class="text-orange-500 text-sm font-medium">{{ $event->prize_pool }}</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $events->appends(request()->query())->links() }}
    </div>
    @else
    <div class="text-center py-20 text-gray-500">
        <p class="text-lg mb-2">No events found</p>
        <p class="text-sm">Try changing the filters above</p>
    </div>
    @endif

</div>
@endsection