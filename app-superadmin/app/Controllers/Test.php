<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Test extends BaseController
{
    public function index()
    {
        echo "Test Controller berhasil!";
    }
    
    public function dashboard()
    {
        // Simple test dashboard
        $data = [
            'title' => 'Dashboard Super Admin - Test',
            'user' => [
                'id' => 1,
                'username' => 'superadmin',
                'full_name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'role_name' => 'superadmin'
            ],
            'stats' => [
                'total_users' => 1,
                'active_users' => 1,
                'total_guru' => 0,
                'total_siswa' => 0,
                'total_admin' => 0,
                'total_superadmin' => 1,
                'recent_activities' => []
            ]
        ];

        return view('dashboard/index', $data);
    }
    
    public function simple()
    {
        echo "<h1>Simple Test</h1>";
        echo "<p>This is a simple test page.</p>";
        echo "<p>Session user_id: " . session()->get('user_id') . "</p>";
        echo "<p>Session role_name: " . session()->get('role_name') . "</p>";
        echo "<p><a href='/test/dashboard'>Test Dashboard</a></p>";
    }
}
