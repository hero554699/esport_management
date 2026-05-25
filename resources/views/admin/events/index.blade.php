@extends('layouts.admin')
@section('title', 'Tournaments')
@section('content')

@if(session('success'))
<div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-lg font-semibold text-white">All Tournaments</h2>
        @if($pendingCount > 0)
        <p class="text-xs text-orange-400 mt-0.5">
            ⚠️ {{ $pendingCount }} tournament{{ $pendingCount > 1 ? 's' : '' }} pending approval
        </p>
        @endif
    </div>
    <a href="{{ route('admin.events.create') }}"
        class="bg-green-500 hover:bg-green-400 text-black font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Tournament
    </a>
</div>

{{-- Pending approvals section --}}
@php
$pendingEvents = $events->where('approval_status', 'pending')->whereNotNull('user_id');
@endphp

@if($pendingEvents->count() > 0)
<div class="mb-8">
    <h3 class="text-sm font-semibold text-orange-400 mb-3 flex items-center gap-2">
        <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
        Pending Tournament Requests ({{ $pendingEvents->count() }})
    </h3>
    <div class="space-y-3">
        @foreach($pendingEvents as $event)
        <div class="bg-gray-900 border border-orange-500/30 rounded-xl p-4 hover:border-orange-500/50 transition cursor-pointer group"
            onclick="window.location.href='{{ route('admin.events.show', $event) }}'">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <p class="font-semibold text-white group-hover:text-orange-400 transition">{{ $event->name }}</p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400 flex-wrap">
                        <span>{{ $event->game?->name ?? 'No game' }}</span>
                        <span>•</span>
                        <span>By: {{ $event->user?->name ?? 'Unknown' }}</span>
                        <span>•</span>
                        <span class="text-orange-400 font-medium uppercase">{{ ucfirst($event->type ?? 'local') }}</span>
                        @if($event->prize_pool)
                        <span>•</span>
                        <span class="text-orange-400">Prize: {{ $event->prize_pool }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0" onclick="event.stopPropagation()">
                    {{-- Approve --}}
                    <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                        @csrf
                        <button type="submit"
                            class="bg-green-500/20 hover:bg-green-500/30 text-green-400 text-xs
                                   font-semibold px-4 py-2 rounded-lg transition border border-green-500/30">
                            ✓ Approve
                        </button>
                    </form>

                    {{-- Reject --}}
                    <button onclick="document.getElementById('reject-{{ $event->id }}').classList.toggle('hidden')"
                        class="bg-red-500/20 hover:bg-red-500/30 text-red-400 text-xs
                               font-semibold px-4 py-2 rounded-lg transition border border-red-500/30">
                        ✕ Reject
                    </button>
                </div>
            </div>

            {{-- Reject form --}}
            <div id="reject-{{ $event->id }}" class="hidden mt-3 pt-3 border-t border-gray-800">
                <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="rejection_reason" required
                            placeholder="Reason for rejection..."
                            class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2
                                      text-white text-xs focus:outline-none focus:border-red-500 transition">
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold
                                   px-4 py-2 rounded-lg transition">
                            Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- All events table --}}
<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Game</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Created By</th>
                <th class="px-4 py-3">Approval</th>
                <th class="px-4 py-3">Matches</th>
                <th class="px-4 py-3">Prize Pool</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                <td class="px-4 py-3 font-medium text-white">
                    <a href="{{ route('admin.events.show', $event) }}" class="hover:text-orange-400 transition">
                        {{ $event->name }}
                    </a>
                </td>
                <td class="px-4 py-3 text-gray-400">{{ $event->game?->name ?? '—' }}</td>
                <td class="px-4 py-3">
                    <span class="bg-orange-500/10 text-orange-400 px-2 py-1 rounded-full text-xs font-medium">
                        {{ ucfirst($event->type) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-400 text-xs">{{ $event->user?->name ?? 'Admin' }}</td>
                <td class="px-4 py-3">
                    @if($event->approval_status === 'approved')
                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs font-medium">Approved</span>
                    @elseif($event->approval_status === 'pending')
                    <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs font-medium">Pending</span>
                    @else
                    <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-full text-xs font-medium">Rejected</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-400">{{ $event->matches_count ?? 0 }}</td>
                <td class="px-4 py-3 text-orange-400 font-semibold">{{ $event->prize_pool ?? '—' }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.events.show', $event) }}"
                            class="text-orange-400 hover:text-orange-300 text-xs transition font-medium">View</a>
                        <a href="{{ route('admin.events.edit', $event) }}"
                            class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                            onsubmit="return confirm('Delete this tournament?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-8 text-center text-gray-500">No tournaments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection