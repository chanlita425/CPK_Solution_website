{{-- resources/views/admin/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - CPK</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .login-card {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-login {
            background-color: #D7B259;
            color: #28282A;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        .btn-login:hover {
            background-color: #c4a145;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Input field wrapper */
        .input-wrapper {
            position: relative;
            width: 100%;
        }

        /* Input field styles */
        .input-field {
            transition: all 0.2s ease;
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            outline: none;
            font-size: 1rem;
            background-color: white;
        }

        /* Password input with eye icon */
        .input-field.password-input {
            padding-right: 2.75rem;
        }

        .input-field:focus {
            border-color: #D7B259;
            box-shadow: 0 0 0 3px rgba(215, 178, 89, 0.1);
        }

        /* Error state styles */
        .input-field.error {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .input-field.error:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        /* Error message styles - under the input */
        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .error-message i {
            font-size: 0.75rem;
        }

        /* Eye icon button */
        .eye-button {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            width: 1.5rem;
            height: 1.5rem;
        }

        .eye-button:hover {
            color: #D7B259;
        }

        /* Shake animation for error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.3s ease-in-out;
        }

        /* Field group spacing */
        .field-group {
            margin-bottom: 1.5rem;
        }

        .field-group:last-of-type {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        label i {
            margin-right: 0.5rem;
            color: #D7B259;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="login-card bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <!-- Logo/Brand Section -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: rgba(215, 178, 89, 0.1);">
                    <i class="fas fa-store text-3xl" style="color: #D7B259;"></i>
                </div>
                <h1 class="text-3xl font-bold" style="color: #D7B259;">CPK Admin</h1>
                <p class="text-gray-500 text-sm mt-2">Login to access your dashboard</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                @csrf

                <!-- Email Field -->
                <div class="field-group">
                    <label>
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <div class="input-wrapper">
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="input-field @error('email') error @enderror"
                               placeholder="admin@example.com"
                               autocomplete="off"
                               autofocus>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="field-group">
                    <label>
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input type="password"
                               name="password"
                               id="password"
                               class="input-field password-input @error('password') error @enderror"
                               placeholder="Enter your password"
                               autocomplete="off">
                        <button type="button" id="togglePassword" class="eye-button">
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

                <!-- Login Button -->
                <button type="submit"
                        id="loginButton"
                        class="btn-login w-full py-3 rounded-lg transition-all flex items-center justify-center gap-2 text-base font-semibold">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </button>
            </form>

            <!-- Footer Note -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-shield-alt"></i>
                    Secure admin access only
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
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
                // Add loading state
                loginButton.classList.add('loading');
                loginButton.disabled = true;
                loginButton.innerHTML = `
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Logging in...</span>
                `;
            });
        }

        // Remove error styling when user starts typing
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                this.classList.remove('error', 'shake');
                const errorDiv = this.closest('.field-group').querySelector('.error-message');
                if (errorDiv && !this.classList.contains('error')) {
                    errorDiv.remove();
                }
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                this.classList.remove('error', 'shake');
                const errorDiv = this.closest('.field-group').querySelector('.error-message');
                if (errorDiv && !this.classList.contains('error')) {
                    errorDiv.remove();
                }
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
