@extends('layouts.admin')

@section('title', 'Add Event')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.events.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">
        &larr; Back to Events
    </a>

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}" class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-400 mb-1">Event Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500"
                placeholder="e.g. MPL Philippines Season 15">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Game</label>
            <select name="game_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
                <option value="">Select a game</option>
                @foreach($games as $game)
                <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                    {{ $game->name }} ({{ $game->platform }})
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Status</label>
            <select name="status" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
                <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="live" {{ old('status') == 'live' ? 'selected' : '' }}>Live</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Prize Pool</label>
            <input type="text" name="prize_pool" value="{{ old('prize_pool') }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500"
                placeholder="e.g. $500,000">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Banner URL <span class="text-gray-600">(optional)</span></label>
            <input type="text" name="banner_url" value="{{ old('banner_url') }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-green-500"
                placeholder="https://...">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="bg-green-500 hover:bg-green-400 text-black font-semibold px-6 py-2 rounded-lg text-sm transition">
                Create Event
            </button>
        </div>
    </form>
</div>

@endsection