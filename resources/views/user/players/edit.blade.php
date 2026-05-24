@extends('layouts.public')
@section('title', 'Edit Player')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <a href="{{ route('user.teams.players.index', $team) }}" class="text-gray-400 text-sm">← Back to Players</a>
    <form method="POST" action="{{ route('user.teams.players.update', [$team, $player]) }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4 space-y-4">
        @csrf
        @method('PUT')
        <h1 class="text-lg font-bold">Edit Player</h1>
        <input type="text" name="nickname" value="{{ old('nickname', $player->nickname) }}" placeholder="Nickname" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2" required>
        <input type="text" name="real_name" value="{{ old('real_name', $player->real_name) }}" placeholder="Real name" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
        <input type="text" name="role" value="{{ old('role', $player->role) }}" placeholder="Role" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
        <input type="text" name="country" value="{{ old('country', $player->country) }}" placeholder="Country" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
        <input type="url" name="avatar_url" value="{{ old('avatar_url', $player->avatar_url) }}" placeholder="Avatar URL" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
        <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">Update Player</button>
    </form>
</div>
@endsection
