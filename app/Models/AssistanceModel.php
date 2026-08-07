<?php namespace App\Models;

use CodeIgniter\Model;

class AssistanceModel extends Model
{
    protected $table            = 'assistance_records';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pwd_id',
        'assistance_type',
        'assistance_date',
        'amount',
        'description',
        'notes',
        'status',
        'recorded_by',
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
        'assistance_date' => 'required|valid_date',
        'amount' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'description' => 'required|min_length[10]|max_length[500]',
        'status' => 'required|in_list[completed,pending,cancelled]'
    ];
    protected $validationMessages   = [
        'pwd_id' => [
            'required' => 'PWD selection is required'
        ],
        'assistance_type' => [
            'required' => 'Assistance type is required'
        ],
        'description' => [
            'required' => 'Description is required',
            'min_length' => 'Description must be at least 10 characters long'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setDefaultStatus'];
    protected $beforeUpdate   = ['updateTimestamp'];

    protected function setDefaultStatus(array $data)
    {
        if (!isset($data['data']['status']) || empty($data['data']['status'])) {
            $data['data']['status'] = 'completed';
        }
        return $data;
    }

    protected function updateTimestamp(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getAssistanceWithPWDInfo()
    {
        return $this->select('assistance_records.*, pwd_profiles.full_name, pwd_profiles.disability_type')
                    ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
                    ->orderBy('assistance_records.assistance_date', 'DESC')
                    ->findAll();
    }

    public function getAssistanceByPWD($pwdId)
    {
        return $this->where('pwd_id', $pwdId)
                    ->orderBy('assistance_date', 'DESC')
                    ->findAll();
    }

    public function getAssistanceByTypeAndDateRange($assistanceType, $startDate, $endDate)
    {
        return $this->where('assistance_type', $assistanceType)
                    ->where('assistance_date >=', $startDate)
                    ->where('assistance_date <=', $endDate)
                    ->orderBy('assistance_date', 'ASC')
                    ->findAll();
    }

    public function getTotalAssistanceAmountByPWD($pwdId)
    {
        $result = $this->selectSum('amount')
                      ->where('pwd_id', $pwdId)
                      ->where('status', 'completed')
                      ->first();
        return $result['amount'] ?? 0;
    }

    public function getAssistanceStatsByType($startDate = null, $endDate = null)
    {
        $builder = $this->select('assistance_type, COUNT(*) as count, SUM(amount) as total_amount')
                       ->groupBy('assistance_type')
                       ->orderBy('count', 'DESC');

        if ($startDate && $endDate) {
            $builder->where('assistance_date >=', $startDate)
                   ->where('assistance_date <=', $endDate);
        }

        return $builder->findAll();
    }

    public function getMonthlyAssistanceTrend($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        return $this->select("MONTH(assistance_date) as month, COUNT(*) as count, SUM(amount) as total_amount")
                   ->where('YEAR(assistance_date)', $year)
                   ->where('status', 'completed')
                   ->groupBy('MONTH(assistance_date)')
                   ->orderBy('month', 'ASC')
                   ->findAll();
    }

    public function getRecentAssistance($limit = 10)
    {
        return $this->select('assistance_records.*, pwd_profiles.full_name')
                   ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
                   ->orderBy('assistance_records.created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getTopAssistanceRecipients($limit = 10)
    {
        return $this->select('pwd_id, pwd_profiles.full_name, COUNT(assistance_records.id) as assistance_count, SUM(assistance_records.amount) as total_amount')
                   ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
                   ->where('assistance_records.status', 'completed')
                   ->groupBy('pwd_id')
                   ->orderBy('total_amount', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function countAssistanceByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    public function getAssistanceByRecorder($recordedBy)
    {
        return $this->where('recorded_by', $recordedBy)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getFinancialAssistanceSummary($startDate = null, $endDate = null)
    {
        $builder = $this->select('assistance_type, SUM(amount) as total_amount, COUNT(*) as count')
                       ->where('assistance_type', 'Financial')
                       ->where('status', 'completed');

        if ($startDate && $endDate) {
            $builder->where('assistance_date >=', $startDate)
                   ->where('assistance_date <=', $endDate);
        }

        return $builder->groupBy('assistance_type')->first();
    }
}