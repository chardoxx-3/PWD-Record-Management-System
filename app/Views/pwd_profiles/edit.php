<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-edit me-2"></i>Edit PWD Profile
            </h1>
            <p class="text-muted mb-0">Update information for <?= $pwdProfile['full_name'] ?></p>
        </div>
        <div>
            <a href="<?= base_url('/pwd-profiles') ?>" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Edit PWD Form -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-user-edit me-2"></i>Edit Personal Information
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/pwd-profiles/update/' . $pwdProfile['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('full_name', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="full_name" name="full_name" value="<?= old('full_name', $pwdProfile['full_name']) ?>" required>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('full_name', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['full_name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="gender" class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                            <select class="form-select form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('gender', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                    id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= old('gender', $pwdProfile['gender']) == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender', $pwdProfile['gender']) == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender', $pwdProfile['gender']) == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('gender', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['gender'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="age" class="form-label fw-semibold">Age <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('age', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="age" name="age" value="<?= old('age', $pwdProfile['age']) ?>" min="1" max="120" required>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('age', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['age'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_number" class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('contact_number', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="contact_number" name="contact_number" value="<?= old('contact_number', $pwdProfile['contact_number']) ?>" required>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('contact_number', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['contact_number'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="email" name="email" value="<?= old('email', $pwdProfile['email']) ?>">
                            <?php if (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Complete Address <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('address', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                              id="address" name="address" rows="3" required><?= old('address', $pwdProfile['address']) ?></textarea>
                    <?php if (session()->getFlashdata('errors') && array_key_exists('address', session()->getFlashdata('errors'))): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errors')['address'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <hr class="my-4">

                <h5 class="mb-3" style="color: var(--primary-color);">
                    <i class="fas fa-wheelchair me-2"></i>Disability Information
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="disability_type" class="form-label fw-semibold">Disability Type <span class="text-danger">*</span></label>
                            <select class="form-select form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('disability_type', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                    id="disability_type" name="disability_type" required>
                                <option value="">Select Disability Type</option>
                                <?php foreach ($disabilityTypes as $type): ?>
                                    <option value="<?= $type['type_name'] ?>" <?= old('disability_type', $pwdProfile['disability_type']) == $type['type_name'] ? 'selected' : '' ?>>
                                        <?= $type['type_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('disability_type', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['disability_type'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="disability_level" class="form-label fw-semibold">Disability Level</label>
                            <select class="form-select form-control-custom" id="disability_level" name="disability_level">
                                <option value="">Select Level</option>
                                <option value="Mild" <?= old('disability_level', $pwdProfile['disability_level']) == 'Mild' ? 'selected' : '' ?>>Mild</option>
                                <option value="Moderate" <?= old('disability_level', $pwdProfile['disability_level']) == 'Moderate' ? 'selected' : '' ?>>Moderate</option>
                                <option value="Severe" <?= old('disability_level', $pwdProfile['disability_level']) == 'Severe' ? 'selected' : '' ?>>Severe</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="medical_notes" class="form-label fw-semibold">Medical Notes & Additional Information</label>
                    <textarea class="form-control form-control-custom" id="medical_notes" name="medical_notes" rows="4"><?= old('medical_notes', $pwdProfile['medical_notes']) ?></textarea>
                </div>

                <hr class="my-4">

                <h5 class="mb-3" style="color: var(--primary-color);">
                    <i class="fas fa-cog me-2"></i>Profile Settings
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="identification_number" class="form-label fw-semibold">Identification Number</label>
                            <input type="text" class="form-control form-control-custom" id="identification_number" 
                                   name="identification_number" value="<?= old('identification_number', $pwdProfile['identification_number']) ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select form-control-custom" id="status" name="status" required>
                                <option value="active" <?= old('status', $pwdProfile['status']) == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="archived" <?= old('status', $pwdProfile['status']) == 'archived' ? 'selected' : '' ?>>Archived</option>
                                <option value="inactive" <?= old('status', $pwdProfile['status']) == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="<?= base_url('/pwd-profiles/view/' . $pwdProfile['id']) ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>