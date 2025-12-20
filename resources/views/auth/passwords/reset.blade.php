<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Dora's Oshoppe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .reset-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 120px;
            height: auto;
        }
        .form-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }
        .form-subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 500;
            width: 100%;
            margin-top: 10px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .back-to-login {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .back-to-login a {
            color: #667eea;
            text-decoration: none;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .password-strength {
            margin-top: 5px;
            font-size: 0.85rem;
        }
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
    </style>
</head>
<body>
    <div class="reset-card">
        <div class="logo">
            <img src="{{ asset('images/logo_.png') }}" alt="Dora's Oshoppe Logo">
        </div>
        
        <h3 class="form-title">Reset Your Password</h3>
        <p class="form-subtitle">Enter your new password below</p>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autofocus>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Enter new password" 
                           required>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <div class="password-strength" id="passwordStrength"></div>
            </div>
            
            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" 
                           class="form-control" 
                           id="password-confirm" 
                           name="password_confirmation" 
                           placeholder="Confirm new password" 
                           required>
                </div>
                <div class="password-match mt-1" id="passwordMatch"></div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sync-alt me-2"></i> Reset Password
            </button>
        </form>
        
        <div class="back-to-login">
            <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password-confirm');
            const strengthDisplay = document.getElementById('passwordStrength');
            const matchDisplay = document.getElementById('passwordMatch');
            
            // Password strength checker
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 'Weak';
                let strengthClass = 'strength-weak';
                
                if (password.length >= 8) {
                    const hasUpperCase = /[A-Z]/.test(password);
                    const hasLowerCase = /[a-z]/.test(password);
                    const hasNumbers = /\d/.test(password);
                    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
                    
                    let score = 0;
                    if (hasUpperCase) score++;
                    if (hasLowerCase) score++;
                    if (hasNumbers) score++;
                    if (hasSpecial) score++;
                    
                    if (score >= 3 && password.length >= 10) {
                        strength = 'Strong';
                        strengthClass = 'strength-strong';
                    } else if (score >= 2) {
                        strength = 'Medium';
                        strengthClass = 'strength-medium';
                    }
                }
                
                strengthDisplay.textContent = `Password strength: ${strength}`;
                strengthDisplay.className = `password-strength ${strengthClass}`;
            });
            
            // Password match checker
            function checkPasswordMatch() {
                if (passwordInput.value && confirmInput.value) {
                    if (passwordInput.value === confirmInput.value) {
                        matchDisplay.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Passwords match';
                        matchDisplay.className = 'password-match text-success';
                    } else {
                        matchDisplay.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i> Passwords do not match';
                        matchDisplay.className = 'password-match text-danger';
                    }
                } else {
                    matchDisplay.textContent = '';
                }
            }
            
            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmInput.addEventListener('input', checkPasswordMatch);
        });
    </script>
</body>
</html>