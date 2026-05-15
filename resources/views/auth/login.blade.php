<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-[Plus_Jakarta_Sans] bg-gray-950 min-h-screen flex">

    {{-- ── Left Panel ── --}}
    <div
        class="hidden md:flex w-[45%] flex-col justify-center items-center px-12
                bg-gradient-to-br from-indigo-950 via-indigo-900 to-indigo-700
                relative overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute w-96 h-96 rounded-full bg-white/[0.03] -top-24 -left-24"></div>
        <div class="absolute w-72 h-72 rounded-full bg-white/[0.05] -bottom-20 -right-20"></div>

        {{-- Brand --}}


        <div class="z-10 w-full max-w-xs">
            <x-app-logo size="lg" :dark="true" />
            <p class="text-indigo-300 text-sm mb-4 mt-2">
                Your personal finance companion
            </p>

            {{-- Features --}}
            <ul class="space-y-0 divide-y divide-white/10">
                @foreach ([['bi-bar-chart-line', 'Track expenses by category'], ['bi-piggy-bank', 'Set monthly budget limits'], ['bi-bell', 'Get budget exceeded alerts'], ['bi-file-earmark-arrow-down', 'Export to PDF & Excel'], ['bi-phone', 'Works on all devices']] as [$icon, $text])
                    <li class="flex items-center gap-3 py-3 text-sm text-indigo-100">
                        <span
                            class="w-7 h-7 rounded-lg bg-white/10
                                     flex items-center justify-center shrink-0">
                            <i class="bi {{ $icon }} text-xs"></i>
                        </span>
                        {{ $text }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- ── Right Panel ── --}}
    <div class="flex-1 flex items-center justify-center p-6
                bg-white md:bg-white">

        <div class="w-full max-w-sm">

            {{-- Mobile brand --}}
            <div class="md:hidden text-center mb-8">
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    <i class="bi bi-wallet2 mr-1 text-indigo-500"></i>
                    Money<span class="text-indigo-500">Tracker</span>
                </h1>
            </div>
            <div class="mb-3 ml-14">
                <x-app-logo size="lg" :dark="false" />
            </div>


            <p class="text-sm text-gray-500 mt-1 mb-5">
                Sign in to your MoneyTracker account
            </p>

            {{-- Error --}}
            @if ($errors->any())
                <div
                    class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl
                            bg-red-50 border border-red-200 text-red-700 text-sm">
                    <i class="bi bi-exclamation-circle shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Success --}}
            @if (session('status'))
                <div
                    class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl
                            bg-green-50 border border-green-200 text-green-700 text-sm">
                    <i class="bi bi-check-circle shrink-0"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-widest
                                  text-gray-500 mb-1.5">
                        Email Address
                    </label>
                    <div class="relative">
                        <i
                            class="bi bi-envelope absolute left-3.5 top-1/2 -translate-y-1/2
                                  text-gray-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                            autofocus required
                            class="w-full rounded-xl pl-10 pr-4 py-2.5 text-sm
                                      border border-gray-200 text-gray-900
                                      placeholder:text-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition
                                      @error('email') border-red-400 @enderror">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                      text-gray-500">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <i
                            class="bi bi-lock absolute left-3.5 top-1/2 -translate-y-1/2
                                  text-gray-400 text-sm"></i>
                        <input type="password" name="password" id="passwordInput" placeholder="••••••••" required
                            class="w-full rounded-xl pl-10 pr-10 py-2.5 text-sm
                                      border border-gray-200 text-gray-900
                                      placeholder:text-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition
                                      @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2
                                   text-gray-400 hover:text-indigo-500 transition">
                            <i class="bi bi-eye text-sm" id="passIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded accent-indigo-500">
                    <label for="remember" class="text-sm text-gray-500 cursor-pointer">
                        Keep me signed in
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-2.5 rounded-xl
                           bg-indigo-500 hover:bg-indigo-600
                           text-white text-sm font-bold
                           hover:-translate-y-0.5 transition-all duration-200">
                    Sign In →
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-bold text-indigo-500 hover:text-indigo-600">
                    Create one for free
                </a>
            </p>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('passIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>

</body>

</html>
