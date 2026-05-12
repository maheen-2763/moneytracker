@extends('admin.layouts.app')
@section('title', 'Manage Users')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                Manage Users
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                {{ $users->total() }} total users
            </p>
        </div>

        {{-- Search --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm p-5">
            <form method="GET" class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                    class="flex-1 rounded-xl
                          border border-gray-200 dark:border-gray-700
                          bg-white dark:bg-gray-800
                          px-4 py-2.5 text-sm
                          text-gray-900 dark:text-white
                          placeholder:text-gray-400
                          focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                          focus:border-indigo-500 transition">

                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                       bg-indigo-500 hover:bg-indigo-600
                       text-white text-sm font-medium transition">
                    <i class="bi bi-search"></i> Search
                </button>

                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                       border border-gray-200 dark:border-gray-700
                       text-sm font-medium
                       text-gray-700 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <i class="bi bi-x-lg"></i> Clear
                </a>
            </form>
        </div>

        {{-- Table --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr
                        class="border-b border-gray-200 dark:border-gray-800
                           bg-gray-50 dark:bg-gray-800/50">
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            User
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Expenses
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Total Spent
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Joined
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase
                               tracking-widest text-gray-500 dark:text-gray-400">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr
                            class="border-b border-gray-100 dark:border-gray-800
                               hover:bg-gray-50 dark:hover:bg-gray-800/60
                               transition-colors duration-150">

                            {{-- User --}}
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                                        class="w-9 h-9 rounded-full object-cover
                                            ring-2 ring-gray-200 dark:ring-gray-700">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Expenses --}}
                            <td class="px-6 py-4 align-middle">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full
                                         text-xs font-semibold
                                         bg-gray-100 dark:bg-gray-800
                                         text-gray-700 dark:text-gray-300">
                                    {{ $user->expenses_count }}
                                </span>
                            </td>

                            {{-- Total Spent --}}
                            <td class="px-6 py-4 align-middle">
                                <span class="text-sm font-bold text-red-500">
                                    ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                                </span>
                            </td>

                            {{-- Joined --}}
                            <td
                                class="px-6 py-4 align-middle text-sm
                                   text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">

                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="w-8 h-8 inline-flex items-center justify-center
                                           rounded-lg text-indigo-500
                                           hover:bg-indigo-50 dark:hover:bg-indigo-900/20
                                           transition"
                                        title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Ban this user?')"
                                            class="w-8 h-8 inline-flex items-center justify-center
                                               rounded-lg text-yellow-500
                                               hover:bg-yellow-50 dark:hover:bg-yellow-900/20
                                               transition"
                                            title="Ban">
                                            <i class="bi bi-slash-circle"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Permanently delete this user?')"
                                            class="w-8 h-8 inline-flex items-center justify-center
                                               rounded-lg text-red-500
                                               hover:bg-red-50 dark:hover:bg-red-900/20
                                               transition"
                                            title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <i class="bi bi-people text-4xl text-gray-300 dark:text-gray-700 block mb-2"></i>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    No users found.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center">
            {{ $users->withQueryString()->links() }}
        </div>

    </div>

@endsection
