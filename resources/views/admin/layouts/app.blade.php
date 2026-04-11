{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('cpk_favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('cpk_favicon.png') }}">

    <title>@yield('title', 'Admin Dashboard') - CPK Solution</title>

    <!-- Vite Assets (Local CSS/JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Local Font Awesome (installed via npm) -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Google Fonts (optional - can be kept as CDN or downloaded locally) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Local Flatpickr CSS & JS (installed via npm) -->
    <link rel="stylesheet" href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}">
    <script src="{{ asset('vendor/flatpickr/dist/flatpickr.js') }}"></script>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-20 right-4 z-50 space-y-3"></div>

    <style>
        /* Ensure pagination doesn't have default ul/li styles */
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav li {
            display: inline-block;
            margin: 0;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        /* Make the wrapper take full height */
        html,
        body {
            height: 100%;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Transitions */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        /* Toast Animations */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-slide-in {
            animation: slideInRight 0.3s ease forwards;
        }

        .toast-slide-out {
            animation: slideOutRight 0.3s ease forwards;
        }

        /* Modal Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-fade-in {
            animation: fadeIn 0.2s ease forwards;
        }

        .modal-scale-in {
            animation: scaleIn 0.2s ease forwards;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            color: #334155;
        }

        .data-table tbody tr:hover {
            background: #fafbff;
        }

        /* Form Styles */
        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #D7B259;
            box-shadow: 0 0 0 3px rgba(215, 178, 89, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-confirmed {
            background: #d1fae5;
            color: #059669;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-active {
            background: #d1fae5;
            color: #059669;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Buttons */
        .btn-primary {
            background: #D7B259;
            color: #1e293b;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #c4a145;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        /* Card Styles */
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 antialiased flex flex-col min-h-screen">

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden transition-opacity duration-300">
    </div>

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content Wrapper - flex column to push footer down -->
    <div id="mainContent" class="lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
        <!-- Header -->
        @include('admin.components.header')

        <!-- Page Content - grows to fill available space -->
        <main class="flex-1 p-4 md:p-6">
            @yield('content')
        </main>

        <!-- Footer - will stick to bottom -->
        @include('admin.components.footer')
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-20 right-4 z-50 space-y-3"></div>

    <!-- Modal Container -->
    <div id="modalContainer"></div>

    <!-- Toast JavaScript -->
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle'
            };

            const colors = {
                success: 'bg-emerald-50 border-emerald-200 text-emerald-800',
                error: 'bg-red-50 border-red-200 text-red-800',
                warning: 'bg-amber-50 border-amber-200 text-amber-800'
            };

            toast.className =
                `toast-slide-in ${colors[type]} border rounded-lg shadow-lg p-4 min-w-[280px] max-w-md flex items-start gap-3`;
            toast.innerHTML = `
                <i class="fas ${icons[type]} text-lg mt-0.5"></i>
                <div class="flex-1 text-sm font-medium">${message}</div>
                <button onclick="this.closest('.toast-slide-in').classList.add('toast-slide-out'); setTimeout(() => this.closest('.toast-slide-in')?.remove(), 300)" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                if (toast && toast.parentNode) {
                    toast.classList.add('toast-slide-out');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }

        // Delete Confirmation Modal
        function confirmDelete(url, itemName = 'this item') {
            const modalContainer = document.getElementById('modalContainer');

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 modal-fade-in';
            modal.style.background = 'rgba(0, 0, 0, 0.5)';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl max-w-md w-full modal-scale-in overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-trash-alt text-red-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Delete Confirmation</h3>
                        </div>
                        <p class="text-gray-600 mb-2">Are you sure you want to delete <strong>${itemName}</strong>?</p>
                        <p class="text-sm text-gray-500 mb-6">This action cannot be undone.</p>
                        <div class="flex gap-3 justify-end">
                            <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button onclick="performDelete('${url}')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            `;

            modalContainer.appendChild(modal);
        }

        function performDelete(url) {
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message || 'Deleted successfully!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(data.message || 'Failed to delete', 'error');
                    }
                    document.querySelector('#modalContainer .fixed')?.remove();
                })
                .catch(() => {
                    showToast('An error occurred', 'error');
                    document.querySelector('#modalContainer .fixed')?.remove();
                });
        }

        // Display toast from session flash data
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('toast'))
                showToast('{{ session('toast.message') }}', '{{ session('toast.type') }}');
            @endif

            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>

    <!-- Include Toast Component -->
    @include('admin.components.toast')
    @stack('scripts')
</body>

</html>
