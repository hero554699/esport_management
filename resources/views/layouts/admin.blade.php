<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — EsportsTrack')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e8460a',
                        'primary-dark': '#c73d09',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-950 text-white min-h-screen">

    {{-- TOP NAVBAR --}}
    <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-full px-4">
            <div class="flex justify-between items-center h-14">

                {{-- Logo --}}
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1">
                        <span class="text-orange-500 font-bold text-lg">Esports</span>
                        <span class="text-white font-bold text-lg">Track</span>
                        <span class="text-gray-500 text-xs ml-2 font-normal">Admin</span>
                    </a>

                    {{-- Desktop Nav Links --}}
                    <div class="hidden md:flex items-center gap-1 text-sm">
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.events.index') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.events.*') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Events
                        </a>
                        <a href="{{ route('admin.teams.index') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.teams.*') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Teams
                        </a>
                        <a href="{{ route('admin.players.index') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.players.*') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Players
                        </a>
                        <a href="{{ route('admin.matches.index') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.matches.*') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Matches
                        </a>
                        <a href="{{ route('admin.organizations.index') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.organizations.*') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Organizations
                        </a>
                        <a href="{{ route('admin.games.index') }}"
                            class="px-3 py-1.5 rounded-lg transition
                           {{ request()->routeIs('admin.games.*') ? 'bg-orange-500/10 text-orange-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            Games
                        </a>
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-4">
                    <span class="hidden md:block text-xs text-gray-500">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-xs text-red-400 hover:text-red-300 transition">Logout</button>
                    </form>

                    {{-- Hamburger --}}
                    <button id="admin-mobile-btn" class="md:hidden text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>

            {{-- Mobile Menu --}}
            <div id="admin-mobile-menu" class="hidden md:hidden border-t border-gray-800 py-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Dashboard</a>
                <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Events</a>
                <a href="{{ route('admin.teams.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Teams</a>
                <a href="{{ route('admin.players.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Players</a>
                <a href="{{ route('admin.matches.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Matches</a>
                <a href="{{ route('admin.organizations.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Organizations</a>
                <a href="{{ route('admin.games.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Games</a>
            </div>
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <script>
        document.getElementById('admin-mobile-btn').addEventListener('click', function() {
            const menu = document.getElementById('admin-mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>