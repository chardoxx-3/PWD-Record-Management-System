<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: var(--primary-color);">
                <i class="fas fa-chart-bar me-2"></i>Generate Reports
            </h1>
            <p class="text-muted mb-0">Generate comprehensive reports and analytics for PWD management.</p>
        </div>
    </div>

    <!-- Report Types -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-custom h-100 text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-wheelchair fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title">Disability Report</h5>
                    <p class="text-muted">Statistics by disability type and distribution</p>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#disabilityReportModal">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-custom h-100 text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-hands-helping fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title">Assistance Report</h5>
                    <p class="text-muted">Assistance distribution and financial summary</p>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#assistanceReportModal">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-custom h-100 text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                    <h5 class="card-title">Demographic Report</h5>
                    <p class="text-muted">Age, gender, and location analysis</p>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#demographicReportModal">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Statistics -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">
                <i class="fas fa-tachometer-alt me-2"></i>Quick Statistics
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h3 class="text-primary mb-1" id="totalPwd"><?= number_format($totalPwd ?? 0) ?></h3>
                        <small class="text-muted">Total PWDs</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h3 class="text-success mb-1" id="totalAssistance"><?= number_format($totalAssistance ?? 0) ?></h3>
                        <small class="text-muted">Assistance Records</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h3 class="text-info mb-1" id="totalAmount">₱<?= number_format($totalAmount ?? 0, 2) ?></h3>
                        <small class="text-muted">Total Assistance</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="border rounded p-3">
                        <h3 class="text-warning mb-1" id="disabilityTypes"><?= number_format($disabilityTypesCount ?? 0) ?></h3>
                        <small class="text-muted">Disability Types</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Disability Report Modal -->
<div class="modal fade" id="disabilityReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--primary-color);">
                    <i class="fas fa-wheelchair me-2"></i>Disability Statistics Report
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/reports/generate') ?>" method="get">
                <input type="hidden" name="report_type" value="disability">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="disability_start_date" class="form-label fw-semibold">Start Date</label>
                                <input type="date" class="form-control form-control-custom" id="disability_start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="disability_end_date" class="form-label fw-semibold">End Date</label>
                                <input type="date" class="form-control form-control-custom" id="disability_end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info alert-custom">
                        <i class="fas fa-info-circle me-2"></i>
                        This report will show disability type distribution, age groups, and gender statistics.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assistance Report Modal -->
<div class="modal fade" id="assistanceReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--primary-color);">
                    <i class="fas fa-hands-helping me-2"></i>Assistance Distribution Report
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/reports/generate') ?>" method="get">
                <input type="hidden" name="report_type" value="assistance">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assistance_start_date" class="form-label fw-semibold">Start Date</label>
                                <input type="date" class="form-control form-control-custom" id="assistance_start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assistance_end_date" class="form-label fw-semibold">End Date</label>
                                <input type="date" class="form-control form-control-custom" id="assistance_end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="assistance_type_filter" class="form-label fw-semibold">Assistance Type</label>
                        <select class="form-select form-control-custom" id="assistance_type_filter" name="assistance_type">
                            <option value="">All Types</option>
                            <option value="Financial">Financial</option>
                            <option value="Medical">Medical</option>
                            <option value="Educational">Educational</option>
                            <option value="Rehabilitation">Rehabilitation</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="alert alert-info alert-custom">
                        <i class="fas fa-info-circle me-2"></i>
                        This report will show assistance distribution by type, financial summaries, and trends.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Demographic Report Modal -->
<div class="modal fade" id="demographicReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--primary-color);">
                    <i class="fas fa-users me-2"></i>Demographic Analysis Report
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/reports/generate') ?>" method="get">
                <input type="hidden" name="report_type" value="demographic">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="demographic_start_date" class="form-label fw-semibold">Start Date</label>
                                <input type="date" class="form-control form-control-custom" id="demographic_start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="demographic_end_date" class="form-label fw-semibold">End Date</label>
                                <input type="date" class="form-control form-control-custom" id="demographic_end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info alert-custom">
                        <i class="fas fa-info-circle me-2"></i>
                        This report will show age distribution, gender statistics, and disability by demographic factors.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default dates for all modals
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        
        const formatDate = (date) => date.toISOString().split('T')[0];
        
        // Set default dates for all date inputs
        document.querySelectorAll('input[type="date"]').forEach(input => {
            if (input.id.includes('start_date')) {
                input.value = formatDate(firstDay);
            }
            if (input.id.includes('end_date')) {
                input.value = formatDate(today);
            }
        });
    });
</script>
<?= $this->endSection() ?>