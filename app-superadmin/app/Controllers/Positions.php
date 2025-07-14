<?php

namespace App\Controllers;

use App\Models\JabatanModel;
use App\Models\PetugasJabatanModel;
use App\Models\PetugasModel;
use App\Models\TahunAjaranModel;
use App\Controllers\BaseController;

class Positions extends BaseController
{
    protected $jabatanModel;
    protected $petugasJabatanModel;
    protected $petugasModel;
    protected $tahunAjaranModel;

    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
        $this->petugasJabatanModel = new PetugasJabatanModel();
        $this->petugasModel = new PetugasModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get previous years for copy function
        $previousYears = $this->jabatanModel->getPreviousYears();

        $data = [
            'title' => 'Kelola Jabatan',
            'jabatan' => $this->jabatanModel->getJabatanWithPetugas(),
            'previous_years' => $previousYears,
            'user' => $this->getUserDataForView()
        ];

        return view('positions/index', $data);
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Load form helper
        helper('form');

        // Get active tahun ajaran
        $activeTahunAjaran = $this->tahunAjaranModel->where('is_active', 1)->first();

        $data = [
            'title' => 'Tambah Jabatan',
            'validation' => \Config\Services::validation(),
            'active_tahun_ajaran' => $activeTahunAjaran,
            'user' => $this->getUserDataForView()
        ];

        return view('positions/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'nama_jabatan' => 'required|min_length[3]|max_length[100]',
            'kode_jabatan' => 'required|min_length[2]|max_length[10]|is_unique[jabatan.kode_jabatan]',
            'kategori' => 'required|in_list[guru_mapel,kepala_sekolah,wakil_kepala_sekolah,guru_bk,admin,staff]',
            'departemen' => 'required|in_list[akademik,administrasi,bimbingan_konseling,kepala_sekolah]',
            'level' => 'required|in_list[pimpinan,koordinator,pelaksana]',
            'deskripsi' => 'permit_empty|max_length[500]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get active tahun ajaran - optional
        $tahunAjaranId = $this->request->getPost('tahun_ajaran_id');
        if (!$tahunAjaranId) {
            $activeTahunAjaran = $this->tahunAjaranModel->where('is_active', 1)->first();
            $tahunAjaranId = $activeTahunAjaran['id'] ?? null;
        }

        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'kode_jabatan' => $this->request->getPost('kode_jabatan'),
            'kategori' => $this->request->getPost('kategori'),
            'departemen' => $this->request->getPost('departemen'),
            'level' => $this->request->getPost('level'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'tahun_ajaran_id' => $tahunAjaranId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->jabatanModel->insert($data)) {
                return redirect()->to('/positions')->with('success', 'Data jabatan berhasil ditambahkan!');
            } else {
                $errors = $this->jabatanModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Gagal menambahkan data jabatan!';
                return redirect()->back()->withInput()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error inserting jabatan: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Load form helper
        helper('form');

        $jabatan = $this->jabatanModel->find($id);

        if (!$jabatan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data jabatan tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Jabatan',
            'jabatan' => $jabatan,
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('positions/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data jabatan tidak ditemukan');
        }

        $rules = [
            'nama_jabatan' => 'required|min_length[3]|max_length[100]',
            'kode_jabatan' => "required|min_length[2]|max_length[10]|is_unique[jabatan.kode_jabatan,id,{$id}]",
            'kategori' => 'required|in_list[guru_mapel,kepala_sekolah,wakil_kepala_sekolah,guru_bk,admin,staff]',
            'departemen' => 'required|in_list[akademik,administrasi,bimbingan_konseling,kepala_sekolah]',
            'level' => 'required|in_list[pimpinan,koordinator,pelaksana]',
            'deskripsi' => 'permit_empty|max_length[500]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'kode_jabatan' => $this->request->getPost('kode_jabatan'),
            'kategori' => $this->request->getPost('kategori'),
            'departemen' => $this->request->getPost('departemen'),
            'level' => $this->request->getPost('level'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->jabatanModel->update($id, $data)) {
            return redirect()->to('/positions')->with('success', 'Data jabatan berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data jabatan!');
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            return redirect()->to('/positions')->with('error', 'Data jabatan tidak ditemukan!');
        }

        // Check if there are petugas assigned to this jabatan
        $assignedPetugas = $this->petugasJabatanModel->where('jabatan_id', $id)->where('status', 'aktif')->countAllResults();
        
        if ($assignedPetugas > 0) {
            return redirect()->to('/positions')->with('error', 'Jabatan ini masih memiliki petugas yang ditugaskan. Hapus tugasan petugas terlebih dahulu.');
        }

        if ($this->jabatanModel->delete($id)) {
            return redirect()->to('/positions')->with('success', 'Data jabatan berhasil dihapus!');
        } else {
            return redirect()->to('/positions')->with('error', 'Gagal menghapus data jabatan!');
        }
    }

    public function viewPetugas($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data jabatan tidak ditemukan');
        }

        $assignedPetugas = $this->petugasJabatanModel->getPetugasJabatan($id);
        $availablePetugas = $this->petugasJabatanModel->getAvailablePetugas($id);
        $stats = $this->petugasJabatanModel->getJabatanStats($id);

        $data = [
            'title' => 'Kelola Petugas - ' . $jabatan['nama_jabatan'],
            'jabatan' => $jabatan,
            'assigned_petugas' => $assignedPetugas,
            'available_petugas' => $availablePetugas,
            'stats' => $stats,
            'user' => $this->getUserDataForView()
        ];

        return view('positions/petugas', $data);
    }

    public function assignPetugas($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Jabatan tidak ditemukan']);
        }

        $petugasId = $this->request->getPost('petugas_id');
        $tanggalMulai = $this->request->getPost('tanggal_mulai') ?: date('Y-m-d');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');

        // Get active tahun ajaran
        $activeTahunAjaran = $this->tahunAjaranModel->where('is_active', 1)->first();
        if (!$activeTahunAjaran) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada tahun ajaran aktif']);
        }

        // Assign petugas to jabatan
        $result = $this->petugasJabatanModel->assignPetugasToJabatan(
            $petugasId, 
            $id, 
            $activeTahunAjaran['id'], 
            $tanggalMulai, 
            $tanggalSelesai
        );

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Petugas berhasil ditugaskan ke jabatan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Petugas sudah ditugaskan ke jabatan ini atau terjadi error']);
        }
    }

    public function removePetugas($jabatanId, $petugasId)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $result = $this->petugasJabatanModel->removePetugasFromJabatan($petugasId, $jabatanId);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Petugas berhasil dihapus dari jabatan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus petugas dari jabatan']);
        }
    }

    public function copyFromPreviousYear()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $fromTahunAjaranId = $this->request->getPost('from_tahun_ajaran_id');
        
        // Get active tahun ajaran as destination
        $activeTahunAjaran = $this->tahunAjaranModel->where('is_active', 1)->first();
        if (!$activeTahunAjaran) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada tahun ajaran aktif']);
        }

        if (!$fromTahunAjaranId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tahun ajaran sumber harus dipilih']);
        }

        $copiedCount = $this->jabatanModel->copyFromPreviousYear($fromTahunAjaranId, $activeTahunAjaran['id']);

        if ($copiedCount > 0) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => "Berhasil menyalin {$copiedCount} jabatan dari tahun ajaran sebelumnya"
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Tidak ada jabatan yang disalin. Mungkin semua jabatan sudah ada atau tidak ada data di tahun ajaran sumber'
            ]);
        }
    }
}
