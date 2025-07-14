<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Exception;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // For debugging, temporarily remove auth check
        // if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
        //     return redirect()->to('/auth/login');
        // }

        try {
            // Get perPage from query string, default to 10
            $perPage = (int)($this->request->getGet('perPage') ?? 10);
            // Validate perPage values
            if (!in_array($perPage, [10, 25, 50, 100])) {
                $perPage = 10;
            }
            
            $page = (int)($this->request->getGet('page') ?? 1);
            $offset = ($page - 1) * $perPage;
            $totalUsers = $this->userModel->countAll();
            $users = $this->userModel->findAll($perPage, $offset);

            foreach ($users as &$user) {
                // Add additional processing if needed
            }

            $pager = [
                'total' => $totalUsers,
                'perPage' => $perPage,
                'current' => $page, // Add the current page key
                'last' => ceil($totalUsers / $perPage), // Add the last page key
            ];

            // Get role filter from request
            $role = $this->request->getGet('role');

            // Fetch users data filtered by role if provided
            $db = \Config\Database::connect();
            $queryBuilder = $db->table('users')
                ->select('users.*, roles.role_name as role_name, kelas.nama_kelas, kelas.tingkat, sekolah.nama_sekolah')
                ->join('roles', 'roles.id = users.role_id', 'inner')
                ->join('kelas', 'kelas.id = users.kelas_id', 'left')
                ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                ->orderBy('users.created_at', 'DESC');

            if (!empty($role)) {
                $queryBuilder->where('roles.role_name', $role);
            }

            $users = $queryBuilder->get()->getResultArray();

            // Fetch roles from the database
            $roles = $db->table('roles')->select('role_name')->get()->getResultArray();

            // Convert roles array to a simple array of role names
            $roles = array_column($roles, 'role_name');

            $data = [
                'users' => $users,
                'pager' => $pager,
                'role' => $role, // Pass the role parameter to the view
                'roles' => $roles, // Pass the roles to the view
                'user' => $this->getUserDataForView() // Add user data for layout
            ];

            return view('users/index', $data);
        } catch (Exception $e) {
            throw new \RuntimeException("Error loading users: " . $e->getMessage());
        }
    }

    public function create()
    {
        $roles = $this->getRoles();
        
        $data = [
            'title' => 'Tambah User Baru',
            'user' => $this->getUserDataForView(),
            'roles' => $roles
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        // Validasi langsung lewat model agar pesan error custom bahasa Indonesia selalu dipakai
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];
        
        // Cek validasi model
        if (!$this->userModel->validate($userData)) {
            $errors = $this->userModel->errors();
            $errorMsg = 'Validasi gagal. Mohon periksa data yang Anda isi:';
            if (!empty($errors)) {
                $errorMsg .= '<ul class="mb-0">';
                foreach ($errors as $err) {
                    $errorMsg .= '<li>' . esc($err) . '</li>';
                }
                $errorMsg .= '</ul>';
            }
            return redirect()->to('/users/create')->withInput()->with('error', $errorMsg);
        }
        
        // Hash password setelah validasi
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

        try {
            $result = $this->userModel->insert($userData);
            if ($result) {
                // Redirect ke URL absolut agar pasti ke localhost:8080/users
                return redirect()->to(base_url('/users'))->with('success', 'User berhasil ditambahkan!');
            } else {
                // Ambil error dari model jika ada
                $modelErrors = $this->userModel->errors();
                $errorMsg = 'Gagal menambahkan user ke database. Alasan:';
                if (!empty($modelErrors)) {
                    $errorMsg .= '<ul class="mb-0">';
                    foreach ($modelErrors as $err) {
                        $errorMsg .= '<li>' . esc($err) . '</li>';
                    }
                    $errorMsg .= '</ul>';
                }
                return redirect()->to(base_url('/users/create'))->withInput()->with('error', $errorMsg);
            }
        } catch (Exception $e) {
            return redirect()->to(base_url('/users/create'))->withInput()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        $userData = $this->userModel->getUserWithRole($id);
        if (!$userData) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $this->getUserDataForView(),
            'userData' => $userData,
            'roles' => $this->getRoles()
        ];

        return view('users/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        // Ambil data lama dari database
        $oldUser = $this->userModel->find($id);
        if (!$oldUser) {
            return redirect()->to(base_url('/users'))->with('error', 'User tidak ditemukan.');
        }
        $input = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $input['password'] = $password;
        }
        // Bandingkan, hanya update field yang berubah
        $userData = [];
        foreach ($input as $key => $val) {
            if ($key === 'password') {
                // Password: hanya update jika diisi dan hash-nya beda
                if (!empty($val) && !password_verify($val, $oldUser['password'])) {
                    $userData['password'] = $val;
                }
            } else {
                if ((string)$val !== (string)$oldUser[$key]) {
                    $userData[$key] = $val;
                }
            }
        }
        if (empty($userData)) {
            return redirect()->to(base_url('/users/edit/' . $id))->with('error', 'Tidak ada perubahan data.');
        }
        // Validasi model (pakai id agar is_unique benar)
        $userDataWithId = $userData;
        $userDataWithId['id'] = $id;
        if (!$this->userModel->validate($userDataWithId)) {
            $errors = $this->userModel->errors();
            $errorMsg = 'Validasi gagal. Mohon periksa data yang Anda isi:';
            if (!empty($errors)) {
                $errorMsg .= '<ul class="mb-0">';
                foreach ($errors as $err) {
                    $errorMsg .= '<li>' . esc($err) . '</li>';
                }
                $errorMsg .= '</ul>';
            }
            // Redirect ke halaman edit user, bukan back()
            return redirect()->to(base_url('/users/edit/' . $id))->withInput()->with('error', $errorMsg);
        }
        // Hash password jika diisi dan berubah
        if (isset($userData['password'])) {
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        }
        if ($this->userModel->update($id, $userData)) {
            // Redirect absolut agar pasti ke /users
            return redirect()->to(base_url('/users'))->with('success', 'User berhasil diupdate.');
        } else {
            $modelErrors = $this->userModel->errors();
            $errorMsg = 'Gagal mengupdate user.';
            if (!empty($modelErrors)) {
                $errorMsg .= '<ul class="mb-0">';
                foreach ($modelErrors as $err) {
                    $errorMsg .= '<li>' . esc($err) . '</li>';
                }
                $errorMsg .= '</ul>';
            }
            // Redirect ke halaman edit user, bukan back()
            return redirect()->to(base_url('/users/edit/' . $id))->withInput()->with('error', $errorMsg);
        }
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        // Prevent deleting own account
        if ($id == session()->get('user_id')) {
            return redirect()->to('/users')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->to('/users')->with('error', 'Gagal menghapus user.');
        }
    }

    public function toggle($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        if ($this->userModel->update($id, ['is_active' => $newStatus])) {
            $status = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->to('/users')->with('success', "User berhasil $status.");
        } else {
            return redirect()->to('/users')->with('error', 'Gagal mengubah status user.');
        }
    }

    public function export($format = 'csv')
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        // Get role filter from request
        $role = $this->request->getGet('role');

        if ($format === 'excel' || $format === 'xlsx') {
            return $this->exportExcel($role);
        } else {
            return $this->exportCsv($role);
        }
    }

    public function exportExcel($role = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        try {
            // Debugging: Log the role parameter
            log_message('debug', 'Role parameter: ' . ($role ?? 'NULL'));

            // Get users data filtered by role if provided
            $db = \Config\Database::connect();
            $queryBuilder = $db->table('users')
                ->select('users.*, roles.role_name as role_name')
                ->join('roles', 'roles.id = users.role_id', 'inner') // Ensure matching roles
                ->orderBy('users.created_at', 'DESC');

            if (!empty($role)) {
                $queryBuilder->where('roles.role_name', $role);
            }

            // Debugging: Log the query using Query Builder
            log_message('debug', 'Export query: ' . $queryBuilder->getCompiledSelect());

            // Execute query and fetch results
            $users = $queryBuilder->get()->getResultArray();

            // Prepare data for export
            $exportData = [];
            foreach ($users as $user) {
                $exportData[] = [
                    'ID' => $user['id'],
                    'Username' => $user['username'],
                    'Email' => $user['email'],
                    'Nama Lengkap' => $user['full_name'],
                    'Role' => $user['role_name'] ?? 'No Role',
                    'Status' => $user['is_active'] ? 'Aktif' : 'Nonaktif',
                    'Tanggal Dibuat' => date('d/m/Y H:i:s', strtotime($user['created_at'])),
                    'Terakhir Login' => $user['last_login'] ? date('d/m/Y H:i:s', strtotime($user['last_login'])) : 'Belum pernah login'
                ];
            }

            // Generate filename
            $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Force download Excel file
            $this->forceDownloadExcel($exportData, $filename);

        } catch (Exception $e) {
            return redirect()->to('/users')->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    public function exportCsv($role = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        try {
            // Get users data filtered by role if provided
            $query = $this->userModel
                ->select('users.*, roles.role_name as role_name')
                ->join('roles', 'roles.id = users.role_id', 'left')
                ->orderBy('users.created_at', 'DESC');

            if ($role) {
                $query->where('roles.role_name', $role);
            }

            $users = $query->findAll();

            // Check if data is empty
            if (empty($users)) {
                return redirect()->to('/users')->with('error', 'Tidak ada data untuk diekspor.');
            }

            // Prepare data for export
            $exportData = [];
            foreach ($users as $user) {
                $exportData[] = [
                    'ID' => $user['id'],
                    'Username' => $user['username'],
                    'Email' => $user['email'],
                    'Nama Lengkap' => $user['full_name'],
                    'Role' => $user['role_name'] ?? 'No Role',
                    'Status' => $user['is_active'] ? 'Aktif' : 'Nonaktif',
                    'Tanggal Dibuat' => date('d/m/Y H:i:s', strtotime($user['created_at'])),
                    'Terakhir Login' => $user['last_login'] ? date('d/m/Y H:i:s', strtotime($user['last_login'])) : 'Belum pernah login'
                ];
            }

            // Generate filename
            $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';

            // Force download CSV file
            $this->forceDownloadCsv($exportData, $filename);

        } catch (Exception $e) {
            return redirect()->to('/users')->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    private function exportToCsv($data, $filename)
    {
        // Clear any previous output
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8 encoding (untuk support karakter Indonesia)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Write headers
        if (!empty($data)) {
            fputcsv($output, array_keys($data[0]));
            
            // Write data rows
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
        }

        fclose($output);
        exit;
    }

    private function exportToExcel($data, $filename)
    {
        // Clear any previous output
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set headers for Excel download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        // Start output buffering
        ob_start();

        // Excel XML header
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
        echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        echo ' xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
        echo ' xmlns:x="urn:schemas-microsoft-com:office:excel"' . "\n";
        echo ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        echo ' xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";

        // Document properties
        echo '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">' . "\n";
        echo '<Title>Export Data Users</Title>' . "\n";
        echo '<Author>Super Admin</Author>' . "\n";
        echo '<Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>' . "\n";
        echo '</DocumentProperties>' . "\n";
        
        // Styles
        echo '<Styles>' . "\n";
        echo '<Style ss:ID="header">' . "\n";
        echo '<Font ss:Bold="1" ss:Color="#FFFFFF"/>' . "\n";
        echo '<Interior ss:Color="#4472C4" ss:Pattern="Solid"/>' . "\n";
        echo '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>' . "\n";
        echo '</Style>' . "\n";
        echo '<Style ss:ID="data">' . "\n";
        echo '<Alignment ss:Horizontal="Left" ss:Vertical="Center"/>' . "\n";
        echo '</Style>' . "\n";
        echo '</Styles>' . "\n";
        
        // Worksheet
        echo '<Worksheet ss:Name="Data Users">' . "\n";
        echo '<Table>' . "\n";
        
        if (!empty($data)) {
            // Add headers
            echo '<Row ss:StyleID="header">';
            foreach (array_keys($data[0]) as $header) {
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($header) . '</Data></Cell>';
            }
            echo '</Row>';

            // Add data rows
            foreach ($data as $index => $row) {
                echo '<Row ss:StyleID="data">';
                foreach ($row as $cell) {
                    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($cell) . '</Data></Cell>';
                }
                echo '</Row>';
            }
        }

        echo '</Table>' . "\n";
        echo '</Worksheet>' . "\n";
        echo '</Workbook>' . "\n";

        // Flush output buffer
        ob_end_flush();
        exit;
    }

    private function getAllUsers()
    {
        $db = \Config\Database::connect();
        return $db->table('users u')
            ->select('u.*, r.role_name')
            ->join('roles r', 'u.role_id = r.id')
            ->orderBy('u.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function getRoles()
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->table('roles')
                ->select('id, role_name')
                ->orderBy('role_name')
                ->get()
                ->getResultArray();
            
            if (empty($result)) {
                return [
                    ['id' => 1, 'role_name' => 'Super Admin'],
                    ['id' => 2, 'role_name' => 'Admin'],
                    ['id' => 3, 'role_name' => 'Guru'],
                    ['id' => 4, 'role_name' => 'Siswa']
                ];
            }
            
            return $result;
        } catch (Exception $e) {
            return [
                ['id' => 1, 'role_name' => 'Super Admin'],
                ['id' => 2, 'role_name' => 'Admin'],
                ['id' => 3, 'role_name' => 'Guru'],
                ['id' => 4, 'role_name' => 'Siswa']
            ];
        }
    }

    public function view($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/login');
        }

        $userData = $this->userModel->getUserWithRole($id);
        if (!$userData) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail User',
            'user' => $this->getUserDataForView(),
            'userData' => $userData
        ];

        return view('users/view', $data);
    }

    private function forceDownloadCsv($data, $filename)
    {
        // Clear any previous output
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8 encoding
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        if (!empty($data)) {
            // Add headers
            fputcsv($output, array_keys($data[0]));

            // Add data rows
            foreach ($data as $row) {
                fputcsv($output, array_values($row));
            }
        }

        fclose($output);
        exit;
    }

    private function forceDownloadExcel($data, $filename)
    {
        // Clear any previous output
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Set headers for Excel download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        // Use PhpSpreadsheet for generating Excel file
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        if (!empty($data)) {
            $headers = array_keys($data[0]);
            $sheet->fromArray($headers, null, 'A1');

            // Add data rows
            foreach ($data as $index => $row) {
                $sheet->fromArray(array_values($row), null, 'A' . ($index + 2));
            }
        }

        // Write to output
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Clear output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Output the file
        $writer->save('php://output');
        exit;
    }

    public function profile()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user dari session
        $userId = session()->get('user_id');
        // Gunakan method yang mengambil data user beserta role_name
        $user = $this->userModel->getUserWithRole($userId);

        if (!$user) {
            // Jika user tidak ditemukan di DB, logout dan redirect
            session()->destroy();
            return redirect()->to('/auth/login')->with('error', 'User tidak ditemukan. Silakan login kembali.');
        }

        // Validasi path foto profil jika ada
        if (!empty($user['profile_picture'])) {
            $profilePicturePath = FCPATH . 'uploads/profile_pictures/' . $user['profile_picture'];
            if (!file_exists($profilePicturePath)) {
                // Jika file tidak ada, hapus referensi dari database
                $this->userModel->update($userId, ['profile_picture' => null]);
                $user['profile_picture'] = null;
            }
        }

        $data = [
            'title' => 'User Profile',
            'user' => $user, // Mengirim semua data user ke view
        ];

        // Tampilkan view profile
        return view('settings/profile', $data);
    }

    public function updateProfilePicture()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Validasi request method
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        // Ambil file yang diupload
        $file = $this->request->getFile('profile_picture');
        
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid']);
        }

        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tipe file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP']);
        }

        // Validasi ukuran file (max 5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 5MB']);
        }

        try {
            // Ambil user ID dari session
            $userId = session()->get('user_id');
            
            // Buat direktori uploads jika belum ada
            $uploadPath = FCPATH . 'uploads/profile_pictures/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate nama file unik
            $fileName = 'profile_' . $userId . '_' . time() . '.' . $file->getExtension();
            
            // Pindahkan file ke direktori tujuan
            if ($file->move($uploadPath, $fileName)) {
                // Hapus foto profile lama jika ada
                $oldUser = $this->userModel->find($userId);
                if ($oldUser && !empty($oldUser['profile_picture'])) {
                    $oldFilePath = $uploadPath . $oldUser['profile_picture'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Update database dengan nama file baru
                $updateData = ['profile_picture' => $fileName];
                if ($this->userModel->update($userId, $updateData)) {
                    // Update session dengan foto profil baru
                    session()->set('profile_picture', $fileName);
                    
                    return $this->response->setJSON([
                        'success' => true, 
                        'message' => 'Foto profil berhasil diperbarui',
                        'file_url' => base_url('uploads/profile_pictures/' . $fileName)
                    ]);
                } else {
                    // Hapus file yang sudah diupload jika gagal update database
                    unlink($uploadPath . $fileName);
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan ke database']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupload file']);
            }
        } catch (Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function updateProfile()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Validasi request method
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            $userId = session()->get('user_id');
            
            // Ambil data lama dari database
            $oldUser = $this->userModel->find($userId);
            if (!$oldUser) {
                return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
            }
            
            // Ambil data dari form
            $input = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name')
            ];

            // Validasi data
            if (empty($input['username']) || empty($input['email']) || empty($input['full_name'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'Semua field harus diisi']);
            }

            // Validasi email format
            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Format email tidak valid']);
            }

            // Bandingkan dengan data lama, hanya update field yang berubah
            $userData = [];
            foreach ($input as $key => $val) {
                if ((string)$val !== (string)$oldUser[$key]) {
                    $userData[$key] = $val;
                }
            }

            // Jika tidak ada perubahan data
            if (empty($userData)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada perubahan data yang perlu disimpan']);
            }

            // Validasi untuk field yang berubah
            if (isset($userData['username'])) {
                $existingUser = $this->userModel->where('username', $userData['username'])->where('id !=', $userId)->first();
                if ($existingUser) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Username "' . $userData['username'] . '" sudah digunakan oleh user lain']);
                }
            }

            if (isset($userData['email'])) {
                $existingEmail = $this->userModel->where('email', $userData['email'])->where('id !=', $userId)->first();
                if ($existingEmail) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Email "' . $userData['email'] . '" sudah digunakan oleh user lain']);
                }
            }

            // Validasi model dengan data yang akan diupdate
            $userDataWithId = $userData;
            $userDataWithId['id'] = $userId;
            if (!$this->userModel->validate($userDataWithId)) {
                $errors = $this->userModel->errors();
                $errorMsg = 'Validasi gagal. Mohon periksa data yang Anda isi:';
                if (!empty($errors)) {
                    $errorList = [];
                    foreach ($errors as $err) {
                        $errorList[] = $err;
                    }
                    $errorMsg .= ' ' . implode(', ', $errorList);
                }
                return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
            }

            // Update database
            if ($this->userModel->update($userId, $userData)) {
                // Update session data hanya untuk field yang berubah
                $sessionUpdate = [];
                if (isset($userData['username'])) {
                    $sessionUpdate['username'] = $userData['username'];
                }
                if (isset($userData['email'])) {
                    $sessionUpdate['email'] = $userData['email'];
                }
                if (isset($userData['full_name'])) {
                    $sessionUpdate['full_name'] = $userData['full_name'];
                }
                
                if (!empty($sessionUpdate)) {
                    session()->set($sessionUpdate);
                }

                // Siapkan pesan detail perubahan
                $changes = [];
                foreach ($userData as $field => $value) {
                    switch ($field) {
                        case 'username':
                            $changes[] = 'Username';
                            break;
                        case 'email':
                            $changes[] = 'Email';
                            break;
                        case 'full_name':
                            $changes[] = 'Nama Lengkap';
                            break;
                    }
                }
                
                $changeMsg = 'Berhasil memperbarui: ' . implode(', ', $changes);

                return $this->response->setJSON([
                    'success' => true, 
                    'message' => $changeMsg,
                    'data' => array_merge($oldUser, $userData), // Gabungkan data lama dengan yang baru
                    'changes' => $userData // Data yang berubah
                ]);
            } else {
                $modelErrors = $this->userModel->errors();
                $errorMsg = 'Gagal memperbarui profil.';
                if (!empty($modelErrors)) {
                    $errorList = [];
                    foreach ($modelErrors as $err) {
                        $errorList[] = $err;
                    }
                    $errorMsg .= ' Alasan: ' . implode(', ', $errorList);
                }
                return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
            }
        } catch (Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function changePassword()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Validasi request method
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            $userId = session()->get('user_id');
            
            // Ambil data dari form
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validasi input
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Semua field harus diisi']);
            }

            // Validasi password baru dan konfirmasi
            if ($newPassword !== $confirmPassword) {
                return $this->response->setJSON(['success' => false, 'message' => 'Konfirmasi password tidak cocok']);
            }

            // Validasi panjang password
            if (strlen($newPassword) < 8) {
                return $this->response->setJSON(['success' => false, 'message' => 'Password minimal 8 karakter']);
            }

            // Ambil data user dari database
            $user = $this->userModel->find($userId);
            if (!$user) {
                return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
            }

            // Verifikasi password lama
            if (!password_verify($currentPassword, $user['password'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'Password lama tidak benar']);
            }

            // Hash password baru
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password di database
            if ($this->userModel->update($userId, ['password' => $hashedPassword])) {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Password berhasil diubah'
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah password']);
            }
        } catch (Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
