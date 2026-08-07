<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-user me-2"></i>PWD Profile
            </h1>
            <p class="text-muted mb-0">View complete details of <?= $pwdProfile['full_name'] ?></p>
        </div>
        <div>
            <a href="<?= base_url('/pwd-profiles') ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
            <a href="<?= base_url('/pwd-profiles/edit/' . $pwdProfile['id']) ?>" class="btn btn-primary-custom">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </a>
        </div>
    </div>

    <!-- Profile Overview -->
    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-user-circle me-2"></i>Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold" style="width: 40%;">Full Name:</td>
                                    <td><?= $pwdProfile['full_name'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Gender:</td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                            <?= $pwdProfile['gender'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Age:</td>
                                    <td>
                                        <span class="fw-semibold"><?= $pwdProfile['age'] ?> years old</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Contact Number:</td>
                                    <td><?= $pwdProfile['contact_number'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold" style="width: 40%;">Email:</td>
                                    <td><?= $pwdProfile['email'] ?: 'Not provided' ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">PWD ID:</td>
                                    <td><?= $pwdProfile['identification_number'] ?: 'Not provided' ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td>
                                        <?php if ($pwdProfile['status'] == 'active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php elseif ($pwdProfile['status'] == 'archived'): ?>
                                            <span class="badge bg-secondary">Archived</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Registered:</td>
                                    <td><?= date('M j, Y', strtotime($pwdProfile['created_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="fw-semibold">Complete Address:</label>
                        <p class="mb-0"><?= $pwdProfile['address'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Disability Information -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-wheelchair me-2"></i>Disability Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold" style="width: 40%;">Disability Type:</td>
                                    <td>
                                        <span class="badge bg-primary px-3 py-2">
                                            <?= $pwdProfile['disability_type'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Disability Level:</td>
                                    <td>
                                        <?php if ($pwdProfile['disability_level']): ?>
                                            <span class="badge bg-warning text-dark">
                                                <?= $pwdProfile['disability_level'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Not specified</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if ($pwdProfile['medical_notes']): ?>
                        <div class="mt-3">
                            <label class="fw-semibold">Medical Notes & Additional Information:</label>
                            <div class="border rounded p-3 bg-light">
                                <?= nl2br(htmlspecialchars($pwdProfile['medical_notes'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="col-lg-4">
            <!-- Profile Summary -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-chart-line me-2"></i>Profile Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                        <h5 class="mt-3 mb-1"><?= $pwdProfile['full_name'] ?></h5>
                        <p class="text-muted">PWD Member</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="<?= base_url('/assistance/record?pwd_id=' . $pwdProfile['id']) ?>" 
                           class="btn btn-primary-custom">
                            <i class="fas fa-hand-holding-heart me-2"></i>Record Assistance
                        </a>
                        <a href="<?= base_url('/assistance/history/' . $pwdProfile['id']) ?>" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i>View Assistance History
                        </a>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-phone-alt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="tel:<?= $pwdProfile['contact_number'] ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-phone text-primary me-2"></i>
                            Call <?= $pwdProfile['full_name'] ?>
                        </a>
                        <?php if ($pwdProfile['email']): ?>
                            <a href="mailto:<?= $pwdProfile['email'] ?>" class="list-group-item list-group-item-action">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                Send Email
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('/pwd-profiles/edit/' . $pwdProfile['id']) ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-edit text-primary me-2"></i>
                            Edit Profile
                        </a>
                        <?php if ($pwdProfile['status'] == 'active'): ?>
                            <a href="#" 
   class="list-group-item list-group-item-action text-warning"
   data-bs-toggle="modal" 
   data-bs-target="#archiveModal"
   data-pwd-id="<?= $pwdProfile['id'] ?>"
   data-pwd-name="<?= htmlspecialchars($pwdProfile['full_name']) ?>">
    <i class="fas fa-archive me-2"></i>
    Archive Profile
</a>
                        <?php else: ?>
                            <a href="<?= base_url('/pwd-profiles/activate/' . $pwdProfile['id']) ?>" 
                               class="list-group-item list-group-item-action text-success">
                                <i class="fas fa-check me-2"></i>
                                Activate Profile
                            </a>
                        <?php endif; ?>
                        <a href="#" 
   class="list-group-item list-group-item-action text-danger"
   data-bs-toggle="modal" 
   data-bs-target="#deleteModal"
   data-pwd-id="<?= $pwdProfile['id'] ?>"
   data-pwd-name="<?= htmlspecialchars($pwdProfile['full_name']) ?>">
    <i class="fas fa-trash me-2"></i>
    Delete Profile
</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this PWD profile?</p>
                <p class="text-danger fw-semibold">This action cannot be undone and all associated data will be permanently lost.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Delete Profile
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="archiveModalLabel">
                    <i class="fas fa-archive me-2"></i>Confirm Archive
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to archive this PWD profile?</p>
                <p class="text-muted">Archived profiles will be moved to the archived section and can be restored later.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmArchive" class="btn btn-warning text-white">
                    <i class="fas fa-archive me-2"></i>Archive Profile
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete Modal Handler
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const pwdId = button.getAttribute('data-pwd-id');
        const pwdName = button.getAttribute('data-pwd-name');
        
        const modalBody = deleteModal.querySelector('.modal-body');
        modalBody.innerHTML = `
            <p>Are you sure you want to delete the profile for <strong>${pwdName}</strong>?</p>
            <p class="text-danger fw-semibold">This action cannot be undone and all associated data will be permanently lost.</p>
        `;
        
        const confirmButton = deleteModal.querySelector('#confirmDelete');
        confirmButton.href = '<?= base_url('/pwd-profiles/delete/') ?>' + pwdId;
    });

    // Archive Modal Handler
    const archiveModal = document.getElementById('archiveModal');
    archiveModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const pwdId = button.getAttribute('data-pwd-id');
        const pwdName = button.getAttribute('data-pwd-name');
        
        const modalBody = archiveModal.querySelector('.modal-body');
        modalBody.innerHTML = `
            <p>Are you sure you want to archive the profile for <strong>${pwdName}</strong>?</p>
            <p class="text-muted">Archived profiles will be moved to the archived section and can be restored later.</p>
        `;
        
        const confirmButton = archiveModal.querySelector('#confirmArchive');
        confirmButton.href = '<?= base_url('/pwd-profiles/archive/') ?>' + pwdId;
    });
});
</script>
<?= $this->endSection() ?>