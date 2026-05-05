@extends('layouts.admin')
@section('title', 'Edit Game')
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.games.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">
        &larr; Back to Games
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

    <form method="POST" action="{{ route('admin.games.update', $game) }}"
        class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-400 mb-1">Game Name</label>
            <input type="text" name="name" value="{{ old('name', $game->name) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Platform</label>
            <select name="platform" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                <option value="pc" {{ old('platform', $game->platform) == 'pc' ? 'selected' : '' }}>PC</option>
                <option value="mobile" {{ old('platform', $game->platform) == 'mobile' ? 'selected' : '' }}>Mobile</option>
                <option value="console" {{ old('platform', $game->platform) == 'console' ? 'selected' : '' }}>Console</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Logo URL <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="logo_url" value="{{ old('logo_url', $game->logo_url) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg text-sm transition">
                Update Game
            </button>
        </div>
    </form>
</div>
@endsection