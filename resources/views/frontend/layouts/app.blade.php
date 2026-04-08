<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CPK Solution')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#fff8e1',
                            100: '#ffecb3',
                            200: '#ffe082',
                            300: '#ffd54f',
                            350: '#D4AF56',
                            400: '#ffca28',
                            500: '#ffc107',
                            600: '#ffb300',
                            700: '#ffa000',
                            800: '#ff8f00',
                            900: '#ff6f00',
                        },
                        dark: {
                            DEFAULT: '#1a1a2e',
                            800: '#16213e',
                            700: '#0f3460',
                        },
                        accent: '#e94560',
                    },
                    fontFamily: {
                        sans: ['"Nunito"', 'sans-serif'],
                        display: ['"Poppins"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'pulse-badge': 'pulseBadge 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        pulseBadge: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.1)' },
                        },
                    },
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- Top Header --}}
    @include('frontend.components.header')
    
    {{-- Main Navbar --}}
    @include('frontend.components.navbar')
    @include('frontend.components.banner')
    @include('frontend.components.categories')
    @include('frontend.components.brands')

    {{-- Page Content --}}
    <main class="animate-fade-in">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.components.footer')

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')
</body>
</html>