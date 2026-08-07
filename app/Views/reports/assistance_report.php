<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-hands-helping me-2"></i>Assistance Distribution Report
            </h1>
            <p class="text-muted mb-0">
                Generated on <?= $generatedAt ? date('F j, Y \a\t g:i A', strtotime($generatedAt)) : date('F j, Y \a\t g:i A') ?>
                <?php if ($startDate && $endDate): ?>
                    • Period: <?= date('M j, Y', strtotime($startDate)) ?> - <?= date('M j, Y', strtotime($endDate)) ?>
                <?php endif; ?>
                <?php if ($assistanceType): ?>
                    • Type: <?= $assistanceType ?>
                <?php endif; ?>
            </p>
        </div>
        <div>
            <a href="<?= base_url('/reports') ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Reports
            </a>
           <button onclick="openPrintView()" class="btn btn-primary-custom me-2">
    <i class="fas fa-print me-2"></i>Print
</button>

        </div>
    </div>

    <!-- Financial Summary -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-chart-line me-2"></i>Financial Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-primary mb-1"><?= $totalAssistance ?? 0 ?></h2>
                        <small class="text-muted">Total Assistance Records</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-success mb-1">₱<?= number_format($totalAmount ?? 0, 2) ?></h2>
                        <small class="text-muted">Total Amount Disbursed</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-info mb-1">
                            ₱<?= $totalAssistance > 0 ? number_format(($totalAmount ?? 0) / $totalAssistance, 2) : 0 ?>
                        </h2>
                        <small class="text-muted">Average per Record</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-warning mb-1"><?= count($assistanceStats ?? []) ?></h2>
                        <small class="text-muted">Assistance Types</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Assistance Distribution -->
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-chart-pie me-2"></i>Assistance Distribution by Type
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($assistanceStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Assistance Type</th>
                                        <th>Records</th>
                                        <th>Percentage</th>
                                        <th>Total Amount</th>
                                        <th>Average Amount</th>
                                        <th>Disability Types</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($assistanceStats as $stat): ?>
                                        <tr>
                                            <td>
                                                <span class="fw-semibold"><?= $stat['assistance_type'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?= $stat['count'] ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">
                                                    <?= $totalAssistance > 0 ? number_format(($stat['count'] / $totalAssistance) * 100, 1) : 0 ?>%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    ₱<?= number_format($stat['total_amount'] ?? 0, 2) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    ₱<?= number_format($stat['avg_amount'] ?? 0, 2) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= $stat['disability_type'] ?? 'Various' ?>
                                                </small>
                                            </td>
                                            <td style="width: 200px;">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar" 
                                                         style="width: <?= $totalAssistance > 0 ? ($stat['count'] / $totalAssistance) * 100 : 0 ?>%; 
                                                                background-color: var(--primary-color);">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Data Available</h5>
                            <p class="text-muted">No assistance statistics found for the selected period.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="col-lg-4">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-tachometer-alt me-2"></i>Key Metrics
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($assistanceStats)): ?>
                        <?php
                        $financialStats = array_filter($assistanceStats, function($stat) {
                            return $stat['assistance_type'] === 'Financial';
                        });
                        $financialStat = $financialStats ? array_values($financialStats)[0] : null;
                        ?>

                        <div class="metric-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Financial Assistance</span>
                                <span class="fw-bold text-success">
                                    ₱<?= $financialStat ? number_format($financialStat['total_amount'], 2) : '0.00' ?>
                                </span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" 
                                     style="width: <?= $totalAmount > 0 ? (($financialStat['total_amount'] ?? 0) / $totalAmount) * 100 : 0 ?>%">
                                </div>
                            </div>
                        </div>

                        <div class="metric-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Medical Support</span>
                                <span class="fw-bold text-primary">
                                    <?= array_reduce($assistanceStats, function($carry, $item) {
                                        return $carry + ($item['assistance_type'] === 'Medical' ? $item['count'] : 0);
                                    }, 0) ?>
                                </span>
                            </div>
                        </div>

                        <div class="metric-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Educational Aid</span>
                                <span class="fw-bold text-info">
                                    <?= array_reduce($assistanceStats, function($carry, $item) {
                                        return $carry + ($item['assistance_type'] === 'Educational' ? $item['count'] : 0);
                                    }, 0) ?>
                                </span>
                            </div>
                        </div>

                        <div class="metric-item">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Equipment Provided</span>
                                <span class="fw-bold text-warning">
                                    <?= array_reduce($assistanceStats, function($carry, $item) {
                                        return $carry + ($item['assistance_type'] === 'Equipment' ? $item['count'] : 0);
                                    }, 0) ?>
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <p class="text-muted mb-0">No metrics available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Top Beneficiaries -->
            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-trophy me-2"></i>Quick Insights
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($assistanceStats)): ?>
                        <div class="insight-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Most Provided</h6>
                                    <small class="text-muted">
                                        <?= $assistanceStats[0]['assistance_type'] ?? 'N/A' ?> 
                                        (<?= $assistanceStats[0]['count'] ?? 0 ?> records)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="insight-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-money-bill-wave text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Highest Value</h6>
                                    <small class="text-muted">
                                        ₱<?= number_format(max(array_column($assistanceStats, 'total_amount')), 2) ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="insight-item">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-chart-bar text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Coverage Rate</h6>
                                    <small class="text-muted">
                                        <?= count($assistanceStats) ?> assistance types active
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <p class="text-muted mb-0">No insights available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn {
            display: none !important;
        }
        
        .card-custom {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        
        .main-content {
            margin-left: 0 !important;
        }
    }

    .metric-item {
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .metric-item:last-child {
        border-bottom: none;
    }

    .insight-item {
        border-left: 3px solid var(--primary-color);
        padding-left: 15px;
        margin-bottom: 15px;
    }
</style>

<script>
function openPrintView() {
    // Get current filter parameters
    const urlParams = new URLSearchParams(window.location.search);
    const startDate = urlParams.get('start_date') || '';
    const endDate = urlParams.get('end_date') || '';
    const assistanceType = urlParams.get('assistance_type') || '';
    
    // Construct print URL
    const printUrl = `<?= base_url('/reports/print') ?>?report_type=assistance&start_date=${startDate}&end_date=${endDate}&assistance_type=${assistanceType}`;
    
    // Open print view in new window
    const printWindow = window.open(printUrl, 'PrintReport', 'width=1000,height=800,scrollbars=yes');
    
    // Focus the new window
    if (printWindow) {
        printWindow.focus();
    }
}
</script>


<?= $this->endSection() ?>