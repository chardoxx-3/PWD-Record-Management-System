<?php namespace App\Controllers;

use App\Models\PwdProfileModel;
use App\Models\AssistanceModel;
use App\Models\DisabilityTypeModel;

class Reports extends BaseController
{
    protected $pwdProfileModel;
    protected $assistanceModel;
    protected $disabilityTypeModel;

    public function __construct()
    {
        $this->pwdProfileModel = new PwdProfileModel();
        $this->assistanceModel = new AssistanceModel();
        $this->disabilityTypeModel = new DisabilityTypeModel();
        
        helper(['form', 'url']);
    }

public function index()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $data = [
        'title' => 'Generate Reports',
        'disabilityTypes' => $this->disabilityTypeModel->findAll(), // Keep this for other uses
        'disabilityTypesCount' => $this->disabilityTypeModel->countAll(), // Add count
        'totalPwd' => $this->pwdProfileModel->where('status', 'active')->countAllResults(),
        'totalAssistance' => $this->assistanceModel->countAll(),
        'totalAmount' => $this->assistanceModel->selectSum('amount')->first()['amount'] ?? 0
    ];

    return view('reports/generate', $data);
}

    public function generate()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $reportType = $this->request->getGet('report_type');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $disabilityType = $this->request->getGet('disability_type');
        $assistanceType = $this->request->getGet('assistance_type');

        switch ($reportType) {
            case 'disability':
                return $this->disabilityReport($startDate, $endDate);
            case 'assistance':
                return $this->assistanceReport($startDate, $endDate, $assistanceType);
            case 'demographic':
                return $this->demographicReport($startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'Invalid report type selected.');
        }
    }

    public function disabilityReport($startDate = null, $endDate = null)
    {
        $builder = $this->pwdProfileModel;

        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate)
                   ->where('created_at <=', $endDate);
        }

        $disabilityStats = $builder
            ->select('disability_type, COUNT(*) as count, 
                     AVG(age) as avg_age,
                     SUM(CASE WHEN gender = "Male" THEN 1 ELSE 0 END) as male_count,
                     SUM(CASE WHEN gender = "Female" THEN 1 ELSE 0 END) as female_count')
            ->where('status', 'active')
            ->groupBy('disability_type')
            ->orderBy('count', 'DESC')
            ->findAll();

        $totalPwd = $this->pwdProfileModel->where('status', 'active')->countAllResults();

        $data = [
            'title' => 'Disability Statistics Report',
            'reportType' => 'disability',
            'disabilityStats' => $disabilityStats,
            'totalPwd' => $totalPwd,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => date('Y-m-d H:i:s')
        ];

        if ($this->request->getGet('export') === 'pdf') {
            return $this->exportToPDF($data, 'disability_report');
        }

        return view('reports/disability_report', $data);
    }

    public function assistanceReport($startDate = null, $endDate = null, $assistanceType = null)
    {
        $builder = $this->assistanceModel
            ->select('assistance_type, 
                     COUNT(*) as count, 
                     SUM(amount) as total_amount,
                     AVG(amount) as avg_amount,
                     pwd_profiles.disability_type')
            ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
            ->groupBy('assistance_type, pwd_profiles.disability_type');

        if ($startDate && $endDate) {
            $builder->where('assistance_date >=', $startDate)
                   ->where('assistance_date <=', $endDate);
        }

        if ($assistanceType) {
            $builder->where('assistance_type', $assistanceType);
        }

        $assistanceStats = $builder->findAll();

        $totalAssistance = $this->assistanceModel->countAll();
        $totalAmount = $this->assistanceModel->selectSum('amount')->first()['amount'] ?? 0;

        $data = [
            'title' => 'Assistance Distribution Report',
            'reportType' => 'assistance',
            'assistanceStats' => $assistanceStats,
            'totalAssistance' => $totalAssistance,
            'totalAmount' => $totalAmount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'assistanceType' => $assistanceType,
            'generatedAt' => date('Y-m-d H:i:s')
        ];

        if ($this->request->getGet('export') === 'pdf') {
            return $this->exportToPDF($data, 'assistance_report');
        }

        return view('reports/assistance_report', $data);
    }

    public function demographicReport($startDate = null, $endDate = null)
    {
        $builder = $this->pwdProfileModel;

        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate)
                   ->where('created_at <=', $endDate);
        }

        // Age distribution
        $ageStats = $builder
            ->select('
                SUM(CASE WHEN age < 18 THEN 1 ELSE 0 END) as under_18,
                SUM(CASE WHEN age BETWEEN 18 AND 35 THEN 1 ELSE 0 END) as age_18_35,
                SUM(CASE WHEN age BETWEEN 36 AND 60 THEN 1 ELSE 0 END) as age_36_60,
                SUM(CASE WHEN age > 60 THEN 1 ELSE 0 END) as over_60
            ')
            ->where('status', 'active')
            ->first();

        // Gender distribution
        $genderStats = $builder
            ->select('gender, COUNT(*) as count')
            ->where('status', 'active')
            ->groupBy('gender')
            ->findAll();

        // Disability by gender
        $disabilityGenderStats = $builder
            ->select('disability_type, gender, COUNT(*) as count')
            ->where('status', 'active')
            ->groupBy('disability_type, gender')
            ->findAll();

        $data = [
            'title' => 'Demographic Analysis Report',
            'reportType' => 'demographic',
            'ageStats' => $ageStats,
            'genderStats' => $genderStats,
            'disabilityGenderStats' => $disabilityGenderStats,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => date('Y-m-d H:i:s')
        ];

        if ($this->request->getGet('export') === 'pdf') {
            return $this->exportToPDF($data, 'demographic_report');
        }

        return view('reports/demographic_report', $data);
    }

    public function exportReport()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $format = $this->request->getGet('format');
        $reportType = $this->request->getGet('report_type');

        if (!in_array($format, ['pdf', 'excel'])) {
            return redirect()->back()->with('error', 'Invalid export format.');
        }

        // This would typically use a library like TCPDF or PhpSpreadsheet
        // For now, we'll redirect to the PDF view
        if ($format === 'pdf') {
            return redirect()->to('/reports/generate?report_type=' . $reportType . '&export=pdf');
        }

        return redirect()->back()->with('error', 'Excel export not implemented yet.');
    }

    private function exportToPDF($data, $template)
    {
        // This is a placeholder for PDF generation
        // In a real implementation, you would use TCPDF, Dompdf, or similar
        $html = view('reports/' . $template, $data);
        
        // For now, just return the HTML view
        // In production, you would generate and download PDF
        return $html;
    }

    public function getReportData()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $reportType = $this->request->getGet('report_type');
        $timeframe = $this->request->getGet('timeframe') ?? 'month';

        switch ($timeframe) {
            case 'week':
                $startDate = date('Y-m-d', strtotime('-1 week'));
                break;
            case 'month':
                $startDate = date('Y-m-d', strtotime('-1 month'));
                break;
            case 'year':
                $startDate = date('Y-m-d', strtotime('-1 year'));
                break;
            default:
                $startDate = date('Y-m-d', strtotime('-1 month'));
        }

        $endDate = date('Y-m-d');

        $data = [];

        switch ($reportType) {
            case 'registrations':
                $data = $this->getRegistrationTrends($startDate, $endDate);
                break;
            case 'assistance':
                $data = $this->getAssistanceTrends($startDate, $endDate);
                break;
        }

        return $this->response->setJSON($data);
    }

    private function getRegistrationTrends($startDate, $endDate)
    {
        // This would typically query the database for daily/weekly registration counts
        // For now, return sample data
        return [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'datasets' => [
                [
                    'label' => 'New Registrations',
                    'data' => [5, 8, 12, 7],
                    'backgroundColor' => '#4e73df'
                ]
            ]
        ];
    }

    private function getAssistanceTrends($startDate, $endDate)
    {
        // This would typically query the database for assistance trends
        // For now, return sample data
        return [
            'labels' => ['Financial', 'Medical', 'Educational', 'Rehabilitation', 'Equipment'],
            'datasets' => [
                [
                    'label' => 'Assistance Provided',
                    'data' => [15, 8, 5, 12, 3],
                    'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                ]
            ]
        ];
    }

    // Add this method to your Reports controller
public function printReport()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $reportType = $this->request->getGet('report_type');
    $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');
    $assistanceType = $this->request->getGet('assistance_type');
    $disabilityType = $this->request->getGet('disability_type');

    switch ($reportType) {
        case 'assistance':
            // Assistance report logic
            $builder = $this->assistanceModel
                ->select('assistance_type, 
                         COUNT(*) as count, 
                         SUM(amount) as total_amount,
                         AVG(amount) as avg_amount,
                         pwd_profiles.disability_type')
                ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
                ->groupBy('assistance_type, pwd_profiles.disability_type');

            if ($startDate && $endDate) {
                $builder->where('assistance_date >=', $startDate)
                       ->where('assistance_date <=', $endDate);
            }

            if ($assistanceType) {
                $builder->where('assistance_type', $assistanceType);
            }

            $assistanceStats = $builder->findAll();
            $totalAssistance = $this->assistanceModel->countAll();
            $totalAmount = $this->assistanceModel->selectSum('amount')->first()['amount'] ?? 0;

            $data = [
                'title' => 'Assistance Distribution Report',
                'assistanceStats' => $assistanceStats,
                'totalAssistance' => $totalAssistance,
                'totalAmount' => $totalAmount,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'assistanceType' => $assistanceType,
                'generatedAt' => date('Y-m-d H:i:s')
            ];

            return view('reports/assistance_report_print', $data);

        case 'disability':
            // Disability report logic
            $builder = $this->pwdProfileModel;

            if ($startDate && $endDate) {
                $builder->where('created_at >=', $startDate)
                       ->where('created_at <=', $endDate);
            }

            $disabilityStats = $builder
                ->select('disability_type, COUNT(*) as count, 
                         AVG(age) as avg_age,
                         SUM(CASE WHEN gender = "Male" THEN 1 ELSE 0 END) as male_count,
                         SUM(CASE WHEN gender = "Female" THEN 1 ELSE 0 END) as female_count')
                ->where('status', 'active')
                ->groupBy('disability_type')
                ->orderBy('count', 'DESC')
                ->findAll();

            $totalPwd = $this->pwdProfileModel->where('status', 'active')->countAllResults();

            $data = [
                'title' => 'Disability Statistics Report',
                'disabilityStats' => $disabilityStats,
                'totalPwd' => $totalPwd,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'generatedAt' => date('Y-m-d H:i:s')
            ];

            return view('reports/disability_report_print', $data);

        default:
            return redirect()->back()->with('error', 'Invalid report type for printing.');

            case 'demographic':
    // Demographic report logic
    $builder = $this->pwdProfileModel;

    if ($startDate && $endDate) {
        $builder->where('created_at >=', $startDate)
               ->where('created_at <=', $endDate);
    }

    // Age distribution
    $ageStats = $builder
        ->select('
            SUM(CASE WHEN age < 18 THEN 1 ELSE 0 END) as under_18,
            SUM(CASE WHEN age BETWEEN 18 AND 35 THEN 1 ELSE 0 END) as age_18_35,
            SUM(CASE WHEN age BETWEEN 36 AND 60 THEN 1 ELSE 0 END) as age_36_60,
            SUM(CASE WHEN age > 60 THEN 1 ELSE 0 END) as over_60
        ')
        ->where('status', 'active')
        ->first();

    // Gender distribution
    $genderStats = $builder
        ->select('gender, COUNT(*) as count')
        ->where('status', 'active')
        ->groupBy('gender')
        ->findAll();

    // Disability by gender
    $disabilityGenderStats = $builder
        ->select('disability_type, gender, COUNT(*) as count')
        ->where('status', 'active')
        ->groupBy('disability_type, gender')
        ->findAll();

    // Calculate overview metrics
    $totalMembers = array_sum([
        $ageStats['under_18'] ?? 0,
        $ageStats['age_18_35'] ?? 0,
        $ageStats['age_36_60'] ?? 0,
        $ageStats['over_60'] ?? 0
    ]);
    
    $maleCount = 0;
    $femaleCount = 0;
    foreach ($genderStats as $stat) {
        if ($stat['gender'] === 'Male') {
            $maleCount = $stat['count'];
        } elseif ($stat['gender'] === 'Female') {
            $femaleCount = $stat['count'];
        }
    }

    $data = [
        'title' => 'Demographic Analysis Report',
        'ageStats' => $ageStats,
        'genderStats' => $genderStats,
        'disabilityGenderStats' => $disabilityGenderStats,
        'totalMembers' => $totalMembers,
        'maleCount' => $maleCount,
        'femaleCount' => $femaleCount,
        'avgAge' => 45, // This should be calculated from your actual data
        'startDate' => $startDate,
        'endDate' => $endDate,
        'generatedAt' => date('Y-m-d H:i:s')
    ];

    return view('reports/demographic_report_print', $data);
    }
}
}
