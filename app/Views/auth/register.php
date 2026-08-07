<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="split-login-container">
    <div class="split-login-card">
        <!-- Left Side - System Information -->
        <div class="system-info-section">
            <div class="system-info-content">
                <div class="login-header">
                    <i class="fas fa-heartbeat fa-3x text-white mb-3"></i>
                    <h2 class="text-white mb-1">PWD Management</h2>
                    <p class="text-white-50 mb-0">Record Management System</p>
                </div>

                <h3 class="text-white mb-4">Admin Registration</h3>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Secure Registration</h5>
                            <p>All new admin accounts require proper authentication and verification.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Verified Access</h5>
                            <p>Only authenticated users can register new administrators for security.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Full System Access</h5>
                            <p>New admins will have complete access to all system features and modules.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Activity Tracking</h5>
                            <p>All admin activities are logged and monitored for security purposes.</p>
                        </div>
                    </div>
                </div>
                
                <div class="system-stats mt-5">
                    <div class="stat-item">
                        <h4 class="text-white">100%</h4>
                        <p class="text-white-50">Secure</p>
                    </div>
                    <div class="stat-item">
                        <h4 class="text-white">24/7</h4>
                        <p class="text-white-50">Monitoring</p>
                    </div>
                    <div class="stat-item">
                        <h4 class="text-white">Role-Based</h4>
                        <p class="text-white-50">Access Control</p>
                    </div>
                </div>
                
                <div class="contact-info mt-4 pt-4 border-top border-white-20">
                    <p class="text-white-50 mb-1">
                        <i class="fas fa-phone me-2"></i>Contact: 09518874506
                    </p>
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-envelope me-2"></i>Email: aljunmar08@gmail.com
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="login-section">
            <div class="login-header" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="<?= base_url('/auth/login') ?>" class="btn btn-light btn-sm me-3 position-absolute" style="left: 20px;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="text-white mb-1">Register New Admin</h2>
                        <p class="text-white-50 mb-0">Create administrator account</p>
                    </div>
                </div>
            </div>

            <div class="login-form">
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

                <div class="alert alert-info alert-custom">
                    <i class="fas fa-info-circle me-2"></i>
                    Fill in all required information to register a new administrator account.
                </div>

                <form action="<?= base_url('/auth/process-register') ?>" method="post" id="registerForm">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-12">
                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="full_name" class="form-label">
                                    <i class="fas fa-user me-1 text-primary"></i>Full Name
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-custom border-start-0 <?= session()->getFlashdata('errors') && array_key_exists('full_name', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                           id="full_name" 
                                           name="full_name" 
                                           value="<?= old('full_name') ?>" 
                                           placeholder="Enter full name"
                                           required>
                                </div>
                                <?php if (session()->getFlashdata('errors') && array_key_exists('full_name', session()->getFlashdata('errors'))): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['full_name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-at me-1 text-primary"></i>Username
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-at text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-custom border-start-0 <?= session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                           id="username" 
                                           name="username" 
                                           value="<?= old('username') ?>" 
                                           placeholder="Choose username"
                                           required>
                                </div>
                                <?php if (session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors'))): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['username'] ?>
                                    </div>
                                <?php endif; ?>
                                <small class="form-text text-muted">Must be unique, 3-50 characters</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1 text-primary"></i>Email
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control form-control-custom border-start-0 <?= session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                           id="email" 
                                           name="email" 
                                           value="<?= old('email') ?>" 
                                           placeholder="Enter email"
                                           required>
                                </div>
                                <?php if (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Password -->
                            <div class="mb-3">
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
                                           placeholder="Enter password"
                                           required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleRegisterPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors'))): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['password'] ?>
                                    </div>
                                <?php endif; ?>
                                <small class="form-text text-muted">Minimum 6 characters</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-key me-1 text-primary"></i>Confirm Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control form-control-custom border-start-0 <?= session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           placeholder="Confirm password"
                                           required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['confirm_password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Register Admin
                        </button>
                        <a href="<?= base_url('/auth/login') ?>" class="btn btn-outline-primary-custom btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('toggleRegisterPassword').addEventListener('click', function() {
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

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('confirm_password');
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

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match. Please confirm your password.');
            document.getElementById('confirm_password').focus();
            return false;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Registering...';
    });

    // Focus on first field
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('full_name').focus();
    });

    // Real-time password match indicator
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const feedback = this.parentNode.nextElementSibling;

        if (confirmPassword && password !== confirmPassword) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else if (confirmPassword && password === confirmPassword) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-invalid', 'is-valid');
        }
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
        max-width: 1000px;
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
        padding: 2rem;
        text-align: center;
        position: relative;
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
        margin-top: 2rem;
    }

    .stat-item {
        flex: 1;
    }

    .stat-item h4 {
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
    }

    .stat-item p {
        font-size: 0.8rem;
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

    .btn-outline-secondary {
        border-color: #e2e8f0;
        background-color: #f8fafc;
    }

    .btn-outline-secondary:hover {
        background-color: #e2e8f0;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border: none;
        color: white;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-primary-custom {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-primary-custom:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .alert-custom {
        border-radius: 10px;
        border: none;
        padding: 12px 16px;
    }

    .form-text {
        font-size: 0.8rem;
        margin-top: 4px;
    }

    .is-valid {
        border-color: #198754 !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .split-login-card {
            flex-direction: column-reverse;
            max-width: 400px;
        }
        
        .system-stats {
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .login-header .position-absolute {
            position: relative !important;
            left: 0 !important;
            margin-bottom: 1rem;
        }
    }
</style>
<?= $this->endSection() ?>