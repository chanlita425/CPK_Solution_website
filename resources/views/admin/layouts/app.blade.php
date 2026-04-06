{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - CPK</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            min-width: 200px;
            display: none;
            z-index: 50;
            overflow: hidden;
        }

        .user-dropdown-menu.show {
            display: block;
            animation: dropdownFade 0.2s ease;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            display: block;
            padding: 10px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background: #f9fafb;
            color: #D7B259;
        }

        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 4px 0;
        }

        /* Custom Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .menu-title {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .nav-link i {
            margin: 0;
            font-size: 1.25rem;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar.collapsed .logo-icon {
            margin: 0 auto;
        }

        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
            min-height: 100vh;
            background: #f5f7fb;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #a0aec0;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(215, 178, 89, 0.1);
            color: #D7B259;
        }

        .nav-link.active {
            background: rgba(215, 178, 89, 0.15);
            color: #D7B259;
            border-left-color: #D7B259;
        }

        .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sidebar-toggle:hover {
            color: #D7B259;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            display: none;
            z-index: 50;
        }

        .user-dropdown-menu.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #2d2d2d;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #D7B259;
            border-radius: 4px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        /* Card Styles */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Table Styles */
        .admin-table {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .admin-table th {
            background: #f8fafc;
            padding: 16px 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        .admin-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Button Styles */
        .btn-primary {
            background: #D7B259;
            color: #1a1a1a;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: #c4a145;
            transform: translateY(-1px);
        }

        /* Status Badge */
        .badge-active {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            padding: 8px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background: #D7B259;
            color: white;
            border-color: #D7B259;
        }

        .pagination .active .page-link {
            background: #D7B259;
            color: white;
            border-color: #D7B259;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo Section -->
        <div class="p-5 border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="logo-icon w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-store text-gray-900 text-xl"></i>
                </div>
                <h1 class="logo-text text-xl font-bold text-yellow-500">CPK Admin</h1>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-5 border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-yellow-500"></i>
                </div>
                <div class="sidebar-text">
                    <p class="text-white font-medium">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-gray-400 text-xs">Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="py-4">
            <div class="px-4 mb-2">
                <p class="menu-title text-gray-500 text-xs uppercase tracking-wider px-4 mb-2">Main</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </div>

            <div class="px-4 mb-2">
                <p class="menu-title text-gray-500 text-xs uppercase tracking-wider px-4 mb-2">Catalog</p>

                <a href="{{ route('admin.categories.index') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i>
                    <span class="sidebar-text">Categories</span>
                </a>

                <a href="{{ route('admin.brands.index') }}"
                    class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                    <i class="fas fa-trademark"></i>
                    <span class="sidebar-text">Brands</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span class="sidebar-text">Products</span>
                </a>
            </div>

            <div class="px-4 mb-2">
                <p class="menu-title text-gray-500 text-xs uppercase tracking-wider px-4 mb-2">Sales</p>

                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="sidebar-text">Orders</span>
                </a>

                <a href="{{ route('admin.coupons.index') }}"
                    class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span class="sidebar-text">Coupons</span>
                </a>
            </div>

            <div class="px-4 mb-2">
                <p class="menu-title text-gray-500 text-xs uppercase tracking-wider px-4 mb-2">Settings</p>

                <a href="{{ route('admin.settings.index') }}"
                    class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
            </div>
        </nav>

        <!-- Logout -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="nav-link w-full text-left">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="sidebar-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <i class="fas fa-bars text-gray-600 text-xl sidebar-toggle cursor-pointer" id="sidebarToggle"></i>
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                </div>

                <div class="user-dropdown">
                    <div class="flex items-center gap-3 cursor-pointer" id="userDropdownBtn">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <span class="text-gray-700 hidden sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <a href="{{ route('admin.profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="border-t my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
                sidebarOverlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        sidebarToggle.addEventListener('click', toggleSidebar);

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Load saved state
        if (window.innerWidth > 768) {
            const saved = localStorage.getItem('sidebarCollapsed');
            if (saved === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        }

        // User Dropdown
        const userBtn = document.getElementById('userDropdownBtn');
        const userMenu = document.getElementById('userDropdownMenu');

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('show');
            });

            document.addEventListener('click', () => {
                userMenu.classList.remove('show');
            });
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('mobile-open');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                    const saved = localStorage.getItem('sidebarCollapsed');
                    if (saved === 'true' && !sidebar.classList.contains('collapsed')) {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');
                    }
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            }, 250);
        });
    </script>

    @stack('scripts')
</body>

</html>
