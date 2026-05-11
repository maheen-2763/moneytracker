@if ($paginator->hasPages())
    <nav class="flex justify-center">
        <ul class="flex gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="opacity-40 px-3 py-2">‹</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 rounded-lg border hover:bg-indigo-50">
                        ‹
                    </a>
                </li>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-2">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a href="{{ $url }}"
                                class="px-3 py-2 rounded-lg border
                               {{ $page == $paginator->currentPage() ? 'bg-indigo-500 text-white' : 'hover:bg-indigo-50' }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 rounded-lg border hover:bg-indigo-50">
                        ›
                    </a>
                </li>
            @else
                <li class="opacity-40 px-3 py-2">›</li>
            @endif

        </ul>
    </nav>
@endif
