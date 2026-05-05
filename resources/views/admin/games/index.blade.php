@extends('layouts.admin')
@section('title', 'Games')
@section('content')

@if(session('success'))
<div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Games</h2>
    <a href="{{ route('admin.games.create') }}"
        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Game
    </a>
</div>

<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Platform</th>
                <th class="px-4 py-3">Teams</th>
                <th class="px-4 py-3">Events</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                <td class="px-4 py-3 font-medium">{{ $game->name }}</td>
                <td class="px-4 py-3">
                    @if($game->platform === 'pc')
                    <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full text-xs">PC</span>
                    @elseif($game->platform === 'mobile')
                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">Mobile</span>
                    @else
                    <span class="bg-purple-500/20 text-purple-400 px-2 py-1 rounded-full text-xs">Console</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-400">{{ $game->teams_count }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $game->events_count }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.games.edit', $game) }}"
                            class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                        <form method="POST" action="{{ route('admin.games.destroy', $game) }}"
                            onsubmit="return confirm('Delete this game?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No games found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection