<?php

namespace App\Controllers;

use App\Models\DashboardBKModel;

class DashboardBK extends BaseController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardBKModel();
    }

    public function index()
    {
        // Mendapatkan data progress
        $progressData = $this->dashboardModel->getProgressData();
        
        // Data untuk dashboard
        $data = [
            'title' => 'Dashboard Bimbingan Konseling',
            
            // Statistik utama
            'totalSiswa' => $this->dashboardModel->getTotalSiswa(),
            'sesiKonselingBulanIni' => $this->dashboardModel->getSesiKonselingBulanIni(),
            'asesmenPending' => $this->dashboardModel->getAsesmenPending(),
            'kasusPrioritas' => $this->dashboardModel->getKasusPrioritas(),
            
            // Progress data
            'progressIndividual' => $progressData['individual'],
            'progressKelompok' => $progressData['kelompok'],
            'progressAsesmen' => $progressData['asesmen'],
            
            // Jadwal hari ini
            'jadwalHariIni' => $this->dashboardModel->getJadwalHariIni(),
            
            // Siswa prioritas
            'siswaPrioritas' => $this->dashboardModel->getSiswaPrioritas(),
            
            // Data untuk grafik
            'trendData' => $this->dashboardModel->getTrendData(),
            'categoryData' => $this->dashboardModel->getCategoryData()
        ];

        return view('dashboard/dashboard_content', $data);
    }

    // Method untuk AJAX endpoints
    public function getStatistik()
    {
        $data = [
            'totalSiswa' => $this->dashboardModel->getTotalSiswa(),
            'sesiKonseling' => $this->dashboardModel->getSesiKonselingBulanIni(),
            'asesmenPending' => $this->dashboardModel->getAsesmenPending(),
            'kasusPrioritas' => $this->dashboardModel->getKasusPrioritas()
        ];
        
        return $this->response->setJSON($data);
    }

    public function getChartData($type)
    {
        switch ($type) {
            case 'trend':
                return $this->response->setJSON($this->dashboardModel->getTrendData());
            case 'category':
                return $this->response->setJSON($this->dashboardModel->getCategoryData());
            default:
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Chart type not found']);
        }
    }

    public function getJadwalHariIni()
    {
        return $this->response->setJSON($this->dashboardModel->getJadwalHariIni());
    }

    public function getSiswaPrioritas()
    {
        return $this->response->setJSON($this->dashboardModel->getSiswaPrioritas());
    }

    public function getProgressData()
    {
        return $this->response->setJSON($this->dashboardModel->getProgressData());
    }
}
