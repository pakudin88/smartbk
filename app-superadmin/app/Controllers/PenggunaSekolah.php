<?php

namespace App\Controllers;

use App\Models\PetugasModel;
use App\Models\RoleModel;
use App\Models\TahunAjaranModel;
use App\Controllers\BaseController;

class PenggunaSekolah extends BaseController
{
    protected $petugasModel;
    protected $roleModel;
    protected $tahunAjaranModel;

    public function __construct()
    {
        $this->petugasModel = new PetugasModel();
        $this->roleModel = new RoleModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get petugas dengan role
        $petugas = $this->petugasModel->getPetugasWithRole();
        
        // Get roles untuk filter dan form
        $roles = $this->roleModel->whereNotIn('role_name', ['Siswa', 'Orangtua'])->findAll();
        
        // Calculate stats
        $stats = [
            'super_admin' => $this->petugasModel->where('role_id', 1)->countAllResults(),
            'kepala_sekolah' => $this->petugasModel->where('role_id', 7)->countAllResults(),
            'guru' => $this->petugasModel->whereIn('role_id', [2, 3, 16])->countAllResults(),
            'staff' => $this->petugasModel->where('role_id', 6)->countAllResults()
        ];

        $data = [
            'title' => 'Pengguna Sekolah',
            'petugas' => $petugas,
            'roles' => $roles,
            'stats' => $stats,
            'user' => [
                'id' => session()->get('userId'),
                'username' => session()->get('username'),
                'role_name' => session()->get('role_name')
            ]
        ];

        return view('pengguna_sekolah/index', $data);
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Get roles untuk petugas (exclude siswa dan wali murid)
        $roles = $this->roleModel->whereNotIn('role_name', ['Siswa', 'Wali Murid'])->findAll();
        $tahunAjaran = $this->tahunAjaranModel->findAll();

        $data = [
            'title' => 'Tambah Pengguna Sekolah',
            'roles' => $roles,
            'tahun_ajaran' => $tahunAjaran,
            'validation' => \Config\Services::validation(),
            'user' => [
                'id' => session()->get('userId'),
                'username' => session()->get('username'),
                'role_name' => session()->get('role_name')
            ]
        ];

        return view('pengguna_sekolah/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[petugas.username]',
            'email' => 'required|valid_email|is_unique[petugas.email]',
            'password' => 'required|min_length[6]',
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'role_id' => 'required|numeric',
            'jenis_kelamin' => 'permit_empty|in_list[L,P]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role_id' => $this->request->getPost('role_id'),
            'nip' => $this->request->getPost('nip'),
            'jabatan' => $this->request->getPost('jabatan'),
            'departemen' => $this->request->getPost('departemen'),
            'is_active' => 1
        ];

        if ($this->petugasModel->save($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Petugas berhasil ditambahkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan petugas']);
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $petugas = $this->petugasModel->find($id);

        if (!$petugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna sekolah tidak ditemukan');
        }

        // Get roles untuk petugas (exclude siswa dan wali murid)
        $roles = $this->roleModel->whereNotIn('role_name', ['Siswa', 'Wali Murid'])->findAll();
        $tahunAjaran = $this->tahunAjaranModel->findAll();

        $data = [
            'title' => 'Edit Pengguna Sekolah',
            'petugas' => $petugas,
            'roles' => $roles,
            'tahun_ajaran' => $tahunAjaran,
            'validation' => \Config\Services::validation(),
            'user' => [
                'id' => session()->get('userId'),
                'username' => session()->get('username'),
                'role_name' => session()->get('role_name')
            ]
        ];

        return view('pengguna_sekolah/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $petugas = $this->petugasModel->find($id);

        if (!$petugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna sekolah tidak ditemukan');
        }

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[petugas.username,id,{$id}]",
            'email' => "required|valid_email|is_unique[petugas.email,id,{$id}]",
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'role_id' => 'required|numeric',
            'jenis_kelamin' => 'permit_empty|in_list[L,P]'
        ];

        // Password optional saat update
        if (!empty($this->request->getPost('password'))) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role_id' => $this->request->getPost('role_id'),
            'nip' => $this->request->getPost('nip'),
            'jabatan' => $this->request->getPost('jabatan'),
            'departemen' => $this->request->getPost('departemen'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tahun_ajaran_id' => $this->request->getPost('tahun_ajaran_id'),
            'is_active' => $this->request->getPost('is_active')
        ];

        // Add password if provided
        if (!empty($this->request->getPost('password'))) {
            $data['password'] = $this->request->getPost('password');
        }

        if ($this->petugasModel->updatePetugas($id, $data)) {
            return redirect()->to('/pengguna-sekolah')->with('success', 'Pengguna sekolah berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna sekolah!');
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $petugas = $this->petugasModel->find($id);

        if (!$petugas) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pengguna sekolah tidak ditemukan']);
        }

        if ($this->petugasModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pengguna sekolah berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pengguna sekolah']);
        }
    }

    public function view($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $petugas = $this->petugasModel->select('petugas.*, roles.role_name, roles.description as role_description, school_years.nama_tahun_ajaran')
                                   ->join('roles', 'petugas.role_id = roles.id', 'left')
                                   ->join('school_years', 'petugas.tahun_ajaran_id = school_years.id', 'left')
                                   ->where('petugas.id', $id)
                                   ->first();

        if (!$petugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna sekolah tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Pengguna Sekolah',
            'petugas' => $petugas,
            'user' => [
                'id' => session()->get('userId'),
                'username' => session()->get('username'),
                'role_name' => session()->get('role_name')
            ]
        ];

        return view('pengguna_sekolah/view', $data);
    }

    public function toggleStatus($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $petugas = $this->petugasModel->find($id);

        if (!$petugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna sekolah tidak ditemukan');
        }

        $newStatus = $petugas['is_active'] ? 0 : 1;

        if ($this->petugasModel->update($id, ['is_active' => $newStatus])) {
            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->to('/pengguna-sekolah')->with('success', "Pengguna sekolah berhasil {$statusText}!");
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah status pengguna sekolah!');
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
            $errors = [];
            $db = \Config\Database::connect();

            foreach ($data as $index => $row) {
                $rowNumber = $index + 2; // +2 karena index dimulai dari 0 dan kita skip header
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validasi data per baris
                $username = trim($row[0] ?? '');
                $email = trim($row[1] ?? '');
                $password = trim($row[2] ?? '');
                $nama_lengkap = trim($row[3] ?? '');
                $role_name = trim($row[4] ?? '');
                $nip = trim($row[5] ?? '');
                $jabatan = trim($row[6] ?? '');
                $departemen = trim($row[7] ?? '');
                $jenis_kelamin = trim($row[8] ?? '');

                // Validasi field required
                if (empty($username) || empty($email) || empty($password) || empty($nama_lengkap) || empty($role_name)) {
                    $errors[] = "Baris {$rowNumber}: Data tidak lengkap (username, email, password, nama lengkap, dan role harus diisi)";
                    continue;
                }

                // Validasi email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Baris {$rowNumber}: Format email tidak valid";
                    continue;
                }

                // Validasi jenis kelamin
                if (!empty($jenis_kelamin) && !in_array($jenis_kelamin, ['L', 'P'])) {
                    $errors[] = "Baris {$rowNumber}: Jenis kelamin harus L atau P";
                    continue;
                }

                // Cek role_id berdasarkan role_name
                $role = $this->roleModel->where('role_name', $role_name)->first();
                if (!$role) {
                    $errors[] = "Baris {$rowNumber}: Role '{$role_name}' tidak ditemukan";
                    continue;
                }

                // Skip role Siswa dan Orangtua
                if (in_array($role['role_name'], ['Siswa', 'Orangtua', 'Wali Murid'])) {
                    $errors[] = "Baris {$rowNumber}: Role '{$role_name}' tidak diperbolehkan untuk pengguna sekolah";
                    continue;
                }

                // Cek username dan email unik
                $existingUsername = $this->petugasModel->where('username', $username)->first();
                if ($existingUsername) {
                    $errors[] = "Baris {$rowNumber}: Username '{$username}' sudah digunakan";
                    continue;
                }

                $existingEmail = $this->petugasModel->where('email', $email)->first();
                if ($existingEmail) {
                    $errors[] = "Baris {$rowNumber}: Email '{$email}' sudah digunakan";
                    continue;
                }

                // Siapkan data untuk insert
                $insertData = [
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'nama_lengkap' => $nama_lengkap,
                    'role_id' => $role['id'],
                    'nip' => !empty($nip) ? $nip : null,
                    'jabatan' => !empty($jabatan) ? $jabatan : null,
                    'departemen' => !empty($departemen) ? $departemen : null,
                    'jenis_kelamin' => !empty($jenis_kelamin) ? $jenis_kelamin : null,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Insert data
                if ($this->petugasModel->save($insertData)) {
                    $imported++;
                } else {
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data";
                }
            }

            $message = "Import selesai. {$imported} data berhasil diimport.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " data gagal diimport.";
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'imported' => $imported,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
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

            // Set headers
            $headers = [
                'A1' => 'Username',
                'B1' => 'Email',
                'C1' => 'Password',
                'D1' => 'Nama Lengkap',
                'E1' => 'Role',
                'F1' => 'NIP',
                'G1' => 'Jabatan',
                'H1' => 'Departemen',
                'I1' => 'Jenis Kelamin (L/P)'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $sheet->getStyle($cell)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E2E8F0');
            }

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(15);

            // Add sample data
            $sampleData = [
                ['john_doe', 'john@example.com', 'password123', 'John Doe', 'Guru', '123456789', 'Guru Matematika', 'Matematika', 'L'],
                ['jane_smith', 'jane@example.com', 'password123', 'Jane Smith', 'Staff', '987654321', 'Admin Sekolah', 'Administrasi', 'P']
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

            // Add roles sheet for reference
            $rolesSheet = $spreadsheet->createSheet();
            $rolesSheet->setTitle('Roles Available');
            $rolesSheet->setCellValue('A1', 'Available Roles:');
            $rolesSheet->getStyle('A1')->getFont()->setBold(true);

            $roles = $this->roleModel->whereNotIn('role_name', ['Siswa', 'Orangtua', 'Wali Murid'])->findAll();
            $roleRow = 2;
            foreach ($roles as $role) {
                $rolesSheet->setCellValue('A' . $roleRow, $role['role_name']);
                $roleRow++;
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            $filename = 'template_import_pengguna_sekolah.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating template: ' . $e->getMessage());
        }
    }
}
