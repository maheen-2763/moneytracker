<nav class="navbar d-flex align-items-center px-3" id="topnav">

    {{-- Hamburger --}}
    <button class="hamburger-btn d-md-none me-3" id="sidebarToggle" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    {{-- Page title --}}
    <span class="page-title">{{ $title ?? 'Dashboard' }}</span>

    {{-- Right side --}}
    <div class="ms-auto d-flex align-items-center gap-2">

        {{-- Add Expense --}}
        <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i>
            <span class="d-none d-md-inline">Add Expense</span>
        </a>
        @auth
            {{-- 🔔 Notifications bell --}}
            @php $unread = auth()->user()->unreadNotifications->count() ?? 0; @endphp
            <div class="dropdown">
                <button class="btn btn-sm btn-light position-relative" data-bs-toggle="dropdown" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    @if ($unread > 0)
                        <span class="notif-badge">{{ $unread > 9 ? '9+' : $unread }}</span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-end notif-dropdown shadow">
                    <div class="notif-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Notifications</span>
                        @if ($unread > 0)
                            <a href="{{ route('notifications.read-all') }}" class="notif-read-all">Mark all read</a>
                        @endif
                    </div>

                    {{-- ← forelse not foreach --}}
                    @forelse(auth()->user()->notifications->take(2) as $notif)
                        <a href="{{ route('notifications.read', $notif->id) }}"
                            class="notif-item {{ is_null($notif->read_at) ? 'unread' : '' }}">
                            <div class="notif-icon">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <div class="notif-body">
                                <div class="notif-text">{{ $notif->data['message'] }}</div>
                                <div class="notif-time">
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="notif-empty">
                            <i class="bi bi-check-circle text-success fs-4 d-block mb-1"></i>
                            All caught up!
                        </div>
                    @endforelse

                    <div class="notif-footer">
                        <a href="{{ route('notifications.index') }}">View all notifications</a>
                    </div>

                </div>{{-- end notif-dropdown --}}
            </div>{{-- end notification dropdown --}}
        @endauth

        {{-- 🌙 Dark mode toggle --}}
        <button class="btn btn-sm btn-light" id="darkToggle" data-bs-toggle="tooltip" data-bs-title="Toggle dark mode">
            <i class="bi bi-moon-stars" id="darkIcon"></i>
        </button>
        @auth
            {{-- 👤 User dropdown --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-light d-flex align-items-center gap-2 dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->avatarUrl() }}" class="rounded-circle" width="28" height="28"
                        style="object-fit:cover;" alt="avatar"> <span
                        class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="bi bi-person me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-left me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>{{-- end user dropdown --}}

        </div>{{-- end ms-auto --}}
    </nav>
@endauth

{{-- Mobile overlay --}}
<div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>
