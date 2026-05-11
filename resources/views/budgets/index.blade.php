@extends('layouts.app')

@section('title', 'Budgets')

@section('content')

    {{-- Heading --}}
    <div class="mb-6 flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            🏷️ Budget Limits
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Set monthly spending limits per category
        </p>
    </div>

    {{-- Add Budget Form --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

        <form method="POST" action="{{ route('budgets.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-12">

            @csrf

            {{-- Category --}}
            <div class="md:col-span-5">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category
                </label>

                <select name="category"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-950 dark:text-white"
                    required>

                    <option value="">Select category...</option>

                    {{-- Unbudgeted categories --}}
                    @forelse($unbudgeted as $cat)
                        <option value="{{ $cat }}">
                            {{ ucfirst($cat) }}
                        </option>
                    @empty
                        <option disabled>
                            All categories have budgets set ✅
                        </option>
                    @endforelse

                    {{-- Existing --}}
                    @if ($budgets->count() > 0)
                        <optgroup label="── Update existing ──">
                            @foreach ($budgets as $b)
                                <option value="{{ $b->category }}">
                                    {{ ucfirst($b->category) }} (update)
                                </option>
                            @endforeach
                        </optgroup>
                    @endif

                </select>
            </div>

            {{-- Amount --}}
            <div class="md:col-span-4">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Monthly Limit (₹)
                </label>

                <div
                    class="flex items-center overflow-hidden rounded-xl border border-gray-300 bg-white shadow-sm focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-950">

                    <span class="border-r border-gray-200 px-4 text-gray-500 dark:border-gray-700 dark:text-gray-400">
                        ₹
                    </span>

                    <input type="number" name="amount" step="0.01" min="1"
                        class="w-full bg-transparent px-4 py-3 text-sm outline-none dark:text-white" placeholder="e.g. 5000"
                        required>
                </div>
            </div>

            {{-- Button --}}
            <div class="md:col-span-3">
                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700">

                    <i class="bi bi-plus-lg"></i>
                    Set Budget
                </button>
            </div>

        </form>
    </div>

    {{-- Empty State --}}
    @if ($budgets->isEmpty())
        <div
            class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center dark:border-gray-700 dark:bg-gray-900">

            <i class="bi bi-piggy-bank mb-3 block text-4xl text-gray-400"></i>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                No budgets set yet. Add one above!
            </p>
        </div>
    @else
        {{-- Budget Cards --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

            @foreach ($budgets as $budget)
                @php
                    $spent = $budget->spentThisMonth();
                    $pct = $budget->percentUsed();
                    $status = $budget->status();
                    $remaining = max(0, $budget->amount - $spent);

                    $barColor = match ($status) {
                        'danger' => 'bg-red-500',
                        'warning' => 'bg-yellow-500',
                        default => 'bg-emerald-500',
                    };

                    $textColor = match ($status) {
                        'danger' => 'text-red-500',
                        'warning' => 'text-yellow-500',
                        default => 'text-emerald-500',
                    };
                @endphp

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900">

                    {{-- Header --}}
                    <div class="mb-4 flex items-start justify-between">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ ucfirst($budget->category) }}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                This month
                            </p>
                        </div>

                        {{-- Dropdown --}}
                        <div class="relative">
                            <button
                                class="rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-gray-600 transition hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                data-bs-toggle="dropdown">

                                <i class="bi bi-three-dots"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end overflow-hidden rounded-xl border-0 shadow-2xl">

                                <li>
                                    <button class="dropdown-item"
                                        onclick="openEditModal(
                                            {{ $budget->id }},
                                            '{{ ucfirst($budget->category) }}',
                                            {{ $budget->amount }}
                                        )">

                                        <i class="bi bi-pencil me-2"></i>
                                        Edit Limit
                                    </button>
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('budgets.destroy', $budget) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="dropdown-item text-danger"
                                            onclick="return confirm('Remove this budget?')">

                                            <i class="bi bi-trash me-2"></i>
                                            Remove
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </div>

                    </div>

                    {{-- Progress --}}
                    <div class="h-3 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-800">

                        <div class="h-full rounded-full {{ $barColor }}" style="width: {{ min($pct, 100) }}%">
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-5 grid grid-cols-3 gap-3 text-center">

                        <div>
                            <div class="text-lg font-bold {{ $textColor }}">
                                ₹{{ number_format($spent, 0) }}
                            </div>

                            <div class="mt-1 text-xs uppercase tracking-wide text-gray-500">
                                Spent
                            </div>
                        </div>

                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $pct }}%
                            </div>

                            <div class="mt-1 text-xs uppercase tracking-wide text-gray-500">
                                Used
                            </div>
                        </div>

                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                ₹{{ number_format($budget->amount, 0) }}
                            </div>

                            <div class="mt-1 text-xs uppercase tracking-wide text-gray-500">
                                Limit
                            </div>
                        </div>

                    </div>

                    {{-- Alerts --}}
                    @if ($pct >= 100)
                        <div
                            class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-950/30 dark:text-red-400">

                            <i class="bi bi-exclamation-triangle-fill me-1"></i>

                            Over budget by
                            ₹{{ number_format($spent - $budget->amount, 0) }}!
                        </div>
                    @elseif($pct >= 80)
                        <div
                            class="mt-5 rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-700 dark:border-yellow-900/50 dark:bg-yellow-950/30 dark:text-yellow-400">

                            <i class="bi bi-exclamation-circle-fill me-1"></i>

                            Only ₹{{ number_format($remaining, 0) }}
                            remaining!
                        </div>
                    @endif

                </div>
            @endforeach

        </div>
    @endif

    {{-- Edit Modal --}}
    <div class="modal fade" id="editBudgetModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content rounded-2xl border-0 bg-white shadow-2xl dark:bg-gray-900">

                <div class="modal-header border-0 pb-0">
                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">
                        Edit Budget
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" id="editBudgetForm">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">

                            Category:
                            <span id="modalCategory" class="font-semibold text-indigo-600"></span>
                        </label>

                        <div
                            class="flex items-center overflow-hidden rounded-xl border border-gray-300 dark:border-gray-700">

                            <span
                                class="border-r border-gray-200 px-4 text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                ₹
                            </span>

                            <input type="number" name="amount" id="modalAmount"
                                class="w-full bg-transparent px-4 py-3 outline-none dark:text-white" step="0.01"
                                min="1" required>
                        </div>

                    </div>

                    <div class="modal-footer border-0 pt-0">

                        <button type="button"
                            class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
                            data-bs-dismiss="modal">

                            Cancel
                        </button>

                        <button type="submit"
                            class="rounded-xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">

                            Save
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openEditModal(id, category, amount) {
                document.getElementById('editBudgetForm').action = `/budgets/${id}`;
                document.getElementById('modalCategory').textContent = category;
                document.getElementById('modalAmount').value = amount;

                new bootstrap.Modal(
                    document.getElementById('editBudgetModal')
                ).show();
            }
        </script>
    @endpush

@endsection
