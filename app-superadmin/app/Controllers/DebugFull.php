<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;

class DebugFull extends BaseController
{
    public function createUser()
    {
        $roles = $this->getRoles();
        
        // Debug: Force log the roles data
        error_log("DEBUG DebugFull: Roles data in createUser(): " . print_r($roles, true));
        
        $data = [
            'title' => 'Tambah User Baru - DEBUG FULL',
            'user' => [
                'id' => 1,
                'name' => 'Test Admin',
                'username' => 'testadmin',
                'role' => 'Super Admin'
            ],
            'roles' => $roles
        ];

        // Debug: Force log the entire data array
        error_log("DEBUG DebugFull: Data array in createUser(): " . print_r($data, true));

        return view('users/create_debug_full', $data);
    }

    private function getRoles()
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->table('roles')
                ->select('id, role_name')
                ->orderBy('role_name')
                ->get()
                ->getResultArray();
            
            // Debug: Force log hasil query
            error_log("DEBUG DebugFull: getRoles query result: " . print_r($result, true));
            
            // Jika hasil kosong, return default roles
            if (empty($result)) {
                $defaultRoles = [
                    ['id' => 1, 'role_name' => 'Super Admin'],
                    ['id' => 2, 'role_name' => 'Admin'],
                    ['id' => 3, 'role_name' => 'Guru'],
                    ['id' => 4, 'role_name' => 'Siswa']
                ];
                error_log("DEBUG DebugFull: Using default roles");
                return $defaultRoles;
            }
            
            return $result;
        } catch (Exception $e) {
            // Log error dan return default roles
            error_log("DEBUG DebugFull: getRoles error: " . $e->getMessage());
            return [
                ['id' => 1, 'role_name' => 'Super Admin'],
                ['id' => 2, 'role_name' => 'Admin'],
                ['id' => 3, 'role_name' => 'Guru'],
                ['id' => 4, 'role_name' => 'Siswa']
            ];
        }
    }

    public function storeUser()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]',
            'role_id' => 'required|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Redirect back to form with error
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Mohon cek data yang diisi.');
        }

        $userModel = new \App\Models\UserModel();
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        try {
            $result = $userModel->insert($userData);
            if ($result) {
                // Redirect ke halaman users dengan notifikasi sukses
                return redirect()->to('/users')->with('success', 'User berhasil ditambahkan!');
            } else {
                // Redirect ke halaman users dengan notifikasi gagal
                return redirect()->to('/users')->with('error', 'Gagal menambahkan user ke database.');
            }
        } catch (Exception $e) {
            return redirect()->to('/users')->with('error', 'Database Error: ' . $e->getMessage());
        }
    }
}
