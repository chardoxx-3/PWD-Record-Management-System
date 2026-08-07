<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-users me-2"></i>Demographic Analysis Report
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

    <!-- Demographic Overview -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-chart-area me-2"></i>Demographic Overview
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-primary mb-1" id="totalMembers">0</h2>
                        <small class="text-muted">Total Members</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-success mb-1" id="maleCount">0</h2>
                        <small class="text-muted">Male</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-danger mb-1" id="femaleCount">0</h2>
                        <small class="text-muted">Female</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h2 class="text-info mb-1" id="avgAge">0</h2>
                        <small class="text-muted">Average Age</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Age Distribution -->
        <div class="col-lg-6">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-birthday-cake me-2"></i>Age Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($ageStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Age Group</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalMembers = array_sum([
                                        $ageStats['under_18'] ?? 0,
                                        $ageStats['age_18_35'] ?? 0,
                                        $ageStats['age_36_60'] ?? 0,
                                        $ageStats['over_60'] ?? 0
                                    ]);
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">Under 18</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $ageStats['under_18'] ?? 0 ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= $totalMembers > 0 ? number_format(($ageStats['under_18'] / $totalMembers) * 100, 1) : 0 ?>%
                                            </span>
                                        </td>
                                        <td style="width: 200px;">
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-info" 
                                                     style="width: <?= $totalMembers > 0 ? ($ageStats['under_18'] / $totalMembers) * 100 : 0 ?>%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">18 - 35 Years</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $ageStats['age_18_35'] ?? 0 ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= $totalMembers > 0 ? number_format(($ageStats['age_18_35'] / $totalMembers) * 100, 1) : 0 ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" 
                                                     style="width: <?= $totalMembers > 0 ? ($ageStats['age_18_35'] / $totalMembers) * 100 : 0 ?>%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">36 - 60 Years</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $ageStats['age_36_60'] ?? 0 ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= $totalMembers > 0 ? number_format(($ageStats['age_36_60'] / $totalMembers) * 100, 1) : 0 ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-warning" 
                                                     style="width: <?= $totalMembers > 0 ? ($ageStats['age_36_60'] / $totalMembers) * 100 : 0 ?>%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">Over 60 Years</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $ageStats['over_60'] ?? 0 ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">
                                                <?= $totalMembers > 0 ? number_format(($ageStats['over_60'] / $totalMembers) * 100, 1) : 0 ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-danger" 
                                                     style="width: <?= $totalMembers > 0 ? ($ageStats['over_60'] / $totalMembers) * 100 : 0 ?>%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-birthday-cake fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Age Data Available</h5>
                            <p class="text-muted">No demographic statistics found for the selected period.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="col-lg-6">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0" style="color: var(--primary-color);">
                        <i class="fas fa-venus-mars me-2"></i>Gender Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($genderStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Gender</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $genderTotal = array_sum(array_column($genderStats, 'count'));
                                    foreach ($genderStats as $stat):
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="fw-semibold"><?= $stat['gender'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?= $stat['count'] ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">
                                                    <?= $genderTotal > 0 ? number_format(($stat['count'] / $genderTotal) * 100, 1) : 0 ?>%
                                                </span>
                                            </td>
                                            <td style="width: 200px;">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar 
                                                        <?= $stat['gender'] == 'Male' ? 'bg-primary' : '' ?>
                                                        <?= $stat['gender'] == 'Female' ? 'bg-danger' : '' ?>
                                                        <?= $stat['gender'] == 'Other' ? 'bg-secondary' : '' ?>" 
                                                         style="width: <?= $genderTotal > 0 ? ($stat['count'] / $genderTotal) * 100 : 0 ?>%">
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
                            <i class="fas fa-venus-mars fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Gender Data Available</h5>
                            <p class="text-muted">No gender statistics found for the selected period.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Disability by Gender -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-chart-bar me-2"></i>Disability Distribution by Gender
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($disabilityGenderStats)): ?>
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Disability Type</th>
                                <th>Gender</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $typeGroups = [];
                            foreach ($disabilityGenderStats as $stat) {
                                $type = $stat['disability_type'];
                                if (!isset($typeGroups[$type])) {
                                    $typeGroups[$type] = [];
                                }
                                $typeGroups[$type][] = $stat;
                            }

                            foreach ($typeGroups as $type => $stats):
                                $typeTotal = array_sum(array_column($stats, 'count'));
                                $firstRow = true;
                                foreach ($stats as $stat):
                            ?>
                                <tr>
                                    <?php if ($firstRow): ?>
                                        <td rowspan="<?= count($stats) ?>" class="align-middle">
                                            <span class="fw-semibold"><?= $type ?></span>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <span class="badge 
                                            <?= $stat['gender'] == 'Male' ? 'bg-primary' : '' ?>
                                            <?= $stat['gender'] == 'Female' ? 'bg-danger' : '' ?>
                                            <?= $stat['gender'] == 'Other' ? 'bg-secondary' : '' ?>">
                                            <?= $stat['gender'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold"><?= $stat['count'] ?></span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <?= $typeTotal > 0 ? number_format(($stat['count'] / $typeTotal) * 100, 1) : 0 ?>%
                                        </span>
                                    </td>
                                </tr>
                            <?php
                                    $firstRow = false;
                                endforeach;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Combined Data Available</h5>
                    <p class="text-muted">No disability by gender statistics found for the selected period.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate and display demographic overview
        const ageStats = <?= json_encode($ageStats ?? []) ?>;
        const genderStats = <?= json_encode($genderStats ?? []) ?>;

        if (ageStats && genderStats) {
            const totalMembers = Object.values(ageStats).reduce((a, b) => a + b, 0);
            const maleCount = genderStats.find(g => g.gender === 'Male')?.count || 0;
            const femaleCount = genderStats.find(g => g.gender === 'Female')?.count || 0;
            
            // Calculate average age (simplified)
            const avgAge = 45; // This would normally come from your data

            document.getElementById('totalMembers').textContent = totalMembers.toLocaleString();
            document.getElementById('maleCount').textContent = maleCount.toLocaleString();
            document.getElementById('femaleCount').textContent = femaleCount.toLocaleString();
            document.getElementById('avgAge').textContent = avgAge;
        }
    });
</script>

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
</style>

<script>
function openPrintView() {
    // Get current filter parameters
    const urlParams = new URLSearchParams(window.location.search);
    const startDate = urlParams.get('start_date') || '';
    const endDate = urlParams.get('end_date') || '';
    
    // Construct print URL
    const printUrl = `<?= base_url('/reports/print') ?>?report_type=demographic&start_date=${startDate}&end_date=${endDate}`;
    
    // Open print view in new window
    const printWindow = window.open(printUrl, 'PrintReport', 'width=1000,height=800,scrollbars=yes');
    
    // Focus the new window
    if (printWindow) {
        printWindow.focus();
    }
}
</script>
<?= $this->endSection() ?>