@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

    <div class="space-y-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ── Page Header ── --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
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
                           border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300
                           hover:bg-gray-50 dark:hover:bg-gray-800 text-sm font-semibold transition">
                        <i class="bi bi-receipt"></i> All Expenses
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                           bg-indigo-500 hover:bg-indigo-600dark:hover:bg-indigo-600
                           text-white text-sm font-semibold transition">
                        <i class="bi bi-people"></i> All Users
                    </a>
                </div>
            </div>

            {{-- ── Stats Grid ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">

                {{-- Total Users --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                Total Users
                            </p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ $stats['total_users'] }}
                            </p>
                            <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                                <span class="font-semibold">+{{ $stats['new_users'] }}</span> this month
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-violet-100 dark:bg-violet-900/30
                                flex items-center justify-center text-violet-600 dark:text-violet-400 text-xl">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>

                {{-- Total Expenses --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                Expenses
                            </p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ $stats['total_expenses'] }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                All time records
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30
                                flex items-center justify-center text-red-600 dark:text-red-400 text-xl">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                    </div>
                </div>

                {{-- Total Spent --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6 hover:shadow-md transition lg:col-span-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                Total Spent
                            </p>
                            <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-2">
                                ₹{{ number_format($stats['total_amount'], 0) }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                All users combined
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30
                                flex items-center justify-center text-amber-600 dark:text-amber-400 text-xl">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                    </div>
                </div>

                {{-- This Month --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6 hover:shadow-md transition lg:col-span-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                This Month
                            </p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                                ₹{{ number_format($stats['this_month'], 0) }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                {{ now()->format('F Y') }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30
                                flex items-center justify-center text-green-600 dark:text-green-400 text-xl">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>

                {{-- Budgets Set --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                Budgets Set
                            </p>
                            <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-400 mt-2">
                                {{ $stats['total_budgets'] }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                Across users
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/30
                                flex items-center justify-center text-cyan-600 dark:text-cyan-400 text-xl">
                            <i class="bi bi-piggy-bank-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Charts Row ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

                {{-- Monthly Trend Chart --}}
                <div
                    class="lg:col-span-4 rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="bi bi-graph-up text-indigo-500 dark:text-indigo-400"></i>
                            Monthly Spending Trend
                        </h3>
                    </div>
                    <div class="p-6" style="height: 300px; position: relative;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                {{-- Category Pie Chart --}}
                <div
                    class="lg:col-span-3 rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="bi bi-pie-chart text-amber-600 dark:text-amber-400"></i>
                            Category Breakdown
                        </h3>
                    </div>
                    <div class="p-6 flex items-center justify-center" style="height: 300px;">
                        <div style="max-width: 280px; width: 100%;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Bottom Row ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Top Spenders --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-800
                            flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="bi bi-trophy text-amber-600 dark:text-amber-400"></i>
                            Top Spenders
                        </h3>
                        <a href="{{ route('admin.users.index') }}"
                            class="text-xs font-semibold text-indigo-500 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                            View all →
                        </a>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($topSpenders as $i => $user)
                            @php
                                $rankColors = [
                                    0 => [
                                        'bg' => 'bg-indigo-100 dark:bg-indigo-900/30',
                                        'text' => 'text-indigo-500 dark:text-indigo-400',
                                    ],
                                    1 => [
                                        'bg' => 'bg-amber-100 dark:bg-amber-900/30',
                                        'text' => 'text-amber-600 dark:text-amber-400',
                                    ],
                                    2 => [
                                        'bg' => 'bg-red-100 dark:bg-red-900/30',
                                        'text' => 'text-red-600 dark:text-red-400',
                                    ],
                                    3 => [
                                        'bg' => 'bg-green-100 dark:bg-green-900/30',
                                        'text' => 'text-green-600 dark:text-green-400',
                                    ],
                                    4 => [
                                        'bg' => 'bg-cyan-100 dark:bg-cyan-900/30',
                                        'text' => 'text-cyan-600 dark:text-cyan-400',
                                    ],
                                ];
                                $colors = $rankColors[$i] ?? [
                                    'bg' => 'bg-gray-100 dark:bg-gray-800',
                                    'text' => 'text-gray-600 dark:text-gray-400',
                                ];
                            @endphp
                            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full {{ $colors['bg'] }} {{ $colors['text'] }}
                                            flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        {{ $i + 1 }}
                                    </div>
                                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                                        class="w-9 h-9 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                    <div class="text-sm font-bold text-red-600 dark:text-red-400 flex-shrink-0">
                                        ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Expenses --}}
                <div
                    class="lg:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-800
                            flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="bi bi-clock-history text-indigo-500 dark:text-indigo-400"></i>
                            Recent Expenses
                        </h3>
                        <a href="{{ route('admin.expenses.index') }}"
                            class="text-xs font-semibold text-indigo-500 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                            View all →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest
                                             text-gray-700 dark:text-gray-300">
                                        User</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest
                                             text-gray-700 dark:text-gray-300">
                                        Title</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest
                                             text-gray-700 dark:text-gray-300">
                                        Category</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest
                                             text-gray-700 dark:text-gray-300">
                                        Amount</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest
                                             text-gray-700 dark:text-gray-300">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($recentExpenses as $expense)
                                    @php
                                        $catColorMap = [
                                            'food' =>
                                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200',
                                            'travel' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-800 dark:text-sky-200',
                                            'health' =>
                                                'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200',
                                            'office' =>
                                                'bg-violet-100 dark:bg-violet-900/30 text-violet-800 dark:text-violet-200',
                                            'other' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $expense->user->avatarUrl() }}"
                                                    alt="{{ $expense->user->name }}"
                                                    class="w-8 h-8 rounded-full object-cover">
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $expense->user->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 truncate max-w-xs block">
                                                {{ $expense->title ?: '—' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                                      {{ $catColorMap[$expense->category] ?? $catColorMap['other'] }}">
                                                {{ ucfirst($expense->category) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-red-600 dark:text-red-400">
                                                ₹{{ number_format($expense->amount, 0) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No recent expenses
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
                const ctx = document.getElementById('monthlyChart');
                const categoryCtx = document.getElementById('categoryChart');

                // Monthly Trend Chart
                const monthlyData = @json($monthlyTrend);
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: monthlyData.map(d => d.month),
                        datasets: [{
                            label: 'Total Spent (₹)',
                            data: monthlyData.map(d => d.total),
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.06)',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                borderRadius: 8,
                                titleFont: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                callbacks: {
                                    label: ctx => '₹' + Number(ctx.raw).toLocaleString('en-IN')
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f3f4f6',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    },
                                    callback: val => '₹' + Number(val).toLocaleString('en-IN')
                                }
                            }
                        }
                    }
                });

                // Category Doughnut Chart
                const categoryData = @json($byCategory);
                const categoryColors = {
                    food: '#f59e0b',
                    travel: '#3b82f6',
                    health: '#10b981',
                    office: '#8b5cf6',
                    other: '#6b7280',
                };

                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: categoryData.map(d => d.category.charAt(0).toUpperCase() + d.category.slice(1)),
                        datasets: [{
                            data: categoryData.map(d => d.total),
                            backgroundColor: categoryData.map(d => categoryColors[d.category] ?? '#6b7280'),
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#6b7280',
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    },
                                    padding: 16,
                                    usePointStyle: true,
                                    pointStyleWidth: 6,
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                borderRadius: 8,
                                callbacks: {
                                    label: ctx => ' ₹' + Number(ctx.raw).toLocaleString('en-IN')
                                }
                            }
                        }
                    }
                });
            </script>
        @endpush
