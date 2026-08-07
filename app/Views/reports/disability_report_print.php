<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disability Statistics Report - Print</title>
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
            
            .col-lg-8 {
                flex: 0 0 100%;
                padding: 0 6px;
            }
            
            .col-lg-4 {
                flex: 0 0 100%;
                padding: 0 6px;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .insight-item {
                border-left: 2px solid var(--primary-color);
                padding-left: 8px;
                margin-bottom: 8px;
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
            .col-lg-8, .col-lg-4 {
                flex: 0 0 100%;
                margin-bottom: 10px;
            }
            
            .d-flex {
                display: flex !important;
            }
            
            .align-items-center {
                align-items: center !important;
            }
            
            .mb-0 { margin-bottom: 0 !important; }
            .mb-1 { margin-bottom: 4px !important; }
            .mb-2 { margin-bottom: 8px !important; }
            .mb-3 { margin-bottom: 12px !important; }
            .mb-4 { margin-bottom: 16px !important; }
            
            .me-2 { margin-right: 8px !important; }
            
            .p-2 { padding: 8px !important; }
            .p-3 { padding: 12px !important; }
            
            .rounded { border-radius: 4px !important; }
            .rounded-circle { border-radius: 50% !important; }
            
            .bg-primary { background-color: var(--primary-color) !important; }
            .bg-opacity-10 { opacity: 0.1; }
            .bg-white { background-color: #fff !important; }
            
            .fw-semibold { font-weight: 600 !important; }
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
                transition: transform 0.2s ease;
            }
            
            .metric-box:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                transition: width 0.5s ease;
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
            
            .col-lg-8 {
                flex: 0 0 66.666667%;
                padding: 0 10px;
            }
            
            .col-lg-4 {
                flex: 0 0 33.333333%;
                padding: 0 10px;
            }
            
            .insight-item {
                border-left: 3px solid var(--primary-color);
                padding-left: 15px;
                margin-bottom: 15px;
            }
            
            .insight-item h6 {
                font-size: 13px;
                margin-bottom: 5px;
            }
            
            .insight-item small {
                color: var(--text-muted);
            }
            
            .report-footer {
                margin-top: 30px;
                padding-top: 15px;
                border-top: 1px solid var(--border-color);
                text-align: center;
                font-size: 11px;
                color: var(--text-muted);
            }
            
            .d-flex {
                display: flex !important;
            }
            
            .align-items-center {
                align-items: center !important;
            }
            
            .mb-0 { margin-bottom: 0 !important; }
            .mb-1 { margin-bottom: 4px !important; }
            .mb-2 { margin-bottom: 8px !important; }
            .mb-3 { margin-bottom: 12px !important; }
            .mb-4 { margin-bottom: 16px !important; }
            
            .me-2 { margin-right: 8px !important; }
            
            .p-2 { padding: 8px !important; }
            .p-3 { padding: 12px !important; }
            
            .rounded { border-radius: 4px !important; }
            .rounded-circle { border-radius: 50% !important; }
            
            .bg-primary { background-color: var(--primary-color) !important; }
            .bg-opacity-10 { opacity: 0.1; }
            .bg-white { background-color: #fff !important; }
            
            .fw-semibold { font-weight: 600 !important; }
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
            <h1>DISABILITY STATISTICS REPORT</h1>
            <div class="subtitle">
                Generated on <?= $generatedAt ? date('F j, Y \a\t g:i A', strtotime($generatedAt)) : date('F j, Y \a\t g:i A') ?>
                <?php if ($startDate && $endDate): ?>
                    • Period: <?= date('M j, Y', strtotime($startDate)) ?> - <?= date('M j, Y', strtotime($endDate)) ?>
                <?php endif; ?>
            </div>
        </header>

        <main>
            <!-- Executive Summary -->
            <section class="card">
                <div class="card-header">EXECUTIVE SUMMARY</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-primary"><?= $totalPwd ?? 0 ?></div>
                                <div class="metric-label">Total PWDs Registered</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-success"><?= count($disabilityStats ?? []) ?></div>
                                <div class="metric-label">Disability Types</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-info">
                                    <?= $disabilityStats ? max(array_column($disabilityStats, 'count')) : 0 ?>
                                </div>
                                <div class="metric-label">Most Common Type</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-warning">
                                    <?= $disabilityStats ? number_format(array_sum(array_column($disabilityStats, 'count')) / count($disabilityStats), 1) : 0 ?>
                                </div>
                                <div class="metric-label">Average per Type</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
                <!-- Disability Distribution -->
<!-- Disability Distribution -->
<section class="col-lg-8">
    <div class="card">
        <div class="card-header">DISABILITY TYPE DISTRIBUTION</div>
        <div class="card-body">
            <?php if (!empty($disabilityStats)): ?>
                <table>
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
                                <td><strong><?= $stat['disability_type'] ?></strong></td>
                                <td><span class="badge"><?= $stat['count'] ?></span></td>
                                <td>
                                    <?= $totalPwd > 0 ? number_format(($stat['count'] / $totalPwd) * 100, 1) : 0 ?>%
                                </td>
                                <td><?= isset($stat['avg_age']) ? number_format($stat['avg_age'], 1) : 'N/A' ?> yrs</td>
                                <td><span class="text-primary"><?= $stat['male_count'] ?? 0 ?></span></td>
                                <td><span class="text-danger"><?= $stat['female_count'] ?? 0 ?></span></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" 
                                             style="width: <?= $totalPwd > 0 ? ($stat['count'] / $totalPwd) * 100 : 0 ?>%">
                                        </div>
                                    </div>
                                    <small class="text-muted" style="font-size: 8px;">
                                        <?= $totalPwd > 0 ? number_format(($stat['count'] / $totalPwd) * 100, 1) : 0 ?>%
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 30px; color: var(--text-muted);">
                    <i class="fas fa-chart-bar fa-3x mb-3"></i>
                    <h5>No Data Available</h5>
                    <p>No disability statistics found for the selected period.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

                <!-- Key Insights & Information -->
                <aside class="col-lg-4">
                    <div class="card">
                        <div class="card-header">KEY INSIGHTS</div>
                        <div class="card-body">
                            <?php if (!empty($disabilityStats)): ?>
                                <?php
                                $mostCommon = $disabilityStats[0] ?? null;
                                $leastCommon = end($disabilityStats) ?? null;
                                $totalMale = array_sum(array_column($disabilityStats, 'male_count'));
                                $totalFemale = array_sum(array_column($disabilityStats, 'female_count'));
                                ?>
                                
                                <div class="insight-item">
                                    <h6>Most Common</h6>
                                    <small><?= $mostCommon['disability_type'] ?? 'N/A' ?> (<?= $mostCommon['count'] ?? 0 ?> members)</small>
                                </div>

                                <div class="insight-item">
                                    <h6>Least Common</h6>
                                    <small><?= $leastCommon['disability_type'] ?? 'N/A' ?> (<?= $leastCommon['count'] ?? 0 ?> members)</small>
                                </div>

                                <div class="insight-item">
                                    <h6>Gender Distribution</h6>
                                    <small>Male: <?= $totalMale ?>, Female: <?= $totalFemale ?></small>
                                </div>

                                <div class="insight-item">
                                    <h6>Coverage</h6>
                                    <small><?= count($disabilityStats) ?> disability types covered</small>
                                </div>
                            <?php else: ?>
                                <div style="text-align: center; color: var(--text-muted); padding: 15px 0;">
                                    No insights available
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">REPORT INFORMATION</div>
                        <div class="card-body">
                            <table class="table-borderless">
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
                </aside>
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