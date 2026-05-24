@extends('layouts.public')
@section('title', 'Edit Match')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <a href="{{ route('user.events.matches.index', $event) }}" class="text-gray-400 text-sm">← Back to Matches</a>
    <form method="POST" action="{{ route('user.events.matches.update', [$event, $match]) }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4 space-y-4">
        @csrf
        @method('PUT')
        <h1 class="text-lg font-bold">Edit Match</h1>
        <select name="team_a_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            <option value="{{ $event->team_a_id }}" {{ old('team_a_id', $match->team_a_id) == $event->team_a_id ? 'selected' : '' }}>{{ $event->teamA?->name }}</option>
            <option value="{{ $event->team_b_id }}" {{ old('team_a_id', $match->team_a_id) == $event->team_b_id ? 'selected' : '' }}>{{ $event->teamB?->name }}</option>
        </select>
        <select name="team_b_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            <option value="{{ $event->team_a_id }}" {{ old('team_b_id', $match->team_b_id) == $event->team_a_id ? 'selected' : '' }}>{{ $event->teamA?->name }}</option>
            <option value="{{ $event->team_b_id }}" {{ old('team_b_id', $match->team_b_id) == $event->team_b_id ? 'selected' : '' }}>{{ $event->teamB?->name }}</option>
        </select>
        <input type="text" name="stage" value="{{ old('stage', $match->stage) }}" placeholder="Stage" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
        <select name="status" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
            @foreach(['scheduled','live','completed','cancelled'] as $status)
            <option value="{{ $status }}" {{ old('status', $match->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', optional($match->scheduled_at)->format('Y-m-d\\TH:i')) }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
        <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">Update</button>
    </form>
</div>
@endsection
