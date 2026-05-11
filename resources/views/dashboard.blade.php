@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="page-wrapper">

        {{-- ── Summary Cards ───────────────────────── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 section-gap">

            {{-- Total Spent --}}
            <div class="stat-card">
                <div class="label-ui">Total Spent</div>

                <div class="value-ui text-red-500 mt-2">
                    ₹{{ number_format($totalAllTime, 0) }}
                </div>

                <div class="meta-ui mt-2">All time</div>
            </div>

            {{-- This Month --}}
            <div class="stat-card">
                <div class="label-ui">This Month</div>

                <div class="value-ui text-blue-500 mt-2">
                    ₹{{ number_format($thisMonth, 0) }}
                </div>

                <div class="meta-ui mt-2">
                    {{ now()->format('F Y') }}
                </div>
            </div>

            {{-- This Week --}}
            <div class="stat-card">
                <div class="label-ui">This Week</div>

                <div class="value-ui text-green-500 mt-2">
                    ₹{{ number_format($thisWeek, 0) }}
                </div>

                <div class="meta-ui mt-2">
                    {{ now()->startOfWeek()->format('d M') }} — {{ now()->endOfWeek()->format('d M') }}
                </div>
            </div>

            {{-- Total Expenses --}}
            <div class="stat-card">
                <div class="label-ui">Total Expenses</div>

                <div class="value-ui text-purple mt-2">
                    {{ $totalExpenses }}
                </div>

                <div class="meta-ui mt-2">Records</div>
            </div>

        </div>

        {{-- ── Charts ───────────────────────── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 section-gap">

            {{-- Monthly Spending --}}
            <div class="dashboard-card xl:col-span-2">

                <div class=" p-6 border-b border-ui flex items-center justify-between">

                    <div>
                        <h2 class="card-title-ui">Monthly Spending</h2>
                        <p class="card-subtitle-ui">Last 6 months</p>
                    </div>

                    <span class="badge-pill bg-indigo-500/10 text-indigo-500">
                        Trend
                    </span>

                </div>

                <div class=" p-6">
                    <div class="h-[320px]">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

            </div>

            {{-- Category Chart --}}
            <div class="dashboard-card">

                <div class=" p-6 border-b border-ui">
                    <h2 class="card-title-ui">By Category</h2>
                    <p class="card-subtitle-ui">This month</p>
                </div>

                <div class=" p-6">
                    <div class="h-[320px]">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

            </div>

        </div>

        {{-- ── Budget + Recent Expenses ───────────────────────── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 section-gap">

            {{-- Budget --}}
            <div class="dashboard-card">

                <div class="flex items-center justify-between p-6 border-b border-ui">
                    <h2 class="card-title-ui">Budget Status</h2>

                    <a href="{{ route('budgets.index') }}" class="action-link">
                        Manage →
                    </a>
                </div>


                {{-- BODY --}}
                <div class="card-pad">

                    @if ($budgets->count())

                        <div class="stack-lg">

                            @foreach ($budgets as $budget)
                                @php
                                    $spent = $budget->spentThisMonth();
                                    $pct = $budget->percentUsed();

                                    $map = [
                                        'success' => 'bg-green-500',
                                        'warning' => 'bg-yellow-500',
                                        'danger' => 'bg-red-500',
                                    ];
                                @endphp

                                <div class="space-y-3">

                                    {{-- Header --}}
                                    <div class="flex justify-between items-center">
                                        <span class="table-title-ui">
                                            {{ ucfirst($budget->category) }}
                                        </span>

                                        <span class="table-meta-ui">
                                            ₹{{ number_format($spent, 0) }} / ₹{{ number_format($budget->amount, 0) }}
                                        </span>
                                    </div>

                                    {{-- Progress --}}
                                    <div class="w-full h-2 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                        <div class="h-full {{ $map[$budget->status()] }} rounded-full"
                                            style="width: {{ min($pct, 100) }}%">
                                        </div>
                                    </div>

                                    {{-- Meta --}}
                                    <div class="meta-ui">
                                        {{ $pct }}% used
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @else
                        {{-- EMPTY STATE (clean + centered system) --}}
                        <div class="flex flex-col items-center justify-center py-10 text-center">

                            <div class="text-3xl mb-2">💰</div>

                            <p class="text-sm text-muted">
                                No budgets set yet.
                            </p>

                            <a href="{{ route('budgets.index') }}" class="action-link mt-3 inline-block">
                                Set your first budget →
                            </a>

                        </div>

                    @endif

                </div>

            </div>

            {{-- Recent Expenses --}}
            <div class="dashboard-card xl:col-span-2 overflow-hidden">

                <div class="flex justify-between  p-6 border-b border-ui">
                    <h2 class="card-title-ui">Recent Expenses</h2>

                    <a href="{{ route('expenses.index') }}" class="action-link">
                        View all →
                    </a>
                </div>

                <table class="table-ui">

                    <tbody>

                        @forelse($recentExpenses as $expense)
                            @php
                                $badgeMap = [
                                    'food' => 'badge-food',
                                    'travel' => 'badge-travel',
                                    'health' => 'badge-health',
                                    'office' => 'badge-office',
                                    'other' => 'badge-other',
                                ];
                            @endphp

                            <tr>

                                <td class="table-cell">
                                    <div class="font-semibold text-main">
                                        {{ $expense->title }}
                                    </div>

                                    <div class="meta-ui">
                                        {{ \Carbon\Carbon::parse($expense->expense_date)->diffForHumans() }}
                                    </div>
                                </td>

                                <td class="table-cell">
                                    <span class="badge-pill {{ $badgeMap[$expense->category] ?? 'badge-other' }}">
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>

                                <td class="table-cell expense-amount">
                                    ₹{{ number_format($expense->amount, 2) }}
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10 text-muted">
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
