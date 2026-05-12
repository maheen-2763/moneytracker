@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    My Profile
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Manage your personal information
                </p>
            </div>

            <a href="{{ route('profile.edit') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                   bg-indigo-500 hover:bg-indigo-600
                   text-white text-sm font-medium transition">
                <i class="bi bi-pencil"></i>
                Edit Profile
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- ── Left: Avatar Card ── --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm p-6
                    flex flex-col items-center text-center">

                {{-- Avatar --}}
                <div class="relative mb-4">
                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                        class="w-24 h-24 rounded-full object-cover ring-4
                            ring-indigo-100 dark:ring-indigo-900/30">
                    <span
                        class="absolute bottom-1 right-1
                             w-3.5 h-3.5 rounded-full
                             bg-green-500 border-2 border-white dark:border-gray-900">
                    </span>
                </div>

                {{-- Name & Email --}}
                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                    {{ $user->name }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $user->email }}
                </p>

                {{-- Bio --}}
                @if ($user->bio)
                    <p
                        class="text-sm text-gray-600 dark:text-gray-400
                           mt-3 border-t border-gray-100 dark:border-gray-800 pt-3">
                        {{ $user->bio }}
                    </p>
                @endif

                {{-- Stats --}}
                <div
                    class="w-full mt-4 pt-4 border-t border-gray-100 dark:border-gray-800
                        grid grid-cols-3 gap-2">

                    <div>
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white">
                            {{ auth()->user()->expenses()->count() }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Expenses
                        </p>
                    </div>

                    <div>
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white">
                            ₹{{ number_format(auth()->user()->expenses()->sum('amount'), 0) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Total Spent
                        </p>
                    </div>

                    <div>
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white">
                            {{ auth()->user()->expenses()->whereMonth('date', now()->month)->count() }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            This Month
                        </p>
                    </div>

                </div>

            </div>

            {{-- ── Right: Info Cards ── --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Personal Information --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                    <div
                        class="flex items-center gap-2 px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <i class="bi bi-person-lines-fill text-indigo-500"></i>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Personal Information
                        </h2>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-800">

                        <div class="flex items-center justify-between px-6 py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Full Name
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between px-6 py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Email
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between px-6 py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Phone
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $user->phone ?? '—' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between px-6 py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Member Since
                            </p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $user->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Two-Factor Auth
                                </p>
                                <p class="text-xs mt-0.5">
                                    @if (auth()->user()->two_factor_enabled)
                                        <span class="text-green-500 font-medium">✅ Enabled</span>
                                    @else
                                        <span class="text-gray-400">Not enabled</span>
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('profile.security') }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg
                                   border border-gray-200 dark:border-gray-700
                                   text-xs font-medium
                                   text-gray-700 dark:text-gray-300
                                   hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                Manage Security
                            </a>
                        </div>

                    </div>
                </div>

                {{-- Security --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                    <div
                        class="flex items-center gap-2 px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <i class="bi bi-shield-lock text-indigo-500"></i>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Security
                        </h2>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                Password
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                Last updated: unknown
                            </p>
                        </div>
                        <a href="{{ route('profile.edit') }}#password"
                            class="inline-flex items-center px-3 py-1.5 rounded-lg
                               border border-gray-200 dark:border-gray-700
                               text-xs font-medium
                               text-gray-700 dark:text-gray-300
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            Change Password
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
