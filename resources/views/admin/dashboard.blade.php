@extends('layouts.public')
@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
            <p class="text-gray-400 mt-2">Platform management & tournament approvals</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Pending Approvals</p>
                <p class="text-3xl font-bold text-red-500">{{ $stats['pending_approvals'] }}</p>
                <p class="text-xs text-gray-600 mt-1">Awaiting review</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Tournaments</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['user_events'] }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Teams</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['user_teams'] }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition">
                <p class="text-gray-400 text-sm mb-2">Total Players</p>
                <p class="text-3xl font-bold text-orange-500">{{ $stats['players'] }}</p>
            </div>
        </div>
    </div>

    <!-- Management Actions -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-4 flex-wrap mb-8">
            <a href="{{ route('admin.events.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl transition">
                Create Event
            </a>
            <a href="{{ route('admin.games.index') }}" class="border border-gray-700 hover:border-orange-500 text-white px-6 py-3 rounded-xl transition">
                Manage Games
            </a>
            <a href="{{ route('admin.organizations.index') }}" class="border border-gray-700 hover:border-orange-500 text-white px-6 py-3 rounded-xl transition">
                Manage Organizations
            </a>
            <a href="{{ route('admin.events.index') }}" class="border border-gray-700 hover:border-orange-500 text-white px-6 py-3 rounded-xl transition">
                View All Events
            </a>
        </div>
    </div>

    <!-- Pending Tournaments for Approval -->
    <div class="max-w-7xl mx-auto px-4 py-8 border-t border-gray-800">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
            Pending Tournament Approvals
        </h2>

        @forelse($pendingEvents as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 mb-4 hover:border-orange-500/50 transition">
            <div class="mb-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $event->name }}</h3>
                        <p class="text-gray-400 text-sm mt-1">Submitted by: <strong>{{ $event->user?->name }}</strong></p>
                    </div>
                    <span class="bg-yellow-500/20 text-yellow-400 text-xs px-3 py-1 rounded-full">PENDING REVIEW</span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                    <div>
                        <p class="text-gray-400">Game</p>
                        <p class="text-white font-semibold">{{ $event->game?->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Type</p>
                        <p class="text-white font-semibold capitalize">{{ $event->type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Start Date</p>
                        <p class="text-white font-semibold">
                            {{ $event->start_date ? \Illuminate\Support\Carbon::parse($event->start_date)->format('M d, Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400">Prize Pool</p>
                        <p class="text-orange-500 font-semibold">{{ $event->prize_pool ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Approval Actions -->
            <div class="flex gap-3">
                <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500/20 hover:bg-green-500/30 text-green-400 font-semibold px-4 py-2 rounded-lg transition">
                        ✓ Approve
                    </button>
                </form>

                <button type="button" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold px-4 py-2 rounded-lg transition"
                    onclick="openRejectModal({{ $event->id }}, '{{ $event->name }}')">
                    ✗ Reject
                </button>

                <a href="{{ route('admin.events.edit', $event) }}" class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 font-semibold px-4 py-2 rounded-lg transition">
                    View Details
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
            <p class="text-gray-400 text-lg">✓ No pending approvals</p>
            <p class="text-gray-600 text-sm mt-1">All tournaments are approved!</p>
        </div>
        @endforelse
    </div>

    <!-- Recent Approved -->
    <div class="max-w-7xl mx-auto px-4 py-8 border-t border-gray-800">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
            Recently Approved
        </h2>

        @forelse($recentApproved as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 mb-4 hover:border-orange-500/50 transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $event->name }}</h3>
                    <p class="text-gray-400 text-sm">
                        {{ $event->game?->name }} • {{ $event->start_date ? \Illuminate\Support\Carbon::parse($event->start_date)->format('M d, Y') : '—' }}
                    </p>
                </div>
                <span class="bg-green-500/20 text-green-400 text-xs px-3 py-1 rounded-full">APPROVED</span>
            </div>
        </div>
        @empty
        <p class="text-gray-400">No recently approved tournaments</p>
        @endforelse
    </div>

    <!-- Recent Rejected -->
    <div class="max-w-7xl mx-auto px-4 py-8 border-t border-gray-800">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
            Recently Rejected
        </h2>

        @forelse($recentRejected as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 mb-4 hover:border-orange-500/50 transition">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold text-white">{{ $event->name }}</h3>
                <span class="bg-red-500/20 text-red-400 text-xs px-3 py-1 rounded-full">REJECTED</span>
            </div>
            <p class="text-red-300 text-sm"><strong>Reason:</strong> {{ $event->rejection_reason ?? 'No reason provided' }}</p>
        </div>
        @empty
        <p class="text-gray-400">No recently rejected tournaments</p>
        @endforelse
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Reject Tournament</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="rejection_reason" placeholder="Enter rejection reason..."
                class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white placeholder-gray-500 mb-4 focus:border-orange-500 outline-none"
                rows="4" required></textarea>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition">
                    Reject
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 border border-gray-600 text-white px-4 py-2 rounded-lg hover:border-gray-500 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(eventId, eventName) {
        const form = document.getElementById('rejectForm');
        form.action = `/admin/events/${eventId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection