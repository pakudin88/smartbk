<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestForm extends BaseController
{
    public function create()
    {
        return view('test_form');
    }

    public function store()
    {
        // Log semua yang diterima
        $post_data = $this->request->getPost();
        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        
        // Buat response untuk debugging
        $debug_info = [
            'method' => $method,
            'uri' => (string)$uri,
            'post_data' => $post_data,
            'files' => $_FILES,
            'server' => [
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
                'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'] ?? 'unknown',
                'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'unknown'
            ]
        ];
        
        // Simpan ke session untuk ditampilkan
        session()->set('debug_info', $debug_info);
        
        // Test insert ke database
        if (!empty($post_data['username'])) {
            try {
                $db = \Config\Database::connect();
                $userData = [
                    'username' => $post_data['username'],
                    'email' => $post_data['email'] ?: 'test@example.com',
                    'password' => password_hash($post_data['password'] ?: 'password123', PASSWORD_DEFAULT),
                    'full_name' => $post_data['full_name'] ?: 'Test User',
                    'role_id' => $post_data['role_id'] ?: 3,
                    'is_active' => 1
                ];
                
                $result = $db->table('users')->insert($userData);
                session()->set('insert_result', $result ? 'Success' : 'Failed');
                session()->set('insert_id', $db->insertID());
                
            } catch (Exception $e) {
                session()->set('insert_error', $e->getMessage());
            }
        }
        
        // Redirect back untuk melihat hasil
        return redirect()->to(base_url('test-form/create'));
    }
}
