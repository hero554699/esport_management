@extends('layouts.public')
@section('title', 'Edit Result')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 py-12">

        <a href="{{ route('user.events.show', $match->event) }}"
            class="inline-flex items-center gap-1.5 text-gray-400 hover:text-orange-500 transition mb-5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Tournament
        </a>

        <h1 class="text-2xl font-medium text-white mb-1">Edit Match Result</h1>
        <p class="text-gray-400 text-sm mb-8">Update the result for this match.</p>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('user.matches.results.update', [$match, $result]) }}"
            class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col gap-5">
            @csrf
            @method('PUT')

            {{-- Match Info --}}
            <div class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-3">
                <p class="text-xs text-gray-500">Match</p>
                <p class="text-white font-semibold">{{ $match->teamA->name }} vs {{ $match->teamB->name }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $match->event->name }}</p>
            </div>

            {{-- Winner --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Winner <span class="text-orange-500">*</span>
                </label>
                <select name="winner_id"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required>
                    <option value="">Select winner</option>
                    <option value="{{ $match->team_a_id }}" {{ old('winner_id', $result->winner_id) == $match->team_a_id ? 'selected' : '' }}>
                        {{ $match->teamA->name }}
                    </option>
                    <option value="{{ $match->team_b_id }}" {{ old('winner_id', $result->winner_id) == $match->team_b_id ? 'selected' : '' }}>
                        {{ $match->teamB->name }}
                    </option>
                </select>
                @error('winner_id')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Scores --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-gray-300">
                        {{ $match->teamA->name }} Score <span class="text-gray-500 font-normal">(optional)</span>
                    </label>
                    <input type="number" name="score_a" value="{{ old('score_a', $result->score_a) }}"
                        placeholder="0"
                        class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm placeholder-gray-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition">
                    @error('score_a')
                    <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-gray-300">
                        {{ $match->teamB->name }} Score <span class="text-gray-500 font-normal">(optional)</span>
                    </label>
                    <input type="number" name="score_b" value="{{ old('score_b', $result->score_b) }}"
                        placeholder="0"
                        class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm placeholder-gray-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition">
                    @error('score_b')
                    <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-700"></div>

            {{-- Submit --}}
            <button type="submit"
                class="relative overflow-hidden w-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-3 rounded-xl transition-colors duration-200 btn-shine">
                Update Result
            </button>

        </form>
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