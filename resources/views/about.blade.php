{{-- resources/views/about.blade.php --}}

@extends('layouts.app')
@section('title', 'About App')

@section('content')

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- ── HERO ── --}}
        <div
            class="relative overflow-hidden rounded-2xl
               bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700
               p-8 sm:p-12 text-white shadow-xl">

            {{-- Background blobs --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-10">
                <div class="absolute -top-16 -right-16 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                <div class="absolute -bottom-16 -left-16 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10">
                <div
                    class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm
                           flex items-center justify-center text-3xl mb-6">
                    💸
                </div>

                <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight">
                    Expense Tracker
                </h1>

                <p class="mt-4 text-indigo-100 max-w-2xl leading-relaxed text-base sm:text-lg">
                    A modern personal finance management platform designed to help
                    users track expenses, monitor budgets, analyze spending,
                    and build smarter financial habits.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @foreach (['Laravel', 'Tailwind CSS', 'MySQL', 'Dark Mode'] as $tag)
                        <span
                            class="px-4 py-1.5 rounded-lg bg-white/15 backdrop-blur-sm
                                   border border-white/20 text-sm font-medium">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── PURPOSE + APP INFO ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Purpose --}}
            <div
                class="lg:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-8">

                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-500/20
                               flex items-center justify-center text-2xl flex-shrink-0">
                        📌
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            Purpose
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Why this app exists
                        </p>
                    </div>
                </div>

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">
                    Expense Tracker was built to simplify financial management with
                    an elegant and intuitive interface. Users can manage daily expenses,
                    monitor income, control budgets, and understand spending patterns
                    through beautiful dashboards and reports.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                    <div
                        class="rounded-xl border border-gray-200 dark:border-gray-800
                               bg-gray-50 dark:bg-gray-950 p-5">
                        <div class="text-3xl mb-3">📊</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                            Analytics
                        </h3>
                        <p class="mt-1.5 text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                            Visualize financial habits using modern charts and reports.
                        </p>
                    </div>

                    <div
                        class="rounded-xl border border-gray-200 dark:border-gray-800
                               bg-gray-50 dark:bg-gray-950 p-5">
                        <div class="text-3xl mb-3">💰</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                            Budget Control
                        </h3>
                        <p class="mt-1.5 text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                            Set monthly spending limits and stay financially disciplined.
                        </p>
                    </div>
                </div>

            </div>

            {{-- App Info --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-8">

                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-500/20
                               flex items-center justify-center text-2xl flex-shrink-0">
                        🚀
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            App Info
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Current release
                        </p>
                    </div>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-800 space-y-4">
                    @foreach ([['label' => 'Version', 'value' => 'v1.0.0'], ['label' => 'Release', 'value' => 'Stable Build'], ['label' => 'UI Theme', 'value' => 'Modern Glass UI'], ['label' => 'Framework', 'value' => 'Laravel 11'], ['label' => 'CSS', 'value' => 'Tailwind CSS v3']] as $info)
                        <div class="pt-4 first:pt-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-semibold">
                                {{ $info['label'] }}
                            </p>
                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $info['value'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>

        {{-- ── FEATURES ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-8">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Features
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Everything included in the platform
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $features = [
                        [
                            'icon' => '💸',
                            'title' => 'Expense Tracking',
                            'desc' => 'Track daily expenses instantly with categories and notes.',
                            'color' => 'bg-red-100 dark:bg-red-900/20',
                        ],
                        [
                            'icon' => '📈',
                            'title' => 'Analytics Dashboard',
                            'desc' => 'Beautiful charts for spending patterns and trends.',
                            'color' => 'bg-indigo-100 dark:bg-indigo-900/20',
                        ],
                        [
                            'icon' => '🌙',
                            'title' => 'Dark Mode',
                            'desc' => 'Elegant dark theme that\'s easy on the eyes.',
                            'color' => 'bg-slate-100 dark:bg-slate-800',
                        ],
                        [
                            'icon' => '🏷️',
                            'title' => 'Budget Limits',
                            'desc' => 'Set and monitor monthly category budgets.',
                            'color' => 'bg-amber-100 dark:bg-amber-900/20',
                        ],
                        [
                            'icon' => '📱',
                            'title' => 'Responsive Design',
                            'desc' => 'Fully optimized for mobile, tablet, and desktop.',
                            'color' => 'bg-sky-100 dark:bg-sky-900/20',
                        ],
                        [
                            'icon' => '⚡',
                            'title' => 'Fast Performance',
                            'desc' => 'Optimized for a smooth, snappy user experience.',
                            'color' => 'bg-emerald-100 dark:bg-emerald-900/20',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div
                        class="rounded-xl border border-gray-200 dark:border-gray-800
                               bg-gray-50 dark:bg-gray-950 p-5
                               hover:-translate-y-1 hover:shadow-lg transition duration-200">
                        <div
                            class="w-12 h-12 rounded-xl {{ $feature['color'] }}
                                   flex items-center justify-center text-2xl mb-4">
                            {{ $feature['icon'] }}
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="mt-1.5 text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ $feature['desc'] }}
                        </p>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- ── DEVELOPER ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-8">

            <div class="flex flex-col sm:flex-row sm:items-center gap-6">

                <div
                    class="w-20 h-20 rounded-2xl flex-shrink-0
                           bg-gradient-to-br from-indigo-500 to-violet-600
                           text-white flex items-center justify-center
                           text-3xl font-black shadow-lg">
                    M
                </div>

                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Developer
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed max-w-xl">
                        Crafted with passion using Laravel and Tailwind CSS
                        to create a clean, modern, and scalable finance platform.
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="https://github.com/maheen-2763/moneytracker" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                                  bg-gray-900 dark:bg-white text-white dark:text-gray-900
                                  text-sm font-semibold hover:opacity-90 transition">
                            <i class="bi bi-github"></i> GitHub
                        </a>
                        <a href="#"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                                  border border-gray-300 dark:border-gray-700
                                  text-gray-700 dark:text-gray-300
                                  text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <i class="bi bi-envelope"></i> Contact
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── CHANGELOG ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-8">

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                Changelog
            </h2>

            <div class="space-y-6">
                @foreach ([
            [
                'version' => 'v1.0.0',
                'tag' => 'Latest',
                'color' => 'bg-emerald-500',
                'badge' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300',
                'desc' => 'Initial stable release with expenses, budgets, dashboard analytics, 2FA security, dark mode, and responsive UI.',
            ],
        ] as $entry)
                    <div class="flex gap-5">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-3.5 h-3.5 mt-1 rounded-full {{ $entry['color'] }} flex-shrink-0 ring-4 ring-indigo-100 dark:ring-indigo-900/30">
                            </div>
                            <div class="w-px flex-1 bg-gray-200 dark:bg-gray-800 mt-2"></div>
                        </div>
                        <div class="pb-6">
                            <div class="flex items-center gap-3 flex-wrap">
                                <h3 class="font-bold text-gray-900 dark:text-white">
                                    {{ $entry['version'] }}
                                </h3>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $entry['badge'] }}">
                                    {{ $entry['tag'] }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $entry['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

@endsection
