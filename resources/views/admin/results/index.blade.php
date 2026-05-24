@extends('layouts.admin')
@section('title', 'Results')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Results</h2>
    <a href="{{ route('admin.results.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm">+ Add Result</a>
</div>

<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Match</th>
                <th class="px-4 py-3">Score</th>
                <th class="px-4 py-3">Winner</th>
                <th class="px-4 py-3">MVP</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $result)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50">
                <td class="px-4 py-3">{{ $result->match?->teamA?->name }} vs {{ $result->match?->teamB?->name }}</td>
                <td class="px-4 py-3">{{ $result->score_a }} - {{ $result->score_b }}</td>
                <td class="px-4 py-3">{{ $result->winner?->name }}</td>
                <td class="px-4 py-3">{{ $result->mvp?->nickname ?? 'N/A' }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.results.show', $result) }}" class="text-blue-400 text-xs">View</a>
                        <a href="{{ route('admin.results.edit', $result) }}" class="text-orange-400 text-xs">Edit</a>
                        <form method="POST" action="{{ route('admin.results.destroy', $result) }}" onsubmit="return confirm('Delete result?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 text-xs">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No results found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
