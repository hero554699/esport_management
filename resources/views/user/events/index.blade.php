@extends('layouts.public')
@section('title', 'My Tournaments')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">My Tournaments</h1>
        <a href="{{ route('user.events.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">+ Create Tournament</a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="space-y-3">
        @forelse($events as $event)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex justify-between items-center">
            <div>
                <p class="font-semibold text-white">{{ $event->name }}</p>
                <p class="text-xs text-gray-500">{{ $event->teamA?->name }} vs {{ $event->teamB?->name }} • {{ ucfirst($event->approval_status) }} • {{ $event->matches_count }} matches</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.events.show', $event) }}" class="text-orange-400">Manage</a>
                <a href="{{ route('user.events.edit', $event) }}" class="text-blue-400">Edit</a>
                <form method="POST" action="{{ route('user.events.destroy', $event) }}" onsubmit="return confirm('Delete this tournament?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 text-center text-gray-500">No tournaments yet.</div>
        @endforelse
    </div>
</div>
@endsection
