@extends('layouts.public')
@section('title', 'Edit Tournament — EsportsTrack')
@section('content')

<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('user.events.index') }}" class="text-gray-500 hover:text-orange-500 text-sm transition">← Back to Tournaments</a>

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl my-4 text-sm">{{ $errors->first() }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4">
        <form method="POST" action="{{ route('user.events.update', $event) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-400 mb-1">Tournament Name *</label>
                <input type="text" name="name" required value="{{ old('name', $event->name) }}" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Game *</label>
                <select name="game_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id', $event->game_id) == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Team A *</label>
                    <select name="team_a_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_a_id', $event->team_a_id) == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Team B *</label>
                    <select name="team_b_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_b_id', $event->team_b_id) == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Start Date *</label>
                    <input type="datetime-local" name="start_date" required value="{{ old('start_date', optional($event->start_date)->format('Y-m-d\TH:i')) }}" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">End Date *</label>
                    <input type="datetime-local" name="end_date" required value="{{ old('end_date', optional($event->end_date)->format('Y-m-d\TH:i')) }}" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Prize Pool</label>
                    <input type="text" name="prize_pool" value="{{ old('prize_pool', $event->prize_pool) }}" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tournament Type</label>
                    <select name="type" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm">
                        <option value="local" {{ old('type', $event->type) == 'local' ? 'selected' : '' }}>Local</option>
                        <option value="national" {{ old('type', $event->type) == 'national' ? 'selected' : '' }}>National</option>
                        <option value="international" {{ old('type', $event->type) == 'international' ? 'selected' : '' }}>International</option>
                        <option value="world" {{ old('type', $event->type) == 'world' ? 'selected' : '' }}>World</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm">Update Tournament</button>
        </form>
    </div>
</div>
@endsection
