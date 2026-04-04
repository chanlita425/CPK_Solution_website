{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - CPK Admin</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .btn-admin-primary {
            background-color: #D7B259;
            color: #28282A;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-admin-primary:hover {
            background-color: #c4a145;
            transform: translateY(-1px);
        }

        .btn-admin-secondary {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-admin-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-admin-danger {
            background-color: #dc2626;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-admin-danger:hover {
            background-color: #b91c1c;
        }

        .admin-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .admin-form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .admin-form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .admin-form-input:focus {
            outline: none;
            border-color: #D7B259;
            box-shadow: 0 0 0 2px rgba(215, 178, 89, 0.1);
        }

        .admin-table {
            min-width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            padding: 0.75rem 1rem;
            background-color: #f9fafb;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            border-bottom: 1px solid #e5e7eb;
        }

        .admin-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .admin-alert-success {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .admin-alert-error {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Navbar color */
        .bg-navbar {
            background-color: #28282A;
        }

        /* Primary color */
        .text-primary {
            color: #D7B259;
        }

        .bg-primary {
            background-color: #D7B259;
        }

        .border-primary {
            border-color: #D7B259;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        @include('admin.components.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.components.header')

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="admin-alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="admin-alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            @include('admin.components.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
