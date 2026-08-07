<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-wheelchair me-2"></i>Disability Statistics Report
            </h1>
            <p class="text-muted mb-0">
                Generated on <?= $generatedAt ? date('F j, Y \a\t g:i A', strtotime($generatedAt)) : date('F j, Y \a\t g:i A') ?>
                <?php if ($startDate && $endDate): ?>
                    • Period: <?= date('M j, Y', strtotime($startDate)) ?> - <?= date('M j, Y', strtotime($endDate)) ?>
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

    <!-- Executive Summary -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-chart-pie me-2"></i>Executive Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-primary mb-1"><?= $totalPwd ?? 0 ?></h2>
                        <small class="text-muted">Total PWDs Registered</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-success mb-1"><?= count($disabilityStats ?? []) ?></h2>
                        <small class="text-muted">Disability Types</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-info mb-1">
                            <?= $disabilityStats ? max(array_column($disabilityStats, 'count')) : 0 ?>
                        </h2>
                        <small class="text-muted">Most Common Type</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-warning mb-1">
                            <?= $disabilityStats ? number_format(array_sum(array_column($disabilityStats, 'count')) / count($disabilityStats), 1) : 0 ?>
                        </h2>
                        <small class="text-muted">Average per Type</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Disability Distribution -->
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-chart-bar me-2"></i>Disability Type Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($disabilityStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Disability Type</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                        <th>Average Age</th>
                                        <th>Male</th>
                                        <th>Female</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($disabilityStats as $stat): ?>
                                        <tr>
                                            <td>
                                                <span class="fw-semibold"><?= $stat['disability_type'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?= $stat['count'] ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">
                                                    <?= $totalPwd > 0 ? number_format(($stat['count'] / $totalPwd) * 100, 1) : 0 ?>%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= isset($stat['avg_age']) ? number_format($stat['avg_age'], 1) : 'N/A' ?> yrs
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-primary">
                                                    <?= $stat['male_count'] ?? 0 ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <?= $stat['female_count'] ?? 0 ?>
                                                </span>
                                            </td>
                                            <td style="width: 200px;">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar" 
                                                         style="width: <?= $totalPwd > 0 ? ($stat['count'] / $totalPwd) * 100 : 0 ?>%; 
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
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Data Available</h5>
                            <p class="text-muted">No disability statistics found for the selected period.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Key Insights -->
        <div class="col-lg-4">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-lightbulb me-2"></i>Key Insights
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($disabilityStats)): ?>
                        <?php
                        $mostCommon = $disabilityStats[0] ?? null;
                        $leastCommon = end($disabilityStats) ?? null;
                        ?>
                        
                        <div class="insight-item mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-chart-line text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Most Common</h6>
                                    <small class="text-muted">
                                        <?= $mostCommon['disability_type'] ?> (<?= $mostCommon['count'] ?> members)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="insight-item mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-chart-area text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Least Common</h6>
                                    <small class="text-muted">
                                        <?= $leastCommon['disability_type'] ?> (<?= $leastCommon['count'] ?> members)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="insight-item mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-balance-scale text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Gender Distribution</h6>
                                    <small class="text-muted">
                                        <?php
                                        $totalMale = array_sum(array_column($disabilityStats, 'male_count'));
                                        $totalFemale = array_sum(array_column($disabilityStats, 'female_count'));
                                        ?>
                                        Male: <?= $totalMale ?>, Female: <?= $totalFemale ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="insight-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-percentage text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Coverage</h6>
                                    <small class="text-muted">
                                        <?= count($disabilityStats) ?> disability types covered
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

            <!-- Report Information -->
            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-info-circle me-2"></i>Report Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td class="fw-semibold" style="width: 40%;">Report Type:</td>
                            <td>Disability Statistics</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Generated:</td>
                            <td><?= $generatedAt ? date('M j, Y g:i A', strtotime($generatedAt)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Time Period:</td>
                            <td>
                                <?php if ($startDate && $endDate): ?>
                                    <?= date('M j, Y', strtotime($startDate)) ?> - <?= date('M j, Y', strtotime($endDate)) ?>
                                <?php else: ?>
                                    All Time
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Total Records:</td>
                            <td><?= $totalPwd ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Data Source:</td>
                            <td>PWD Management System</td>
                        </tr>
                    </table>
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

    .insight-item {
        border-left: 3px solid var(--primary-color);
        padding-left: 15px;
    }
</style>


<script>
function openPrintView() {
    // Get current filter parameters
    const urlParams = new URLSearchParams(window.location.search);
    const startDate = urlParams.get('start_date') || '';
    const endDate = urlParams.get('end_date') || '';
    const disabilityType = urlParams.get('disability_type') || '';
    
    // Construct print URL - Fixed parameter name
    const printUrl = `<?= base_url('/reports/print') ?>?report_type=disability&start_date=${startDate}&end_date=${endDate}&disability_type=${disabilityType}`;
    
    // Open print view in new window
    const printWindow = window.open(printUrl, 'PrintReport', 'width=1000,height=800,scrollbars=yes');
    
    // Focus the new window
    if (printWindow) {
        printWindow.focus();
    }
}
</script>

<?= $this->endSection() ?>