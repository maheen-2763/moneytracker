<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-[Plus_Jakarta_Sans] bg-gray-50 dark:bg-gray-950
             min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <x-app-logo size="lg" :dark="false" />
        </div>

        {{-- Card --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-8 pt-8 pb-6 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl
                                bg-indigo-100 dark:bg-indigo-900/30
                                flex items-center justify-center shrink-0">
                        <i class="bi bi-key text-indigo-500 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                            Reset Password
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Choose a strong new password
                        </p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-8 py-6">

                {{-- Error --}}
                @if ($errors->any())
                    <div
                        class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl
                                bg-red-50 dark:bg-red-900/20
                                border border-red-200 dark:border-red-900/40
                                text-red-700 dark:text-red-400 text-sm">
                        <i class="bi bi-exclamation-circle shrink-0"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    {{-- Token --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email --}}
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                            Email Address
                        </label>
                        <div class="relative">
                            <i
                                class="bi bi-envelope absolute left-3.5 top-1/2 -translate-y-1/2
                                      text-gray-400 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                                readonly
                                class="w-full rounded-xl pl-10 pr-4 py-2.5 text-sm
                                          border border-gray-200 dark:border-gray-700
                                          bg-gray-50 dark:bg-gray-800
                                          text-gray-500 dark:text-gray-400
                                          focus:outline-none transition">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                            New Password
                        </label>
                        <div class="relative">
                            <i
                                class="bi bi-lock absolute left-3.5 top-1/2 -translate-y-1/2
                                      text-gray-400 text-sm"></i>
                            <input type="password" name="password" id="passwordInput" placeholder="Min. 8 characters"
                                required
                                class="w-full rounded-xl pl-10 pr-10 py-2.5 text-sm
                                          border border-gray-200 dark:border-gray-700
                                          bg-white dark:bg-gray-800
                                          text-gray-900 dark:text-white
                                          placeholder:text-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                          focus:border-indigo-500 transition
                                          @error('password') border-red-400 @enderror">
                            <button type="button" onclick="togglePassword('passwordInput', 'passIcon')"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2
                                           text-gray-400 hover:text-indigo-500 transition">
                                <i class="bi bi-eye text-sm" id="passIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <i
                                class="bi bi-lock-fill absolute left-3.5 top-1/2 -translate-y-1/2
                                      text-gray-400 text-sm"></i>
                            <input type="password" name="password_confirmation" id="confirmInput"
                                placeholder="Repeat password" required
                                class="w-full rounded-xl pl-10 pr-10 py-2.5 text-sm
                                          border border-gray-200 dark:border-gray-700
                                          bg-white dark:bg-gray-800
                                          text-gray-900 dark:text-white
                                          placeholder:text-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                          focus:border-indigo-500 transition">
                            <button type="button" onclick="togglePassword('confirmInput', 'confirmIcon')"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2
                                           text-gray-400 hover:text-indigo-500 transition">
                                <i class="bi bi-eye text-sm" id="confirmIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-bold
                               hover:-translate-y-0.5 transition-all duration-200">
                        Reset Password →
                    </button>

                </form>

            </div>

            {{-- Footer --}}
            <div
                class="px-8 py-4 border-t border-gray-200 dark:border-gray-800
                        bg-gray-50 dark:bg-gray-800/50 text-center">
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-indigo-500 hover:text-indigo-600 transition">
                    ← Back to Login
                </a>
            </div>

        </div>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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
