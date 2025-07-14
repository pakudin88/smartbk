<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // For debugging, temporarily remove auth check
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }

        // Get complete user data using BaseController helper
        $userData = $this->getUserDataForView();

        // Get statistics with school year filtering
        $stats = $this->getStatsWithSchoolYear();

        // Data untuk dashboard
        $data = [
            'title' => 'Dashboard',
            'user' => $userData,
            'stats' => $stats,
            'active_school_year' => $this->getActiveSchoolYear()
        ];

        return view('dashboard/index', $data);
    }

    private function getStatsWithSchoolYear()
    {
        try {
            // Load models
            $userModel = new \App\Models\UserModel();
            $kelasModel = new \App\Models\KelasModel();
            $mataPelajaranModel = new \App\Models\MataPelajaranModel();
            
            // Get stats filtered by active school year
            $userStats = $userModel->getUserStats();
            $kelasStats = $kelasModel->getClassStats();
            $subjectStats = $mataPelajaranModel->getSubjectStats();
            
            return [
                'total_users' => $userStats['total'],
                'active_users' => $userStats['aktif'],
                'total_classes' => $kelasStats['total'],
                'active_classes' => $kelasStats['aktif'],
                'total_subjects' => $subjectStats['total'],
                'active_subjects' => $subjectStats['aktif'],
                'total_schools' => $this->getSchoolCount(),
            ];
        } catch (\Exception $e) {
            // If there's an error, return fallback data
            return [
                'total_users' => 1,
                'active_users' => 1,
                'total_classes' => 0,
                'active_classes' => 0,
                'total_subjects' => 0,
                'active_subjects' => 0,
                'total_schools' => 0,
            ];
        }
    }

    private function getActiveSchoolYear()
    {
        try {
            $tahunAjaranModel = new \App\Models\TahunAjaranModel();
            return $tahunAjaranModel->getActiveSchoolYear();
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getSchoolCount()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('sekolah');
            return $builder->countAll();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
