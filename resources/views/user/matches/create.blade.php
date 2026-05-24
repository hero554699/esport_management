@extends('layouts.public')
@section('title', 'Schedule Match')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <a href="{{ route('user.events.matches.index', $event) }}" class="text-gray-400 text-sm">← Back to Matches</a>
    <form method="POST" action="{{ route('user.events.matches.store', $event) }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4 space-y-4">
        @csrf
        <h1 class="text-lg font-bold">Schedule Match</h1>
        <input type="hidden" name="status" value="scheduled">
        <select name="team_a_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            <option value="">Team A</option>
            <option value="{{ $event->team_a_id }}">{{ $event->teamA?->name }}</option>
            <option value="{{ $event->team_b_id }}">{{ $event->teamB?->name }}</option>
        </select>
        <select name="team_b_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            <option value="">Team B</option>
            <option value="{{ $event->team_a_id }}">{{ $event->teamA?->name }}</option>
            <option value="{{ $event->team_b_id }}">{{ $event->teamB?->name }}</option>
        </select>
        <input type="text" name="stage" value="{{ old('stage') }}" placeholder="Stage" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
        <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">Schedule</button>
    </form>
</div>
@endsection
