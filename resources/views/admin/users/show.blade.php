@extends('admin.layouts.app')
@section('title', 'User: ' . $user->name)

@section('content')

    <div class="space-y-6">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    User Profile
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Viewing details for {{ $user->name }}
                </p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="text-sm font-medium text-indigo-500 hover:text-indigo-600 transition">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── Left: User Card ── --}}
            <div class="space-y-4">

                {{-- Profile Card --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                    {{-- Cover Banner --}}
                    <div class="h-24 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

                    {{-- Avatar & Info --}}
                    <div class="px-6 pb-6 -mt-10">
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                            class="w-20 h-20 rounded-full object-cover
                                   ring-4 ring-white dark:ring-gray-900 mb-4">

                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $user->name }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            {{ $user->email }}
                        </p>

                        @if ($user->bio)
                            <p
                                class="mt-3 text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800
                                      border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                                {{ $user->bio }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Stats Card --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6">

                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-wider">
                        Statistics
                    </h3>

                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-400">
                                {{ $user->expenses_count }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wide">
                                Expenses
                            </p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-red-500 dark:text-red-400">
                                ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wide">
                                Spent
                            </p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-emerald-500 dark:text-emerald-400">
                                {{ $budgets->count() }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wide">
                                Budgets
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Actions Card --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm p-6 space-y-3">

                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-wider">
                        Actions
                    </h3>

                    <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Ban this user?')"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5
                                   rounded-lg border border-amber-300 dark:border-amber-700
                                   text-amber-700 dark:text-amber-300
                                   hover:bg-amber-50 dark:hover:bg-amber-900/20
                                   text-sm font-semibold transition">
                            <i class="bi bi-slash-circle"></i> Ban User
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this user permanently?')"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5
                                   rounded-lg bg-red-500 hover:bg-red-600 dark:hover:bg-red-600
                                   text-white text-sm font-semibold transition">
                            <i class="bi bi-trash"></i> Delete User
                        </button>
                    </form>

                </div>

            </div>

            {{-- ── Right: Expenses Table ── --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Recent Expenses --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="bi bi-clock-history text-indigo-500"></i>
                            Recent Expenses
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                                <tr>
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
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @php
                                    $catColorMap = [
                                        'food' =>
                                            'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200',
                                        'travel' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-800 dark:text-sky-200',
                                        'health' =>
                                            'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200',
                                        'office' =>
                                            'bg-violet-100 dark:bg-violet-900/30 text-violet-800 dark:text-violet-200',
                                        'other' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
                                    ];
                                @endphp

                                @forelse($expenses as $expense)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="px-6 py-4">
                                            <p
                                                class="text-sm font-semibold text-gray-900 dark:text-white truncate max-w-xs">
                                                {{ $expense->title ?: '—' }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                                      {{ $catColorMap[$expense->category] ?? $catColorMap['other'] }}">
                                                {{ ucfirst($expense->category) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-red-600 dark:text-red-400">
                                                ₹{{ number_format($expense->amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-700 mb-3"></i>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    No expenses yet.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $expenses->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection
