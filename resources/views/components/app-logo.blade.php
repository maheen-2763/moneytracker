@props([
    'size' => 'md',
    'dark' => false,
])

@php
    $sizes = [
        'sm' => ['icon' => 'w-7 h-7 text-xs', 'text' => 'text-sm'],
        'md' => ['icon' => 'w-9 h-9 text-base', 'text' => 'text-lg'],
        'lg' => ['icon' => 'w-12 h-12 text-xl', 'text' => 'text-2xl'],
        'xl' => ['icon' => 'w-16 h-16 text-3xl', 'text' => 'text-4xl'],
    ];
    $s = $sizes[$size] ?? $sizes['md'];
@endphp

<a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5 no-underline group">

    {{-- Icon --}}
    <div
        class="{{ $s['icon'] }} rounded-xl shrink-0
                flex items-center justify-center
                bg-gradient-to-br from-indigo-500 to-violet-500
                shadow-lg shadow-indigo-500/20
                group-hover:shadow-indigo-500/40
                transition-all duration-200">
        <i class="bi bi-graph-up-arrow text-white"></i>
    </div>

    {{-- Text --}}
    <span
        class="{{ $s['text'] }} font-extrabold tracking-tight
                 {{ $dark ? 'text-white' : 'text-gray-900 dark:text-white' }}">
        Money<span class="text-indigo-500">Tracker</span>
    </span>

</a>
