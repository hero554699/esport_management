@extends('layouts.public')
@section('title', 'Match Details')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('user.events.matches.index', $event) }}" class="text-gray-400 text-sm">← Back to Matches</a>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4">
        <h1 class="text-xl font-bold">{{ $match->teamA?->name }} vs {{ $match->teamB?->name }}</h1>
        <p class="text-gray-500 text-sm mt-2">{{ $match->stage }} • {{ strtoupper($match->status) }} • {{ optional($match->scheduled_at)->format('M d, Y H:i') }}</p>
        <div class="mt-4">
            <a href="{{ route('user.events.matches.edit', [$event, $match]) }}" class="text-orange-400 text-sm">Edit Match</a>
            <span class="mx-2 text-gray-600">|</span>
            <a href="{{ route('user.matches.results.index', $match) }}" class="text-green-400 text-sm">Manage Results</a>
        </div>
    </div>
</div>
@endsection
