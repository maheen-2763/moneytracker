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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    @include('components.sidebar')

    @include('components.navbar', ['title' => View::yieldContent('title')])

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
            sidebar.classList.add('show');
            overlay.classList.add('show');
            toggle?.classList.add('open');
            document.body.style.overflow = 'hidden'; // prevent bg scroll
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            toggle?.classList.remove('open');
            document.body.style.overflow = '';
        }

        toggle?.addEventListener('click', () => {
            sidebar.classList.contains('show') ? closeSidebar() : openSidebar();
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

</body>

</html>
