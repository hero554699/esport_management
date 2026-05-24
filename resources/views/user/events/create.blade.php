@extends('layouts.public')
@section('title', 'Create Tournament')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-white mb-2">Create Tournament</h1>
        <p class="text-gray-400 mb-8">Submit a new tournament for admin approval</p>

        <form action="{{ route('user.events.store') }}" method="POST" class="bg-gray-800 border border-gray-700 rounded-xl p-8">
            @csrf

            <!-- Tournament Name -->
            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Tournament Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white placeholder-gray-500 focus:border-orange-500 outline-none @error('name') border-red-500 @enderror"
                    placeholder="e.g., CounterStrike Open 2024" required>
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Game Selection -->
            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Game *</label>
                <select name="game_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:border-orange-500 outline-none @error('game_id') border-red-500 @enderror" required>
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                    @endforeach
                </select>
                @error('game_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Type -->
            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Tournament Type *</label>
                <select name="type" class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:border-orange-500 outline-none @error('type') border-red-500 @enderror" required>
                    <option value="">Select type</option>
                    <option value="local" {{ old('type') == 'local' ? 'selected' : '' }}>Local</option>
                    <option value="national" {{ old('type') == 'national' ? 'selected' : '' }}>National</option>
                    <option value="international" {{ old('type') == 'international' ? 'selected' : '' }}>International</option>
                    <option value="world" {{ old('type') == 'world' ? 'selected' : '' }}>World</option>
                </select>
                @error('type') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-white font-semibold mb-2">Start Date *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:border-orange-500 outline-none @error('start_date') border-red-500 @enderror"
                        required>
                    <p class="text-gray-500 text-xs mt-1">⚠️ Cannot be in the past</p>
                    @error('start_date') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-white font-semibold mb-2">End Date *</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:border-orange-500 outline-none @error('end_date') border-red-500 @enderror"
                        required>
                    <p class="text-gray-500 text-xs mt-1">Must be after start date</p>
                    @error('end_date') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Prize Pool -->
            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Prize Pool (Optional)</label>
                <input type="text" name="prize_pool" value="{{ old('prize_pool') }}"
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white placeholder-gray-500 focus:border-orange-500 outline-none"
                    placeholder="e.g., $10,000">
                @error('prize_pool') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition">
                    Submit for Approval
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 border border-gray-600 text-white px-6 py-3 rounded-xl hover:border-gray-500 transition text-center">
                    Cancel
                </a>
            </div>

            <!-- Info -->
            <div class="mt-6 bg-orange-500/10 border border-orange-500/30 rounded-lg p-4 text-orange-300 text-sm">
                <strong>ℹ️ Note:</strong> Your tournament will be reviewed by admins before appearing on the public site.
            </div>
        </form>
    </div>
</div>
@endsection