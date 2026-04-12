{{-- resources/views/admin/components/sidebar.blade.php --}}
@php
    $settings = App\Models\Setting::getSettings();
    $companyLogo = $settings->company_logo ?? null;
@endphp

<aside id="sidebar"
    class="fixed left-0 top-0 h-full bg-gradient-to-b from-gray-900 to-gray-800 w-64 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

    <!-- Logo Area - Sticky top - Logo Only -->
    <div class="flex-shrink-0 flex items-center justify-between px-6 py-5 border-b border-gray-700 bg-gray-900">
        {{-- Dynamic Company Logo from Database --}}
        <div class="w-20">
            @if ($companyLogo && Storage::disk('public')->exists($companyLogo))
                <img src="{{ asset('storage/' . $companyLogo) }}" alt="{{ $settings->company_name ?? 'Company Logo' }}"
                    class="w-100 object-contain">
            @else
                {{-- Fallback to public/images/logo.png if exists --}}
                @if (file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="w-full h-full object-contain">
                @else
                    <i class="fas fa-store text-[#D7B259] text-2xl"></i>
                @endif
            @endif
        </div>
        <button id="closeSidebar" class="lg:hidden text-gray-400 hover:text-white absolute right-4">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- User Info -->
    <div class="flex-shrink-0 px-6 py-5 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-[#D7B259] text-lg"></i>
            </div>
            <div>
                <p class="text-white font-medium text-sm">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <p class="text-gray-400 text-xs">Administrator</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu - Scrollable area -->
    <nav class="flex-1 overflow-y-auto px-3 py-4">
        <!-- Main Section -->
        <div class="mb-6">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Main</p>

            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Catalog Section -->
        <div class="mb-6">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Catalog</p>

            <a href="{{ route('admin.categories.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder w-5"></i>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.brands.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="fas fa-trademark w-5"></i>
                <span>Brands</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box w-5"></i>
                <span>Products</span>
            </a>
        </div>

        <!-- Sales Section -->
        <div class="mb-6">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Sales</p>

            <a href="{{ route('admin.orders.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart w-5"></i>
                <span>Orders</span>
            </a>

            <a href="{{ route('admin.coupons.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt w-5"></i>
                <span>Coupons</span>
            </a>
        </div>

        <!-- Settings Section -->
        <div class="mb-6">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Settings</p>

            <a href="{{ route('admin.profile.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-circle w-5"></i>
                <span>Profile</span>
            </a>

            <a href="{{ route('admin.settings.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog w-5"></i>
                <span>Settings</span>
            </a>
        </div>
    </nav>

    <!-- Logout Button - Fixed at bottom, always visible -->
    <div class="flex-shrink-0 p-4 border-t border-gray-700 bg-gray-800 mt-auto">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-full text-left">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.625rem 0.875rem;
        margin-bottom: 0.25rem;
        border-radius: 0.5rem;
        color: #cbd5e1;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .sidebar-link:hover {
        background: rgba(215, 178, 89, 0.1);
        color: #D7B259;
    }

    .sidebar-link.active {
        background: rgba(215, 178, 89, 0.15);
        color: #D7B259;
    }

    .sidebar-link i {
        width: 1.25rem;
        font-size: 1rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const closeBtn = document.getElementById('closeSidebar');
        const menuToggle = document.getElementById('menuToggle');

        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
                if (overlay) overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            if (overlay) overlay.classList.add('hidden');
            document.body.style.overflow = '';
        };

        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });
    });
</script>
