@extends('layouts.admin')
@section('title', 'Players')
@section('content')

@if(session('success'))
<div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Players</h2>
    <a href="{{ route('admin.players.create') }}"
        class="bg-green-500 hover:bg-green-400 text-black font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Player
    </a>
</div>

<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Username</th>
                <th class="px-4 py-3">Real Name</th>
                <th class="px-4 py-3">Team</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Country</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($players as $player)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                <td class="px-4 py-3 font-medium text-green-400">{{ $player->username }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $player->real_name ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $player->team->name }}</td>
                <td class="px-4 py-3">
                    @if($player->role)
                    <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full text-xs">{{ $player->role }}</span>
                    @else
                    <span class="text-gray-600">—</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-400">{{ $player->country ?? '—' }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.players.edit', $player) }}"
                            class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                        <form method="POST" action="{{ route('admin.players.destroy', $player) }}"
                            onsubmit="return confirm('Delete this player?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No players found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection