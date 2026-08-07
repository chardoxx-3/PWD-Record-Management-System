<?php namespace App\Models;

use CodeIgniter\Model;

class PwdProfileModel extends Model
{
    protected $table            = 'pwd_profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name',
        'gender',
        'age',
        'birth_date',
        'address',
        'contact_number',
        'email',
        'disability_type',
        'disability_level',
        'medical_notes',
        'identification_number',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_relation',
        'status',
        'registration_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
protected $validationRules      = [
    'full_name' => 'required|min_length[3]|max_length[100]',
    'gender' => 'required|in_list[Male,Female,Other]',
    'age' => 'required|numeric|greater_than[0]',
    'address' => 'required|min_length[5]|max_length[255]',
    'contact_number' => 'required|min_length[10]|max_length[20]',
    'email' => 'permit_empty|valid_email|max_length[100]',
    'disability_type' => 'required|max_length[50]',
    'disability_level' => 'permit_empty|in_list[Mild,Moderate,Severe]',
    'identification_number' => 'permit_empty|max_length[50]',
    'status' => 'required|in_list[active,archived,inactive]'
];
    protected $validationMessages   = [
        'full_name' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 3 characters long'
        ],
        'identification_number' => [
            'is_unique' => 'This identification number is already registered'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setRegistrationDate'];
    protected $beforeUpdate   = ['updateTimestamp'];

    protected function setRegistrationDate(array $data)
    {
        if (!isset($data['data']['registration_date']) || empty($data['data']['registration_date'])) {
            $data['data']['registration_date'] = date('Y-m-d');
        }
        return $data;
    }

    protected function updateTimestamp(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getAllActivePWD()
    {
        return $this->where('status', 'active')->orderBy('full_name', 'ASC')->findAll();
    }

    public function getPWDByDisabilityType($disabilityType)
    {
        return $this->where('disability_type', $disabilityType)
                    ->where('status', 'active')
                    ->orderBy('full_name', 'ASC')
                    ->findAll();
    }

    public function searchPWD($searchTerm)
    {
        return $this->groupStart()
                    ->like('full_name', $searchTerm)
                    ->orLike('contact_number', $searchTerm)
                    ->orLike('identification_number', $searchTerm)
                    ->orLike('address', $searchTerm)
                    ->groupEnd()
                    ->where('status', 'active')
                    ->orderBy('full_name', 'ASC')
                    ->findAll();
    }

    public function getPWDStatsByDisability()
    {
        return $this->select('disability_type, COUNT(*) as count')
                    ->where('status', 'active')
                    ->groupBy('disability_type')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    public function getPWDStatsByGender()
    {
        return $this->select('gender, COUNT(*) as count')
                    ->where('status', 'active')
                    ->groupBy('gender')
                    ->findAll();
    }

    public function getPWDStatsByAgeGroup()
    {
        return $this->select("
            SUM(CASE WHEN age < 18 THEN 1 ELSE 0 END) as under_18,
            SUM(CASE WHEN age BETWEEN 18 AND 35 THEN 1 ELSE 0 END) as age_18_35,
            SUM(CASE WHEN age BETWEEN 36 AND 60 THEN 1 ELSE 0 END) as age_36_60,
            SUM(CASE WHEN age > 60 THEN 1 ELSE 0 END) as over_60
        ")->where('status', 'active')->first();
    }

    public function getRecentRegistrations($limit = 10)
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getPWDWithAssistanceCount()
    {
        return $this->select('pwd_profiles.*, COUNT(assistance_records.id) as assistance_count')
                    ->join('assistance_records', 'assistance_records.pwd_id = pwd_profiles.id', 'left')
                    ->where('pwd_profiles.status', 'active')
                    ->groupBy('pwd_profiles.id')
                    ->orderBy('assistance_count', 'DESC')
                    ->findAll();
    }

    public function archivePWD($pwdId)
    {
        return $this->update($pwdId, ['status' => 'archived']);
    }

    public function activatePWD($pwdId)
    {
        return $this->update($pwdId, ['status' => 'active']);
    }

    public function countActivePWD()
    {
        return $this->where('status', 'active')->countAllResults();
    }

    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    public function getPWDByIdentificationNumber($identificationNumber)
    {
        return $this->where('identification_number', $identificationNumber)->first();
    }

    public function getPWDByAgeRange($minAge, $maxAge)
    {
        return $this->where('age >=', $minAge)
                    ->where('age <=', $maxAge)
                    ->where('status', 'active')
                    ->orderBy('age', 'ASC')
                    ->findAll();
    }
}