@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/30 transition">
        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Tournaments</p>
        <p class="text-3xl font-bold text-orange-500">{{ $stats['events'] }}</p>
        <p class="text-xs text-gray-600 mt-1">user-created</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/30 transition">
        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Teams</p>
        <p class="text-3xl font-bold text-orange-500">{{ $stats['teams'] }}</p>
        <p class="text-xs text-gray-600 mt-1">user-created</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/30 transition">
        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Players</p>
        <p class="text-3xl font-bold text-orange-500">{{ $stats['players'] }}</p>
        <p class="text-xs text-gray-600 mt-1">user-created</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-orange-500/30 transition">
        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Games</p>
        <p class="text-3xl font-bold text-orange-500">{{ $stats['games'] }}</p>
        <p class="text-xs text-gray-600 mt-1">in system</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Pending approvals --}}
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-white flex items-center gap-2">
                <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                Pending Tournament Requests
            </h2>
            <a href="{{ route('admin.events.index') }}" class="text-xs text-orange-500 hover:text-orange-400">View all →</a>
        </div>

        @if($pendingEvents->count() > 0)
        <div class="space-y-3">
            @foreach($pendingEvents->take(5) as $event)
            <div class="bg-gray-900 border border-orange-500/20 rounded-xl p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-medium text-white text-sm">{{ $event->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $event->game?->name ?? '—' }} •
                            By: <span class="text-gray-400">{{ $event->user?->name ?? 'Unknown' }}</span> •
                            {{ ucfirst($event->type ?? 'local') }}
                            @if($event->start_date)
                            • {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                            @csrf
                            <button class="bg-green-500/20 border border-green-500/30 text-green-400 text-xs px-3 py-1.5 rounded-lg hover:bg-green-500/30 transition">
                                ✓ Approve
                            </button>
                        </form>
                        <button onclick="document.getElementById('rd-{{ $event->id }}').classList.toggle('hidden')"
                            class="bg-red-500/20 border border-red-500/30 text-red-400 text-xs px-3 py-1.5 rounded-lg hover:bg-red-500/30 transition">
                            ✕ Reject
                        </button>
                    </div>
                </div>
                <div id="rd-{{ $event->id }}" class="hidden mt-3 pt-3 border-t border-gray-800">
                    <form method="POST" action="{{ route('admin.events.reject', $event) }}" class="flex gap-2">
                        @csrf
                        <input type="text" name="rejection_reason" required placeholder="Reason for rejection..."
                            class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-red-500">
                        <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg transition">Send</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 text-center">
            <p class="text-gray-500 text-sm">No pending requests</p>
            <p class="text-gray-600 text-xs mt-1">All tournament requests have been reviewed</p>
        </div>
        @endif
    </div>

    {{-- Quick actions + info --}}
    <div class="space-y-4">
        <h2 class="font-semibold text-white">Quick Actions</h2>

        <a href="{{ route('admin.events.create') }}"
            class="flex items-center gap-3 bg-gray-900 border border-gray-800 rounded-xl p-4 hover:border-orange-500/40 transition">
            <div class="w-9 h-9 bg-orange-500/15 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-white">Add Tournament</p>
                <p class="text-xs text-gray-500">Create an official event</p>
            </div>
        </a>

        <a href="{{ route('admin.teams.create') }}"
            class="flex items-center gap-3 bg-gray-900 border border-gray-800 rounded-xl p-4 hover:border-orange-500/40 transition">
            <div class="w-9 h-9 bg-orange-500/15 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-white">Add Team</p>
                <p class="text-xs text-gray-500">Register a new team</p>
            </div>
        </a>

        <a href="{{ route('admin.games.create') }}"
            class="flex items-center gap-3 bg-gray-900 border border-gray-800 rounded-xl p-4 hover:border-orange-500/40 transition">
            <div class="w-9 h-9 bg-orange-500/15 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 11-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-white">Add Game</p>
                <p class="text-xs text-gray-500">Add a game to the platform</p>
            </div>
        </a>

        {{-- Info box --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 mt-2">
            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-2">Admin Notes</p>
            <ul class="space-y-1.5 text-xs text-gray-500">
                <li class="flex items-start gap-2"><span class="text-orange-500 mt-0.5">•</span> Only user-created data appears here. PandaScore data is public-only.</li>
                <li class="flex items-start gap-2"><span class="text-orange-500 mt-0.5">•</span> Approve or reject tournament requests from users.</li>
                <li class="flex items-start gap-2"><span class="text-orange-500 mt-0.5">•</span> Approved tournaments appear on the public site.</li>
                <li class="flex items-start gap-2"><span class="text-orange-500 mt-0.5">•</span> Games here are shared across the entire platform.</li>
            </ul>
        </div>
    </div>

</div>
@endsection