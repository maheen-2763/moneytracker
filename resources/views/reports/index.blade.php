@extends('layouts.app')
@section('title', 'Reports')

@php
    $badgeMap = [
        'food' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200',
        'travel' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-800 dark:text-sky-200',
        'health' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200',
        'office' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-800 dark:text-violet-200',
        'other' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
    ];
@endphp

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- ── Page Heading ── --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    📊 Reports
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Filter your expenses and export them
                </p>
            </div>
        </div>

        {{-- ── Summary Cards ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Expenses --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-6">
                <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    Total Expenses
                </div>
                <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ $summary['total'] }}
                </div>
            </div>

            {{-- Total Amount --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-6">
                <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    Total Amount
                </div>
                <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                    ₹{{ number_format($summary['amount'], 2) }}
                </div>
            </div>

            {{-- Highest Amount --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-6">
                <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    Highest
                </div>
                <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">
                    ₹{{ number_format($summary['highest'], 2) }}
                </div>
            </div>

            {{-- Average Amount --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-6">
                <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    Average
                </div>
                <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                    ₹{{ number_format($summary['average'], 2) }}
                </div>
            </div>
        </div>

        {{-- ── Filter Card ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-6">

            <h2 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                Filter Expenses
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Narrow down your records quickly
            </p>

            <form method="GET" action="{{ route('reports.index') }}"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">
                        Category
                    </label>
                    <select name="category"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $filters['category'] == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- From Date --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">
                        From Date
                    </label>
                    <input type="date" name="start_date"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition"
                        value="{{ $filters['start_date'] }}">
                </div>

                {{-- To Date --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">
                        To Date
                    </label>
                    <input type="date" name="end_date"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition"
                        value="{{ $filters['end_date'] }}">
                </div>

                {{-- Filter Button --}}
                <div class="flex gap-2 lg:col-span-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                           bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-600
                           text-white text-sm font-semibold transition">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('reports.index') }}"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg
                           text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800
                           text-sm font-semibold transition">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </form>
        </div>

        {{-- ── Export Buttons ── --}}
        @if ($expenses->count() > 0)
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('expenses.export.excel', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                       bg-green-600 hover:bg-green-700 dark:hover:bg-green-600
                       text-white text-sm font-semibold transition">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="{{ route('expenses.export.pdf', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                       bg-red-600 hover:bg-red-700 dark:hover:bg-red-600
                       text-white text-sm font-semibold transition">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        @endif

        {{-- ── TABLE (Desktop) ── --}}
        <div
            class="hidden md:block rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                #</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Title</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Category</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Amount</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($expenses as $i => $expense)
                            @php
                                $category = $expense->category ?? 'other';
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $i + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $expense->title }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                              {{ $badgeMap[$category] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                                        {{ ucfirst($category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-red-600 dark:text-red-400">
                                    ₹{{ number_format($expense->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-700 mb-3"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            No expenses found for the selected filters.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ── MOBILE CARDS ── --}}
        <div class="md:hidden space-y-3">

            @forelse($expenses as $expense)
                @php
                    $category = $expense->category ?? 'other';
                @endphp

                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-4">

                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $expense->title }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                            </p>
                        </div>
                        <p class="text-sm font-bold text-red-600 dark:text-red-400">
                            ₹{{ number_format($expense->amount, 2) }}
                        </p>
                    </div>

                    <div class="mt-3">
                        <span
                            class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                  {{ $badgeMap[$category] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                            {{ ucfirst($category) }}
                        </span>
                    </div>

                </div>

            @empty
                <div class="text-center py-10">
                    <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-700 mb-3 block"></i>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        No expenses found for the selected filters.
                    </p>
                </div>
            @endforelse

        </div>

    </div>

@endsection
