<?php

namespace App\Controllers;

class GuruAuth extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    
    // Halaman utama - redirect ke login atau dashboard
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/dashboard'));
        }
        
        // Jika belum login, redirect ke halaman login
        return redirect()->to(base_url('/login'));
    }
    
    // Halaman login guru
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/dashboard'));
        }
        
        // Get demo users from database
        $demoUsers = [];
        try {
            $db = \Config\Database::connect();
            $query = $db->query("SELECT username, role, full_name FROM users WHERE status = 'active' AND role IN ('teacher', 'guru', 'admin') LIMIT 5");
            $demoUsers = $query->getResultArray();
        } catch (\Exception $e) {
            // Default demo users if database query fails
            $demoUsers = [
                ['username' => 'admin', 'role' => 'admin', 'full_name' => 'Administrator'],
                ['username' => 'guru1', 'role' => 'teacher', 'full_name' => 'Guru Demo 1'],
                ['username' => 'teacher', 'role' => 'teacher', 'full_name' => 'Teacher Demo']
            ];
        }
        
        $data = [
            'title' => 'Login Guru - Smart BookKeeping',
            'validation' => \Config\Services::validation(),
            'demoUsers' => $demoUsers
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
        
        // Check user in users table with role_id = 2 (guru)
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM users WHERE username = ? AND role_id = 2 AND is_active = 1", [$username]);
        $user = $query->getRow();
        
        if ($user && password_verify($password, $user->password)) {
            // Set session
            $this->session->set([
                'guru_logged_in' => true,
                'user_id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'tahun_ajaran_id' => $user->tahun_ajaran_id
            ]);
            
            // Update last login
            $db->query("UPDATE users SET last_login = NOW() WHERE id = ?", [$user->id]);
            
            return redirect()->to(base_url('/dashboard'))->with('success', 'Login berhasil! Selamat datang, ' . $user->full_name);
        } else {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah. Pastikan Anda terdaftar sebagai guru.');
        }
    }
    
    // Dashboard utama untuk guru
    public function dashboard()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Ambil statistik untuk dashboard
        $stats = $this->getDashboardStats();
        
        $data = [
            'title' => 'Dashboard Guru - Smart BookKeeping',
            'user_name' => $this->session->get('full_name'),
            'username' => $this->session->get('username'),
            'email' => $this->session->get('email'),
            'tahun_ajaran_id' => $this->session->get('tahun_ajaran_id'),
            'stats' => $stats
        ];
        
        return view('guru/dashboard', $data);
    }
    
    // Halaman profil guru
    public function profile()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $data = [
            'title' => 'Profil Guru - Smart BookKeeping',
            'user_name' => $this->session->get('full_name'),
            'username' => $this->session->get('username'),
            'email' => $this->session->get('email')
        ];
        
        return view('guru/profile', $data);
    }
    
    // Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('/login'))->with('success', 'Anda telah logout dari sistem.');
    }
    
    // Helper: Ambil statistik dashboard
    private function getDashboardStats()
    {
        try {
            $db = \Config\Database::connect();
            $user_id = $this->session->get('user_id');
            $tahun_ajaran_id = $this->session->get('tahun_ajaran_id');
            
            $stats = [
                'total_siswa' => 0,
                'total_kelas' => 0,
                'total_orang_tua' => 0,
                'active_tahun_ajaran' => $tahun_ajaran_id
            ];
            
            // Hitung total siswa (role_id = 3)
            if ($db->tableExists('users')) {
                $query = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3 AND is_active = 1 AND tahun_ajaran_id = ?", [$tahun_ajaran_id]);
                $result = $query->getRow();
                $stats['total_siswa'] = $result->total ?? 0;
            }
            
            // Hitung total kelas
            if ($db->tableExists('kelas')) {
                $query = $db->query("SELECT COUNT(*) as total FROM kelas WHERE tahun_ajaran_id = ?", [$tahun_ajaran_id]);
                $result = $query->getRow();
                $stats['total_kelas'] = $result->total ?? 0;
            }
            
            // Hitung total orang tua
            if ($db->tableExists('orang_tua')) {
                $query = $db->query("SELECT COUNT(*) as total FROM orang_tua WHERE is_active = 1 AND tahun_ajaran_id = ?", [$tahun_ajaran_id]);
                $result = $query->getRow();
                $stats['total_orang_tua'] = $result->total ?? 0;
            }
            
            return $stats;
            
        } catch (Exception $e) {
            log_message('error', 'Error getting dashboard stats: ' . $e->getMessage());
            return [
                'total_siswa' => 0,
                'total_kelas' => 0,
                'total_orang_tua' => 0,
                'active_tahun_ajaran' => 0
            ];
        }
    }
}
