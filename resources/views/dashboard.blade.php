@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

    {{-- ── Summary Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="label">Total Spent</div>
                <div class="value text-danger">
                    ₹{{ number_format($totalAllTime, 0) }}
                </div>
                <div class="stat-sub text-muted">All time</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="label">This Month</div>
                <div class="value text-primary">
                    ₹{{ number_format($thisMonth, 0) }}
                </div>
                <div class="stat-sub text-muted">{{ now()->format('F Y') }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="label">This Week</div>
                <div class="value text-success">
                    ₹{{ number_format($thisWeek, 0) }}
                </div>
                <div class="stat-sub text-muted">
                    {{ now()->startOfWeek()->format('d M') }} —
                    {{ now()->endOfWeek()->format('d M') }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="label">Total Expenses</div>
                <div class="value" style="color:#7c3aed;">
                    {{ $totalExpenses }}
                </div>
                <div class="stat-sub text-muted">Records</div>
            </div>
        </div>
    </div>

    {{-- ── Charts Row ── --}}
    <div class="row g-4 mb-4">

        {{-- Monthly Trend --}}
        {{-- ── Charts Row ── --}}
        <div class="row g-4 mb-4">

            {{-- Monthly Trend --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="fw-bold mb-0">Monthly Spending</h6>
                                <small class="text-muted">Last 6 months</small>
                            </div>
                            <span
                                class="badge bg-primary bg-opacity-10
                                 text-primary fw-semibold">
                                Trend
                            </span>
                        </div>
                        {{-- ← Fixed height wrapper --}}
                        <div style="position:relative; height:220px; width:100%;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Category Doughnut --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between
                            align-items-center mb-3">
                            <div>
                                <h6 class="fw-bold mb-0">By Category</h6>
                                <small class="text-muted">This month</small>
                            </div>
                        </div>
                        {{-- ← Fixed height wrapper --}}
                        <div style="position:relative; height:220px; width:100%;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Budget Progress + Recent Expenses ── --}}
        <div class="row g-4">

            {{-- Budget Progress --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Budget Status</h6>
                            <a href="{{ route('budgets.index') }}"
                                style="font-size:.75rem; color:#6366f1;
                              text-decoration:none; font-weight:600;">
                                Manage →
                            </a>
                        </div>

                        @forelse($budgets as $budget)
                            @php
                                $spent = $budget->spentThisMonth();
                                $pct = $budget->percentUsed();
                                $status = $budget->status();
                                $colors = [
                                    'success' => '#22c55e',
                                    'warning' => '#f59e0b',
                                    'danger' => '#ef4444',
                                ];
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size:.82rem; font-weight:600; color:#0f172a;">
                                        {{ ucfirst($budget->category) }}
                                    </span>
                                    <span style="font-size:.78rem; color:#64748b;">
                                        ₹{{ number_format($spent, 0) }} /
                                        ₹{{ number_format($budget->amount, 0) }}
                                    </span>
                                </div>
                                <div
                                    style="height:6px; background:#f1f5f9;
                                border-radius:99px; overflow:hidden;">
                                    <div
                                        style="height:100%;
                                    width:{{ $pct }}%;
                                    background:{{ $colors[$status] }};
                                    border-radius:99px;
                                    transition:width 0.6s ease;">
                                    </div>
                                </div>
                                <div
                                    style="font-size:.7rem; color:{{ $colors[$status] }};
                                font-weight:600; margin-top:2px;">
                                    {{ $pct }}% used
                                    @if ($pct >= 100)
                                        · Over by ₹{{ number_format($spent - $budget->amount, 0) }}!
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3" style="font-size:.85rem;">
                                <i class="bi bi-piggy-bank fs-4 d-block mb-2"></i>
                                No budgets set yet.
                                <a href="{{ route('budgets.index') }}" class="d-block mt-1">
                                    Set a budget →
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Recent Expenses --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden;">
                    <div class="card-body p-0">
                        <div
                            class="px-4 py-3 border-bottom d-flex
                            justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Recent Expenses</h6>
                            <a href="{{ route('expenses.index') }}"
                                style="font-size:.75rem; color:#6366f1;
                              text-decoration:none; font-weight:600;">
                                View all →
                            </a>
                        </div>
                        <table class="table mb-0">
                            <tbody>
                                @forelse($recentExpenses as $expense)
                                    @php
                                        $catColors = [
                                            'food' => ['bg' => '#fef9c3', 'color' => '#854d0e'],
                                            'travel' => ['bg' => '#e0f2fe', 'color' => '#075985'],
                                            'health' => ['bg' => '#dcfce7', 'color' => '#166534'],
                                            'office' => ['bg' => '#ede9fe', 'color' => '#5b21b6'],
                                            'other' => ['bg' => '#f1f5f9', 'color' => '#475569'],
                                        ];
                                        $cat = $catColors[$expense->category] ?? $catColors['other'];
                                    @endphp
                                    <tr style="border-bottom:1px solid #f8fafc;">
                                        <td style="padding:.75rem 1.25rem; vertical-align:middle;">
                                            <div
                                                style="font-weight:600; font-size:.875rem;
                                            color:#0f172a;">
                                                {{ $expense->title }}
                                            </div>
                                            <div style="font-size:.72rem; color:#94a3b8;">
                                                {{ \Carbon\Carbon::parse($expense->expense_date)->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td style="padding:.75rem 1rem; vertical-align:middle;">
                                            <span
                                                style="padding:.2rem .65rem;
                                             border-radius:20px; font-size:.72rem;
                                             font-weight:700;
                                             background:{{ $cat['bg'] }};
                                             color:{{ $cat['color'] }};">
                                                {{ ucfirst($expense->category) }}
                                            </span>
                                        </td>
                                        <td
                                            style="padding:.75rem 1rem; vertical-align:middle;
                                       text-align:right; font-weight:800;
                                       color:#ef4444; font-size:.875rem;">
                                            ₹{{ number_format($expense->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                            No expenses yet.
                                            <a href="{{ route('expenses.create') }}" class="d-block mt-1">Add your first
                                                →</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
