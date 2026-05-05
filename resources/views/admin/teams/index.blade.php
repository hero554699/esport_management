@extends('layouts.admin')
@section('title', 'Teams')
@section('content')

@if(session('success'))
<div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Teams</h2>
    <a href="{{ route('admin.teams.create') }}"
        class="bg-green-500 hover:bg-green-400 text-black font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Team
    </a>
</div>

<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Tag</th>
                <th class="px-4 py-3">Game</th>
                <th class="px-4 py-3">Organization</th>
                <th class="px-4 py-3">Country</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teams as $team)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                <td class="px-4 py-3 font-medium">{{ $team->name }}</td>
                <td class="px-4 py-3">
                    <span class="bg-gray-800 text-gray-300 px-2 py-1 rounded text-xs font-mono">{{ $team->tag }}</span>
                </td>
                <td class="px-4 py-3 text-gray-400">{{ $team->game->name }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $team->organization->name ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $team->country ?? '—' }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.teams.edit', $team) }}"
                            class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                        <form method="POST" action="{{ route('admin.teams.destroy', $team) }}"
                            onsubmit="return confirm('Delete this team?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No teams found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection