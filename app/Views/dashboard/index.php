<?= $this->extend('templates/header') ?>


<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1" style="color: var(--primary-color);">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h1>
        <p class="text-muted mb-0">System overview and quick statistics</p>
    </div>
    <div class="text-end">
        <p class="text-muted small mb-0">Last login: <?= date('M j, Y g:i A') ?></p>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle p-3" style="background: rgba(30, 58, 138, 0.1);">
                            <i class="fas fa-users fa-2x" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="stat-number"><?= $totalPwd ?? 0 ?></h3>
                        <p class="stat-label">Total PWDs</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle p-3" style="background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-hands-helping fa-2x" style="color: #10b981;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="stat-number"><?= $totalAssistance ?? 0 ?></h3>
                        <p class="stat-label">Assistance Records</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle p-3" style="background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-calendar-check fa-2x" style="color: #f59e0b;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="stat-number"><?= $totalReservations ?? 0 ?></h3>
                        <p class="stat-label">Pending Reservations</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle p-3" style="background: rgba(239, 68, 68, 0.1);">
                            <i class="fas fa-chart-pie fa-2x" style="color: #ef4444;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="stat-number"><?= count($disabilityStats ?? []) ?></h3>
                        <p class="stat-label">Disability Types</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Disability Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-wheelchair me-2"></i>Disability Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($disabilityStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <?php foreach ($disabilityStats as $stat): ?>
                                        <tr>
                                            <td class="w-50">
                                                <span class="fw-semibold"><?= $stat['disability_type'] ?></span>
                                            </td>
                                            <td class="w-25">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar" 
                                                         style="background-color: var(--primary-color); width: <?= ($stat['count'] / $totalPwd) * 100 ?>%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="w-25 text-end">
                                                <span class="badge bg-primary"><?= $stat['count'] ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No disability data available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Assistance -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-history me-2"></i>Recent Assistance
                    </h5>
                    <a href="<?= base_url('/assistance') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentAssistance)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentAssistance as $assistance): ?>
                                <div class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?= $assistance['full_name'] ?></h6>
                                            <p class="text-muted small mb-0">
                                                <?= $assistance['assistance_type'] ?> - 
                                                <?= date('M j, Y', strtotime($assistance['assistance_date'])) ?>
                                            </p>
                                        </div>
                                        <span class="badge bg-success"><?= $assistance['amount'] ? '₱' . number_format($assistance['amount'], 2) : 'Provided' ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-hands-helping fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent assistance records</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Upcoming Reservations -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-calendar-alt me-2"></i>Upcoming Reservations
                    </h5>
                    <a href="<?= base_url('/assistance/reservations') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($upcomingReservations)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($upcomingReservations as $reservation): ?>
                                <div class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= $reservation['full_name'] ?></h6>
                                            <p class="text-muted small mb-1">
                                                <?= $reservation['assistance_type'] ?>
                                            </p>
                                            <small class="text-primary">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('M j, Y', strtotime($reservation['reservation_date'])) ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No upcoming reservations</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="<?= base_url('/pwd-profiles/add') ?>" class="btn btn-primary-custom w-100 h-100 py-3">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <br>
                                Add PWD
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('/assistance/record') ?>" class="btn btn-outline-primary w-100 h-100 py-3">
                                <i class="fas fa-hand-holding-heart fa-2x mb-2"></i>
                                <br>
                                Record Assistance
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('/reports') ?>" class="btn btn-outline-primary w-100 h-100 py-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <br>
                                Generate Reports
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('/pwd-profiles') ?>" class="btn btn-outline-primary w-100 h-100 py-3">
                                <i class="fas fa-list fa-2x mb-2"></i>
                                <br>
                                View All PWDs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>