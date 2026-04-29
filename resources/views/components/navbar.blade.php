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

        {{-- Add Expense — icon only on mobile --}}
        <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i>
            <span class="d-none d-md-inline">Add Expense</span>
        </a>

        {{-- User dropdown --}}
        <div class="dropdown">
            <button class="btn btn-sm btn-light d-flex align-items-center gap-2 dropdown-toggle"
                data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatarUrl() }}" class="rounded-circle" width="28" height="28"
                    style="object-fit:cover;" alt="avatar">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
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
        </div>

    </div>
</nav>

{{-- Mobile overlay (tap to close sidebar) --}}
<div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>
