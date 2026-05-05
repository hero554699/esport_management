<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — EsportsTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes floatA {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes floatB {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes floatC {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .card-a {
            animation: floatA 4s ease-in-out infinite;
        }

        .card-b {
            animation: floatB 4s ease-in-out infinite 1.3s;
        }

        .card-c {
            animation: floatC 4s ease-in-out infinite 2.6s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-1 {
            animation: fadeInUp 0.6s ease forwards;
        }

        .fade-in-2 {
            animation: fadeInUp 0.6s ease 0.15s forwards;
            opacity: 0;
        }

        .fade-in-3 {
            animation: fadeInUp 0.6s ease 0.3s forwards;
            opacity: 0;
        }

        .fade-in-4 {
            animation: fadeInUp 0.6s ease 0.45s forwards;
            opacity: 0;
        }

        .fade-in-5 {
            animation: fadeInUp 0.6s ease 0.6s forwards;
            opacity: 0;
        }
    </style>
</head>

<body class="bg-gray-950 text-white min-h-screen flex">

    {{-- LEFT SIDE — Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900 border-r border-gray-800 flex-col items-center justify-center p-12">

        {{-- Background blobs --}}
        <div class="absolute top-20 left-10 w-72 h-72 bg-orange-500/8 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-orange-600/8 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Grid pattern --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none"
            style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 40px 40px;">
        </div>

        <div class="relative z-10 w-full max-w-sm">

            {{-- Logo --}}
            <div class="flex items-center gap-2 mb-10">
                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-xl font-bold">
                    <span class="text-orange-500">Esports</span><span class="text-white">Track</span>
                </span>
            </div>

            {{-- Headline --}}
            <h1 class="text-3xl font-bold leading-tight mb-3">
                Track Every <br><span class="text-orange-500">Esports</span> Moment.
            </h1>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                The all-in-one platform for esports events, live scores, team rosters, and tournament results — all in one place.
            </p>

            {{-- Feature pills --}}
            <div class="flex flex-wrap gap-2 mb-10">
                <span class="bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full">
                    🔴 Live match tracking
                </span>
                <span class="bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full">
                    🏆 Tournament brackets
                </span>
                <span class="bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full">
                    👥 Team rosters
                </span>
                <span class="bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full">
                    📊 Match results
                </span>
                <span class="bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full">
                    🎮 PC & Mobile games
                </span>
            </div>

            {{-- Floating cards — stacked neatly --}}
            <div class="space-y-3">

                {{-- Card 1 - Live match --}}
                <div class="card-a bg-gray-800/80 backdrop-blur border border-gray-700 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-400">Live Now</p>
                        <p class="text-white text-sm font-semibold truncate">MPL Philippines Season 15</p>
                    </div>
                    <span class="text-orange-500 text-xs font-medium flex-shrink-0">₱3M</span>
                </div>

                {{-- Card 2 - Stats --}}
                <div class="card-b bg-gray-800/80 backdrop-blur border border-gray-700 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-400">Peak Viewers</p>
                        <p class="text-white text-sm font-bold">1,200,000+</p>
                    </div>
                    <span class="text-green-400 text-xs">↑ 24%</span>
                </div>

                {{-- Card 3 - Upcoming --}}
                <div class="card-c bg-gray-800/80 backdrop-blur border border-gray-700 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-400">Upcoming</p>
                        <p class="text-white text-sm font-semibold truncate">The International 2026</p>
                    </div>
                    <span class="text-orange-500 text-xs font-medium flex-shrink-0">$15M</span>
                </div>

            </div>

            {{-- Stats row --}}
            <div class="flex gap-6 mt-8 pt-6 border-t border-gray-800">
                <div>
                    <p class="text-lg font-bold text-orange-500">19+</p>
                    <p class="text-xs text-gray-500 mt-0.5">Teams tracked</p>
                </div>
                <div>
                    <p class="text-lg font-bold text-orange-500">12</p>
                    <p class="text-xs text-gray-500 mt-0.5">Games covered</p>
                </div>
                <div>
                    <p class="text-lg font-bold text-orange-500">5</p>
                    <p class="text-xs text-gray-500 mt-0.5">Live events</p>
                </div>
                <div>
                    <p class="text-lg font-bold text-orange-500">4</p>
                    <p class="text-xs text-gray-500 mt-0.5">Live matches</p>
                </div>
            </div>

        </div>
    </div>

    {{-- RIGHT SIDE — Login Form --}}
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center px-6 py-12">

        {{-- Mobile logo --}}
        <div class="lg:hidden flex items-center gap-2 mb-10">
            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="text-xl font-bold">
                <span class="text-orange-500">Esports</span><span class="text-white">Track</span>
            </span>
        </div>

        <div class="w-full max-w-md">

            <div class="fade-in-1">
                <h2 class="text-2xl font-bold mb-1">Welcome back</h2>
                <p class="text-gray-400 text-sm mb-8">Sign in to your EsportsTrack account</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="fade-in-2">
                    <label class="block text-sm text-gray-400 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                  focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                                  placeholder-gray-600 transition"
                        placeholder="@sample.com">
                </div>

                {{-- Password --}}
                <div class="fade-in-3">
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-sm text-gray-400">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-orange-500 hover:text-orange-400 transition">
                            Forgot password?
                        </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                      focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                                      placeholder-gray-600 transition pr-11"
                            placeholder="password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="fade-in-4 flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-orange-500 focus:ring-orange-500/30">
                    <label for="remember" class="text-sm text-gray-400 cursor-pointer">Remember me for 30 days</label>
                </div>

                {{-- Submit --}}
                <div class="fade-in-5">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-semibold
                                   py-3 rounded-xl transition-all text-sm tracking-wide">
                        Sign in to EsportsTrack
                    </button>
                </div>

            </form>

            {{-- Trusted by text --}}
            <div class="mt-8 pt-6 border-t border-gray-800 text-center">
                <p class="text-xs text-gray-600 mb-3">Trusted by esports enthusiasts tracking</p>
                <div class="flex justify-center gap-4 text-xs text-gray-500">
                    <span>🎮 CS2</span>
                    <span>🎯 Valorant</span>
                    <span>⚔️ MLBB</span>
                    <span>🏆 Dota 2</span>
                    <span>📱 PUBG Mobile</span>
                </div>
            </div>

            {{-- Sign up link --}}
            <div class="mt-6 pt-6 border-t border-gray-800 text-center">
                <p class="text-sm text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                        class="text-orange-500 hover:text-orange-400 font-semibold transition">
                        Sign up
                    </a>
                </p>

                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-xs text-gray-600 hover:text-gray-400 transition">
                        ← Back to EsportsTrack
                    </a>
                </div>

            </div>
        </div>

        <script>
            function togglePassword() {
                const pwd = document.getElementById('password');
                const icon = document.getElementById('eye-icon');
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>`;
                } else {
                    pwd.type = 'password';
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                }
            }
        </script>

</body>

</html>