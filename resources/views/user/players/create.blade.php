@extends('layouts.public')
@section('title', 'Add Player — EsportsTrack')
@section('content')

<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <a href="{{ route('user.teams.players.index', $team) }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition mb-4 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to {{ $team->name }}
            </a>
            <h1 class="text-3xl font-bold text-white">Add Player</h1>
            <p class="text-gray-400 mt-2">Add a new player to your team</p>
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
            <form method="POST" action="{{ route('user.teams.players.store', $team) }}" class="space-y-6">
                @csrf

                <!-- Nickname (Required) -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Nickname *</label>
                    <input type="text" name="nickname" value="{{ old('nickname') }}"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                        placeholder="e.g. Faker, Uzi, Simple" required>
                    @error('nickname')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Two Column Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Real Name -->
                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Real Name</label>
                        <input type="text" name="real_name" value="{{ old('real_name') }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="Full name">
                        @error('real_name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Role</label>
                        <input type="text" name="role" value="{{ old('role') }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="e.g. Mid, ADC, Support">
                        @error('role')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Country</label>
                    <input type="text" name="country" value="{{ old('country') }}"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                        placeholder="e.g. South Korea, China">
                    @error('country')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Avatar URL -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Avatar URL</label>
                    <input type="url" name="avatar_url" value="{{ old('avatar_url') }}"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                        placeholder="https://example.com/avatar.jpg">
                    <p class="text-gray-600 text-xs mt-1">Paste a direct image link</p>
                    @error('avatar_url')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-gray-700">
                    <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Player
                    </button>
                    <a href="{{ route('user.teams.players.index', $team) }}"
                        class="flex-1 text-center border border-gray-700 hover:border-gray-600 text-gray-400 hover:text-white font-semibold px-6 py-3 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection