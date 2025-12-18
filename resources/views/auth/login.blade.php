<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Dora's Oshopee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8ff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 980px;
            margin: 0 auto;
        }
        .row {
            align-items: center;
            min-height: 70vh;
        }
        .brand-section {
            padding-right: 60px;
        }
        
        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3b3183;
            margin-bottom: 5px;
            line-height: 1.1;
        }
        .brand-subtitle {
            font-size: 1.2rem;
            color: #5b5f72;
            font-weight: 400;
        }
        .login-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1), 0 8px 16px rgba(0, 0, 0, .1);
            padding: 20px;
            max-width: 400px;
            margin-left: auto;
        }
        .login-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-control {
            border: 1px solid #dddfe2;
            border-radius: 6px;
            padding: 14px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f5f6f7;
        }
        .form-control:focus {
            border-color: #8D8EF6;
            box-shadow: 0 0 0 2px rgba(141, 142, 246, 0.2);
            background: white;
        }
        .form-label {
            font-weight: 500;
            color: #5b5f72;
            margin-bottom: 8px;
            display: block;
            text-align: left;
            font-size: 0.9rem;
        }
        .btn-login {
            background: #8D8EF6;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 15px;
        }
        .btn-login:hover {
            background: #7a7bf0;
        }
        .password-toggle {
            position: relative;
        }
        .toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            background: none;
            border: none;
            font-size: 1.1rem;
        }
        .form-check-input:checked {
            background-color: #8D8EF6;
            border-color: #8D8EF6;
        }
        .form-check-label {
            color: #5b5f72;
            font-size: 0.9rem;
        }
        .divider {
            border-bottom: 1px solid #dadde1;
            margin: 20px 0;
        }
        .create-account {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #dadde1;
        }
        .create-account-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .brand-section {
                padding-right: 30px;
            }
            .brand-title {
                font-size: 2rem;
            }
            .brand-subtitle {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 768px) {
            .row {
                text-align: center;
            }
            .brand-section {
                padding-right: 0;
                margin-bottom: 40px;
                text-align: center;
            }
            .login-card {
                margin: 0 auto;
            }
            .brand-title {
                font-size: 2.2rem;
            }
        }
        
        @media (max-width: 576px) {
            .login-wrapper {
                padding: 10px;
            }
            .brand-title {
                font-size: 1.8rem;
            }
            .brand-subtitle {
                font-size: 1rem;
            }
            .login-card {
                padding: 15px;
            }
        }
        
        /* Animation for alerts */
        .alert-success {
            animation: fadeIn 0.8s ease-in-out;
            background-color: #E6E6FF;
            color: #4B50A3;
            border: 1px solid #8D8EF6;
            font-weight: 500;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .text-danger {
            font-size: 0.875rem;
            text-align: left;
            margin-top: 5px;
            color: #e05252;
        }
        
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="brand-section">
                        <h1 class="brand-title">DORA'S OSHOPPE GIFT SHOP</h1>
                        <p class="brand-subtitle">your one stop gift shop.</p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="login-card">
                        <div class="login-header">
                            <h2 class="login-title">Log In</h2>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autofocus
                                       placeholder="Email">
                                @error('email')
                                    <!-- Specific email errors (e.g., invalid format, not found) -->
                                    @if($message !== 'These credentials do not match our records.' && $message !== 'The provided credentials are incorrect.')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group password-toggle">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required placeholder="Password">
                                <button type="button" class="toggle-icon" onclick="togglePassword('password', this)">👁</button>
                                
                                <!-- Specific password errors + General credential error moved here -->
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- General "The provided credentials are incorrect." error (usually under 'email') -->
                                @error('email')
                                    @if($message === 'The provided credentials are incorrect.' || $message === 'These credentials do not match our records.')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                @enderror
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-login">Log in</button>

                            <div class="divider"></div>

                            <!-- Remember Me Checkbox -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, button) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                button.textContent = "👁";
            } else {
                input.type = "password";
                button.textContent = "👁";
            }
        }

        // Auto-hide success message after 4 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 4000);

        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...';
            button.disabled = true;
        });
    </script>
</body>
</html>