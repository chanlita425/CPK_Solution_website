@props([
    'page' => 1,
    'total' => 1,
    'size' => 'sm',
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

    // Make sure $page and $total are integers
    $page = (int) $page;
    $total = (int) $total;

    // URL function
    $pgUrl = $pgUrl ?? fn(int $p) => request()->fullUrlWithQuery(['page' => $p]) . '#product-grid';
@endphp

<div class="flex items-center justify-center gap-2">
    {{-- Previous --}}
    @if($page > 1)
        <a href="{{ $pgUrl($page - 1) }}"
           class="w-2.5 h-2.5 rounded-full bg-yellow-400 {{ $dotSpacing }} hover:bg-yellow-500 transition-colors"></a>
    @else
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-100 {{ $dotSpacing }}"></span>
    @endif

    {{-- Page Numbers --}}
    @for($p = 1; $p <= $total; $p++)
        <a href="{{ $pgUrl($p) }}"
            class="{{ $sizeClasses[$size] }} rounded-full flex items-center justify-center transition-colors
            {{ $p === $page ? 'font-bold text-white shadow' : 'font-medium text-gray-500 hover:bg-yellow-50' }}"
            @if($p === $page) style="background:#C9A84C;" @endif>
            {{ $p }}
        </a>
    @endfor

    {{-- Next --}}
    @if($page < $total)
        <a href="{{ $pgUrl($page + 1) }}"
           class="w-2.5 h-2.5 rounded-full bg-yellow-400 {{ $dotSpacing }} hover:bg-yellow-500 transition-colors"></a>
    @else
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-100 {{ $dotSpacing }}"></span>
    @endif
</div>