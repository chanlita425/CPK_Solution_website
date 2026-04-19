<nav class="px-[5rem] sm:px-[8rem] lg:px-[7rem] mt-[5rem] text-sm text-gray-500 flex flex-wrap items-center gap-1">

    {{-- Home --}}
    <a href="{{ route('home') }}"
       class="hover:text-yellow-600 transition-colors">
        Home
    </a>

    <span class="text-gray-300">/</span>

    {{-- Products --}}
    <a href="{{ route('products') }}"
       class="hover:text-yellow-600 transition-colors">
        Products
    </a>

    <span class="text-gray-300">/</span>

    {{-- Category --}}
    @if($product->category)
        <a href="{{ route('products', ['category_id' => $product->category->id]) }}"
           class="hover:text-yellow-600 transition-colors">
            {{ $product->category->name }}
        </a>

        <span class="text-gray-300">/</span>
    @endif

    {{-- Brand --}}
    @if($product->brand)
        <a href="{{ route('products', ['brand_id' => $product->brand->id]) }}"
           class="hover:text-yellow-600 transition-colors">
            {{ $product->brand->name }}
        </a>

        <span class="text-gray-300">/</span>
    @endif

    {{-- Product --}}
    <span class="text-black font-semibold max-w-[200px] truncate cursor-default">
        {{ $product->name }}
    </span>

</nav>
