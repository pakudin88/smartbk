<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        // Get user data
        $userId = $session->get('user_id');
        $userName = $session->get('user_name');
        $userRole = $session->get('role_id');
        
        // Only allow students (role_id = 4)
        if ($userRole != 4) {
            $session->setFlashdata('error', 'Akses ditolak. Halaman ini khusus untuk siswa.');
            return redirect()->to('/login');
        }
        
        // Prepare data for view
        $data = [
            'title' => 'Dashboard - Safe Space BK',
            'user_name' => $userName,
            'user_id' => $userId,
            'current_time' => date('H:i'),
            'current_date' => $this->getIndonesianDate()
        ];
        
        return view('dashboard/index', $data);
    }
    
    private function getIndonesianDate()
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $days = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $day_name = $days[date('l')];
        $day = date('j');
        $month = $months[date('n')];
        $year = date('Y');
        
        return "$day_name, $day $month $year";
    }
    
    public function konsulCepat()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role_id') != 4) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Konsul Cepat - Safe Space BK',
            'user_name' => $session->get('user_name')
        ];
        
        return view('safe_space/konsul_cepat', $data);
    }
    
    public function jadwalKonseling()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role_id') != 4) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Jadwal Konseling - Safe Space BK',
            'user_name' => $session->get('user_name')
        ];
        
        return view('safe_space/jadwal_konseling', $data);
    }
    
    public function jurnalDigital()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role_id') != 4) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Jurnal Digital - Safe Space BK',
            'user_name' => $session->get('user_name')
        ];
        
        return view('safe_space/jurnal_digital_clean', $data);
    }
    
    public function pusatInformasi()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role_id') != 4) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Pusat Informasi - Safe Space BK',
            'user_name' => $session->get('user_name')
        ];
        
        return view('safe_space/pusat_informasi', $data);
    }
}
