<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MuridModel;

class Auth extends BaseController
{
    protected $session;
    protected $muridModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->muridModel = new MuridModel();
    }

    // Display login page
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->get('isLoggedIn') && $this->session->get('role') === 'murid') {
            return redirect_with_port('/dashboard');
        }
        
        $data = [
            'title' => 'Login - Aplikasi Murid',
            'current_url' => $this->getCurrentUrlForView()
        ];
        
        return view('auth/login', $data);
    }

    // Process login
    public function processLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Validation
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password harus diisi');
        }
        
        // Load database
        $db = \Config\Database::connect();
        
        // Check user in users table (remote database structure)
        // Role ID 4 = students/siswa
        $builder = $db->table('users');
        $user = $builder->where('username', $username)
                       ->where('role_id', 4)
                       ->where('is_active', 1)
                       ->get()
                       ->getRowArray();
        
        if ($user && password_verify($password, $user['password'])) {
            // Get or create murid profile data
            $muridData = $this->muridModel->getMuridWithDetails($user['id']);
            
            // If murid profile doesn't exist, create it
            if (!$muridData) {
                $this->muridModel->createMuridProfile($user['id'], $user);
                $muridData = $this->muridModel->getMuridWithDetails($user['id']);
            }

            // Login success - combine user and murid data
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['full_name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'role' => 'murid',
                'isLoggedIn' => true
            ];
            
            // Add murid specific data if exists
            if ($muridData) {
                $sessionData['murid_id'] = $muridData['id'];
                $sessionData['nisn'] = $muridData['nisn'];
                $sessionData['nis'] = $muridData['nis'];
                $sessionData['nama_lengkap'] = $muridData['nama_lengkap'];
                $sessionData['kelas'] = $muridData['nama_kelas'];
                $sessionData['tingkat'] = $muridData['tingkat'];
                $sessionData['tahun_ajaran'] = $muridData['nama_tahun_ajaran'];
                $sessionData['foto'] = $muridData['foto'];
            }

            $this->session->set($sessionData);
            
            // Update last login
            $builder->where('id', $user['id'])
                    ->update(['last_login' => date('Y-m-d H:i:s')]);
            
            return redirect_with_port('/dashboard')->with('success', 'Login berhasil! Selamat datang ' . ($muridData['nama_lengkap'] ?? $user['full_name']));
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    // Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect_with_port('/login')->with('success', 'Anda telah logout');
    }

    // Redirect to dashboard (handled by Dashboard controller)
    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'murid') {
            return redirect_with_port('/login');
        }
        
        // Redirect to the new Dashboard controller
        return redirect()->to(base_url('dashboard'));
    }
}
