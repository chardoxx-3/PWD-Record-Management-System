<?php namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $auditLogModel;
    protected $userModel;

    public function __construct()
    {
        $this->auditLogModel = new AuditLogModel();
        $this->userModel = new UserModel();
        
        helper(['form', 'url']);
    }

    public function auditLog()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $perPage = 20;
        $currentPage = $this->request->getGet('page') ?? 1;

        // Get filters
        $action = $this->request->getGet('action');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $userId = $this->request->getGet('user_id');

        // Build query
        $builder = $this->auditLogModel
            ->select('audit_logs.*, users.username, users.full_name')
            ->join('users', 'users.id = audit_logs.user_id');

        if (!empty($action)) {
            $builder->where('action', $action);
        }

        if (!empty($userId)) {
            $builder->where('user_id', $userId);
        }

        if (!empty($startDate)) {
            $builder->where('audit_logs.created_at >=', $startDate);
        }

        if (!empty($endDate)) {
            $builder->where('audit_logs.created_at <=', $endDate);
        }

        $auditLogs = $builder->orderBy('audit_logs.created_at', 'DESC')
            ->paginate($perPage, 'default', $currentPage);

        $users = $this->userModel->findAll();
        $actions = $this->getDistinctActions();

        $data = [
            'title' => 'System Audit Log',
            'auditLogs' => $auditLogs,
            'users' => $users,
            'actions' => $actions,
            'pager' => $this->auditLogModel->pager,
            'action' => $action,
            'userId' => $userId,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('admin/audit_log', $data);
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'User profile not found.');
        }

        $data = [
            'title' => 'Admin Profile',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/profile', $data);
    }

public function updateProfile()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $userId = session()->get('userId');
    $user = $this->userModel->find($userId);

    if (!$user) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'User profile not found.'
        ]);
        return redirect()->to('/dashboard');
    }

    $validation = \Config\Services::validation();
    
    // Define base validation rules
    $rules = [
        'full_name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email'
    ];

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    // Only add password validation if user is trying to change password
    if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
        $rules['current_password'] = 'required';
        $rules['new_password'] = 'required|min_length[6]';
        $rules['confirm_password'] = 'required|matches[new_password]';
    }

    $validation->setRules($rules);

    if (!$validation->withRequest($this->request)->run()) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Please fix the validation errors below.'
        ]);
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $updateData = [
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Handle password change only if all password fields are provided
    if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
        if (!password_verify($currentPassword, $user['password'])) {
            session()->setFlashdata('toast', [
                'type' => 'error',
                'message' => 'Current password is incorrect.'
            ]);
            return redirect()->back()->withInput();
        }

        $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    try {
        $this->userModel->update($userId, $updateData);

        // Update session data if full name changed
        if ($user['full_name'] !== $updateData['full_name']) {
            session()->set('fullName', $updateData['full_name']);
        }

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => $userId,
            'action' => 'UPDATE_PROFILE',
            'description' => 'Updated admin profile information',
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'Profile updated successfully!'
        ]);

        return redirect()->back();
    } catch (\Exception $e) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to update profile: ' . $e->getMessage()
        ]);
        return redirect()->back()->withInput();
    }
}

    public function systemSettings()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // This would typically load settings from a configuration table
        $data = [
            'title' => 'System Settings'
        ];

        return view('admin/settings', $data);
    }

    public function updateSystemSettings()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // This would typically update settings in a configuration table
        // For now, we'll just show a success message

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'UPDATE_SETTINGS',
            'description' => 'Updated system settings',
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'System settings updated successfully!');
    }

    private function getDistinctActions()
    {
        $builder = $this->auditLogModel->distinct()->select('action');
        $results = $builder->findAll();
        
        $actions = [];
        foreach ($results as $result) {
            $actions[] = $result['action'];
        }
        
        return $actions;
    }

    public function clearAuditLog()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $daysToKeep = 90; // Keep logs for 90 days
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-$daysToKeep days"));

        try {
            $this->auditLogModel->where('created_at <', $cutoffDate)->delete();

            // Log the activity
            $this->auditLogModel->insert([
                'user_id' => session()->get('userId'),
                'action' => 'CLEAR_AUDIT_LOG',
                'description' => 'Cleared audit logs older than ' . $daysToKeep . ' days',
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', 'Audit logs cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear audit logs: ' . $e->getMessage());
        }
    }
    public function updatePassword()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $userId = session()->get('userId');
    $user = $this->userModel->find($userId);

    if (!$user) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'User profile not found.'
        ]);
        return redirect()->to('/dashboard');
    }

    $validation = \Config\Services::validation();
    
    // Only password validation rules
    $validation->setRules([
        'current_password' => 'required',
        'new_password' => 'required|min_length[6]',
        'confirm_password' => 'required|matches[new_password]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Please fix the password validation errors.'
        ]);
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');

    // Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Current password is incorrect.'
        ]);
        return redirect()->back()->withInput();
    }

    try {
        $this->userModel->update($userId, [
             'password' => $newPassword, // Changed this line
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => $userId,
            'action' => 'UPDATE_PASSWORD',
            'description' => 'Changed account password',
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'Password updated successfully!'
        ]);

        return redirect()->back();
    } catch (\Exception $e) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to update password: ' . $e->getMessage()
        ]);
        return redirect()->back()->withInput();
    }
}
}