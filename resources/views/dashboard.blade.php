@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Dashboard</h1>

    {{-- ── Summary Cards ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Spent (All Time)</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                ₹ {{ number_format($totalAll, 2) }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">This Month</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">
                ₹ {{ number_format($totalThisMonth, 2) }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">This Week</p>
            <p class="text-3xl font-bold text-green-600 mt-1">
                ₹ {{ number_format($totalThisWeek, 2) }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Expenses</p>
            <p class="text-3xl font-bold text-purple-600 mt-1">
                {{ $totalExpenses }}
            </p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- ── Spending by Category ──────────────────────── --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Spending by Category
            </h2>

            @forelse($byCategory as $item)
                @php
                    $percentage = $totalAll > 0
                        ? round(($item->total / $totalAll) * 100)
                        : 0;

                    $colors = [
                        'food'    => 'bg-yellow-400',
                        'travel'  => 'bg-blue-400',
                        'office'  => 'bg-purple-400',
                        'health'  => 'bg-green-400',
                        'other'   => 'bg-gray-400',
                    ];
                    $color = $colors[$item->category] ?? 'bg-gray-400';
                @endphp

                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ ucfirst($item->category) }}
                            <span class="text-gray-400">({{ $item->count }})</span>
                        </span>
                        <span class="text-gray-900 dark:text-white font-semibold">
                            ₹ {{ number_format($item->total, 2) }}
                            <span class="text-gray-400 text-xs">({{ $percentage }}%)</span>
                        </span>
                    </div>
                    {{-- Progress Bar --}}
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="{{ $color }} h-2 rounded-full"
                             style="width: {{ $percentage }}%">
                        </div>
                    </div>
                </div>

            @empty
                <p class="text-gray-500">No expenses yet.</p>
            @endforelse
        </div>

        {{-- ── Monthly Spending ──────────────────────────── --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Last 6 Months
            </h2>

            @forelse($monthlySpending as $month)
                @php
                    $max = $monthlySpending->max('total');
                    $percentage = $max > 0 ? round(($month['total'] / $max) * 100) : 0;
                @endphp

                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700 dark:text-gray-300">{{ $month['label'] }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            ₹ {{ number_format($month['total'], 2) }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full"
                             style="width: {{ $percentage }}%">
                        </div>
                    </div>
                </div>

            @empty
                <p class="text-gray-500">No data yet.</p>
            @endforelse
        </div>

    </div>

    {{-- ── Recent Expenses ───────────────────────────────── --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                Recent Expenses
            </h2>
            <a href="{{ route('expenses.index') }}"
               class="text-blue-600 hover:underline text-sm">
                View All →
            </a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentExpenses as $expense)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-gray-900 dark:text-white">
                            <a href="{{ route('expenses.show', $expense) }}"
                               class="hover:text-blue-600">
                                {{ $expense->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                            ₹{{ number_format($expense->amount, 2) }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($expense->category) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $expense->expense_date->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                            No expenses yet.
                            <a href="{{ route('expenses.create') }}" class="text-blue-600 hover:underline">Add one!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection