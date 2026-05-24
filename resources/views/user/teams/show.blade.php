@extends('layouts.public')
@section('title', $team->name . ' — EsportsTrack')
@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">
    <a href="{{ route('user.teams.index') }}" class="text-gray-400 hover:text-orange-500 text-sm transition mb-6 inline-block">← Back to Teams</a>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6 flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $team->name }}</h1>
            <p class="text-xs text-gray-500 mt-1">{{ $team->tag }} • {{ $team->country }} • {{ $team->game?->name }}</p>
        </div>
        <div class="flex gap-3 text-sm">
            <a href="{{ route('user.teams.players.index', $team) }}" class="text-orange-400">Manage Players</a>
            <a href="{{ route('user.teams.players.create', $team) }}" class="text-blue-400">Add Player</a>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-800 font-semibold">Players</div>
        @forelse($team->players as $player)
        <div class="px-5 py-4 border-b border-gray-800/80 flex items-center justify-between">
            <div>
                <p class="text-sm text-white">{{ $player->nickname }}</p>
                <p class="text-xs text-gray-500">{{ $player->real_name }} • {{ $player->role }} • {{ $player->country }}</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.teams.players.show', [$team, $player]) }}" class="text-blue-400">View</a>
                <a href="{{ route('user.teams.players.edit', [$team, $player]) }}" class="text-orange-400">Edit</a>
                <form method="POST" action="{{ route('user.teams.players.destroy', [$team, $player]) }}" onsubmit="return confirm('Remove player?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-5 py-6 text-sm text-gray-500">No players yet.</div>
        @endforelse
    </div>
</div>
@endsection
