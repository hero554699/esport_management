@extends('layouts.public')
@section('title', 'Result Details')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <a href="{{ route('user.matches.results.index', $match) }}" class="text-gray-400 text-sm">← Back to Results</a>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4">
        <h1 class="text-xl font-bold">Result</h1>
        <p class="text-gray-400 mt-2">Winner: {{ $result->winner?->name }}</p>
        <p class="text-gray-400">Score: {{ $result->score_a }} - {{ $result->score_b }}</p>
        <p class="text-gray-400">MVP: {{ $result->mvp?->nickname ?? 'N/A' }}</p>
        <p class="text-gray-500 text-sm mt-2">{{ $result->notes }}</p>
        <a href="{{ route('user.matches.results.edit', [$match, $result]) }}" class="text-orange-400 text-sm mt-4 inline-block">Edit Result</a>
    </div>
</div>
@endsection
