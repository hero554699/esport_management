@extends('layouts.admin')
@section('title', 'Edit Player')
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.players.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">
        &larr; Back to Players
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

    <form method="POST" action="{{ route('admin.players.update', $player) }}"
        class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-400 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username', $player->username) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Real Name <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="real_name" value="{{ old('real_name', $player->real_name) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Team</label>
            <select name="team_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
                @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>
                    {{ $team->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Role <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="role" value="{{ old('role', $player->role) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Country <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="country" value="{{ old('country', $player->country) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Avatar URL <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="avatar_url" value="{{ old('avatar_url', $player->avatar_url) }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="bg-green-500 hover:bg-green-400 text-black font-semibold px-6 py-2 rounded-lg text-sm transition">
                Update Player
            </button>
        </div>
    </form>
</div>
@endsection