<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — MoneyTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-[Plus_Jakarta_Sans] bg-gray-950 min-h-screen flex items-center justify-center p-4">

    {{-- Background grid pattern --}}
    <div
        class="absolute inset-0 bg-[linear-gradient(rgba(99,102,241,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(99,102,241,0.03)_1px,transparent_1px)] bg-[size:32px_32px]">
    </div>

    {{-- Glow effect --}}
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                w-[500px] h-[500px] rounded-full
                bg-indigo-500/5 blur-3xl pointer-events-none">
    </div>

    <div class="relative w-full max-w-md">

        {{-- Top badge --}}
        <div class="flex justify-center mb-6">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full
                         bg-red-500/10 border border-red-500/20
                         text-red-400 text-xs font-semibold tracking-widest uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Restricted Access
            </span>
        </div>

        {{-- Card --}}
        <div
            class="rounded-2xl border border-gray-800
                    bg-gray-900/80 backdrop-blur-sm
                    shadow-2xl overflow-hidden">

            {{-- Card Header --}}
            <div class="px-8 pt-8 pb-6 border-b border-gray-800">
                <div class="flex items-center gap-4">

                    {{-- Icon --}}
                    <div
                        class="w-14 h-14 rounded-2xl
                                bg-gradient-to-br from-indigo-600 to-indigo-400
                                flex items-center justify-center
                                shadow-lg shadow-indigo-500/20 shrink-0">
                        <i class="bi bi-shield-check text-white text-2xl"></i>
                    </div>

                    <div>
                        <h1 class="text-xl font-extrabold text-white tracking-tight">
                            Admin Portal
                        </h1>
                        <p class="text-sm text-gray-500 mt-0.5">
                            MoneyTracker Control Panel
                        </p>
                    </div>

                </div>
            </div>

            {{-- Card Body --}}
            <div class="px-8 py-6">

                {{-- Error --}}
                @if ($errors->any())
                    <div
                        class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl
                                bg-red-500/10 border border-red-500/20
                                text-red-400 text-sm">
                        <i class="bi bi-exclamation-circle shrink-0"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                      text-gray-500 mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <i
                                class="bi bi-envelope absolute left-3.5 top-1/2 -translate-y-1/2
                                      text-gray-600 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="admin@moneytracker.com" autofocus required
                                class="w-full rounded-xl pl-10 pr-4 py-2.5 text-sm
                                          bg-gray-800 border border-gray-700
                                          text-white placeholder:text-gray-600
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                          focus:border-indigo-500 transition">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                      text-gray-500 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <i
                                class="bi bi-lock absolute left-3.5 top-1/2 -translate-y-1/2
                                      text-gray-600 text-sm"></i>
                            <input type="password" name="password" id="passwordInput" placeholder="••••••••" required
                                class="w-full rounded-xl pl-10 pr-10 py-2.5 text-sm
                                          bg-gray-800 border border-gray-700
                                          text-white placeholder:text-gray-600
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                          focus:border-indigo-500 transition">
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2
                                       text-gray-600 hover:text-indigo-400 transition">
                                <i class="bi bi-eye text-sm" id="passIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-bold
                               flex items-center justify-center gap-2
                               hover:-translate-y-0.5 transition-all duration-200
                               shadow-lg shadow-indigo-500/20">
                        <i class="bi bi-shield-lock"></i>
                        Sign in as Admin
                    </button>

                </form>

            </div>

            {{-- Card Footer --}}
            <div class="px-8 py-4 border-t border-gray-800 bg-gray-900/50">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-600">
                        Not an admin?
                    </p>
                    <a href="{{ route('login') }}"
                        class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition">
                        ← Back to user login
                    </a>
                </div>
            </div>

        </div>

        {{-- Bottom warning --}}
        <p class="text-center text-xs text-gray-700 mt-6">
            <i class="bi bi-lock-fill mr-1"></i>
            This area is restricted to authorized administrators only
        </p>

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
