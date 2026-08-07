<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistance Distribution Report - Print</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Base Styles */
        :root {
            --primary-color: #2c5aa0;
            --primary-light: #e8eff9;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
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
            
            .text-primary { color: var(--primary-color) !important; }
            .text-success { color: var(--success-color) !important; }
            .text-info { color: var(--info-color) !important; }
            .text-warning { color: var(--warning-color) !important; }
            
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
            
            .text-primary { color: var(--primary-color) !important; }
            .text-success { color: var(--success-color) !important; }
            .text-info { color: var(--info-color) !important; }
            .text-warning { color: var(--warning-color) !important; }
            
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
        }
    </style>
</head>
<body>
    <!-- Print Actions (only visible on screen) -->
    <div class="print-actions no-print">
        <button onclick="window.print()" class="btn btn-print">
            🖨️ Print Report
        </button>
        <button onclick="window.close()" class="btn btn-close">
            ✕ Close Window
        </button>
    </div>

    <!-- Report Container -->
    <div class="report-container">
        <!-- Report Header -->
        <header class="print-header">
            <h1>ASSISTANCE DISTRIBUTION REPORT</h1>
            <div class="subtitle">
                Generated on <?= $generatedAt ? date('F j, Y \a\t g:i A', strtotime($generatedAt)) : date('F j, Y \a\t g:i A') ?>
                <?php if ($startDate && $endDate): ?>
                    • Period: <?= date('M j, Y', strtotime($startDate)) ?> - <?= date('M j, Y', strtotime($endDate)) ?>
                <?php endif; ?>
                <?php if ($assistanceType): ?>
                    • Type: <?= $assistanceType ?>
                <?php endif; ?>
            </div>
        </header>

        <main>
            <!-- Financial Summary -->
            <section class="card">
                <div class="card-header">FINANCIAL SUMMARY</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-primary"><?= $totalAssistance ?? 0 ?></div>
                                <div class="metric-label">Total Assistance Records</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-success">₱<?= number_format($totalAmount ?? 0, 2) ?></div>
                                <div class="metric-label">Total Amount Disbursed</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-info">
                                    ₱<?= $totalAssistance > 0 ? number_format(($totalAmount ?? 0) / $totalAssistance, 2) : 0 ?>
                                </div>
                                <div class="metric-label">Average per Record</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-box">
                                <div class="metric-value text-warning"><?= count($assistanceStats ?? []) ?></div>
                                <div class="metric-label">Assistance Types</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
                <!-- Assistance Distribution -->
                <section class="col-lg-8">
                    <div class="card">
                        <div class="card-header">ASSISTANCE DISTRIBUTION BY TYPE</div>
                        <div class="card-body">
                            <?php if (!empty($assistanceStats)): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Assistance Type</th>
                                            <th>Records</th>
                                            <th>Percentage</th>
                                            <th>Total Amount</th>
                                            <th>Average Amount</th>
                                            <th>Disability Types</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($assistanceStats as $stat): ?>
                                            <tr>
                                                <td><strong><?= $stat['assistance_type'] ?></strong></td>
                                                <td><?= $stat['count'] ?></td>
                                                <td>
                                                    <?= $totalAssistance > 0 ? number_format(($stat['count'] / $totalAssistance) * 100, 1) : 0 ?>%
                                                    <div class="progress">
                                                        <div class="progress-bar" 
                                                             style="width: <?= $totalAssistance > 0 ? ($stat['count'] / $totalAssistance) * 100 : 0 ?>%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><strong>₱<?= number_format($stat['total_amount'] ?? 0, 2) ?></strong></td>
                                                <td>₱<?= number_format($stat['avg_amount'] ?? 0, 2) ?></td>
                                                <td><small><?= $stat['disability_type'] ?? 'Various' ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div style="text-align: center; padding: 30px; color: var(--text-muted);">
                                    <i class="fas fa-chart-pie fa-3x mb-3"></i>
                                    <h5>No Data Available</h5>
                                    <p>No assistance statistics found for the selected period.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Key Metrics & Insights -->
                <aside class="col-lg-4">
                    <div class="card">
                        <div class="card-header">KEY METRICS</div>
                        <div class="card-body">
                            <?php if (!empty($assistanceStats)): ?>
                                <?php
                                $financialStats = array_filter($assistanceStats, function($stat) {
                                    return $stat['assistance_type'] === 'Financial';
                                });
                                $financialStat = $financialStats ? array_values($financialStats)[0] : null;
                                ?>

                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span>Financial Assistance</span>
                                        <strong>₱<?= $financialStat ? number_format($financialStat['total_amount'], 2) : '0.00' ?></strong>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" 
                                             style="width: <?= $totalAmount > 0 ? (($financialStat['total_amount'] ?? 0) / $totalAmount) * 100 : 0 ?>%">
                                        </div>
                                    </div>
                                </div>

                                <div style="margin-bottom: 10px;">
                                    <strong>Medical Support:</strong> 
                                    <?= array_reduce($assistanceStats, function($carry, $item) {
                                        return $carry + ($item['assistance_type'] === 'Medical' ? $item['count'] : 0);
                                    }, 0) ?> records
                                </div>

                                <div style="margin-bottom: 10px;">
                                    <strong>Educational Aid:</strong> 
                                    <?= array_reduce($assistanceStats, function($carry, $item) {
                                        return $carry + ($item['assistance_type'] === 'Educational' ? $item['count'] : 0);
                                    }, 0) ?> records
                                </div>

                                <div>
                                    <strong>Equipment Provided:</strong> 
                                    <?= array_reduce($assistanceStats, function($carry, $item) {
                                        return $carry + ($item['assistance_type'] === 'Equipment' ? $item['count'] : 0);
                                    }, 0) ?> records
                                </div>
                            <?php else: ?>
                                <div style="text-align: center; color: var(--text-muted); padding: 15px 0;">
                                    No metrics available
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">QUICK INSIGHTS</div>
                        <div class="card-body">
                            <?php if (!empty($assistanceStats)): ?>
                                <div class="insight-item">
                                    <h6>Most Provided</h6>
                                    <small><?= $assistanceStats[0]['assistance_type'] ?? 'N/A' ?> 
                                    (<?= $assistanceStats[0]['count'] ?? 0 ?> records)</small>
                                </div>

                                <div class="insight-item">
                                    <h6>Highest Value</h6>
                                    <small>₱<?= number_format(max(array_column($assistanceStats, 'total_amount')), 2) ?></small>
                                </div>

                                <div class="insight-item">
                                    <h6>Coverage Rate</h6>
                                    <small><?= count($assistanceStats) ?> assistance types active</small>
                                </div>
                            <?php else: ?>
                                <div style="text-align: center; color: var(--text-muted); padding: 15px 0;">
                                    No insights available
                                </div>
                            <?php endif; ?>
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