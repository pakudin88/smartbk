<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    
    public function dashboard()
    {
        // TEMPORARY: Disable authentication for testing
        // TODO: Re-enable authentication after testing
        /*
        // Cek apakah user sudah login
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        // Cek apakah user adalah Super Admin
        if (session()->get('role_name') !== 'Super Admin') {
            session()->setFlashdata('error', 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
            return redirect()->to('/login');
        }
        */

        // Ambil data statistik
        $stats = $this->getDashboardStats();
        
        // Data untuk dashboard
        $data = [
            'title' => 'Dashboard Super Admin',
            'user' => [
                'id' => session()->get('user_id') ?? 1,
                'name' => session()->get('full_name') ?? 'Administrator',
                'username' => session()->get('username') ?? 'admin',
                'email' => session()->get('email') ?? 'admin@test.com',
                'role' => session()->get('role_name') ?? 'Super Admin'
            ],
            'stats' => $stats
        ];

        return view('dashboard/index', $data);
    }

    public function dashboardTest()
    {
        // Temporary method for testing - bypass authentication
        
        // Ambil data statistik
        $stats = $this->getDashboardStats();
        
        // Data untuk dashboard
        $data = [
            'title' => 'Dashboard Super Admin (Test)',
            'user' => [
                'id' => 1,
                'name' => 'Administrator Test',
                'username' => 'admin_test',
                'email' => 'admin@test.com',
                'role' => 'Super Admin'
            ],
            'stats' => $stats
        ];

        return view('dashboard/index', $data);
    }

    private function getDashboardStats()
    {
        $stats = [
            'total_users' => 0,
            'total_schools' => 0,
            'total_classes' => 0,
            'total_subjects' => 0,
            'total_guru' => 0,
            'total_siswa' => 0,
            'total_admin' => 0,
            'total_kepala_sekolah' => 0,
            'total_pengguna_aktif' => 0,
            'active_users' => 0,
            'recent_activities' => [],
            'active_school_year' => null,
            'active_school_year_stats' => [
                'classes' => 0,
                'subjects' => 0,
                'students' => 0,
                'teachers' => 0,
                'kepala_sekolah' => 0,
                'admin' => 0,
                'total_aktif' => 0
            ]
        ];

        try {
            // DIRECT APPROACH: Use simple mysqli connection
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'sekolah_multiapp';
            
            $connection = new \mysqli($host, $username, $password, $database);
            
            if ($connection->connect_error) {
                // Connection failed, set null
                $stats['active_school_year'] = null;
            } else {
                // Query for active school year
                $sql = "SELECT * FROM school_years WHERE is_active = 1 ORDER BY id DESC LIMIT 1";
                $result = $connection->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    $activeSchoolYear = $result->fetch_assoc();
                    $stats['active_school_year'] = $activeSchoolYear;
                } else {
                    $stats['active_school_year'] = null;
                }
                
                $connection->close();
            }
            
            // FALLBACK: If still no data, try CodeIgniter connection
            if (!$stats['active_school_year']) {
                try {
                    $db = \Config\Database::connect();
                    $query = $db->query("SELECT * FROM school_years WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
                    $result = $query->getRowArray();
                    
                    if ($result) {
                        $stats['active_school_year'] = $result;
                    }
                } catch (Exception $e) {
                    // CodeIgniter failed too, leave as null
                }
            }
            
            // Continue with other stats
            $db = \Config\Database::connect();
            
            // Total users
            $query = $db->query("SELECT COUNT(*) as total FROM users");
            $result = $query->getRow();
            $stats['total_users'] = $result->total;
            
            // Active users
            $query = $db->query("SELECT COUNT(*) as total FROM users WHERE is_active = 1");
            $result = $query->getRow();
            $stats['active_users'] = $result->total;
            
            // Total schools
            $query = $db->query("SELECT COUNT(*) as total FROM sekolah");
            $result = $query->getRow();
            $stats['total_schools'] = $result->total;
            
            // Statistics based on active school year
            if ($stats['active_school_year']) {
                $activeSchoolYearId = $stats['active_school_year']['id'];
                
                // Classes in active school year
                $query = $db->query("SELECT COUNT(*) as total FROM kelas WHERE tahun_ajaran_id = ?", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_classes'] = $result->total;
                $stats['active_school_year_stats']['classes'] = $result->total;
                
                // Subjects in active school year
                $query = $db->query("SELECT COUNT(*) as total FROM mata_pelajaran WHERE tahun_ajaran_id = ?", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_subjects'] = $result->total;
                $stats['active_school_year_stats']['subjects'] = $result->total;
                
                // Students in active school year
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Siswa' AND u.tahun_ajaran_id = ?
                ", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_siswa'] = $result->total;
                $stats['active_school_year_stats']['students'] = $result->total;
                
                // Teachers in active school year
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Guru' AND u.tahun_ajaran_id = ?
                ", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_guru'] = $result->total;
                $stats['active_school_year_stats']['teachers'] = $result->total;
                
                // Kepala Sekolah in active school year
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Kepala Sekolah' AND u.tahun_ajaran_id = ?
                ", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_kepala_sekolah'] = $result->total;
                $stats['active_school_year_stats']['kepala_sekolah'] = $result->total;
                
                // Admin in active school year
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name IN ('Super Admin', 'Admin') AND u.tahun_ajaran_id = ?
                ", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_admin'] = $result->total;
                $stats['active_school_year_stats']['admin'] = $result->total;
                
                // Total pengguna aktif (tanpa wali murid/orangtua)
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name NOT IN ('Orangtua', 'Wali Murid') AND u.tahun_ajaran_id = ?
                ", [$activeSchoolYearId]);
                $result = $query->getRow();
                $stats['total_pengguna_aktif'] = $result->total;
                $stats['active_school_year_stats']['total_aktif'] = $result->total;
            } else {
                // Fallback to total counts if no active school year
                $query = $db->query("SELECT COUNT(*) as total FROM kelas");
                $result = $query->getRow();
                $stats['total_classes'] = $result->total;
                
                $query = $db->query("SELECT COUNT(*) as total FROM mata_pelajaran");
                $result = $query->getRow();
                $stats['total_subjects'] = $result->total;
                
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Siswa'
                ");
                $result = $query->getRow();
                $stats['total_siswa'] = $result->total;
                
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Guru'
                ");
                $result = $query->getRow();
                $stats['total_guru'] = $result->total;
                
                // Kepala Sekolah (fallback)
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name = 'Kepala Sekolah'
                ");
                $result = $query->getRow();
                $stats['total_kepala_sekolah'] = $result->total;
                
                // Admin (fallback)
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name IN ('Super Admin', 'Admin')
                ");
                $result = $query->getRow();
                $stats['total_admin'] = $result->total;
                
                // Total pengguna aktif tanpa wali murid (fallback)
                $query = $db->query("
                    SELECT COUNT(*) as total 
                    FROM users u 
                    JOIN roles r ON u.role_id = r.id 
                    WHERE r.role_name NOT IN ('Orangtua', 'Wali Murid')
                ");
                $result = $query->getRow();
                $stats['total_pengguna_aktif'] = $result->total;
            }
            
            // Recent activities (last 10 users)
            $query = $db->query("
                SELECT u.full_name, u.username, r.role_name, u.last_login, u.created_at
                FROM users u
                JOIN roles r ON u.role_id = r.id
                ORDER BY u.created_at DESC
                LIMIT 10
            ");
            $stats['recent_activities'] = $query->getResultArray();

        } catch (Exception $e) {
            log_message('error', 'Error getting dashboard stats: ' . $e->getMessage());
        }

        return $stats;
    }
}
