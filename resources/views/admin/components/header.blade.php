{{-- resources/views/admin/components/header.blade.php --}}
<header class="bg-white shadow-sm z-10">
    <div class="flex justify-between items-center px-4 md:px-6 py-3 md:py-4">
        <div class="flex items-center space-x-3">
            <i class="fas fa-bars text-gray-600 text-xl cursor-pointer hover:text-primary transition-colors"
                id="sidebarToggle"></i>
            <h2 class="text-lg md:text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
        </div>

        <div class="flex items-center space-x-3 md:space-x-4">
            <!-- Admin Dropdown -->
            <div class="relative">
                <div class="flex items-center space-x-2 md:space-x-3 cursor-pointer hover:bg-gray-50 rounded-lg px-2 py-1 transition-colors"
                    id="adminDropdown">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-sm"
                        style="background-color: #D7B259;">
                        <i class="fas fa-user text-gray-800 text-sm"></i>
                    </div>
                    <span class="text-gray-700 text-sm hidden sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-500 hidden sm:inline"></i>
                </div>
                <div class="user-dropdown-menu" id="userDropdownMenu">
                    <!-- FIXED: Changed from admin.pages.profile.index to admin.profile.index -->
                    <a href="{{ route('admin.profile.index') }}" class="dropdown-item">
                        <i class="fas fa-user-circle mr-2"></i> My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.getElementById('adminDropdown')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.getElementById('userDropdownMenu');
        menu.classList.toggle('show');
    });

    document.addEventListener('click', function() {
        const menu = document.getElementById('userDropdownMenu');
        if (menu) menu.classList.remove('show');
    });
</script>
