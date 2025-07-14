<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Exception;

class DebugUsers extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create()
    {
        $data = [
            'title' => 'Debug - Tambah User Baru',
            'user' => [
                'id' => 1,
                'name' => 'Debug Admin',
                'username' => 'debugadmin',
                'role' => 'Super Admin'
            ],
            'roles' => $this->getRoles()
        ];

        return view('users/create_debug', $data);
    }

    public function store()
    {
        log_message('info', 'DebugUsers::store() called');
        
        // Log semua input
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        
        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]',
            'role_id' => 'required|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        log_message('info', 'User data to insert: ' . json_encode($userData));

        try {
            $result = $this->userModel->insert($userData);
            log_message('info', 'Insert result: ' . ($result ? 'Success ID: ' . $result : 'Failed'));
            
            if ($result) {
                log_message('info', 'Redirecting to users page with success message');
                return redirect()->to(base_url('users'))->with('success', 'User berhasil ditambahkan dengan ID: ' . $result);
            } else {
                log_message('error', 'Insert failed but no exception thrown');
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user ke database.');
            }
        } catch (Exception $e) {
            log_message('error', 'Exception during insert: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Database Error: ' . $e->getMessage());
        }
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
            
            if (empty($result)) {
                return [
                    ['id' => 1, 'role_name' => 'Super Admin'],
                    ['id' => 2, 'role_name' => 'Admin'],
                    ['id' => 3, 'role_name' => 'Guru'],
                    ['id' => 4, 'role_name' => 'Siswa']
                ];
            }
            
            return $result;
        } catch (Exception $e) {
            return [
                ['id' => 1, 'role_name' => 'Super Admin'],
                ['id' => 2, 'role_name' => 'Admin'],
                ['id' => 3, 'role_name' => 'Guru'],
                ['id' => 4, 'role_name' => 'Siswa']
            ];
        }
    }
}
