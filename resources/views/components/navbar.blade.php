{{-- TOP NAVBAR --}}
<nav id="topnav"
    class="topbar
           sticky top-0 z-40
           flex items-center justify-between
           px-4 md:px-6 py-3">

    {{-- LEFT --}}
    <div class="flex items-center gap-3">

        {{-- MOBILE TOGGLE --}}
        <button id="sidebarToggle"
            class="md:hidden
                   inline-flex items-center justify-center
                   w-10 h-10 rounded-xl
                   border border-ui
                   bg-card
                   hover:bg-gray-100 dark:hover:bg-slate-800
                   transition-all duration-200">

            <i class="bi bi-list text-lg"></i>

        </button>

        {{-- PAGE TITLE --}}
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                {{ $title ?? 'Dashboard' }}
            </h1>

        </div>

    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-2 md:gap-3">

        {{-- ADD EXPENSE --}}
        <a href="{{ route('expenses.create') }}" class="btn-primary-ui gap-2">

            <i class="bi bi-plus-lg"></i>

            <span class="hidden md:inline">
                Add Expense
            </span>

        </a>

        {{-- NOTIFICATION --}}
        @php
            $unread = auth()->user()->unreadNotifications->count() ?? 0;
        @endphp

        <div class="relative">

            <button id="notifToggle"
                class="relative
                       inline-flex items-center justify-center
                       w-10 h-10 rounded-xl
                       border border-ui
                       bg-card
                       hover:bg-gray-100 dark:hover:bg-slate-800
                       transition-all duration-200">

                <i class="bi bi-bell text-lg"></i>

                @if ($unread > 0)
                    <span
                        class="absolute -top-1 -right-1
                               min-w-[20px] h-5
                               px-1
                               flex items-center justify-center
                               rounded-full
                               bg-red-500 text-white
                               text-[10px] font-bold">

                        {{ $unread > 9 ? '9+' : $unread }}

                    </span>
                @endif

            </button>

            {{-- DROPDOWN --}}
            <div id="notifMenu"
                class="hidden absolute right-0 mt-3
                       w-80 overflow-hidden
                       rounded-2xl
                       border border-ui
                       bg-card
                       shadow-2xl">

                {{-- HEADER --}}
                <div class="flex items-center justify-between
                           px-4 py-3 border-b border-ui">

                    <h3 class="card-title-ui">
                        Notifications
                    </h3>

                    @if ($unread > 0)
                        <a href="{{ route('notifications.read-all') }}"
                            class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">

                            Mark all read

                        </a>
                    @endif

                </div>

                {{-- ITEMS --}}
                <div class="max-h-96 overflow-y-auto">

                    @forelse(auth()->user()->notifications->take(5) as $notif)
                        <a href="{{ route('notifications.read', $notif->id) }}"
                            class="flex items-start gap-3
                                   px-4 py-4
                                   transition-all duration-200
                                   hover:bg-gray-50 dark:hover:bg-slate-800">

                            <div
                                class="w-10 h-10 rounded-full
                                       flex items-center justify-center
                                       bg-yellow-100 dark:bg-yellow-900/20">

                                <i class="bi bi-bell-fill text-yellow-600"></i>

                            </div>

                            <div class="flex-1 min-w-0">

                                <p class="text-sm text-gray-700 dark:text-slate-300">
                                    {{ $notif->data['message'] }}
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>

                            </div>

                        </a>

                    @empty

                        <div class="px-6 py-10 text-center">

                            <i class="bi bi-check-circle text-3xl text-green-500"></i>

                            <p class="meta-ui mt-2">
                                All caught up!
                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </div>

        {{-- DARK MODE --}}
        <button id="darkToggle"
            class="inline-flex items-center justify-center
                   w-10 h-10 rounded-xl
                   border border-ui
                   bg-card
                   hover:bg-gray-100 dark:hover:bg-slate-800
                   transition-all duration-200">

            <i class="bi bi-moon-stars text-lg" id="darkIcon"></i>

        </button>

        {{-- USER --}}
        <div class="relative">

            <button id="userToggle"
                class="flex items-center gap-3
                       px-2 py-2
                       rounded-xl
                       border border-ui
                       bg-card
                       hover:bg-gray-100 dark:hover:bg-slate-800
                       transition-all duration-200">

                <img src="{{ auth()->user()->avatarUrl() }}" class="w-9 h-9 rounded-full object-cover" alt="avatar">

                <div class="hidden md:flex flex-col items-start leading-tight">

                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="text-xs text-gray-500 dark:text-slate-400">
                        User
                    </span>

                </div>

                <i class="bi bi-chevron-down text-xs text-gray-400"></i>

            </button>

            {{-- DROPDOWN --}}
            <div id="userMenu"
                class="hidden absolute right-0 mt-3
                       w-56 overflow-hidden
                       rounded-2xl
                       border border-ui
                       bg-card
                       shadow-2xl">

                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-3
                           px-4 py-3 text-sm
                           hover:bg-gray-50 dark:hover:bg-slate-800">

                    <i class="bi bi-person"></i>

                    Profile

                </a>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        class="w-full flex items-center gap-3
                               px-4 py-3 text-sm
                               text-red-500
                               hover:bg-red-50 dark:hover:bg-red-900/20">

                        <i class="bi bi-box-arrow-right"></i>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>

@push('scripts')
    <script>
        /* ELEMENTS */
        const notifToggle = document.getElementById('notifToggle');
        const notifMenu = document.getElementById('notifMenu');

        const userToggle = document.getElementById('userToggle');
        const userMenu = document.getElementById('userMenu');

        /* NOTIFICATION DROPDOWN */
        notifToggle?.addEventListener('click', function(e) {

            e.stopPropagation();

            notifMenu?.classList.toggle('hidden');

            userMenu?.classList.add('hidden');

        });

        /* USER DROPDOWN */
        userToggle?.addEventListener('click', function(e) {

            e.stopPropagation();

            userMenu?.classList.toggle('hidden');

            notifMenu?.classList.add('hidden');

        });

        /* OUTSIDE CLICK */
        document.addEventListener('click', function(e) {

            if (
                !notifToggle?.contains(e.target) &&
                !notifMenu?.contains(e.target)
            ) {

                notifMenu?.classList.add('hidden');

            }

            if (
                !userToggle?.contains(e.target) &&
                !userMenu?.contains(e.target)
            ) {

                userMenu?.classList.add('hidden');

            }

        });
    </script>
@endpush
