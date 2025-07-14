<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Debug: Tampilkan pesan jika sampai ke sini
        echo "<!-- Auth Controller Reached -->";
        
        // Jika sudah login, redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        // Debug: Pastikan view file ada
        $viewPath = APPPATH . 'Views/auth/login.php';
        if (!file_exists($viewPath)) {
            die("Login view file not found: " . $viewPath);
        }
        
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        
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

        // Cari user berdasarkan username atau email
        $user = $this->userModel->getUserByLogin($username);

        if ($user && password_verify($password, $user['password'])) {
            // Cek apakah user aktif
            if (!$user['is_active']) {
                return redirect()->back()->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
            }

            // Cek role - hanya Super Admin yang bisa login di app ini
            if ($user['role_name'] !== 'Super Admin') {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke aplikasi ini.');
            }

            // Set session
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'role_name' => $user['role_name'],
                'isLoggedIn' => true
            ];
            $session->set($sessionData);

            // Update last login
            $this->userModel->updateLastLogin($user['id']);

            return $this->redirectToDashboard()->with('success', 'Selamat datang, ' . $user['full_name'] . '!');
        } else {
            return redirect()->back()->with('error', 'Username/Email atau Password salah.');
        }
    }

    public function logout()
    {
        // Clear session
        session()->destroy();
        
        // Redirect to login with success message
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }

    private function redirectToDashboard()
    {
        return redirect()->to('/dashboard');
    }
}
