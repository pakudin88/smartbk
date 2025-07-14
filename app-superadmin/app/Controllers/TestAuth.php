<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestAuth extends Controller
{
    public function index()
    {
        echo "<h2>Test Auth Status</h2>";
        
        // Check session status
        echo "<h3>Session Status</h3>";
        echo "Session started: " . (session_status() === PHP_SESSION_ACTIVE ? "Yes" : "No") . "<br>";
        echo "Session ID: " . session_id() . "<br>";
        
        // Check login status
        echo "<h3>Login Status</h3>";
        $isLoggedIn = session()->get('isLoggedIn');
        echo "Is Logged In: " . ($isLoggedIn ? "Yes" : "No") . "<br>";
        
        if ($isLoggedIn) {
            echo "User ID: " . session()->get('userId') . "<br>";
            echo "Username: " . session()->get('username') . "<br>";
            echo "Role Name: " . session()->get('role_name') . "<br>";
            echo "Role ID: " . session()->get('role_id') . "<br>";
        } else {
            echo "❌ User not logged in<br>";
        }
        
        // Show all session data
        echo "<h3>All Session Data</h3>";
        $sessionData = session()->get();
        if ($sessionData) {
            echo "<pre>";
            print_r($sessionData);
            echo "</pre>";
        } else {
            echo "No session data<br>";
        }
        
        echo "<hr>";
        echo "<h3>Next Steps</h3>";
        if (!$isLoggedIn) {
            echo "You need to login first: <a href='" . base_url('login') . "'>Login</a><br>";
        } else {
            echo "You are logged in! Try accessing:<br>";
            echo "<a href='" . base_url('pengguna-sekolah') . "'>Pengguna Sekolah</a><br>";
            echo "<a href='" . base_url('pengguna-murid') . "'>Pengguna Murid</a><br>";
            echo "<a href='" . base_url('pengguna-orang-tua') . "'>Pengguna Orang Tua</a><br>";
        }
    }
    
    public function login()
    {
        echo "<h2>Quick Login for Testing</h2>";
        
        // Try to find a super admin user
        try {
            $petugasModel = new \App\Models\PetugasModel();
            $superAdmin = $petugasModel->select('petugas.*, roles.role_name')
                                     ->join('roles', 'petugas.role_id = roles.id')
                                     ->where('roles.role_name', 'Super Admin')
                                     ->first();
            
            if ($superAdmin) {
                // Set session
                session()->set([
                    'isLoggedIn' => true,
                    'userId' => $superAdmin['id'],
                    'username' => $superAdmin['username'],
                    'role_name' => $superAdmin['role_name'],
                    'role_id' => $superAdmin['role_id']
                ]);
                
                echo "✅ Auto-login successful for user: " . $superAdmin['username'] . "<br>";
                echo "Role: " . $superAdmin['role_name'] . "<br>";
                echo "<a href='" . base_url('dashboard') . "'>Go to Dashboard</a><br>";
                echo "<a href='" . base_url('pengguna-sekolah') . "'>Go to Pengguna Sekolah</a><br>";
            } else {
                echo "❌ No Super Admin user found in database<br>";
                echo "You need to create a Super Admin user first<br>";
            }
            
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }
    }
}
