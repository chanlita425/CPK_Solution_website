{{-- resources/views/components/footer.blade.php --}}
<footer class="bg-gray-900 text-gray-400 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-primary-500 rounded-lg flex items-center justify-center shadow">
                        <i class="fa fa-home text-white text-base"></i>
                    </div>
                    <div class="leading-tight">
                        <span class="block font-display font-bold text-white text-base leading-none">CPK</span>
                        <span class="block text-[10px] text-primary-400 font-semibold tracking-widest uppercase">Solution</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-gray-500">
                    Your trusted partner for home appliances, electronics, and smart solutions in Cambodia.
                </p>
            </div>

            {{-- Categories --}}
            <div>
                <h4 class="text-white font-display font-semibold text-sm mb-4 uppercase tracking-wide">Categories</h4>
                <ul class="space-y-2 text-sm">
                    @foreach([
                        'Air Conditioner & Air Cooler' => 'air-conditioner',
                        'Beauty & Health'               => 'beauty-health',
                        'Computer & Accessory'         => 'computer-accessories',
                        'Furniture'                    => 'furniture',
                        'Home Appliances'              => 'home-appliance',
                        'Home Audio & Video'           => 'home-audio-video',
                        'Kitchen Appliances'           => 'kitchen-appliance',
                        'Phone & Accessory'            => 'phone-accessory',
                    ] as $label => $slug)
                    <li>
                        <a href=" "
                           class="hover:text-primary-400 transition-colors flex items-center gap-2">
                             
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Follow Us --}}
            <div>
                <h4 class="text-white font-display font-semibold text-sm mb-4 uppercase tracking-wide">Follow Us</h4>
                <div class="flex items-center gap-3">
                    @foreach([
                        ['icon' => 'fa-brands fa-facebook-f',  'href' => '#', 'bg' => 'bg-blue-600'],
                        ['icon' => 'fa-brands fa-tiktok',      'href' => '#', 'bg' => 'bg-gray-800 border border-gray-600'],
                        ['icon' => 'fa-brands fa-instagram',   'href' => '#', 'bg' => 'bg-gradient-to-br from-pink-500 to-orange-400'],
                        ['icon' => 'fa-brands fa-telegram',    'href' => '#', 'bg' => 'bg-sky-500'],
                    ] as $social)
                    <a href=" "
                       class="{{ $social['bg'] }} w-9 h-9 rounded-full flex items-center justify-center text-white text-sm hover:scale-110 hover:shadow-lg transition-all duration-200">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                    @endforeach
                </div>

                <div class="mt-6 text-sm space-y-1">
                    <p class="flex items-center gap-2">
                        <i class="fa fa-phone text-primary-500 text-xs"></i>
                        <a href="tel:012049676" class="hover:text-primary-400 transition-colors">012 049 676</a>
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa fa-phone text-primary-500 text-xs"></i>
                        <a href="tel:092254567" class="hover:text-primary-400 transition-colors">092 254 567</a>
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa fa-globe text-primary-500 text-xs"></i>
                        <a href="https://www.cpksolution.com" class="hover:text-primary-400 transition-colors">www.cpksolution.com</a>
                    </p>
                </div>
            </div>
        </div>

        
    </div>
</footer>