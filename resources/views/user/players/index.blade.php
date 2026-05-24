@extends('layouts.public')
@section('title', 'Players — ' . $team->name)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('user.teams.show', $team) }}" class="text-gray-400 text-sm">← Back to Team</a>
        <a href="{{ route('user.teams.players.create', $team) }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">+ Add Player</a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        @forelse($players as $player)
        <div class="px-5 py-4 border-b border-gray-800 flex justify-between items-center">
            <div>
                <p class="text-white font-semibold">{{ $player->nickname }}</p>
                <p class="text-xs text-gray-500">{{ $player->real_name }} • {{ $player->role }}</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.teams.players.show', [$team, $player]) }}" class="text-blue-400">View</a>
                <a href="{{ route('user.teams.players.edit', [$team, $player]) }}" class="text-orange-400">Edit</a>
                <form method="POST" action="{{ route('user.teams.players.destroy', [$team, $player]) }}" onsubmit="return confirm('Delete player?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-5 py-8 text-gray-500 text-sm">No players found.</div>
        @endforelse
    </div>
</div>
@endsection
