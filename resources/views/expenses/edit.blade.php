@extends('layouts.app')

@section('title', 'Edit — ' . $expense->title)

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Edit Expense
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Update and manage your expense details
                </p>
            </div>

            <a href="{{ route('expenses.index') }}"
                class="text-sm font-medium text-indigo-500 hover:text-indigo-600 transition">
                ← Back to Expenses
            </a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div
                class="rounded-2xl border border-red-200 dark:border-red-900/40
                    bg-red-50 dark:bg-red-900/10 p-5">
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-circle text-lg text-red-500 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-red-700 dark:text-red-400">
                            Please fix the following errors
                        </h3>
                        <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <form method="POST" action="{{ route('expenses.update', $expense) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Title --}}
                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-semibold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Expense Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $expense->title) }}"
                            placeholder="Enter expense title" required
                            class="w-full rounded-xl
                                  border border-gray-200 dark:border-gray-700
                                  bg-white dark:bg-gray-800
                                  px-4 py-2.5 text-sm
                                  text-gray-900 dark:text-white
                                  placeholder:text-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                  focus:border-indigo-500 transition">
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Amount <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2
                                     text-gray-400 font-medium text-sm">₹</span>
                            <input type="number" name="amount" step="0.01" min="0.01" max="999999.99"
                                value="{{ old('amount', $expense->amount) }}" required
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      pl-8 pr-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition">
                        </div>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category" required
                            class="w-full rounded-xl
                                   border border-gray-200 dark:border-gray-700
                                   bg-white dark:bg-gray-800
                                   px-4 py-2.5 text-sm
                                   text-gray-900 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                   focus:border-indigo-500 transition">
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
                            class="block text-xs font-semibold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Expense Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="expense_date"
                            value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}"
                            max="{{ now()->format('Y-m-d') }}" required
                            class="w-full rounded-xl
                                  border border-gray-200 dark:border-gray-700
                                  bg-white dark:bg-gray-800
                                  px-4 py-2.5 text-sm
                                  text-gray-900 dark:text-white
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                  focus:border-indigo-500 transition">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-semibold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Description
                            <span class="normal-case tracking-normal font-normal text-gray-400 ml-1">
                                (optional)
                            </span>
                        </label>
                        <textarea name="description" rows="4" placeholder="Write additional details..."
                            class="w-full rounded-xl
                                     border border-gray-200 dark:border-gray-700
                                     bg-white dark:bg-gray-800
                                     px-4 py-2.5 text-sm
                                     text-gray-900 dark:text-white
                                     placeholder:text-gray-400
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                     focus:border-indigo-500 transition resize-none">{{ old('description', $expense->description) }}</textarea>
                    </div>

                    {{-- Receipt --}}
                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-semibold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Receipt Upload
                            <span class="normal-case tracking-normal font-normal text-gray-400 ml-1">
                                (optional)
                            </span>
                        </label>

                        @if ($expense->receipt_path)
                            <div
                                class="mb-3 inline-flex items-center gap-2
                                    rounded-lg bg-green-100 dark:bg-green-900/20
                                    px-4 py-2 text-sm font-medium
                                    text-green-700 dark:text-green-400">
                                <i class="bi bi-check-circle-fill"></i>
                                Receipt already uploaded
                            </div>
                        @endif

                        <div
                            class="rounded-xl border-2 border-dashed
                                border-gray-200 dark:border-gray-700
                                bg-gray-50 dark:bg-gray-800/50 p-5">
                            <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf"
                                class="block w-full text-sm
                                      text-gray-500 dark:text-gray-400
                                      file:mr-4 file:rounded-lg file:border-0
                                      file:bg-indigo-500 file:px-4 file:py-2
                                      file:text-sm file:font-medium file:text-white
                                      hover:file:bg-indigo-600 transition">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                JPG, PNG or PDF · max 2MB
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div
                    class="flex items-center justify-end gap-3
                        border-t border-gray-200 dark:border-gray-800
                        px-6 py-4 bg-gray-50 dark:bg-gray-800/50">

                    <a href="{{ route('expenses.index') }}"
                        class="inline-flex items-center justify-center
                           px-5 py-2.5 rounded-xl
                           border border-gray-200 dark:border-gray-700
                           text-sm font-medium
                           text-gray-700 dark:text-gray-300
                           hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center
                           px-6 py-2.5 rounded-xl
                           bg-indigo-500 hover:bg-indigo-600
                           text-sm font-semibold text-white
                           shadow-sm transition">
                        Update Expense
                    </button>

                </div>

            </form>
        </div>

    </div>

@endsection
