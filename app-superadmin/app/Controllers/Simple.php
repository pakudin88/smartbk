<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Simple extends BaseController
{
    public function index()
    {
        echo "<h1>Simple Dashboard Super Admin</h1>";
        echo "<p>Dashboard sederhana yang berfungsi!</p>";
        echo "<p>Tanggal: " . date('d F Y, H:i:s') . "</p>";
        echo "<p>Session user_id: " . (session()->get('user_id') ?? 'Tidak ada') . "</p>";
        echo "<p>Session role: " . (session()->get('role_name') ?? 'Tidak ada') . "</p>";
        echo "<hr>";
        echo "<a href='/simple/dashboard'>Dashboard dengan View</a> | ";
        echo "<a href='/simple/login'>Set Session</a>";
    }
    
    public function dashboard()
    {
        // Set session untuk testing
        session()->set([
            'user_id' => 1,
            'username' => 'superadmin',
            'role_name' => 'superadmin',
            'logged_in' => true
        ]);
        
        $data = [
            'title' => 'Simple Dashboard Super Admin',
            'user' => [
                'id' => 1,
                'username' => 'superadmin',
                'full_name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'role_name' => 'superadmin'
            ],
            'stats' => [
                'total_users' => 10,
                'active_users' => 8,
                'total_guru' => 3,
                'total_siswa' => 5,
                'total_admin' => 1,
                'total_superadmin' => 1,
                'recent_activities' => [
                    [
                        'full_name' => 'Test User',
                        'username' => 'testuser',
                        'role_name' => 'guru',
                        'created_at' => date('Y-m-d H:i:s'),
                        'last_login' => date('Y-m-d H:i:s')
                    ]
                ]
            ]
        ];

        return view('dashboard/index', $data);
    }
    
    public function login()
    {
        // Set session untuk testing
        session()->set([
            'user_id' => 1,
            'username' => 'superadmin',
            'role_name' => 'superadmin',
            'logged_in' => true
        ]);
        
        echo "<h1>Session Set</h1>";
        echo "<p>Session berhasil di-set untuk testing</p>";
        echo "<p>User ID: " . session()->get('user_id') . "</p>";
        echo "<p>Username: " . session()->get('username') . "</p>";
        echo "<p>Role: " . session()->get('role_name') . "</p>";
        echo "<hr>";
        echo "<a href='/simple/dashboard'>Akses Dashboard</a>";
    }
}
