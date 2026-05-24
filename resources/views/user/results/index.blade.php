@extends('layouts.public')
@section('title', 'Results')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('user.events.matches.show', [$match->event, $match]) }}" class="text-gray-400 text-sm">← Back to Match</a>
        <a href="{{ route('user.matches.results.create', $match) }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">+ Record Result</a>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        @forelse($results as $result)
        <div class="px-5 py-4 border-b border-gray-800 flex justify-between items-center">
            <div>
                <p class="text-white">Winner: {{ $result->winner?->name }}</p>
                <p class="text-xs text-gray-500">Score: {{ $result->score_a }} - {{ $result->score_b }} @if($result->mvp)• MVP: {{ $result->mvp->nickname }}@endif</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('user.matches.results.show', [$match, $result]) }}" class="text-blue-400">View</a>
                <a href="{{ route('user.matches.results.edit', [$match, $result]) }}" class="text-orange-400">Edit</a>
                <form method="POST" action="{{ route('user.matches.results.destroy', [$match, $result]) }}" onsubmit="return confirm('Delete result?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-5 py-8 text-gray-500 text-sm">No result recorded yet.</div>
        @endforelse
    </div>
</div>
@endsection
