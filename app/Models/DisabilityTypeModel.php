<?php namespace App\Models;

use CodeIgniter\Model;

class DisabilityTypeModel extends Model
{
    protected $table            = 'disability_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_name',
        'description',
        'is_active',
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
        'type_name' => 'required|min_length[3]|max_length[100]|is_unique[disability_types.type_name]',
        'description' => 'permit_empty|max_length[500]'
    ];
    protected $validationMessages   = [
        'type_name' => [
            'required' => 'Disability type name is required',
            'is_unique' => 'This disability type already exists'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setActiveStatus'];
    protected $beforeUpdate   = ['updateTimestamp'];

    protected function setActiveStatus(array $data)
    {
        if (!isset($data['data']['is_active']) || empty($data['data']['is_active'])) {
            $data['data']['is_active'] = 1;
        }
        return $data;
    }

    protected function updateTimestamp(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getAllActiveTypes()
    {
        return $this->where('is_active', 1)
                    ->orderBy('type_name', 'ASC')
                    ->findAll();
    }

    public function getTypeWithPWDCount()
    {
        return $this->select('disability_types.*, COUNT(pwd_profiles.id) as pwd_count')
                   ->join('pwd_profiles', 'pwd_profiles.disability_type = disability_types.type_name AND pwd_profiles.status = "active"', 'left')
                   ->where('disability_types.is_active', 1)
                   ->groupBy('disability_types.id')
                   ->orderBy('pwd_count', 'DESC')
                   ->findAll();
    }

    public function getTypeByName($typeName)
    {
        return $this->where('type_name', $typeName)->first();
    }

    public function activateType($typeId)
    {
        return $this->update($typeId, ['is_active' => 1]);
    }

    public function deactivateType($typeId)
    {
        return $this->update($typeId, ['is_active' => 0]);
    }

    public function searchTypes($searchTerm)
    {
        return $this->groupStart()
                   ->like('type_name', $searchTerm)
                   ->orLike('description', $searchTerm)
                   ->groupEnd()
                   ->where('is_active', 1)
                   ->orderBy('type_name', 'ASC')
                   ->findAll();
    }

    public function getMostCommonTypes($limit = 10)
    {
        // This would typically join with pwd_profiles to get count
        // For now, return all active types
        return $this->where('is_active', 1)
                   ->orderBy('type_name', 'ASC')
                   ->limit($limit)
                   ->findAll();
    }

    public function countActiveTypes()
    {
        return $this->where('is_active', 1)->countAllResults();
    }

    public function getTypesWithAssistanceStats($startDate = null, $endDate = null)
    {
        $builder = $this->select('disability_types.type_name, 
                                 COUNT(DISTINCT pwd_profiles.id) as pwd_count,
                                 COUNT(assistance_records.id) as assistance_count,
                                 SUM(assistance_records.amount) as total_amount')
                       ->join('pwd_profiles', 'pwd_profiles.disability_type = disability_types.type_name AND pwd_profiles.status = "active"', 'left')
                       ->join('assistance_records', 'assistance_records.pwd_id = pwd_profiles.id AND assistance_records.status = "completed"', 'left')
                       ->where('disability_types.is_active', 1);

        if ($startDate && $endDate) {
            $builder->where('assistance_records.assistance_date >=', $startDate)
                   ->where('assistance_records.assistance_date <=', $endDate);
        }

        return $builder->groupBy('disability_types.id')
                      ->orderBy('pwd_count', 'DESC')
                      ->findAll();
    }
}