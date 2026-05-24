@extends('layouts.public')
@section('title', 'Create Tournament')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-white mb-2">Create Tournament</h1>
        <p class="text-gray-400 mb-8">Select 2 of your teams and submit for approval.</p>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('user.events.store') }}" method="POST" class="bg-gray-800 border border-gray-700 rounded-xl p-8 space-y-5">
            @csrf

            <div>
                <label class="block text-white font-semibold mb-2">Tournament Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
            </div>

            <div>
                <label class="block text-white font-semibold mb-2">Game *</label>
                <select name="game_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-white font-semibold mb-2">Team A *</label>
                    <select name="team_a_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
                        <option value="">Select your team</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_a_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-white font-semibold mb-2">Team B *</label>
                    <select name="team_b_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
                        <option value="">Select your team</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_b_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-white font-semibold mb-2">Tournament Type *</label>
                <select name="type" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
                    <option value="">Select type</option>
                    <option value="local" {{ old('type') == 'local' ? 'selected' : '' }}>Local</option>
                    <option value="national" {{ old('type') == 'national' ? 'selected' : '' }}>National</option>
                    <option value="international" {{ old('type') == 'international' ? 'selected' : '' }}>International</option>
                    <option value="world" {{ old('type') == 'world' ? 'selected' : '' }}>World</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-white font-semibold mb-2">Start Date *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
                </div>
                <div>
                    <label class="block text-white font-semibold mb-2">End Date *</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white" required>
                </div>
            </div>

            <div>
                <label class="block text-white font-semibold mb-2">Prize Pool (Optional)</label>
                <input type="text" name="prize_pool" value="{{ old('prize_pool') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white">
            </div>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl">Submit for Approval</button>
        </form>
    </div>
</div>
@endsection
