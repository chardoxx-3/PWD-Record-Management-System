<?php namespace App\Controllers;

use App\Models\PwdProfileModel;
use App\Models\AssistanceModel;
use App\Models\DisabilityTypeModel;
use App\Models\ReservationModel;

class Dashboard extends BaseController
{
    protected $pwdProfileModel;
    protected $assistanceModel;
    protected $disabilityTypeModel;
    protected $reservationModel;

    public function __construct()
    {
        $this->pwdProfileModel = new PwdProfileModel();
        $this->assistanceModel = new AssistanceModel();
        $this->disabilityTypeModel = new DisabilityTypeModel();
        $this->reservationModel = new ReservationModel();
        
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get dashboard statistics
        $totalPwd = $this->pwdProfileModel->where('status', 'active')->countAllResults();
        $totalAssistance = $this->assistanceModel->countAll();
        $totalReservations = $this->reservationModel->where('status', 'pending')->countAllResults();
        
        // Get disability type distribution
        $disabilityStats = $this->pwdProfileModel
            ->select('disability_type, COUNT(*) as count')
            ->where('status', 'active')
            ->groupBy('disability_type')
            ->findAll();

        // Recent assistance activities
        $recentAssistance = $this->assistanceModel
            ->select('assistance_records.*, pwd_profiles.full_name')
            ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
            ->orderBy('assistance_records.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        // Upcoming reservations
        $upcomingReservations = $this->reservationModel
            ->select('reservations.*, pwd_profiles.full_name')
            ->join('pwd_profiles', 'pwd_profiles.id = reservations.pwd_id')
            ->where('reservations.reservation_date >=', date('Y-m-d'))
            ->where('reservations.status', 'pending')
            ->orderBy('reservations.reservation_date', 'ASC')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => 'Dashboard - PWD Management System',
            'totalPwd' => $totalPwd,
            'totalAssistance' => $totalAssistance,
            'totalReservations' => $totalReservations,
            'disabilityStats' => $disabilityStats,
            'recentAssistance' => $recentAssistance,
            'upcomingReservations' => $upcomingReservations
        ];

        return view('dashboard/index', $data);
    }

    public function getStatistics()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $timeframe = $this->request->getGet('timeframe') ?? 'month';

        // Get statistics based on timeframe
        $stats = $this->generateStatistics($timeframe);

        return $this->response->setJSON($stats);
    }

    private function generateStatistics($timeframe)
    {
        // This is a simplified version - you can expand based on your needs
        $currentDate = date('Y-m-d');
        
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

        $newRegistrations = $this->pwdProfileModel
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $currentDate)
            ->countAllResults();

        $assistanceProvided = $this->assistanceModel
            ->where('assistance_date >=', $startDate)
            ->where('assistance_date <=', $currentDate)
            ->countAllResults();

        return [
            'new_registrations' => $newRegistrations,
            'assistance_provided' => $assistanceProvided,
            'timeframe' => $timeframe
        ];
    }
}