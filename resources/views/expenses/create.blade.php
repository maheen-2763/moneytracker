@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Add Expense</h1>
        <a href="{{ route('expenses.index') }}"
           class="text-gray-600 dark:text-gray-400 hover:underline">
            ← Back to Expenses
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="e.g. Team lunch"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                              text-gray-900 dark:text-white dark:bg-gray-700
                              focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Amount --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Amount <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">₹</span>
                    <input type="number"
                           name="amount"
                           step="0.01"
                           min="0.01"
                           max="999999.99"
                           value="{{ old('amount') }}"
                           placeholder="0.00"
                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg pl-7 pr-3 py-2
                                  text-gray-900 dark:text-white dark:bg-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                               text-gray-900 dark:text-white dark:bg-gray-700
                               focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">-- Select Category --</option>
                    @foreach(['food','travel','office','health','other'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date"
                       name="expense_date"
                       value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                       max="{{ now()->format('Y-m-d') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                              text-gray-900 dark:text-white dark:bg-gray-700
                              focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Description <span class="text-gray-400 text-xs">(optional)</span>
                </label>
                <textarea name="description"
                          rows="3"
                          placeholder="Any additional notes..."
                          class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                                 text-gray-900 dark:text-white dark:bg-gray-700
                                 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            {{-- Receipt --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Receipt <span class="text-gray-400 text-xs">(optional — jpg, png, pdf, max 2MB)</span>
                </label>
                <input type="file"
                       name="receipt"
                       accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full text-gray-700 dark:text-gray-300">
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('expenses.index') }}"
                   class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:underline">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    Save Expense
                </button>
            </div>

        </form>
    </div>
</div>
@endsection