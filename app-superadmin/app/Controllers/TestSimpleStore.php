<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Exception;

class TestSimpleStore extends BaseController
{
    public function store()
    {
        // Debug: Force output
        echo "<h2>Test Simple Store Method</h2>";
        echo "<p>Method called successfully</p>";
        
        // Get POST data
        $postData = $this->request->getPost();
        echo "<h3>POST Data Received:</h3>";
        echo "<pre>" . print_r($postData, true) . "</pre>";
        
        // Test database insert
        if (!empty($postData)) {
            $userModel = new UserModel();
            
            $userData = [
                'username' => $postData['username'] ?? 'test_' . time(),
                'email' => $postData['email'] ?? 'test_' . time() . '@example.com',
                'password' => password_hash($postData['password'] ?? 'password123', PASSWORD_DEFAULT),
                'full_name' => $postData['full_name'] ?? 'Test User',
                'role_id' => $postData['role_id'] ?? 1,
                'is_active' => !empty($postData['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            echo "<h3>User Data to Insert:</h3>";
            echo "<pre>" . print_r($userData, true) . "</pre>";
            
            try {
                $result = $userModel->insert($userData);
                if ($result) {
                    echo "<h3>✅ SUCCESS!</h3>";
                    echo "<p>User inserted with ID: " . $result . "</p>";
                    echo "<p><a href='" . base_url('users') . "'>Go to Users List</a></p>";
                } else {
                    echo "<h3>❌ FAILED!</h3>";
                    echo "<p>Insert returned false</p>";
                }
            } catch (Exception $e) {
                echo "<h3>❌ ERROR!</h3>";
                echo "<p>Exception: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<h3>No POST data received</h3>";
        }
        
        return;
    }
}
