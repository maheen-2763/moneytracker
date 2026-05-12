{{-- resources/views/components/app-logo.blade.php --}}

<a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">

    {{-- LOGO ICON --}}
    <div
        class="relative w-11 h-11 shrink-0
               rounded-2xl overflow-hidden
               bg-gradient-to-br from-indigo-600 via-violet-600 to-blue-600
               shadow-lg shadow-indigo-500/20
               flex items-center justify-center
               transition-all duration-300
               group-hover:scale-105">

        {{-- Wallet --}}
        <div
            class="absolute bottom-[9px]
                   w-7 h-5 rounded-lg
                   bg-white/95 dark:bg-white
                   rotate-[-6deg]">
        </div>

        {{-- Wallet flap --}}
        <div
            class="absolute bottom-[15px] left-[11px]
                   w-5 h-2 rounded-full
                   bg-indigo-300 rotate-[-6deg]">
        </div>

        {{-- Money --}}
        <div
            class="absolute top-[7px] right-[7px]
                   w-4 h-5 rounded-sm
                   bg-emerald-400 rotate-[12deg]
                   border border-emerald-300">
        </div>

        {{-- Coin --}}
        <div
            class="absolute top-[6px] left-[8px]
                   w-2.5 h-2.5 rounded-full
                   bg-yellow-300 shadow">
        </div>

    </div>

    {{-- BRAND --}}
    <div class="flex flex-col leading-tight">

        <span class="text-lg font-black tracking-tight
                   text-gray-900 dark:text-white">
            Expense
        </span>

        <span
            class="-mt-1 text-xs font-semibold tracking-[0.3em]
                   uppercase text-indigo-600 dark:text-indigo-400">
            Tracker
        </span>

    </div>

</a>
