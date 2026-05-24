@extends('layouts.public')
@section('title', 'Record Result')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <a href="{{ route('user.matches.results.index', $match) }}" class="text-gray-400 text-sm">← Back to Results</a>
    <form method="POST" action="{{ route('user.matches.results.store', $match) }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4 space-y-4">
        @csrf
        <h1 class="text-lg font-bold">Record Result</h1>
        <input type="hidden" name="match_id" value="{{ $match->id }}">
        <select name="winner_team_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            <option value="{{ $match->team_a_id }}">{{ $match->teamA?->name }}</option>
            <option value="{{ $match->team_b_id }}">{{ $match->teamB?->name }}</option>
        </select>
        <div class="grid grid-cols-2 gap-4">
            <input type="number" name="score_a" min="0" value="{{ old('score_a', 0) }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            <input type="number" name="score_b" min="0" value="{{ old('score_b', 0) }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
        </div>
        <select name="mvp_player" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
            <option value="">Select MVP (optional)</option>
            @foreach($match->teamA->players->merge($match->teamB->players) as $player)
            <option value="{{ $player->id }}">{{ $player->nickname }} ({{ $player->team?->name }})</option>
            @endforeach
        </select>
        <textarea name="notes" rows="3" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
        <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">Save Result</button>
    </form>
</div>
@endsection
