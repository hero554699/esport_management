@extends('layouts.public')
@section('title', 'Games — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold">Games</h1>
            <p class="text-gray-400 text-sm mt-1">All games covered on EsportsTrack</p>
        </div>
    </div>

    {{-- Platform Filter --}}
    <div class="flex gap-3 mb-8 flex-wrap">
        <a href="{{ route('games.index') }}"
            class="px-4 py-2 rounded-lg text-sm transition {{ !$platform ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            All
        </a>
        <a href="{{ route('games.index') }}?platform=pc"
            class="px-4 py-2 rounded-lg text-sm transition {{ $platform === 'pc' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            PC
        </a>
        <a href="{{ route('games.index') }}?platform=mobile"
            class="px-4 py-2 rounded-lg text-sm transition {{ $platform === 'mobile' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            Mobile
        </a>
        <a href="{{ route('games.index') }}?platform=console"
            class="px-4 py-2 rounded-lg text-sm transition {{ $platform === 'console' ? 'bg-orange-500 text-white' : 'bg-gray-900 border border-gray-700 text-gray-400 hover:border-orange-500' }}">
            Console
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($games as $game)
        <a href="{{ route('events.index') }}?game={{ $game->id }}"
            class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition block">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-white">{{ $game->name }}</h3>
                @if($game->platform === 'mobile')
                <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">Mobile</span>
                @elseif($game->platform === 'pc')
                <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full">PC</span>
                @else
                <span class="text-xs bg-purple-500/20 text-purple-400 px-2 py-1 rounded-full">Console</span>
                @endif
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-500 mt-3 pt-3 border-t border-gray-800">
                <span>{{ $game->teams_count }} teams</span>
                <span>{{ $game->events_count }} events</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection