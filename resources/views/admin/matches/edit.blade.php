@extends('layouts.admin')
@section('title', 'Edit Match')
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.matches.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">
        &larr; Back to Matches
    </a>

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.matches.update', $match) }}"
        class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-400 mb-1">Event</label>
            <select name="event_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                @foreach($events as $event)
                <option value="{{ $event->id }}" {{ old('event_id', $match->event_id) == $event->id ? 'selected' : '' }}>
                    {{ $event->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Team A</label>
                <select name="team_a_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_a_id', $match->team_a_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Team B</label>
                <select name="team_b_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_b_id', $match->team_b_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Stage</label>
                <select name="stage" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                    <option value="group" {{ old('stage', $match->stage) == 'group' ? 'selected' : '' }}>Group</option>
                    <option value="quarterfinal" {{ old('stage', $match->stage) == 'quarterfinal' ? 'selected' : '' }}>Quarterfinal</option>
                    <option value="semifinal" {{ old('stage', $match->stage) == 'semifinal' ? 'selected' : '' }}>Semifinal</option>
                    <option value="final" {{ old('stage', $match->stage) == 'final' ? 'selected' : '' }}>Final</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Status</label>
                <select name="status" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                    <option value="scheduled" {{ old('status', $match->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="live" {{ old('status', $match->status) == 'live' ? 'selected' : '' }}>Live</option>
                    <option value="completed" {{ old('status', $match->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $match->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Scheduled Date & Time</label>
            <input type="datetime-local" name="scheduled_at"
                value="{{ old('scheduled_at', \Carbon\Carbon::parse($match->scheduled_at)->format('Y-m-d\TH:i')) }}"
                min="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg text-sm transition">
                Update Match
            </button>
        </div>
    </form>
</div>
@endsection