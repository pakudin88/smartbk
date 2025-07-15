<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class RoleDashboard extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    /**
     * Main dashboard router - redirects based on user role
     */
    public function index()
    {
        // Check if user is logged in (using the same session key as GuruAuth)
        if (!session()->get('guru_logged_in')) {
            return redirect()->to('/login');
        }

        // Get user role from session (you should implement this based on your auth system)
        $userRole = $this->getUserRole();
        
        switch ($userRole) {
            case 'guru_bk':
                return $this->dashboardGuruBK();
            case 'guru_kelas':
                return $this->dashboardGuruKelas();
            case 'wali_kelas':
                return $this->dashboardWaliKelas();
            case 'kepala_sekolah':
                return $this->dashboardKepalaSekolah();
            default:
                return redirect()->to('/login')->with('error', 'Role tidak dikenali');
        }
    }

    /**
     * Dashboard untuk Guru BK (Bimbingan Konseling)
     */
    public function dashboardGuruBK()
    {
        // Data untuk dashboard Guru BK
        $data = [
            'title' => 'Dashboard Guru BK - SmartBK',
            'user_role' => 'guru_bk',
            'stats' => [
                'siswa_terbimbing' => 145,
                'sesi_konseling' => 28,
                'kasus_prioritas' => 7,
                'asesmen_selesai' => 42
            ],
            'quick_actions' => $this->getQuickActionsGuruBK(),
            'recent_activities' => $this->getRecentActivitiesGuruBK(),
            'counseling_schedule' => $this->getCounselingSchedule()
        ];

        return view('guru/dashboard', $data);
    }

    /**
     * Dashboard untuk Guru Kelas
     */
    public function dashboardGuruKelas()
    {
        // Data untuk dashboard Guru Kelas
        $data = [
            'title' => 'Dashboard Guru Kelas - SmartBK',
            'user_role' => 'guru_kelas',
            'stats' => [
                'total_siswa' => 32,
                'mata_pelajaran' => 3,
                'tugas_pending' => 8,
                'kehadiran_hari_ini' => 94
            ],
            'class_info' => [
                'nama_kelas' => 'XI-A',
                'mata_pelajaran' => ['Matematika', 'Fisika', 'Kimia']
            ],
            'student_progress' => $this->getStudentProgress(),
            'grade_distribution' => $this->getGradeDistribution(),
            'recent_activities' => $this->getRecentActivitiesGuruKelas()
        ];

        return view('guru/dashboard_guru_kelas', $data);
    }

    /**
     * Dashboard untuk Wali Kelas
     */
    public function dashboardWaliKelas()
    {
        // Data untuk dashboard Wali Kelas
        $data = [
            'title' => 'Dashboard Wali Kelas - SmartBK',
            'user_role' => 'wali_kelas',
            'stats' => [
                'siswa_wali' => 32,
                'kehadiran_rata_rata' => 94.5,
                'siswa_perlu_perhatian' => 5,
                'rata_rata_nilai' => 82.8
            ],
            'class_info' => [
                'nama_kelas' => 'XI-IPA 1',
                'wali_kelas' => 'Bapak/Ibu [Nama]'
            ],
            'students_attention' => $this->getStudentsNeedAttention(),
            'monitoring_data' => $this->getMonitoringData(),
            'parent_contacts' => $this->getParentContacts()
        ];

        return view('guru/dashboard_wali_kelas', $data);
    }

    /**
     * Dashboard untuk Kepala Sekolah
     */
    public function dashboardKepalaSekolah()
    {
        // Data untuk dashboard Kepala Sekolah
        $data = [
            'title' => 'Dashboard Executive - SmartBK',
            'user_role' => 'kepala_sekolah',
            'stats' => [
                'total_siswa' => 1247,
                'total_guru' => 78,
                'rata_rata_nilai' => 84.2,
                'tingkat_kehadiran' => 96.8
            ],
            'school_info' => [
                'nama_sekolah' => 'SMA Negeri 1',
                'tahun_ajaran' => '2024/2025',
                'akreditasi' => 'A'
            ],
            'performance_data' => $this->getSchoolPerformance(),
            'class_distribution' => $this->getClassDistribution(),
            'alerts' => $this->getSchoolAlerts(),
            'kpi' => $this->getKPI()
        ];

        return view('guru/dashboard_kepala_sekolah', $data);
    }

    /**
     * Get user role from session/database
     */
    private function getUserRole()
    {
        // Get role from session (set by GuruAuth during login)
        $userRole = $this->session->get('user_role');
        
        // Map 'guru_mapel' to 'guru_kelas' for our dashboard system
        if ($userRole === 'guru_mapel') {
            $userRole = 'guru_kelas';
        }
        
        // For testing purposes when no session exists, default to guru_bk
        if (!$userRole) {
            $userRole = 'guru_bk'; // Default for testing - remove in production
        }
        
        return $userRole;
    }

    /**
     * Get quick actions for Guru BK
     */
    private function getQuickActionsGuruBK()
    {
        return [
            [
                'title' => 'Konseling Individual',
                'description' => 'Jadwalkan sesi konseling',
                'icon' => 'fa-user-friends',
                'link' => '/konseling/individual',
                'color' => 'primary'
            ],
            [
                'title' => 'Konseling Kelompok',
                'description' => 'Kelola grup konseling',
                'icon' => 'fa-users',
                'link' => '/konseling/kelompok',
                'color' => 'success'
            ],
            [
                'title' => 'Asesmen Siswa',
                'description' => 'Buat asesmen psikologis',
                'icon' => 'fa-clipboard-list',
                'link' => '/asesmen',
                'color' => 'info'
            ],
            [
                'title' => 'Bimbingan Karir',
                'description' => 'Panduan pilihan karir',
                'icon' => 'fa-briefcase',
                'link' => '/bimbingan-karir',
                'color' => 'warning'
            ]
        ];
    }

    /**
     * Get recent activities for Guru BK
     */
    private function getRecentActivitiesGuruBK()
    {
        return [
            [
                'title' => 'Sesi konseling dengan Ahmad selesai',
                'description' => 'Konseling individual tentang masalah akademik',
                'time' => '2 jam yang lalu',
                'type' => 'success'
            ],
            [
                'title' => 'Asesmen kepribadian diselesaikan',
                'description' => '15 siswa kelas XI telah menyelesaikan tes',
                'time' => '5 jam yang lalu',
                'type' => 'info'
            ],
            [
                'title' => 'Kasus prioritas ditambahkan',
                'description' => 'Siswa dengan masalah keluarga memerlukan perhatian',
                'time' => '1 hari yang lalu',
                'type' => 'warning'
            ]
        ];
    }

    /**
     * Get counseling schedule
     */
    private function getCounselingSchedule()
    {
        return [
            [
                'time' => '08:00',
                'student' => 'Siti Aminah',
                'type' => 'Individual',
                'topic' => 'Masalah Akademik'
            ],
            [
                'time' => '10:00',
                'student' => 'Grup XI-A',
                'type' => 'Kelompok',
                'topic' => 'Bimbingan Karir'
            ],
            [
                'time' => '13:00',
                'student' => 'Ahmad Rahman',
                'type' => 'Individual',
                'topic' => 'Konseling Sosial'
            ]
        ];
    }

    /**
     * Get student progress for Guru Kelas
     */
    private function getStudentProgress()
    {
        return [
            'matematika' => [75, 78, 82, 79, 85, 88],
            'fisika' => [72, 76, 74, 81, 83, 86],
            'kimia' => [70, 73, 77, 75, 80, 82]
        ];
    }

    /**
     * Get grade distribution
     */
    private function getGradeDistribution()
    {
        return [
            'A' => 25,
            'B' => 40,
            'C' => 35
        ];
    }

    /**
     * Get recent activities for Guru Kelas
     */
    private function getRecentActivitiesGuruKelas()
    {
        return [
            [
                'title' => 'Tugas Matematika dikumpulkan',
                'description' => '25 dari 32 siswa telah mengumpulkan tugas',
                'time' => '2 jam yang lalu',
                'type' => 'success'
            ],
            [
                'title' => 'Quiz Fisika selesai dinilai',
                'description' => 'Rata-rata nilai kelas: 82.5',
                'time' => '5 jam yang lalu',
                'type' => 'info'
            ]
        ];
    }

    /**
     * Get students need attention for Wali Kelas
     */
    private function getStudentsNeedAttention()
    {
        return [
            [
                'name' => 'Ahmad Hidayat',
                'nisn' => '0012345678',
                'issues' => ['Absen 3 hari', 'Nilai turun'],
                'priority' => 'high'
            ],
            [
                'name' => 'Siti Permata',
                'nisn' => '0012345679',
                'issues' => ['Sering terlambat'],
                'priority' => 'medium'
            ],
            [
                'name' => 'Rian Dwi',
                'nisn' => '0012345680',
                'issues' => ['Konseling BK'],
                'priority' => 'low'
            ]
        ];
    }

    /**
     * Get monitoring data for Wali Kelas
     */
    private function getMonitoringData()
    {
        return [
            'kehadiran' => [92, 94, 91, 95, 93, 94.5],
            'nilai_rata_rata' => [78, 80, 79, 83, 81, 82.8]
        ];
    }

    /**
     * Get parent contacts
     */
    private function getParentContacts()
    {
        return [
            [
                'student' => 'Ahmad Hidayat',
                'parent' => 'Bpk. Hidayat',
                'phone' => '08123456789',
                'last_contact' => '2 hari yang lalu'
            ]
        ];
    }

    /**
     * Get school performance data for Kepala Sekolah
     */
    private function getSchoolPerformance()
    {
        return [
            'nilai_rata_rata' => [82, 83.5, 84, 83.8, 84.5, 84.2],
            'kehadiran' => [95, 96, 95.5, 97, 96.5, 96.8],
            'kepuasan_ortu' => [4.0, 4.1, 4.0, 4.2, 4.1, 4.2]
        ];
    }

    /**
     * Get class distribution
     */
    private function getClassDistribution()
    {
        return [
            'Kelas X' => 35,
            'Kelas XI' => 33,
            'Kelas XII' => 32
        ];
    }

    /**
     * Get school alerts
     */
    private function getSchoolAlerts()
    {
        return [
            [
                'type' => 'info',
                'title' => 'Rapat Koordinasi',
                'message' => 'Rapat koordinasi bulanan dijadwalkan hari ini pukul 14:00'
            ],
            [
                'type' => 'warning',
                'title' => 'Laporan Pending',
                'message' => '3 laporan bulanan belum diserahkan dari guru kelas'
            ],
            [
                'type' => 'success',
                'title' => 'Prestasi Sekolah',
                'message' => 'Sekolah meraih juara 2 lomba OSN tingkat provinsi'
            ],
            [
                'type' => 'danger',
                'title' => 'Perhatian Khusus',
                'message' => '15 siswa memiliki tingkat absensi di bawah standar'
            ]
        ];
    }

    /**
     * Get Key Performance Indicators
     */
    private function getKPI()
    {
        return [
            'target_kelulusan' => 98.5,
            'akreditasi' => 95,
            'kepuasan_ortu' => 84,
            'prestasi_sekolah' => 92
        ];
    }

    /**
     * API endpoint to switch dashboard view (for testing)
     */
    public function switchRole($role)
    {
        $validRoles = ['guru_bk', 'guru_kelas', 'wali_kelas', 'kepala_sekolah'];
        
        if (in_array($role, $validRoles)) {
            $this->session->set('user_role', $role);
            return redirect()->to('/dashboard')->with('success', 'Role berhasil diubah ke ' . $role);
        }
        
        return redirect()->to('/dashboard')->with('error', 'Role tidak valid');
    }
}
