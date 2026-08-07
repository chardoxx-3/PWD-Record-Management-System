<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-hands-helping me-2"></i>Assistance Records
            </h1>
            <p class="text-muted mb-0">View and manage all assistance provided to PWD members.</p>
        </div>
        <div>
            <a href="<?= base_url('/assistance/record') ?>" class="btn btn-primary-custom me-2">
                <i class="fas fa-plus me-2"></i>Record Assistance
            </a>
            <a href="<?= base_url('/assistance/reservations') ?>" class="btn btn-outline-primary">
                <i class="fas fa-calendar-alt me-2"></i>Reservations
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <form method="get" action="<?= base_url('/assistance') ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">PWD Member</label>
                        <select class="form-select form-control-custom" name="pwd_id">
                            <option value="">All Members</option>
                            <?php foreach ($pwdProfiles as $pwd): ?>
                                <option value="<?= $pwd['id'] ?>" <?= ($pwdId ?? '') == $pwd['id'] ? 'selected' : '' ?>>
                                    <?= $pwd['full_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Assistance Type</label>
                        <select class="form-select form-control-custom" name="assistance_type">
                            <option value="">All Types</option>
                            <option value="Financial" <?= ($assistanceType ?? '') == 'Financial' ? 'selected' : '' ?>>Financial</option>
                            <option value="Medical" <?= ($assistanceType ?? '') == 'Medical' ? 'selected' : '' ?>>Medical</option>
                            <option value="Educational" <?= ($assistanceType ?? '') == 'Educational' ? 'selected' : '' ?>>Educational</option>
                            <option value="Rehabilitation" <?= ($assistanceType ?? '') == 'Rehabilitation' ? 'selected' : '' ?>>Rehabilitation</option>
                            <option value="Equipment" <?= ($assistanceType ?? '') == 'Equipment' ? 'selected' : '' ?>>Equipment</option>
                            <option value="Other" <?= ($assistanceType ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control form-control-custom" name="start_date" 
                               value="<?= $startDate ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control form-control-custom" name="end_date" 
                               value="<?= $endDate ?? '' ?>">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        <a href="<?= base_url('/assistance') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- Assistance Records Table -->
<div class="table-container mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: var(--primary-color);">
            <i class="fas fa-list me-2"></i>Assistance Records
        </h5>
        <div class="text-muted">
            <?php if (!empty($assistanceRecords) && $pager && $pager->getTotal() > 20): ?>
                Showing <?= count($assistanceRecords) ?> of <?= $pager->getTotal() ?> records
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($assistanceRecords)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-custom table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>PWD Member</th>
                        <th>Assistance Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assistanceRecords as $record): ?>
                        <tr>
                            <td>
                                <span class="fw-semibold"><?= date('M j, Y', strtotime($record['assistance_date'])) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?= $record['full_name'] ?></h6>
                                        <small class="text-muted">ID: <?= $record['pwd_id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $record['assistance_type'] == 'Financial' ? 'bg-success' : '' ?>
                                    <?= $record['assistance_type'] == 'Medical' ? 'bg-danger' : '' ?>
                                    <?= $record['assistance_type'] == 'Educational' ? 'bg-info' : '' ?>
                                    <?= $record['assistance_type'] == 'Rehabilitation' ? 'bg-warning text-dark' : '' ?>
                                    <?= $record['assistance_type'] == 'Equipment' ? 'bg-secondary' : '' ?>
                                    <?= $record['assistance_type'] == 'Other' ? 'bg-dark' : '' ?>
                                    px-3 py-2">
                                    <?= $record['assistance_type'] ?>
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= $record['description'] ?></span>
                                <?php if ($record['notes']): ?>
                                    <br>
                                    <small class="text-muted"><?= $record['notes'] ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($record['amount'] > 0): ?>
                                    <span class="fw-bold text-success">₱<?= number_format($record['amount'], 2) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted">Admin</small>
                            </td>
                            <td>
<a class="btn btn-sm btn-outline-primary" 
   href="<?= base_url('/assistance/history/' . $record['pwd_id']) ?>">
   <i class="fas fa-history me-1"></i>View History
</a>

                                <!-- Details Modal -->
                                <div class="modal fade" id="detailsModal<?= $record['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" style="color: var(--primary-color);">
                                                    <i class="fas fa-info-circle me-2"></i>Assistance Details
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td class="fw-semibold">PWD Member:</td>
                                                                <td><?= $record['full_name'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-semibold">Assistance Type:</td>
                                                                <td>
                                                                    <span class="badge bg-primary"><?= $record['assistance_type'] ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-semibold">Date:</td>
                                                                <td><?= date('F j, Y', strtotime($record['assistance_date'])) ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td class="fw-semibold">Amount:</td>
                                                                <td>
                                                                    <?php if ($record['amount'] > 0): ?>
                                                                        <span class="fw-bold text-success">₱<?= number_format($record['amount'], 2) ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">Not applicable</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-semibold">Recorded:</td>
                                                                <td><?= date('M j, Y g:i A', strtotime($record['created_at'])) ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="fw-semibold">Description:</label>
                                                    <p class="mb-0"><?= $record['description'] ?></p>
                                                </div>
                                                <?php if ($record['notes']): ?>
                                                    <div class="mt-3">
                                                        <label class="fw-semibold">Additional Notes:</label>
                                                        <p class="mb-0 text-muted"><?= $record['notes'] ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
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
            <i class="fas fa-hands-helping fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No Assistance Records Found</h4>
            <p class="text-muted mb-4">Start recording assistance provided to PWD members.</p>
            <a href="<?= base_url('/assistance/record') ?>" class="btn btn-primary-custom">
                <i class="fas fa-plus me-2"></i>Record Assistance
            </a>
        </div>
    <?php endif; ?>
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
<?= $this->endSection() ?>