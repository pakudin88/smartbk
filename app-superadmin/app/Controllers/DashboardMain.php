<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardMain extends Controller
{
    public function index()
    {
        echo "DashboardMain Controller berhasil di-load!<br>";
        echo "Session user_id: " . session()->get('user_id') . "<br>";
        echo "Session role_name: " . session()->get('role_name') . "<br>";
        
        // Jika session tidak ada, arahkan ke login
        if (!session()->get('user_id')) {
            echo "Tidak ada session, redirect ke login...";
            return redirect()->to('/login');
        }
        
        // Jika bukan Super Admin, arahkan ke login
        if (session()->get('role_name') !== 'Super Admin') {
            echo "Bukan Super Admin, redirect ke login...";
            return redirect()->to('/login');
        }
        
        echo "Akses diizinkan untuk Super Admin!";
    }
}
