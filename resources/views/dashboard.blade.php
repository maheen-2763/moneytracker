@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

    {{-- ── Page Heading ── --}}
    <div class="page-heading">
        <h4>Dashboard</h4>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="label">Total Spent (All Time)</div>
                <div class="value text-primary">₹{{ number_format($totalAll, 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="label">This Month</div>
                <div class="value text-primary">₹{{ number_format($totalThisMonth, 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="label">This Week</div>
                <div class="value text-success">₹{{ number_format($totalThisWeek, 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="label">Total Expenses</div>
                <div class="value text-purple">{{ $totalExpenses }}</div>
            </div>
        </div>
    </div>

    {{-- ── Charts Row ── --}}
    <div class="row g-4 mb-4">

        {{-- Donut Chart — Spending by Category --}}
        <div class="col-12 col-lg-6">
            <div class="stat-card h-100">
                <div class="label mb-3">Spending by Category</div>
                @if ($byCategory->count() > 0)
                    <div class="d-flex align-items-center justify-content-center" style="height:220px">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    {{-- Legend --}}
                    <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                        @foreach ($byCategory as $item)
                            <span style="font-size:0.78rem;color:var(--text-muted)">
                                <span class="category-dot" data-cat="{{ $item->category }}">●</span>
                                {{ ucfirst($item->category) }} (₹{{ number_format($item->total, 2) }})
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height:220px">
                        <p style="color:var(--text-muted)">No expenses yet.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Line Chart — Last 6 Months --}}
        <div class="col-12 col-lg-6">
            <div class="stat-card h-100">
                <div class="label mb-3">Last 6 Months</div>
                @if ($monthlySpending->count() > 0)
                    <div style="height:250px">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height:250px">
                        <p style="color:var(--text-muted)">No data yet.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Recent Expenses ── --}}
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
            <span style="font-weight:700;font-size:0.9rem;color:var(--text-main)">Recent Expenses</span>
            <a href="{{ route('expenses.index') }}" class="text-primary" style="font-size:0.82rem">View All →</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentExpenses as $expense)
                    <tr>
                        <td>
                            <a href="{{ route('expenses.show', $expense) }}" class="text-decoration-none"
                                style="color:var(--text-main)">
                                {{ $expense->title }}
                            </a>
                        </td>
                        <td><span class="amount-text">₹{{ number_format($expense->amount, 2) }}</span></td>
                        <td><span class="cat-badge">{{ ucfirst($expense->category) }}</span></td>
                        <td style="color:var(--text-muted)">{{ $expense->expense_date->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4" style="color:var(--text-muted)">
                            No expenses yet.
                            <a href="{{ route('expenses.create') }}" class="text-primary">Add one!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Chart.js ── --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // ── Detect dark mode ──────────────────────────────
        const isDark = document.body.classList.contains('dark');
        const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
        const labelColor = isDark ? '#94a3b8' : '#64748b';
        const tooltipBg = isDark ? '#1e293b' : '#ffffff';
        const tooltipText = isDark ? '#e2e8f0' : '#0f172a';

        // ── Category colors ───────────────────────────────
        @php
            $catColors = [
                'food' => '#facc15',
                'travel' => '#60a5fa',
                'office' => '#a78bfa',
                'health' => '#34d399',
                'other' => '#94a3b8',
            ];
        @endphp

        // ── Donut Chart ───────────────────────────────────
        @if ($byCategory->count() > 0)
            const categoryData = {
                labels: @json($byCategory->pluck('category')->map(fn($c) => ucfirst($c))),
                datasets: [{
                    data: @json($byCategory->pluck('total')),
                    backgroundColor: @json($byCategory->pluck('category')->map(fn($c) => $catColors[$c] ?? '#94a3b8')),
                    borderWidth: 0,
                    hoverOffset: 8,
                }]
            };

            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: categoryData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: tooltipBg,
                            titleColor: tooltipText,
                            bodyColor: tooltipText,
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: ctx =>
                                    ` ₹${Number(ctx.raw).toLocaleString('en-IN', {minimumFractionDigits:2})}`
                            }
                        }
                    }
                }
            });
        @endif

        // ── Line Chart ────────────────────────────────────
        @if ($monthlySpending->count() > 0)
            const monthlyData = {
                labels: @json($monthlySpending->pluck('label')),
                datasets: [{
                    label: 'Spent',
                    data: @json($monthlySpending->pluck('total')),
                    borderColor: '#6366f1',
                    backgroundColor: isDark ?
                        'rgba(99,102,241,0.15)' : 'rgba(99,102,241,0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#6366f1',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4,
                }]
            };

            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: monthlyData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: tooltipBg,
                            titleColor: tooltipText,
                            bodyColor: tooltipText,
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: ctx =>
                                    ` ₹${Number(ctx.raw).toLocaleString('en-IN', {minimumFractionDigits:2})}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: labelColor,
                                font: {
                                    size: 11
                                }
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: labelColor,
                                font: {
                                    size: 11
                                },
                                callback: val => '₹' + val.toLocaleString('en-IN')
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        @endif
    </script>

@endsection
