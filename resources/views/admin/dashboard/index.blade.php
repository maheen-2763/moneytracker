@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')

@push('styles')
    <style>
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }

        .stat-card .icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 0.35rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-card .stat-sub {
            font-size: 0.75rem;
            color: #64748b;
        }

        .stat-card .stat-sub .up {
            color: #22c55e;
            font-weight: 700;
        }

        .stat-card .stat-sub .down {
            color: #ef4444;
            font-weight: 700;
        }

        .section-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .section-card .section-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-card .section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .rank-badge {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.65rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .expense-title {
            font-weight: 600;
            font-size: 0.875rem;
            color: #0f172a;
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .amount-cell {
            font-weight: 700;
            color: #ef4444;
            font-variant-numeric: tabular-nums;
            font-size: 0.875rem;
        }

        .chart-container {
            position: relative;
            padding: 1.25rem 1.5rem;
        }
    </style>
@endpush

@section('content')

    {{-- ── Page Heading ── --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight:800; letter-spacing:-0.03em; color:#0f172a; margin:0;">
                Admin Dashboard
            </h4>
            <small class="text-muted">
                {{ now()->format('l, d M Y') }} · Real-time overview
            </small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-receipt me-1"></i> All Expenses
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-people me-1"></i> All Users
            </a>
        </div>
    </div>

    {{-- ── Stats Row ── --}}
    <div class="row g-3 mb-4">

        {{-- Users --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="icon-wrap" style="background:#ede9fe; color:#7c3aed;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value" style="color:#7c3aed;">{{ $stats['total_users'] }}</div>
                <div class="stat-sub">
                    <span class="up">+{{ $stats['new_users'] }}</span> this month
                </div>
            </div>
        </div>

        {{-- Expenses --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="icon-wrap" style="background:#fef2f2; color:#ef4444;">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div class="stat-label">Expenses</div>
                <div class="stat-value" style="color:#ef4444;">{{ $stats['total_expenses'] }}</div>
                <div class="stat-sub">All time records</div>
            </div>
        </div>

        {{-- Total Spent --}}
        <div class="col-6 col-md-4 col-lg-3">
            <div class="stat-card">
                <div class="icon-wrap" style="background:#fef9c3; color:#ca8a04;">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div class="stat-label">Total Spent</div>
                <div class="stat-value" style="color:#ca8a04; font-size:1.4rem;">
                    ₹{{ number_format($stats['total_amount'], 0) }}
                </div>
                <div class="stat-sub">All users combined</div>
            </div>
        </div>

        {{-- This Month --}}
        <div class="col-6 col-md-4 col-lg-3">
            <div class="stat-card">
                <div class="icon-wrap" style="background:#dcfce7; color:#16a34a;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-label">This Month</div>
                <div class="stat-value" style="color:#16a34a; font-size:1.4rem;">
                    ₹{{ number_format($stats['this_month'], 0) }}
                </div>
                <div class="stat-sub">{{ now()->format('F Y') }}</div>
            </div>
        </div>

        {{-- Budgets --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="icon-wrap" style="background:#e0f2fe; color:#0284c7;">
                    <i class="bi bi-piggy-bank-fill"></i>
                </div>
                <div class="stat-label">Budgets Set</div>
                <div class="stat-value" style="color:#0284c7;">{{ $stats['total_budgets'] }}</div>
                <div class="stat-sub">Across all users</div>
            </div>
        </div>

    </div>

    {{-- ── Charts Row ── --}}
    <div class="row g-4 mb-4">

        {{-- Monthly Trend Chart --}}
        <div class="col-md-7">
            <div class="section-card h-100">
                <div class="section-header">
                    <span class="section-title">
                        <i class="bi bi-graph-up me-2 text-primary"></i>Monthly Spending Trend
                    </span>
                </div>
                <div class="chart-container" style="height: 260px;"> {{-- ← fixed height --}}
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Category Pie Chart --}}
        <div class="col-md-5">
            <div class="section-card h-100">
                <div class="section-header">
                    <span class="section-title">
                        <i class="bi bi-pie-chart me-2 text-warning"></i>Category Breakdown
                    </span>
                </div>
                <div class="chart-container d-flex align-items-center justify-content-center">
                    <div style="max-width: 260px; width: 100%;"> {{-- ← constrain width --}}
                        <canvas id="categoryChart" height="260"></canvas> {{-- ← fixed height --}}
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- ── Bottom Row ── --}}
    <div class="row g-4">

        {{-- Top Spenders --}}
        <div class="col-md-4">
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">
                        <i class="bi bi-trophy me-2 text-warning"></i>Top Spenders
                    </span>
                    <a href="{{ route('admin.users.index') }}"
                        style="font-size:.75rem; color:#6366f1; text-decoration:none; font-weight:600;">
                        View all →
                    </a>
                </div>
                <div class="p-3">
                    @foreach ($topSpenders as $i => $user)
                        @php
                            $colors = ['#6366f1', '#f59e0b', '#ef4444', '#22c55e', '#06b6d4'];
                            $bgColors = ['#eef2ff', '#fffbeb', '#fef2f2', '#f0fdf4', '#ecfeff'];
                        @endphp
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rank-badge"
                                style="background:{{ $bgColors[$i] ?? '#f1f5f9' }};
                                color:{{ $colors[$i] ?? '#64748b' }}">
                                {{ $i + 1 }}
                            </div>
                            <img src="{{ $user->avatarUrl() }}" class="user-avatar-sm" alt="{{ $user->name }}">
                            <div class="flex-grow-1" style="min-width:0;">
                                <div
                                    style="font-size:.85rem; font-weight:700;
                                    white-space:nowrap; overflow:hidden;
                                    text-overflow:ellipsis; color:#0f172a;">
                                    {{ $user->name }}
                                </div>
                                <div
                                    style="font-size:.72rem; color:#94a3b8;
                                    white-space:nowrap; overflow:hidden;
                                    text-overflow:ellipsis;">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div
                                style="font-size:.875rem; font-weight:800;
                                color:#ef4444; flex-shrink:0;">
                                ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Expenses --}}
        <div class="col-md-8">
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Recent Expenses
                    </span>
                    <a href="{{ route('admin.expenses.index') }}"
                        style="font-size:.75rem; color:#6366f1; text-decoration:none; font-weight:600;">
                        View all →
                    </a>
                </div>
                <table class="table mb-0" style="font-size:.875rem;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th
                                style="padding:.75rem 1.25rem; font-size:.7rem;
                                   font-weight:700; text-transform:uppercase;
                                   letter-spacing:.06em; color:#94a3b8;
                                   border-bottom:1px solid #f1f5f9;">
                                User</th>
                            <th
                                style="padding:.75rem 1rem; font-size:.7rem;
                                   font-weight:700; text-transform:uppercase;
                                   letter-spacing:.06em; color:#94a3b8;
                                   border-bottom:1px solid #f1f5f9;">
                                Title</th>
                            <th
                                style="padding:.75rem 1rem; font-size:.7rem;
                                   font-weight:700; text-transform:uppercase;
                                   letter-spacing:.06em; color:#94a3b8;
                                   border-bottom:1px solid #f1f5f9;">
                                Category</th>
                            <th
                                style="padding:.75rem 1rem; font-size:.7rem;
                                   font-weight:700; text-transform:uppercase;
                                   letter-spacing:.06em; color:#94a3b8;
                                   border-bottom:1px solid #f1f5f9;">
                                Amount</th>
                            <th
                                style="padding:.75rem 1rem; font-size:.7rem;
                                   font-weight:700; text-transform:uppercase;
                                   letter-spacing:.06em; color:#94a3b8;
                                   border-bottom:1px solid #f1f5f9;">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentExpenses as $expense)
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
                            <tr style="border-bottom:1px solid #f8fafc; transition:background 0.15s;"
                                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                                <td style="padding:.75rem 1.25rem; vertical-align:middle;">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $expense->user->avatarUrl() }}" class="user-avatar-sm"
                                            width="28" height="28" alt="{{ $expense->user->name }}">
                                        <span
                                            style="font-weight:600; font-size:.82rem;
                                             color:#0f172a; white-space:nowrap;">
                                            {{ $expense->user->name }}
                                        </span>
                                    </div>
                                </td>
                                <td style="padding:.75rem 1rem; vertical-align:middle;">
                                    <div class="expense-title">
                                        {{ $expense->title ?: '—' }}
                                    </div>
                                </td>
                                <td style="padding:.75rem 1rem; vertical-align:middle;">
                                    <span class="cat-pill"
                                        style="background:{{ $cat['bg'] }};
                                         color:{{ $cat['color'] }};">
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>
                                <td style="padding:.75rem 1rem; vertical-align:middle;">
                                    <span class="amount-cell">
                                        ₹{{ number_format($expense->amount, 2) }}
                                    </span>
                                </td>
                                <td
                                    style="padding:.75rem 1rem; vertical-align:middle;
                                   color:#94a3b8; font-size:.8rem;">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ── Monthly Trend Line Chart ──────────────────
        const monthlyData = @json($monthlyTrend);

        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [{
                    label: 'Total Spent (₹)',
                    data: monthlyData.map(d => d.total),
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // ← add this
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ₹' + Number(ctx.raw).toLocaleString('en-IN')
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
                            color: '#f1f5f9'
                        },
                        beginAtZero: false,
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#94a3b8',
                            callback: val => '₹' + Number(val).toLocaleString('en-IN')
                        }
                    }
                }
            }
        });

        // ── Category Doughnut Chart ───────────────────
        const catData = @json($byCategory);
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
                labels: catData.map(d => d.category.charAt(0).toUpperCase() + d.category.slice(1)),
                datasets: [{
                    data: catData.map(d => d.total),
                    backgroundColor: catData.map(d => catColors[d.category] ?? '#94a3b8'),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // ← add this
                cutout: '70%', // ← slightly more cutout looks cleaner
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11,
                                weight: '600'
                            },
                            color: '#475569',
                            padding: 12,
                            usePointStyle: true,
                            pointStyleWidth: 8,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ₹${Number(ctx.raw).toLocaleString('en-IN')}`
                        }
                    }
                }
            }
        });
    </script>
@endpush
