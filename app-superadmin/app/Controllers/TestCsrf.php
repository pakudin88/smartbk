<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Exception;

class TestCsrf extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create()
    {
        $data = [
            'title' => 'Test CSRF - Tambah User Baru',
            'user' => [
                'id' => 1,
                'name' => 'Test Admin',
                'full_name' => 'Test Administrator',
                'username' => 'testadmin',
                'role' => 'Super Admin',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('users/create_test_csrf', $data);
    }

    public function store()
    {
        // Debug: Log all request data
        error_log("DEBUG TestCsrf: store() method called");
        error_log("DEBUG TestCsrf: REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
        error_log("DEBUG TestCsrf: POST data: " . print_r($_POST, true));
        error_log("DEBUG TestCsrf: All request data: " . print_r($this->request->getPost(), true));
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]',
            'role_id' => 'required|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            error_log("DEBUG TestCsrf: Validation failed: " . print_r($validation->getErrors(), true));
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

        error_log("DEBUG TestCsrf: User data to insert: " . print_r($userData, true));

        try {
            $result = $this->userModel->insert($userData);
            error_log("DEBUG TestCsrf: Insert result: " . print_r($result, true));
            
            if ($result) {
                error_log("DEBUG TestCsrf: User inserted successfully with ID: " . $result);
                // Redirect ke halaman users dengan pesan sukses
                return redirect()->to(base_url('users'))->with('success', 'User berhasil ditambahkan dengan ID: ' . $result);
            } else {
                error_log("DEBUG TestCsrf: Insert failed - userModel->insert returned false");
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user ke database.');
            }
        } catch (Exception $e) {
            error_log("DEBUG TestCsrf: Exception during insert: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }
}
