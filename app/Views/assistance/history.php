<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-history me-2"></i>Assistance History
            </h1>
            <p class="text-muted mb-0">Complete assistance history for <?= $pwdProfile['full_name'] ?></p>
        </div>
        <div>
            <a href="<?= base_url('/assistance') ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
            <a href="<?= base_url('/pwd-profiles/view/' . $pwdProfile['id']) ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-user me-2"></i>View Profile
            </a>
            <a href="<?= base_url('/assistance/record?pwd_id=' . $pwdProfile['id']) ?>" class="btn btn-primary-custom">
                <i class="fas fa-plus me-2"></i>Record Assistance
            </a>
        </div>
    </div>

    <!-- PWD Profile Summary -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-1"><?= $pwdProfile['full_name'] ?></h4>
                            <p class="text-muted mb-1">
                                <span class="badge bg-primary me-2"><?= $pwdProfile['disability_type'] ?></span>
                                <?= $pwdProfile['age'] ?> years old • <?= $pwdProfile['gender'] ?>
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i><?= $pwdProfile['contact_number'] ?>
                                <?php if ($pwdProfile['email']): ?>
                                    • <i class="fas fa-envelope me-1"></i><?= $pwdProfile['email'] ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="row text-center">
                        <div class="col-4">
                            <h3 class="text-primary mb-0"><?= count($assistanceHistory) ?></h3>
                            <small class="text-muted">Assistance Records</small>
                        </div>
                        <div class="col-4">
                            <h3 class="text-success mb-0">₱<?= number_format(array_sum(array_column($assistanceHistory, 'amount')), 2) ?></h3>
                            <small class="text-muted">Total Amount</small>
                        </div>
                        <div class="col-4">
                            <h3 class="text-info mb-0"><?= count($reservationHistory) ?></h3>
                            <small class="text-muted">Reservations</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Assistance History -->
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-hands-helping me-2"></i>Assistance Records
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($assistanceHistory)): ?>
                        <div class="timeline">
                            <?php foreach ($assistanceHistory as $record): ?>
                                <div class="timeline-item mb-4">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <div class="card card-custom">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <h6 class="mb-1"><?= $record['assistance_type'] ?> Assistance</h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            <?= date('F j, Y', strtotime($record['assistance_date'])) ?>
                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <?php if ($record['amount'] > 0): ?>
                                                            <span class="fw-bold text-success">₱<?= number_format($record['amount'], 2) ?></span>
                                                        <?php endif; ?>
                                                        <br>
                                                        <small class="text-muted">
                                                            <?= date('g:i A', strtotime($record['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                <p class="mb-2"><?= $record['description'] ?></p>
                                                <?php if ($record['notes']): ?>
                                                    <div class="bg-light p-2 rounded">
                                                        <small class="text-muted">
                                                            <i class="fas fa-sticky-note me-1"></i>
                                                            <?= $record['notes'] ?>
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- Edit Button -->
                                                <div class="mt-3 text-end">
                                                    <a href="<?= base_url('/assistance/edit/' . $record['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-hands-helping fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Assistance Records</h5>
                            <p class="text-muted">No assistance has been recorded for this PWD member yet.</p>
                            <a href="<?= base_url('/assistance/record?pwd_id=' . $pwdProfile['id']) ?>" class="btn btn-primary-custom">
                                <i class="fas fa-plus me-2"></i>Record First Assistance
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Reservation History & Quick Stats -->
        <div class="col-lg-4">
            <!-- Reservation History -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-calendar-alt me-2"></i>Reservation History
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($reservationHistory)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($reservationHistory as $reservation): ?>
                                <div class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= $reservation['assistance_type'] ?></h6>
                                            <small class="text-muted">
                                                <?= date('M j, Y', strtotime($reservation['reservation_date'])) ?>
                                            </small>
                                            <br>
                                            <small class="text-muted"><?= $reservation['purpose'] ?></small>
                                        </div>
                                        <span class="badge 
                                            <?= $reservation['status'] == 'pending' ? 'bg-warning text-dark' : '' ?>
                                            <?= $reservation['status'] == 'approved' ? 'bg-success' : '' ?>
                                            <?= $reservation['status'] == 'completed' ? 'bg-info' : '' ?>
                                            <?= $reservation['status'] == 'cancelled' ? 'bg-danger' : '' ?>">
                                            <?= $reservation['status'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <i class="fas fa-calendar-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No reservations</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Assistance Statistics -->
            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-chart-pie me-2"></i>Assistance Summary
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    $typeCounts = [];
                    $totalAmount = 0;
                    
                    foreach ($assistanceHistory as $record) {
                        $type = $record['assistance_type'];
                        if (!isset($typeCounts[$type])) {
                            $typeCounts[$type] = 0;
                        }
                        $typeCounts[$type]++;
                        $totalAmount += $record['amount'];
                    }
                    ?>
                    
                    <?php if (!empty($typeCounts)): ?>
                        <div class="mb-3">
                            <h6 class="fw-semibold">By Type:</h6>
                            <?php foreach ($typeCounts as $type => $count): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted"><?= $type ?></span>
                                    <span class="fw-semibold"><?= $count ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if ($totalAmount > 0): ?>
                            <div class="border-top pt-3">
                                <h6 class="fw-semibold">Financial Summary:</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total Amount</span>
                                    <span class="fw-bold text-success">₱<?= number_format($totalAmount, 2) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-2">
                            <p class="text-muted mb-0">No data available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
    }

    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 15px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-color);
    }

    .timeline-content {
        margin-left: 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: -24px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--border-color);
    }
</style>
<?= $this->endSection() ?>