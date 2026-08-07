<?php namespace App\Controllers;

use App\Models\PwdProfileModel;
use App\Models\DisabilityTypeModel;
use App\Models\AuditLogModel;

class PwdProfiles extends BaseController
{
    protected $pwdProfileModel;
    protected $disabilityTypeModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->pwdProfileModel = new PwdProfileModel();
        $this->disabilityTypeModel = new DisabilityTypeModel();
        $this->auditLogModel = new AuditLogModel();
        
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $perPage = 10;
        $currentPage = $this->request->getGet('page') ?? 1;

        // Get search filters
        $search = $this->request->getGet('search');
        $disabilityType = $this->request->getGet('disability_type');
        $status = $this->request->getGet('status') ?? 'active';

        // Build query
        $builder = $this->pwdProfileModel;

        if (!empty($search)) {
            $builder->groupStart()
                ->like('full_name', $search)
                ->orLike('address', $search)
                ->orLike('contact_number', $search)
                ->groupEnd();
        }

        if (!empty($disabilityType)) {
            $builder->where('disability_type', $disabilityType);
        }

        if (!empty($status)) {
            $builder->where('status', $status);
        }

        $pwdProfiles = $builder->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $currentPage);

        $disabilityTypes = $this->disabilityTypeModel->findAll();

        $data = [
            'title' => 'PWD Profiles - Management System',
            'pwdProfiles' => $pwdProfiles,
            'disabilityTypes' => $disabilityTypes,
            'pager' => $this->pwdProfileModel->pager,
            'search' => $search,
            'disabilityType' => $disabilityType,
            'status' => $status
        ];

        return view('pwd_profiles/list', $data);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $disabilityTypes = $this->disabilityTypeModel->findAll();

        $data = [
            'title' => 'Add PWD Profile',
            'disabilityTypes' => $disabilityTypes,
            'validation' => \Config\Services::validation()
        ];

        return view('pwd_profiles/add', $data);
    }

public function create()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $validation = \Config\Services::validation();
    
    $validation->setRules([
        'full_name' => 'required|min_length[3]|max_length[100]',
        'gender' => 'required|in_list[Male,Female,Other]',
        'age' => 'required|numeric|greater_than[0]',
        'address' => 'required|min_length[5]',
        'contact_number' => 'required|min_length[10]',
        'email' => 'permit_empty|valid_email', // Add email validation
        'disability_type' => 'required',
        'disability_level' => 'permit_empty|in_list[Mild,Moderate,Severe]', // Add disability_level validation
        'identification_number' => 'permit_empty|max_length[50]', // Add identification_number validation
        'medical_notes' => 'permit_empty|max_length[500]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $pwdData = [
        'full_name' => $this->request->getPost('full_name'),
        'gender' => $this->request->getPost('gender'),
        'age' => $this->request->getPost('age'),
        'address' => $this->request->getPost('address'),
        'contact_number' => $this->request->getPost('contact_number'),
        'email' => $this->request->getPost('email'), // Add this line
        'disability_type' => $this->request->getPost('disability_type'),
        'disability_level' => $this->request->getPost('disability_level'), // Add this line
        'medical_notes' => $this->request->getPost('medical_notes'),
        'identification_number' => $this->request->getPost('identification_number'), // Add this line
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $this->pwdProfileModel->insert($pwdData);
        $pwdId = $this->pwdProfileModel->getInsertID();

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'CREATE_PWD',
            'description' => 'Created PWD profile for: ' . $pwdData['full_name'],
            'record_id' => $pwdId,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'PWD profile created successfully!'
        ]);
        return redirect()->to('/pwd-profiles');
    } catch (\Exception $e) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to create PWD profile: ' . $e->getMessage()
        ]);
        return redirect()->back()->withInput();
    }
}

    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $pwdProfile = $this->pwdProfileModel->find($id);
        if (!$pwdProfile) {
            return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
        }

        $disabilityTypes = $this->disabilityTypeModel->findAll();

        $data = [
            'title' => 'Edit PWD Profile',
            'pwdProfile' => $pwdProfile,
            'disabilityTypes' => $disabilityTypes,
            'validation' => \Config\Services::validation()
        ];

        return view('pwd_profiles/edit', $data);
    }

