<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EsportsTrack')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e8460a',
                        'primary-dark': '#c73d09',
                        'primary-light': '#ff5a1f',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-950 text-white min-h-screen flex flex-col">

    <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-14">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-1">
                    <span class="text-orange-500 font-bold text-xl tracking-tight">Esports</span>
                    <span class="text-white font-bold text-xl tracking-tight">Track</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1 text-sm font-medium">

                    <a href="{{ route('home') }}"
                        class="px-3 py-2 text-gray-300 hover:text-orange-500 transition rounded-lg hover:bg-gray-800">
                        Home
                    </a>

                    {{-- Tournaments --}}
                    <div class="relative group">
                        <button class="flex items-center gap-1 px-3 py-2 text-gray-300 hover:text-orange-500 transition rounded-lg hover:bg-gray-800">
                            Tournaments
                            <svg class="w-3 h-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-48 bg-gray-900 border border-gray-700 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('events.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-t-xl transition">
                                All Events
                            </a>
                            <a href="{{ route('events.index') }}?status=live" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 transition">
                                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                Live Now
                            </a>
                            <a href="{{ route('events.index') }}?status=upcoming" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-b-xl transition">
                                Upcoming
                            </a>
                        </div>
                    </div>

                    {{-- Esports Data --}}
                    <div class="relative group">
                        <button class="flex items-center gap-1 px-3 py-2 text-gray-300 hover:text-orange-500 transition rounded-lg hover:bg-gray-800">
                            Esports Data
                            <svg class="w-3 h-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-52 bg-gray-900 border border-gray-700 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('organizations.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-t-xl transition">
                                Organizations
                            </a>
                            <a href="{{ route('teams.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 transition">
                                Teams
                            </a>
                            <a href="{{ route('players.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 transition">
                                Players
                            </a>
                            <a href="{{ route('matches.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-b-xl transition">
                                Matches
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('games.index') }}"
                        class="px-3 py-2 text-gray-300 hover:text-orange-500 transition rounded-lg hover:bg-gray-800">
                        Games
                    </a>

                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="hidden md:block text-sm bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Admin Panel
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-400 hover:text-red-400 transition">Logout</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-300 hover:text-white transition">Log in</a>
                    @endauth

                    {{-- Mobile hamburger --}}
                    <button id="mobile-menu-btn" class="md:hidden text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-800 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Home</a>
                <a href="{{ route('events.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Events</a>
                <a href="{{ route('teams.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Teams</a>
                <a href="{{ route('players.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Players</a>
                <a href="{{ route('organizations.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Organizations</a>
                <a href="{{ route('matches.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Matches</a>
                <a href="{{ route('games.index') }}" class="block px-3 py-2 text-sm text-gray-300 hover:text-orange-500 hover:bg-gray-800 rounded-lg transition">Games</a>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <span class="text-orange-500 font-bold text-lg">Esports</span>
                    <span class="text-white font-bold text-lg">Track</span>
                    <p class="text-gray-500 text-sm mt-1">Your home for esports events and results.</p>
                </div>
                <div class="flex gap-6 text-sm text-gray-500">
                    <a href="{{ route('events.index') }}" class="hover:text-orange-500 transition">Events</a>
                    <a href="{{ route('teams.index') }}" class="hover:text-orange-500 transition">Teams</a>
                    <a href="{{ route('players.index') }}" class="hover:text-orange-500 transition">Players</a>
                    <a href="{{ route('games.index') }}" class="hover:text-orange-500 transition">Games</a>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-6 pt-4 text-center text-gray-600 text-xs">
                &copy; {{ date('Y') }} EsportsTrack. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>