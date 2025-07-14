<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\SekolahModel;
use App\Models\MuridKelasModel; // Tambahkan ini
use App\Models\TahunAjaranModel; // Tambahkan ini
use App\Controllers\BaseController;

class Classes extends BaseController
{
    protected $kelasModel;
    protected $sekolahModel;
    protected $muridKelasModel; // Tambahkan ini
    protected $tahunAjaranModel; // Tambahkan ini

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->sekolahModel = new SekolahModel();
        $this->muridKelasModel = new MuridKelasModel(); // Tambahkan ini
        $this->tahunAjaranModel = new TahunAjaranModel(); // Tambahkan ini
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Data Kelas',
            'classes' => $this->kelasModel->getClassesWithStudentCount(),
            'user' => $this->getUserDataForView()
        ];

        return view('classes/index', $data);
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Tambah Kelas',
            'schools' => $this->sekolahModel->where('status', 'aktif')->findAll(),
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('classes/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'nama_kelas' => 'required|min_length[2]|max_length[50]',
            'sekolah_id' => 'required|numeric|greater_than[0]',
            'tingkat' => 'required|in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
            'jurusan' => 'max_length[50]',
            'kapasitas' => 'required|numeric|greater_than[0]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'sekolah_id' => $this->request->getPost('sekolah_id'),
            'tingkat' => $this->request->getPost('tingkat'),
            'jurusan' => $this->request->getPost('jurusan'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->kelasModel->insert($data)) {
            return redirect()->to('/classes')->with('success', 'Data kelas berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data kelas!');
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $class = $this->kelasModel->find($id);

        if (!$class) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kelas tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kelas',
            'class' => $class,
            'schools' => $this->sekolahModel->where('status', 'aktif')->findAll(),
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('classes/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $class = $this->kelasModel->find($id);

        if (!$class) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kelas tidak ditemukan');
        }

        $rules = [
            'nama_kelas' => 'required|min_length[2]|max_length[50]',
            'sekolah_id' => 'required|numeric|greater_than[0]',
            'tingkat' => 'required|in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
            'jurusan' => 'max_length[50]',
            'kapasitas' => 'required|numeric|greater_than[0]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'sekolah_id' => $this->request->getPost('sekolah_id'),
            'tingkat' => $this->request->getPost('tingkat'),
            'jurusan' => $this->request->getPost('jurusan'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->kelasModel->update($id, $data)) {
            return redirect()->to('/classes')->with('success', 'Data kelas berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data kelas!');
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $class = $this->kelasModel->find($id);

        if (!$class) {
            return redirect()->to('/classes')->with('error', 'Data kelas tidak ditemukan!');
        }

        if ($this->kelasModel->delete($id)) {
            return redirect()->to('/classes')->with('success', 'Data kelas berhasil dihapus!');
        } else {
            return redirect()->to('/classes')->with('error', 'Gagal menghapus data kelas!');
        }
    }

    /**
     * View students in a specific class for the active school year
     */
    public function viewStudents($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $class = $this->kelasModel->find($id);
        if (!$class) {
            return redirect()->to('/classes')->with('error', 'Data kelas tidak ditemukan!');
        }

        // Dapatkan tahun ajaran aktif
        $activeSchoolYear = $this->tahunAjaranModel->where('is_active', 1)->first();
        if (!$activeSchoolYear) {
            // Handle jika tidak ada tahun ajaran aktif, mungkin redirect atau tampilkan pesan
            return redirect()->to('/classes')->with('error', 'Tidak ada tahun ajaran yang aktif saat ini.');
        }

        // Get class with school info
        $classWithSchool = $this->kelasModel->select('kelas.*, sekolah.nama_sekolah')
                                          ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                                          ->where('kelas.id', $id)
                                          ->first();

        // Get students in this class for the active school year
        $students = $this->muridKelasModel->getStudentsByClassAndSchoolYear($id, $activeSchoolYear['id']);
        
        // Get capacity info
        $capacityInfo = $this->kelasModel->getClassCapacityInfo($id, $activeSchoolYear['id']);

        $data = [
            'title' => 'Siswa di Kelas ' . $class['nama_kelas'],
            'class' => $classWithSchool,
            'students' => $students,
            'capacityInfo' => $capacityInfo,
            'activeSchoolYear' => $activeSchoolYear, // Kirim data tahun ajaran ke view
            'user' => $this->getUserDataForView()
        ];

        return view('classes/students', $data);
    }

    /**
     * Assign student to class for the active school year
     */
    public function assignStudent($classId)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn') && !session()->get('logged_in')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
            }
            return redirect()->to('/auth/login');
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Permintaan tidak valid.']);
        }

        $studentId = $this->request->getPost('student_id');

        // 1. Validasi Input
        if (empty($studentId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal: ID Siswa tidak boleh kosong.']);
        }

        // 2. Dapatkan Tahun Ajaran Aktif
        $activeSchoolYear = $this->tahunAjaranModel->where('is_active', 1)->first();
        if (!$activeSchoolYear) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal: Tidak ada tahun ajaran yang aktif.']);
        }
        $tahunAjaranId = $activeSchoolYear['id'];

        // 3. Validasi Kapasitas Kelas
        if (!$this->kelasModel->hasAvailableCapacity($classId, $tahunAjaranId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal: Kelas sudah penuh untuk tahun ajaran ini!']);
        }
        
        // 4. Validasi Siswa
        $userModel = new \App\Models\UserModel();
        $student = $userModel->find($studentId);
        if (!$student) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal: Data siswa tidak ditemukan.']);
        }

        // 5. Cek apakah siswa sudah ada di kelas lain pada tahun ajaran ini
        $isAlreadyInClass = $this->muridKelasModel->isStudentInAnyClass($studentId, $tahunAjaranId);
        if ($isAlreadyInClass) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal: Siswa ini sudah terdaftar di kelas lain pada tahun ajaran ini.']);
        }

        // 6. Proses Penambahan Siswa ke Tabel Pivot
        $dataToInsert = [
            'murid_id' => $studentId,
            'kelas_id' => $classId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'status' => 'aktif'
        ];

        if ($this->muridKelasModel->insert($dataToInsert)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Siswa berhasil ditambahkan ke kelas!']);
        } else {
            $errors = $this->muridKelasModel->errors();
            $errorMessage = $errors ? implode(', ', $errors) : 'Gagal menyimpan data ke database.';
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal: ' . $errorMessage]);
        }
    }

    /**
     * Remove student from class for the active school year
     */
    public function removeStudent($classId, $studentId)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Dapatkan tahun ajaran aktif
        $activeSchoolYear = $this->tahunAjaranModel->where('is_active', 1)->first();
        if (!$activeSchoolYear) {
            return redirect()->to("/classes/students/$classId")->with('error', 'Gagal: Tidak ada tahun ajaran yang aktif.');
        }
        $tahunAjaranId = $activeSchoolYear['id'];

        // Hapus record dari tabel pivot
        $isDeleted = $this->muridKelasModel
            ->where('murid_id', $studentId)
            ->where('kelas_id', $classId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->delete();

        if ($isDeleted) {
            return redirect()->to("/classes/students/$classId")->with('success', 'Siswa berhasil dikeluarkan dari kelas!');
        } else {
            return redirect()->to("/classes/students/$classId")->with('error', 'Gagal mengeluarkan siswa dari kelas!');
        }
    }
}
