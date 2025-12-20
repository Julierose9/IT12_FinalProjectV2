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
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .brand-logo {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
        .brand-text {
            flex: 1;
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
            margin-bottom: 10px;
        }
        .btn-login:hover {
            background: #7a7bf0;
        }
        .btn-forgot {
            background: transparent;
            border: none;
            color: #8D8EF6;
            font-size: 0.9rem;
            padding: 0;
            margin-top: 8px;
            text-align: center;
            width: 100%;
            display: block;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-forgot:hover {
            text-decoration: underline;
            color: #7a7bf0;
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
                gap: 20px;
            }
            .brand-title {
                font-size: 2rem;
            }
            .brand-subtitle {
                font-size: 1.1rem;
            }
            .brand-logo {
                width: 140px;
                height: 140px;
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
                flex-direction: column;
                gap: 20px;
            }
            .brand-text {
                text-align: center;
            }
            .login-card {
                margin: 0 auto;
            }
            .brand-title {
                font-size: 2.2rem;
            }
            .brand-logo {
                width: 160px;
                height: 160px;
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
            .brand-logo {
                width: 120px;
                height: 120px;
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
        
        /* Modal Styles */
        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1), 0 8px 16px rgba(0, 0, 0, .1);
            font-family: 'Poppins', sans-serif;
        }
        
        .modal-header {
            background: #f8f8ff;
            border-bottom: 1px solid #dddfe2;
            border-radius: 8px 8px 0 0;
            padding: 20px;
        }
        
        .modal-title {
            color: #3b3183;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .modal-title i {
            color: #8D8EF6;
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .modal-footer {
            border-top: 1px solid #dddfe2;
            padding: 15px 25px;
            background: #f8f8ff;
            border-radius: 0 0 8px 8px;
        }
        
        .modal-subtitle {
            color: #5b5f72;
            font-size: 0.95rem;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .btn-modal-primary {
            background: #8D8EF6;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-modal-primary:hover {
            background: #7a7bf0;
        }
        
        .btn-modal-secondary {
            background: #f5f6f7;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            color: #5b5f72;
            transition: all 0.3s ease;
        }
        
        .btn-modal-secondary:hover {
            background: #e9ecef;
        }
        
        .modal-alert {
            animation: fadeIn 0.8s ease-in-out;
            background-color: #E6E6FF;
            color: #4B50A3;
            border: 1px solid #8D8EF6;
            font-weight: 500;
            border-radius: 6px;
            font-size: 0.9rem;
            padding: 12px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
        }
        
        .modal-alert.danger {
            background-color: #ffe6e6;
            color: #a34b4b;
            border: 1px solid #f68d8d;
        }
        
        .modal-alert i {
            font-size: 1.1rem;
        }
        
        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .btn[disabled] {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        /* Two-step modal styles */
        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        
        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .step-circle.active {
            background: #8D8EF6;
            color: white;
        }
        
        .step-circle.completed {
            background: #28a745;
            color: white;
        }
        
        .step-label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .step-line {
            width: 40px;
            height: 2px;
            background: #e9ecef;
            margin-top: -15px;
        }
        
        .step-content {
            display: none;
        }
        
        .step-content.active {
            display: block;
        }
        
        .verified-email-badge {
            background: #E6E6FF;
            border: 1px solid #8D8EF6;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .verified-email-badge i {
            color: #4B50A3;
        }
        
        .verified-email-badge span {
            color: #4B50A3;
            font-weight: 500;
        }
        
        .password-strength {
            margin-top: 5px;
            font-size: 0.85rem;
        }
        
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
        
        .password-match {
            margin-top: 5px;
            font-size: 0.85rem;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .form-control.is-valid {
            border-color: #28a745;
        }
        
        .back-btn {
            background: none;
            border: none;
            color: #8D8EF6;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
        }
        
        .back-btn:hover {
            color: #7a7bf0;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="brand-section">
                        <img src="{{ asset('images/logo1.png') }}" alt="Dora's Oshoppe Logo" class="brand-logo">
                        <div class="brand-text">
                            <h1 class="brand-title">DORA'S OSHOPPE GIFT SHOP</h1>
                            <p class="brand-subtitle">your one stop gift shop.</p>
                        </div>
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
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autofocus
                                       placeholder="Email">
                                @error('email')
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
                                
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                @error('email')
                                    @if($message === 'The provided credentials are incorrect.' || $message === 'These credentials do not match our records.')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                @enderror
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-login" id="loginBtn">Log in</button>

                            <!-- Forgot Password Button (Triggers Modal) -->
                            <button type="button" class="btn-forgot" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
                                Forgot Password?
                            </button>

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

    <!-- Password Reset Modal (Two-Step) -->
    <div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordResetModalLabel">
                        <i ></i> Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step">
                            <div class="step-circle active" id="step1Circle">1</div>
                            <div class="step-label">Verify Email</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-circle" id="step2Circle">2</div>
                            <div class="step-label">New Password</div>
                        </div>
                    </div>
                    
                    <!-- Alert Message -->
                    <div id="modalAlert" class="modal-alert"></div>
                    
                    <!-- Step 1: Email Verification -->
                    <div id="step1" class="step-content active">
                        <p class="modal-subtitle">
                            Enter your email address to verify your account.
                        </p>
                        
                        <form id="verifyEmailForm">
                            @csrf
                            
                            <div class="form-group">
                                <label for="resetEmail" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <input type="email" 
                                           class="form-control" 
                                           id="resetEmail" 
                                           name="email" 
                                           placeholder="Enter your email address" 
                                           required>
                                </div>
                                <div id="emailError" class="text-danger" style="display: none;"></div>
                            </div>
                            
                            <button type="submit" class="btn-modal-primary" id="verifyBtn">
                                <i class="fas fa-check-circle me-2"></i> Verify Email
                            </button>
                        </form>
                    </div>
                    
                    <!-- Step 2: Password Reset -->
                    <div id="step2" class="step-content">
                        <button type="button" class="back-btn" id="backToStep1">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        
                        <div class="verified-email-badge" id="verifiedEmailBadge">
                            <i class="fas fa-check-circle"></i>
                            <span id="verifiedEmailText"></span>
                        </div>
                        
                        <p class="modal-subtitle">
                            Enter your new password below.
                        </p>
                        
                        <form id="resetPasswordForm">
                            @csrf
                            
                            <div class="form-group">
                                <label for="newPassword" class="form-label">New Password</label>
                                <div class="password-toggle">
                                    <input type="password" 
                                           class="form-control" 
                                           id="newPassword" 
                                           name="password" 
                                           placeholder="Enter new password" 
                                           required 
                                           minlength="6">
                                    <button type="button" class="toggle-icon" onclick="togglePassword('newPassword', this)">👁</button>
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <div class="password-toggle">
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirmPassword" 
                                           name="password_confirmation" 
                                           placeholder="Confirm new password" 
                                           required 
                                           minlength="6">
                                    <button type="button" class="toggle-icon" onclick="togglePassword('confirmPassword', this)">👁</button>
                                </div>
                                <div class="password-match" id="passwordMatch"></div>
                            </div>
                            
                            <button type="submit" class="btn-modal-primary" id="resetBtn">
                                <i class="fas fa-sync-alt me-2"></i> Reset Password
                            </button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Contact administrator if you need further assistance.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        // Password toggle function
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
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginBtn');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...';
            button.disabled = true;
        });

        // Password Reset Modal Logic
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('passwordResetModal');
            const verifyEmailForm = document.getElementById('verifyEmailForm');
            const resetPasswordForm = document.getElementById('resetPasswordForm');
            const modalAlert = document.getElementById('modalAlert');
            const backToStep1Btn = document.getElementById('backToStep1');
            const verifiedEmailText = document.getElementById('verifiedEmailText');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step1Circle = document.getElementById('step1Circle');
            const step2Circle = document.getElementById('step2Circle');
            
            let verifiedEmail = '';
            
            // Reset modal when opened
            modal.addEventListener('show.bs.modal', function () {
                resetModal();
            });
            
            // Step 1: Email Verification
            verifyEmailForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Reset alert
                modalAlert.style.display = 'none';
                
                // Show loading state
                const verifyBtn = document.getElementById('verifyBtn');
                const originalContent = verifyBtn.innerHTML;
                verifyBtn.innerHTML = '<span class="loading-spinner"></span> Verifying...';
                verifyBtn.disabled = true;
                
                // Get form data
                const formData = new FormData(this);
                const email = formData.get('email');
                
                // Validate email
                if (!isValidEmail(email)) {
                    showModalAlert('Please enter a valid email address.', 'danger');
                    resetButton(verifyBtn, originalContent);
                    return;
                }
                
                // Submit via AJAX
                fetch('{{ route("password.email") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Store verified email
                        verifiedEmail = email;
                        verifiedEmailText.textContent = email;
                        
                        // Show success message
                        showModalAlert(data.message, 'success');
                        
                        // Move to step 2
                        setTimeout(() => {
                            goToStep2();
                        }, 1000);
                    } else {
                        showModalAlert(data.message || 'Email verification failed.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModalAlert('An error occurred. Please try again.', 'danger');
                })
                .finally(() => {
                    resetButton(verifyBtn, originalContent);
                });
            });
            
            // Step 2: Password Reset
            resetPasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate passwords
                const password = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                
                if (password.length < 6) {
                    showModalAlert('Password must be at least 6 characters long.', 'danger');
                    return;
                }
                
                if (password !== confirmPassword) {
                    showModalAlert('Passwords do not match.', 'danger');
                    return;
                }
                
                // Show loading state
                const resetBtn = document.getElementById('resetBtn');
                const originalContent = resetBtn.innerHTML;
                resetBtn.innerHTML = '<span class="loading-spinner"></span> Resetting...';
                resetBtn.disabled = true;
                
                // Prepare form data
                const formData = new FormData(this);
                formData.append('email', verifiedEmail);
                
                // Submit via AJAX
                fetch('{{ route("password.reset") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showModalAlert(data.message, 'success');
                        
                        // Clear forms
                        verifyEmailForm.reset();
                        resetPasswordForm.reset();
                        
                        // Close modal and redirect after 2 seconds
                        setTimeout(() => {
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            modalInstance.hide();
                            
                            // Redirect to login page if needed
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            }
                        }, 2000);
                    } else {
                        showModalAlert(data.message || 'Password reset failed.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModalAlert('An error occurred. Please try again.', 'danger');
                })
                .finally(() => {
                    resetButton(resetBtn, originalContent);
                });
            });
            
            // Back button
            backToStep1Btn.addEventListener('click', function() {
                goToStep1();
            });
            
            // Password strength checker
            const passwordInput = document.getElementById('newPassword');
            const confirmInput = document.getElementById('confirmPassword');
            const strengthDisplay = document.getElementById('passwordStrength');
            const matchDisplay = document.getElementById('passwordMatch');
            
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
                
                // Update match display
                checkPasswordMatch();
            });
            
            // Password match checker
            function checkPasswordMatch() {
                if (passwordInput.value && confirmInput.value) {
                    if (passwordInput.value === confirmInput.value) {
                        matchDisplay.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Passwords match';
                        matchDisplay.className = 'password-match text-success';
                        confirmInput.classList.remove('is-invalid');
                        confirmInput.classList.add('is-valid');
                        return true;
                    } else {
                        matchDisplay.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i> Passwords do not match';
                        matchDisplay.className = 'password-match text-danger';
                        confirmInput.classList.remove('is-valid');
                        confirmInput.classList.add('is-invalid');
                        return false;
                    }
                } else {
                    matchDisplay.textContent = '';
                    confirmInput.classList.remove('is-valid', 'is-invalid');
                    return false;
                }
            }
            
            confirmInput.addEventListener('input', checkPasswordMatch);
            
            // Helper functions
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            function showModalAlert(message, type = 'success') {
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                
                modalAlert.innerHTML = `
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                `;
                modalAlert.className = `modal-alert ${type === 'danger' ? 'danger' : ''}`;
                modalAlert.style.display = 'flex';
                
                // Auto-hide success messages after 5 seconds
                if (type === 'success') {
                    setTimeout(() => {
                        modalAlert.style.display = 'none';
                    }, 5000);
                }
            }
            
            function resetButton(button, originalContent) {
                button.innerHTML = originalContent;
                button.disabled = false;
            }
            
            function goToStep2() {
                step1.classList.remove('active');
                step2.classList.add('active');
                step1Circle.classList.remove('active');
                step1Circle.classList.add('completed');
                step2Circle.classList.add('active');
                modalAlert.style.display = 'none';
            }
            
            function goToStep1() {
                step2.classList.remove('active');
                step1.classList.add('active');
                step2Circle.classList.remove('active');
                step1Circle.classList.add('active');
                step1Circle.classList.remove('completed');
                modalAlert.style.display = 'none';
            }
            
            function resetModal() {
                goToStep1();
                verifyEmailForm.reset();
                resetPasswordForm.reset();
                modalAlert.style.display = 'none';
                verifiedEmail = '';
                verifiedEmailText.textContent = '';
                strengthDisplay.textContent = '';
                matchDisplay.textContent = '';
                document.getElementById('resetEmail').classList.remove('is-invalid', 'is-valid');
                document.getElementById('newPassword').classList.remove('is-invalid', 'is-valid');
                document.getElementById('confirmPassword').classList.remove('is-invalid', 'is-valid');
            }
        });
    </script>
</body>
</html>