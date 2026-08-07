<?php namespace App\Controllers;

use App\Models\AssistanceModel;
use App\Models\ReservationModel;
use App\Models\PwdProfileModel;
use App\Models\AuditLogModel;

class Assistance extends BaseController
{
    protected $assistanceModel;
    protected $reservationModel;
    protected $pwdProfileModel;
    protected $auditLogModel;

    public function __construct()
    {
        $this->assistanceModel = new AssistanceModel();
        $this->reservationModel = new ReservationModel();
        $this->pwdProfileModel = new PwdProfileModel();
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

        // Get filters
        $pwdId = $this->request->getGet('pwd_id');
        $assistanceType = $this->request->getGet('assistance_type');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Build query
        $builder = $this->assistanceModel
            ->select('assistance_records.*, pwd_profiles.full_name')
            ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id');

        if (!empty($pwdId)) {
            $builder->where('pwd_id', $pwdId);
        }

        if (!empty($assistanceType)) {
            $builder->where('assistance_type', $assistanceType);
        }

        if (!empty($startDate)) {
            $builder->where('assistance_date >=', $startDate);
        }

        if (!empty($endDate)) {
            $builder->where('assistance_date <=', $endDate);
        }

        $assistanceRecords = $builder->orderBy('assistance_date', 'DESC')
            ->paginate($perPage, 'default', $currentPage);

        $pwdProfiles = $this->pwdProfileModel->where('status', 'active')->findAll();

        $data = [
            'title' => 'Assistance Records',
            'assistanceRecords' => $assistanceRecords,
            'pwdProfiles' => $pwdProfiles,
            'pager' => $this->assistanceModel->pager,
            'pwdId' => $pwdId,
            'assistanceType' => $assistanceType,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('assistance/list', $data);
    }

    public function record()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $pwdProfiles = $this->pwdProfileModel->where('status', 'active')->findAll();

        $data = [
            'title' => 'Record Assistance',
            'pwdProfiles' => $pwdProfiles,
            'validation' => \Config\Services::validation()
        ];

        return view('assistance/record', $data);
    }

public function createAssistance()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $validation = \Config\Services::validation();
    
    $validation->setRules([
        'pwd_id' => 'required|numeric',
        'assistance_type' => 'required|in_list[Financial,Medical,Educational,Rehabilitation,Equipment,Other]',
        'assistance_date' => 'required|valid_date',
        'amount' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'description' => 'required|min_length[10]|max_length[500]',
        'notes' => 'permit_empty|max_length[500]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        // Get the first error message for toast
        $errors = $validation->getErrors();
        $firstError = reset($errors);
        
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => $firstError
        ]);
        return redirect()->back()->withInput();
    }

    $assistanceData = [
        'pwd_id' => $this->request->getPost('pwd_id'),
        'assistance_type' => $this->request->getPost('assistance_type'),
        'assistance_date' => $this->request->getPost('assistance_date'),
        'amount' => $this->request->getPost('amount') ?? 0,
        'description' => $this->request->getPost('description'),
        'notes' => $this->request->getPost('notes'),
        'status' => 'completed',
        'recorded_by' => session()->get('userId'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $result = $this->assistanceModel->insert($assistanceData);
        
        if (!$result) {
            session()->setFlashdata('toast', [
                'type' => 'error',
                'message' => 'Failed to save assistance record'
            ]);
            return redirect()->back()->withInput();
        }
        
        $assistanceId = $this->assistanceModel->getInsertID();

        // Get PWD name for audit log
        $pwdProfile = $this->pwdProfileModel->find($assistanceData['pwd_id']);

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'RECORD_ASSISTANCE',
            'description' => 'Recorded ' . $assistanceData['assistance_type'] . ' assistance for: ' . $pwdProfile['full_name'],
            'record_id' => $assistanceId,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'Assistance record created successfully!'
        ]);
        return redirect()->to('/assistance');
    } catch (\Exception $e) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to create assistance record: ' . $e->getMessage()
        ]);
        return redirect()->back()->withInput();
    }
}

    public function reservations()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $perPage = 10;
        $currentPage = $this->request->getGet('page') ?? 1;

        $status = $this->request->getGet('status') ?? 'pending';

        $reservations = $this->reservationModel
            ->select('reservations.*, pwd_profiles.full_name')
            ->join('pwd_profiles', 'pwd_profiles.id = reservations.pwd_id')
            ->where('reservations.status', $status)
            ->orderBy('reservations.reservation_date', 'ASC')
            ->paginate($perPage, 'default', $currentPage);

        $pwdProfiles = $this->pwdProfileModel->where('status', 'active')->findAll();

        $data = [
            'title' => 'Reservation Management',
            'reservations' => $reservations,
            'pwdProfiles' => $pwdProfiles,
            'pager' => $this->reservationModel->pager,
            'status' => $status
        ];

        return view('assistance/reservations', $data);
    }

