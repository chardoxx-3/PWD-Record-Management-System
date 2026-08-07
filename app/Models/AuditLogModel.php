<?php namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'action',
        'description',
        'record_id',
        'table_name',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'user_id' => 'required|numeric',
        'action' => 'required|max_length[50]',
        'description' => 'required|max_length[500]',
        'ip_address' => 'required|max_length[45]'
    ];
    protected $validationMessages   = [
        'user_id' => [
            'required' => 'User ID is required'
        ],
        'action' => [
            'required' => 'Action is required'
        ],
        'description' => [
            'required' => 'Description is required'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setTimestamp'];

    protected function setTimestamp(array $data)
    {
        if (!isset($data['data']['created_at']) || empty($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }

    public function getLogsWithUserInfo($limit = 50)
    {
        return $this->select('audit_logs.*, users.username, users.full_name')
                   ->join('users', 'users.id = audit_logs.user_id')
                   ->orderBy('audit_logs.created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getLogsByUser($userId, $limit = 50)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getLogsByAction($action, $limit = 50)
    {
        return $this->where('action', $action)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getLogsByDateRange($startDate, $endDate)
    {
        return $this->where('created_at >=', $startDate)
                   ->where('created_at <=', $endDate)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getRecentActivities($limit = 10)
    {
        return $this->select('audit_logs.*, users.username, users.full_name')
                   ->join('users', 'users.id = audit_logs.user_id')
                   ->orderBy('audit_logs.created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getActionStatistics($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        return $this->select('action, COUNT(*) as count')
                   ->where('created_at >=', $startDate)
                   ->groupBy('action')
                   ->orderBy('count', 'DESC')
                   ->findAll();
    }

    public function getUserActivityStatistics($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        return $this->select('user_id, users.username, users.full_name, COUNT(*) as activity_count')
                   ->join('users', 'users.id = audit_logs.user_id')
                   ->where('audit_logs.created_at >=', $startDate)
                   ->groupBy('user_id')
                   ->orderBy('activity_count', 'DESC')
                   ->findAll();
    }

    public function getLoginStatistics($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        return $this->select("DATE(created_at) as date, COUNT(*) as login_count")
                   ->where('action', 'LOGIN')
                   ->where('created_at >=', $startDate)
                   ->groupBy('DATE(created_at)')
                   ->orderBy('date', 'DESC')
                   ->findAll();
    }

    public function logUserAction($userId, $action, $description, $recordId = null, $tableName = null, $oldValues = null, $newValues = null)
    {
        $logData = [
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'record_id' => $recordId,
            'table_name' => $tableName,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($logData);
    }

    public function cleanupOldLogs($daysToKeep = 90)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-$daysToKeep days"));
        return $this->where('created_at <', $cutoffDate)->delete();
    }

    public function getSystemUsageStats($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        $stats = $this->select("
            COUNT(*) as total_activities,
            COUNT(DISTINCT user_id) as active_users,
            SUM(CASE WHEN action = 'LOGIN' THEN 1 ELSE 0 END) as total_logins,
            SUM(CASE WHEN action = 'CREATE_PWD' THEN 1 ELSE 0 END) as pwd_created,
            SUM(CASE WHEN action = 'RECORD_ASSISTANCE' THEN 1 ELSE 0 END) as assistance_recorded
        ")->where('created_at >=', $startDate)->first();

        return $stats;
    }
}