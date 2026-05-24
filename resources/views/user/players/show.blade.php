@extends('layouts.public')
@section('title', $player->nickname)
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <a href="{{ route('user.teams.players.index', $team) }}" class="text-gray-400 text-sm">← Back to Players</a>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4">
        <h1 class="text-xl font-bold text-white">{{ $player->nickname }}</h1>
        <p class="text-gray-500 text-sm mt-2">Real Name: {{ $player->real_name ?: 'N/A' }}</p>
        <p class="text-gray-500 text-sm">Role: {{ $player->role ?: 'N/A' }}</p>
        <p class="text-gray-500 text-sm">Country: {{ $player->country ?: 'N/A' }}</p>
        <div class="mt-4">
            <a href="{{ route('user.teams.players.edit', [$team, $player]) }}" class="text-orange-400 text-sm">Edit Player</a>
        </div>
    </div>
</div>
@endsection
