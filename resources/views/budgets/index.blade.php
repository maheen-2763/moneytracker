@extends('layouts.app')

@section('title', 'Budgets')

@php
    $statusMap = [
        'danger' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200',
        'warning' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200',
        'safe' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200',
    ];

    $barColorMap = [
        'danger' => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        'safe' => 'bg-emerald-500',
    ];
@endphp

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    🏷️ Budget Limits
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Set monthly spending limits per category
                </p>
            </div>
        </div>

        {{-- ── Add Budget Form ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-6">

            <h2 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                Create New Budget
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Set spending limits for categories
            </p>

            <form method="POST" action="{{ route('budgets.store') }}"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                @csrf

                {{-- Category --}}
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">
                        Category
                    </label>
                    <select name="category"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition"
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
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">
                        Monthly Limit (₹)
                    </label>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 dark:text-gray-400">₹</span>
                        <input type="number" name="amount" step="0.01" min="1"
                            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700
                                  rounded-lg bg-white dark:bg-gray-800
                                  text-gray-900 dark:text-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                  focus:border-indigo-500 transition"
                            placeholder="e.g. 5000" required>
                    </div>
                </div>

                {{-- Button --}}
                <div class="lg:col-span-2">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                           bg-indigo-500 hover:bg-indigo-600 dark:hover:bg-indigo-600
                           text-white text-sm font-semibold transition">
                        <i class="bi bi-plus-lg"></i>
                        Set Budget
                    </button>
                </div>

            </form>
        </div>

        {{-- ── Empty State ── --}}
        @if ($budgets->isEmpty())
            <div
                class="rounded-2xl border border-dashed border-gray-300 dark:border-gray-700
                    bg-white dark:bg-gray-900 py-16 text-center">
                <i class="bi bi-piggy-bank text-4xl text-gray-400 dark:text-gray-600 block mb-3"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No budgets set yet. Add one above!
                </p>
            </div>
        @else
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
                                    Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                         text-gray-700 dark:text-gray-300">
                                    Limit</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                         text-gray-700 dark:text-gray-300">
                                    Spent</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                         text-gray-700 dark:text-gray-300">
                                    Used</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                         text-gray-700 dark:text-gray-300">
                                    Progress</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                         text-gray-700 dark:text-gray-300">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @foreach ($budgets as $budget)
                                @php
                                    $spent = $budget->spentThisMonth();
                                    $pct = $budget->percentUsed();
                                    $status = $budget->status();
                                    $remaining = max(0, $budget->amount - $spent);
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ ucfirst($budget->category) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                        ₹{{ number_format($budget->amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-red-600 dark:text-red-400">
                                        ₹{{ number_format($spent, 0) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                                  {{ $statusMap[$status] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                                            {{ $pct }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="w-32 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full {{ $barColorMap[$status] ?? 'bg-gray-400' }}"
                                                style="width: {{ min($pct, 100) }}%"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button
                                                onclick="openEditModal({{ $budget->id }}, '{{ ucfirst($budget->category) }}', {{ $budget->amount }})"
                                                class="p-2 text-indigo-500 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition"
                                                title="Edit budget">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('budgets.destroy', $budget) }}"
                                                class="inline" onsubmit="return confirm('Remove this budget?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                                                    title="Delete budget">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- ── MOBILE CARDS ── --}}
            <div class="md:hidden space-y-4">

                @foreach ($budgets as $budget)
                    @php
                        $spent = $budget->spentThisMonth();
                        $pct = $budget->percentUsed();
                        $status = $budget->status();
                        $remaining = max(0, $budget->amount - $spent);
                    @endphp

                    <div
                        class="rounded-2xl border border-gray-200 dark:border-gray-800
                            bg-white dark:bg-gray-900 shadow-sm p-5">

                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ ucfirst($budget->category) }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    This month
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2">
                                <button
                                    onclick="openEditModal({{ $budget->id }}, '{{ ucfirst($budget->category) }}', {{ $budget->amount }})"
                                    class="p-2 text-indigo-500 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form method="POST" action="{{ route('budgets.destroy', $budget) }}" class="inline"
                                    onsubmit="return confirm('Remove this budget?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mb-4">
                            <div class="h-full {{ $barColorMap[$status] ?? 'bg-gray-400' }}"
                                style="width: {{ min($pct, 100) }}%"></div>
                        </div>

                        {{-- Stats --}}
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div>
                                <div class="text-lg font-bold text-red-600 dark:text-red-400">
                                    ₹{{ number_format($spent, 0) }}
                                </div>
                                <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mt-1">
                                    Spent
                                </div>
                            </div>

                            <div>
                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $pct }}%
                                </div>
                                <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mt-1">
                                    Used
                                </div>
                            </div>

                            <div>
                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    ₹{{ number_format($budget->amount, 0) }}
                                </div>
                                <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mt-1">
                                    Limit
                                </div>
                            </div>
                        </div>

                        {{-- Alerts --}}
                        @if ($pct >= 100)
                            <div
                                class="mt-4 rounded-lg border border-red-200 dark:border-red-900/40
                                    bg-red-50 dark:bg-red-900/20 px-4 py-3 text-sm text-red-700 dark:text-red-400">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Over budget by ₹{{ number_format($spent - $budget->amount, 0) }}!
                            </div>
                        @elseif($pct >= 80)
                            <div
                                class="mt-4 rounded-lg border border-yellow-200 dark:border-yellow-900/40
                                    bg-yellow-50 dark:bg-yellow-900/20 px-4 py-3 text-sm text-yellow-700 dark:text-yellow-400">
                                <i class="bi bi-exclamation-circle-fill me-1"></i>
                                Only ₹{{ number_format($remaining, 0) }} remaining!
                            </div>
                        @endif

                    </div>
                @endforeach

            </div>

        @endif

        {{-- ── Edit Modal (Tailwind) ── --}}
        <div id="editBudgetModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>

            {{-- Modal --}}
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-sm w-full p-6 space-y-6">

                {{-- Header --}}
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Edit Budget
                    </h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>

                {{-- Form --}}
                <form method="POST" id="editBudgetForm" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Category:
                            <span id="modalCategory" class="text-indigo-500 dark:text-indigo-400"></span>
                        </label>
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Monthly Limit (₹)
                        </label>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 dark:text-gray-400">₹</span>
                            <input type="number" name="amount" id="modalAmount" step="0.01" min="1"
                                class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700
                                      rounded-lg bg-white dark:bg-gray-800
                                      text-gray-900 dark:text-white text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition"
                                required>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700
                                  rounded-lg text-gray-700 dark:text-gray-300 text-sm font-semibold
                                  hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-600
                                  rounded-lg text-white text-sm font-semibold transition">
                            Save Changes
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
                document.getElementById('editBudgetModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeEditModal() {
                document.getElementById('editBudgetModal').classList.add('hidden');
                document.body.style.overflow = '';
            }

            // Close modal when clicking outside
            document.getElementById('editBudgetModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeEditModal();
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeEditModal();
            });
        </script>
    @endpush

@endsection
