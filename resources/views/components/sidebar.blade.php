{{-- SIDEBAR --}}
<aside id="sidebar"
    class="fixed top-0 left-0 z-50
           h-screen w-60
           flex flex-col
           bg-gray-900
           -translate-x-full md:translate-x-0
           transition-transform duration-300">

    {{-- Brand --}}
    <div class="h-16 px-5 flex items-center justify-between
                border-b border-gray-800 shrink-0">

        <x-app-logo size="md" :dark="true" />

        {{-- Mobile Close --}}
        <button id="sidebarClose"
            class="md:hidden w-8 h-8
                   flex items-center justify-center
                   rounded-lg text-gray-400
                   hover:bg-gray-800 transition">
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

    {{-- Menu --}}
    <div class="flex-1 overflow-y-auto py-4 space-y-6">

        {{-- Main --}}
        <div>
            <p class="px-5 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">
                Main
            </p>
            <div class="space-y-0.5 px-3">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           {{ request()->routeIs('dashboard')
                               ? 'bg-indigo-500/10 text-indigo-400'
                               : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="bi bi-grid-1x2 text-base"></i>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Finances --}}
        <div>
            <p class="px-5 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">
                Finances
            </p>
            <div class="space-y-0.5 px-3">
                <a href="{{ route('expenses.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           {{ request()->routeIs('expenses.*')
                               ? 'bg-indigo-500/10 text-indigo-400'
                               : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="bi bi-receipt text-base"></i>
                    Expenses
                </a>

                <a href="{{ route('budgets.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           {{ request()->routeIs('budgets.*')
                               ? 'bg-indigo-500/10 text-indigo-400'
                               : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="bi bi-piggy-bank text-base"></i>
                    Budgets
                </a>

                <a href="{{ route('reports.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           {{ request()->routeIs('reports.*')
                               ? 'bg-indigo-500/10 text-indigo-400'
                               : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="bi bi-bar-chart-line text-base"></i>
                    Reports
                </a>
            </div>
        </div>

        {{-- Developer --}}
        <div>
            <p class="px-5 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">
                Developer
            </p>
            <div class="space-y-0.5 px-3">
                <a href="{{ route('api.docs') }}" target="_blank"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           text-gray-400 hover:bg-gray-800 hover:text-white">
                    <i class="bi bi-code-slash text-base"></i>
                    API Docs
                    <i class="bi bi-box-arrow-up-right ml-auto text-xs"></i>
                </a>
            </div>
        </div>

        {{-- Account --}}
        <div>
            <p class="px-5 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">
                Account
            </p>
            <div class="space-y-0.5 px-3">
                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           {{ request()->routeIs('profile.index')
                               ? 'bg-indigo-500/10 text-indigo-400'
                               : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="bi bi-person-circle text-base"></i>
                    Profile
                </a>

                <a href="{{ route('profile.security') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
                           text-sm font-medium transition
                           {{ request()->routeIs('profile.security')
                               ? 'bg-indigo-500/10 text-indigo-400'
                               : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="bi bi-shield-lock text-base"></i>
                    Security
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg
                               text-sm font-medium transition
                               text-red-400 hover:bg-red-500/10 hover:text-red-300">
                        <i class="bi bi-box-arrow-left text-base"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>

</aside>

{{-- Mobile Overlay --}}
<div id="sidebarOverlay" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden md:hidden">
</div>
