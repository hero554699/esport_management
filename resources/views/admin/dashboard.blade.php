@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="p-8">

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-10">
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
            <p class="text-gray-400 text-xs mb-2">Pending Approvals</p>
            <p class="text-2xl font-medium text-red-400">{{ $stats['pending_approvals'] }}</p>
            <p class="text-xs text-gray-600 mt-1">User submitted</p>
        </div>
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
            <p class="text-gray-400 text-xs mb-2">User Tournaments</p>
            <p class="text-2xl font-medium text-blue-400">{{ $stats['user_events'] }}</p>
            <p class="text-xs text-gray-600 mt-1">Community created</p>
        </div>
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
            <p class="text-gray-400 text-xs mb-2">PandaScore Tournaments</p>
            <p class="text-2xl font-medium text-green-400">{{ $stats['pandascore_events'] }}</p>
            <p class="text-xs text-gray-600 mt-1">Auto-approved</p>
        </div>
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition">
            <p class="text-gray-400 text-xs mb-2">All Players</p>
            <p class="text-2xl font-medium text-orange-500">{{ $stats['players'] }}</p>
            <p class="text-xs text-gray-600 mt-1">From all sources</p>
        </div>
    </div>

    {{-- Pending Approvals --}}
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-5">
            <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            <h2 class="text-base font-medium text-white">Pending Tournament Approvals</h2>
        </div>

        @forelse($pendingEvents as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 mb-3 hover:border-orange-500/40 transition">

            {{-- Top row --}}
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-sm font-medium text-white">{{ ucwords($event->name) }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Submitted by <span class="text-gray-400 font-medium">{{ $event->user?->name ?? 'Unknown' }}</span></p>
                </div>
                <span class="bg-yellow-500/12 text-yellow-500 text-xs px-2.5 py-0.5 rounded-full font-medium flex-shrink-0 ml-4">Pending review</span>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-700 mb-4"></div>

            {{-- Meta --}}
            <div class="grid grid-cols-3 divide-x divide-gray-700 mb-4">
                <div class="pr-5">
                    <p class="text-gray-500 text-xs mb-1">Game</p>
                    <p class="text-white text-sm font-medium">{{ $event->game?->name ?? 'N/A' }}</p>
                </div>
                <div class="px-5">
                    <p class="text-gray-500 text-xs mb-1">Type</p>
                    <span class="bg-orange-500/10 text-orange-400 text-xs px-2.5 py-0.5 rounded-full font-medium">
                        {{ ucfirst($event->type) }}
                    </span>
                </div>
                <div class="pl-5">
                    <p class="text-gray-500 text-xs mb-1">Prize Pool</p>
                    <p class="text-orange-500 text-sm font-medium">{{ $event->prize_pool ?? '—' }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2">
                <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-green-500/12 hover:bg-green-500/20 text-green-400 border border-green-500/25 text-xs font-medium px-4 py-2 rounded-lg transition">
                        ✓ Approve
                    </button>
                </form>
                <button type="button"
                    class="bg-red-500/12 hover:bg-red-500/20 text-red-400 border border-red-500/25 text-xs font-medium px-4 py-2 rounded-lg transition"
                    onclick="openRejectModal({{ $event->id }}, '{{ $event->name }}')">
                    ✗ Reject
                </button>
            </div>

        </div>
        @empty
        <div class="text-center py-12 bg-gray-800 border border-gray-700 rounded-xl">
            <p class="text-gray-400 text-sm">✓ No pending approvals</p>
            <p class="text-gray-600 text-xs mt-1">All user tournaments have been reviewed</p>
        </div>
        @endforelse
    </div>

    {{-- Recently Approved --}}
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-5">
            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            <h2 class="text-base font-medium text-white">Recently Approved</h2>
        </div>

        @forelse($recentApproved as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl px-5 py-4 mb-2 flex items-center justify-between hover:border-orange-500/40 transition">
            <div>
                <p class="text-sm font-medium text-white">{{ ucwords($event->name) }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $event->game?->name ?? 'N/A' }}
                    @if($event->start_date)
                    · {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                    @endif
                </p>
            </div>
            <span class="bg-green-500/12 text-green-400 text-xs px-2.5 py-0.5 rounded-full font-medium flex-shrink-0 ml-4">Approved</span>
        </div>
        @empty
        <p class="text-gray-600 text-sm">No recently approved tournaments</p>
        @endforelse
    </div>

    {{-- Recently Rejected --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-5">
            <span class="w-2 h-2 bg-gray-600 rounded-full"></span>
            <h2 class="text-base font-medium text-white">Recently Rejected</h2>
        </div>

        @forelse($recentRejected as $event)
        <div class="bg-gray-800 border border-gray-700 rounded-xl px-5 py-4 mb-2 hover:border-orange-500/40 transition">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-white">{{ ucwords($event->name) }}</p>
                <span class="bg-red-500/12 text-red-400 text-xs px-2.5 py-0.5 rounded-full font-medium flex-shrink-0 ml-4">Rejected</span>
            </div>
            <p class="text-xs text-red-300/80">
                <span class="text-red-400 font-medium">Reason:</span>
                {{ $event->rejection_reason ?? 'No reason provided' }}
            </p>
        </div>
        @empty
        <p class="text-gray-600 text-sm">No recently rejected tournaments</p>
        @endforelse
    </div>

</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-base font-medium text-white mb-4">Reject Tournament</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="rejection_reason" placeholder="Enter rejection reason..."
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 mb-4 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition resize-none"
                rows="4" required></textarea>
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                    Reject
                </button>
                <button type="button" onclick="closeRejectModal()"
                    class="flex-1 border border-gray-700 hover:border-gray-500 text-gray-300 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(eventId, eventName) {
        document.getElementById('rejectForm').action = `/admin/events/${eventId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection