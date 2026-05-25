@extends('layouts.admin')
@section('title', $event->name)

@section('content')
<button onclick="window.history.back()"
    class="text-gray-400 hover:text-orange-500 text-sm font-medium mb-6 inline-flex items-center gap-1">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
</button>

<div class="mb-8">
    <div class="flex items-start justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-3xl font-bold text-white">{{ $event->name }}</h1>
                @if($event->approval_status === 'pending')
                <span class="bg-yellow-500/20 text-yellow-400 text-sm px-3 py-1 rounded-full font-medium">PENDING</span>
                @elseif($event->approval_status === 'approved')
                <span class="bg-green-500/20 text-green-400 text-sm px-3 py-1 rounded-full font-medium">APPROVED</span>
                @else
                <span class="bg-red-500/20 text-red-400 text-sm px-3 py-1 rounded-full font-medium">REJECTED</span>
                @endif
            </div>
            <p class="text-gray-400 text-sm">Created by: <strong>{{ $event->user?->name ?? 'Admin' }}</strong></p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.edit', $event) }}"
                class="text-orange-400 hover:text-orange-300 font-semibold text-sm">
                Edit Event
            </a>
        </div>
    </div>
</div>

{{-- Tournament Info Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
        <p class="text-gray-500 text-xs mb-1">Game</p>
        <p class="text-white font-semibold">{{ $event->game->name ?? 'N/A' }}</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
        <p class="text-gray-500 text-xs mb-1">Type</p>
        <p class="text-orange-400 font-semibold uppercase">{{ $event->type }}</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
        <p class="text-gray-500 text-xs mb-1">Matches</p>
        <p class="text-white font-semibold">{{ $matches->count() }}</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
        <p class="text-gray-500 text-xs mb-1">Prize Pool</p>
        <p class="text-orange-500 font-semibold">{{ $event->prize_pool ?? 'N/A' }}</p>
    </div>
</div>

{{-- Certification Status --}}
@if($event->hasCertification())
<div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 mb-8 flex items-center gap-3">
    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    <div>
        <p class="text-green-400 font-semibold text-sm">Certification Verified</p>
        <p class="text-green-300 text-xs">{{ basename($event->certification_path) }}</p>
    </div>
</div>
@endif

{{-- Rejection Reason --}}
@if($event->approval_status === 'rejected' && $event->rejection_reason)
<div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-8">
    <p class="text-red-400 font-semibold text-sm">Rejection Reason</p>
    <p class="text-red-300 text-sm mt-1">{{ $event->rejection_reason }}</p>
</div>
@endif

{{-- Approval Actions --}}
@if($event->approval_status === 'pending' && $event->user_id)
<div class="bg-orange-500/10 border border-orange-500/30 rounded-xl p-4 mb-8">
    <p class="text-orange-400 font-semibold text-sm mb-4">Approval Actions</p>
    <div class="flex items-center gap-2">
        {{-- Approve --}}
        <form method="POST" action="{{ route('admin.events.approve', $event) }}" class="inline">
            @csrf
            <button type="submit"
                class="bg-green-500/20 hover:bg-green-500/30 text-green-400 text-sm
                       font-semibold px-4 py-2 rounded-lg transition border border-green-500/30">
                ✓ Approve Tournament
            </button>
        </form>

        {{-- Reject --}}
        <button onclick="document.getElementById('rejectForm').classList.toggle('hidden')"
            class="bg-red-500/20 hover:bg-red-500/30 text-red-400 text-sm
                   font-semibold px-4 py-2 rounded-lg transition border border-red-500/30">
            ✕ Reject Tournament
        </button>
    </div>

    {{-- Reject form --}}
    <div id="rejectForm" class="hidden mt-4 pt-4 border-t border-orange-500/30">
        <form method="POST" action="{{ route('admin.events.reject', $event) }}">
            @csrf
            <div class="flex gap-2">
                <input type="text" name="rejection_reason" required
                    placeholder="Reason for rejection..."
                    class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2
                              text-white text-sm focus:outline-none focus:border-red-500 transition">
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold
                           px-4 py-2 rounded-lg transition whitespace-nowrap">
                    Send Rejection
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Matches Section --}}
<div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Matches ({{ $matches->count() }})</h2>
    </div>

    @if($matches->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-400">No matches scheduled for this tournament.</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($matches->sortBy('scheduled_at') as $match)
        <div class="bg-gray-800 border border-gray-700 hover:border-orange-500/40 rounded-xl p-5 transition">
            <div class="flex items-center justify-between gap-4">
                {{-- Match Info --}}
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <h3 class="text-white font-semibold">
                            {{ $match->teamA->name ?? 'TBD' }}
                            <span class="text-gray-500">vs</span>
                            {{ $match->teamB->name ?? 'TBD' }}
                        </h3>
                        @if($match->result)
                        <span class="bg-green-500/20 text-green-400 text-xs px-2 py-0.5 rounded">Completed</span>
                        @elseif($match->status === 'live')
                        <span class="bg-red-500/20 text-red-400 text-xs px-2 py-0.5 rounded flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Live
                        </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Stage</p>
                            <p class="text-gray-300">{{ $match->stage }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Scheduled</p>
                            <p class="text-gray-300">{{ $match->scheduled_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Status</p>
                            <p class="text-gray-300 uppercase text-xs font-medium">{{ $match->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection