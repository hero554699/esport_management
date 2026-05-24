@extends('layouts.public')
@section('title', 'My Teams')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">My Teams</h1>
        <a href="{{ route('user.teams.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">+ Create Team</a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="space-y-3">
        @forelse($teams as $team)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex justify-between items-center">
            <div>
                <p class="font-semibold text-white">{{ $team->name }}</p>
                <p class="text-xs text-gray-500">{{ $team->players_count }} players • {{ $team->game?->name ?? 'No game' }}</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.teams.show', $team) }}" class="text-orange-400">Manage</a>
                <a href="{{ route('user.teams.edit', $team) }}" class="text-blue-400">Edit</a>
                <form method="POST" action="{{ route('user.teams.destroy', $team) }}" onsubmit="return confirm('Delete this team?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 text-center text-gray-500">No teams yet.</div>
        @endforelse
    </div>
</div>
@endsection
