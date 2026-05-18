@extends('layouts.app')
@section('title', 'About')

@section('content')

    <div class="max-w-4xl mx-auto space-y-4">

        {{-- ── Hero ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            {{-- Banner --}}
            <div class="h-32 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

            {{-- Profile --}}
            <div class="px-8 pb-8 -mt-12">
                <div
                    class="w-24 h-24 rounded-2xl
                        bg-gradient-to-br from-indigo-500 to-violet-500
                        flex items-center justify-center
                        text-4xl shadow-xl ring-4 ring-white dark:ring-gray-900 mb-4">
                    📈
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    MoneyTracker
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Personal Finance Management · Built with Laravel 11
                </p>

                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach (['Laravel 11', 'PHP 8.2', 'MySQL', 'Tailwind CSS', 'PestPHP', 'Sanctum'] as $tech)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 bg-indigo-50 dark:bg-indigo-900/20
                                 text-indigo-600 dark:text-indigo-400
                                 border border-indigo-200 dark:border-indigo-900/40">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── About the App ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div
                class="flex items-center gap-2 px-6 py-4
                    border-b border-gray-200 dark:border-gray-800">
                <i class="bi bi-info-circle text-indigo-500"></i>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    About the App
                </h2>
            </div>

            <div class="p-8 space-y-5">
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    MoneyTracker is a production-grade personal finance application
                    built as a portfolio project to demonstrate full-stack Laravel
                    development skills. It allows users to track expenses, set monthly
                    budgets, receive alerts, and export detailed reports.
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    The application follows clean architecture principles with a
                    service layer, policy-based authorization, form request validation,
                    and a fully tested codebase with 57 PestPHP tests.
                </p>
            </div>
        </div>

        {{-- ── Features ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div
                class="flex items-center gap-2 px-6 py-4
                    border-b border-gray-200 dark:border-gray-800">
                <i class="bi bi-stars text-indigo-500"></i>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Features
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-gray-100 dark:bg-gray-800">
                @foreach ([['bi-receipt', 'Expense Tracking', 'Full CRUD with soft delete, categories and receipt uploads'], ['bi-piggy-bank', 'Budget Limits', 'Monthly limits per category with progress bars and alerts'], ['bi-bell', 'Smart Alerts', 'Bell notifications and email alerts when budgets are exceeded'], ['bi-bar-chart-line', 'Reports & Export', 'Filter expenses and export to PDF or Excel in one click'], ['bi-shield-lock', '2FA Security', 'Google Authenticator support for account protection'], ['bi-grid-1x2', 'Admin Panel', 'Separate admin guard with full user management'], ['bi-code-slash', 'REST API', 'Sanctum-authenticated API with interactive documentation'], ['bi-envelope', 'Email Notifications', 'Welcome, expense receipt, budget alerts and weekly reports']] as [$icon, $title, $desc])
                    <div class="flex items-start gap-4 p-6
                            bg-white dark:bg-gray-900">
                        <div
                            class="w-9 h-9 rounded-xl shrink-0
                                bg-indigo-50 dark:bg-indigo-900/20
                                flex items-center justify-center">
                            <i class="bi {{ $icon }} text-indigo-500"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $title }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                {{ $desc }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Tech Stack ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div
                class="flex items-center gap-2 px-6 py-4
                    border-b border-gray-200 dark:border-gray-800">
                <i class="bi bi-cpu text-indigo-500"></i>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Tech Stack
                </h2>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ([['Backend', 'Laravel 11, PHP 8.2, MySQL'], ['Frontend', 'Tailwind CSS, Bootstrap Icons, Chart.js, Vanilla JS'], ['Auth', 'Laravel Breeze, Sanctum, 2FA (TOTP)'], ['Testing', 'PestPHP — 57 tests, 117 assertions'], ['Email', 'Mailtrap (dev), Custom Blade templates, Queue'], ['Export', 'DomPDF (PDF), Laravel Excel (XLSX)'], ['Dev Tools', 'Laravel Herd, Vite, Git']] as [$label, $value])
                    <div class="flex items-center justify-between px-6 py-4">
                        <p
                            class="text-xs font-bold uppercase tracking-widest
                               text-gray-400 dark:text-gray-500">
                            {{ $label }}
                        </p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white text-right">
                            {{ $value }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Stats ── --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([['57', 'Tests Passing', 'text-green-500'], ['117', 'Assertions', 'text-indigo-500'], ['15+', 'Features', 'text-violet-500'], ['4', 'Email Types', 'text-amber-500']] as [$num, $label, $color])
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-8 text-center
                        hover:-translate-y-1 hover:shadow-md transition-all duration-200">
                    <p class="text-3xl font-extrabold {{ $color }}">
                        {{ $num }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">
                        {{ $label }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- ── Developer ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div
                class="flex items-center gap-2 px-6 py-4
                    border-b border-gray-200 dark:border-gray-800">
                <i class="bi bi-person-badge text-indigo-500"></i>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Developer
                </h2>
            </div>

            <div class="p-6 flex items-center gap-6 flex-wrap">
                <div
                    class="w-16 h-16 rounded-2xl
                        bg-gradient-to-br from-indigo-500 to-violet-500
                        flex items-center justify-center
                        text-2xl font-extrabold text-white shrink-0">
                    M
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        Mohammed Maheen Afzal
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        Junior Full-Stack Laravel Developer
                    </p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <a href="https://github.com/maheen-2763/moneytracker" target="_blank"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                              text-xs font-semibold
                              bg-gray-900 dark:bg-gray-800
                              text-white hover:bg-gray-700 transition">
                            <i class="bi bi-github"></i>
                            GitHub Repo
                        </a>
                        <a href="{{ route('api.docs') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                              text-xs font-semibold
                              bg-indigo-500 hover:bg-indigo-600
                              text-white transition">
                            <i class="bi bi-code-slash"></i>
                            API Docs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Version ── --}}
        <div class="text-center text-xs text-gray-400 dark:text-gray-600 pb-4">
            MoneyTracker v1.0.0 · Built with ❤️ using Laravel 11 · MIT License
        </div>

    </div>

@endsection
