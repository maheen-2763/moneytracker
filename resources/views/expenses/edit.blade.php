@extends('layouts.app')

@section('title', 'Edit — ' . $expense->title)

@section('content')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>

                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Edit Expense
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update and manage your expense details
                </p>

            </div>

            <a href="{{ route('expenses.index') }}"
                class="inline-flex items-center gap-2
                  text-sm font-medium
                  text-blue-600 dark:text-blue-400
                  hover:underline">

                ← Back to Expenses

            </a>

        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())

            <div
                class="mb-6 rounded-2xl
                    border border-red-200 dark:border-red-900/40
                    bg-red-50 dark:bg-red-900/10
                    p-5">

                <div class="flex items-start gap-3">

                    <div class="mt-0.5 text-red-500">
                        <i class="bi bi-exclamation-circle text-lg"></i>
                    </div>

                    <div>

                        <h3 class="font-semibold text-red-700 dark:text-red-400">
                            Please fix the following errors
                        </h3>

                        <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-300">

                            @foreach ($errors->all() as $error)
                                <li>
                                    • {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif

        {{-- Form Card --}}
        <div
            class="bg-white dark:bg-gray-900
               border border-gray-200 dark:border-gray-800
               rounded-3xl shadow-sm overflow-hidden">

            <form method="POST" action="{{ route('expenses.update', $expense) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Title --}}
                        <div class="md:col-span-2">

                            <label
                                class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300">

                                Expense Title
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="text" name="title" value="{{ old('title', $expense->title) }}"
                                placeholder="Enter expense title" required
                                class="w-full rounded-2xl
                                      border border-gray-300 dark:border-gray-700
                                      bg-white dark:bg-gray-950
                                      px-4 py-3
                                      text-sm text-gray-900 dark:text-white
                                      placeholder:text-gray-400
                                      focus:border-blue-500
                                      focus:ring-4 focus:ring-blue-500/10
                                      outline-none transition">

                        </div>

                        {{-- Amount --}}
                        <div>

                            <label
                                class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300">

                                Amount
                                <span class="text-red-500">*</span>

                            </label>

                            <div class="relative">

                                <span
                                    class="absolute left-4 top-1/2
                                       -translate-y-1/2
                                       text-gray-400 font-medium">

                                    ₹

                                </span>

                                <input type="number" name="amount" step="0.01" min="0.01" max="999999.99"
                                    value="{{ old('amount', $expense->amount) }}" required
                                    class="w-full rounded-2xl
                                          border border-gray-300 dark:border-gray-700
                                          bg-white dark:bg-gray-950
                                          pl-8 pr-4 py-3
                                          text-sm text-gray-900 dark:text-white
                                          placeholder:text-gray-400
                                          focus:border-blue-500
                                          focus:ring-4 focus:ring-blue-500/10
                                          outline-none transition">

                            </div>

                        </div>

                        {{-- Category --}}
                        <div>

                            <label
                                class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300">

                                Category
                                <span class="text-red-500">*</span>

                            </label>

                            <select name="category" required
                                class="w-full rounded-2xl
                                       border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-950
                                       px-4 py-3
                                       text-sm text-gray-900 dark:text-white
                                       focus:border-blue-500
                                       focus:ring-4 focus:ring-blue-500/10
                                       outline-none transition">

                                @foreach (['food', 'travel', 'office', 'health', 'other'] as $cat)
                                    <option value="{{ $cat }}"
                                        {{ old('category', $expense->category) === $cat ? 'selected' : '' }}>

                                        {{ ucfirst($cat) }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Date --}}
                        <div class="md:col-span-2">

                            <label
                                class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300">

                                Expense Date
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="date" name="expense_date"
                                value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}"
                                max="{{ now()->format('Y-m-d') }}" required
                                class="w-full rounded-2xl
                                      border border-gray-300 dark:border-gray-700
                                      bg-white dark:bg-gray-950
                                      px-4 py-3
                                      text-sm text-gray-900 dark:text-white
                                      focus:border-blue-500
                                      focus:ring-4 focus:ring-blue-500/10
                                      outline-none transition">

                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">

                            <label
                                class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300">

                                Description

                                <span class="text-xs text-gray-400">
                                    (optional)
                                </span>

                            </label>

                            <textarea name="description" rows="5" placeholder="Write additional details..."
                                class="w-full rounded-2xl
                                         border border-gray-300 dark:border-gray-700
                                         bg-white dark:bg-gray-950
                                         px-4 py-3
                                         text-sm text-gray-900 dark:text-white
                                         placeholder:text-gray-400
                                         focus:border-blue-500
                                         focus:ring-4 focus:ring-blue-500/10
                                         outline-none transition resize-none">{{ old('description', $expense->description) }}</textarea>

                        </div>

                        {{-- Receipt --}}
                        <div class="md:col-span-2">

                            <label
                                class="block mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300">

                                Receipt Upload

                                <span class="text-xs text-gray-400">
                                    (optional)
                                </span>

                            </label>

                            @if ($expense->receipt_path)
                                <div
                                    class="mb-4 inline-flex items-center gap-2
                                       rounded-xl
                                       bg-green-100 dark:bg-green-900/20
                                       px-4 py-2
                                       text-sm font-medium
                                       text-green-700 dark:text-green-400">

                                    <i class="bi bi-check-circle-fill"></i>

                                    Receipt already uploaded

                                </div>
                            @endif

                            <div
                                class="rounded-2xl border-2 border-dashed
                                   border-gray-300 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-950/50
                                   p-6">

                                <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf"
                                    class="block w-full text-sm
                                          text-gray-700 dark:text-gray-300
                                          file:mr-4
                                          file:rounded-xl
                                          file:border-0
                                          file:bg-blue-600
                                          file:px-4
                                          file:py-2
                                          file:text-sm
                                          file:font-medium
                                          file:text-white
                                          hover:file:bg-blue-700">

                                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    JPG, PNG or PDF. Recommended max size 2MB.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                <div
                    class="flex flex-col sm:flex-row
                       items-center justify-end
                       gap-3
                       border-t border-gray-200 dark:border-gray-800
                       px-6 sm:px-8 py-5
                       bg-gray-50 dark:bg-gray-950/50">

                    {{-- Cancel --}}
                    <a href="{{ route('expenses.index') }}"
                        class="w-full sm:w-auto
                          inline-flex items-center justify-center
                          rounded-2xl
                          border border-gray-300 dark:border-gray-700
                          px-5 py-3
                          text-sm font-medium
                          text-gray-700 dark:text-gray-300
                          hover:bg-gray-100 dark:hover:bg-gray-800
                          transition">

                        Cancel

                    </a>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full sm:w-auto
                               inline-flex items-center justify-center
                               rounded-2xl
                               bg-yellow-500 hover:bg-yellow-600
                               px-6 py-3
                               text-sm font-semibold
                               text-white
                               shadow-sm transition">

                        Update Expense

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
