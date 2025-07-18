@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-row justify-center space-x-1">

    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span class="px-3 py-1 rounded border bg-gray-200 text-gray-500 cursor-not-allowed">
        {{ __('pagination.previous') }}
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded border hover:bg-gray-300">
        {{ __('pagination.previous') }}
    </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <span class="px-3 py-1 rounded border bg-gray-200 cursor-default">{{ $element }}</span>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="px-3 py-1 rounded border bg-blue-500 text-white">{{ $page }}</span>
    @else
    <a href="{{ $url }}" class="px-3 py-1 rounded border hover:bg-gray-300">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded border hover:bg-gray-300">
        {{ __('pagination.next') }}
    </a>
    @else
    <span class="px-3 py-1 rounded border bg-gray-200 text-gray-500 cursor-not-allowed">
        {{ __('pagination.next') }}
    </span>
    @endif
</nav>
@endif