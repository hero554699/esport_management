@extends('layouts.admin')
@section('title', 'Result Details')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.results.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">&larr; Back to Results</a>
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-2">
        <h2 class="text-lg font-semibold">{{ $result->match?->teamA?->name }} vs {{ $result->match?->teamB?->name }}</h2>
        <p class="text-gray-400 text-sm">Winner: {{ $result->winner?->name }}</p>
        <p class="text-gray-400 text-sm">Score: {{ $result->score_a }} - {{ $result->score_b }}</p>
        <p class="text-gray-400 text-sm">MVP: {{ $result->mvp?->nickname ?? 'N/A' }}</p>
        <p class="text-gray-500 text-sm">Notes: {{ $result->notes ?? 'N/A' }}</p>
    </div>
</div>
@endsection
