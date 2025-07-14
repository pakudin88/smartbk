<?php

namespace App\Controllers;

use App\Models\OrangTuaModel;
use App\Models\MuridModel;
use App\Models\TahunAjaranModel;
use App\Controllers\BaseController;

class PenggunaOrangTua extends BaseController
{
    protected $orangTuaModel;
    protected $muridModel;
    protected $tahunAjaranModel;

    public function __construct()
    {
        $this->orangTuaModel = new OrangTuaModel();
        $this->muridModel = new MuridModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get orang tua dengan jumlah anak
        $orangTua = $this->orangTuaModel->getOrangTuaWithMurid();
        
        // Calculate stats
        $stats = [
            'total' => $this->orangTuaModel->countAllResults(),
            'aktif' => $this->orangTuaModel->where('is_active', 1)->countAllResults(),
            'ayah' => $this->orangTuaModel->where('hubungan_keluarga', 'Ayah')->countAllResults(),
            'ibu' => $this->orangTuaModel->where('hubungan_keluarga', 'Ibu')->countAllResults()
        ];

        $data = [
            'title' => 'Pengguna Orang Tua',
            'orangTua' => $orangTua,
            'stats' => $stats,
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_orang_tua/index', $data);
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $tahunAjaran = $this->tahunAjaranModel->findAll();
        $murid = $this->muridModel->getMuridWithKelas();

        $data = [
            'title' => 'Tambah Pengguna Orang Tua',
            'tahun_ajaran' => $tahunAjaran,
            'murid' => $murid,
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_orang_tua/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[orang_tua.username]',
            'email' => 'permit_empty|valid_email|is_unique[orang_tua.email]',
            'password' => 'required|min_length[6]',
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'hubungan_keluarga' => 'required|in_list[Ayah,Ibu,Wali]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'no_telepon' => $this->request->getPost('no_telepon'),
                'alamat' => $this->request->getPost('alamat'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'pendidikan' => $this->request->getPost('pendidikan'),
                'penghasilan' => $this->request->getPost('penghasilan'),
                'hubungan_keluarga' => $this->request->getPost('hubungan_keluarga'),
                'tahun_ajaran_id' => $this->request->getPost('tahun_ajaran_id'),
                'is_active' => 1
            ];

            $orangTuaId = $this->orangTuaModel->createOrangTua($data);

            if ($orangTuaId) {
                // Assign children if selected
                $selectedMurid = $this->request->getPost('murid_ids');
                if (!empty($selectedMurid)) {
                    foreach ($selectedMurid as $muridId) {
                        $this->orangTuaModel->assignMurid(
                            $orangTuaId,
                            $muridId,
                            $this->request->getPost('hubungan_keluarga'),
                            false // is_primary
                        );
                    }
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \Exception('Transaction failed');
                }

                return redirect()->to('/pengguna-orang-tua')->with('success', 'Pengguna orang tua berhasil ditambahkan!');
            } else {
                throw new \Exception('Failed to create orang tua');
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna orang tua: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $orangTua = $this->orangTuaModel->find($id);

        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna orang tua tidak ditemukan');
        }

        $tahunAjaran = $this->tahunAjaranModel->findAll();
        $murid = $this->muridModel->getMuridWithKelas();
        $assignedMurid = $this->orangTuaModel->getMuridByOrangTua($id);

        $data = [
            'title' => 'Edit Pengguna Orang Tua',
            'orang_tua' => $orangTua,
            'tahun_ajaran' => $tahunAjaran,
            'murid' => $murid,
            'assigned_murid' => $assignedMurid,
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_orang_tua/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $orangTua = $this->orangTuaModel->find($id);

        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna orang tua tidak ditemukan');
        }

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[orang_tua.username,id,{$id}]",
            'email' => "permit_empty|valid_email|is_unique[orang_tua.email,id,{$id}]",
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'hubungan_keluarga' => 'required|in_list[Ayah,Ibu,Wali]'
        ];

        // Password optional saat update
        if (!empty($this->request->getPost('password'))) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'no_telepon' => $this->request->getPost('no_telepon'),
                'alamat' => $this->request->getPost('alamat'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'pendidikan' => $this->request->getPost('pendidikan'),
                'penghasilan' => $this->request->getPost('penghasilan'),
                'hubungan_keluarga' => $this->request->getPost('hubungan_keluarga'),
                'tahun_ajaran_id' => $this->request->getPost('tahun_ajaran_id'),
                'is_active' => $this->request->getPost('is_active')
            ];

            // Add password if provided
            if (!empty($this->request->getPost('password'))) {
                $data['password'] = $this->request->getPost('password');
            }

            if ($this->orangTuaModel->updateOrangTua($id, $data)) {
                // Update children assignments
                $selectedMurid = $this->request->getPost('murid_ids');
                
                // Remove all current assignments
                $currentMurid = $this->orangTuaModel->getMuridByOrangTua($id);
                foreach ($currentMurid as $murid) {
                    $this->orangTuaModel->removeMurid($id, $murid['id']);
                }

                // Add new assignments
                if (!empty($selectedMurid)) {
                    foreach ($selectedMurid as $muridId) {
                        $this->orangTuaModel->assignMurid(
                            $id,
                            $muridId,
                            $this->request->getPost('hubungan_keluarga'),
                            false // is_primary
                        );
                    }
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \Exception('Transaction failed');
                }

                return redirect()->to('/pengguna-orang-tua')->with('success', 'Pengguna orang tua berhasil diperbarui!');
            } else {
                throw new \Exception('Failed to update orang tua');
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna orang tua: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $orangTua = $this->orangTuaModel->find($id);

        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna orang tua tidak ditemukan');
        }

        if ($this->orangTuaModel->delete($id)) {
            return redirect()->to('/pengguna-orang-tua')->with('success', 'Pengguna orang tua berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus pengguna orang tua!');
        }
    }

    public function view($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $orangTua = $this->orangTuaModel->find($id);

        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna orang tua tidak ditemukan');
        }

        $murid = $this->orangTuaModel->getMuridByOrangTua($id);

        $data = [
            'title' => 'Detail Pengguna Orang Tua',
            'orang_tua' => $orangTua,
            'murid' => $murid,
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_orang_tua/view', $data);
    }

    public function toggleStatus($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $orangTua = $this->orangTuaModel->find($id);

        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna orang tua tidak ditemukan');
        }

        $newStatus = $orangTua['is_active'] ? 0 : 1;

        if ($this->orangTuaModel->update($id, ['is_active' => $newStatus])) {
            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->to('/pengguna-orang-tua')->with('success', "Pengguna orang tua berhasil {$statusText}!");
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah status pengguna orang tua!');
        }
    }

