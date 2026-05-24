@extends('layouts.public')
@section('title', 'Edit Team — EsportsTrack')
@section('content')

<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <a href="{{ route('user.teams.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition mb-4 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Teams
            </a>
            <h1 class="text-3xl font-bold text-white">Edit Team</h1>
            <p class="text-gray-400 mt-2">Update {{ $team->name }}'s information</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-3xl mx-auto px-4 py-8">
        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-8">
            <form method="POST" action="{{ route('user.teams.update', $team) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Team Name (Required) -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Team Name *</label>
                    <input type="text" name="name" value="{{ old('name', $team->name) }}"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                        placeholder="e.g. T1, Fnatic, Cloud9" required>
                    @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Two Column Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Tag -->
                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Tag</label>
                        <input type="text" name="tag" value="{{ old('tag', $team->tag) }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="e.g. T1, FNC, C9">
                        @error('tag')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Country</label>
                        <input type="text" name="country" value="{{ old('country', $team->country) }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="e.g. South Korea, Europe">
                        @error('country')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Game Selection -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Game</label>
                    <select name="game_id"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition">
                        <option value="">Select a game</option>
                        @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id', $team->game_id) == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                        @endforeach
                    </select>
                    @error('game_id')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo URL -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Logo URL</label>
                    <input type="url" name="logo_url" value="{{ old('logo_url', $team->logo_url) }}"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                        placeholder="https://example.com/logo.png">
                    <p class="text-gray-600 text-xs mt-1">Paste a direct image link</p>
                    @error('logo_url')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Logo Preview -->
                @if($team->logo_url)
                <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                    <p class="text-gray-400 text-xs mb-2">Current Logo:</p>
                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" class="h-24 w-24 rounded-lg object-cover">
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-gray-700">
                    <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Update Team
                    </button>
                    <a href="{{ route('user.teams.index') }}"
                        class="flex-1 text-center border border-gray-700 hover:border-gray-600 text-gray-400 hover:text-white font-semibold px-6 py-3 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection