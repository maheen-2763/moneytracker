<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page Styles --}}
    @stack('styles')

    {{-- Prevent dark-mode flicker --}}
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

<body
    class="font-[Plus_Jakarta_Sans] bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white antialiased transition-colors duration-300">

    {{-- Sidebar + Navbar --}}
    @auth

        @include('components.sidebar')



        @include('components.navbar', [
            'title' => $title ?? 'Dashboard',
        ])

    @endauth

    {{-- Main Content --}}
    <main id="main-content" class="min-h-screen md:ml-60 pt-16 mt-5 px-4 md:px-6">

        @include('components.alert')

        @yield('content')

    </main>

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

    {{-- Page Scripts --}}
    @stack('scripts')

    <script>
        /* ─────────────────────────────────────
                                                                                                                                                           Sidebar
                                                                                                                                                        ───────────────────────────────────── */

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            sidebar?.classList.remove('-translate-x-full');
            overlay?.classList.remove('hidden');

            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar?.classList.add('-translate-x-full');
            overlay?.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');
        }

        toggle?.addEventListener('click', () => {

            if (sidebar?.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }

        });

        overlay?.addEventListener('click', closeSidebar);

        closeBtn?.addEventListener('click', closeSidebar);

        document.querySelectorAll('#sidebar .nav-link')
            .forEach(link => {

                link.addEventListener('click', () => {

                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }

                });

            });

        /* ─────────────────────────────────────
           Dark Mode
        ───────────────────────────────────── */

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

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';

        applyTheme(savedTheme);

        // Toggle
        darkToggle?.addEventListener('click', () => {

            const nextTheme =
                document.documentElement.classList.contains('dark') ?
                'light' :
                'dark';

            localStorage.setItem('theme', nextTheme);

            applyTheme(nextTheme);

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
