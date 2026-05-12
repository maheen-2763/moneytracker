@extends('layouts.app')

@section('title', $expense->title)

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl
                        bg-indigo-100 dark:bg-indigo-900/30
                        flex items-center justify-center">
                    <i class="bi bi-receipt text-indigo-500 text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $expense->title }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Expense Details
                    </p>
                </div>
            </div>

            <a href="{{ route('expenses.index') }}"
                class="text-sm font-medium text-indigo-500 hover:text-indigo-600 transition">
                ← Back to Expenses
            </a>
        </div>

        {{-- Main Card --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            {{-- Amount Banner --}}
            <div
                class="px-6 py-6 flex items-center justify-between
                    bg-indigo-50 dark:bg-indigo-900/10
                    border-b border-gray-200 dark:border-gray-800">
                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-widest
                           text-gray-500 dark:text-gray-400">
                        Total Amount
                    </p>
                    <p
                        class="text-4xl font-extrabold tracking-tight
                           text-gray-900 dark:text-white mt-1">
                        ₹{{ number_format($expense->amount, 2) }}
                    </p>
                </div>

                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5
                         rounded-full text-xs font-semibold
                         bg-green-100 dark:bg-green-900/30
                         text-green-700 dark:text-green-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Paid
                </span>
            </div>

            {{-- Detail Rows --}}
            <div class="divide-y divide-gray-100 dark:divide-gray-800">

                {{-- Category --}}
                <div class="flex items-center justify-between px-6 py-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Category
                    </p>
                    @php
                        $badgeMap = [
                            'food' => 'bg-yellow-100 text-yellow-800',
                            'travel' => 'bg-sky-100 text-sky-800',
                            'health' => 'bg-green-100 text-green-800',
                            'office' => 'bg-violet-100 text-violet-800',
                            'other' => 'bg-gray-100 text-gray-700',
                        ];
                    @endphp
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full
                             text-xs font-semibold
                             {{ $badgeMap[$expense->category] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($expense->category) }}
                    </span>
                </div>

                {{-- Date --}}
                <div class="flex items-center justify-between px-6 py-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Expense Date
                    </p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $expense->expense_date->format('d M Y') }}
                    </p>
                </div>

                {{-- Receipt --}}
                <div class="flex items-center justify-between px-6 py-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Receipt
                    </p>
                    @if ($expense->receipt_path)
                        <span
                            class="inline-flex items-center gap-1.5
                                 text-sm font-semibold
                                 text-green-600 dark:text-green-400">
                            <i class="bi bi-check-circle-fill"></i>
                            Uploaded
                        </span>
                    @else
                        <span class="text-sm text-gray-400 dark:text-gray-500">
                            No receipt
                        </span>
                    @endif
                </div>

                {{-- Added On --}}
                <div class="flex items-center justify-between px-6 py-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Added On
                    </p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $expense->created_at->format('d M Y, h:i A') }}
                    </p>
                </div>

                {{-- Description --}}
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Description
                    </p>
                    <div
                        class="rounded-xl bg-gray-50 dark:bg-gray-800
                            border border-gray-100 dark:border-gray-700 p-4">
                        <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                            {{ $expense->description ?: 'No description provided.' }}
                        </p>
                    </div>
                </div>

            </div>

        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-4 flex-wrap">

            <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this expense permanently?')"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                           bg-red-500 hover:bg-red-600
                           text-white text-sm font-semibold
                           shadow-sm transition">
                    <i class="bi bi-trash"></i>
                    Delete Expense
                </button>
            </form>

            <a href="{{ route('expenses.edit', $expense) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                   bg-indigo-500 hover:bg-indigo-600
                   text-white text-sm font-semibold
                   shadow-sm transition">
                <i class="bi bi-pencil-square"></i>
                Edit Expense
            </a>

        </div>

    </div>

@endsection
