@extends('layouts.app')

@section('title', $expense->title)

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $expense->title }}</h1>
        <a href="{{ route('expenses.index') }}"
           class="text-gray-600 dark:text-gray-400 hover:underline">
            ← Back to Expenses
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">

        {{-- Detail Rows --}}
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">

            <div class="px-6 py-4 flex justify-between">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount</dt>
                <dd class="text-lg font-bold text-gray-900 dark:text-white">
                    ₹{{ number_format($expense->amount, 2) }}
                </dd>
            </div>

            <div class="px-6 py-4 flex justify-between">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                <dd>
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($expense->category) }}
                    </span>
                </dd>
            </div>

            <div class="px-6 py-4 flex justify-between">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</dt>
                <dd class="text-gray-900 dark:text-white">
                    {{ $expense->expense_date->format('d M Y') }}
                </dd>
            </div>

            <div class="px-6 py-4 flex justify-between">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                <dd class="text-gray-900 dark:text-white">
                    {{ $expense->description ?? '—' }}
                </dd>
            </div>

            <div class="px-6 py-4 flex justify-between">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Receipt</dt>
                <dd class="text-gray-900 dark:text-white">
                    {{ $expense->receipt_path ? '✓ Uploaded' : 'None' }}
                </dd>
            </div>

            <div class="px-6 py-4 flex justify-between">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Added On</dt>
                <dd class="text-gray-900 dark:text-white">
                    {{ $expense->created_at->format('d M Y, h:i A') }}
                </dd>
            </div>

        </dl>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between mt-6">
        <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Delete this expense permanently?')"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                Delete Expense
            </button>
        </form>

        <a href="{{ route('expenses.edit', $expense) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
            Edit Expense
        </a>
    </div>

</div>
@endsection