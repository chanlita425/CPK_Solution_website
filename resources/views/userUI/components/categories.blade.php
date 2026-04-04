{{-- resources/views/components/categories.blade.php --}}
@php
$categories = $categories ?? [
    ['name' => 'Smart Lock Key', 'icon' => 'fa-lock',            'slug' => 'smart-lock-key'],
    ['name' => 'CCTV',           'icon' => 'fa-video',           'slug' => 'cctv'],
    ['name' => 'Air Conditioner & Air Cooler', 'icon' => 'fa-wind', 'slug' => 'air-conditioner'],
    ['name' => 'Beauty & Health','icon' => 'fa-spa',             'slug' => 'beauty-health'],
    ['name' => 'Computer & Accessories', 'icon' => 'fa-laptop',  'slug' => 'computer-accessories'],
    ['name' => 'Camera & Lens',  'icon' => 'fa-camera',          'slug' => 'camera-lens'],
    ['name' => 'Furniture',      'icon' => 'fa-couch',           'slug' => 'furniture'],
    ['name' => 'Home Appliance', 'icon' => 'fa-blender',         'slug' => 'home-appliance'],
    ['name' => 'Home Audio & Video', 'icon' => 'fa-tv',          'slug' => 'home-audio-video'],
    ['name' => 'Kitchen Appliance', 'icon' => 'fa-utensils',     'slug' => 'kitchen-appliance'],
    ['name' => 'Computer & Accessories', 'icon' => 'fa-laptop',  'slug' => 'computer-accessories'],
    ['name' => 'Camera & Lens',  'icon' => 'fa-camera',          'slug' => 'camera-lens'],
    ['name' => 'Furniture',      'icon' => 'fa-couch',           'slug' => 'furniture'],
    ['name' => 'Home Appliance', 'icon' => 'fa-blender',         'slug' => 'home-appliance'],
    ['name' => 'Home Audio & Video', 'icon' => 'fa-tv',          'slug' => 'home-audio-video'],
    ['name' => 'Kitchen Appliance', 'icon' => 'fa-utensils',     'slug' => 'kitchen-appliance'],
    ['name' => 'Phone & Accessory', 'icon' => 'fa-mobile-screen','slug' => 'phone-accessory'],
    ['name' => 'Phone & Accessory', 'icon' => 'fa-mobile-screen','slug' => 'phone-accessory'],
];
@endphp

<section class="category px-14">

    <div class="relative  bg-[#FFEDD0] rounded-[40px] shadow-sm border border-gray-100 p-4"">
            <p class="text-center text-xs font-Inter text-[#000000] uppercase tracking-widest mb-3">Categories</p>

        {{-- Swiper --}}
        <div class="swiper categories-swiper overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($categories as $cat)
                <div class="swiper-slide !w-auto">
                    <a href=""
                       class="flex flex-col items-center gap-1.5 px-3 py-2 rounded-xl hover:bg-primary-50 transition-colors group w-20 text-center">
                        <div class="w-11 h-11 bg-primary-50 group-hover:bg-primary-100 rounded-xl flex items-center justify-center transition-colors shadow-sm">
                            <i class="fa {{ $cat['icon'] }} text-primary-600 text-base"></i>
                        </div>
                        <span class="text-[10px] font-medium text-gray-600 group-hover:text-primary-700 leading-tight transition-colors">
                            {{ $cat['name'] }}
                        </span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Nav buttons --}}
        <button class="cat-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-3 z-10 w-7 h-7 bg-white rounded-full shadow-md flex items-center justify-center text-gray-500 hover:text-primary-600 hover:shadow-lg transition-all">
            <i class="fa fa-chevron-left text-xs"></i>
        </button>
        <button class="cat-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-3 z-10 w-7 h-7 bg-white rounded-full shadow-md flex items-center justify-center text-gray-500 hover:text-primary-600 hover:shadow-lg transition-all">
            <i class="fa fa-chevron-right text-xs"></i>
        </button>
    </div>
</section>

@push('scripts')
<script>
    new Swiper('.categories-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 4,
        navigation: {
            nextEl: '.cat-next',
            prevEl: '.cat-prev',
        },
        grabCursor: true,
        freeMode: true,
    });
</script>
@endpush