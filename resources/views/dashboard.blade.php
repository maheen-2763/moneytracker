@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="space-y-8">

        {{-- ── Summary Cards ─────────────────── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Total Spent --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 p-6
                    shadow-sm hover:-translate-y-1 hover:shadow-md
                    transition-all duration-200">
                <p
                    class="text-xs font-semibold uppercase tracking-widest
                      text-gray-500 dark:text-gray-400">
                    Total Spent
                </p>
                <p class="text-4xl font-extrabold tracking-tight text-red-500 mt-2">
                    ₹{{ number_format($totalAllTime, 0) }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    All time
                </p>
            </div>

            {{-- This Month --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 p-6
                    shadow-sm hover:-translate-y-1 hover:shadow-md
                    transition-all duration-200">
                <p
                    class="text-xs font-semibold uppercase tracking-widest
                      text-gray-500 dark:text-gray-400">
                    This Month
                </p>
                <p class="text-4xl font-extrabold tracking-tight text-blue-500 mt-2">
                    ₹{{ number_format($thisMonth, 0) }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ now()->format('F Y') }}
                </p>
            </div>

            {{-- This Week --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 p-6
                    shadow-sm hover:-translate-y-1 hover:shadow-md
                    transition-all duration-200">
                <p
                    class="text-xs font-semibold uppercase tracking-widest
                      text-gray-500 dark:text-gray-400">
                    This Week
                </p>
                <p class="text-4xl font-extrabold tracking-tight text-green-500 mt-2">
                    ₹{{ number_format($thisWeek, 0) }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ now()->startOfWeek()->format('d M') }} — {{ now()->endOfWeek()->format('d M') }}
                </p>
            </div>

            {{-- Total Expenses --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 p-6
                    shadow-sm hover:-translate-y-1 hover:shadow-md
                    transition-all duration-200">
                <p
                    class="text-xs font-semibold uppercase tracking-widest
                      text-gray-500 dark:text-gray-400">
                    Total Expenses
                </p>
                <p class="text-4xl font-extrabold tracking-tight text-purple-500 mt-2">
                    {{ $totalExpenses }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Records
                </p>
            </div>

        </div>

        {{-- ── Charts ─────────────────────────── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Monthly Spending --}}
            <div
                class="xl:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                <div
                    class="flex items-center justify-between px-6 py-4
                        border-b border-gray-200 dark:border-gray-800">
                    <div>
                        <h2 class="text-base font-bold text-gray-900 dark:text-white">
                            Monthly Spending
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
                    <div class="h-[320px]">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

            </div>

            {{-- Category Chart --}}
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

        {{-- ── Budget + Recent Expenses ────────── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Budget Status --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                <div
                    class="flex items-center justify-between px-6 py-4
                        border-b border-gray-200 dark:border-gray-800">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">
                        Budget Status
                    </h2>
                    <a href="{{ route('budgets.index') }}"
                        class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">
                        Manage →
                    </a>
                </div>

                <div class="px-6 pt-4 pb-2">
                    @if ($budgets->count())
                        <div class="space-y-4">
                            @foreach ($budgets as $budget)
                                @php
                                    $spent = $budget->spentThisMonth();
                                    $pct = $budget->percentUsed();
                                    $barColor = match ($budget->status()) {
                                        'success' => 'bg-green-500',
                                        'warning' => 'bg-yellow-500',
                                        'danger' => 'bg-red-500',
                                        default => 'bg-gray-400',
                                    };
                                @endphp
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-sm font-semibold
                                                 text-gray-900 dark:text-white">
                                            {{ ucfirst($budget->category) }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            ₹{{ number_format($spent, 0) }} / ₹{{ number_format($budget->amount, 0) }}
                                        </span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full {{ $barColor }} rounded-full"
                                            style="width: {{ min($pct, 100) }}%">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $pct }}% used
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <div class="text-3xl mb-2">💰</div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                No budgets set yet.
                            </p>
                            <a href="{{ route('budgets.index') }}"
                                class="text-xs font-semibold text-indigo-500 hover:text-indigo-600 mt-3">
                                Set your first budget →
                            </a>
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
                    <a href="{{ route('expenses.index') }}"
                        class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">
                        View all →
                    </a>
                </div>

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

                                <td class="px-6 py-4 align-middle">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $expense->title }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($expense->expense_date)->diffForHumans() }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full
                                             text-xs font-semibold
                                             {{ $badgeMap[$expense->category] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>

                                <td
                                    class="px-6 py-4 align-middle text-right
                                       text-sm font-bold text-red-500">
                                    ₹{{ number_format($expense->amount, 2) }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
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

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyData = @json($monthlyTrend);
        const categoryData = @json($categoryBreakdown);

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
                maintainAspectRatio: false, // ← key fix
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
                maintainAspectRatio: false, // ← key fix
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
