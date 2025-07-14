<?php

namespace App\Controllers;

use App\Models\TahunAjaranModel;
use App\Controllers\BaseController;

class SchoolYears extends BaseController
{
    protected $tahunAjaranModel;

    public function __construct()
    {
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
            'title' => 'Data Tahun Ajaran',
            'schoolYears' => $this->tahunAjaranModel->getSchoolYearsWithStats(),
            'activeSchoolYear' => $this->tahunAjaranModel->getActiveSchoolYear(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('school_years/index', $data);
    }

    public function create()
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
            'title' => 'Tambah Tahun Ajaran',
            'validation' => \Config\Services::validation(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('school_years/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'nama_tahun_ajaran' => 'required|min_length[5]|max_length[20]',
            'tahun_mulai' => 'required|numeric|exact_length[4]',
            'tahun_selesai' => 'required|numeric|exact_length[4]',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'semester' => 'required|in_list[Ganjil,Genap]',
            'is_active' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $tahunMulai = $this->request->getPost('tahun_mulai');
        $tahunSelesai = $this->request->getPost('tahun_selesai');

        if ($tahunSelesai <= $tahunMulai) {
            return redirect()->back()->withInput()->with('error', 'Tahun selesai harus lebih besar dari tahun mulai!');
        }

        $data = [
            'nama_tahun_ajaran' => $this->request->getPost('nama_tahun_ajaran'),
            'tahun_mulai' => $tahunMulai,
            'tahun_selesai' => $tahunSelesai,
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'semester' => $this->request->getPost('semester'),
            'is_active' => $this->request->getPost('is_active'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->tahunAjaranModel->insert($data)) {
            return redirect()->to('/school-years')->with('success', 'Data tahun ajaran berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data tahun ajaran!');
        }
    }

    public function edit($id)
    {
        // Set session untuk testing
        session()->set([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin',
            'full_name' => 'Administrator',
            'role_name' => 'Super Admin'
        ]);

        $schoolYear = $this->tahunAjaranModel->find($id);

        if (!$schoolYear) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tahun ajaran tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Tahun Ajaran',
            'schoolYear' => $schoolYear,
            'validation' => \Config\Services::validation(),
            'user' => [
                'id' => 1,
                'full_name' => 'Administrator',
                'role_name' => 'Super Admin'
            ]
        ];

        return view('school_years/edit', $data);
    }

    public function update($id)
    {
        $schoolYear = $this->tahunAjaranModel->find($id);

        if (!$schoolYear) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tahun ajaran tidak ditemukan');
        }

        $rules = [
            'nama_tahun_ajaran' => 'required|min_length[5]|max_length[20]',
            'tahun_mulai' => 'required|numeric|exact_length[4]',
            'tahun_selesai' => 'required|numeric|exact_length[4]',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'semester' => 'required|in_list[Ganjil,Genap]',
            'is_active' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $tahunMulai = $this->request->getPost('tahun_mulai');
        $tahunSelesai = $this->request->getPost('tahun_selesai');

        if ($tahunSelesai <= $tahunMulai) {
            return redirect()->back()->withInput()->with('error', 'Tahun selesai harus lebih besar dari tahun mulai!');
        }

        $data = [
            'nama_tahun_ajaran' => $this->request->getPost('nama_tahun_ajaran'),
            'tahun_mulai' => $tahunMulai,
            'tahun_selesai' => $tahunSelesai,
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'semester' => $this->request->getPost('semester'),
            'is_active' => $this->request->getPost('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->tahunAjaranModel->update($id, $data)) {
            return redirect()->to('/school-years')->with('success', 'Data tahun ajaran berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data tahun ajaran!');
        }
    }

    public function delete($id)
    {
        $schoolYear = $this->tahunAjaranModel->find($id);

        if (!$schoolYear) {
            return redirect()->to('/school-years')->with('error', 'Data tahun ajaran tidak ditemukan!');
        }

        if ($this->tahunAjaranModel->delete($id)) {
            return redirect()->to('/school-years')->with('success', 'Data tahun ajaran berhasil dihapus!');
        } else {
            return redirect()->to('/school-years')->with('error', 'Gagal menghapus data tahun ajaran!');
        }
    }

    public function activate($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $schoolYear = $this->tahunAjaranModel->find($id);

        if (!$schoolYear) {
            return redirect()->to('/school-years')->with('error', 'Data tahun ajaran tidak ditemukan!');
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Deactivate all school years
            $this->tahunAjaranModel->set('is_active', 0)
                                  ->where('is_active', 1)
                                  ->update();

            // Activate selected school year
            $this->tahunAjaranModel->update($id, [
                'is_active' => 1
            ]);

            // Update system settings
            $settingsModel = new \App\Models\SettingsModel();
            $settingsModel->updateSetting('active_school_year_id', $id);

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->to('/school-years')->with('error', 'Gagal mengaktifkan tahun ajaran!');
            }

            return redirect()->to('/school-years')->with('success', 'Tahun ajaran berhasil diaktifkan! Semua data akan mengacu pada tahun ajaran ' . $schoolYear['nama_tahun_ajaran']);

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/school-years')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
