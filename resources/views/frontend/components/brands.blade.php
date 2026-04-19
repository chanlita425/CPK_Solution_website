@php
use App\Models\Brand;
$brands = Brand::where('is_active', true)->get();
@endphp

<section class="category px-8 mt-2">
    <div class="relative bg-[#FCF6ED] rounded-[40px] shadow-sm border border-gray-100 p-14 py-6">
        <p class="text-center text-xs font-Inter text-[#000000] uppercase tracking-widest mb-3">{{ __('messages.brands') }}</p>

        {{-- Swiper --}}
        <div class="swiper brands-swiper overflow-hidden">
            <div class="swiper-wrapper px-[10px]">

                @foreach($brands as $index => $brand)
                    <div class="swiper-slide !w-auto">
                        @php $baseUrl = $filterBaseUrl ?? url()->current(); @endphp
                        <a href="{{ $brandId == $brand->id
                                ? $baseUrl . ($categoryId ? '?category_id=' . $categoryId : '') . (request('search') ? ($categoryId ? '&' : '?') . 'search=' . request('search') : '') . '#product-grid'
                                : $baseUrl . '?brand_id=' . $brand->id . ($categoryId ? '&category_id=' . $categoryId : '') . (request('search') ? '&search=' . request('search') : '') . '#product-grid'
                            }}"
                            data-filter-link="brand"
                            data-brand-id="{{ $brand->id }}"
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

        {{-- Nav buttons --}}
        <button id="brand-prev" class="brand-prev absolute left-6 top-1/2 -translate-y-1/2 -translate-x-3 z-10 w-7 h-7 flex items-center justify-center hover:shadow-lg transition-all mt-2">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19"/>
                <rect x="14" y="5" width="3" height="14" rx="1"/>
            </svg>
        </button>
        <button id="brand-next" class="brand-next absolute right-6 top-1/2 -translate-y-1/2 translate-x-3 z-10 w-7 h-7 flex items-center justify-center hover:shadow-lg transition-all mt-2">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19"/>
                <rect x="7" y="5" width="3" height="14" rx="1"/>
            </svg>
        </button>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiperEl = document.querySelector('.brands-swiper');
        const prevBtn  = document.getElementById('brand-prev');
        const nextBtn  = document.getElementById('brand-next');

        new Swiper(swiperEl, {
            slidesPerView: 'auto',
            spaceBetween: 4,
            grabCursor: true,
            freeMode: true,
            navigation: {
                nextEl: nextBtn,
                prevEl: prevBtn,
            },
            on: {
                init: function () {
                    const showButtons = this.wrapperEl.scrollWidth > this.el.clientWidth;
                    prevBtn.style.display = showButtons ? 'flex' : 'none';
                    nextBtn.style.display = showButtons ? 'flex' : 'none';
                },
                resize: function () {
                    const showButtons = this.wrapperEl.scrollWidth > this.el.clientWidth;
                    prevBtn.style.display = showButtons ? 'flex' : 'none';
                    nextBtn.style.display = showButtons ? 'flex' : 'none';
                },
            },
        });
    });
</script>
@endpush
