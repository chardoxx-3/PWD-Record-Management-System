<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-calendar-alt me-2"></i>Reservation Management
            </h1>
            <p class="text-muted mb-0">Manage upcoming assistance reservations and appointments.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addReservationModal">
                <i class="fas fa-plus me-2"></i>New Reservation
            </button>
        </div>
    </div>

    <!-- Status Filter -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="btn-group" role="group">
                        <a href="<?= base_url('/assistance/reservations?status=pending') ?>" 
                           class="btn <?= ($status ?? 'pending') == 'pending' ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <i class="fas fa-clock me-2"></i>Pending
                        </a>
                        <a href="<?= base_url('/assistance/reservations?status=approved') ?>" 
                           class="btn <?= ($status ?? '') == 'approved' ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <i class="fas fa-check me-2"></i>Approved
                        </a>
                        <a href="<?= base_url('/assistance/reservations?status=completed') ?>" 
                           class="btn <?= ($status ?? '') == 'completed' ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <i class="fas fa-check-double me-2"></i>Completed
                        </a>
                        <a href="<?= base_url('/assistance/reservations?status=cancelled') ?>" 
                           class="btn <?= ($status ?? '') == 'cancelled' ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <i class="fas fa-times me-2"></i>Cancelled
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <span class="text-muted">
                        <?= $pager ? $pager->getTotal() : 0 ?> reservations found
                    </span>
                </div>
            </div>
        </div>
    </div>

<!-- Reservations Table -->
<div class="table-container mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="color: var(--primary-color);">
            <i class="fas fa-list me-2"></i>Reservations
            <span class="badge bg-primary ms-2"><?= $status ?? 'pending' ?></span>
        </h5>
        <div class="text-muted">
            <?php if (!empty($reservations) && $pager && $pager->getTotal() > 20): ?>
                Showing <?= count($reservations) ?> of <?= $pager->getTotal() ?> reservations
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($reservations)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-custom table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Reservation Date</th>
                        <th>PWD Member</th>
                        <th>Assistance Type</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                                    <td>
                                        <span class="fw-semibold">
                                            <?= date('M j, Y', strtotime($reservation['reservation_date'])) ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <?= date('D', strtotime($reservation['reservation_date'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="fw-semibold"><?= $reservation['full_name'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                            <?= $reservation['assistance_type'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold"><?= $reservation['purpose'] ?></span>
                                        <?php if ($reservation['notes']): ?>
                                            <br>
                                            <small class="text-muted"><?= $reservation['notes'] ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($reservation['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php elseif ($reservation['status'] == 'approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif ($reservation['status'] == 'completed'): ?>
                                            <span class="badge bg-info">Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('M j, Y', strtotime($reservation['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <?php if ($reservation['status'] == 'pending'): ?>
                                                <form action="<?= base_url('/assistance/update-reservation-status/' . $reservation['id']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="<?= base_url('/assistance/update-reservation-status/' . $reservation['id']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            <?php elseif ($reservation['status'] == 'approved'): ?>
                                                <form action="<?= base_url('/assistance/update-reservation-status/' . $reservation['id']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-outline-info" title="Mark as Completed">
                                                        <i class="fas fa-check-double"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailsModal<?= $reservation['id'] ?>"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>

                                        <!-- Details Modal -->
                                        <div class="modal fade" id="detailsModal<?= $reservation['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: var(--primary-color);">
                                                            <i class="fas fa-info-circle me-2"></i>Reservation Details
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <td class="fw-semibold">PWD Member:</td>
                                                                        <td><?= $reservation['full_name'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-semibold">Assistance Type:</td>
                                                                        <td>
                                                                            <span class="badge bg-primary"><?= $reservation['assistance_type'] ?></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-semibold">Reservation Date:</td>
                                                                        <td><?= date('F j, Y', strtotime($reservation['reservation_date'])) ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <td class="fw-semibold">Status:</td>
                                                                        <td>
                                                                            <?php if ($reservation['status'] == 'pending'): ?>
                                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                                            <?php elseif ($reservation['status'] == 'approved'): ?>
                                                                                <span class="badge bg-success">Approved</span>
                                                                            <?php elseif ($reservation['status'] == 'completed'): ?>
                                                                                <span class="badge bg-info">Completed</span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-danger">Cancelled</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-semibold">Created:</td>
                                                                        <td><?= date('M j, Y g:i A', strtotime($reservation['created_at'])) ?></td>
                                                                    </tr>
                                                                    <?php if ($reservation['approved_at']): ?>
                                                                        <tr>
                                                                            <td class="fw-semibold">Approved:</td>
                                                                            <td><?= date('M j, Y g:i A', strtotime($reservation['approved_at'])) ?></td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="fw-semibold">Purpose:</label>
                                                            <p class="mb-0"><?= $reservation['purpose'] ?></p>
                                                        </div>
                                                        <?php if ($reservation['notes']): ?>
                                                            <div class="mt-3">
                                                                <label class="fw-semibold">Additional Notes:</label>
                                                                <p class="mb-0 text-muted"><?= $reservation['notes'] ?></p>
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
            <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No Reservations Found</h4>
            <p class="text-muted mb-4">No <?= $status ?? 'pending' ?> reservations at the moment.</p>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addReservationModal">
                <i class="fas fa-plus me-2"></i>Create New Reservation
            </button>
        </div>
    <?php endif; ?>
</div>
    </div>
</div>

<!-- Add Reservation Modal -->
<div class="modal fade" id="addReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--primary-color);">
                    <i class="fas fa-plus-circle me-2"></i>New Reservation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/assistance/create-reservation') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pwd_id" class="form-label fw-semibold">Select PWD <span class="text-danger">*</span></label>
                                <select class="form-select form-control-custom" id="pwd_id" name="pwd_id" required>
                                    <option value="">Select PWD Member</option>
                                    <?php foreach ($pwdProfiles as $pwd): ?>
                                        <option value="<?= $pwd['id'] ?>"><?= $pwd['full_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assistance_type" class="form-label fw-semibold">Assistance Type <span class="text-danger">*</span></label>
                                <select class="form-select form-control-custom" id="assistance_type" name="assistance_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Financial">Financial Aid</option>
                                    <option value="Medical">Medical Support</option>
                                    <option value="Educational">Educational Assistance</option>
                                    <option value="Rehabilitation">Rehabilitation Services</option>
                                    <option value="Equipment">Equipment Provision</option>
                                    <option value="Other">Other Support</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reservation_date" class="form-label fw-semibold">Reservation Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-custom" id="reservation_date" name="reservation_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="purpose" class="form-label fw-semibold">Purpose <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-custom" id="purpose" name="purpose" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                        <textarea class="form-control form-control-custom" id="notes" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Create Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today for reservation date
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservation_date').min = today;
        document.getElementById('reservation_date').value = today;
    });
</script>

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