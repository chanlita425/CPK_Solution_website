{{-- resources/views/components/footer.blade.php --}}
<footer class="bg-[#28282A] text-[#FFFFFF] mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    
                    <div class="leading-tight">
                        <a href="{{ url('/') }}" class="flex items-center gap-4">
                            <div class="rounded-lg flex items-center justify-center ">
                                <img src="{{ asset('images/logo.png') }}" alt="CPK Logo"  >
                            </div> 
                        </a>      
                    </div>
                </div>
                <p class="text-[20px] leading-relaxed  ">
                    Your trusted partner for home appliances, electronics, and smart solutions in Cambodia.
                </p>
            </div>

            {{-- Categories --}}
            <div>
                <h4 class="text-white text-[#D7B259] font-display font-semibold text-md sm:text-[20px] mb-4 uppercase tracking-wide">
                    Categories
                </h4>                
                <ul class="space-y-2 text-[20px]">
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
                <h4 class="text-white font-display  text-[#D7B259] font-semibold text-md sm:text-[20px] mb-4 uppercase tracking-wide">Follow Us</h4>
               <div class="flex items-center gap-3">
                    @foreach([
                        [
                            'icon' => 'fa-brands fa-facebook-f',
                            'href' => 'https://www.facebook.com/yourpage'
                        ],
                        [
                            'icon' => 'fa-brands fa-tiktok',
                            'href' => 'https://www.tiktok.com/@yourusername'
                        ],
                        [
                            'icon' => 'fa-brands fa-instagram',
                            'href' => 'https://www.instagram.com/yourusername'
                        ],
                        [
                            'icon' => 'fa-brands fa-telegram',
                            'href' => 'https://t.me/yourchannel'
                        ],
                    ] as $social)

                    <a href="{{ $social['href'] }}"
                        target="_blank"
                        class="w-9 h-9  flex items-center justify-center rounded-full 
                            bg-white text-black border border-gray-300 
                            hover:bg-gray-100 hover:scale-110 hover:shadow-lg 
                            transition-all duration-200">
                        <i class="{{ $social['icon'] }} text-[25px] text-sm"></i>
                    </a>
                    @endforeach
                </div>

                <div class="mt-6 text-[20px] space-y-1 mt-[30px]">
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