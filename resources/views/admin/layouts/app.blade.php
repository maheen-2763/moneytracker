<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- SEO Meta Tags --}}
    <meta name="description"
        content="MoneyTracker — Track expenses, set budgets, and get alerts. A production-grade personal finance app built with Laravel 11.">
    <meta name="keywords" content="money tracker, expense tracker, budget, personal finance, Laravel">
    <meta name="author" content="Mohammed Maheen Afzal">
    <meta name="robots" content="index, follow">

    {{-- Open Graph (for social sharing) --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="MoneyTracker — Your finances, finally under control.">
    <meta property="og:description" content="Track expenses, set budgets, get alerts — all in one beautiful dashboard.">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="MoneyTracker">
    <meta name="twitter:description" content="Track expenses, set budgets, get alerts.">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📈</text></svg>">

    {{-- Theme color (mobile browser bar) --}}
    <meta name="theme-color" content="#6366f1">
    <title>Admin — @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <script>
        if (
            localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        }
    </script>

</head>

<body class="font-sans bg-gray-50 dark:bg-gray-950">

    <div class="flex min-h-screen">

        {{-- ── Sidebar ── --}}
        <aside
            class="w-64 bg-indigo-950 dark:bg-slate-900 fixed h-screen z-50 overflow-y-auto
                    border-r border-indigo-900 dark:border-slate-800">

            {{-- Brand --}}
            <div class="px-6 py-5 border-b border-indigo-900 dark:border-slate-800">
                <div class="flex items-center gap-2 text-white font-bold text-lg tracking-tight">

                    <x-app-logo size="md" :dark="true" />
                </div>
                <p class="text-xs text-indigo-300 mt-3">Admin Panel</p>
            </div>

            {{-- Navigation --}}
            <nav class="p-4 space-y-6">

                {{-- Overview Section --}}
                <div>
                    <p class="text-xs font-bold text-indigo-300 uppercase tracking-wider mb-3 px-3">
                        Overview
                    </p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-indigo-200 hover:bg-indigo-900 dark:hover:bg-slate-800
                               transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-900 dark:bg-slate-800 text-white border-l-2 border-indigo-300' : 'border-l-2 border-transparent' }}">
                        <i class="bi bi-grid-1x2 text-lg"></i>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                </div>

                {{-- Management Section --}}
                <div>
                    <p class="text-xs font-bold text-indigo-300 uppercase tracking-wider mb-3 px-3">
                        Management
                    </p>
                    <div class="space-y-2">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center justify-between px-4 py-2.5 rounded-lg text-indigo-200 hover:bg-indigo-900 dark:hover:bg-slate-800
                                   transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-indigo-900 dark:bg-slate-800 text-white border-l-2 border-indigo-300' : 'border-l-2 border-transparent' }}">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-people text-lg"></i>
                                <span class="text-sm font-medium">Users</span>
                            </div>
                            <span
                                class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                       bg-red-500/20 text-red-300">
                                {{ \App\Models\User::count() }}
                            </span>
                        </a>

                        <a href="{{ route('admin.expenses.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-indigo-200 hover:bg-indigo-900 dark:hover:bg-slate-800
                                   transition-colors {{ request()->routeIs('admin.expenses.*') ? 'bg-indigo-900 dark:bg-slate-800 text-white border-l-2 border-indigo-300' : 'border-l-2 border-transparent' }}">
                            <i class="bi bi-receipt text-lg"></i>
                            <span class="text-sm font-medium">All Expenses</span>
                        </a>
                    </div>
                </div>

                {{-- Account Section --}}
                <div>
                    <p class="text-xs font-bold text-indigo-300 uppercase tracking-wider mb-3 px-3">
                        Account
                    </p>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-300 hover:bg-red-900/30
                                   transition-colors border-l-2 border-transparent">
                            <i class="bi bi-box-arrow-left text-lg"></i>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>

            </nav>

        </aside>

        {{-- ── Main Content ── --}}
        <div class="flex-1 ml-64">

            {{-- ── Top Navigation ── --}}
            <nav class="sticky top-0 z-40 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        @yield('title', 'Dashboard')
                    </h2>

                    <div class="flex items-center gap-4">
                        <button id="darkToggle"
                            class="w-9 h-9 flex items-center justify-center
                   rounded-lg text-gray-500
                   hover:bg-gray-100 dark:hover:bg-gray-800
                   transition">
                            <i class="bi bi-moon-stars text-lg" id="darkIcon"></i>
                        </button>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 dark:bg-red-900/30
                                   text-red-700 dark:text-red-300">
                            Admin
                        </span>
                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                            {{ Auth::guard('admin')->user()->name }}
                        </span>
                    </div>
                </div>
            </nav>

            {{-- ── Page Content ── --}}
            <main class="p-6 lg:p-8">

                {{-- Alerts --}}
                @if (session('success'))
                    <div
                        class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20
                            border border-green-200 dark:border-green-900/40 text-green-800 dark:text-green-300">
                        <i class="bi bi-check-circle text-lg flex-shrink-0"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()"
                            class="ml-auto text-green-600 dark:text-green-400 hover:text-green-700">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20
                            border border-red-200 dark:border-red-900/40 text-red-800 dark:text-red-300">
                        <i class="bi bi-exclamation-circle text-lg flex-shrink-0"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()"
                            class="ml-auto text-red-600 dark:text-red-400 hover:text-red-700">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @yield('content')

            </main>

        </div>

    </div>

    @stack('scripts')

    <script>
        /* ── Dark Mode ── */
        const darkToggle = document.getElementById('darkToggle');
        const darkIcon = document.getElementById('darkIcon');

        function applyTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                darkIcon?.classList.remove('bi-moon-stars');
                darkIcon?.classList.add('bi-sun');
            } else {
                document.documentElement.classList.remove('dark');
                darkIcon?.classList.remove('bi-sun');
                darkIcon?.classList.add('bi-moon-stars');
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        darkToggle?.addEventListener('click', () => {
            const nextTheme = document.documentElement.classList.contains('dark') ?
                'light' : 'dark';
            localStorage.setItem('theme', nextTheme);
            applyTheme(nextTheme);
        });
    </script>
</body>

</html>
