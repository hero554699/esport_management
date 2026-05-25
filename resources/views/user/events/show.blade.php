@extends('layouts.public')
@section('title', $event->name)

@section('content')
<div class="min-h-screen" style="background:#0f1117">

    {{-- Header --}}
    <div style="border-bottom:1px solid #1e2535">
        <div class="max-w-7xl mx-auto px-6 pt-7 pb-6">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-1.5 text-sm mb-5 transition"
                style="color:#64748b"
                onmouseover="this.style.color='#fb923c'" onmouseout="this.style.color='#64748b'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>

            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <div class="flex items-center gap-3 flex-wrap mb-2">
                        <h1 class="text-3xl font-extrabold" style="color:#f1f5f9">{{ $event->name }}</h1>
                        @if($event->approval_status === 'pending')
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full" style="background:rgba(234,179,8,.15);color:#fbbf24;border:1px solid rgba(234,179,8,.25)">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            PENDING
                        </span>
                        @elseif($event->approval_status === 'approved')
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full" style="background:rgba(34,197,94,.15);color:#4ade80;border:1px solid rgba(34,197,94,.25)">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            APPROVED
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full" style="background:rgba(239,68,68,.15);color:#f87171;border:1px solid rgba(239,68,68,.25)">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            REJECTED
                        </span>
                        @endif
                    </div>
                    <p class="text-sm" style="color:#475569">Manage and schedule matches for your tournament</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('user.events.matches.index', $event) }}"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-lg transition"
                        style="color:#94a3b8;border:1px solid #334155;background:transparent"
                        onmouseover="this.style.color='#fb923c';this.style.borderColor='#fb923c'"
                        onmouseout="this.style.color='#94a3b8';this.style.borderColor='#334155'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Matches
                    </a>
                    <a href="{{ route('user.events.edit', $event) }}"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-lg transition"
                        style="color:#94a3b8;border:1px solid #334155;background:transparent"
                        onmouseover="this.style.color='#fb923c';this.style.borderColor='#fb923c'"
                        onmouseout="this.style.color='#94a3b8';this.style.borderColor='#334155'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            @php
            $stats = [
            ['label' => 'Game', 'value' => $event->game->name ?? 'N/A', 'orange' => false],
            ['label' => 'Type', 'value' => strtoupper($event->type), 'orange' => true],
            ['label' => 'Matches', 'value' => $matches->count(), 'orange' => false],
            ['label' => 'Prize Pool', 'value' => $event->prize_pool ?? 'N/A', 'orange' => true],
            ];
            @endphp
            @foreach($stats as $s)
            <div class="rounded-xl p-4" style="background:#1a1f2e;border:1px solid #252d3d">
                <p class="text-xs uppercase tracking-wider mb-1.5" style="color:#64748b;letter-spacing:.6px">{{ $s['label'] }}</p>
                <p class="font-semibold text-sm" style="color:{{ $s['orange'] ? '#fb923c' : '#e2e8f0' }}">{{ $s['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Certification --}}
        @if($event->hasCertification())
        <div class="flex items-center gap-3 rounded-xl p-4 mb-6" style="background:rgba(34,197,94,.07);border:1px solid rgba(34,197,94,.18)">
            <div class="flex items-center justify-center w-8 h-8 rounded-full flex-shrink-0" style="background:rgba(34,197,94,.15)">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color:#4ade80">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold" style="color:#4ade80">Certification Verified</p>
                <p class="text-xs mt-0.5" style="color:#6ee7b7">{{ basename($event->certification_path) }}</p>
            </div>
        </div>
        @endif

        {{-- Matches --}}
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold" style="color:#f1f5f9">
                Matches
                <span class="font-normal text-base ml-1" style="color:#475569">({{ $matches->count() }})</span>
            </h2>
            @if($event->approval_status === 'approved')
            <a href="{{ route('user.events.matches.create', $event) }}"
                class="inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-lg transition"
                style="background:#3b82f6;color:#fff;border:1px solid #3b82f6"
                onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Match
            </a>
            @else
            <p class="text-sm" style="color:#fbbf24">⚠️ Tournament must be approved to create matches</p>
            @endif
        </div>

        @if($matches->isEmpty())
        <div class="rounded-xl p-12 text-center" style="background:#1a1f2e;border:1px dashed #252d3d">
            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#334155">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="mb-4 text-sm" style="color:#475569">No matches scheduled yet.</p>
            @if($event->approval_status === 'approved')
            <a href="{{ route('user.events.matches.create', $event) }}"
                class="inline-block text-sm font-semibold px-5 py-2.5 rounded-lg"
                style="background:#3b82f6;color:#fff">
                + Schedule First Match
            </a>
            @endif
        </div>
        @else
        <div class="space-y-4">
            @foreach($matches->sortBy('scheduled_at') as $match)
            <div class="rounded-2xl overflow-hidden transition-all duration-200" style="background:#1a1f2e;border:1px solid #252d3d"
                onmouseover="this.style.borderColor='#334155'" onmouseout="this.style.borderColor='#252d3d'">

                {{-- Match Top --}}
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div class="flex-1">
                            {{-- Teams --}}
                            <div class="flex items-center gap-3 flex-wrap mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl font-bold" style="color:#f1f5f9">{{ $match->teamA->name ?? 'TBD' }}</span>
                                    @if($match->result && $match->result->winner_id === $match->team_a_id)
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(251,191,36,.12);color:#fbbf24;border:1px solid rgba(251,191,36,.2)">👑 Winner</span>
                                    @endif
                                </div>
                                <span class="text-sm font-semibold" style="color:#475569">vs</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-xl font-bold" style="color:#f1f5f9">{{ $match->teamB->name ?? 'TBD' }}</span>
                                    @if($match->result && $match->result->winner_id === $match->team_b_id)
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(251,191,36,.12);color:#fbbf24;border:1px solid rgba(251,191,36,.2)">👑 Winner</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Status badges --}}
                            <div class="flex items-center gap-2 flex-wrap">
                                @if($match->result)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full" style="background:rgba(34,197,94,.12);color:#4ade80;border:1px solid rgba(34,197,94,.2)">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Completed
                                </span>
                                @elseif($match->status === 'live')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full" style="background:rgba(239,68,68,.12);color:#f87171;border:1px solid rgba(239,68,68,.2)">
                                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:#f87171"></span>
                                    Live
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full" style="background:rgba(99,179,237,.12);color:#63b3ed;border:1px solid rgba(99,179,237,.2)">
                                    Scheduled
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-4 flex-shrink-0">
                            @if($match->result && ($match->result->score_a !== null || $match->result->score_b !== null))
                            <div class="text-xl font-bold px-4 py-1.5 rounded-lg" style="background:#252d3d;color:#f1f5f9;letter-spacing:3px">
                                {{ $match->result->score_a }} — {{ $match->result->score_b }}
                            </div>
                            @endif
                            <div class="flex items-center gap-3">
                                <a href="{{ route('user.events.matches.edit', [$event, $match]) }}"
                                    class="text-sm font-medium transition" style="color:#63b3ed"
                                    onmouseover="this.style.color='#93c5fd'" onmouseout="this.style.color='#63b3ed'">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('user.events.matches.destroy', [$event, $match]) }}"
                                    onsubmit="return confirm('Delete this match?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm font-medium transition cursor-pointer" style="color:#f87171;background:none;border:none;padding:0"
                                        onmouseover="this.style.color='#fca5a5'" onmouseout="this.style.color='#f87171'">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div style="border-top:1px solid #252d3d;margin:0 24px"></div>

                {{-- Meta --}}
                <div class="grid grid-cols-3 gap-4 px-6 py-4">
                    <div>
                        <p class="text-xs uppercase tracking-wider mb-1" style="color:#475569;letter-spacing:.5px">Stage</p>
                        <p class="text-sm font-medium" style="color:#cbd5e1">{{ $match->stage }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider mb-1" style="color:#475569;letter-spacing:.5px">Scheduled</p>
                        <p class="text-sm font-medium" style="color:#cbd5e1">{{ $match->scheduled_at?->format('M d, Y · H:i') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider mb-1" style="color:#475569;letter-spacing:.5px">Status</p>
                        <p class="text-sm font-medium uppercase" style="color:#cbd5e1">{{ $match->status }}</p>
                    </div>
                </div>

                {{-- Result / Record --}}
                <div class="px-6 pb-6">
                    @if($match->result)
                    <div class="flex items-center justify-between rounded-xl p-4" style="background:rgba(34,197,94,.07);border:1px solid rgba(34,197,94,.18)">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color:#4ade80;letter-spacing:.4px">Match Result</p>
                            <p class="text-sm" style="color:#a7f3d0">
                                <span style="color:#f1f5f9;font-weight:600">Winner:</span>
                                {{ $match->result->winner?->name ?? 'N/A' }}
                                @if($match->result->score_a !== null || $match->result->score_b !== null)
                                &nbsp;·&nbsp;
                                <span style="color:#f1f5f9;font-weight:600">Score:</span>
                                {{ $match->result->score_a }} – {{ $match->result->score_b }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('user.matches.results.edit', [$match, $match->result]) }}"
                            class="text-xs font-semibold transition flex-shrink-0" style="color:#63b3ed"
                            onmouseover="this.style.color='#93c5fd'" onmouseout="this.style.color='#63b3ed'">
                            Edit Result
                        </a>
                    </div>
                    @else
                    <a href="{{ route('user.matches.results.create', $match) }}"
                        class="block w-full text-center text-sm font-semibold py-2.5 rounded-xl transition"
                        style="background:linear-gradient(135deg,#f97316,#fb923c);color:#fff"
                        onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                        + Record Result
                    </a>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection