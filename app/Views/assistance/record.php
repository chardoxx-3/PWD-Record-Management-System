<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-hand-holding-heart me-2"></i>Record Assistance
            </h1>
            <p class="text-muted mb-0">Record new assistance provided to PWD members.</p>
        </div>
        <div>
            <a href="<?= base_url('/assistance') ?>" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Assistance Form -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-plus-circle me-2"></i>New Assistance Record
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/assistance/create-assistance') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pwd_id" class="form-label fw-semibold">Select PWD <span class="text-danger">*</span></label>
                            <select class="form-select form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('pwd_id', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                    id="pwd_id" name="pwd_id" required>
                                <option value="">Select PWD Member</option>
                                <?php foreach ($pwdProfiles as $pwd): ?>
                                    <option value="<?= $pwd['id'] ?>" <?= old('pwd_id') == $pwd['id'] ? 'selected' : '' ?>>
                                        <?= $pwd['full_name'] ?> (<?= $pwd['disability_type'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('pwd_id', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['pwd_id'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assistance_type" class="form-label fw-semibold">Assistance Type <span class="text-danger">*</span></label>
                            <select class="form-select form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('assistance_type', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                    id="assistance_type" name="assistance_type" required>
                                <option value="">Select Assistance Type</option>
                                <option value="Financial" <?= old('assistance_type') == 'Financial' ? 'selected' : '' ?>>Financial Aid</option>
                                <option value="Medical" <?= old('assistance_type') == 'Medical' ? 'selected' : '' ?>>Medical Support</option>
                                <option value="Educational" <?= old('assistance_type') == 'Educational' ? 'selected' : '' ?>>Educational Assistance</option>
                                <option value="Rehabilitation" <?= old('assistance_type') == 'Rehabilitation' ? 'selected' : '' ?>>Rehabilitation Services</option>
                                <option value="Equipment" <?= old('assistance_type') == 'Equipment' ? 'selected' : '' ?>>Equipment Provision</option>
                                <option value="Other" <?= old('assistance_type') == 'Other' ? 'selected' : '' ?>>Other Support</option>
                            </select>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('assistance_type', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['assistance_type'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assistance_date" class="form-label fw-semibold">Assistance Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('assistance_date', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                   id="assistance_date" name="assistance_date" value="<?= old('assistance_date', date('Y-m-d')) ?>" required>
                            <?php if (session()->getFlashdata('errors') && array_key_exists('assistance_date', session()->getFlashdata('errors'))): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['assistance_date'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">Amount (if applicable)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">₱</span>
                                <input type="number" class="form-control form-control-custom border-start-0" 
                                       id="amount" name="amount" value="<?= old('amount') ?>" 
                                       placeholder="0.00" step="0.01" min="0">
                            </div>
                            <small class="text-muted">Leave blank if no financial amount involved</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('description', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                              id="description" name="description" rows="4" 
                              placeholder="Describe the assistance provided, items given, services rendered, etc." required><?= old('description') ?></textarea>
                    <?php if (session()->getFlashdata('errors') && array_key_exists('description', session()->getFlashdata('errors'))): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errors')['description'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                    <textarea class="form-control form-control-custom" id="notes" name="notes" rows="3" 
                              placeholder="Any additional information, observations, or follow-up requirements..."><?= old('notes') ?></textarea>
                </div>

                <div class="alert alert-info alert-custom">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> This assistance record will be immediately saved and linked to the selected PWD profile.
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="<?= base_url('/assistance') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Save Assistance Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set today's date as default for assistance date
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('assistance_date').value = today;

        // Show/hide amount field based on assistance type
        const assistanceType = document.getElementById('assistance_type');
        const amountField = document.getElementById('amount');
        
        assistanceType.addEventListener('change', function() {
            if (this.value === 'Financial') {
                amountField.closest('.mb-3').style.display = 'block';
            } else {
                amountField.closest('.mb-3').style.display = 'block'; // Always show but make optional
            }
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
</script>
<?= $this->endSection() ?>