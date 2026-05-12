@extends('admin.layouts.app')
@section('title', 'All Expenses')

@section('content')

    <div class="space-y-6">

        {{-- ── Page Header ── --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                All Expenses
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ $expenses->total() }} total records
            </p>
        </div>

        {{-- ── Filter Card ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-6">

            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">
                Filters
            </h3>

            <form method="GET" action="{{ route('admin.expenses.index') }}"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">

                {{-- Search --}}
                <div class="lg:col-span-2">
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">
                        Search
                    </label>
                    <input type="text" name="search"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition"
                        placeholder="Search by title..." value="{{ request('search') }}">
                </div>

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
                              focus:border-indigo-500 transition">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- User --}}
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">
                        User
                    </label>
                    <select name="user_id"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition">
                        <option value="">All Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- From Date --}}
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">
                        From
                    </label>
                    <input type="date" name="start_date"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition"
                        value="{{ request('start_date') }}">
                </div>

                {{-- To Date --}}
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-widest">
                        To
                    </label>
                    <input type="date" name="end_date"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700
                              rounded-lg bg-white dark:bg-gray-800
                              text-gray-900 dark:text-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                              focus:border-indigo-500 transition"
                        value="{{ request('end_date') }}">
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2 lg:col-span-6">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                           bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-600
                           text-white text-sm font-semibold transition">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.expenses.index') }}"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                           border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300
                           hover:bg-gray-50 dark:hover:bg-gray-800 text-sm font-semibold transition">
                        <i class="bi bi-x-lg"></i> Clear
                    </a>
                </div>

            </form>
        </div>

        {{-- ── Table ── --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                User</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Title</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Category</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Amount</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Date</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest
                                     text-gray-700 dark:text-gray-300">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @php
                            $catColorMap = [
                                'food' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200',
                                'travel' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-800 dark:text-sky-200',
                                'health' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200',
                                'office' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-800 dark:text-violet-200',
                                'other' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
                            ];
                        @endphp

                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">

                                {{-- User --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $expense->user->avatarUrl() }}" alt="{{ $expense->user->name }}"
                                            class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $expense->user->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $expense->user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Title --}}
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $expense->title ?: '—' }}
                                        </p>
                                        @if ($expense->description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {{ $expense->description }}
                                            </p>
                                        @endif
                                    </div>
                                </td>

                                {{-- Category --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                              {{ $catColorMap[$expense->category] ?? $catColorMap['other'] }}">
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>

                                {{-- Amount --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-red-600 dark:text-red-400">
                                        ₹{{ number_format($expense->amount, 2) }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.expenses.destroy', $expense) }}"
                                        class="inline" onsubmit="return confirm('Permanently delete this expense?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20
                                                   rounded-lg transition"
                                            title="Delete permanently">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-700 mb-3"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            No expenses found.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ── Pagination ── --}}
        <div class="flex justify-center">
            {{ $expenses->withQueryString()->links() }}
        </div>

    </div>

@endsection
