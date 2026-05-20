@extends('layouts.public')
@section('title', $event->name . ' — EsportsTrack')
@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-orange-500 text-sm transition mb-6 inline-block">
        ← Back to Dashboard
    </a>

    {{-- Tournament header --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    @if($event->status === 'live')
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>LIVE
                    </span>
                    @elseif($event->status === 'upcoming')
                    <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full">UPCOMING</span>
                    @else
                    <span class="text-xs bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full">COMPLETED</span>
                    @endif

                    @if($event->approval_status === 'pending')
                    <span class="text-xs bg-orange-500/20 text-orange-400 px-2 py-1 rounded-full border border-orange-500/30">⏳ Pending Approval</span>
                    @elseif($event->approval_status === 'approved')
                    <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full border border-green-500/30">✓ Approved</span>
                    @else
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full border border-red-500/30">✕ Rejected</span>
                    @endif
                </div>

                <h1 class="text-xl font-bold text-white">{{ $event->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">
                    {{ $event->game?->name }}
                    @if($event->start_date)
                    • {{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}
                    @if($event->end_date) — {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }} @endif
                    @endif
                </p>
            </div>
            @if($event->prize_pool)
            <p class="text-xl font-bold text-orange-500">{{ $event->prize_pool }}</p>
            @endif
        </div>

        @if($event->approval_status === 'rejected' && $event->rejection_reason)
        <div class="mt-4 bg-red-500/10 border border-red-500/20 rounded-lg px-4 py-3">
            <p class="text-xs text-red-400"><span class="font-semibold">Rejection reason:</span> {{ $event->rejection_reason }}</p>
        </div>
        @endif
    </div>

    {{-- Success --}}
    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- Matches section --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden mb-6">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-800">
            <h2 class="font-bold">
                Matches
                <span class="text-gray-600 font-normal text-sm ml-1">{{ $event->matches->count() }} scheduled</span>
            </h2>
            @if($event->approval_status === 'approved')
            <button onclick="document.getElementById('schedule-modal').classList.remove('hidden')"
                class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                + Schedule Match
            </button>
            @else
            <span class="text-xs text-gray-600">Approval required to schedule matches</span>
            @endif
        </div>

        @if($event->matches->count() > 0)
        <div class="divide-y divide-gray-800">
            @foreach($event->matches->sortBy('scheduled_at') as $match)
            <div class="px-5 py-4 flex items-center gap-4">

                {{-- Status --}}
                <div class="w-24 flex-shrink-0">
                    @if($match->status === 'live')
                    <span class="text-xs text-red-400 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>LIVE
                    </span>
                    @elseif($match->status === 'upcoming')
                    <span class="text-xs text-blue-400 font-semibold">UPCOMING</span>
                    @else
                    <span class="text-xs text-gray-500 font-semibold">DONE</span>
                    @endif
                    @if($match->scheduled_at)
                    <p class="text-xs text-gray-600 mt-0.5">{{ \Carbon\Carbon::parse($match->scheduled_at)->format('M d · H:i') }}</p>
                    @endif
                </div>

                {{-- Teams --}}
                <div class="flex-1 flex items-center justify-center gap-3">
                    <span class="font-semibold text-sm text-right flex-1">{{ $match->teamA?->name ?? 'TBD' }}</span>
                    <span class="text-xs text-gray-600 border border-gray-700 rounded px-2 py-0.5">VS</span>
                    <span class="font-semibold text-sm flex-1">{{ $match->teamB?->name ?? 'TBD' }}</span>
                </div>

                {{-- Stage + Delete --}}
                <div class="flex items-center gap-3 flex-shrink-0">
                    @if($match->stage)
                    <span class="text-xs text-gray-500">{{ $match->stage }}</span>
                    @endif
                    <form method="POST" action="{{ route('user.events.matches.destroy', [$event, $match]) }}"
                        onsubmit="return confirm('Remove this match?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-400 hover:text-red-300 transition">Remove</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-gray-500">
            <p class="text-sm">No matches scheduled yet.</p>
            @if($event->approval_status === 'approved')
            <p class="text-xs text-gray-600 mt-1">Click "Schedule Match" to add one.</p>
            @else
            <p class="text-xs text-gray-600 mt-1">Waiting for admin approval before scheduling.</p>
            @endif
        </div>
        @endif
    </div>

</div>

{{-- SCHEDULE MATCH MODAL --}}
<div id="schedule-modal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center px-4"
    onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
    <div class="relative bg-gray-900 border border-gray-700 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <button onclick="document.getElementById('schedule-modal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-500 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="font-bold text-lg mb-5">Schedule Match</h3>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-3 py-2 rounded-lg mb-4 text-xs">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('user.events.matches.store', $event) }}">
            @csrf

            <div class="mb-4">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Team A *</label>
                <select name="team_a_id" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-orange-500">
                    <option value="">Select team...</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_a_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Team B *</label>
                <select name="team_b_id" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-orange-500">
                    <option value="">Select team...</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_b_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Stage</label>
                <input type="text" name="stage" value="{{ old('stage') }}"
                    placeholder="e.g. Group Stage, Semifinals, Final..."
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-orange-500 placeholder-gray-600">
            </div>

            <div class="mb-5">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Date & Time *</label>
                <input type="datetime-local" name="scheduled_at" required
                    min="{{ now()->format('Y-m-d\TH:i') }}"
                    value="{{ old('scheduled_at') }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-orange-500">
                <p class="text-xs text-gray-600 mt-1">Cannot schedule in the past.</p>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                    Schedule Match
                </button>
                <button type="button" onclick="document.getElementById('schedule-modal').classList.add('hidden')"
                    class="flex-1 bg-gray-800 hover:bg-gray-700 text-gray-300 py-2.5 rounded-xl transition text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => document.getElementById('schedule-modal')?.classList.remove('hidden'));
</script>
@endif

@endsection