<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ✅ CHANGED: allows each view to set its own title --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-loading');
        }
    </script>
    <style>
        .dark-loading * {
            transition: none !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ ADDED: for page-specific CSS --}}
    @stack('styles')
</head>

<body>

    {{-- ✅ FIXED: Only show sidebar & navbar to authenticated users --}}
    @auth
        @include('components.sidebar')
        @include('components.navbar', ['title' => $title ?? 'Dashboard'])
    @endauth

    <main id="main-content">
        @include('components.alert')

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            sidebar?.classList.add('show');
            overlay?.classList.add('show');
            toggle?.classList.add('open');
            document.body.style.overflow = 'hidden'; // prevent bg scroll
        }

        function closeSidebar() {
            sidebar?.classList.remove('show');
            overlay?.classList.remove('show');
            toggle?.classList.remove('open');
            document.body.style.overflow = '';
        }

        toggle?.addEventListener('click', () => {
            sidebar?.classList.contains('show') ? closeSidebar() : openSidebar();
        });

        overlay?.addEventListener('click', closeSidebar);
        closeBtn?.addEventListener('click', closeSidebar);

        // Close sidebar when a nav link is clicked on mobile
        document.querySelectorAll('#sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) closeSidebar();
            });
        });

        // Tooltips init
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
                .forEach(el => new bootstrap.Tooltip(el));
        });
        // ── Dark Mode ──────────────────────────
        const darkToggle = document.getElementById('darkToggle');
        const darkIcon = document.getElementById('darkIcon');

        function applyTheme(theme) {
            if (theme === 'dark') {
                document.body.classList.add('dark');
                darkIcon?.classList.replace('bi-moon-stars', 'bi-sun');
            } else {
                document.body.classList.remove('dark');
                darkIcon?.classList.replace('bi-sun', 'bi-moon-stars');
            }
        }

        // Apply saved theme on load
        applyTheme(localStorage.getItem('theme') || 'light');

        darkToggle?.addEventListener('click', () => {
            const next = document.body.classList.contains('dark') ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    </script>

    {{-- ── Toast Notifications ── --}}
    <div id="toast-container" aria-live="polite"></div>

    @if (session('toast_success'))
        <div class="d-none" id="flash-success">{{ session('toast_success') }}</div>
    @endif
    @if (session('toast_error'))
        <div class="d-none" id="flash-error">{{ session('toast_error') }}</div>
    @endif
    @if (session('toast_warning'))
        <div class="d-none" id="flash-warning">{{ session('toast_warning') }}</div>
    @endif
    <script>
        /* ── Toast System ── */
        const TOAST_ICONS = {
            success: 'bi-check-lg',
            error: 'bi-x-lg',
            warning: 'bi-exclamation-lg',
        };

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');

            const toast = document.createElement('div');
            toast.className = `toast-item toast-${type}`;
            toast.innerHTML = `
        <div class="toast-icon">
            <i class="bi ${TOAST_ICONS[type]}"></i>
        </div>
        <span>${message}</span>
        <button class="toast-close" onclick="dismissToast(this.parentElement)">
            <i class="bi bi-x"></i>
        </button>
        <div class="toast-progress"></div>
    `;

            container.appendChild(toast);

            // Auto dismiss after 3.5s
            setTimeout(() => dismissToast(toast), 3500);
        }

        function dismissToast(toast) {
            if (!toast || toast.classList.contains('hiding')) return;
            toast.classList.add('hiding');
            setTimeout(() => toast.remove(), 300);
        }

        // ── Fire flash messages on page load ──
        document.addEventListener('DOMContentLoaded', () => {
            const success = document.getElementById('flash-success');
            const error = document.getElementById('flash-error');
            const warning = document.getElementById('flash-warning');

            if (success) showToast(success.textContent.trim(), 'success');
            if (error) showToast(error.textContent.trim(), 'error');
            if (warning) showToast(warning.textContent.trim(), 'warning');
        });
    </script>

</body>

</html>
