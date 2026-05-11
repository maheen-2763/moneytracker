@extends('layouts.app')

@section('title', $expense->title)

@section('content')

    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 transition-colors duration-300">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

                <div>

                    <div class="flex items-center gap-3 mb-2">

                        <div
                            class="w-12 h-12 rounded-2xl
                                bg-blue-100 dark:bg-blue-900/30
                                flex items-center justify-center">

                            <i class="bi bi-receipt text-blue-600 dark:text-blue-400 text-xl"></i>

                        </div>

                        <div>

                            <h1
                                class="text-3xl font-bold tracking-tight
                                   text-gray-900 dark:text-white">

                                {{ $expense->title }}

                            </h1>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Expense Details Overview
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Back Button --}}
                <a href="{{ route('expenses.index') }}"
                    class="inline-flex items-center justify-center gap-2
                      px-5 py-3 rounded-2xl
                      border border-gray-200 dark:border-gray-700
                      bg-white dark:bg-gray-900
                      text-sm font-medium
                      text-gray-700 dark:text-gray-300
                      hover:bg-gray-100 dark:hover:bg-gray-800
                      transition-all duration-200 shadow-sm">

                    <i class="bi bi-arrow-left"></i>

                    Back to Expenses

                </a>

            </div>

            {{-- Main Card --}}
            <div
                class="overflow-hidden rounded-3xl
                    border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900
                    shadow-sm">

                {{-- Top Amount Section --}}
                <div
                    class="px-6 sm:px-8 py-8
                        bg-gradient-to-r
                        from-blue-50 to-indigo-50
                        dark:from-gray-900 dark:to-gray-900
                        border-b border-gray-200 dark:border-gray-800">

                    <div
                        class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-5">

                        <div>

                            <p
                                class="text-sm font-medium
                                  text-gray-500 dark:text-gray-400">

                                Total Amount

                            </p>

                            <h2
                                class="mt-2 text-4xl font-bold
                                   text-gray-900 dark:text-white">

                                ₹{{ number_format($expense->amount, 2) }}

                            </h2>

                        </div>

                        <div>

                            <span
                                class="inline-flex items-center gap-2
                                     px-4 py-2 rounded-full
                                     bg-green-100 dark:bg-green-900/30
                                     text-green-700 dark:text-green-400
                                     text-sm font-semibold">

                                <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                Paid

                            </span>

                        </div>

                    </div>

                </div>

                {{-- Details --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-800">

                    {{-- Category --}}
                    <div class="flex items-center justify-between
                            px-6 sm:px-8 py-5">

                        <div>

                            <p
                                class="text-sm font-medium
                                  text-gray-500 dark:text-gray-400">

                                Category

                            </p>

                        </div>

                        <span
                            class="inline-flex items-center
                                 px-4 py-2 rounded-full
                                 bg-blue-100 dark:bg-blue-900/30
                                 text-blue-700 dark:text-blue-400
                                 text-sm font-semibold">

                            {{ ucfirst($expense->category) }}

                        </span>

                    </div>

                    {{-- Expense Date --}}
                    <div class="flex items-center justify-between
                            px-6 sm:px-8 py-5">

                        <p class="text-sm font-medium
                              text-gray-500 dark:text-gray-400">

                            Expense Date

                        </p>

                        <span class="font-semibold
                                 text-gray-900 dark:text-white">

                            {{ $expense->expense_date->format('d M Y') }}

                        </span>

                    </div>

                    {{-- Description --}}
                    <div class="px-6 sm:px-8 py-6">

                        <p class="text-sm font-medium
                              text-gray-500 dark:text-gray-400 mb-3">

                            Description

                        </p>

                        <div
                            class="rounded-2xl
                                bg-gray-50 dark:bg-gray-800/50
                                border border-gray-100 dark:border-gray-800
                                p-5">

                            <p class="leading-relaxed
                                  text-gray-700 dark:text-gray-300">

                                {{ $expense->description ?: 'No description provided.' }}

                            </p>

                        </div>

                    </div>

                    {{-- Receipt --}}
                    <div class="flex items-center justify-between
                            px-6 sm:px-8 py-5">

                        <p class="text-sm font-medium
                              text-gray-500 dark:text-gray-400">

                            Receipt

                        </p>

                        @if ($expense->receipt_path)
                            <span
                                class="inline-flex items-center gap-2
                                     text-green-600 dark:text-green-400
                                     font-semibold">

                                <i class="bi bi-check-circle-fill"></i>

                                Uploaded

                            </span>
                        @else
                            <span class="text-gray-400 dark:text-gray-500">

                                No receipt uploaded

                            </span>
                        @endif

                    </div>

                    {{-- Created At --}}
                    <div class="flex items-center justify-between
                            px-6 sm:px-8 py-5">

                        <p class="text-sm font-medium
                              text-gray-500 dark:text-gray-400">

                            Added On

                        </p>

                        <span class="text-gray-900 dark:text-white font-medium">

                            {{ $expense->created_at->format('d M Y, h:i A') }}

                        </span>

                    </div>

                </div>

            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col sm:flex-row
                    items-center justify-between
                    gap-4 mt-8">

                {{-- Delete --}}
                <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="w-full sm:w-auto">

                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Delete this expense permanently?')"
                        class="w-full sm:w-auto
                               inline-flex items-center justify-center gap-2
                               px-6 py-3 rounded-2xl
                               bg-red-600 hover:bg-red-700
                               text-white font-semibold
                               shadow-sm hover:shadow-md
                               transition-all duration-200">

                        <i class="bi bi-trash"></i>

                        Delete Expense

                    </button>

                </form>

                {{-- Edit --}}
                <a href="{{ route('expenses.edit', $expense) }}"
                    class="w-full sm:w-auto
                      inline-flex items-center justify-center gap-2
                      px-6 py-3 rounded-2xl
                      bg-yellow-500 hover:bg-yellow-600
                      text-white font-semibold
                      shadow-sm hover:shadow-md
                      transition-all duration-200">

                    <i class="bi bi-pencil-square"></i>

                    Edit Expense

                </a>

            </div>

        </div>

    </div>

@endsection
