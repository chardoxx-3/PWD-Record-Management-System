<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 
        'password', 
        'full_name', 
        'email', 
        'is_active', 
        'last_login', 
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
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]'
    ];
    protected $validationMessages   = [
        'username' => [
            'required' => 'Username is required',
            'is_unique' => 'This username is already taken'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'full_name' => [
            'required' => 'Full name is required'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please provide a valid email address'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->where('is_active', 1)->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    public function getAllAdmins()
    {
        return $this->where('is_active', 1)->orderBy('full_name', 'ASC')->findAll();
    }

    public function deactivateUser($userId)
    {
        return $this->update($userId, ['is_active' => 0]);
    }

    public function activateUser($userId)
    {
        return $this->update($userId, ['is_active' => 1]);
    }

    public function countActiveUsers()
    {
        return $this->where('is_active', 1)->countAllResults();
    }
}