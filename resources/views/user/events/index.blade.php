@extends('layouts.public')
@section('title', 'My Tournaments')
@section('content')
<div class="min-h-screen bg-gray-900">

    {{-- Header --}}
    <div class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-5xl mx-auto px-6 py-8">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-1.5 text-gray-400 hover:text-orange-500 transition text-sm mb-5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-medium text-white">My Tournaments</h1>
                    <p class="text-gray-400 text-sm mt-1">Manage and organize your esports tournaments</p>
                </div>
                <a href="{{ route('user.events.create') }}"
                    class="relative overflow-hidden bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition btn-shine">
                    + Create Tournament
                </a>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-5xl mx-auto px-6 py-8">

        @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/25 text-green-400 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="flex flex-col gap-3">
            @forelse($events as $event)
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-orange-500/40 transition cursor-pointer group"
                onclick="window.location.href='{{ route('user.events.show', $event) }}'">

                {{-- Top row: name + badges + actions --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-base font-medium text-white group-hover:text-orange-400 transition">{{ ucwords(str_replace('_', ' ', $event->name)) }}</h3>

                        @if($event->approval_status === 'pending')
                        <span class="bg-yellow-500/12 text-yellow-500 text-xs px-2.5 py-0.5 rounded-full font-medium">Pending</span>
                        @elseif($event->approval_status === 'approved')
                        <span class="bg-green-500/12 text-green-400 text-xs px-2.5 py-0.5 rounded-full font-medium">Approved</span>
                        @else
                        <span class="bg-red-500/12 text-red-400 text-xs px-2.5 py-0.5 rounded-full font-medium">Rejected</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0 ml-4" onclick="event.stopPropagation()">
                        @if($event->approval_status === 'approved')
                        <a href="{{ route('user.events.matches.create', $event) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium px-3 py-1.5 rounded transition whitespace-nowrap">
                            + Add Match
                        </a>
                        @endif
                        <a href="{{ route('user.events.edit', $event) }}"
                            class="text-blue-400 hover:text-blue-300 text-sm transition">Edit</a>
                        <form method="POST" action="{{ route('user.events.destroy', $event) }}"
                            onsubmit="return confirm('Delete this tournament?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-sm transition">Delete</button>
                        </form>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-700 mb-4"></div>

                {{-- Meta grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-700">
                    <div class="pr-5">
                        <p class="text-gray-500 text-xs mb-1">Type</p>
                        <span class="bg-orange-500/10 text-orange-400 text-xs px-2.5 py-0.5 rounded-full font-medium">
                            {{ ucfirst($event->type) }}
                        </span>
                    </div>
                    <div class="px-5">
                        <p class="text-gray-500 text-xs mb-1">Matches</p>
                        <p class="text-white text-sm font-medium">{{ $event->matches_count ?? 0 }}</p>
                    </div>
                    <div class="px-5">
                        <p class="text-gray-500 text-xs mb-1">Prize Pool</p>
                        <p class="text-orange-500 text-sm font-medium">{{ $event->prize_pool ?? '—' }}</p>
                    </div>
                    <div class="pl-5">
                        <p class="text-gray-500 text-xs mb-1">Approval</p>
                        @if($event->approval_status === 'pending')
                        <p class="text-gray-400 text-sm">Awaiting review</p>
                        @elseif($event->approval_status === 'approved')
                        <p class="text-green-400 text-sm">Approved</p>
                        @else
                        <p class="text-red-400 text-sm">Rejected</p>
                        @endif
                    </div>
                </div>

            </div>
            @empty
            <div class="bg-gray-800 border border-gray-700 rounded-xl py-16 text-center">
                <p class="text-gray-400 text-sm mb-5">No tournaments yet. Create your first one!</p>
                <a href="{{ route('user.events.create') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition inline-block">
                    + Create Tournament
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>

<style>
    .btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.18), transparent);
        transform: skewX(-20deg);
        transition: left 0.5s ease;
    }

    .btn-shine:hover::after {
        left: 150%;
    }
</style>
@endsection