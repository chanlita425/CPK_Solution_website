{{-- resources/views/admin/components/sidebar.blade.php --}}
<aside class="admin-sidebar bg-navbar text-white flex flex-col h-full shadow-xl transition-all duration-300 ease-in-out" style="width: 260px;">
    <!-- Logo Section -->
    <div class="flex items-center justify-between px-5 py-6 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                <i class="fas fa-store text-gray-800 text-lg"></i>
            </div>
            <h1 class="text-xl font-bold sidebar-text" style="color: #D7B259;">CPK Admin</h1>
        </div>
        <button id="sidebarCollapse" class="lg:hidden text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- User Info Section -->
    <div class="px-5 py-4 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center border-2 border-primary">
                <i class="fas fa-user text-primary text-sm"></i>
            </div>
            <div class="flex-1 min-w-0 sidebar-text">
                <p class="text-sm font-medium text-white truncate">{{ Auth::guard('admin')->user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-gray-400 truncate">Administrator</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 custom-scrollbar">
        <div class="px-3 mb-2">
            <p class="text-xs text-gray-500 uppercase tracking-wider px-3 mb-2 sidebar-text">Main Navigation</p>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-chart-line w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                <i class="fas fa-circle text-primary text-xs ml-auto"></i>
                @endif
            </a>
        </div>

        <div class="px-3 mb-2">
            <p class="text-xs text-gray-500 uppercase tracking-wider px-3 mb-2 sidebar-text">Catalog Management</p>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-folder w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Categories</span>
                @php $categoryCount = App\Models\Category::count(); @endphp
                @if($categoryCount > 0)
                <span class="ml-auto bg-gray-700 text-xs px-2 py-0.5 rounded-full sidebar-text">{{ $categoryCount }}</span>
                @endif
            </a>

            <!-- Brands -->
            <a href="{{ route('admin.brands.index') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.brands.*') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-trademark w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Brands</span>
                @php $brandCount = App\Models\Brand::count(); @endphp
                @if($brandCount > 0)
                <span class="ml-auto bg-gray-700 text-xs px-2 py-0.5 rounded-full sidebar-text">{{ $brandCount }}</span>
                @endif
            </a>

            <!-- Products -->
            <a href="{{ route('admin.products.index') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-box w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Products</span>
                @php $productCount = App\Models\Product::count(); @endphp
                @if($productCount > 0)
                <span class="ml-auto bg-gray-700 text-xs px-2 py-0.5 rounded-full sidebar-text">{{ $productCount }}</span>
                @endif
            </a>
        </div>

        <div class="px-3 mb-2">
            <p class="text-xs text-gray-500 uppercase tracking-wider px-3 mb-2 sidebar-text">Marketing</p>

            <!-- Banners -->
            <a href="{{ route('admin.banners.index') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.banners.*') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-image w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Banners</span>
            </a>

            <!-- Coupons -->
            <a href="{{ route('admin.coupons.index') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.coupons.*') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-ticket-alt w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Coupons</span>
                @php $activeCouponCount = App\Models\Coupon::where('is_active', true)->count(); @endphp
                @if($activeCouponCount > 0)
                <span class="ml-auto bg-green-600 text-white text-xs px-2 py-0.5 rounded-full sidebar-text">{{ $activeCouponCount }}</span>
                @endif
            </a>
        </div>

        <div class="px-3 mb-2">
            <p class="text-xs text-gray-500 uppercase tracking-wider px-3 mb-2 sidebar-text">Settings</p>

            <!-- Profile Settings -->
            <a href="{{ route('admin.settings.profile') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.settings.profile') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-user-circle w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">Profile Settings</span>
            </a>

            <!-- System Settings -->
            <a href="{{ route('admin.settings.system') }}"
               class="nav-link flex items-center px-3 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ request()->routeIs('admin.settings.system') ? 'active bg-primary/20 text-primary' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i class="fas fa-cog w-5 text-lg"></i>
                <span class="ml-3 sidebar-text text-sm">System Settings</span>
            </a>
        </div>
    </nav>

    <!-- Footer Section -->
    <div class="border-t border-gray-700 p-4">
        <div class="space-y-2">
            <!-- Language Switcher -->
            <div class="relative">
                <button id="mobileLangDropdown" class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-300 hover:bg-gray-700 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-globe w-5 text-lg"></i>
                        <span class="ml-3 sidebar-text text-sm">{{ app()->getLocale() == 'km' ? 'ភាសាខ្មែរ' : 'English' }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div id="mobileLangMenu" class="absolute bottom-full left-0 right-0 mb-2 bg-gray-800 rounded-lg shadow-lg hidden z-50">
                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-t-lg">
                        <i class="fas fa-flag-usa w-4 mr-2"></i> English
                    </a>
                    <a href="{{ route('lang.switch', 'km') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-b-lg">
                        <i class="fas fa-flag w-4 mr-2"></i> ភាសាខ្មែរ
                    </a>
                </div>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-red-600/20 hover:text-red-400 transition-colors">
                    <i class="fas fa-sign-out-alt w-5 text-lg"></i>
                    <span class="ml-3 sidebar-text text-sm">Logout</span>
                </button>
            </form>

            <!-- Version Info -->
            <div class="px-3 pt-3">
                <p class="text-xs text-gray-600 text-center sidebar-text">Version 1.0.0</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #3f3f46;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #D7B259;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #c4a145;
    }

    /* Active link styles */
    .nav-link.active {
        background-color: rgba(215, 178, 89, 0.15);
        color: #D7B259;
    }

    /* Collapsed sidebar styles */
    .admin-sidebar.collapsed {
        width: 80px !important;
    }

    .admin-sidebar.collapsed .sidebar-text {
        display: none;
    }

    .admin-sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.625rem;
    }

    .admin-sidebar.collapsed .nav-link i {
        margin: 0;
    }

    .admin-sidebar.collapsed .ml-3,
    .admin-sidebar.collapsed .ml-auto {
        display: none;
    }

    .admin-sidebar.collapsed .px-3 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .admin-sidebar {
            position: fixed;
            left: -260px;
            top: 0;
            bottom: 0;
            z-index: 40;
            height: 100vh;
        }

        .admin-sidebar.mobile-open {
            left: 0;
        }
    }
</style>

<script>
    // Sidebar collapse toggle for desktop
    const sidebarCollapseBtn = document.getElementById('sidebarCollapse');
    const sidebar = document.querySelector('.admin-sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarCollapseBtn) {
        sidebarCollapseBtn.addEventListener('click', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.toggle('collapsed');
            } else {
                sidebar.classList.toggle('mobile-open');
                sidebarOverlay.classList.toggle('hidden');
            }
        });
    }

    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.add('hidden');
        });
    }

    // Language dropdown for mobile
    const mobileLangDropdown = document.getElementById('mobileLangDropdown');
    const mobileLangMenu = document.getElementById('mobileLangMenu');

    if (mobileLangDropdown) {
        mobileLangDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileLangMenu.classList.toggle('hidden');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        if (mobileLangMenu) {
            mobileLangMenu.classList.add('hidden');
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('mobile-open');
                if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
            }
        }, 250);
    });
</script>
