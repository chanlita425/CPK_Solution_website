
@php
    $settings = \App\Models\Setting::getSettings();
    $logoPath = $settings->company_logo; // assuming stored as 'settings/filename.jpg'
@endphp

{{-- resources/views/components/navbar.blade.php --}}
<nav class="nav mt-2">
    <div class="max-w-7xl mx-auto px-10 sm:px-12 lg:px-12">
        <div class="flex items-center justify-between h-20 gap-4">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <div class="rounded-lg flex items-center justify-center ">
                @if($logoPath)
                        <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $settings->company_name }}" class="h-10">
                    @else
                        <span class="text-lg font-bold">{{ $settings->company_name ?? 'CPK' }}</span>
                    @endif                
                </div> 
            </a>

            {{-- Search Bar --}}
            <div class="flex-1 max-w-xl hidden sm:block">
                <form action="" method="GET" class="relative">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search products ..."
                        class="w-full border border-gray-400 bg-gray-50  rounded-[18px]  py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition-colors">
                        <i class="fa fa-search text-sm"></i>
                    </button>
                </form>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-4">
                {{-- Cart --}}
                <a href="" class="relative flex items-center gap-1.5 text-gray-600 hover:text-primary-600 transition-colors group">
                    <div class="relative">
                        <i class="fa-solid fa-bag-shopping text-[#28282A] text-[15px] text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <span class="hidden md:inline text-sm font-medium text-[#28282A] text-[15px] ml-1">Cart</span>
                   <span class="absolute -top-1 -right-1 bg-accent text-white text-[10px] font-bold w-2 h-2 rounded-full flex items-center justify-center animate-pulse-badge">
                        {{-- {{ session('cart_count', 0) }} --}}
                    </span>
                </a>

                {{-- Mobile search toggle --}}
                <button class="sm:hidden text-gray-500 hover:text-primary-500" id="mobileSearchBtn">
                    <i class="fa fa-search text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Search --}}
        <div class="sm:hidden pb-3 hidden" id="mobileSearch">
            <form action="" method="GET" class="relative">
                <input
                    type="text"
                    name="q"
                    placeholder="Search products..."
                    class="w-full border border-gray-200 bg-gray-50 rounded-full py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                >
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

    


<script>
    document.getElementById('mobileSearchBtn')?.addEventListener('click', () => {
        document.getElementById('mobileSearch').classList.toggle('hidden');
    });
</script>