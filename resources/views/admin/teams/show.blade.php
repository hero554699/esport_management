@extends('layouts.admin')
@section('title', $team->name . ' — Players')
@section('content')

<div class="mb-6">
    <a href="{{ route('admin.teams.index') }}" class="text-gray-500 hover:text-orange-500 text-sm transition">← Back to Teams</a>
</div>

{{-- Team header --}}
<div class="bg-gray-900 border border-gray-800 rounded-xl p-5 mb-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            @if($team->logo_url)
            <img src="{{ $team->logo_url }}" class="w-14 h-14 rounded-xl object-cover">
            @else
            <div class="w-14 h-14 rounded-xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center font-bold text-orange-500 text-lg">
                {{ strtoupper(substr($team->name, 0, 2)) }}
            </div>
            @endif
            <div>
                <h1 class="text-xl font-bold">{{ $team->name }}</h1>
                <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                    @if($team->tag) <span class="font-mono">{{ $team->tag }}</span> @endif
                    @if($team->country) <span>{{ $team->country }}</span> @endif
                    @if($team->game) <span>{{ $team->game->name }}</span> @endif
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('add-player-modal').classList.remove('hidden')"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                + Add Player
            </button>
            <a href="{{ route('admin.teams.edit', $team) }}"
                class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm px-4 py-2 rounded-lg transition">
                Edit Team
            </a>
        </div>
    </div>
</div>

{{-- Players list --}}
<div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-800 flex items-center justify-between">
        <h2 class="font-semibold">Players <span class="text-gray-600 font-normal text-sm ml-1">{{ $team->players->count() }} members</span></h2>
    </div>

    @if($team->players->count() > 0)
    <div class="divide-y divide-gray-800">
        @foreach($team->players as $player)
        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex items-center gap-3">
                @if($player->avatar_url)
                <img src="{{ $player->avatar_url }}" class="w-10 h-10 rounded-full object-cover">
                @else
                <div class="w-10 h-10 rounded-full bg-orange-500/15 flex items-center justify-center font-bold text-orange-500 text-sm">
                    {{ strtoupper(substr($player->nickname ?? $player->username ?? '?', 0, 2)) }}
                </div>
                @endif
                <div>
                    <p class="font-medium text-sm">{{ $player->nickname ?? $player->username }}</p>
                    <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                        @if($player->real_name) <span>{{ $player->real_name }}</span> @endif
                        @if($player->country) <span>{{ $player->country }}</span> @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($player->role)
                <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">{{ $player->role }}</span>
                @endif
                <form method="POST" action="{{ route('admin.players.destroy', $player) }}"
                    onsubmit="return confirm('Remove {{ addslashes($player->nickname ?? $player->username) }}?')">
                    @csrf @method('DELETE')
                    <button class="text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400 px-3 py-1.5 rounded-lg transition">Remove</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 text-gray-500">
        <p class="text-sm mb-1">No players yet</p>
        <p class="text-xs text-gray-600">Add players using the button above</p>
    </div>
    @endif
</div>

{{-- ADD PLAYER MODAL --}}
<div id="add-player-modal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center px-4"
    onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
    <div class="relative bg-gray-900 border border-gray-700 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <button onclick="document.getElementById('add-player-modal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-500 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h3 class="font-bold text-lg mb-5">Add Player to {{ $team->name }}</h3>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-3 py-2 rounded-lg mb-4 text-xs">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.players.store') }}">
            @csrf
            <input type="hidden" name="team_id" value="{{ $team->id }}">

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Nickname *</label>
                    <input type="text" name="username" required value="{{ old('username') }}"
                        placeholder="e.g. s1mple"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500 placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Real Name</label>
                    <input type="text" name="real_name" value="{{ old('real_name') }}"
                        placeholder="Full name"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500 placeholder-gray-600">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Role</label>
                    <input type="text" name="role" value="{{ old('role') }}"
                        placeholder="e.g. IGL, AWPer..."
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500 placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">Country</label>
                    <select name="country"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-orange-500">
                        <option value="">Select...</option>
                        @foreach(config('countries') as $code => $name)
                        <option value="{{ $name }}" {{ old('country') == $name ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg transition text-sm">
                    Add Player
                </button>
                <button type="button" onclick="document.getElementById('add-player-modal').classList.add('hidden')"
                    class="flex-1 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium py-2.5 rounded-lg transition text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => document.getElementById('add-player-modal').classList.remove('hidden'));
</script>
@endif

@endsection