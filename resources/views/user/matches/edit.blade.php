@extends('layouts.public')
@section('title', 'Edit Match')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 py-12">

        <a href="{{ route('user.events.show', $event) }}"
            class="inline-flex items-center gap-1.5 text-gray-400 hover:text-orange-500 transition mb-5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Tournament
        </a>

        <h1 class="text-2xl font-medium text-white mb-1">Edit Match</h1>
        <p class="text-gray-400 text-sm mb-8">Update match details for <strong>{{ $event->name }}</strong></p>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('user.events.matches.update', [$event, $match]) }}"
            class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col gap-5">
            @csrf
            @method('PUT')

            {{-- Tournament and Game Info --}}
            <div class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-3">
                <p class="text-xs text-gray-500">Tournament</p>
                <p class="text-white font-semibold">{{ $event->name }}</p>
                <p class="text-xs text-gray-400 mt-1">Game: <span class="text-orange-400">{{ $event->game->name }}</span></p>
            </div>

            {{-- Team A --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Team A <span class="text-orange-500">*</span>
                </label>
                <select name="team_a_id"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required onchange="validateTeams()">
                    <option value="">Select Team A</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_a_id', $match->team_a_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                    @endforeach
                </select>
                @error('team_a_id')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Team B --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Team B <span class="text-orange-500">*</span>
                </label>
                <select name="team_b_id"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required onchange="validateTeams()">
                    <option value="">Select Team B</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_b_id', $match->team_b_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                    @endforeach
                </select>
                <p id="teamError" class="text-red-400 text-xs mt-0.5 hidden">Teams must be different</p>
                @error('team_b_id')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stage --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Stage <span class="text-orange-500">*</span>
                </label>
                <input type="text" name="stage" value="{{ old('stage', $match->stage) }}"
                    placeholder="e.g., Group Stage, Semi-Finals, Finals"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm placeholder-gray-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required>
                @error('stage')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Scheduled At --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Schedule Date & Time <span class="text-orange-500">*</span>
                </label>
                <p class="text-xs text-gray-500">Must be in the future (no past dates)</p>
                <input type="datetime-local" name="scheduled_at"
                    value="{{ old('scheduled_at', $match->scheduled_at?->format('Y-m-d\TH:i')) }}"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    id="scheduledAt"
                    required>
                @error('scheduled_at')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-700"></div>

            {{-- Submit --}}
            <button type="submit" id="submitBtn"
                class="relative overflow-hidden w-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-3 rounded-xl transition-colors duration-200 btn-shine disabled:opacity-50 disabled:cursor-not-allowed">
                Update Match
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

<script>
    function validateTeams() {
        const teamA = document.querySelector('select[name="team_a_id"]').value;
        const teamB = document.querySelector('select[name="team_b_id"]').value;
        const teamError = document.getElementById('teamError');

        if (teamA && teamB && teamA === teamB) {
            teamError.classList.remove('hidden');
            document.getElementById('submitBtn').disabled = true;
        } else {
            teamError.classList.add('hidden');
            document.getElementById('submitBtn').disabled = false;
        }
    }

    function setMinDateTime() {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        const isoString = now.toISOString().slice(0, 16);
        document.getElementById('scheduledAt').min = isoString;
    }

    document.addEventListener('DOMContentLoaded', () => {
        setMinDateTime();
        validateTeams();
    });
</script>

@endsection