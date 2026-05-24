@extends('layouts.public')
@section('title', 'Create Team')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-white mb-2">Create Team</h1>
        <p class="text-gray-400 mb-8">Build your esports team profile</p>

        @if($errors->any())
        <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('user.teams.store') }}" enctype="multipart/form-data"
            class="bg-gray-800 border border-gray-700 rounded-xl p-8">
            @csrf

            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Team Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white placeholder-gray-500 focus:border-orange-500 outline-none @error('name') border-red-500 @enderror"
                    placeholder="e.g. Team Bayani" required>
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-white font-semibold mb-2">Tag / Abbreviation</label>
                    <input type="text" name="tag" value="{{ old('tag') }}" maxlength="10"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white placeholder-gray-500 focus:border-orange-500 outline-none @error('tag') border-red-500 @enderror"
                        placeholder="e.g. TBY">
                    @error('tag') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-white font-semibold mb-2">Country</label>
                    <select name="country"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:border-orange-500 outline-none @error('country') border-red-500 @enderror">
                        <option value="">Select country...</option>
                        @foreach(config('countries') as $code => $name)
                        <option value="{{ $name }}" {{ old('country') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                    @error('country') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Game</label>
                <select name="game_id"
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:border-orange-500 outline-none @error('game_id') border-red-500 @enderror">
                    <option value="">Select a game...</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->name }}
                    </option>
                    @endforeach
                </select>
                @error('game_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-white font-semibold mb-2">Team Logo</label>

                <div class="flex gap-2 mb-3">
                    <button type="button" id="btn-url" onclick="switchLogoMode('url')"
                        class="px-3 py-1.5 text-xs rounded-lg bg-orange-500 text-white transition">Image URL</button>
                    <button type="button" id="btn-file" onclick="switchLogoMode('file')"
                        class="px-3 py-1.5 text-xs rounded-lg bg-gray-700 text-gray-400 transition">Upload File</button>
                </div>

                <div id="logo-url-input">
                    <input type="url" name="logo_url" value="{{ old('logo_url') }}"
                        placeholder="https://example.com/logo.png"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white placeholder-gray-500 focus:border-orange-500 outline-none @error('logo_url') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Paste a direct image link</p>
                    @error('logo_url') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="logo-file-input" class="hidden">
                    <input type="file" name="logo_file" accept="image/*"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white text-sm focus:border-orange-500 outline-none file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-orange-500 file:text-white hover:file:bg-orange-600 @error('logo_file') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Upload JPG, PNG or GIF (max 2MB)</p>
                    @error('logo_file') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition">
                    Create Team
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 border border-gray-600 text-white px-6 py-3 rounded-xl hover:border-gray-500 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function switchLogoMode(mode) {
        const urlInput = document.getElementById('logo-url-input');
        const fileInput = document.getElementById('logo-file-input');
        const btnUrl = document.getElementById('btn-url');
        const btnFile = document.getElementById('btn-file');

        if (mode === 'url') {
            urlInput.classList.remove('hidden');
            fileInput.classList.add('hidden');
            btnUrl.classList.replace('bg-gray-700', 'bg-orange-500');
            btnUrl.classList.replace('text-gray-400', 'text-white');
            btnFile.classList.replace('bg-orange-500', 'bg-gray-700');
            btnFile.classList.replace('text-white', 'text-gray-400');
        } else {
            fileInput.classList.remove('hidden');
            urlInput.classList.add('hidden');
            btnFile.classList.replace('bg-gray-700', 'bg-orange-500');
            btnFile.classList.replace('text-gray-400', 'text-white');
            btnUrl.classList.replace('bg-orange-500', 'bg-gray-700');
            btnUrl.classList.replace('text-white', 'text-gray-400');
        }
    }
</script>
@endsection
