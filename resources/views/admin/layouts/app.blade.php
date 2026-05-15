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
            <div class="px-6 py-6 border-b border-indigo-900 dark:border-slate-800">
                <div class="flex items-center gap-2 text-white font-bold text-lg tracking-tight">
                    <x-app-logo size="md" :dark="true" />
                </div>
                <p class="text-xs text-indigo-300 mt-2">Admin Panel</p>
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


                        {{-- ── Profile Dropdown ── --}}
                        <div class="relative" id="profileDropdown">
                            <button
                                class="flex items-center gap-3 px-3 py-1.5 rounded-lg
                                       hover:bg-gray-100 dark:hover:bg-gray-800
                                       transition-colors"
                                onclick="toggleProfileMenu(event)">
                                <div class="flex items-center gap-2">
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ Auth::guard('admin')->user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Admin
                                        </p>
                                    </div>
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600
                                               flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                                    </div>
                                    <i class="bi bi-chevron-down text-sm text-gray-500 dark:text-gray-400"></i>
                                </div>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div id="profileMenu"
                                class="hidden absolute right-0 mt-2 w-56 rounded-lg
                                       bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
                                       shadow-lg z-50">

                                {{-- Profile Header --}}
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ Auth::guard('admin')->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ Auth::guard('admin')->user()->email }}
                                    </p>
                                </div>

                                {{-- Menu Items --}}
                                <div class="py-2">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                        <i class="bi bi-speedometer2 text-gray-500 dark:text-gray-400"></i>
                                        Dashboard
                                    </a>

                                    <button onclick="toggleDarkMode()"
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                        <i id="modeIcon" class="bi bi-moon-stars text-gray-500 dark:text-gray-400"></i>
                                        <span id="modeText">Dark Mode</span>
                                    </button>
                                </div>

                                {{-- Divider --}}
                                <div class="border-t border-gray-200 dark:border-gray-800"></div>

                                {{-- Logout --}}
                                <div class="py-2">
                                    <form method="POST" action="{{ route('admin.logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 dark:text-red-400
                                                   hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <i class="bi bi-box-arrow-left"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </nav>

            {{-- ── Page Content ── --}}
            <main class="p-6 lg:p-8">

                {{-- Toast Notifications --}}
                <div id="toast-container"
                    class="fixed top-5 left-1/2 -translate-x-1/2 z-[9999] space-y-3 flex flex-col items-center">
                </div>

                {{-- Flash Messages --}}
                @if (session('toast_success'))
                    <div class="hidden" id="flash-success">
                        {{ session('toast_success') }}
                    </div>
                @endif

                @if (session('toast_error'))
                    <div class="hidden" id="flash-error">
                        {{ session('toast_error') }}
                    </div>
                @endif

                @if (session('toast_warning'))
                    <div class="hidden" id="flash-warning">
                        {{ session('toast_warning') }}
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
                document.getElementById('modeIcon')?.classList.remove('bi-moon-stars');
                document.getElementById('modeIcon')?.classList.add('bi-sun');
                document.getElementById('modeText').textContent = 'Light Mode';
            } else {
                document.documentElement.classList.remove('dark');
                darkIcon?.classList.remove('bi-sun');
                darkIcon?.classList.add('bi-moon-stars');
                document.getElementById('modeIcon')?.classList.remove('bi-sun');
                document.getElementById('modeIcon')?.classList.add('bi-moon-stars');
                document.getElementById('modeText').textContent = 'Dark Mode';
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

        /* ── Profile Dropdown ── */
        function toggleProfileMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileMenu');
            menu?.classList.toggle('hidden');
        }

        function toggleDarkMode() {
            const nextTheme = document.documentElement.classList.contains('dark') ?
                'light' : 'dark';
            localStorage.setItem('theme', nextTheme);
            applyTheme(nextTheme);
            document.getElementById('profileMenu')?.classList.add('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profileDropdown');
            const menu = document.getElementById('profileMenu');
            if (!dropdown?.contains(e.target)) {
                menu?.classList.add('hidden');
            }
        });



        /* ─────────────────────────────────────
           Toast System
        ───────────────────────────────────── */

        const TOAST_CONFIG = {
            success: {
                icon: 'bi-check-circle-fill',
                color: 'text-green-500',
                timer: 'bg-green-500',
                bg: 'bg-green-100 dark:bg-gray-900',
                border: 'border-green-200 dark:border-green-900/40',
            },
            error: {
                icon: 'bi-x-circle-fill',
                color: 'text-red-500',
                timer: 'bg-red-500',
                bg: 'bg-red-100 dark:bg-gray-900',
                border: 'border-red-200 dark:border-red-900/40',
            },
            warning: {
                icon: 'bi-exclamation-circle-fill',
                color: 'text-yellow-500',
                timer: 'bg-yellow-500',
                bg: 'bg-yellow-100 dark:bg-gray-900',
                border: 'border-yellow-200 dark:border-yellow-900/40',
            },
        };

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const config = TOAST_CONFIG[type] ?? TOAST_CONFIG.success;
            const duration = 3500;

            const toast = document.createElement('div');
            toast.className = `
        relative overflow-hidden
        flex items-center gap-3
        min-w-[280px] max-w-[360px]
        px-4 py-3 rounded-2xl
        border shadow-xl
        ${config.bg} ${config.border}
        translate-x-0 opacity-100
        transition-all duration-300
    `;

            toast.innerHTML = `
        {{-- Icon --}}
        <i class="bi ${config.icon} ${config.color} text-lg shrink-0"></i>

        {{-- Message --}}
        <span class="text-sm font-medium text-gray-800 dark:text-white flex-1">
            ${message}
        </span>

        {{-- Close button --}}
        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300
                       transition shrink-0">
            <i class="bi bi-x-lg text-xs"></i>
        </button>

        {{-- Timer bar --}}
        <div class="absolute bottom-0 left-0 right-0 h-0.5 ${config.timer}
                    rounded-full origin-left timer-bar"
             style="animation: shrink ${duration}ms linear forwards;">
        </div>
    `;

            toast.querySelector('button')
                .addEventListener('click', () => dismissToast(toast));

            container.appendChild(toast);

            setTimeout(() => dismissToast(toast), duration);
        }

        function dismissToast(toast) {
            toast.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }
        document.addEventListener('DOMContentLoaded', () => {

            const success =
                document.getElementById('flash-success');

            const error =
                document.getElementById('flash-error');

            const warning =
                document.getElementById('flash-warning');

            if (success) {
                showToast(success.textContent.trim(), 'success');
            }

            if (error) {
                showToast(error.textContent.trim(), 'error');
            }

            if (warning) {
                showToast(warning.textContent.trim(), 'warning');
            }

        });
    </script>
</body>

</html>