public function update($id)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $pwdProfile = $this->pwdProfileModel->find($id);
    if (!$pwdProfile) {
        return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
    }

    $validation = \Config\Services::validation();
    
    $validation->setRules([
        'full_name' => 'required|min_length[3]|max_length[100]',
        'gender' => 'required|in_list[Male,Female,Other]',
        'age' => 'required|numeric|greater_than[0]',
        'address' => 'required|min_length[5]',
        'contact_number' => 'required|min_length[10]',
        'email' => 'permit_empty|valid_email', // Add email validation
        'disability_type' => 'required',
        'disability_level' => 'permit_empty|in_list[Mild,Moderate,Severe]', // Add disability_level validation
        'identification_number' => 'permit_empty|max_length[50]', // Add identification_number validation
        'medical_notes' => 'permit_empty|max_length[500]',
        'status' => 'required|in_list[active,archived,inactive]' // Added inactive to the list
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $updateData = [
        'full_name' => $this->request->getPost('full_name'),
        'gender' => $this->request->getPost('gender'),
        'age' => $this->request->getPost('age'),
        'address' => $this->request->getPost('address'),
        'contact_number' => $this->request->getPost('contact_number'),
        'email' => $this->request->getPost('email'), // Add this line
        'disability_type' => $this->request->getPost('disability_type'),
        'disability_level' => $this->request->getPost('disability_level'), // Add this line
        'medical_notes' => $this->request->getPost('medical_notes'),
        'identification_number' => $this->request->getPost('identification_number'), // Add this line
        'status' => $this->request->getPost('status'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $this->pwdProfileModel->update($id, $updateData);

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'UPDATE_PWD',
            'description' => 'Updated PWD profile for: ' . $updateData['full_name'],
            'record_id' => $id,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'PWD profile updated successfully!'
        ]);
        return redirect()->to('/pwd-profiles');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Failed to update PWD profile: ' . $e->getMessage());
    }
}

    public function view($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $pwdProfile = $this->pwdProfileModel->find($id);
        if (!$pwdProfile) {
            return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
        }

        $data = [
            'title' => 'View PWD Profile - ' . $pwdProfile['full_name'],
            'pwdProfile' => $pwdProfile
        ];

        return view('pwd_profiles/view', $data);
    }

    public function archive($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $pwdProfile = $this->pwdProfileModel->find($id);
        if (!$pwdProfile) {
            return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
        }

        try {
            $this->pwdProfileModel->update($id, ['status' => 'archived', 'updated_at' => date('Y-m-d H:i:s')]);

            // Log the activity
            $this->auditLogModel->insert([
                'user_id' => session()->get('userId'),
                'action' => 'ARCHIVE_PWD',
                'description' => 'Archived PWD profile: ' . $pwdProfile['full_name'],
                'record_id' => $id,
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            session()->setFlashdata('toast', [
    'type' => 'success',
    'message' => 'PWD profile archived successfully!'
]);
return redirect()->to('/pwd-profiles');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to archive PWD profile: ' . $e->getMessage());
        }
    }

public function delete($id)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $pwdProfile = $this->pwdProfileModel->find($id);
    if (!$pwdProfile) {
        return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
    }

    try {
        // Use forceDelete to permanently remove the record
        $this->pwdProfileModel->delete($id, true); // true forces permanent deletion

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'DELETE_PWD',
            'description' => 'Deleted PWD profile: ' . $pwdProfile['full_name'],
            'record_id' => $id,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'PWD profile deleted successfully!'
        ]);
        return redirect()->to('/pwd-profiles');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete PWD profile: ' . $e->getMessage());
    }
}

    public function search()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $searchTerm = $this->request->getGet('q');

        $results = $this->pwdProfileModel
            ->select('id, full_name, disability_type, contact_number')
            ->like('full_name', $searchTerm)
            ->orLike('contact_number', $searchTerm)
            ->where('status', 'active')
            ->limit(10)
            ->findAll();

        return $this->response->setJSON($results);
    }

    public function activate($id)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $pwdProfile = $this->pwdProfileModel->find($id);
    if (!$pwdProfile) {
        return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
    }

    try {
        $this->pwdProfileModel->update($id, ['status' => 'active', 'updated_at' => date('Y-m-d H:i:s')]);

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'ACTIVATE_PWD',
            'description' => 'Activated PWD profile: ' . $pwdProfile['full_name'],
            'record_id' => $id,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'PWD profile activated successfully!'
        ]);
        return redirect()->to('/pwd-profiles');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to activate PWD profile: ' . $e->getMessage());
    }
}
}