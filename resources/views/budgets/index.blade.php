@extends('layouts.app')
@section('title', 'Budgets')

@php
    $statusMap = [
        'danger' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
        'warning' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
        'safe' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
    ];
    $barColorMap = [
        'danger' => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        'safe' => 'bg-emerald-500',
    ];
    $iconMap = [
        'danger' => 'bi-exclamation-triangle-fill text-red-500',
        'warning' => 'bi-exclamation-circle-fill text-yellow-500',
        'safe' => 'bi-check-circle-fill text-green-500',
    ];
@endphp

@section('content')

    <div class="space-y-6">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Budget Limits
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Set monthly spending limits per category
                </p>
            </div>

            {{-- Summary badge --}}
            @if ($budgets->count() > 0)
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                             bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400
                             text-xs font-semibold">
                        <i class="bi bi-piggy-bank-fill"></i>
                        {{ $budgets->count() }} {{ Str::plural('Budget', $budgets->count()) }} Set
                    </span>
                </div>
            @endif
        </div>

        {{-- ── Add Budget Form ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div class="flex items-center gap-2 px-6 py-4
                    border-b border-gray-200 dark:border-gray-800">
                <i class="bi bi-plus-circle text-indigo-500"></i>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Create New Budget
                </h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('budgets.store') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    @csrf

                    {{-- Category --}}
                    <div class="lg:col-span-2">
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Category
                        </label>
                        <select name="category" required
                            class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700
                                   rounded-xl bg-white dark:bg-gray-800
                                   text-gray-900 dark:text-white text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                   focus:border-indigo-500 transition">
                            <option value="">Select category...</option>
                            @forelse($unbudgeted as $cat)
                                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                            @empty
                                <option disabled>All categories have budgets ✅</option>
                            @endforelse
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
                    <div class="lg:col-span-2">
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Monthly Limit
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2
                                     text-gray-400 font-medium text-sm">₹</span>
                            <input type="number" name="amount" step="0.01" min="1" placeholder="e.g. 5000"
                                required
                                class="w-full pl-8 pr-4 py-2.5 border border-gray-200 dark:border-gray-700
                                      rounded-xl bg-white dark:bg-gray-800
                                      text-gray-900 dark:text-white text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition">
                        </div>
                    </div>

                    {{-- Button --}}
                    <div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2
                               px-5 py-2.5 rounded-xl
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-semibold transition
                               hover:-translate-y-0.5 duration-200">
                            <i class="bi bi-plus-lg"></i>
                            Set Budget
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ── Empty State ── --}}
        @if ($budgets->isEmpty())
            <div
                class="rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700
                    bg-white dark:bg-gray-900 py-20 text-center">
                <div
                    class="w-16 h-16 rounded-2xl mx-auto mb-4
                        bg-gray-100 dark:bg-gray-800
                        flex items-center justify-center">
                    <i class="bi bi-piggy-bank text-2xl text-gray-400 dark:text-gray-600"></i>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    No budgets set yet
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Add your first budget above to start tracking!
                </p>
            </div>
        @else
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
                                    Category
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                       tracking-widest text-gray-500 dark:text-gray-400">
                                    Limit
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                       tracking-widest text-gray-500 dark:text-gray-400">
                                    Spent
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                       tracking-widest text-gray-500 dark:text-gray-400">
                                    Remaining
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                       tracking-widest text-gray-500 dark:text-gray-400">
                                    Progress
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                       tracking-widest text-gray-500 dark:text-gray-400">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                       tracking-widest text-gray-500 dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets as $budget)
                                @php
                                    $spent = $budget->spentThisMonth();
                                    $pct = $budget->percentUsed();
                                    $status = $budget->status();
                                    $remaining = max(0, $budget->amount - $spent);
                                @endphp
                                <tr
                                    class="border-b border-gray-100 dark:border-gray-800
                                       hover:bg-gray-50 dark:hover:bg-gray-800/60
                                       transition-colors duration-150">

                                    {{-- Category --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ ucfirst($budget->category) }}
                                        </span>
                                    </td>

                                    {{-- Limit --}}
                                    <td
                                        class="px-6 py-4 text-sm font-semibold
                                           text-gray-900 dark:text-white">
                                        ₹{{ number_format($budget->amount, 0) }}
                                    </td>

                                    {{-- Spent --}}
                                    <td class="px-6 py-4 text-sm font-bold text-red-500">
                                        ₹{{ number_format($spent, 0) }}
                                    </td>

                                    {{-- Remaining --}}
                                    <td
                                        class="px-6 py-4 text-sm font-semibold
                                           {{ $remaining > 0 ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $remaining > 0 ? '₹' . number_format($remaining, 0) : 'Over budget' }}
                                    </td>

                                    {{-- Progress --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-28 h-2 bg-gray-200 dark:bg-gray-700
                                                    rounded-full overflow-hidden">
                                                <div class="h-full {{ $barColorMap[$status] ?? 'bg-gray-400' }}
                                                        rounded-full transition-all duration-500"
                                                    style="width: {{ min($pct, 100) }}%">
                                                </div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                                {{ $pct }}%
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                 text-xs font-semibold
                                                 {{ $statusMap[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                            <i class="bi {{ $iconMap[$status] ?? 'bi-circle text-gray-400' }}"></i>
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button
                                                onclick="openEditModal({{ $budget->id }}, '{{ ucfirst($budget->category) }}', {{ $budget->amount }})"
                                                class="w-8 h-8 inline-flex items-center justify-center
                                                   rounded-lg text-indigo-500
                                                   hover:bg-indigo-50 dark:hover:bg-indigo-900/20
                                                   transition"
                                                title="Edit">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </button>
                                            <form method="POST" action="{{ route('budgets.destroy', $budget) }}"
                                                class="inline" onsubmit="return confirm('Remove this budget?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 inline-flex items-center justify-center
                                                       rounded-lg text-red-500
                                                       hover:bg-red-50 dark:hover:bg-red-900/20
                                                       transition"
                                                    title="Delete">
                                                    <i class="bi bi-trash text-sm"></i>
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
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ ucfirst($budget->category) }}
                                </h3>
                                <span
                                    class="inline-flex items-center gap-1 mt-1 text-xs font-semibold
                                         {{ $statusMap[$status] ?? 'bg-gray-100 text-gray-700' }}
                                         px-2 py-0.5 rounded-full">
                                    <i class="bi {{ $iconMap[$status] ?? 'bi-circle' }}"></i>
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button
                                    onclick="openEditModal({{ $budget->id }}, '{{ ucfirst($budget->category) }}', {{ $budget->amount }})"
                                    class="w-8 h-8 inline-flex items-center justify-center
                                       rounded-lg text-indigo-500
                                       hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition">
                                    <i class="bi bi-pencil text-sm"></i>
                                </button>
                                <form method="POST" action="{{ route('budgets.destroy', $budget) }}" class="inline"
                                    onsubmit="return confirm('Remove this budget?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 inline-flex items-center justify-center
                                           rounded-lg text-red-500
                                           hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mb-2">
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                                <span>{{ $pct }}% used</span>
                                <span>₹{{ number_format($remaining, 0) }} left</span>
                            </div>
                            <div class="h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full {{ $barColorMap[$status] ?? 'bg-gray-400' }} rounded-full"
                                    style="width: {{ min($pct, 100) }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div
                            class="grid grid-cols-3 gap-3 text-center mt-4 pt-4
                                border-t border-gray-100 dark:border-gray-800">
                            <div>
                                <p class="text-base font-extrabold text-red-500">
                                    ₹{{ number_format($spent, 0) }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Spent</p>
                            </div>
                            <div>
                                <p class="text-base font-extrabold text-gray-900 dark:text-white">
                                    ₹{{ number_format($budget->amount, 0) }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Limit</p>
                            </div>
                            <div>
                                <p
                                    class="text-base font-extrabold
                                      {{ $remaining > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $remaining > 0 ? '₹' . number_format($remaining, 0) : 'Over' }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Remaining</p>
                            </div>
                        </div>

                        {{-- Alert --}}
                        @if ($pct >= 100)
                            <div
                                class="mt-4 flex items-center gap-2 px-4 py-3 rounded-xl
                                    bg-red-50 dark:bg-red-900/20
                                    border border-red-200 dark:border-red-900/40
                                    text-red-700 dark:text-red-400 text-xs font-medium">
                                <i class="bi bi-exclamation-triangle-fill shrink-0"></i>
                                Over budget by ₹{{ number_format($spent - $budget->amount, 0) }}!
                            </div>
                        @elseif($pct >= 80)
                            <div
                                class="mt-4 flex items-center gap-2 px-4 py-3 rounded-xl
                                    bg-yellow-50 dark:bg-yellow-900/20
                                    border border-yellow-200 dark:border-yellow-900/40
                                    text-yellow-700 dark:text-yellow-400 text-xs font-medium">
                                <i class="bi bi-exclamation-circle-fill shrink-0"></i>
                                Only ₹{{ number_format($remaining, 0) }} remaining!
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

        @endif

        {{-- ── Edit Modal ── --}}
        <div id="editBudgetModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">

            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeEditModal()"></div>

            <div
                class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl
                    max-w-sm w-full overflow-hidden">

                {{-- Modal Header --}}
                <div
                    class="flex items-center justify-between px-6 py-4
                        border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-pencil text-indigo-500"></i>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            Edit Budget
                        </h3>
                    </div>
                    <button onclick="closeEditModal()"
                        class="w-8 h-8 flex items-center justify-center rounded-lg
                           text-gray-400 hover:text-gray-600 dark:hover:text-gray-300
                           hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <form method="POST" id="editBudgetForm" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Category display --}}
                    <div
                        class="flex items-center gap-3 px-4 py-3 rounded-xl
                            bg-indigo-50 dark:bg-indigo-900/20
                            border border-indigo-200 dark:border-indigo-900/40">
                        <i class="bi bi-tag text-indigo-500"></i>
                        <div>
                            <p class="text-xs text-indigo-500 font-semibold uppercase tracking-widest">
                                Category
                            </p>
                            <p id="modalCategory" class="text-sm font-bold text-indigo-700 dark:text-indigo-300">
                            </p>
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-widest
                                  text-gray-500 dark:text-gray-400 mb-1.5">
                            Monthly Limit
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2
                                     text-gray-400 font-medium text-sm">₹</span>
                            <input type="number" name="amount" id="modalAmount" step="0.01" min="1"
                                required
                                class="w-full pl-8 pr-4 py-2.5 rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      text-gray-900 dark:text-white text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 px-4 py-2.5 rounded-xl
                               border border-gray-200 dark:border-gray-700
                               text-gray-700 dark:text-gray-300 text-sm font-semibold
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 rounded-xl
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-semibold transition">
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

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeEditModal();
            });
        </script>
    @endpush

@endsection
