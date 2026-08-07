<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demographic Analysis Report - Print</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Base Styles */
        :root {
            --primary-color: #2c5aa0;
            --primary-light: #e8eff9;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-color: #212529;
            --text-muted: #6c757d;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: var(--text-color);
            background: #fff;
        }
        
        /* Print Styles */
        @media print {
            @page {
                size: portrait;
                margin: 0.5in;
            }
            
            body {
                font-size: 11px;
                background: #fff !important;
                color: #000 !important;
            }
            
            .no-print {
                display: none !important;
            }
            
            .print-header {
                margin-bottom: 20px;
                border-bottom: 2px solid var(--primary-color);
                padding-bottom: 10px;
                text-align: center;
            }
            
            .card {
                border: 1px solid var(--border-color) !important;
                margin-bottom: 15px;
                page-break-inside: avoid;
            }
            
            .card-header {
                background: var(--light-bg) !important;
                border-bottom: 1px solid var(--border-color);
                padding: 8px 12px;
                font-weight: 700;
                color: var(--primary-color);
            }
            
            .card-body {
                padding: 12px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 9px;
            }
            
            table th {
                background: var(--light-bg);
                border: 1px solid var(--border-color);
                padding: 5px 6px;
                text-align: left;
                font-weight: 700;
                color: var(--primary-color);
            }
            
            table td {
                border: 1px solid var(--border-color);
                padding: 5px 6px;
            }
            
            .table-borderless td, .table-borderless th {
                border: none !important;
            }
            
            tr:nth-child(even) {
                background-color: rgba(0, 0, 0, 0.02);
            }
            
            .metric-box {
                border: 1px solid var(--border-color);
                padding: 8px;
                text-align: center;
                margin-bottom: 8px;
                background: #fff;
            }
            
            .metric-value {
                font-size: 14px;
                font-weight: 700;
                margin-bottom: 3px;
            }
            
            .metric-label {
                font-size: 9px;
                color: var(--text-muted);
            }
            
            .progress {
                height: 6px;
                background: #f0f0f0;
                border-radius: 3px;
                overflow: hidden;
                margin-top: 3px;
            }
            
            .progress-bar {
                height: 100%;
                background: var(--primary-color);
            }
            
            .badge {
                padding: 3px 6px;
                font-size: 8px;
                font-weight: 700;
                border-radius: 3px;
                background: var(--primary-color);
                color: white;
            }
            
            .text-primary { color: var(--primary-color) !important; }
            .text-success { color: var(--success-color) !important; }
            .text-info { color: var(--info-color) !important; }
            .text-warning { color: var(--warning-color) !important; }
            .text-danger { color: var(--danger-color) !important; }
            .text-muted { color: var(--text-muted) !important; }
            
            .row {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -6px;
            }
            
            .col-md-3 {
                flex: 0 0 25%;
                padding: 0 6px;
            }
            
            .col-lg-6 {
                flex: 0 0 100%;
                padding: 0 6px;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .report-footer {
                margin-top: 15px;
                padding-top: 8px;
                border-top: 1px solid var(--border-color);
                text-align: center;
                font-size: 8px;
                color: var(--text-muted);
            }

            /* Stack columns vertically in portrait mode */
            .col-lg-6 {
                flex: 0 0 100%;
                margin-bottom: 10px;
            }
            
            .fw-semibold { font-weight: 600 !important; }
            
            .bg-primary { background-color: var(--primary-color) !important; }
            .bg-info { background-color: var(--info-color) !important; }
            .bg-success { background-color: var(--success-color) !important; }
            .bg-warning { background-color: var(--warning-color) !important; }
            .bg-danger { background-color: var(--danger-color) !important; }
            .bg-secondary { background-color: var(--text-muted) !important; }
        }
        
        /* Screen Styles */
        @media screen {
            body {
                margin: 20px;
                background: #f5f7fa;
            }
            
            .print-actions {
                text-align: center;
                margin-bottom: 20px;
                padding: 15px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            
            .btn {
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-weight: 500;
                font-size: 14px;
                transition: all 0.3s ease;
            }
            
            .btn-print {
                background: var(--primary-color);
                color: white;
            }
            
            .btn-print:hover {
                background: #1e4a8a;
            }
            
            .btn-close {
                background: var(--text-muted);
                color: white;
                margin-left: 10px;
            }
            
            .btn-close:hover {
                background: #5a6268;
            }
            
            .report-container {
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
                padding: 25px;
                margin-bottom: 30px;
            }
            
            .print-header {
                text-align: center;
                margin-bottom: 25px;
                border-bottom: 2px solid var(--primary-color);
                padding-bottom: 15px;
            }
            
            .print-header h1 {
                color: var(--primary-color);
                margin: 0 0 8px 0;
                font-size: 24px;
                font-weight: 700;
            }
            
            .print-header .subtitle {
                color: var(--text-muted);
                font-size: 14px;
            }
            
            .card {
                border: 1px solid var(--border-color);
                border-radius: 6px;
                margin-bottom: 20px;
                overflow: hidden;
            }
            
            .card-header {
                background: var(--light-bg);
                border-bottom: 1px solid var(--border-color);
                padding: 12px 15px;
                font-weight: 700;
                color: var(--primary-color);
                font-size: 14px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }
            
            table th {
                background: var(--light-bg);
                border: 1px solid var(--border-color);
                padding: 10px 12px;
                text-align: left;
                font-weight: 700;
                color: var(--primary-color);
            }
            
            table td {
                border: 1px solid var(--border-color);
                padding: 10px 12px;
            }
            
            .table-borderless td, .table-borderless th {
                border: none;
            }
            
            tr:nth-child(even) {
                background-color: rgba(0, 0, 0, 0.02);
            }
            
            .metric-box {
                border: 1px solid var(--border-color);
                border-radius: 6px;
                padding: 15px;
                text-align: center;
                margin-bottom: 15px;
                background: #fff;
            }
            
            .metric-value {
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 8px;
            }
            
            .metric-label {
                font-size: 12px;
                color: var(--text-muted);
            }
            
            .progress {
                height: 10px;
                background: #f0f0f0;
                border-radius: 5px;
                overflow: hidden;
                margin-top: 5px;
            }
            
            .progress-bar {
                height: 100%;
                background: var(--primary-color);
            }
            
            .badge {
                padding: 4px 8px;
                font-size: 11px;
                font-weight: 700;
                border-radius: 4px;
                background: var(--primary-color);
                color: white;
            }
            
            .text-primary { color: var(--primary-color) !important; }
            .text-success { color: var(--success-color) !important; }
            .text-info { color: var(--info-color) !important; }
            .text-warning { color: var(--warning-color) !important; }
            .text-danger { color: var(--danger-color) !important; }
            .text-muted { color: var(--text-muted) !important; }
            
            .row {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }
            
            .col-md-3 {
                flex: 0 0 25%;
                padding: 0 10px;
            }
            
            .col-lg-6 {
                flex: 0 0 50%;
                padding: 0 10px;
            }
            
            .report-footer {
                margin-top: 30px;
                padding-top: 15px;
                border-top: 1px solid var(--border-color);
                text-align: center;
                font-size: 11px;
                color: var(--text-muted);
            }
            
            .fw-semibold { font-weight: 600 !important; }
            
            .bg-primary { background-color: var(--primary-color) !important; }
            .bg-info { background-color: var(--info-color) !important; }
            .bg-success { background-color: var(--success-color) !important; }
            .bg-warning { background-color: var(--warning-color) !important; }
            .bg-danger { background-color: var(--danger-color) !important; }
            .bg-secondary { background-color: var(--text-muted) !important; }
        }
    </style>
</head>
<body>
    <!-- Print Actions (only visible on screen) -->
    <div class="print-actions no-print">
        <button onclick="window.print()" class="btn btn-print">
            <i class="fas fa-print me-2"></i>Print Report
        </button>
        <button onclick="window.close()" class="btn btn-close">
            <i class="fas fa-times me-2"></i>Close Window
        </button>
    </div>

    <!-- Report Container -->
    <div class="report-container">
        <!-- Report Header -->
        <header class="print-header">
            <h1>DEMOGRAPHIC ANALYSIS REPORT</h1>
            <div class="subtitle">
                Generated on <?= $generatedAt ? date('F j, Y \a\t g:i A', strtotime($generatedAt)) : date('F j, Y \a\t g:i A') ?>
                <?php if ($startDate && $endDate): ?>
                    • Period: <?= date('M j, Y', strtotime($startDate)) ?> - <?= date('M j, Y', strtotime($endDate)) ?>
                <?php endif; ?>
            </div>
        </header>

        <main>
            <!-- Demographic Overview -->
            <section class="card">
                <div class="card-header">DEMOGRAPHIC OVERVIEW</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-primary"><?= $totalMembers ?? 0 ?></div>
                                <div class="metric-label">Total Members</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-success"><?= $maleCount ?? 0 ?></div>
                                <div class="metric-label">Male</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-danger"><?= $femaleCount ?? 0 ?></div>
                                <div class="metric-label">Female</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-info"><?= $avgAge ?? 0 ?></div>
                                <div class="metric-label">Average Age</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
                <!-- Age Distribution -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">AGE DISTRIBUTION</div>
                        <div class="card-body">
                            <?php if (!empty($ageStats)): ?>
                                <table>
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
                                            <td><strong>Under 18</strong></td>
                                            <td><span class="badge"><?= $ageStats['under_18'] ?? 0 ?></span></td>
                                            <td><?= $totalMembers > 0 ? number_format(($ageStats['under_18'] / $totalMembers) * 100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" 
                                                         style="width: <?= $totalMembers > 0 ? ($ageStats['under_18'] / $totalMembers) * 100 : 0 ?>%">
                                                    </div>
                                                </div>
                                                <small class="text-muted" style="font-size: 7px;">
                                                    <?= $totalMembers > 0 ? number_format(($ageStats['under_18'] / $totalMembers) * 100, 1) : 0 ?>%
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>18 - 35 Years</strong></td>
                                            <td><span class="badge"><?= $ageStats['age_18_35'] ?? 0 ?></span></td>
                                            <td><?= $totalMembers > 0 ? number_format(($ageStats['age_18_35'] / $totalMembers) * 100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" 
                                                         style="width: <?= $totalMembers > 0 ? ($ageStats['age_18_35'] / $totalMembers) * 100 : 0 ?>%">
                                                    </div>
                                                </div>
                                                <small class="text-muted" style="font-size: 7px;">
                                                    <?= $totalMembers > 0 ? number_format(($ageStats['age_18_35'] / $totalMembers) * 100, 1) : 0 ?>%
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>36 - 60 Years</strong></td>
                                            <td><span class="badge"><?= $ageStats['age_36_60'] ?? 0 ?></span></td>
                                            <td><?= $totalMembers > 0 ? number_format(($ageStats['age_36_60'] / $totalMembers) * 100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" 
                                                         style="width: <?= $totalMembers > 0 ? ($ageStats['age_36_60'] / $totalMembers) * 100 : 0 ?>%">
                                                    </div>
                                                </div>
                                                <small class="text-muted" style="font-size: 7px;">
                                                    <?= $totalMembers > 0 ? number_format(($ageStats['age_36_60'] / $totalMembers) * 100, 1) : 0 ?>%
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Over 60 Years</strong></td>
                                            <td><span class="badge"><?= $ageStats['over_60'] ?? 0 ?></span></td>
                                            <td><?= $totalMembers > 0 ? number_format(($ageStats['over_60'] / $totalMembers) * 100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" 
                                                         style="width: <?= $totalMembers > 0 ? ($ageStats['over_60'] / $totalMembers) * 100 : 0 ?>%">
                                                    </div>
                                                </div>
                                                <small class="text-muted" style="font-size: 7px;">
                                                    <?= $totalMembers > 0 ? number_format(($ageStats['over_60'] / $totalMembers) * 100, 1) : 0 ?>%
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                                    <i class="fas fa-birthday-cake fa-2x mb-2"></i>
                                    <h6>No Age Data Available</h6>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Gender Distribution -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">GENDER DISTRIBUTION</div>
                        <div class="card-body">
                            <?php if (!empty($genderStats)): ?>
                                <table>
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
                                                <td><strong><?= $stat['gender'] ?></strong></td>
                                                <td><span class="badge"><?= $stat['count'] ?></span></td>
                                                <td><?= $genderTotal > 0 ? number_format(($stat['count'] / $genderTotal) * 100, 1) : 0 ?>%</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar 
                                                            <?= $stat['gender'] == 'Male' ? 'bg-primary' : '' ?>
                                                            <?= $stat['gender'] == 'Female' ? 'bg-danger' : '' ?>
                                                            <?= $stat['gender'] == 'Other' ? 'bg-secondary' : '' ?>" 
                                                             style="width: <?= $genderTotal > 0 ? ($stat['count'] / $genderTotal) * 100 : 0 ?>%">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted" style="font-size: 7px;">
                                                        <?= $genderTotal > 0 ? number_format(($stat['count'] / $genderTotal) * 100, 1) : 0 ?>%
                                                    </small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                                    <i class="fas fa-venus-mars fa-2x mb-2"></i>
                                    <h6>No Gender Data Available</h6>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disability by Gender -->
            <div class="card">
                <div class="card-header">DISABILITY DISTRIBUTION BY GENDER</div>
                <div class="card-body">
                    <?php if (!empty($disabilityGenderStats)): ?>
                        <table>
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
                                                <strong><?= $type ?></strong>
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
                                        <td><?= $stat['count'] ?></td>
                                        <td><?= $typeTotal > 0 ? number_format(($stat['count'] / $typeTotal) * 100, 1) : 0 ?>%</td>
                                    </tr>
                                <?php
                                        $firstRow = false;
                                    endforeach;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <h6>No Combined Data Available</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="report-footer">
            Generated by PWD Management System • <?= date('F j, Y \a\t g:i A') ?>
        </footer>
    </div>

    <script>
        // Auto-print when page loads (optional)
        window.onload = function() {
            // Uncomment the line below if you want auto-print
            // window.print();
        };
        
        // Close window after printing
        window.onafterprint = function() {
            // Optional: close window after printing
            // window.close();
        };
    </script>
</body>
</html>