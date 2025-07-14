<?php

namespace App\Controllers;

class Partnership extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    
    // Halaman utama - cek undangan
    public function index()
    {
        // Cek apakah ada token undangan di URL
        $invitation_token = $this->request->getVar('token');
        
        if ($invitation_token) {
            return $this->processInvitation($invitation_token);
        }
        
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('parent_logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        // Redirect ke halaman login yang baru
        return redirect()->to('/login');
    }
    
    // Halaman login yang elegant
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('parent_logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        $data = [
            'title' => 'Login - Jendela Kemitraan',
            'validation' => \Config\Services::validation()
        ];
        
        return view('auth/login', $data);
    }
    
    // Proses authenticate username/password
    public function authenticate()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[5]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Check user in orang_tua table (parent users are stored here)
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orang_tua WHERE username = ? AND is_active = 1", [$username]);
        $user = $query->getRow();
        
        if ($user && password_verify($password, $user->password)) {
            // Set session
            $this->session->set([
                'parent_logged_in' => true,
                'user_id' => $user->id,
                'username' => $user->username,
                'parent_name' => $user->nama_lengkap ?? $user->username,
                'email' => $user->email,
                'hubungan_keluarga' => $user->hubungan_keluarga
            ]);
            
            // Update last login
            $db->query("UPDATE orang_tua SET last_login = NOW() WHERE id = ?", [$user->id]);
            
            return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah');
        }
    }
    
    // Halaman notifikasi
    public function notifications()
    {
        // Cek login
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Notifikasi - Smart BookKeeping',
            'parent_name' => $this->session->get('parent_name'),
            'student_name' => $this->session->get('student_name')
        ];
        
        return view('partnership/notifications', $data);
    }
    
    // Halaman profil anak
    public function profile()
    {
        // Cek login
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Profil Anak - Smart BookKeeping',
            'parent_name' => $this->session->get('parent_name'),
            'student_name' => $this->session->get('student_name')
        ];
        
        return view('partnership/profile', $data);
    }
    
    // Halaman laporan akademik
    public function academic()
    {
        // Cek login
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Laporan Akademik - Smart BookKeeping',
            'parent_name' => $this->session->get('parent_name'),
            'student_name' => $this->session->get('student_name')
        ];
        
        return view('partnership/academic', $data);
    }
    
    // Halaman keuangan
    public function finance()
    {
        // Cek login
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Keuangan - Smart BookKeeping',
            'parent_name' => $this->session->get('parent_name'),
            'student_name' => $this->session->get('student_name')
        ];
        
        return view('partnership/finance', $data);
    }
    
    // Proses undangan berdasarkan token
    private function processInvitation($token)
    {
        // Connect ke database
        $db = \Config\Database::connect();
        
        try {
            // Cari undangan berdasarkan token
            $invitation = $db->table('parent_invitations')
                ->where('invitation_token', $token)
                ->where('is_active', 1)
                ->where('expires_at >', date('Y-m-d H:i:s'))
                ->get()
                ->getRowArray();
            
            if (!$invitation) {
                return view('invitation/invalid', [
                    'title' => 'Undangan Tidak Valid',
                    'message' => 'Undangan tidak ditemukan atau sudah kadaluarsa.'
                ]);
            }
            
            // Ambil data siswa dan orang tua
            $student_data = $db->table('users u')
                ->select('u.*, m.nama_lengkap, m.kelas, m.nis')
                ->join('murid m', 'u.id = m.user_id', 'left')
                ->where('u.id', $invitation['student_id'])
                ->get()
                ->getRowArray();
            
            if (!$student_data) {
                return view('invitation/invalid', [
                    'title' => 'Data Tidak Ditemukan',
                    'message' => 'Data siswa tidak ditemukan.'
                ]);
            }
            
            // Set session untuk orang tua
            $this->session->set([
                'parent_logged_in' => true,
                'invitation_id' => $invitation['id'],
                'student_id' => $invitation['student_id'],
                'student_name' => $student_data['nama_lengkap'] ?? $student_data['full_name'],
                'student_class' => $student_data['kelas'] ?? 'Tidak diketahui',
                'student_nis' => $student_data['nis'] ?? '',
                'parent_name' => $invitation['parent_name'],
                'parent_email' => $invitation['parent_email'],
                'invitation_expires' => $invitation['expires_at']
            ]);
            
            // Update last accessed
            $db->table('parent_invitations')
                ->where('id', $invitation['id'])
                ->update(['last_accessed' => date('Y-m-d H:i:s')]);
            
            // Redirect ke dashboard
            return redirect()->to('/dashboard')->with('success', 'Selamat datang! Anda berhasil mengakses Jendela Kemitraan.');
            
        } catch (\Exception $e) {
            log_message('error', 'Partnership invitation error: ' . $e->getMessage());
            return view('invitation/error', [
                'title' => 'Terjadi Kesalahan',
                'message' => 'Maaf, terjadi kesalahan sistem. Silakan hubungi sekolah.'
            ]);
        }
    }
    
    // Dashboard utama untuk orang tua
    public function dashboard()
    {
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Ambil data ringkasan untuk ditampilkan
        $summaryData = $this->getSummaryData();
        $actionPlans = $this->getActionPlans();
        
        $data = [
            'title' => 'Dashboard - Jendela Kemitraan',
            'user_name' => $this->session->get('parent_name') ?? 'Orang Tua',
            'student_name' => $this->session->get('student_name') ?? 'Siswa',
            'student_class' => $this->session->get('student_class') ?? 'Kelas',
            'student_nis' => $this->session->get('student_nis') ?? '000000',
            'summary_data' => $summaryData,
            'action_plans' => $actionPlans,
            'expires_at' => $this->session->get('invitation_expires') ?? date('Y-m-d H:i:s', strtotime('+30 days'))
        ];
        
        return view('partnership/dashboard_basic', $data);
    }
    
    // Halaman ringkasan & rencana aksi detail
    public function summary()
    {
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/');
        }
        
        $summaryData = $this->getSummaryData();
        $actionPlans = $this->getActionPlans();
        
        $data = [
            'title' => 'Ringkasan & Rencana Aksi',
            'user_name' => $this->session->get('parent_name'),
            'student_name' => $this->session->get('student_name'),
            'summary_data' => $summaryData,
            'action_plans' => $actionPlans
        ];
        
        return view('partnership/summary', $data);
    }
    
    // Halaman progress dan feedback
    public function progress()
    {
        if (!$this->session->get('parent_logged_in')) {
            return redirect()->to('/');
        }
        
        $progressData = $this->getProgressData();
        
        $data = [
            'title' => 'Progress & Feedback',
            'user_name' => $this->session->get('parent_name'),
            'student_name' => $this->session->get('student_name'),
            'progress_data' => $progressData
        ];
        
        return view('partnership/progress', $data);
    }
    
    // Submit feedback dari orang tua
    public function submitFeedback()
    {
        if (!$this->session->get('parent_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $feedback = $this->request->getPost('feedback');
        $rating = $this->request->getPost('rating');
        
        if (empty($feedback)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Feedback tidak boleh kosong']);
        }
        
        $db = \Config\Database::connect();
        
        try {
            $db->table('parent_feedback')->insert([
                'invitation_id' => $this->session->get('invitation_id'),
                'student_id' => $this->session->get('student_id'),
                'feedback_text' => $feedback,
                'rating' => $rating,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Feedback berhasil dikirim. Terima kasih!']);
            
        } catch (\Exception $e) {
            log_message('error', 'Submit feedback error: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim feedback']);
        }
    }
    
    // Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/')->with('success', 'Anda telah keluar dari sistem');
    }
    
    // Helper: Ambil data ringkasan
    private function getSummaryData()
    {
        $student_id = $this->session->get('student_id');
        
        if (!$student_id) {
            return []; // Return empty array if no student_id
        }
        
        try {
            $db = \Config\Database::connect();
            
            // Check if table exists first
            if (!$db->tableExists('parent_summaries')) {
                return [];
            }
            
            // Ambil ringkasan yang sudah dikurasi oleh Guru BK
            $summary = $db->table('parent_summaries')
                ->where('student_id', $student_id)
                ->where('is_active', 1)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
                
            return $summary;
        } catch (Exception $e) {
            log_message('error', 'Error getting summary data: ' . $e->getMessage());
            return [];
        }
    }
    
    // Helper: Ambil rencana aksi
    private function getActionPlans()
    {
        $student_id = $this->session->get('student_id');
        
        if (!$student_id) {
            return []; // Return empty array if no student_id
        }
        
        try {
            $db = \Config\Database::connect();
            
            // Check if table exists first
            if (!$db->tableExists('action_plans')) {
                return [];
            }
            
            // Ambil rencana aksi untuk rumah dan sekolah
            $plans = $db->table('action_plans')
                ->where('student_id', $student_id)
                ->where('is_active', 1)
                ->orderBy('priority', 'ASC')
                ->get()
                ->getResultArray();
                
            return $plans;
        } catch (Exception $e) {
            log_message('error', 'Error getting action plans: ' . $e->getMessage());
            return [];
        }
    }
    
    // Helper: Ambil data progress
    private function getProgressData()
    {
        $db = \Config\Database::connect();
        $student_id = $this->session->get('student_id');
        
        // Ambil data progress dari rencana aksi
        $progress = $db->table('action_progress ap')
            ->select('ap.*, a.title as action_title, a.description as action_desc')
            ->join('action_plans a', 'ap.action_plan_id = a.id')
            ->where('a.student_id', $student_id)
            ->orderBy('ap.updated_at', 'DESC')
            ->get()
            ->getResultArray();
        
        return $progress;
    }
}
