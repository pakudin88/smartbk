<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Api extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function studentsWithoutClass()
    {
        // Pastikan user sudah login - check multiple session keys
        if (!session()->get('isLoggedIn') && !session()->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        try {
            // Clear any potential cache
            $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');
            
            // Get active school year
            $tahunAjaranModel = new \App\Models\TahunAjaranModel();
            $activeSchoolYear = $tahunAjaranModel->where('is_active', 1)->first();
            
            if (!$activeSchoolYear) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak ada tahun ajaran yang aktif'
                ]);
            }
            
            // Get students without class using new pivot model
            $muridKelasModel = new \App\Models\MuridKelasModel();
            $students = $muridKelasModel->getStudentsWithoutClass($activeSchoolYear['id']);
            
            // Add debug info
            $debugInfo = [
                'total_found' => count($students),
                'timestamp' => date('Y-m-d H:i:s'),
                'school_year' => $activeSchoolYear['nama_tahun_ajaran'],
                'query_info' => 'Looking for students without class assignment in active school year'
            ];
            
            return $this->response->setJSON([
                'success' => true,
                'students' => $students,
                'debug' => $debugInfo
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in studentsWithoutClass: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function classesWithCapacity()
    {
        // Pastikan user sudah login - check multiple session keys
        if (!session()->get('isLoggedIn') && !session()->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        try {
            $kelasModel = new \App\Models\KelasModel();
            $classes = $kelasModel->select('kelas.*, sekolah.nama_sekolah')
                                ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                                ->where('kelas.status', 'aktif')
                                ->orderBy('sekolah.nama_sekolah, kelas.tingkat, kelas.nama_kelas')
                                ->findAll();

            $classesWithCapacity = [];
            foreach ($classes as $class) {
                $capacityInfo = $kelasModel->getClassCapacityInfo($class['id']);
                $classesWithCapacity[] = array_merge($class, $capacityInfo);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'classes' => $classesWithCapacity
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
