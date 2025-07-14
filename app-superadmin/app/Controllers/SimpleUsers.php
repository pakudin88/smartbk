<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Exception;

class SimpleUsers extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create()
    {
        // Data roles langsung tanpa database query
        $roles = [
            ['id' => 1, 'role_name' => 'Super Admin'],
            ['id' => 2, 'role_name' => 'Admin'],
            ['id' => 3, 'role_name' => 'Guru'],
            ['id' => 4, 'role_name' => 'Siswa']
        ];

        $data = [
            'title' => 'Simple - Tambah User Baru',
            'roles' => $roles
        ];

        return view('users/create_simple', $data);
    }

    public function store()
    {
        // Tanpa validasi untuk test simpel
        $userData = [
            'username' => $this->request->getPost('username') ?: 'simple_' . time(),
            'email' => $this->request->getPost('email') ?: 'simple_' . time() . '@test.com',
            'password' => password_hash($this->request->getPost('password') ?: 'password123', PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name') ?: 'Simple User',
            'role_id' => $this->request->getPost('role_id') ?: 3,
            'is_active' => 1
        ];

        // Direct database insert
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        if ($builder->insert($userData)) {
            // Explicit redirect dengan full URL
            $redirectUrl = base_url('users');
            header("Location: $redirectUrl");
            exit();
        } else {
            // Kembali ke form dengan error
            return redirect()->back()->with('error', 'Gagal menyimpan user');
        }
    }
}
