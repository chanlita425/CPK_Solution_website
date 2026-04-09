<nav class="px-[5rem] sm:px-[8rem] lg:px-[7rem] mt-[5rem] text-sm text-gray-500 flex flex-wrap items-center gap-1" x-data="{ open: false }">
    
    {{-- Breadcrumbs safely --}}
    @if(!empty($product->breadcrumbs) && is_array($product->breadcrumbs))
        @foreach($product->breadcrumbs as $crumb)
            <a href="{{ url($crumb['url']) }}" class="hover:text-yellow-600 transition-colors">
                {{ $crumb['label'] }}
            </a>
            <span class="text-gray-300">/</span>
        @endforeach
    @endif

    {{-- Product name --}}
    <span class="text-gray-400 truncate max-w-[160px] md:max-w-none cursor-pointer"
          @click="open = !open"
          :class="{'truncate max-w-[160px]': !open, 'truncate-none': open}">
        {{ $product->name_en ?? $product->name ?? 'Product' }}
    </span>
</nav>