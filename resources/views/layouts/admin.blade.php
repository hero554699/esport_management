<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — EsportsTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e8460a'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-950 text-white min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-60 min-h-screen bg-gray-900 border-r border-gray-800 flex flex-col fixed top-0 left-0 z-40">

        {{-- Logo --}}
        <div class="px-5 py-4 border-b border-gray-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-7 h-7 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="text-orange-500 font-bold text-sm">Esports</span><span class="text-white font-bold text-sm">Track</span>
                    <p class="text-gray-500 text-xs leading-none mt-0.5">Admin Panel</p>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <p class="text-gray-600 text-xs uppercase tracking-widest px-3 mb-2">Overview</p>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
            {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500/10 text-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h7v7H3zM3 17h7v4H3zM14 3h7v8h-7zM14 15h7v6h-7z" />
                </svg>
                Dashboard
            </a>

            <p class="text-gray-600 text-xs uppercase tracking-widest px-3 mt-4 mb-2">Manage</p>

            <a href="{{ route('admin.events.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
            {{ request()->routeIs('admin.events.*') ? 'bg-orange-500/10 text-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Tournaments
                @php $pendingEventsCount = \App\Models\Event::whereNull('pandascore_id')->where('approval_status','pending')->whereNotNull('user_id')->count(); @endphp
                @if($pendingEventsCount > 0)
                <span class="ml-auto bg-orange-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingEventsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.teams.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
            {{ request()->routeIs('admin.teams.*') ? 'bg-orange-500/10 text-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Teams & Players
            </a>

            <a href="{{ route('admin.matches.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
            {{ request()->routeIs('admin.matches.*') ? 'bg-orange-500/10 text-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Matches
            </a>

            <a href="{{ route('admin.organizations.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
            {{ request()->routeIs('admin.organizations.*') ? 'bg-orange-500/10 text-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Organizations
            </a>

            <p class="text-gray-600 text-xs uppercase tracking-widest px-3 mt-4 mb-2">Config</p>

            <a href="{{ route('admin.games.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
            {{ request()->routeIs('admin.games.*') ? 'bg-orange-500/10 text-orange-500 font-medium' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 11-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                </svg>
                Games
            </a>

            <a href="{{ route('home') }}" target="_blank"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition text-gray-400 hover:text-white hover:bg-gray-800 mt-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                View Public Site
            </a>
        </nav>

        {{-- User info --}}
        <div class="px-4 py-4 border-t border-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-orange-500">Administrator</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-gray-500 hover:text-red-400 transition">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="ml-60 flex-1 flex flex-col min-h-screen">

        {{-- Top bar --}}
        <header class="bg-gray-900 border-b border-gray-800 px-6 py-3 flex items-center justify-between sticky top-0 z-30">
            <div>
                <h1 class="text-sm font-semibold text-white">@yield('title', 'Dashboard')</h1>
                <p class="text-xs text-gray-500">EsportsTrack Admin</p>
            </div>
            <div class="flex items-center gap-2">
                @php $pending = \App\Models\Event::whereNull('pandascore_id')->where('approval_status','pending')->whereNotNull('user_id')->count(); @endphp
                @if($pending > 0)
                <a href="{{ route('admin.events.index') }}"
                    class="flex items-center gap-1.5 bg-orange-500/10 border border-orange-500/30
                           text-orange-400 text-xs px-3 py-1.5 rounded-lg hover:bg-orange-500/20 transition">
                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                    {{ $pending }} pending approval
                </a>
                @endif
            </div>
        </header>

        <main class="flex-1 px-6 py-6">
            @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-5 text-sm">
                {{ session('success') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>

</body>

</html>