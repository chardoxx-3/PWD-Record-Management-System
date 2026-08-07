<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-clipboard-list me-2"></i>System Audit Log
            </h1>
            <p class="text-muted mb-0">Monitor all system activities and user actions.</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#clearLogsModal">
                <i class="fas fa-broom me-2"></i>Clear Old Logs
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <form method="get" action="<?= base_url('/admin/audit-log') ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Action Type</label>
                        <select class="form-select form-control-custom" name="action">
                            <option value="">All Actions</option>
                            <?php foreach ($actions as $action): ?>
                                <option value="<?= $action ?>" <?= ($actionFilter ?? '') == $action ? 'selected' : '' ?>>
                                    <?= $action ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">User</label>
                        <select class="form-select form-control-custom" name="user_id">
                            <option value="">All Users</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= ($userId ?? '') == $user['id'] ? 'selected' : '' ?>>
                                    <?= $user['username'] ?>
                                </option>
                            <?php endforeach; ?>
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
                        <a href="<?= base_url('/admin/audit-log') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-history me-2"></i>Activity Log
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($auditLogs)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-custom">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Record ID</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($auditLogs as $log): ?>
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('M j, Y', strtotime($log['created_at'])) ?><br>
                                            <?= date('g:i A', strtotime($log['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="fw-semibold"><?= $log['username'] ?></span>
                                                <br>
                                                <small class="text-muted"><?= $log['full_name'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            <?= strpos($log['action'], 'CREATE') !== false ? 'bg-success' : '' ?>
                                            <?= strpos($log['action'], 'UPDATE') !== false ? 'bg-primary' : '' ?>
                                            <?= strpos($log['action'], 'DELETE') !== false ? 'bg-danger' : '' ?>
                                            <?= strpos($log['action'], 'LOGIN') !== false ? 'bg-info' : '' ?>
                                            <?= strpos($log['action'], 'LOGOUT') !== false ? 'bg-secondary' : '' ?>
                                            <?= !in_array(true, [
                                                strpos($log['action'], 'CREATE') !== false,
                                                strpos($log['action'], 'UPDATE') !== false,
                                                strpos($log['action'], 'DELETE') !== false,
                                                strpos($log['action'], 'LOGIN') !== false,
                                                strpos($log['action'], 'LOGOUT') !== false
                                            ]) ? 'bg-warning text-dark' : '' ?>
                                            px-3 py-2">
                                            <?= $log['action'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold"><?= $log['description'] ?></span>
                                    </td>
                                    <td>
                                        <?php if ($log['record_id']): ?>
                                            <span class="badge bg-light text-dark">#<?= $log['record_id'] ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= $log['ip_address'] ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pager): ?>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing <?= count($auditLogs) ?> of <?= $pager->getTotal() ?> activities
                        </div>
                        <nav>
                            <?= $pager->links('default', 'custom_pagination') ?>
                        </nav>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Audit Logs Found</h4>
                    <p class="text-muted">System activities will appear here once users start using the system.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Clear Logs Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--primary-color);">
                    <i class="fas fa-exclamation-triangle me-2"></i>Clear Audit Logs
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>This action will permanently delete audit logs older than 90 days.</p>
                <p class="text-danger fw-semibold">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    This action cannot be undone. Are you sure you want to proceed?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= base_url('/admin/clear-audit-log') ?>" class="btn btn-danger">
                    <i class="fas fa-broom me-2"></i>Clear Old Logs
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
<?= $this->endSection() ?>