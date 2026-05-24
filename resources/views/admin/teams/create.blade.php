@extends('layouts.admin')
@section('title', 'Add Team — EsportsTrack Admin')
@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('admin.teams.index') }}" class="text-gray-400 hover:text-white text-sm transition inline-flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Teams
        </a>
        <h1 class="text-3xl font-bold text-white">Create Team</h1>
        <p class="text-gray-400 text-sm mt-2">Add a new esports team to the system</p>
    </div>

    @if($errors->any())
    <div class="bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl p-8">
        <form method="POST" action="{{ route('admin.teams.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Team Name -->
            <div>
                <label class="block text-sm font-semibold text-white mb-2">Team Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-green-500 transition"
                    placeholder="e.g. ECHO MLBB" required>
                @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tag & Country Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Tag / Abbreviation</label>
                    <input type="text" name="tag" value="{{ old('tag') }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-green-500 transition"
                        placeholder="e.g. ECHO" maxlength="10">
                    <p class="text-gray-600 text-xs mt-1">Max 10 characters</p>
                    @error('tag')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Country</label>
                    <select name="country" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-green-500 transition">
                        <option value="">Select country...</option>
                        @foreach(config('countries') as $code => $name)
                        <option value="{{ $name }}" {{ old('country') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                    @error('country')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Game -->
            <div>
                <label class="block text-sm font-semibold text-white mb-2">Game *</label>
                <select name="game_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-green-500 transition" required>
                    <option value="">Select a game...</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->name }}
                    </option>
                    @endforeach
                </select>
                @error('game_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Organization -->
            <div>
                <label class="block text-sm font-semibold text-white mb-2">Organization <span class="text-gray-500">(Optional)</span></label>
                <select name="organization_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-green-500 transition">
                    <option value="">No organization</option>
                    @foreach($organizations as $org)
                    <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                        {{ $org->name }}
                    </option>
                    @endforeach
                </select>
                @error('organization_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Team Logo -->
            <div>
                <label class="block text-sm font-semibold text-white mb-3">Team Logo</label>

                <div class="flex gap-2 mb-4">
                    <button type="button" id="btn-url"
                        onclick="switchLogoMode('url')"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition">
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
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-green-500 transition mb-2">
                    <p class="text-xs text-gray-500">Paste a direct image link</p>
                </div>

                <div id="logo-file-input" class="hidden">
                    <input type="file" name="logo_file" accept="image/*"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 transition file:mr-3 file:py-1 file:px-3 file:bg-green-500 file:text-white file:border-0 file:rounded file:cursor-pointer hover:file:bg-green-600">
                    <p class="text-xs text-gray-500 mt-2">Upload JPG, PNG or GIF (max 2MB)</p>
                </div>

                @error('logo_url')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('logo_file')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-800">
                <button type="submit"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Create Team
                </button>
                <a href="{{ route('admin.teams.index') }}"
                    class="flex-1 text-center border border-gray-700 hover:border-gray-600 text-gray-400 hover:text-white font-semibold px-6 py-3 rounded-lg transition">
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
            btnUrl.classList.add('bg-green-500');
            btnUrl.classList.remove('bg-gray-700');
            btnFile.classList.remove('bg-green-500');
            btnFile.classList.add('bg-gray-700');
        } else {
            fileInput.classList.remove('hidden');
            urlInput.classList.add('hidden');
            btnFile.classList.add('bg-green-500');
            btnFile.classList.remove('bg-gray-700');
            btnUrl.classList.remove('bg-green-500');
            btnUrl.classList.add('bg-gray-700');
        }
    }
</script>
@endsection