public function createReservation()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $validation = \Config\Services::validation();
    
    $validation->setRules([
        'pwd_id' => 'required|numeric',
        'assistance_type' => 'required|in_list[Financial,Medical,Educational,Rehabilitation,Equipment,Other]',
        'reservation_date' => 'required|valid_date',
        'purpose' => 'required|min_length[10]|max_length[500]',
        'notes' => 'permit_empty|max_length[500]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        $errors = $validation->getErrors();
        $firstError = reset($errors);
        
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => $firstError
        ]);
        return redirect()->back()->withInput();
    }

    $reservationData = [
        'pwd_id' => $this->request->getPost('pwd_id'),
        'assistance_type' => $this->request->getPost('assistance_type'),
        'reservation_date' => $this->request->getPost('reservation_date'),
        'purpose' => $this->request->getPost('purpose'),
        'notes' => $this->request->getPost('notes'),
        'status' => 'pending',
        'created_by' => session()->get('userId'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $this->reservationModel->insert($reservationData);
        $reservationId = $this->reservationModel->getInsertID();

        // Get PWD name for audit log
        $pwdProfile = $this->pwdProfileModel->find($reservationData['pwd_id']);

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'CREATE_RESERVATION',
            'description' => 'Created reservation for ' . $reservationData['assistance_type'] . ' assistance for: ' . $pwdProfile['full_name'],
            'record_id' => $reservationId,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'Reservation created successfully!'
        ]);
        return redirect()->to('/assistance/reservations');
    } catch (\Exception $e) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to create reservation: ' . $e->getMessage()
        ]);
        return redirect()->back()->withInput();
    }
}

    public function updateReservationStatus($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $reservation = $this->reservationModel->find($id);
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        $status = $this->request->getPost('status');
        $validStatuses = ['pending', 'approved', 'completed', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        try {
            $this->reservationModel->update($id, [
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Log the activity
            $this->auditLogModel->insert([
                'user_id' => session()->get('userId'),
                'action' => 'UPDATE_RESERVATION',
                'description' => 'Updated reservation status to: ' . $status,
                'record_id' => $id,
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            session()->setFlashdata('toast', [
    'type' => 'success',
    'message' => 'Reservation status updated successfully!'
]);
return redirect()->back();
        } catch (\Exception $e) {
            session()->setFlashdata('toast', [
    'type' => 'error',
    'message' => 'Failed to update reservation status: ' . $e->getMessage()
]);
return redirect()->back();
        }
    }

    public function history($pwd_id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $pwdProfile = $this->pwdProfileModel->find($pwd_id);
        if (!$pwdProfile) {
            return redirect()->to('/pwd-profiles')->with('error', 'PWD profile not found.');
        }

        $assistanceHistory = $this->assistanceModel
            ->where('pwd_id', $pwd_id)
            ->orderBy('assistance_date', 'DESC')
            ->findAll();

        $reservationHistory = $this->reservationModel
            ->where('pwd_id', $pwd_id)
            ->orderBy('reservation_date', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Assistance History - ' . $pwdProfile['full_name'],
            'pwdProfile' => $pwdProfile,
            'assistanceHistory' => $assistanceHistory,
            'reservationHistory' => $reservationHistory
        ];

        return view('assistance/history', $data);
    }

    public function edit($id)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $assistanceRecord = $this->assistanceModel
        ->select('assistance_records.*, pwd_profiles.full_name')
        ->join('pwd_profiles', 'pwd_profiles.id = assistance_records.pwd_id')
        ->where('assistance_records.id', $id)
        ->first();

    if (!$assistanceRecord) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Assistance record not found.'
        ]);
        return redirect()->to('/assistance');
    }

    $data = [
        'title' => 'Edit Assistance Record',
        'assistanceRecord' => $assistanceRecord,
        'validation' => \Config\Services::validation()
    ];

    return view('assistance/edit', $data);
}

public function updateAssistance($id)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    $assistanceRecord = $this->assistanceModel->find($id);
    if (!$assistanceRecord) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Assistance record not found.'
        ]);
        return redirect()->to('/assistance');
    }

    $validation = \Config\Services::validation();
    
    $validation->setRules([
        'assistance_type' => 'required|in_list[Financial,Medical,Educational,Rehabilitation,Equipment,Other]',
        'assistance_date' => 'required|valid_date',
        'amount' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'description' => 'required|min_length[10]|max_length[500]',
        'notes' => 'permit_empty|max_length[500]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        // Get the first error message for toast
        $errors = $validation->getErrors();
        $firstError = reset($errors);
        
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => $firstError
        ]);
        return redirect()->back()->withInput();
    }

    $assistanceData = [
        'assistance_type' => $this->request->getPost('assistance_type'),
        'assistance_date' => $this->request->getPost('assistance_date'),
        'amount' => $this->request->getPost('amount') ?? 0,
        'description' => $this->request->getPost('description'),
        'notes' => $this->request->getPost('notes'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $result = $this->assistanceModel->update($id, $assistanceData);
        
        if (!$result) {
            session()->setFlashdata('toast', [
                'type' => 'error',
                'message' => 'Failed to update assistance record'
            ]);
            return redirect()->back()->withInput();
        }

        // Get PWD name for audit log
        $pwdProfile = $this->pwdProfileModel->find($assistanceRecord['pwd_id']);

        // Log the activity
        $this->auditLogModel->insert([
            'user_id' => session()->get('userId'),
            'action' => 'UPDATE_ASSISTANCE',
            'description' => 'Updated ' . $assistanceData['assistance_type'] . ' assistance record for: ' . $pwdProfile['full_name'],
            'record_id' => $id,
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('toast', [
            'type' => 'success',
            'message' => 'Assistance record updated successfully!'
        ]);
        return redirect()->to('/assistance/history/' . $assistanceRecord['pwd_id']);
    } catch (\Exception $e) {
        session()->setFlashdata('toast', [
            'type' => 'error',
            'message' => 'Failed to update assistance record: ' . $e->getMessage()
        ]);
        return redirect()->back()->withInput();
    }
}
}