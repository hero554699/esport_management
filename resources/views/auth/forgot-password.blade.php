<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — EsportsTrack</title>
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
                Secure Your <br><span class="text-orange-500">Account.</span>
            </h1>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                No worries — it happens. Enter your email and we'll send you a link to reset your password and get back in the game.
            </p>

            {{-- Steps --}}
            <div class="space-y-4">
                <div class="flex items-center gap-4 bg-gray-800/60 border border-gray-700 rounded-xl p-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-orange-500 text-sm font-bold">1</span>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">Enter your email</p>
                        <p class="text-gray-500 text-xs mt-0.5">The one linked to your account</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800/60 border border-gray-700 rounded-xl p-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-orange-500 text-sm font-bold">2</span>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">Check your inbox</p>
                        <p class="text-gray-500 text-xs mt-0.5">We'll send a reset link right away</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800/60 border border-gray-700 rounded-xl p-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-orange-500 text-sm font-bold">3</span>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">Set a new password</p>
                        <p class="text-gray-500 text-xs mt-0.5">Back to tracking in seconds</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- RIGHT SIDE — Form --}}
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

            {{-- Icon --}}
            <div class="fade-in-1 w-14 h-14 bg-orange-500/15 border border-orange-500/30 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>

            <div class="fade-in-1">
                <h2 class="text-2xl font-bold mb-1">Forgot your password?</h2>
                <p class="text-gray-400 text-sm mb-8">
                    Enter your email and we'll send you a reset link.
                </p>
            </div>

            {{-- Success message --}}
            @if (session('status'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('status') }}
            </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div class="fade-in-2">
                    <label class="block text-sm text-gray-400 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                               focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                               placeholder-gray-600 transition"
                        placeholder="example@email.com">
                </div>

                <div class="fade-in-3">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-semibold
                               py-3 rounded-xl transition-all text-sm tracking-wide">
                        Send Reset Link
                    </button>
                </div>

            </form>

            <div class="fade-in-4 mt-6 flex flex-col gap-3 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-orange-500 transition flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to login
                </a>
                <a href="{{ route('home') }}" class="text-xs text-gray-600 hover:text-gray-400 transition">
                    ← Back to EsportsTrack
                </a>
            </div>

        </div>
    </div>

</body>

</html>