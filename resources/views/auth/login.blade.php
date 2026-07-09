<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRAS System</title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Security CSS -->
    <link rel="stylesheet" href="{{ asset('css/security.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            z-index: 0;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite ease-in-out;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 10%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out;
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

        .logo-container {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container img {
            width: 120px;
            height: auto;
            margin-bottom: 16px;
            animation: fadeIn 0.8s ease-out;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .logo-container h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .logo-container p {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: white;
            color: #1e293b;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        input[type="email"]:focus ~ .input-icon,
        input[type="password"]:focus ~ .input-icon {
            color: #667eea;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        input[type="checkbox"]:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .checkbox-wrapper label {
            margin-bottom: 0;
            margin-left: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 32px;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .security-badge {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .security-badge p {
            font-size: 13px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .security-badge i {
            color: #10b981;
            font-size: 16px;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        /* Loading State */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-login.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }

            .logo-container h1 {
                font-size: 24px;
            }

            .form-footer {
                flex-direction: column;
                gap: 16px;
            }

            .btn-login {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="login-container">
        <div class="login-card">
            <!-- Logo Section -->
            <div class="logo-container">
                <img src="{{ asset('logo/ChatGPT Image Jul 6, 2026, 03_34_47 PM.png') }}" alt="CRAS Logo">
                <h1>Welcome Back</h1>
                <p>Cybersecurity Risk Assessment System</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email"
                        >
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        >
                        <i class="fas fa-lock input-icon"></i>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Remember me for 30 days</label>
                </div>

                <!-- Submit Button & Forgot Password -->
                <div class="form-footer">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot Password?
                        </a>
                    @endif

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Security Badge -->
            <div class="security-badge">
                <p>
                    <i class="fas fa-shield-halved"></i>
                    <span>Secured with enterprise-grade encryption</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Disable Inspect Element -->
    <script src="{{ asset('js/disable-inspect.js') }}"></script>

    <!-- JavaScript -->
    <script>
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form Submit Loading State
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        loginForm.addEventListener('submit', function() {
            loginBtn.classList.add('loading');
            loginBtn.querySelector('span').textContent = 'Signing In...';
        });

        // Input Animation
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Auto-fill detection
        window.addEventListener('load', function() {
            inputs.forEach(input => {
                if (input.value !== '') {
                    input.parentElement.querySelector('.input-icon').style.color = '#667eea';
                }
            });
        });
    </script>
</body>
</html>
