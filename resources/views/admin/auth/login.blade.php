{{-- resources/views/admin/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('cpk_favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('cpk_favicon.png') }}">

    <title>Admin Login - CPK</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f5f5f7;
        }

        .login-card {
            animation: slideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input group styling */
        .input-group {
            position: relative;
            margin-bottom: 0;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
            transition: color 0.2s ease;
            pointer-events: none;
            z-index: 1;
        }

        .input-field {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            outline: none;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background-color: white;
        }

        .input-field.password-input {
            padding-right: 2.75rem;
        }

        .input-field:focus {
            border-color: #D7B259;
            box-shadow: 0 0 0 3px rgba(215, 178, 89, 0.1);
        }

        .input-field.error {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .input-field.error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Password toggle button */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            transition: color 0.2s ease;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .password-toggle:hover {
            color: #D7B259;
        }

        /* Error message */
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .error-message i {
            font-size: 0.6875rem;
        }

        /* Login button */
        .btn-login {
            background: #D7B259;
            color: #1e293b;
            font-weight: 600;
            padding: 0.875rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #c4a145;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(215, 178, 89, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login.loading {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Remember me checkbox */
        .checkbox-custom {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            border: 1.5px solid #cbd5e1;
            cursor: pointer;
            accent-color: #D7B259;
        }

        /* Logo container */
        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .logo-image {
            max-width: 200px;
            max-height: 80px;
            width: auto;
            height: auto;
            object-fit: contain;
            margin-bottom: 1.5rem;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: rgba(215, 178, 89, 0.1);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .logo-placeholder i {
            font-size: 2.5rem;
            color: #D7B259;
        }

        /* Welcome text */
        .welcome-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            text-align: center;
            margin: 0;
        }

        /* Shake animation */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            75% {
                transform: translateX(6px);
            }
        }

        .shake {
            animation: shake 0.3s ease-in-out;
        }

        /* Label styling */
        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        /* Form group spacing */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group:last-of-type {
            margin-bottom: 0;
        }

        /* Remember me row */
        .remember-row {
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4" style="background: #f5f5f7;">
    <div class="login-card w-full max-w-md">
        <!-- Main Card with enhanced box shadow -->
        <div class="bg-white rounded-2xl p-8"">
            <!-- Logo Section -->
            <div class="logo-wrapper">
                @php
                    $settings = App\Models\Setting::getSettings();
                    $companyLogo = $settings->company_logo ?? null;
                @endphp

                @if ($companyLogo && Storage::disk('public')->exists($companyLogo))
                    <img src="{{ asset('storage/' . $companyLogo) }}"
                        alt="{{ $settings->company_name ?? 'Company Logo' }}" class="logo-image">
                @elseif(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo-image">
                @else
                    <div class="logo-placeholder">
                        <i class="fas fa-store"></i>
                    </div>
                @endif

                <h1 class="welcome-title">Welcome Back</h1>
                <p class="welcome-subtitle">Sign in to your administrator account</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="input-field @error('email') error @enderror" placeholder="admin@example.com"
                            autocomplete="off" autofocus>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                            class="input-field password-input @error('password') error @enderror"
                            placeholder="Enter your password" autocomplete="off">
                        <button type="button" id="togglePassword" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-row">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="checkbox-custom">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" id="loginButton" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                </button>
            </form>

            <!-- Security Note -->
            <div class="mt-6 pt-5 border-t border-gray-100">
                <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure admin access only</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }

        // Form submission with loading state
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                loginButton.classList.add('loading');
                loginButton.disabled = true;
                loginButton.innerHTML = `
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Signing in...</span>
                `;
            });
        }

        // Remove error styling when user starts typing
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                this.classList.remove('error', 'shake');
                const errorDiv = this.closest('.form-group')?.querySelector('.error-message');
                if (errorDiv) errorDiv.remove();
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                this.classList.remove('error', 'shake');
                const errorDiv = this.closest('.form-group')?.querySelector('.error-message');
                if (errorDiv) errorDiv.remove();
            });
        }

        // Add shake animation to inputs with errors
        const errorInputs = document.querySelectorAll('.input-field.error');
        errorInputs.forEach(input => {
            input.classList.add('shake');
            setTimeout(() => {
                input.classList.remove('shake');
            }, 500);
        });

        // Auto-focus on first error field or email field
        const firstError = document.querySelector('.input-field.error');
        if (firstError) {
            firstError.focus();
        } else if (emailInput) {
            emailInput.focus();
        }
    </script>
</body>

</html>
