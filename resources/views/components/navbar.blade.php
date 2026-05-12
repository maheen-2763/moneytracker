{{-- TOP NAVBAR --}}
<nav
    class="fixed top-0 left-0 right-0 md:left-60 z-40
            h-16 px-6
            flex items-center justify-between
            bg-white dark:bg-gray-900
            border-b border-gray-200 dark:border-gray-800">

    {{-- LEFT: Toggle + Title --}}
    <div class="flex items-center gap-4">

        {{-- Mobile Sidebar Toggle --}}
        <button id="sidebarToggle"
            class="md:hidden w-9 h-9
                   flex items-center justify-center
                   rounded-lg text-gray-500
                   hover:bg-gray-100 dark:hover:bg-gray-800
                   transition">
            <i class="bi bi-list text-xl"></i>
        </button>

        {{-- Page Title --}}

        <h1 class="text-lg font-semibold text-gray-800 dark:text-white">
            {{ $title ?? 'Dashboard' }}
        </h1>

    </div>

    {{-- RIGHT: Actions --}}
    <div class="flex items-center gap-2">

        {{-- Add Expense --}}
        <a href="{{ route('expenses.create') }}"
            class="hidden md:inline-flex items-center gap-2
                   px-4 py-2 rounded-lg
                   bg-indigo-500 hover:bg-indigo-600
                   text-white text-sm font-medium
                   transition">
            <i class="bi bi-plus-lg"></i>
            Add Expense
        </a>

        {{-- Notifications --}}
        @php $unread = auth()->user()->unreadNotifications->count() ?? 0; @endphp

        <div class="relative">
            <button id="notifToggle"
                class="relative w-9 h-9
                       flex items-center justify-center
                       rounded-lg text-gray-500
                       hover:bg-gray-100 dark:hover:bg-gray-800
                       transition">
                <i class="bi bi-bell text-lg"></i>
                @if ($unread > 0)
                    <span
                        class="absolute -top-0.5 -right-0.5
                                 w-4 h-4 rounded-full
                                 bg-red-500 text-white
                                 text-[9px] font-bold
                                 flex items-center justify-center">
                        {{ $unread > 9 ? '9+' : $unread }}
                    </span>
                @endif
            </button>

            {{-- Notification Dropdown --}}
            <div id="notifMenu"
                class="hidden absolute right-0 mt-2 w-80
                       rounded-xl border border-gray-200 dark:border-gray-700
                       bg-white dark:bg-gray-900
                       shadow-lg overflow-hidden">

                <div
                    class="flex items-center justify-between
                            px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white">
                        Notifications
                    </p>
                    @if ($unread > 0)
                        <a href="{{ route('notifications.read-all') }}"
                            class="text-xs text-indigo-500 hover:text-indigo-600 font-medium">
                            Mark all read
                        </a>
                    @endif
                </div>

                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse(auth()->user()->notifications->take(5) as $notif)
                        <a href="{{ route('notifications.read', $notif->id) }}"
                            class="flex items-start gap-3 px-4 py-3
                                   hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <div
                                class="w-8 h-8 rounded-full
                                        bg-yellow-100 dark:bg-yellow-900/30
                                        flex items-center justify-center shrink-0">
                                <i class="bi bi-bell-fill text-yellow-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $notif->data['message'] }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center text-sm text-gray-400">
                            <i class="bi bi-check-circle text-2xl text-green-400 block mb-2"></i>
                            All caught up!
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        {{-- Dark Mode --}}
        <button id="darkToggle"
            class="w-9 h-9 flex items-center justify-center
                   rounded-lg text-gray-500
                   hover:bg-gray-100 dark:hover:bg-gray-800
                   transition">
            <i class="bi bi-moon-stars text-lg" id="darkIcon"></i>
        </button>

        {{-- User Menu --}}
        <div class="relative">
            <button id="userToggle"
                class="flex items-center gap-2 pl-2 pr-3 py-1.5
                       rounded-lg
                       hover:bg-gray-100 dark:hover:bg-gray-800
                       transition">
                <img src="{{ auth()->user()->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover" alt="avatar">
                <span
                    class="hidden md:block text-sm font-medium
                             text-gray-700 dark:text-gray-200">
                    {{ auth()->user()->name }}
                </span>
                <i class="bi bi-chevron-down text-xs text-gray-400"></i>
            </button>

            {{-- User Dropdown --}}
            <div id="userMenu"
                class="hidden absolute right-0 mt-2 w-48
                       rounded-xl border border-gray-200 dark:border-gray-700
                       bg-white dark:bg-gray-900
                       shadow-lg overflow-hidden">

                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-2 px-4 py-3
                           text-sm text-gray-700 dark:text-gray-300
                           hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <i class="bi bi-person"></i> Profile
                </a>

                <a href="{{ route('about') }}"
                    class="flex items-center gap-2 px-4 py-3
                           text-sm text-gray-700 dark:text-gray-300
                           hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                    <i class="bi bi-info-circle text-lg"></i> About App
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center gap-2 px-4 py-3
                                   text-sm text-red-500
                                   hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>

            </div>
        </div>

    </div>

</nav>

@push('scripts')
    <script>
        const notifToggle = document.getElementById('notifToggle');
        const notifMenu = document.getElementById('notifMenu');
        const userToggle = document.getElementById('userToggle');
        const userMenu = document.getElementById('userMenu');

        notifToggle?.addEventListener('click', e => {
            e.stopPropagation();
            notifMenu?.classList.toggle('hidden');
            userMenu?.classList.add('hidden');
        });

        userToggle?.addEventListener('click', e => {
            e.stopPropagation();
            userMenu?.classList.toggle('hidden');
            notifMenu?.classList.add('hidden');
        });

        document.addEventListener('click', () => {
            notifMenu?.classList.add('hidden');
            userMenu?.classList.add('hidden');
        });
    </script>
@endpush
