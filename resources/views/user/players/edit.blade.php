@extends('layouts.public')
@section('title', 'Edit Player')
@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <a href="{{ route('user.teams.show', $team) }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition mb-4 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Team
            </a>
            <h1 class="text-3xl font-bold text-white">Edit Player</h1>
            <p class="text-gray-400 mt-2">Update player information</p>
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
            <form method="POST" action="{{ route('user.teams.players.update', [$team, $player]) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nickname (Required) -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Nickname *</label>
                    <input type="text" name="nickname" value="{{ old('nickname', $player->nickname) }}"
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
                        <input type="text" name="real_name" value="{{ old('real_name', $player->real_name) }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="Full name">
                        @error('real_name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Role</label>
                        <input type="text" name="role" value="{{ old('role', $player->role) }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="e.g. Mid, ADC, Support">
                        @error('role')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Country Dropdown -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Country</label>
                    <select name="country" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition">
                        <option value="">Select country...</option>
                        @foreach(config('countries') as $code => $name)
                        <option value="{{ $name }}" {{ old('country', $player->country) == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                    @error('country')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Avatar URL -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-3">Player Avatar</label>

                    <div class="flex gap-2 mb-4">
                        <button type="button" id="btn-url"
                            onclick="switchAvatarMode('url')"
                            class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition">
                            Image URL
                        </button>
                        <button type="button" id="btn-upload"
                            onclick="switchAvatarMode('upload')"
                            class="px-4 py-2 bg-gray-700 text-gray-300 font-semibold rounded-lg hover:bg-gray-600 transition">
                            Upload File
                        </button>
                    </div>

                    <!-- URL Input -->
                    <div id="avatar-url-section" class="block">
                        <input type="url" name="avatar_url" id="avatar_url" value="{{ old('avatar_url', $player->avatar_url) }}"
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                            placeholder="https://example.com/avatar.jpg">
                        <p class="text-gray-500 text-xs mt-2">Paste a direct image link</p>
                        @error('avatar_url')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div id="avatar-upload-section" class="hidden">
                        <div class="border-2 border-dashed border-gray-700 rounded-lg px-4 py-8 text-center hover:border-orange-500 transition cursor-pointer"
                            onclick="document.getElementById('avatar_file').click()">
                            <svg class="w-8 h-8 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-400 text-sm">Click to upload or drag file here</p>
                            <p class="text-gray-500 text-xs mt-1">PNG, JPG, GIF up to 10MB</p>
                        </div>
                        <input type="file" id="avatar_file" name="avatar_file" class="hidden" accept="image/*">
                        @error('avatar_file')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-6">
                    <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                        Update Player
                    </button>
                    <a href="{{ route('user.teams.show', $team) }}" class="flex-1 border border-gray-700 text-gray-300 font-semibold py-3 rounded-lg hover:border-gray-500 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function switchAvatarMode(mode) {
        const urlSection = document.getElementById('avatar-url-section');
        const uploadSection = document.getElementById('avatar-upload-section');
        const btnUrl = document.getElementById('btn-url');
        const btnUpload = document.getElementById('btn-upload');

        if (mode === 'url') {
            urlSection.classList.remove('hidden');
            uploadSection.classList.add('hidden');
            btnUrl.classList.add('bg-orange-500');
            btnUrl.classList.remove('bg-gray-700', 'text-gray-300');
            btnUpload.classList.remove('bg-orange-500');
            btnUpload.classList.add('bg-gray-700', 'text-gray-300');
        } else {
            urlSection.classList.add('hidden');
            uploadSection.classList.remove('hidden');
            btnUpload.classList.add('bg-orange-500');
            btnUpload.classList.remove('bg-gray-700', 'text-gray-300');
            btnUrl.classList.remove('bg-orange-500');
            btnUrl.classList.add('bg-gray-700', 'text-gray-300');
        }
    }
</script>

@endsection