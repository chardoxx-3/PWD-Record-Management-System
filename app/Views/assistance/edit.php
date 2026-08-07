<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-edit me-2"></i>Edit Assistance Record
            </h1>
            <p class="text-muted mb-0">Update assistance record for <?= $assistanceRecord['full_name'] ?></p>
        </div>
        <div>
            <a href="<?= base_url('/assistance/history/' . $assistanceRecord['pwd_id']) ?>" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to History
            </a>
        </div>
    </div>

    <!-- Assistance Form -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-edit me-2"></i>Edit Assistance Record
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/assistance/update-assistance/' . $assistanceRecord['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pwd_id" class="form-label fw-semibold">PWD Member</label>
                            <input type="text" class="form-control form-control-custom" value="<?= $assistanceRecord['full_name'] ?>" readonly>
                            <input type="hidden" name="pwd_id" value="<?= $assistanceRecord['pwd_id'] ?>">
                            <small class="text-muted">PWD member cannot be changed</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assistance_type" class="form-label fw-semibold">Assistance Type <span class="text-danger">*</span></label>
                            <select class="form-select form-control-custom <?= session()->getFlashdata('errors') && array_key_exists('assistance_type', session()->getFlashdata('errors')) ? 'is-invalid' : '' ?>" 
                                    id="assistance_type" name="assistance_type" required>
                                <option value="">Select Assistance Type</option>
                                <option value="Financial" <?= old('assistance_type', $assistanceRecord['assistance_type']) == 'Financial' ? 'selected' : '' ?>>Financial Aid</option>
                                <option value="Medical" <?= old('assistance_type', $assistanceRecord['assistance_type']) == 'Medical' ? 'selected' : '' ?>>Medical Support</option>
                                <option value="Educational" <?= old('assistance_type', $assistanceRecord['assistance_type']) == 'Educational' ? 'selected' : '' ?>>Educational Assistance</option>
                                <option value="Rehabilitation" <?= old('assistance_type', $assistanceRecord['assistance_type']) == 'Rehabilitation' ? 'selected' : '' ?>>Rehabilitation Services</option>
                                <option value="Equipment" <?= old('assistance_type', $assistanceRecord['assistance_type']) == 'Equipment' ? 'selected' : '' ?>>Equipment Provision</option>
                                <option value="Other" <?= old('assistance_type', $assistanceRecord['assistance_type']) == 'Other' ? 'selected' : '' ?>>Other Support</option>
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
                                   id="assistance_date" name="assistance_date" value="<?= old('assistance_date', $assistanceRecord['assistance_date']) ?>" required>
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
                                       id="amount" name="amount" value="<?= old('amount', $assistanceRecord['amount']) ?>" 
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
                              placeholder="Describe the assistance provided, items given, services rendered, etc." required><?= old('description', $assistanceRecord['description']) ?></textarea>
                    <?php if (session()->getFlashdata('errors') && array_key_exists('description', session()->getFlashdata('errors'))): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errors')['description'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                    <textarea class="form-control form-control-custom" id="notes" name="notes" rows="3" 
                              placeholder="Any additional information, observations, or follow-up requirements..."><?= old('notes', $assistanceRecord['notes']) ?></textarea>
                </div>

                <div class="alert alert-warning alert-custom">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Note:</strong> This will update the existing assistance record. Changes will be logged in the audit trail.
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="<?= base_url('/assistance/history/' . $assistanceRecord['pwd_id']) ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Update Assistance Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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