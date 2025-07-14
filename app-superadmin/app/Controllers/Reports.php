<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SekolahModel;
use App\Models\KelasModel;
use App\Models\MataPelajaranModel;
use App\Models\TahunAjaranModel;
use CodeIgniter\Controller;

class Reports extends Controller
{
    protected $userModel;
    protected $sekolahModel;
    protected $kelasModel;
    protected $mataPelajaranModel;
    protected $tahunAjaranModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->sekolahModel = new SekolahModel();
        $this->kelasModel = new KelasModel();
        $this->mataPelajaranModel = new MataPelajaranModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
    }

    public function index()
    {
        // Set session untuk testing
        session()->set([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin',
            'full_name' => 'Administrator',
            'role_name' => 'Super Admin'
        ]);

        $data = [
            'title' => 'Laporan Sistem',
            'stats' => $this->getSystemStats(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('reports/index', $data);
    }

    public function users()
    {
        // Set session untuk testing
        session()->set([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin',
            'full_name' => 'Administrator',
            'role_name' => 'Super Admin'
        ]);

        $data = [
            'title' => 'Laporan Pengguna',
            'users' => $this->userModel->getUsersWithRoles(),
            'userStats' => $this->getUserStats(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('reports/users', $data);
    }

    public function schools()
    {
        // Set session untuk testing
        session()->set([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin',
            'full_name' => 'Administrator',
            'role_name' => 'Super Admin'
        ]);

        $data = [
            'title' => 'Laporan Sekolah',
            'schools' => $this->sekolahModel->findAll(),
            'schoolStats' => $this->getSchoolStats(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('reports/schools', $data);
    }

    public function classes()
    {
        // Set session untuk testing
        session()->set([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin',
            'full_name' => 'Administrator',
            'role_name' => 'Super Admin'
        ]);

        $data = [
            'title' => 'Laporan Kelas',
            'classes' => $this->kelasModel->getClassesWithSchool(),
            'classStats' => $this->getClassStats(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('reports/classes', $data);
    }

    public function subjects()
    {
        // Set session untuk testing
        session()->set([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin',
            'full_name' => 'Administrator',
            'role_name' => 'Super Admin'
        ]);

        $data = [
            'title' => 'Laporan Mata Pelajaran',
            'subjects' => $this->mataPelajaranModel->findAll(),
            'subjectStats' => $this->getSubjectStats(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('reports/subjects', $data);
    }

    public function export($type = 'users')
    {
        $data = [];
        $filename = '';

        switch ($type) {
            case 'users':
                $data = $this->userModel->getUsersWithRoles();
                $filename = 'laporan_pengguna_' . date('Y-m-d');
                break;
            case 'schools':
                $data = $this->sekolahModel->findAll();
                $filename = 'laporan_sekolah_' . date('Y-m-d');
                break;
            case 'classes':
                $data = $this->kelasModel->getClassesWithSchool();
                $filename = 'laporan_kelas_' . date('Y-m-d');
                break;
            case 'subjects':
                $data = $this->mataPelajaranModel->findAll();
                $filename = 'laporan_mata_pelajaran_' . date('Y-m-d');
                break;
            default:
                return redirect()->to('/reports')->with('error', 'Jenis laporan tidak valid!');
        }

        return $this->exportToExcel($data, $filename, $type);
    }

    private function getSystemStats()
    {
        return [
            'total_users' => $this->userModel->countAll(),
            'total_schools' => $this->sekolahModel->countAll(),
            'total_classes' => $this->kelasModel->countAll(),
            'total_subjects' => $this->mataPelajaranModel->countAll(),
            'active_schools' => $this->sekolahModel->where('status', 'aktif')->countAllResults(),
            'active_classes' => $this->kelasModel->where('status', 'aktif')->countAllResults(),
            'active_subjects' => $this->mataPelajaranModel->where('status', 'aktif')->countAllResults()
        ];
    }

    private function getUserStats()
    {
        return [
            'total' => $this->userModel->countAll(),
            'aktif' => $this->userModel->where('is_active', 1)->countAllResults(),
            'nonaktif' => $this->userModel->where('is_active', 0)->countAllResults(),
            'by_role' => $this->userModel->getUserCountByRole()
        ];
    }

    private function getSchoolStats()
    {
        return [
            'total' => $this->sekolahModel->countAll(),
            'aktif' => $this->sekolahModel->where('status', 'aktif')->countAllResults(),
            'nonaktif' => $this->sekolahModel->where('status', 'nonaktif')->countAllResults()
        ];
    }

    private function getClassStats()
    {
        return [
            'total' => $this->kelasModel->countAll(),
            'aktif' => $this->kelasModel->where('status', 'aktif')->countAllResults(),
            'nonaktif' => $this->kelasModel->where('status', 'nonaktif')->countAllResults(),
            'by_tingkat' => $this->kelasModel->getClassCountByTingkat()
        ];
    }

    private function getSubjectStats()
    {
        return [
            'total' => $this->mataPelajaranModel->countAll(),
            'aktif' => $this->mataPelajaranModel->where('status', 'aktif')->countAllResults(),
            'nonaktif' => $this->mataPelajaranModel->where('status', 'nonaktif')->countAllResults(),
            'by_kategori' => $this->mataPelajaranModel->getSubjectCountByKategori()
        ];
    }

    private function exportToExcel($data, $filename, $type)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo '<table border="1">';
        
        // Header
        if ($type == 'users') {
            echo '<tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Terakhir Login</th></tr>';
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['full_name'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['role_name'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td>' . $row['last_login'] . '</td>';
                echo '</tr>';
            }
        } elseif ($type == 'schools') {
            echo '<tr><th>ID</th><th>Nama Sekolah</th><th>NPSN</th><th>Alamat</th><th>Telepon</th><th>Email</th><th>Kepala Sekolah</th><th>Status</th></tr>';
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nama_sekolah'] . '</td>';
                echo '<td>' . $row['npsn'] . '</td>';
                echo '<td>' . $row['alamat'] . '</td>';
                echo '<td>' . $row['telepon'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['kepala_sekolah'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '</tr>';
            }
        } elseif ($type == 'classes') {
            echo '<tr><th>ID</th><th>Nama Kelas</th><th>Sekolah</th><th>Tingkat</th><th>Jurusan</th><th>Kapasitas</th><th>Status</th></tr>';
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nama_kelas'] . '</td>';
                echo '<td>' . $row['nama_sekolah'] . '</td>';
                echo '<td>' . $row['tingkat'] . '</td>';
                echo '<td>' . $row['jurusan'] . '</td>';
                echo '<td>' . $row['kapasitas'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '</tr>';
            }
        } elseif ($type == 'subjects') {
            echo '<tr><th>ID</th><th>Nama Mata Pelajaran</th><th>Kode</th><th>Kategori</th><th>Tingkat</th><th>Jam Pelajaran</th><th>Status</th></tr>';
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nama_mapel'] . '</td>';
                echo '<td>' . $row['kode_mapel'] . '</td>';
                echo '<td>' . $row['kategori'] . '</td>';
                echo '<td>' . $row['tingkat'] . '</td>';
                echo '<td>' . $row['jam_pelajaran'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';
        exit;
    }
}
