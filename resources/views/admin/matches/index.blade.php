@extends('layouts.admin')
@section('title', 'Matches')
@section('content')

@if(session('success'))
<div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Matches</h2>
    <a href="{{ route('admin.matches.create') }}"
        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Match
    </a>
</div>

<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Teams</th>
                <th class="px-4 py-3">Event</th>
                <th class="px-4 py-3">Stage</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Scheduled</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($matches as $match)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                <td class="px-4 py-3 font-medium">
                    {{ $match->teamA->name }}
                    <span class="text-orange-500 mx-1">vs</span>
                    {{ $match->teamB->name }}
                </td>
                <td class="px-4 py-3 text-gray-400">{{ $match->event->name }}</td>
                <td class="px-4 py-3">
                    <span class="bg-gray-800 text-gray-300 px-2 py-1 rounded text-xs capitalize">{{ $match->stage }}</span>
                </td>
                <td class="px-4 py-3">
                    @if($match->status === 'live')
                    <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-full text-xs">LIVE</span>
                    @elseif($match->status === 'upcoming')
                    <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs">UPCOMING</span>
                    @else
                    <span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full text-xs">COMPLETED</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-400">
                    {{ \Carbon\Carbon::parse($match->scheduled_at)->format('M d, Y H:i') }}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.matches.edit', $match) }}"
                            class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                        <form method="POST" action="{{ route('admin.matches.destroy', $match) }}"
                            onsubmit="return confirm('Delete this match?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No matches found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection