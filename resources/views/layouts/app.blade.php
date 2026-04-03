<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ecommerce</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @include('components.header')
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4">
        @include('components.categories')
        @include('components.brands')
    </div>

    <main>
        @yield('content')
    </main>

    @include('components.footer')

</body>
</html>