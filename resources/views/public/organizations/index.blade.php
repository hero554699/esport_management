@extends('layouts.public')
@section('title', 'Organizations — EsportsTrack')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Organizations</h1>
        <p class="text-gray-400 text-sm mt-1">Esports organizations tracked on EsportsTrack</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($organizations as $org)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/50 transition">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-white">{{ $org->name }}</h3>
                    <p class="text-gray-500 text-xs mt-0.5">{{ $org->country ?? 'Unknown' }}</p>
                </div>
                <span class="text-xs text-orange-500">{{ $org->teams_count }} teams</span>
            </div>
            @if($org->website)
            <a href="{{ $org->website }}" target="_blank"
                class="text-xs text-gray-500 hover:text-orange-500 transition mt-2 inline-block">
                Visit website →
            </a>
            @endif
        </div>
        @empty
        <div class="col-span-3 text-center py-20 text-gray-500">No organizations found.</div>
        @endforelse
    </div>
</div>
@endsection