{{-- resources/views/admin/components/header.blade.php --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="px-4 md:px-6 py-4 flex items-center justify-between">
        <!-- Left Section -->
        <div class="flex items-center gap-4">
            <button id="menuToggle" class="lg:hidden text-gray-600 hover:text-[#D7B259] transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Page Title -->
            <div>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                <p class="text-sm text-gray-500 hidden md:block mt-0.5">
                    @yield('subheader', 'Welcome back to your admin dashboard')
                </p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-3 md:gap-4">
            <!-- Quick Actions Dropdown -->
            <div class="relative">
                <button id="quickActionsBtn" class="text-gray-600 hover:text-[#D7B259] transition-colors p-2">
                    <i class="fas fa-plus-circle text-xl"></i>
                </button>

                <div id="quickActionsMenu"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                    <div class="py-2">
                        <a href="{{ route('admin.categories.create') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-folder text-[#D7B259] w-4"></i> Add Category
                        </a>
                        <a href="{{ route('admin.brands.create') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-trademark text-[#D7B259] w-4"></i> Add Brand
                        </a>
                        <a href="{{ route('admin.products.create') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-box text-[#D7B259] w-4"></i> Add Product
                        </a>
                        <div class="border-t my-1"></div>
                        <a href="{{ route('admin.coupons.create') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-ticket-alt text-[#D7B259] w-4"></i> Add Coupon
                        </a>
                    </div>
                </div>
            </div>

            <!-- Admin Profile Dropdown -->
            <div class="relative">
                <button id="userDropdownBtn"
                    class="flex items-center gap-2 md:gap-3 hover:bg-gray-50 rounded-lg px-2 py-1 transition-colors">
                    <div
                        class="w-8 h-8 md:w-9 md:h-9 bg-gradient-to-br from-[#D7B259] to-[#c4a145] rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-900 text-sm"></i>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <i class="fas fa-chevron-down hidden md:block text-xs text-gray-400"></i>
                </button>

                <div id="userDropdownMenu"
                    class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                    <div class="p-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                    </div>
                    <div class="py-2">
                        <a href="{{ route('admin.profile.index') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user-circle text-[#D7B259] w-4"></i> My Profile
                        </a>
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-cog text-[#D7B259] w-4"></i> Settings
                        </a>
                        <div class="border-t my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                <i class="fas fa-sign-out-alt w-4"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // User Dropdown
        const userBtn = document.getElementById('userDropdownBtn');
        const userMenu = document.getElementById('userDropdownMenu');

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function() {
                userMenu.classList.add('hidden');
            });

            userMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Quick Actions Dropdown
        const actionsBtn = document.getElementById('quickActionsBtn');
        const actionsMenu = document.getElementById('quickActionsMenu');

        if (actionsBtn && actionsMenu) {
            actionsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                actionsMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function() {
                actionsMenu.classList.add('hidden');
            });

            actionsMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>
