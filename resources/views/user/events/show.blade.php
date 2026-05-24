@extends('layouts.public')
@section('title', $event->name . ' — EsportsTrack')
@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">
    <a href="{{ route('user.events.index') }}" class="text-gray-400 hover:text-orange-500 text-sm transition mb-6 inline-block">← Back to Tournaments</a>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <h1 class="text-xl font-bold text-white">{{ $event->name }}</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $event->teamA?->name }} vs {{ $event->teamB?->name }} • {{ ucfirst($event->approval_status) }}</p>
        <div class="mt-4 flex gap-3 text-sm">
            <a href="{{ route('user.events.matches.index', $event) }}" class="text-orange-400">Manage Matches</a>
            <a href="{{ route('user.events.matches.create', $event) }}" class="text-blue-400">Schedule Match</a>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-800 font-semibold">Matches</div>
        @forelse($event->matches->sortBy('scheduled_at') as $match)
        <div class="px-5 py-4 border-b border-gray-800/80 flex items-center justify-between">
            <div>
                <p class="text-sm text-white">{{ $match->teamA?->name }} vs {{ $match->teamB?->name }}</p>
                <p class="text-xs text-gray-500">{{ $match->stage }} • {{ strtoupper($match->status) }} • {{ optional($match->scheduled_at)->format('M d, Y H:i') }}</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.events.matches.show', [$event, $match]) }}" class="text-blue-400">View</a>
                <a href="{{ route('user.events.matches.edit', [$event, $match]) }}" class="text-orange-400">Edit</a>
                <a href="{{ route('user.matches.results.index', $match) }}" class="text-green-400">Results</a>
            </div>
        </div>
        @empty
        <div class="px-5 py-6 text-sm text-gray-500">No matches scheduled yet.</div>
        @endforelse
    </div>
</div>
@endsection
