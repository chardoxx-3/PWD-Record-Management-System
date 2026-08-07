<?php namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table            = 'reservations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pwd_id',
        'assistance_type',
        'reservation_date',
        'purpose',
        'notes',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'completed_at',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'pwd_id' => 'required|numeric',
        'assistance_type' => 'required|in_list[Financial,Medical,Educational,Rehabilitation,Equipment,Other]',
        'reservation_date' => 'required|valid_date',
        'purpose' => 'required|min_length[10]|max_length[500]',
        'status' => 'required|in_list[pending,approved,completed,cancelled]'
    ];
    protected $validationMessages   = [
        'pwd_id' => [
            'required' => 'PWD selection is required'
        ],
        'reservation_date' => [
            'required' => 'Reservation date is required',
            'valid_date' => 'Please provide a valid reservation date'
        ],
        'purpose' => [
            'required' => 'Purpose is required',
            'min_length' => 'Purpose must be at least 10 characters long'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setDefaultStatus'];
    protected $beforeUpdate   = ['updateTimestamp', 'setApprovalDate'];

    protected function setDefaultStatus(array $data)
    {
        if (!isset($data['data']['status']) || empty($data['data']['status'])) {
            $data['data']['status'] = 'pending';
        }
        return $data;
    }

    protected function updateTimestamp(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function setApprovalDate(array $data)
    {
        if (isset($data['data']['status']) && $data['data']['status'] === 'approved' && !isset($data['data']['approved_at'])) {
            $data['data']['approved_at'] = date('Y-m-d H:i:s');
        }
        
        if (isset($data['data']['status']) && $data['data']['status'] === 'completed' && !isset($data['data']['completed_at'])) {
            $data['data']['completed_at'] = date('Y-m-d H:i:s');
        }
        
        return $data;
    }

    public function getReservationsWithPWDInfo($status = null)
    {
        $builder = $this->select('reservations.*, pwd_profiles.full_name, pwd_profiles.contact_number')
                       ->join('pwd_profiles', 'pwd_profiles.id = reservations.pwd_id')
                       ->orderBy('reservations.reservation_date', 'ASC');

        if ($status) {
            $builder->where('reservations.status', $status);
        }

        return $builder->findAll();
    }

    public function getUpcomingReservations($days = 7)
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+$days days"));

        return $this->select('reservations.*, pwd_profiles.full_name, pwd_profiles.contact_number')
                   ->join('pwd_profiles', 'pwd_profiles.id = reservations.pwd_id')
                   ->where('reservations.reservation_date >=', $startDate)
                   ->where('reservations.reservation_date <=', $endDate)
                   ->where('reservations.status', 'approved')
                   ->orderBy('reservations.reservation_date', 'ASC')
                   ->findAll();
    }

    public function getPendingReservations()
    {
        return $this->where('status', 'pending')
                   ->orderBy('created_at', 'ASC')
                   ->findAll();
    }

    public function getReservationsByPWD($pwdId)
    {
        return $this->where('pwd_id', $pwdId)
                   ->orderBy('reservation_date', 'DESC')
                   ->findAll();
    }

    public function approveReservation($reservationId, $approvedBy)
    {
        return $this->update($reservationId, [
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function completeReservation($reservationId)
    {
        return $this->update($reservationId, [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function cancelReservation($reservationId)
    {
        return $this->update($reservationId, [
            'status' => 'cancelled'
        ]);
    }

    public function getReservationStatsByStatus()
    {
        return $this->select('status, COUNT(*) as count')
                   ->groupBy('status')
                   ->findAll();
    }

    public function getReservationStatsByType($startDate = null, $endDate = null)
    {
        $builder = $this->select('assistance_type, COUNT(*) as count')
                       ->groupBy('assistance_type')
                       ->orderBy('count', 'DESC');

        if ($startDate && $endDate) {
            $builder->where('reservation_date >=', $startDate)
                   ->where('reservation_date <=', $endDate);
        }

        return $builder->findAll();
    }

    public function getOverdueReservations()
    {
        $today = date('Y-m-d');

        return $this->select('reservations.*, pwd_profiles.full_name')
                   ->join('pwd_profiles', 'pwd_profiles.id = reservations.pwd_id')
                   ->where('reservations.reservation_date <', $today)
                   ->where('reservations.status', 'approved')
                   ->orderBy('reservations.reservation_date', 'ASC')
                   ->findAll();
    }

    public function countReservationsByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    public function getMonthlyReservationTrend($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        return $this->select("MONTH(reservation_date) as month, COUNT(*) as count")
                   ->where('YEAR(reservation_date)', $year)
                   ->groupBy('MONTH(reservation_date)')
                   ->orderBy('month', 'ASC')
                   ->findAll();
    }

    public function getReservationsRequiringAction()
    {
        $today = date('Y-m-d');

        // Get pending reservations and approved reservations for today or past dates
        return $this->select('reservations.*, pwd_profiles.full_name')
                   ->join('pwd_profiles', 'pwd_profiles.id = reservations.pwd_id')
                   ->groupStart()
                   ->where('reservations.status', 'pending')
                   ->orGroupStart()
                   ->where('reservations.status', 'approved')
                   ->where('reservations.reservation_date <=', $today)
                   ->groupEnd()
                   ->groupEnd()
                   ->orderBy('reservations.reservation_date', 'ASC')
                   ->findAll();
    }
}