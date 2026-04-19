@props([
    'page' => 1,
    'total' => 1,
    'size' => 'sm',
    'pgUrl' => null,
    'pageParam' => 'page',
    'ajax' => true,
])

@php
    $page = (int) $page;
    $total = (int) $total;

    // DON'T show pagination if total pages is 1 or less
    if ($total <= 1) {
        return;
    }
@endphp

@php
    // Pagination dot/button sizes
    $sizeClasses = [
        'xs' => 'w-7 h-7 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-9 h-9 text-base',
        'lg' => 'w-10 h-10 text-base',
    ];

    $dotSpacing = in_array($size, ['lg', 'md']) ? 'mx-1' : '';

    $lastPage = $total;

    // Calculate start and end for pagination
    $start = max(1, $page - 2);
    $end = min($lastPage, $page + 2);

    if ($start <= 3) {
        $start = 1;
        $end = min(5, $lastPage);
    }
    if ($end >= $lastPage - 2) {
        $end = $lastPage;
        $start = max(1, $lastPage - 4);
    }
@endphp

<div class="flex items-center justify-center gap-2">
    {{-- Previous --}}
    @if($page > 1)
        <button type="button" data-page="{{ $page - 1 }}" class="pagination-ajax-btn {{ $dotSpacing }} hover:opacity-70 transition-opacity flex items-center cursor-pointer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19"/>
                <rect x="14" y="5" width="3" height="14" rx="1"/>
            </svg>
        </button>
    @else
        <span class="{{ $dotSpacing }} flex items-center opacity-30 cursor-default">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19"/>
                <rect x="14" y="5" width="3" height="14" rx="1"/>
            </svg>
        </span>
    @endif

    {{-- First page if not in range --}}
    @if($start > 1)
        <button type="button" data-page="1" class="pagination-ajax-btn {{ $sizeClasses[$size] }} flex items-center justify-center transition-colors font-medium text-gray-500 hover:bg-yellow-50 cursor-pointer">
            1
        </button>
        @if($start > 2)
            <span class="px-1 text-gray-400">...</span>
        @endif
    @endif

    {{-- Page numbers --}}
    @for($p = $start; $p <= $end; $p++)
        @if($p == $page)
            <span class="{{ $sizeClasses[$size] }} flex items-center justify-center font-bold text-white shadow cursor-default" style="background:#C9A84C; border-radius:6px;">
                {{ $p }}
            </span>
        @else
            <button type="button" data-page="{{ $p }}" class="pagination-ajax-btn {{ $sizeClasses[$size] }} flex items-center justify-center transition-colors font-medium text-gray-500 hover:bg-yellow-50 cursor-pointer">
                {{ $p }}
            </button>
        @endif
    @endfor

    {{-- Last page if not in range --}}
    @if($end < $lastPage)
        @if($end < $lastPage - 1)
            <span class="px-1 text-gray-400">...</span>
        @endif
        <button type="button" data-page="{{ $lastPage }}" class="pagination-ajax-btn {{ $sizeClasses[$size] }} flex items-center justify-center transition-colors font-medium text-gray-500 hover:bg-yellow-50 cursor-pointer">
            {{ $lastPage }}
        </button>
    @endif

    {{-- Next --}}
    @if($page < $total)
        <button type="button" data-page="{{ $page + 1 }}" class="pagination-ajax-btn {{ $dotSpacing }} hover:opacity-70 transition-opacity flex items-center cursor-pointer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19"/>
                <rect x="7" y="5" width="3" height="14" rx="1"/>
            </svg>
        </button>
    @else
        <span class="{{ $dotSpacing }} flex items-center opacity-30 cursor-default">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19"/>
                <rect x="7" y="5" width="3" height="14" rx="1"/>
            </svg>
        </span>
    @endif
</div>
