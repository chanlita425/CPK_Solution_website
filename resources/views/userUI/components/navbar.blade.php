{{-- resources/views/components/navbar.blade.php --}}
<nav class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-3">
        <div class="flex items-center justify-between h-24 gap-4">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-9 h-9 bg-primary-500 rounded-lg flex items-center justify-center shadow">
                    <img src="{{ asset('images/logo.png') }}" alt="">
                </div>
                <div class="leading-tight">
                    <span class="block font-display font-bold text-gray-800 text-base leading-none">CPK</span>
                    <span class="block text-[10px] text-primary-600 font-semibold tracking-widest uppercase">Solution</span>
                </div>
            </a>

            {{-- Search Bar --}}
            <div class="flex-1 max-w-xl hidden sm:block">
                <form action="" method="GET" class="relative">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search products..."
                        class="w-full border border-gray-200 bg-gray-50 rounded-full py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
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
                        <i class="fa fa-shopping-cart text-xl group-hover:scale-110 transition-transform"></i>
                        <span class="absolute -top-2 -right-2 bg-accent text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center animate-pulse-badge">
                            {{ session('cart_count', 0) }}
                        </span>
                    </div>
                    <span class="hidden md:inline text-sm font-medium">Cart</span>
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