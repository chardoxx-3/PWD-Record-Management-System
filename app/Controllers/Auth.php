<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->auditLogModel = new AuditLogModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Admin Login - PWD Management System'
        ];

        return view('auth/login', $data);
    }

    public function processLogin()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'username' => 'required',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session data
            $sessionData = [
                'userId' => $user['id'],
                'username' => $user['username'],
                'fullName' => $user['full_name'],
                'isLoggedIn' => true
            ];
            session()->set($sessionData);

            // Log the login activity
            $this->auditLogModel->insert([
                'user_id' => $user['id'],
                'action' => 'LOGIN',
                'description' => 'User logged into the system',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Set toast message for successful login
            session()->setFlashdata('toast', [
                'type' => 'success',
                'message' => 'Login successful! Welcome back, ' . $user['full_name'] . '!'
            ]);

            return redirect()->to('/dashboard');
        } else {
            // Set toast message for login error
            session()->setFlashdata('toast', [
                'type' => 'error',
                'message' => 'Invalid username or password'
            ]);
            
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        // Log the logout activity
        if (session()->get('isLoggedIn')) {
            $this->auditLogModel->insert([
                'user_id' => session()->get('userId'),
                'action' => 'LOGOUT',
                'description' => 'User logged out of the system',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Set toast message for successful logout
            session()->setFlashdata('toast', [
                'type' => 'success',
                'message' => 'You have been logged out successfully.'
            ]);
        }

        // Destroy session
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    // Optional: Helper method for toast messages in other controllers
    protected function setToastMessage($type, $message)
    {
        session()->setFlashdata('toast', [
            'type' => $type,
            'message' => $message
        ]);
    }
    public function verifyAndRegister()
{
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // Verify credentials
    $user = $this->userModel->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
        // Credentials are valid, allow access to register page
        return redirect()->to('/auth/register');
    } else {
        // Invalid credentials
        session()->setFlashdata('error', 'Invalid credentials. Please login first to register new admin.');
        return redirect()->to('/auth/login');
    }
}

public function register()
{
    // If user is already logged in, redirect to dashboard
    if (session()->get('isLoggedIn')) {
        return redirect()->to('/dashboard');
    }

    $data = [
        'title' => 'Register Admin - PWD Management System'
    ];

    return view('auth/register', $data);
}

public function processRegister()
{
    $validation = \Config\Services::validation();
    
    $validation->setRules([
        'full_name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'required|matches[password]'
    ], [
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
        ],
        'confirm_password' => [
            'required' => 'Please confirm your password',
            'matches' => 'Passwords do not match'
        ]
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Create new user
    $userData = [
        'username' => $this->request->getPost('username'),
        'password' => $this->request->getPost('password'),
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'is_active' => 1
    ];

    if ($this->userModel->insert($userData)) {
        // Log the registration activity
        $this->auditLogModel->insert([
            'user_id' => $this->userModel->getInsertID(),
            'action' => 'REGISTER',
            'description' => 'New admin user registered: ' . $userData['username'],
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Admin user registered successfully! You can now login with the new credentials.');
        return redirect()->to('/auth/login');
    } else {
        session()->setFlashdata('error', 'Failed to register admin user. Please try again.');
        return redirect()->back()->withInput();
    }
}
}