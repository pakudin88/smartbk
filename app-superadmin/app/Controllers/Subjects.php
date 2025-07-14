<?php

namespace App\Controllers;

use App\Models\MataPelajaranModel;
use App\Controllers\BaseController;

class Subjects extends BaseController
{
    protected $mataPelajaranModel;

    public function __construct()
    {
        $this->mataPelajaranModel = new MataPelajaranModel();
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Load model TahunAjaranModel untuk mendapatkan data tahun ajaran
        $tahunAjaranModel = new \App\Models\TahunAjaranModel();
        $previousYears = $tahunAjaranModel->getPreviousYears();

        $data = [
            'title' => 'Data Mata Pelajaran',
            'subjects' => $this->mataPelajaranModel->getSubjectsWithTeachers(),
            'previous_years' => $previousYears,
            'user' => $this->getUserDataForView()
        ];

        return view('subjects/index', $data);
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('subjects/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'nama_mapel' => 'required|min_length[3]|max_length[100]',
            'kode_mapel' => 'required|min_length[2]|max_length[10]|is_unique[mata_pelajaran.kode_mapel]',
            'kategori' => 'required|in_list[wajib,pilihan,muatan_lokal]',
            'tingkat' => 'required|in_list[SD,SMP,SMA,SMK]',
            'jam_pelajaran' => 'required|numeric|greater_than[0]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'kode_mapel' => $this->request->getPost('kode_mapel'),
            'kategori' => $this->request->getPost('kategori'),
            'tingkat' => $this->request->getPost('tingkat'),
            'jam_pelajaran' => $this->request->getPost('jam_pelajaran'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->mataPelajaranModel->insert($data)) {
            return redirect()->to('/subjects')->with('success', 'Data mata pelajaran berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data mata pelajaran!');
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $subject = $this->mataPelajaranModel->find($id);

        if (!$subject) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mata pelajaran tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Mata Pelajaran',
            'subject' => $subject,
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('subjects/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $subject = $this->mataPelajaranModel->find($id);

        if (!$subject) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mata pelajaran tidak ditemukan');
        }

        $rules = [
            'nama_mapel' => 'required|min_length[3]|max_length[100]',
            'kode_mapel' => "required|min_length[2]|max_length[10]|is_unique[mata_pelajaran.kode_mapel,id,{$id}]",
            'kategori' => 'required|in_list[wajib,pilihan,muatan_lokal]',
            'tingkat' => 'required|in_list[SD,SMP,SMA,SMK]',
            'jam_pelajaran' => 'required|numeric|greater_than[0]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'kode_mapel' => $this->request->getPost('kode_mapel'),
            'kategori' => $this->request->getPost('kategori'),
            'tingkat' => $this->request->getPost('tingkat'),
            'jam_pelajaran' => $this->request->getPost('jam_pelajaran'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->mataPelajaranModel->update($id, $data)) {
            return redirect()->to('/subjects')->with('success', 'Data mata pelajaran berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data mata pelajaran!');
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $subject = $this->mataPelajaranModel->find($id);

        if (!$subject) {
            return redirect()->to('/subjects')->with('error', 'Data mata pelajaran tidak ditemukan!');
        }

        if ($this->mataPelajaranModel->delete($id)) {
            return redirect()->to('/subjects')->with('success', 'Data mata pelajaran berhasil dihapus!');
        } else {
            return redirect()->to('/subjects')->with('error', 'Gagal menghapus data mata pelajaran!');
        }
    }

    public function viewTeachers($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $subject = $this->mataPelajaranModel->find($id);
        if (!$subject) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data mata pelajaran tidak ditemukan');
        }

        $data = [
            'title' => 'Guru Pengajar - ' . $subject['nama_mapel'],
            'subject' => $subject,
            'teachers' => $this->mataPelajaranModel->getTeachersBySubject($id),
            'availableTeachers' => $this->mataPelajaranModel->getAvailableTeachers(),
            'user' => $this->getUserDataForView()
        ];

        return view('subjects/teachers', $data);
    }

    public function assignTeacher($subjectId)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $teacherId = $this->request->getPost('teacher_id');
        $classId = $this->request->getPost('class_id');

        if (!$teacherId) {
            return redirect()->back()->with('error', 'Pilih guru terlebih dahulu!');
        }

        if ($this->mataPelajaranModel->assignTeacherToSubject($teacherId, $subjectId, $classId)) {
            return redirect()->to('/subjects/teachers/' . $subjectId)->with('success', 'Guru berhasil ditugaskan ke mata pelajaran!');
        } else {
            return redirect()->back()->with('error', 'Gagal menugaskan guru ke mata pelajaran!');
        }
    }

    public function removeTeacher($subjectId, $teacherId)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        if ($this->mataPelajaranModel->removeTeacherFromSubject($teacherId, $subjectId)) {
            return redirect()->to('/subjects/teachers/' . $subjectId)->with('success', 'Guru berhasil dihapus dari mata pelajaran!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus guru dari mata pelajaran!');
        }
    }

    public function copyFromPreviousYear()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $previousYearId = $this->request->getPost('previous_year');
        $confirmCopy = $this->request->getPost('confirm_copy');

        if (!$previousYearId || !$confirmCopy) {
            return redirect()->back()->with('error', 'Pilih tahun ajaran dan konfirmasi copy terlebih dahulu!');
        }

        // Validasi tahun ajaran sebelumnya
        $tahunAjaranModel = new \App\Models\TahunAjaranModel();
        $previousYear = $tahunAjaranModel->find($previousYearId);
        
        if (!$previousYear) {
            return redirect()->back()->with('error', 'Tahun ajaran sebelumnya tidak ditemukan!');
        }

        // Dapatkan tahun ajaran aktif saat ini
        $currentYear = $tahunAjaranModel->getActiveYear();
        
        if (!$currentYear) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif saat ini!');
        }

        // Copy mata pelajaran dari tahun sebelumnya
        $result = $this->mataPelajaranModel->copyFromPreviousYear($previousYearId, $currentYear['id']);
        
        if ($result['success']) {
            $message = "Berhasil menyalin {$result['copied_count']} mata pelajaran dari tahun ajaran {$previousYear['nama_tahun_ajaran']} ke tahun ajaran {$currentYear['nama_tahun_ajaran']}";
            return redirect()->to('/subjects')->with('success', $message);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }
}
