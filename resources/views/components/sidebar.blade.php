<nav id="sidebar" class="sidebar -translate-x-full md:translate-x-0">

    {{-- Brand --}}
    <div class="sidebar-brand">

        <h1 class="flex items-center gap-2">

            <i class="bi bi-wallet2 text-green-500"></i>

            Money<span>Tracker</span>

        </h1>

        {{-- Mobile Close --}}
        <button id="sidebarClose"
            class="md:hidden inline-flex items-center justify-center
                   w-10 h-10 rounded-xl
                   border border-slate-700
                   hover:bg-slate-800 transition">

            <i class="bi bi-x-lg text-lg text-white"></i>

        </button>

    </div>

    {{-- Menu --}}
    <div class="flex-1 overflow-y-auto py-5">

        {{-- Main --}}
        <p class="sidebar-section">
            Main
        </p>

        <div class="space-y-1 px-3">

            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="bi bi-grid-1x2"></i>

                Dashboard

            </a>

        </div>

        {{-- Finances --}}
        <p class="sidebar-section">
            Finances
        </p>

        <div class="space-y-1 px-3">

            <a href="{{ route('expenses.index') }}"
                class="sidebar-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">

                <i class="bi bi-receipt"></i>

                Expenses

            </a>

            <a href="{{ route('budgets.index') }}"
                class="sidebar-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">

                <i class="bi bi-piggy-bank"></i>

                Budgets

            </a>

            <a href="{{ route('reports.index') }}"
                class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">

                <i class="bi bi-bar-chart-line"></i>

                Reports

            </a>

        </div>

        {{-- Developer --}}
        <p class="sidebar-section">
            Developer
        </p>

        <div class="space-y-1 px-3">

            <a href="{{ route('api.docs') }}" target="_blank" class="sidebar-link">

                <i class="bi bi-code-slash"></i>

                API Docs

                <i class="bi bi-box-arrow-up-right ml-auto text-xs"></i>

            </a>

        </div>

        {{-- Account --}}
        <p class="sidebar-section">
            Account
        </p>

        <div class="space-y-1 px-3">

            <a href="{{ route('profile.index') }}"
                class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">

                <i class="bi bi-person-circle"></i>

                Profile

            </a>

            <a href="{{ route('profile.security') }}"
                class="sidebar-link {{ request()->routeIs('profile.security') ? 'active' : '' }}">

                <i class="bi bi-shield-lock"></i>

                Security

            </a>

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300">

                    <i class="bi bi-box-arrow-left"></i>

                    Logout

                </button>

            </form>

        </div>

    </div>

</nav>

{{-- Overlay --}}
<div id="sidebarOverlay" class="fixed inset-0 z-40
           bg-black/50 backdrop-blur-sm
           hidden md:hidden">
</div>
