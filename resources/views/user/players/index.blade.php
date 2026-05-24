@extends('layouts.public')
@section('title', 'Players — ' . $team->name)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('user.teams.show', $team) }}" class="text-gray-400 text-sm">← Back to Team</a>
        <a href="{{ route('user.teams.players.create', $team) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">+ Add Player</a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        @forelse($players as $player)
        <div class="px-5 py-4 border-b border-gray-800 flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if($player->avatar_url)
                <img src="{{ $player->avatar_url }}" alt="{{ $player->nickname }}" class="w-10 h-10 rounded-full object-cover border border-gray-700">
                @else
                <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-white text-xs font-bold">
                    {{ substr($player->nickname, 0, 2) }}
                </div>
                @endif
                <div>
                    <p class="text-white font-semibold">{{ $player->nickname }}</p>
                    <p class="text-xs text-gray-500">{{ $player->real_name }} • {{ $player->role }} • {{ $player->country }}</p>
                </div>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.teams.players.show', [$team, $player]) }}" class="text-blue-400 hover:text-blue-300">View</a>
                <a href="{{ route('user.teams.players.edit', [$team, $player]) }}" class="text-orange-400 hover:text-orange-300">Edit</a>
                <form method="POST" action="{{ route('user.teams.players.destroy', [$team, $player]) }}" onsubmit="return confirm('Delete player?')" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-300">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-5 py-8 text-gray-500 text-sm">No players found.</div>
        @endforelse
    </div>
</div>
@endsection