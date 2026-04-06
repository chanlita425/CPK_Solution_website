{{-- resources/views/vendor/pagination/tailwind.blade.php --}}
@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled">
                <span class="page-link bg-gray-100 cursor-not-allowed">&laquo;</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link hover:bg-yellow-500 hover:text-white">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-item disabled">
                    <span class="page-link">{{ $element }}</span>
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-item active">
                            <span class="page-link bg-yellow-500 text-white border-yellow-500">{{ $page }}</span>
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="page-link hover:bg-yellow-500 hover:text-white">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link hover:bg-yellow-500 hover:text-white">
                &raquo;
            </a>
        @else
            <span class="page-item disabled">
                <span class="page-link bg-gray-100 cursor-not-allowed">&raquo;</span>
            </span>
        @endif
    </div>
@endif
