@extends('layouts.app')

@section('title', 'My Expenses')

@php
    $badgeMap = [
        'food' => 'bg-yellow-100 text-yellow-800',
        'travel' => 'bg-sky-100 text-sky-800',
        'health' => 'bg-green-100 text-green-800',
        'office' => 'bg-violet-100 text-violet-800',
        'other' => 'bg-gray-100 text-gray-700',
    ];
@endphp

@section('content')

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    My Expenses
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $expenses->total() }} total records
                </p>
            </div>

            <a href="{{ route('expenses.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                   bg-indigo-500 hover:bg-indigo-600
                   text-white text-sm font-medium transition">
                <i class="bi bi-plus-lg"></i>
                Add Expense
            </a>
        </div>

        {{-- FILTER --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-6">

            <h2 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                Filter Expenses
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Narrow down your records quickly
            </p>

            <form method="GET" action="{{ route('expenses.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
                        From
                    </label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-700
                              bg-white dark:bg-gray-800
                              text-sm text-gray-900 dark:text-white
                              px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
                        To
                    </label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-700
                              bg-white dark:bg-gray-800
                              text-sm text-gray-900 dark:text-white
                              px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
                        Category
                    </label>
                    <select name="category"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-700
                               bg-white dark:bg-gray-800
                               text-sm text-gray-900 dark:text-white
                               px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                               focus:border-indigo-500">
                        <option value="">All</option>
                        @foreach (array_keys($badgeMap) as $cat)
                            <option value="{{ $cat }}" @selected(request('category') == $cat)>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2
                               px-4 py-2 rounded-lg
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-medium transition">
                        <i class="bi bi-funnel"></i> Filter
                    </button>

                    <a href="{{ route('expenses.index') }}"
                        class="inline-flex items-center justify-center
                          w-10 h-10 rounded-lg
                          border border-gray-200 dark:border-gray-700
                          text-gray-500 dark:text-gray-400
                          hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </form>
        </div>

        {{-- TABLE (desktop) --}}
        <div
            class="hidden md:block rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Title
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Amount
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Category
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Date
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($expenses as $expense)
                        @php
                            $category = $expense->category ?? 'other';
                            $date = $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date) : null;
                        @endphp

                        <tr
                            class="border-b border-gray-100 dark:border-gray-800
                               hover:bg-gray-50 dark:hover:bg-gray-800/60
                               transition-colors duration-150">

                            {{-- Title --}}
                            <td class="px-6 py-4 align-middle">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $expense->title }}
                                </p>
                                @if ($expense->notes)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ Str::limit($expense->notes, 40) }}
                                    </p>
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td class="px-6 py-4 align-middle text-sm font-bold text-red-500">
                                ₹{{ number_format($expense->amount, 2) }}
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4 align-middle">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full
                                         text-xs font-semibold
                                         {{ $badgeMap[$category] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($category) }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 align-middle text-sm text-gray-500 dark:text-gray-400">
                                {{ $date ? $date->diffForHumans() : 'No date' }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-3">

                                    <a href="{{ route('expenses.show', $expense) }}"
                                        class="text-indigo-500 hover:text-indigo-600 transition">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('expenses.edit', $expense) }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                        onsubmit="return confirm('Delete this expense?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-red-500 hover:text-red-600
                                                   bg-transparent border-0 transition">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                No expenses found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- MOBILE CARDS --}}
        <div class="md:hidden space-y-3">

            @forelse($expenses as $expense)
                @php
                    $category = $expense->category ?? 'other';
                    $date = $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date) : null;
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
                                {{ $date ? $date->format('d M Y') : 'No date' }}
                            </p>
                        </div>
                        <p class="text-sm font-bold text-red-500">
                            ₹{{ number_format($expense->amount, 2) }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 {{ $badgeMap[$category] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($category) }}
                        </span>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('expenses.show', $expense) }}"
                                class="text-indigo-500 hover:text-indigo-600 transition">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('expenses.edit', $expense) }}"
                                class="text-yellow-500 hover:text-yellow-600 transition">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="text-red-500 hover:text-red-600
                                           bg-transparent border-0 transition">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($expense->notes)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            {{ $expense->notes }}
                        </p>
                    @endif

                </div>

            @empty
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 py-10">
                    No expenses found
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="flex justify-center">
            {{ $expenses->withQueryString()->links() }}
        </div>

    </div>

@endsection
