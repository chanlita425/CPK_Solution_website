@php
use App\Models\Brand;
$brands = Brand::where('is_active', true)->get();
@endphp

<section class="px-8 mt-2">
    <div class="relative bg-[#FCF6ED] rounded-[40px] px-6 py-5">

        {{-- Label --}}
        <p class="text-center text-xs font-semibold text-[#000000] uppercase tracking-widest mb-4">Brands</p>

        {{-- Swiper --}}
        <div class="swiper brands-swiper overflow-hidden">
            <div class="swiper-wrapper flex items-center">
                @foreach($brands as $index => $brand)
                    <div class="swiper-slide !w-auto">
                        <a href="{{ $brandId == $brand->id
                                ? url()->current() . ($categoryId ? '?category_id=' . $categoryId : '') . (request('search') ? ($categoryId ? '&' : '?') . 'search=' . request('search') : '') . '#product-grid'
                                : url()->current() . '?brand_id=' . $brand->id . ($categoryId ? '&category_id=' . $categoryId : '') . (request('search') ? '&search=' . request('search') : '') . '#product-grid'
                            }}"
                        class="flex items-center justify-center px-4 py-3 rounded-full transition-all duration-200
                        {{ $brandId == $brand->id ? 'bg-[#FFE3A1]' : 'hover:bg-[#FFE3A1]' }}">
                            
                            @if($brand->logo_image)
                                <img src="{{ asset('storage/' . $brand->logo_image) }}"
                                    alt="{{ $brand->name }}"
                                    class="h-8 w-auto object-contain max-w-[90px]">
                            @else
                                <span class="font-bold text-sm text-gray-500 uppercase tracking-wide">
                                    {{ $brand->name }}
                                </span>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Prev button --}}
        <button class="brand-prev absolute left-3 top-1/2 -translate-y-1/2 z-20
            w-8 h-8 flex items-center justify-center
              hover:shadow-lg transition-all">
        </button>

        {{-- Next button --}}
        <button class="brand-next absolute right-3 top-1/2 -translate-y-1/2 z-20
            w-8 h-8 flex items-center justify-center
              hover:shadow-lg transition-all">  
        </button>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSwiper = new Swiper('.brands-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 8,
            grabCursor: true,
            freeMode: true,
            navigation: {
                nextEl: '.brand-next',
                prevEl: '.brand-prev',
            },
            on: {
                init: function () {
                    const wrapperWidth  = this.wrapperEl.scrollWidth;
                    const containerWidth = this.el.clientWidth;
                    const hide = wrapperWidth <= containerWidth;
                    this.navigation.prevEl.style.display = hide ? 'none' : '';
                    this.navigation.nextEl.style.display = hide ? 'none' : '';
                }
            }
        });
    });
</script>
@endpush