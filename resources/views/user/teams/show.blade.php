@extends('layouts.public')
@section('title', $team->name . ' — EsportsTrack')
@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Back --}}
    <a href="{{ route('dashboard') }}"
       class="text-gray-400 hover:text-orange-500 text-sm transition mb-6 inline-block">
        ← Back to Dashboard
    </a>

    {{-- Team Header --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                @if($team->logo_url)
                    <img src="{{ $team->logo_url }}"
                         class="w-16 h-16 rounded-xl object-cover">
                @else
                    <div class="w-16 h-16 rounded-xl bg-orange-500/20 border border-orange-500/30
                                flex items-center justify-center font-bold text-orange-500 text-xl">
                        {{ strtoupper(substr($team->name, 0, 2)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $team->name }}</h1>
                    <div class="flex items-center gap-3 mt-1">
                        @if($team->tag)
                            <span class="text-xs bg-gray-800 text-gray-400 px-2 py-0.5 rounded font-mono">
                                {{ $team->tag }}
                            </span>
                        @endif
                        @if($team->country)
                            <span class="text-xs text-gray-500">{{ $team->country }}</span>
                        @endif
                        @if($team->game)
                            <span class="text-xs text-gray-500">{{ $team->game->name }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="document.getElementById('add-player-modal').classList.remove('hidden')"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold
                           px-4 py-2 rounded-lg transition">
                    + Add Player
                </button>
                <a href="{{ route('user.teams.edit', $team) }}"
                   class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm px-4 py-2 rounded-lg transition">
                    Edit Team
                </a>
            </div>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ $errors->first() }}
            <script>
                // Re-open modal if there are errors
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('add-player-modal').classList.remove('hidden');
                });
            </script>
        </div>
    @endif

    {{-- Players section --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-800">
            <h2 class="font-bold text-lg">
                Players
                <span class="text-gray-600 text-sm font-normal ml-2">
                    {{ $team->players->count() }} members
                </span>
            </h2>
        </div>

        @if($team->players->count() > 0)
            <div class="divide-y divide-gray-800">
                @foreach($team->players as $player)
                    <div class="flex items-center justify-between px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if($player->avatar_url)
                                <img src="{{ $player->avatar_url }}"
                                     class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-orange-500/20
                                            flex items-center justify-center font-bold text-orange-500 text-sm">
                                    {{ strtoupper(substr($player->nickname ?? '?', 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-white text-sm">{{ $player->nickname }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    @if($player->real_name)
                                        <span class="text-xs text-gray-500">{{ $player->real_name }}</span>
                                    @endif
                                    @if($player->country)
                                        <span class="text-xs text-gray-600">{{ $player->country }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($player->role)
                                <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">
                                    {{ $player->role }}
                                </span>
                            @endif
                            <form method="POST"
                                  action="{{ route('user.teams.players.destroy', [$team, $player]) }}"
                                  onsubmit="return confirm('Remove {{ $player->nickname }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400
                                           px-3 py-1.5 rounded-lg transition">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-gray-500">
                <div class="w-14 h-14 rounded-full bg-gray-800 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium mb-1">No players yet</p>
                <p class="text-xs text-gray-600 mb-4">Add your first player to get started</p>
                <button onclick="document.getElementById('add-player-modal').classList.remove('hidden')"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
                    + Add First Player
                </button>
            </div>
        @endif
    </div>

</div>

{{-- ADD PLAYER MODAL --}}
<div id="add-player-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center px-4"
     onclick="if(event.target===this) this.classList.add('hidden')">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    {{-- Modal --}}
    <div class="relative bg-gray-900 border border-gray-700 rounded-2xl p-6 w-full max-w-lg shadow-2xl">

        {{-- Close --}}
        <button onclick="document.getElementById('add-player-modal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-500 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h3 class="font-bold text-lg mb-5">Add Player</h3>

        <form method="POST" action="{{ route('user.teams.players.store', $team) }}">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Nickname / IGN *
                    </label>
                    <input type="text" name="nickname" required
                           value="{{ old('nickname') }}"
                           placeholder="e.g. s1mple"
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5
                                  text-white text-sm focus:outline-none focus:border-orange-500
                                  placeholder-gray-600 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Real Name
                    </label>
                    <input type="text" name="real_name"
                           value="{{ old('real_name') }}"
                           placeholder="e.g. Juan dela Cruz"
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5
                                  text-white text-sm focus:outline-none focus:border-orange-500
                                  placeholder-gray-600 transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">Role</label>
                    <input type="text" name="role"
                           value="{{ old('role') }}"
                           placeholder="e.g. Jungler, IGL, AWPer..."
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5
                                  text-white text-sm focus:outline-none focus:border-orange-500
                                  placeholder-gray-600 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">Country</label>
                    <select name="country"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5
                               text-white text-sm focus:outline-none focus:border-orange-500 transition">
                        <option value="">Select country...</option>
                        @foreach(config('countries') as $code => $name)
                            <option value="{{ $name }}" {{ old('country') == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-2">
                    Avatar URL
                </label>
                <input type="url" name="avatar_url"
                       value="{{ old('avatar_url') }}"
                       placeholder="https://example.com/avatar.png"
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5
                              text-white text-sm focus:outline-none focus:border-orange-500
                              placeholder-gray-600 transition">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold
                           py-2.5 rounded-xl transition text-sm">
                    Add Player
                </button>
                <button type="button"
                    onclick="document.getElementById('add-player-modal').classList.add('hidden')"
                    class="flex-1 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium
                           py-2.5 rounded-xl transition text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@endsection