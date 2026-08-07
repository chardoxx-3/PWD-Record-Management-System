<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-users me-2"></i>PWD Profiles
            </h1>
            <p class="text-muted mb-0">Manage Persons with Disabilities records and information.</p>
        </div>
        <div>
            <a href="<?= base_url('/pwd-profiles/add') ?>" class="btn btn-primary-custom">
                <i class="fas fa-user-plus me-2"></i>Add New PWD
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <form method="get" action="<?= base_url('/pwd-profiles') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control form-control-custom" name="search" 
                               value="<?= $search ?? '' ?>" placeholder="Search by name, contact, or address...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Disability Type</label>
                        <select class="form-select form-control-custom" name="disability_type">
                            <option value="">All Types</option>
                            <?php foreach ($disabilityTypes as $type): ?>
                                <option value="<?= $type['type_name'] ?>" <?= ($disabilityType ?? '') == $type['type_name'] ? 'selected' : '' ?>>
                                    <?= $type['type_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select form-control-custom" name="status">
                            <option value="active" <?= ($status ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="archived" <?= ($status ?? '') == 'archived' ? 'selected' : '' ?>>Archived</option>
                            <option value="inactive" <?= ($status ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- PWD Profiles Table -->
<div class="table-container mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: var(--primary-color);">
            <i class="fas fa-list me-2"></i>PWD Records
        </h5>
        <div class="text-muted">
            <?php if (!empty($pwdProfiles) && $pager && $pager->getTotal() > 20): ?>
                Showing <?= count($pwdProfiles) ?> of <?= $pager->getTotal() ?> records
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($pwdProfiles)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-custom table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Full Name</th>
                        <th>Age/Gender</th>
                        <th>Contact</th>
                        <th>Disability Type</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pwdProfiles as $pwd): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?= $pwd['full_name'] ?></h6>
                                        <small class="text-muted">ID: <?= $pwd['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= $pwd['age'] ?> yrs</span>
                                <br>
                                <small class="text-muted"><?= $pwd['gender'] ?></small>
                            </td>
                            <td>
                                <?= $pwd['contact_number'] ?>
                                <?php if (!empty($pwd['email'])): ?>
                                    <br><small class="text-muted"><?= $pwd['email'] ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    <?= $pwd['disability_type'] ?>
                                </span>
                            </td>
                            <td>
                                <small class="text-truncate d-inline-block" style="max-width: 200px;">
                                    <?= $pwd['address'] ?>
                                </small>
                            </td>
                            <td>
                                <?php if ($pwd['status'] == 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php elseif ($pwd['status'] == 'archived'): ?>
                                    <span class="badge bg-secondary">Archived</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Inactive</span>
                                <?php endif; ?>
                            </td>
<td>
    <div class="dropdown position-static">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" 
                   href="<?= base_url('/pwd-profiles/view/' . $pwd['id']) ?>">
                    <i class="fas fa-eye me-2 text-primary"></i>View Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" 
                   href="<?= base_url('/pwd-profiles/edit/' . $pwd['id']) ?>">
                    <i class="fas fa-edit me-2 text-secondary"></i>Edit Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" 
                   href="<?= base_url('/assistance/history/' . $pwd['id']) ?>">
                    <i class="fas fa-history me-2 text-info"></i>View History
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <?php if ($pwd['status'] == 'active'): ?>
                <li>
                    <a class="dropdown-item" 
                       href="#" 
                       data-bs-toggle="modal" 
                       data-bs-target="#archiveModal"
                       data-pwd-id="<?= $pwd['id'] ?>"
                       data-pwd-name="<?= htmlspecialchars($pwd['full_name']) ?>">
                        <i class="fas fa-archive me-2 text-warning"></i>Archive
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a class="dropdown-item" 
                       href="<?= base_url('/pwd-profiles/activate/' . $pwd['id']) ?>">
                        <i class="fas fa-check me-2 text-success"></i>Activate
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a class="dropdown-item text-danger" 
                   href="#" 
                   data-bs-toggle="modal" 
                   data-bs-target="#deleteModal"
                   data-pwd-id="<?= $pwd['id'] ?>"
                   data-pwd-name="<?= htmlspecialchars($pwd['full_name']) ?>">
                    <i class="fas fa-trash me-2"></i>Delete
                </a>
            </li>
        </ul>
    </div>
</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination - Only show if total records exceed 20 -->
        <?php if ($pager && $pager->getTotal() > 20): ?>
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <?= $pager->links('default', 'default_full') ?>
                </nav>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="text-center py-5 border rounded">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No PWD Profiles Found</h4>
            <p class="text-muted mb-4">Get started by adding your first PWD profile.</p>
            <a href="<?= base_url('/pwd-profiles/add') ?>" class="btn btn-primary-custom">
                <i class="fas fa-user-plus me-2"></i>Add New PWD
            </a>
        </div>
    <?php endif; ?>
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

<style>
    .custom_pagination .pagination .page-link {
        color: var(--primary-color);
        border: 1px solid var(--border-color);
    }

    .custom_pagination .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .custom_pagination .pagination .page-link:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
        color: white;
    }
</style>

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