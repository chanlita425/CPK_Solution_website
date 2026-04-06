{{-- resources/views/admin/components/sidebar.blade.php --}}
<aside class="admin-sidebar" id="adminSidebar">
    <!-- Logo Section -->
    <div class="sidebar-header" style="padding: 1.5rem; border-bottom: 1px solid #3f3f46;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 36px; height: 36px; background: #D7B259; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-store" style="color: #28282A; font-size: 1.125rem;"></i>
            </div>
            <h1 class="logo-text" style="color: #D7B259; font-size: 1.25rem; font-weight: 700; margin: 0;">CPK Admin</h1>
        </div>
    </div>

    <!-- User Info Section -->
    <div style="padding: 1rem; border-bottom: 1px solid #3f3f46;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 44px; height: 44px; background: rgba(215, 178, 89, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user" style="color: #D7B259; font-size: 1.125rem;"></i>
            </div>
            <div class="user-info-text">
                <p style="color: white; font-size: 0.875rem; font-weight: 500; margin: 0;">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p style="color: #9ca3af; font-size: 0.7rem; margin: 0;">Administrator</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav style="flex: 1; overflow-y: auto; padding: 1rem 0;" class="custom-scrollbar">
        <div style="padding: 0 1rem 0.5rem 1.5rem;">
            <p class="menu-group-title" style="color: #6b7280; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Main</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-chart-line" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Dashboard</span>
        </a>

        <div style="padding: 0.75rem 1rem 0.5rem 1.5rem; margin-top: 0.5rem;">
            <p class="menu-group-title" style="color: #6b7280; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Catalog</p>
        </div>

        <a href="{{ route('admin.categories.index') }}"
           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-folder" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Categories</span>
        </a>

        <a href="{{ route('admin.brands.index') }}"
           class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-trademark" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Brands</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-box" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Products</span>
        </a>

        <div style="padding: 0.75rem 1rem 0.5rem 1.5rem; margin-top: 0.5rem;">
            <p class="menu-group-title" style="color: #6b7280; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Sales</p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-shopping-cart" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Orders</span>
        </a>

        <a href="{{ route('admin.coupons.index') }}"
           class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-ticket-alt" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Coupons</span>
        </a>

        <div style="padding: 0.75rem 1rem 0.5rem 1.5rem; margin-top: 0.5rem;">
            <p class="menu-group-title" style="color: #6b7280; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Settings</p>
        </div>

        <a href="{{ route('admin.settings.index') }}"
           class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; text-decoration: none; gap: 12px;">
            <i class="fas fa-cog" style="width: 20px; font-size: 1rem;"></i>
            <span class="sidebar-text" style="font-size: 0.875rem;">Settings</span>
        </a>
    </nav>

    <!-- Footer Section with Logout -->
    <div style="border-top: 1px solid #3f3f46; padding: 1rem;">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-link" style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #d1d5db; background: none; border: none; width: 100%; text-align: left; cursor: pointer; gap: 12px;">
                <i class="fas fa-sign-out-alt" style="width: 20px; font-size: 1rem;"></i>
                <span class="sidebar-text" style="font-size: 0.875rem;">Logout</span>
            </button>
        </form>
    </div>
</aside>

<style>
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

    .nav-link.active {
        background-color: rgba(215, 178, 89, 0.15);
        color: #D7B259 !important;
    }

    .admin-sidebar.collapsed .sidebar-header {
        justify-content: center;
        padding: 1rem !important;
    }

    .admin-sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.75rem !important;
    }

    .admin-sidebar.collapsed .nav-link i {
        margin-right: 0;
    }
</style>

<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const mainContent = document.getElementById('adminMain');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
                if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
            } else {
                sidebar.classList.toggle('collapsed');
                if (mainContent) mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        // Load saved state on desktop
        if (window.innerWidth > 768) {
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
                if (mainContent) mainContent.classList.add('expanded');
            }
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('mobile-open');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                    const savedState = localStorage.getItem('sidebarCollapsed');
                    if (savedState === 'true' && !sidebar.classList.contains('collapsed')) {
                        sidebar.classList.add('collapsed');
                        if (mainContent) mainContent.classList.add('expanded');
                    }
                } else {
                    sidebar.classList.remove('collapsed');
                    if (mainContent) mainContent.classList.remove('expanded');
                }
            }, 250);
        });
    });
</script>
