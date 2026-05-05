@extends('layouts.admin')
@section('title', 'Edit Team')
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.teams.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">
        &larr; Back to Teams
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

    <form method="POST" action="{{ route('admin.teams.update', $team) }}"
        class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-400 mb-1">Team Name</label>
            <input type="text" name="name" value="{{ old('name', $team->name) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Tag</label>
            <input type="text" name="tag" value="{{ old('tag', $team->tag) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Game</label>
            <select name="game_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
                @foreach($games as $game)
                <option value="{{ $game->id }}" {{ old('game_id', $team->game_id) == $game->id ? 'selected' : '' }}>
                    {{ $game->name }} ({{ $game->platform }})
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Organization <span class="text-gray-600">(optional)</span></label>
            <select name="organization_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
                <option value="">No organization</option>
                @foreach($organizations as $org)
                <option value="{{ $org->id }}" {{ old('organization_id', $team->organization_id) == $org->id ? 'selected' : '' }}>
                    {{ $org->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Country</label>
            <input type="text" name="country" value="{{ old('country', $team->country) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Logo URL <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="logo_url" value="{{ old('logo_url', $team->logo_url) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="bg-green-500 hover:bg-green-400 text-black font-semibold px-6 py-2 rounded-lg text-sm transition">
                Update Team
            </button>
        </div>
    </form>
</div>
@endsection