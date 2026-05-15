@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

    <div class="space-y-4 md:space-y-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ── Page Header ── --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Admin Dashboard
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ now()->format('l, d M Y') }} · Real-time overview
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.expenses.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                           border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300
                           hover:bg-gray-50 dark:hover:bg-gray-800 text-sm font-semibold transition">
                        <i class="bi bi-receipt"></i> All Expenses
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                           bg-indigo-500 hover:bg-indigo-600 dark:hover:bg-indigo-600
                           text-white text-sm font-semibold transition">
                        <i class="bi bi-people"></i> All Users
                    </a>
                </div>
            </div>

            {{-- ── Stats Grid ── --}}
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 md:gap-6 mb-8">

                {{-- Total Users --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 p-4 md:p-6
                        shadow-sm hover:-translate-y-1 hover:shadow-md
                        transition-all duration-200">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                        Total Users
                    </p>
                    <p class="text-2xl md:text-4xl font-extrabold tracking-tight text-violet-500 mt-2">
                        {{ $stats['total_users'] }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        <span class="font-semibold text-green-600 dark:text-green-400">+{{ $stats['new_users'] }}</span>
                        this month
                    </p>
                </div>

                {{-- Total Expenses --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 p-4 md:p-6
                        shadow-sm hover:-translate-y-1 hover:shadow-md
                        transition-all duration-200">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                        Total Records
                    </p>
                    <p class="text-2xl md:text-4xl font-extrabold tracking-tight text-red-500 mt-2">
                        {{ $stats['total_expenses'] }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        All time
                    </p>
                </div>

                {{-- Total Spent --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 p-4 md:p-6
                        shadow-sm hover:-translate-y-1 hover:shadow-md
                        transition-all duration-200 lg:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                        Total Spent
                    </p>
                    <p class="text-2xl md:text-4xl font-extrabold tracking-tight text-amber-500 mt-2">
                        ₹{{ number_format($stats['total_amount'], 0) }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        All users combined
                    </p>
                </div>

                {{-- This Month --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 p-4 md:p-6
                        shadow-sm hover:-translate-y-1 hover:shadow-md
                        transition-all duration-200 lg:col-span-1">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                        This Month
                    </p>
                    <p class="text-2xl md:text-4xl font-extrabold tracking-tight text-green-500 mt-2">
                        ₹{{ number_format($stats['this_month'], 0) }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        {{ now()->format('F Y') }}
                    </p>
                </div>

                {{-- Budgets Set --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 p-4 md:p-6
                        shadow-sm hover:-translate-y-1 hover:shadow-md
                        transition-all duration-200">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                        Budgets Set
                    </p>
                    <p class="text-2xl md:text-4xl font-extrabold tracking-tight text-cyan-500 mt-2">
                        {{ $stats['total_budgets'] }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Across users
                    </p>
                </div>
            </div>

            {{-- ── Charts Row ── --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-3 md:gap-6 mb-8">

                {{-- Monthly Trend Chart --}}
                <div
                    class="xl:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="flex items-center justify-between px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <div>
                            <h2 class="text-base font-bold text-gray-900 dark:text-white">
                                Monthly Spending Trend
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Last 6 months
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 bg-indigo-500/10 text-indigo-500">
                            Trend
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="h-[220px] md:h-[320px]">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Category Pie Chart --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white">
                            By Category
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            This month
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="h-[320px]">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Bottom Row ── --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-3 md:gap-6">

                {{-- Top Spenders --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="flex items-center justify-between px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white">
                            Top Spenders
                        </h2>
                        <a href="{{ route('admin.users.index') }}"
                            class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">
                            View all →
                        </a>
                    </div>

                    <div class="px-6 pt-4 pb-2">
                        @if ($topSpenders->count())
                            <div class="space-y-4">
                                @foreach ($topSpenders as $i => $user)
                                    @php
                                        $rankColors = [
                                            0 => 'text-indigo-500',
                                            1 => 'text-amber-500',
                                            2 => 'text-red-500',
                                            3 => 'text-green-500',
                                            4 => 'text-cyan-500',
                                        ];
                                        $rankColor = $rankColors[$i] ?? 'text-gray-500';
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="text-sm font-bold {{ $rankColor }}">
                                                #{{ $i + 1 }}
                                            </div>
                                            <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                                                class="w-8 h-8 rounded-full object-cover">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                                    {{ $user->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold text-red-500 ml-2">
                                            ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="text-3xl mb-2">🏆</div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    No expenses yet.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Expenses --}}
                <div
                    class="xl:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="flex items-center justify-between px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white">
                            Recent Expenses
                        </h2>
                        <a href="{{ route('admin.expenses.index') }}"
                            class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">
                            View all →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <tbody>
                                @forelse($recentExpenses as $expense)
                                    @php
                                        $badgeMap = [
                                            'food' => 'bg-yellow-100 text-yellow-800',
                                            'travel' => 'bg-sky-100 text-sky-800',
                                            'health' => 'bg-green-100 text-green-800',
                                            'office' => 'bg-violet-100 text-violet-800',
                                            'other' => 'bg-gray-100 text-gray-700',
                                        ];
                                    @endphp
                                    <tr
                                        class="border-b border-gray-100 dark:border-gray-800
                                       hover:bg-gray-50 dark:hover:bg-gray-800/60
                                       transition-colors duration-150">

                                        <td class="px-3 md:px-6 py-3 md:py-4 align-middle">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $expense->user->avatarUrl() }}"
                                                    alt="{{ $expense->user->name }}"
                                                    class="w-8 h-8 rounded-full object-cover">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $expense->user->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $expense->title }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-3 md:px-6 py-3 md:py-4 align-middle">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full
                                                 text-xs font-semibold
                                                 {{ $badgeMap[$expense->category] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($expense->category) }}
                                            </span>
                                        </td>

                                        <td
                                            class="px-3 md:px-6 py-3 md:py-4 align-middle text-right
                                           text-sm font-bold text-red-500">
                                            ₹{{ number_format($expense->amount, 0) }}
                                        </td>

                                        <td class="px-3 md:px-6 py-3 md:py-4 align-middle text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($expense->expense_date)->diffForHumans() }}
                                            </p>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="py-10 text-center
                                                       text-sm text-gray-500 dark:text-gray-400">
                                            No expenses yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyData = @json($monthlyTrend);
        const categoryData = @json($byCategory);

        // ── Dark mode chart color fix ───────────────
        function applyChartDarkMode() {
            const isDark = document.body.classList.contains('dark');
            const tickColor = isDark ? '#64748b' : '#94a3b8';
            const gridColor = isDark ? '#1e293b' : '#f8fafc';
            const legendColor = isDark ? '#94a3b8' : '#475569';

            Chart.defaults.color = tickColor;
            Chart.defaults.borderColor = gridColor;
        }

        // Apply on load
        applyChartDarkMode();

        // Apply when dark mode toggles
        document.getElementById('darkToggle')
            ?.addEventListener('click', () => {
                setTimeout(applyChartDarkMode, 50);
            });

        // ── Monthly Bar + Line Chart ────────────────
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [{
                        type: 'line',
                        label: 'Trend',
                        data: monthlyData.map(d => d.total),
                        borderColor: '#6366f1',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: false,
                        tension: 0.4,
                        yAxisID: 'y',
                    },
                    {
                        type: 'bar',
                        label: 'Spent',
                        data: monthlyData.map(d => d.total),
                        backgroundColor: 'rgba(99,102,241,0.12)',
                        borderColor: 'rgba(99,102,241,0.3)',
                        borderWidth: 1,
                        borderRadius: 6,
                        yAxisID: 'y',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx =>
                                ' ₹' + Number(ctx.raw).toLocaleString('en-IN')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f8fafc'
                        },
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#94a3b8',
                            callback: val =>
                                '₹' + Number(val).toLocaleString('en-IN')
                        }
                    }
                }
            }
        });

        // ── Category Doughnut ───────────────────────
        const catColors = {
            food: '#f59e0b',
            travel: '#6366f1',
            health: '#22c55e',
            office: '#06b6d4',
            other: '#94a3b8',
        };

        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: categoryData.map(d =>
                    d.category.charAt(0).toUpperCase() + d.category.slice(1)
                ),
                datasets: [{
                    data: categoryData.map(d => d.total),
                    backgroundColor: categoryData.map(d =>
                        catColors[d.category] ?? '#94a3b8'
                    ),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11,
                                weight: '600'
                            },
                            color: '#475569',
                            padding: 10,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx =>
                                ` ₹${Number(ctx.raw).toLocaleString('en-IN')}`
                        }
                    }
                }
            }
        });
    </script>
@endpush
