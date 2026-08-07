<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-user-cog me-2"></i>Admin Profile
            </h1>
            <p class="text-muted mb-0">Manage your account settings and preferences.</p>
        </div>
        <div>
            <a href="<?= base_url('/dashboard') ?>" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-user-edit me-2"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/update-profile') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom bg-light" 
                                           id="username" value="<?= $user['username'] ?>" readonly>
                                    <small class="text-muted">Username cannot be changed</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                                    <?php if (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors')['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('full_name', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('full_name', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['full_name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Account Status</label>
                                    <div>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Active
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Last Login</label>
                                    <div>
                                        <span class="text-muted">
                                            <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

<!-- Change Password -->
<div class="card card-custom">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0" style="color: var(--primary-color);">
            <i class="fas fa-lock me-2"></i>Change Password
        </h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/admin/update-password') ?>" method="post" id="passwordForm">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="current_password" class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control form-control-custom <?= (session()->getFlashdata('errors') && array_key_exists('current_password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" 
                           id="current_password" name="current_password" required>
                    <button type="button" class="btn  toggle-password" data-target="current_password">
                    </button>
                    <?php if (session()->getFlashdata('errors') && array_key_exists('current_password', session()->getFlashdata('errors'))): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errors')['current_password'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-custom <?= (session()->getFlashdata('errors') && array_key_exists('new_password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" 
                                   id="new_password" name="new_password" required>
                            <button type="button" class="btn toggle-password" data-target="new_password">
                               
                            </button>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('new_password', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['new_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-custom <?= (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" 
                                   id="confirm_password" name="confirm_password" required>
                            <button type="button" class="btn toggle-password" data-target="confirm_password">
                                
                            </button>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['confirm_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-key me-2"></i>Change Password
                </button>
            </div>
        </form>
    </div>
</div>
        </div>

        <!-- Account Summary -->
        <div class="col-lg-4">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-user-shield me-2"></i>Account Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x text-primary"></i>
                        </div>
                        <h4 class="mt-3 mb-1"><?= $user['full_name'] ?></h4>
                        <p class="text-muted">System Administrator</p>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="fw-semibold">Member Since</span>
                            <span class="text-muted"><?= date('M Y', strtotime($user['created_at'])) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="fw-semibold">Last Updated</span>
                            <span class="text-muted"><?= date('M j, Y', strtotime($user['updated_at'])) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="fw-semibold">Account Type</span>
                            <span class="badge bg-primary">Administrator</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-shield-alt me-2"></i>Security Tips
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning alert-custom mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Keep your account secure</strong>
                    </div>
                    
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use a strong, unique password
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Never share your login credentials
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Log out after each session
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Update your password regularly
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Report any suspicious activity
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password validation
        const passwordForm = document.querySelector('form');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');

        if (passwordForm && newPassword && confirmPassword) {
            passwordForm.addEventListener('submit', function(e) {
                if (newPassword.value || confirmPassword.value) {
                    if (newPassword.value.length < 6) {
                        e.preventDefault();
                        alert('New password must be at least 6 characters long.');
                        newPassword.focus();
                        return;
                    }

                    if (newPassword.value !== confirmPassword.value) {
                        e.preventDefault();
                        alert('New password and confirmation password do not match.');
                        confirmPassword.focus();
                        return;
                    }
                }
            });
        }

        // Toggle password visibility
        const togglePassword = (inputId) => {
            const input = document.getElementById(inputId);
            const icon = input.parentNode.querySelector('.toggle-password i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        };

        // Add toggle buttons to password fields
        const passwordFields = ['current_password', 'new_password', 'confirm_password'];
        passwordFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                const wrapper = document.createElement('div');
                wrapper.className = 'input-group';
                
                field.parentNode.insertBefore(wrapper, field);
                wrapper.appendChild(field);
                
                const toggleBtn = document.createElement('button');
                toggleBtn.type = 'button';
                toggleBtn.className = 'btn btn-outline-secondary toggle-password';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                toggleBtn.onclick = () => togglePassword(fieldId);
                
                wrapper.appendChild(toggleBtn);
            }
        });
    });
</script>
<?= $this->endSection() ?>