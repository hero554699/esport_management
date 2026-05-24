@extends('layouts.public')
@section('title', 'Create Team — EsportsTrack')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Create Team</h1>
        <p class="text-gray-400 text-sm mt-2">Build your esports team</p>
    </div>

    @if($errors->any())
    <div class="bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg mb-6">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-8">
        <form method="POST" action="{{ route('user.teams.store') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-white mb-2">Team Name *</label>
                <input type="text" name="name" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                    value="{{ old('name') }}"
                    placeholder="e.g. Team Bayani" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Tag / Abbreviation</label>
                    <input type="text" name="tag" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition"
                        value="{{ old('tag') }}"
                        placeholder="e.g. TBY" maxlength="10">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Country</label>
                    <select name="country" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition">
                        <option value="">Select country...</option>
                        @foreach(config('countries') as $code => $name)
                        <option value="{{ $name }}" {{ old('country') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-white mb-2">Game *</label>
                <select name="game_id" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 transition" required>
                    <option value="">Select a game...</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-white mb-3">Team Logo</label>

                <div class="flex gap-2 mb-4">
                    <button type="button" id="btn-url"
                        onclick="switchLogoMode('url')"
                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-lg transition">
                        Image URL
                    </button>
                    <button type="button" id="btn-file"
                        onclick="switchLogoMode('file')"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-400 text-sm font-medium rounded-lg transition">
                        Upload File
                    </button>
                </div>

                <div id="logo-url-input">
                    <input type="url" name="logo_url"
                        value="{{ old('logo_url') }}"
                        placeholder="https://example.com/logo.png"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 transition mb-2">
                    <p class="text-xs text-gray-500">Paste a direct image link</p>
                </div>

                <div id="logo-file-input" class="hidden">
                    <input type="file" name="logo_file" accept="image/*"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-orange-500 transition file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-orange-500 file:text-white hover:file:bg-orange-600 mb-2">
                    <p class="text-xs text-gray-500">Upload JPG, PNG or GIF (max 2MB)</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Create Team
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 text-center border border-gray-700 hover:border-gray-600 text-gray-400 hover:text-white font-semibold px-6 py-3 rounded-lg transition">
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
            btnUrl.classList.add('bg-orange-500');
            btnUrl.classList.remove('bg-gray-700');
            btnFile.classList.remove('bg-orange-500');
            btnFile.classList.add('bg-gray-700');
        } else {
            fileInput.classList.remove('hidden');
            urlInput.classList.add('hidden');
            btnFile.classList.add('bg-orange-500');
            btnFile.classList.remove('bg-gray-700');
            btnUrl.classList.remove('bg-orange-500');
            btnUrl.classList.add('bg-gray-700');
        }
    }
</script>
@endsection