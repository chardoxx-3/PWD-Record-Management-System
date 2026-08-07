<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="split-login-container">
    <div class="split-login-card">
        <!-- Left Side - Login Form -->
        <div class="login-section">
            <div class="login-header">
                <i class="fas fa-heartbeat fa-3x text-white mb-3"></i>
                <h2 class="text-white mb-1">PWD Management</h2>
                <p class="text-white-50 mb-0">Record Management System</p>
            </div>

            <div class="login-form">
                <h4 class="text-center mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-lock me-2"></i>Admin Login
                </h4>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/auth/process-login') ?>" method="post" id="loginForm">
                    <?= csrf_field() ?>
                    
                    <!-- Username Field -->
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-1 text-primary"></i>Username
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control form-control-custom border-start-0 <?= session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="username" 
                                   name="username" 
                                   value="<?= old('username') ?>" 
                                   placeholder="Enter your username"
                                   required>
                        </div>
                        <?php if (session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors'))): ?>
                            <div class="invalid-feedback d-block">
                                <?= session()->getFlashdata('errors')['username'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-key me-1 text-primary"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" 
                                   class="form-control form-control-custom border-start-0 <?= session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   required>
                            <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if (session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors'))): ?>
                            <div class="invalid-feedback d-block">
                                <?= session()->getFlashdata('errors')['password'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                    </div>

                    <!-- Register Button -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-primary-custom btn-lg" id="registerBtn">
                            <i class="fas fa-user-plus me-2"></i>Register New Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side - System Information -->
        <div class="system-info-section">
            <div class="system-info-content">
                <h3 class="text-white mb-4">About the System</h3>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-text">
                            <h5>PWD Management</h5>
                            <p>Comprehensive system for managing Persons with Disabilities records and services.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Analytics & Reports</h5>
                            <p>Generate detailed reports and analytics to track program effectiveness.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Secure & Compliant</h5>
                            <p>All data is encrypted and stored securely in compliance with privacy regulations.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Support Services</h5>
                            <p>Track and manage support services, benefits, and assistance programs.</p>
                        </div>
                    </div>
                </div>
                
                <div class="system-stats mt-5">
                    <div class="stat-item">
                        <h4 class="text-white">500+</h4>
                        <p class="text-white-50">Registered PWDs</p>
                    </div>
                    <div class="stat-item">
                        <h4 class="text-white">98%</h4>
                        <p class="text-white-50">Data Accuracy</p>
                    </div>
                    <div class="stat-item">
                        <h4 class="text-white">24/7</h4>
                        <p class="text-white-50">System Availability</p>
                    </div>
                </div>
                
                <div class="contact-info mt-4 pt-4 border-top border-white-20">
                    <p class="text-white-50 mb-1">
                        <i class="fas fa-phone me-2"></i>Contact: 1234567890
                    </p>
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-envelope me-2"></i>Email: admin@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Add loading state to form submission
    document.querySelector('form').addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';
    });

    // Focus on username field on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('username').focus();
    });

    // Register button functionality
    document.getElementById('registerBtn').addEventListener('click', function() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (!username || !password) {
            alert('Please enter your login credentials first to verify your identity.');
            return;
        }

        // Create a hidden form to submit credentials for verification
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('/auth/verify-and-register') ?>';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '<?= csrf_token() ?>';
        csrfToken.value = '<?= csrf_hash() ?>';
        form.appendChild(csrfToken);

        const usernameInput = document.createElement('input');
        usernameInput.type = 'hidden';
        usernameInput.name = 'username';
        usernameInput.value = username;
        form.appendChild(usernameInput);

        const passwordInput = document.createElement('input');
        passwordInput.type = 'hidden';
        passwordInput.name = 'password';
        passwordInput.value = password;
        form.appendChild(passwordInput);

        document.body.appendChild(form);
        form.submit();
    });
</script>

<style>
    .split-login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .split-login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 900px;
        display: flex;
        animation: slideUp 0.5s ease-out;
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

    .login-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .login-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        padding: 2rem;
        text-align: center;
    }

    .login-form {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .system-info-section {
        flex: 1;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-darker, #1a4a8d));
        color: white;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .system-info-content {
        max-width: 100%;
    }

    .feature-list {
        margin-top: 1.5rem;
    }

    .feature-item {
        display: flex;
        margin-bottom: 1.5rem;
        align-items: flex-start;
    }

    .feature-icon {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .feature-icon i {
        font-size: 1.2rem;
        color: white;
    }

    .feature-text h5 {
        color: white;
        margin-bottom: 0.25rem;
    }

    .feature-text p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .system-stats {
        display: flex;
        justify-content: space-between;
        text-align: center;
    }

    .stat-item {
        flex: 1;
    }

    .stat-item h4 {
        margin-bottom: 0.25rem;
    }

    .stat-item p {
        font-size: 0.85rem;
    }

    .contact-info {
        font-size: 0.9rem;
    }

    .border-white-20 {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .input-group-text {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: var(--primary-color);
    }

    #togglePassword {
        border-color: #e2e8f0;
        background-color: #f8fafc;
    }

    #togglePassword:hover {
        background-color: #e2e8f0;
    }

    .btn-outline-primary-custom {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-primary-custom:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .split-login-card {
            flex-direction: column;
            max-width: 400px;
        }
        
        .system-stats {
            flex-direction: column;
            gap: 1.5rem;
        }
    }
</style>
<?= $this->endSection() ?>