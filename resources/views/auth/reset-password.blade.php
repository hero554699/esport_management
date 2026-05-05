<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — EsportsTrack</title>
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
                Almost <br><span class="text-orange-500">back in.</span>
            </h1>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                Choose a strong new password to secure your EsportsTrack account.
            </p>

            {{-- Password tips --}}
            <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-5 space-y-3">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Password tips</p>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <div class="w-1.5 h-1.5 bg-orange-500 rounded-full flex-shrink-0"></div>
                        At least 8 characters long
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <div class="w-1.5 h-1.5 bg-orange-500 rounded-full flex-shrink-0"></div>
                        Mix of uppercase and lowercase
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <div class="w-1.5 h-1.5 bg-orange-500 rounded-full flex-shrink-0"></div>
                        Include numbers or symbols
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <div class="w-1.5 h-1.5 bg-orange-500 rounded-full flex-shrink-0"></div>
                        Don't reuse old passwords
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

            <div class="fade-in-1 w-14 h-14 bg-orange-500/15 border border-orange-500/30 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <div class="fade-in-1">
                <h2 class="text-2xl font-bold mb-1">Set new password</h2>
                <p class="text-gray-400 text-sm mb-8">Make it strong and memorable.</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="fade-in-2">
                    <label class="block text-sm text-gray-400 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                        class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                               focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                               placeholder-gray-600 transition"
                        placeholder="example@email.com">
                </div>

                <div class="fade-in-3">
                    <label class="block text-sm text-gray-400 mb-1.5">New password</label>
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

                <div class="fade-in-4">
                    <label class="block text-sm text-gray-400 mb-1.5">Confirm new password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm
                                   focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/20
                                   placeholder-gray-600 transition pr-11"
                            placeholder="Repeat your password">
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <svg id="eye-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="fade-in-5">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-semibold
                               py-3 rounded-xl transition-all text-sm tracking-wide">
                        Reset Password
                    </button>
                </div>

            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-xs text-gray-600 hover:text-gray-400 transition">
                    ← Back to login
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