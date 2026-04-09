@props([
    'page' => 1,
    'total' => 1,
    'size' => 'sm',
    'pgUrl' => null, // optional: base URL
    'pageParam' => 'page', // allows xs/sm/lg to have different query params
])

@php
    // Pagination dot/button sizes
    $sizeClasses = [
        'xs' => 'w-7 h-7 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-9 h-9 text-base',
        'lg' => 'w-10 h-10 text-base',
    ];

    $dotSpacing = in_array($size, ['lg', 'md']) ? 'mx-1' : '';

    $page = (int) $page;
    $total = (int) $total;

    // Make sure $pgUrl is a proper string
    $baseUrl = $pgUrl ?? url()->current();

    // Helper function to generate page URLs safely
    $urlForPage = function($p) use ($baseUrl, $pageParam) {
        return request()->fullUrlWithQuery([$pageParam => $p]) . '#product-grid';
    };

    $window = 3;
    $lastPage = $total;
    $start = max(1, $page);
    $end = min($page + $window - 1, $lastPage - 1);
@endphp

<div class="flex items-center justify-center gap-2">
    {{-- Previous --}}
    @if($page > 1)
        <a href="{{ $urlForPage($page - 1) }}" class="{{ $dotSpacing }} hover:opacity-70 transition-opacity flex items-center">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19"/>
                <rect x="14" y="5" width="3" height="14" rx="1"/>
            </svg>
        </a>
    @else
        <span class="{{ $dotSpacing }} flex items-center opacity-30">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19"/>
                <rect x="14" y="5" width="3" height="14" rx="1"/>
            </svg>
        </span>
    @endif

    {{-- Page numbers --}}
    @for($p = $start; $p <= $end; $p++)
        <a href="{{ $urlForPage($p) }}"
            class="{{ $sizeClasses[$size] }} flex items-center justify-center transition-colors
            {{ $p === $page ? 'font-bold text-white shadow' : 'font-medium text-gray-500 hover:bg-yellow-50' }}"
            @if($p === $page) style="background:#C9A84C; border-radius:6px;" @endif>
            {{ $p }}
        </a>
    @endfor

    {{-- Ellipsis if needed --}}
    @if($end < $lastPage - 1)
        <span class="px-1 text-gray-400">...</span>
    @endif

    {{-- Last page --}}
    @if($lastPage > 1)
        <a href="{{ $urlForPage($lastPage) }}"
            class="{{ $sizeClasses[$size] }} flex items-center justify-center transition-colors
            {{ $page === $lastPage ? 'font-bold text-white shadow' : 'font-medium text-gray-500 hover:bg-yellow-50' }}"
            @if($page === $lastPage) style="background:#C9A84C; border-radius:6px;" @endif>
            {{ $lastPage }}
        </a>
    @endif

    {{-- Next --}}
    @if($page < $total)
        <a href="{{ $urlForPage($page + 1) }}" class="{{ $dotSpacing }} hover:opacity-70 transition-opacity flex items-center">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19"/>
                <rect x="7" y="5" width="3" height="14" rx="1"/>
            </svg>
        </a>
    @else
        <span class="{{ $dotSpacing }} flex items-center opacity-30">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19"/>
                <rect x="7" y="5" width="3" height="14" rx="1"/>
            </svg>
        </span>
    @endif
</div>