    public function searchMurid()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $searchTerm = $this->request->getGet('q');
        
        if (empty($searchTerm) || strlen($searchTerm) < 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Search term minimal 2 karakter'
            ]);
        }

        try {
            // Cari murid berdasarkan nama atau NISN
            $murid = $this->muridModel
                ->select('murid.id, murid.nama_lengkap, murid.nisn, kelas.nama_kelas')
                ->join('murid_kelas', 'murid.id = murid_kelas.murid_id', 'left')
                ->join('kelas', 'murid_kelas.kelas_id = kelas.id', 'left')
                ->groupStart()
                    ->like('murid.nama_lengkap', $searchTerm)
                    ->orLike('murid.nisn', $searchTerm)
                ->groupEnd()
                ->where('murid.is_active', 1)
                ->limit(20) // Batasi hasil maksimal 20 untuk performa
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'murid' => $murid
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function importExcel()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'excel_file' => [
                'rules' => 'uploaded[excel_file]|ext_in[excel_file,xlsx,xls]|max_size[excel_file,2048]',
                'errors' => [
                    'uploaded' => 'File Excel harus diunggah',
                    'ext_in' => 'File harus berformat Excel (.xlsx atau .xls)',
                    'max_size' => 'Ukuran file maksimal 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('excel_file');
        
        if (!$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid']);
        }

        try {
            // Load PHPSpreadsheet
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            // Skip header row
            array_shift($data);

            $imported = 0;
            $hubunganImported = 0;
            $errors = [];
            $db = \Config\Database::connect();

            foreach ($data as $index => $row) {
                $rowNumber = $index + 2; // +2 karena index dimulai dari 0 dan kita skip header
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Start transaction untuk setiap baris
                $db->transStart();

                try {
                    // Validasi data per baris
                    $username = trim($row[0] ?? '');
                    $email = trim($row[1] ?? '');
                    $password = trim($row[2] ?? '');
                    $nama_lengkap = trim($row[3] ?? '');
                    $hubungan_keluarga = trim($row[4] ?? '');
                    $jenis_kelamin = trim($row[5] ?? '');
                    $no_telepon = trim($row[6] ?? '');
                    $pekerjaan = trim($row[7] ?? '');
                    $pendidikan = trim($row[8] ?? '');
                    $penghasilan = trim($row[9] ?? '');
                    $alamat = trim($row[10] ?? '');
                    $daftar_anak = trim($row[11] ?? ''); // Kolom baru untuk daftar NISN anak

                    // Validasi field required
                    if (empty($username) || empty($password) || empty($nama_lengkap) || empty($hubungan_keluarga)) {
                        $errors[] = "Baris {$rowNumber}: Data tidak lengkap (username, password, nama lengkap, dan hubungan keluarga harus diisi)";
                        $db->transRollback();
                        continue;
                    }

                    // Validasi hubungan keluarga
                    if (!in_array($hubungan_keluarga, ['Ayah', 'Ibu', 'Wali'])) {
                        $errors[] = "Baris {$rowNumber}: Hubungan keluarga harus Ayah, Ibu, atau Wali";
                        $db->transRollback();
                        continue;
                    }

                    // Validasi email format jika diisi
                    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Baris {$rowNumber}: Format email tidak valid";
                        $db->transRollback();
                        continue;
                    }

                    // Validasi jenis kelamin
                    if (!empty($jenis_kelamin) && !in_array($jenis_kelamin, ['L', 'P'])) {
                        $errors[] = "Baris {$rowNumber}: Jenis kelamin harus L atau P";
                        $db->transRollback();
                        continue;
                    }

                    // Cek username unik
                    $existingUsername = $this->orangTuaModel->where('username', $username)->first();
                    if ($existingUsername) {
                        $errors[] = "Baris {$rowNumber}: Username '{$username}' sudah digunakan";
                        $db->transRollback();
                        continue;
                    }

                    // Cek email unik jika diisi
                    if (!empty($email)) {
                        $existingEmail = $this->orangTuaModel->where('email', $email)->first();
                        if ($existingEmail) {
                            $errors[] = "Baris {$rowNumber}: Email '{$email}' sudah digunakan";
                            $db->transRollback();
                            continue;
                        }
                    }

                    // Siapkan data untuk insert
                    $insertData = [
                        'username' => $username,
                        'email' => !empty($email) ? $email : null,
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'nama_lengkap' => $nama_lengkap,
                        'hubungan_keluarga' => $hubungan_keluarga,
                        'jenis_kelamin' => !empty($jenis_kelamin) ? $jenis_kelamin : null,
                        'no_telepon' => !empty($no_telepon) ? $no_telepon : null,
                        'pekerjaan' => !empty($pekerjaan) ? $pekerjaan : null,
                        'pendidikan' => !empty($pendidikan) ? $pendidikan : null,
                        'penghasilan' => !empty($penghasilan) ? $penghasilan : null,
                        'alamat' => !empty($alamat) ? $alamat : null,
                        'role_id' => 5, // Role Orangtua
                        'is_active' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert data orang tua
                    if ($this->orangTuaModel->save($insertData)) {
                        $orangTuaId = $this->orangTuaModel->getInsertID();
                        $imported++;

                        // Proses hubungan dengan anak jika ada
                        if (!empty($daftar_anak)) {
                            $this->processAnakRelations($orangTuaId, $daftar_anak, $rowNumber, $errors, $hubunganImported);
                        }

                        $db->transComplete();
                        if ($db->transStatus() === false) {
                            throw new \Exception('Transaction failed');
                        }

                    } else {
                        $errors[] = "Baris {$rowNumber}: Gagal menyimpan data orang tua";
                        $db->transRollback();
                    }

                } catch (\Exception $e) {
                    $errors[] = "Baris {$rowNumber}: Error - " . $e->getMessage();
                    $db->transRollback();
                }
            }

            $message = "Import selesai. {$imported} data orang tua berhasil diimport";
            if ($hubunganImported > 0) {
                $message .= " dengan {$hubunganImported} hubungan anak";
            }
            $message .= ".";
            
            if (!empty($errors)) {
                $message .= " " . count($errors) . " data gagal diimport.";
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'imported' => $imported,
                'hubungan_imported' => $hubunganImported,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    private function processAnakRelations($orangTuaId, $daftarAnak, $rowNumber, &$errors, &$hubunganImported)
    {
        // Parse daftar NISN anak (dipisah dengan koma atau semicolon)
        $nisnList = preg_split('/[,;]/', $daftarAnak);
        
        foreach ($nisnList as $nisn) {
            $nisn = trim($nisn);
            if (empty($nisn)) continue;

            // Cari murid berdasarkan NISN
            $murid = $this->muridModel->where('nisn', $nisn)->where('is_active', 1)->first();
            
            if ($murid) {
                // Cek apakah hubungan sudah ada
                $existingRelation = $this->orangTuaModel->checkHubunganMurid($orangTuaId, $murid['id']);
                
                if (!$existingRelation) {
                    // Tambah hubungan
                    if ($this->orangTuaModel->addHubunganMurid($orangTuaId, $murid['id'])) {
                        $hubunganImported++;
                    } else {
                        $errors[] = "Baris {$rowNumber}: Gagal menambah hubungan dengan murid NISN {$nisn}";
                    }
                } else {
                    $errors[] = "Baris {$rowNumber}: Hubungan dengan murid NISN {$nisn} sudah ada";
                }
            } else {
                $errors[] = "Baris {$rowNumber}: Murid dengan NISN {$nisn} tidak ditemukan atau tidak aktif";
            }
        }
    }

    public function downloadTemplate()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers dengan kolom baru untuk daftar anak
            $headers = [
                'A1' => 'Username',
                'B1' => 'Email',
                'C1' => 'Password',
                'D1' => 'Nama Lengkap',
                'E1' => 'Hubungan Keluarga',
                'F1' => 'Jenis Kelamin (L/P)',
                'G1' => 'Nomor Telepon',
                'H1' => 'Pekerjaan',
                'I1' => 'Pendidikan',
                'J1' => 'Penghasilan',
                'K1' => 'Alamat',
                'L1' => 'Daftar NISN Anak (pisahkan dengan koma)'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $sheet->getStyle($cell)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E2E8F0');
            }

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(15); // Username
            $sheet->getColumnDimension('B')->setWidth(25); // Email
            $sheet->getColumnDimension('C')->setWidth(12); // Password
            $sheet->getColumnDimension('D')->setWidth(25); // Nama Lengkap
            $sheet->getColumnDimension('E')->setWidth(20); // Hubungan Keluarga
            $sheet->getColumnDimension('F')->setWidth(15); // Jenis Kelamin
            $sheet->getColumnDimension('G')->setWidth(15); // Nomor Telepon
            $sheet->getColumnDimension('H')->setWidth(20); // Pekerjaan
            $sheet->getColumnDimension('I')->setWidth(20); // Pendidikan
            $sheet->getColumnDimension('J')->setWidth(15); // Penghasilan
            $sheet->getColumnDimension('K')->setWidth(30); // Alamat
            $sheet->getColumnDimension('L')->setWidth(40); // Daftar NISN Anak

            // Add sample data dengan contoh NISN anak
            $sampleData = [
                ['budi_ayah', 'budi.ayah@example.com', 'password123', 'Budi Santoso', 'Ayah', 'L', '081234567890', 'Pegawai Swasta', 'S1', '2-5 Juta', 'Jl. Merdeka No. 123', '1234567890,1234567891'],
                ['sari_ibu', 'sari.ibu@example.com', 'password123', 'Sari Indrawati', 'Ibu', 'P', '081234567891', 'Ibu Rumah Tangga', 'SMA', '< 1 Juta', 'Jl. Sudirman No. 456', '1234567892'],
                ['ahmad_wali', 'ahmad.wali@example.com', 'password123', 'Ahmad Rahman', 'Wali', 'L', '081234567892', 'Pensiunan', 'S2', '5-10 Juta', 'Jl. Gatot Subroto No. 789', '1234567893,1234567894,1234567895']
            ];

            $row = 2;
            foreach ($sampleData as $data) {
                $col = 'A';
                foreach ($data as $value) {
                    $sheet->setCellValue($col . $row, $value);
                    $col++;
                }
                $row++;
            }

            // Add reference sheet
            $refSheet = $spreadsheet->createSheet();
            $refSheet->setTitle('Referensi Data');
            $refSheet->setCellValue('A1', 'REFERENSI DATA');
            $refSheet->getStyle('A1')->getFont()->setBold(true);
            
            $refSheet->setCellValue('A3', 'Hubungan Keluarga:');
            $refSheet->getStyle('A3')->getFont()->setBold(true);
            $refSheet->setCellValue('A4', '• Ayah');
            $refSheet->setCellValue('A5', '• Ibu');
            $refSheet->setCellValue('A6', '• Wali');
            
            $refSheet->setCellValue('A8', 'Jenis Kelamin:');
            $refSheet->getStyle('A8')->getFont()->setBold(true);
            $refSheet->setCellValue('A9', '• L (Laki-laki)');
            $refSheet->setCellValue('A10', '• P (Perempuan)');
            
            $refSheet->setCellValue('A12', 'Penghasilan:');
            $refSheet->getStyle('A12')->getFont()->setBold(true);
            $refSheet->setCellValue('A13', '• < 1 Juta');
            $refSheet->setCellValue('A14', '• 1-2 Juta');
            $refSheet->setCellValue('A15', '• 2-5 Juta');
            $refSheet->setCellValue('A16', '• 5-10 Juta');
            $refSheet->setCellValue('A17', '• > 10 Juta');

            $refSheet->setCellValue('A19', 'CATATAN PENTING:');
            $refSheet->getStyle('A19')->getFont()->setBold(true);
            $refSheet->setCellValue('A20', '• Kolom wajib: Username, Password, Nama Lengkap, Hubungan Keluarga');
            $refSheet->setCellValue('A21', '• Username harus unik');
            $refSheet->setCellValue('A22', '• Email harus format valid jika diisi');
            $refSheet->setCellValue('A23', '• Hapus baris contoh sebelum import data asli');
            $refSheet->setCellValue('A24', '• Hubungan anak dapat diatur nanti secara manual');
            
            $refSheet->getColumnDimension('A')->setWidth(60);

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            $filename = 'template_import_orang_tua.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating template: ' . $e->getMessage());
        }
    }

    public function kelolaMurid($orangTuaId)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get data orang tua
        $orangTua = $this->orangTuaModel->find($orangTuaId);
        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Orang tua tidak ditemukan');
        }

        // Get murid yang sudah terhubung dengan orang tua ini
        $muridTerhubung = $this->orangTuaModel->getMuridByOrangTua($orangTuaId);

        $data = [
            'title' => 'Kelola Murid - ' . $orangTua['nama_lengkap'],
            'orangTua' => $orangTua,
            'muridTerhubung' => $muridTerhubung,
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_orang_tua/kelola_murid', $data);
    }

    public function tambahMurid()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $orangTuaId = $this->request->getPost('orang_tua_id');
        $muridId = $this->request->getPost('murid_id');

        if (!$orangTuaId || !$muridId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            // Cek apakah hubungan sudah ada
            $existing = $this->orangTuaModel->checkHubunganMurid($orangTuaId, $muridId);
            if ($existing) {
                return $this->response->setJSON(['success' => false, 'message' => 'Murid sudah terhubung dengan orang tua ini']);
            }

            // Tambah hubungan
            if ($this->orangTuaModel->addHubunganMurid($orangTuaId, $muridId)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Murid berhasil ditambahkan']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan murid']);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function hapusMurid()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $orangTuaId = $this->request->getPost('orang_tua_id');
        $muridId = $this->request->getPost('murid_id');

        if (!$orangTuaId || !$muridId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            if ($this->orangTuaModel->removeHubunganMurid($orangTuaId, $muridId)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Hubungan murid berhasil dihapus']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus hubungan murid']);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
