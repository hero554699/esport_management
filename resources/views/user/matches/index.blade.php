@extends('layouts.public')
@section('title', 'Matches — ' . $event->name)
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('user.events.show', $event) }}" class="text-gray-400 text-sm">← Back to Tournament</a>
        <a href="{{ route('user.events.matches.create', $event) }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">+ Add Match</a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        @forelse($matches as $match)
        <div class="px-5 py-4 border-b border-gray-800 flex justify-between items-center">
            <div>
                <p class="text-white">{{ $match->teamA?->name }} vs {{ $match->teamB?->name }}</p>
                <p class="text-xs text-gray-500">{{ $match->stage }} • {{ strtoupper($match->status) }} • {{ optional($match->scheduled_at)->format('M d, Y H:i') }}</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.events.matches.edit', [$event, $match]) }}" class="text-orange-400">Edit</a>
                <a href="{{ route('user.matches.results.index', $match) }}" class="text-green-400">Results</a>
                <form method="POST" action="{{ route('user.events.matches.destroy', [$event, $match]) }}" onsubmit="return confirm('Delete match?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-5 py-8 text-gray-500 text-sm">No matches found.</div>
        @endforelse
    </div>
</div>
@endsection