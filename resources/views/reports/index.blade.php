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

    <div class="space-y-6">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Reports
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Filter your expenses and export them
                </p>
            </div>

            {{-- Export Buttons --}}
            @if ($expenses->count() > 0)
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('expenses.export.excel', request()->query()) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                           bg-green-500 hover:bg-green-600
                           text-white text-sm font-semibold transition
                           hover:-translate-y-0.5 duration-200">
                        <i class="bi bi-file-earmark-excel"></i>
                        <span class="hidden sm:inline">Export</span> Excel
                    </a>
                    <a href="{{ route('expenses.export.pdf', request()->query()) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                           bg-red-500 hover:bg-red-600
                           text-white text-sm font-semibold transition
                           hover:-translate-y-0.5 duration-200">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span class="hidden sm:inline">Export</span> PDF
                    </a>
                </div>
            @endif
        </div>

        {{-- ── Summary Cards ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">

            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-4 md:p-6
                    hover:-translate-y-1 hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30
                            flex items-center justify-center">
                        <i class="bi bi-receipt text-indigo-500 text-sm"></i>
                    </div>
                    <p
                        class="text-xs font-semibold uppercase tracking-widest
                           text-gray-500 dark:text-gray-400">
                        Total
                    </p>
                </div>
                <p class="text-2xl md:text-3xl font-extrabold text-indigo-500">
                    {{ $summary['total'] }}
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">expenses</p>
            </div>

            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-4 md:p-6
                    hover:-translate-y-1 hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30
                            flex items-center justify-center">
                        <i class="bi bi-currency-rupee text-red-500 text-sm"></i>
                    </div>
                    <p
                        class="text-xs font-semibold uppercase tracking-widest
                           text-gray-500 dark:text-gray-400">
                        Amount
                    </p>
                </div>
                <p class="text-2xl md:text-3xl font-extrabold text-red-500">
                    ₹{{ number_format($summary['amount'], 0) }}
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">total spent</p>
            </div>

            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-4 md:p-6
                    hover:-translate-y-1 hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30
                            flex items-center justify-center">
                        <i class="bi bi-arrow-up-circle text-amber-500 text-sm"></i>
                    </div>
                    <p
                        class="text-xs font-semibold uppercase tracking-widest
                           text-gray-500 dark:text-gray-400">
                        Highest
                    </p>
                </div>
                <p class="text-2xl md:text-3xl font-extrabold text-amber-500">
                    ₹{{ number_format($summary['highest'], 0) }}
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">single expense</p>
            </div>

            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-4 md:p-6
                    hover:-translate-y-1 hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30
                            flex items-center justify-center">
                        <i class="bi bi-bar-chart text-green-500 text-sm"></i>
                    </div>
                    <p
                        class="text-xs font-semibold uppercase tracking-widest
                           text-gray-500 dark:text-gray-400">
                        Average
                    </p>
                </div>
                <p class="text-2xl md:text-3xl font-extrabold text-green-500">
                    ₹{{ number_format($summary['average'], 0) }}
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">per expense</p>
            </div>

        </div>

        {{-- ── Filter Card ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-5 md:p-6">

            <div class="flex items-center gap-2 mb-4">
                <i class="bi bi-funnel text-indigo-500"></i>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Filter Expenses
                </h2>
            </div>

            <form method="GET" action="{{ route('reports.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                {{-- Category --}}
                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-widest
                              text-gray-500 dark:text-gray-400 mb-1.5">
                        Category
                    </label>
                    <select name="category"
                        class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700
                               rounded-xl bg-white dark:bg-gray-800
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
                    <label
                        class="block text-xs font-semibold uppercase tracking-widest
                              text-gray-500 dark:text-gray-400 mb-1.5">
                        From Date
                    </label>
                    <input type="date" name="start_date" value="{{ $filters['start_date'] }}"
                        class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700
                              rounded-xl bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition">
                </div>

                {{-- To Date --}}
                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-widest
                              text-gray-500 dark:text-gray-400 mb-1.5">
                        To Date
                    </label>
                    <input type="date" name="end_date" value="{{ $filters['end_date'] }}"
                        class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700
                              rounded-xl bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition">
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2 lg:col-span-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2
                           px-5 py-2.5 rounded-xl
                           bg-indigo-500 hover:bg-indigo-600
                           text-white text-sm font-semibold transition">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('reports.index') }}"
                        class="inline-flex items-center justify-center
                           w-10 h-10 rounded-xl
                           border border-gray-200 dark:border-gray-700
                           text-gray-500 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="bi bi-x-lg text-sm"></i>
                    </a>
                </div>

            </form>
        </div>

        {{-- ── Results Info ── --}}
        @if ($expenses->count() > 0)
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $expenses->count() }}
                    </span> of
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $summary['total'] }}
                    </span> expenses
                </p>
            </div>
        @endif

        {{-- ── TABLE (Desktop) ── --}}
        <div
            class="hidden md:block rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead
                        class="bg-gray-50 dark:bg-gray-800/50
                              border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase
                                   tracking-widest text-gray-500 dark:text-gray-400">
                                #
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase
                                   tracking-widest text-gray-500 dark:text-gray-400">
                                Title
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase
                                   tracking-widest text-gray-500 dark:text-gray-400">
                                Category
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase
                                   tracking-widest text-gray-500 dark:text-gray-400">
                                Amount
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase
                                   tracking-widest text-gray-500 dark:text-gray-400">
                                Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $i => $expense)
                            @php $category = $expense->category ?? 'other'; @endphp
                            <tr
                                class="border-b border-gray-100 dark:border-gray-800
                                   hover:bg-gray-50 dark:hover:bg-gray-800/60
                                   transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-400 dark:text-gray-500">
                                    {{ $i + 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-semibold
                                       text-gray-900 dark:text-white">
                                    {{ $expense->title }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full
                                             text-xs font-semibold
                                             {{ $badgeMap[$category] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-red-500">
                                    ₹{{ number_format($expense->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-700 block mb-3"></i>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        No expenses found for the selected filters.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ── MOBILE CARDS ── --}}
        <div class="md:hidden space-y-3">

            @forelse($expenses as $i => $expense)
                @php $category = $expense->category ?? 'other'; @endphp

                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-4">

                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0 mr-3">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ $expense->title }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                            </p>
                        </div>
                        <p class="text-sm font-bold text-red-500 shrink-0">
                            ₹{{ number_format($expense->amount, 2) }}
                        </p>
                    </div>

                    <span
                        class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                             {{ $badgeMap[$category] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($category) }}
                    </span>

                </div>

            @empty
                <div class="text-center py-16">
                    <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-700 block mb-3"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No expenses found for the selected filters.
                    </p>
                </div>
            @endforelse

        </div>

    </div>

@endsection
