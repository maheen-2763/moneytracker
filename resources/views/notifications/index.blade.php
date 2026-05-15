@extends('layouts.app')
@section('title', 'Notifications')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                {{-- Back link --}}
                <a href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-indigo-500 hover:text-indigo-600 transition mb-2 inline-block">
                    ← Back to Dashboard
                </a>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Notifications
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Your activity and budget alerts
                </p>
            </div>

            @if (auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('notifications.read-all') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                   border border-indigo-200 dark:border-indigo-900/40
                   text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20
                   text-sm font-medium transition">
                    <i class="bi bi-check-all"></i>
                    Mark all read
                </a>
            @endif
        </div>

        {{-- Notifications List --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            @forelse($notifications as $notif)
                <a href="{{ route('notifications.read', $notif->id) }}"
                    class="flex items-start gap-4 px-6 py-4
                       border-b border-gray-100 dark:border-gray-800
                       hover:bg-gray-50 dark:hover:bg-gray-800/60
                       transition-colors duration-150
                       {{ is_null($notif->read_at) ? 'bg-indigo-50/50 dark:bg-indigo-900/10' : '' }}">

                    {{-- Icon --}}
                    <div
                        class="w-10 h-10 rounded-full shrink-0
                            flex items-center justify-center
                            {{ is_null($notif->read_at) ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'bg-gray-100 dark:bg-gray-800' }}">
                        <i
                            class="bi bi-exclamation-triangle-fill
                              {{ is_null($notif->read_at) ? 'text-yellow-500' : 'text-gray-400 dark:text-gray-500' }}">
                        </i>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-sm font-medium
                              {{ is_null($notif->read_at) ? 'text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ $notif->data['message'] }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            {{ $notif->created_at->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Unread dot --}}
                    @if (is_null($notif->read_at))
                        <span class="w-2 h-2 rounded-full bg-indigo-500 shrink-0 mt-2"></span>
                    @else
                        <i class="bi bi-check text-gray-300 dark:text-gray-700 shrink-0 mt-1"></i>
                    @endif

                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div
                        class="w-16 h-16 rounded-2xl mx-auto mb-4
                            bg-gray-100 dark:bg-gray-800
                            flex items-center justify-center">
                        <i class="bi bi-bell-slash text-2xl text-gray-400 dark:text-gray-600"></i>
                    </div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        All caught up!
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        No notifications yet.
                    </p>
                </div>
            @endforelse
            <a href="{{ route('notifications.index') }}"
                class="flex items-center justify-center gap-1
          px-4 py-3 text-xs font-semibold
          text-indigo-500 hover:text-indigo-600
          border-t border-gray-100 dark:border-gray-800
          hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                See all notifications →
            </a>

        </div>

        {{-- Pagination --}}
        <div class="flex justify-center">
            {{ $notifications->links() }}
        </div>

    </div>

@endsection
