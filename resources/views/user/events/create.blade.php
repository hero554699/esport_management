@extends('layouts.public')
@section('title', 'Create Tournament — EsportsTrack')
@section('content')

<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}"
            class="text-gray-500 hover:text-orange-500 text-sm transition">← Back to Dashboard</a>
        <h1 class="text-2xl font-bold mt-3">Create Tournament</h1>
        <p class="text-gray-400 text-sm mt-1">Set up your esports tournament</p>
    </div>

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <form method="POST" action="{{ route('user.events.store') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                    Tournament Name *
                </label>
                <input type="text" name="name" required
                    value="{{ old('name') }}"
                    placeholder="e.g. Manila Esports Cup 2026"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                              focus:outline-none focus:border-orange-500 placeholder-gray-600 transition">
            </div>

            <div class="mb-5">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">Game *</label>
                <select name="game_id" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                           focus:outline-none focus:border-orange-500 transition">
                    <option value="">Select a game...</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Start Date *
                    </label>
                    <input type="date" name="start_date" required
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('start_date') }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                  focus:outline-none focus:border-orange-500 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                        End Date *
                    </label>
                    <input type="date" name="end_date" required
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('end_date') }}"
                        id="end-date"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                  focus:outline-none focus:border-orange-500 transition">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                    Prize Pool
                </label>
                <input type="text" name="prize_pool"
                    value="{{ old('prize_pool') }}"
                    placeholder="e.g. $500 or ₱10,000"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                              focus:outline-none focus:border-orange-500 placeholder-gray-600 transition">
            </div>

            <div class="mb-6">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                    Tournament Type
                </label>
                <select name="type"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                           focus:outline-none focus:border-orange-500 transition">
                    <option value="local" {{ old('type') == 'local' ? 'selected' : '' }}>Local</option>
                    <option value="national" {{ old('type') == 'national' ? 'selected' : '' }}>National</option>
                    <option value="international" {{ old('type') == 'international' ? 'selected' : '' }}>International</option>
                    <option value="world" {{ old('type') == 'world' ? 'selected' : '' }}>World</option>
                </select>
                <p class="text-xs text-gray-600 mt-1">
                    Your tournament starts as <span class="text-orange-500">Pending</span> —
                    invite other users to join and it becomes active once accepted.
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-semibold
                           px-6 py-2.5 rounded-xl transition text-sm">
                    Create Tournament
                </button>
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium
                          px-6 py-2.5 rounded-xl transition text-sm">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Make end date always >= start date
    document.querySelector('[name="start_date"]').addEventListener('change', function() {
        document.getElementById('end-date').min = this.value;
    });
</script>

@endsection