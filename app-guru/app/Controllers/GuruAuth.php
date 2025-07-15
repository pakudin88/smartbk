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
        
        $data = [
            'title' => 'Login Guru - Smart BookKeeping',
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
        
        // Check user in users table with role_id = 2 (guru)
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM users WHERE username = ? AND role_id = 2 AND is_active = 1", [$username]);
        $user = $query->getRow();
        
        if ($user && password_verify($password, $user->password)) {
            // Determine specific role based on user data or additional checks
            $specificRole = $this->determineSpecificRole($user);
            
            // Set session
            $this->session->set([
                'guru_logged_in' => true,
                'user_id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'user_role' => $specificRole, // Specific role for menu filtering
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

        return view('guru/dashboard_new', $data);
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
            $tahun_ajaran_id = $this->session->get('tahun_ajaran_id') ?? 1; // Default fallback
            
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
                $query = $db->query("SELECT COUNT(*) as total FROM kelas WHERE tahun_ajaran_id = ? AND status = 'aktif'", [$tahun_ajaran_id]);
                $result = $query->getRow();
                $stats['total_kelas'] = $result->total ?? 0;
            }
            
            // Hitung total orang tua (menggunakan tabel users dengan role orang tua jika ada, atau tabel khusus)
            if ($db->tableExists('users')) {
                // Coba dengan role_id untuk orang tua (asumsi role_id = 4)
                $query = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 4 AND is_active = 1", []);
                $result = $query->getRow();
                $stats['total_orang_tua'] = $result->total ?? 0;
            } elseif ($db->tableExists('orang_tua')) {
                // Fallback ke tabel orang_tua jika ada
                $query = $db->query("SELECT COUNT(*) as total FROM orang_tua WHERE is_active = 1", []);
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
                'active_tahun_ajaran' => 1
            ];
        }
    }
    
    // Method untuk menentukan role spesifik guru
    private function determineSpecificRole($user)
    {
        $db = \Config\Database::connect();
        
        try {
            // Check if user is a class teacher (wali kelas) based on kelas_id in users table
            $isWaliKelas = !empty($user->kelas_id);
            
            // Check if user is BK teacher (based on subject or specific field)
            if ($db->tableExists('mata_pelajaran') && $db->tableExists('guru_mata_pelajaran')) {
                $bkQuery = $db->query("SELECT COUNT(*) as count FROM mata_pelajaran mp 
                                      JOIN guru_mata_pelajaran gmp ON mp.id = gmp.mata_pelajaran_id 
                                      WHERE gmp.user_id = ? AND (mp.nama_mapel LIKE '%BK%' OR mp.nama_mapel LIKE '%Konseling%' OR mp.nama_mapel LIKE '%Bimbingan%')", [$user->id]);
                $isBK = $bkQuery->getRow()->count > 0;
            } else {
                $isBK = false;
            }
            
            // Check if user is headmaster (based on role or specific field in guru_profiles)
            $isHeadmaster = false;
            if ($db->tableExists('guru_profiles')) {
                $headmasterQuery = $db->query("SELECT specialization FROM guru_profiles WHERE user_id = ?", [$user->id]);
                $guruData = $headmasterQuery->getRow();
                $isHeadmaster = $guruData && (strpos(strtolower($guruData->specialization ?? ''), 'kepala') !== false);
            }
            
            // Determine specific role
            if ($isHeadmaster) {
                return 'kepala_sekolah';
            } elseif ($isBK) {
                return 'guru_bk';
            } elseif ($isWaliKelas) {
                return 'wali_kelas';
            } else {
                return 'guru_mapel';
            }
            
        } catch (Exception $e) {
            log_message('error', 'Error determining user role: ' . $e->getMessage());
            return 'guru_mapel'; // Default role
        }
    }
}
