<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — EsportsTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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

        .fade-in-6 {
            animation: fadeInUp 0.6s ease 0.75s forwards;
            opacity: 0;
        }
    </style>
</head>

<body class="bg-gray-950 text-white min-h-screen flex">

    {{-- LEFT SIDE — Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900 border-r border-gray-800 flex-col items-center justify-center p-12">

        <div class="absolute top-20 left-10 w-72 h-72 bg-orange-500/8 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-orange-600/8 rounded-full blur-3xl pointer-events-none"></div>
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

            <h1 class="text-3xl font-bold leading-tight mb-3">
                Join the <br><span class="text-orange-500">Esports</span> Community.
            </h1>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                Create your account and start organizing your own local tournaments, build your team, and track every match.
            </p>

            {{-- What you can do --}}
            <div class="space-y-3">
                <div class="flex items-center gap-4 bg-gray-800/60 border border-gray-700 rounded-xl p-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">Create your team</p>
                        <p class="text-gray-500 text-xs mt-0.5">Build and manage your own roster</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800/60 border border-gray-700 rounded-xl p-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">Organize tournaments</p>
                        <p class="text-gray-500 text-xs mt-0.5">Local, national or international</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800/60 border border-gray-700 rounded-xl p-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">Track match results</p>
                        <p class="text-gray-500 text-xs mt-0.5">Record scores and standings</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- RIGHT SIDE — Register Form --}}
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
                <h2 class="text-2xl font-bold mb-1">Create your account</h2>
                <p class="text-gray-400 text-sm mb-8">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-400 transition">Sign in</a>
                </p>
            </div>

            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div class="fade-in-2">
                    <label class="block text-sm text-gray-400 mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                               focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                               placeholder-gray-600 transition"
                        placeholder="Juan dela Cruz">
                </div>

                {{-- Username --}}
                <div class="fade-in-2">
                    <label class="block text-sm text-gray-400 mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-sm">@</span>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl pl-8 pr-4 py-3 text-white text-sm
                                   focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                                   placeholder-gray-600 transition"
                            placeholder="juandelacruz">
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Letters, numbers, underscores and dashes only</p>
                </div>

                {{-- Email --}}
                <div class="fade-in-3">
                    <label class="block text-sm text-gray-400 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                               focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                               placeholder-gray-600 transition"
                        placeholder="example@email.com">
                </div>

                {{-- Password --}}
                <div class="fade-in-4">
                    <label class="block text-sm text-gray-400 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                   focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                                   placeholder-gray-600 transition pr-11"
                            placeholder="Min. 8 characters">
                        <button type="button" onclick="togglePassword('password', 'eye-1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <svg id="eye-1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="fade-in-5">
                    <label class="block text-sm text-gray-400 mb-1.5">Confirm password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                   focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                                   placeholder-gray-600 transition pr-11"
                            placeholder="Confirm your password">
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <svg id="eye-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="fade-in-6">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-semibold
                               py-3 rounded-xl transition-all text-sm tracking-wide">
                        Create Account
                    </button>
                </div>

            </form>

            {{-- Terms --}}
            <p class="fade-in-6 text-xs text-gray-600 text-center mt-6">
                By creating an account you agree to our
                <span class="text-gray-500">Terms of Service</span> and
                <span class="text-gray-500">Privacy Policy</span>
            </p>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-xs text-gray-600 hover:text-gray-400 transition">
                    ← Back to EsportsTrack
                </a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>`;
            } else {
                field.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }
    </script>

</body>

</html>