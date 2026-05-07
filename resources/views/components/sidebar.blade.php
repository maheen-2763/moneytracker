<nav id="sidebar">

    {{-- Brand + close button --}}
    <div class="sidebar-brand d-flex align-items-center justify-content-between">
        <span><i class="bi bi-wallet2 me-2"></i>Money<span class="brand-accent">Tracker</span></span>
        <button class="btn-close btn-close-white d-md-none" id="sidebarClose" style="font-size:0.7rem;"></button>
    </div>

    <ul class="nav flex-column mt-2">

        <li class="nav-section">Main</li>
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </li>

        <li class="nav-section">Finances</li>
        <li class="nav-item">
            <a href="{{ route('expenses.index') }}"
                class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Expenses
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('budgets.index') }}"
                class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
                <i class="bi bi-piggy-bank"></i> Budgets
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.index') }}"
                class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Reports
            </a>
        </li>
        <li class="nav-section">Developer</li>
        <li class="nav-item">
            <a href="{{ route('api.docs') }}" target="_blank" class="nav-link">
                <i class="bi bi-code-slash"></i> API Docs
                <i class="bi bi-box-arrow-up-right ms-auto" style="font-size:.65rem;"></i>
            </a>
        </li>
        <li class="nav-section">Account</li>
        <li class="nav-item">
            <a href="{{ route('profile.index') }}"
                class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('profile.security') }}"
                class="nav-link {{ request()->routeIs('profile.security') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i> Security
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link w-100 text-start text-danger">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </li>

    </ul>
</nav>
