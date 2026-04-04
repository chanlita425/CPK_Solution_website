{{-- resources/views/admin/components/header.blade.php --}}
<header class="bg-white shadow-sm">
    <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center">
            <i class="fas fa-bars text-gray-600 text-xl cursor-pointer" id="sidebarToggle"></i>
            <h2 class="text-xl font-semibold text-gray-800 ml-4">@yield('header', 'Dashboard')</h2>
        </div>

        <div class="flex items-center space-x-4">
            <div class="relative">
                <button class="flex items-center text-gray-600 hover:text-primary transition-colors" id="langDropdown">
                    <i class="fas fa-globe mr-1"></i>
                    <span>{{ app()->getLocale() == 'km' ? 'ភាសាខ្មែរ' : 'English' }}</span>
                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                </button>
                <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg hidden z-50" id="langMenu">
                    <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 hover:bg-gray-100">English</a>
                    <a href="{{ route('lang.switch', 'km') }}" class="block px-4 py-2 hover:bg-gray-100">ភាសាខ្មែរ</a>
                </div>
            </div>

            <div class="relative">
                <div class="flex items-center space-x-3 cursor-pointer" id="adminDropdown">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: #D7B259;">
                        <i class="fas fa-user text-gray-800"></i>
                    </div>
                    <span class="text-gray-700">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                </div>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden z-50" id="adminMenu">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <hr class="my-1">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.admin-sidebar').classList.toggle('collapsed');
    });

    document.getElementById('langDropdown')?.addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('langMenu').classList.toggle('hidden');
    });

    document.getElementById('adminDropdown')?.addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('adminMenu').classList.toggle('hidden');
    });

    document.addEventListener('click', function() {
        document.getElementById('langMenu')?.classList.add('hidden');
        document.getElementById('adminMenu')?.classList.add('hidden');
    });
</script>
@endpush
