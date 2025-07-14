<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use Exception;

class Settings extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        try {
            $this->roleModel = new RoleModel();
        } catch (Exception $e) {
            // Jika RoleModel tidak dapat diinisialisasi, buat dummy
            $this->roleModel = null;
        }
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Pengaturan Sistem',
            'user' => $this->getUserDataForView()
        ];

        return view('settings/index', $data);
    }

    public function profile()
    {
        $user = $this->userModel->find(session('user_id'));

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan!');
        }

        $roles = $this->roleModel->findAll();

        $data = [
            'title' => 'Profil Pengguna',
            'user' => $user,
            'roles' => $roles,
            'validation' => \Config\Services::validation()
        ];

        return view('settings/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan!');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'phone' => 'max_length[15]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->update($userId, $data)) {
            // Update session data
            session()->set('user_name', $data['name']);
            session()->set('user_email', $data['email']);
            
            return redirect()->to('/settings/profile')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil!');
        }
    }

    public function changePassword()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Ubah Password',
            'user' => $this->getUserDataForView(),
            'validation' => \Config\Services::validation()
        ];

        return view('settings/change_password', $data);
    }

    public function updatePassword()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan!');
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai!');
        }

        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->update($userId, $data)) {
            return redirect()->to('/settings/change-password')->with('success', 'Password berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password!');
        }
    }

    public function system()
    {
        // Pastikan user sudah login dan memiliki hak akses
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Pengaturan Sistem',
            'appInfo' => $this->getAppInfo(),
            'user' => $this->getUserDataForView(),
            'validation' => \Config\Services::validation()
        ];

        return view('settings/system', $data);
    }

    public function backup()
    {
        // Pastikan user sudah login dan memiliki hak akses
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Backup & Restore',
            'backupFiles' => $this->getBackupFiles(),
            'user' => $this->getUserDataForView()
        ];

        return view('settings/backup', $data);
    }

    public function createBackup()
    {
        // Pastikan user sudah login dan memiliki hak akses
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/auth/login');
        }

        try {
            $db = \Config\Database::connect();
            $dbName = $db->database;
            $backupDir = WRITEPATH . 'backups/';
            
            // Buat direktori backup jika belum ada
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupDir . $filename;

            // Alternative backup method menggunakan PHP jika mysqldump tidak tersedia
            $this->createPhpBackup($db, $filepath);
            
            if (file_exists($filepath) && filesize($filepath) > 0) {
                return redirect()->to('/settings/backup')->with('success', 'Backup berhasil dibuat!');
            } else {
                return redirect()->to('/settings/backup')->with('error', 'Gagal membuat backup!');
            }
        } catch (Exception $e) {
            return redirect()->to('/settings/backup')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function createPhpBackup($db, $filepath)
    {
        $output = '';
        
        // Header SQL
        $output .= "-- Database Backup\n";
        $output .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n";
        $output .= "-- Database: " . $db->database . "\n\n";
        
        // Disable foreign key checks
        $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
        
        // Get all tables
        $tables = $db->listTables();
        
        foreach ($tables as $table) {
            // Drop table if exists
            $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
            
            // Create table structure
            $createTable = $db->query("SHOW CREATE TABLE `{$table}`")->getRowArray();
            $output .= $createTable['Create Table'] . ";\n\n";
            
            // Get table data
            $data = $db->table($table)->get()->getResultArray();
            
            if (!empty($data)) {
                $output .= "INSERT INTO `{$table}` VALUES \n";
                $rows = [];
                
                foreach ($data as $row) {
                    $values = [];
                    foreach ($row as $value) {
                        if ($value === null) {
                            $values[] = 'NULL';
                        } else {
                            $values[] = "'" . $db->escapeString($value) . "'";
                        }
                    }
                    $rows[] = '(' . implode(', ', $values) . ')';
                }
                
                $output .= implode(",\n", $rows) . ";\n\n";
            }
        }
        
        // Re-enable foreign key checks
        $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        // Write to file
        file_put_contents($filepath, $output);
    }

    public function downloadBackup($filename)
    {
        // Pastikan user sudah login dan memiliki hak akses
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/auth/login');
        }

        // Validasi nama file untuk keamanan
        $filename = basename($filename); // Mencegah directory traversal
        if (!preg_match('/^backup_[\d_-]+\.sql$/', $filename)) {
            return redirect()->to('/settings/backup')->with('error', 'Nama file backup tidak valid!');
        }

        $filepath = WRITEPATH . 'backups/' . $filename;
        
        if (file_exists($filepath)) {
            return $this->response->download($filepath, null);
        } else {
            return redirect()->to('/settings/backup')->with('error', 'File backup tidak ditemukan!');
        }
    }

    public function deleteBackup($filename)
    {
        // Pastikan user sudah login dan memiliki hak akses
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'Super Admin') {
            return redirect()->to('/auth/login');
        }

        // Validasi nama file untuk keamanan
        $filename = basename($filename); // Mencegah directory traversal
        if (!preg_match('/^backup_[\d_-]+\.sql$/', $filename)) {
            return redirect()->to('/settings/backup')->with('error', 'Nama file backup tidak valid!');
        }

        $filepath = WRITEPATH . 'backups/' . $filename;
        
        if (file_exists($filepath)) {
            if (unlink($filepath)) {
                return redirect()->to('/settings/backup')->with('success', 'File backup berhasil dihapus!');
            } else {
                return redirect()->to('/settings/backup')->with('error', 'Gagal menghapus file backup!');
            }
        } else {
            return redirect()->to('/settings/backup')->with('error', 'File backup tidak ditemukan!');
        }
    }

    public function updateProfilePicture()
    {
        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/settings/profile')->with('error', 'Data pengguna tidak ditemukan!');
        }

        $file = $this->request->getFile('profile_picture');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/profile_pictures', $newName);

            $data = ['profile_picture' => '/uploads/profile_pictures/' . $newName];

            if ($this->userModel->update($userId, $data)) {
                return redirect()->to('/settings/profile')->with('success', 'Foto profil berhasil diperbarui!');
            } else {
                return redirect()->to('/settings/profile')->with('error', 'Gagal memperbarui foto profil!');
            }
        } else {
            return redirect()->to('/settings/profile')->with('error', 'File tidak valid atau gagal diunggah!');
        }
    }

    private function getAppInfo()
    {
        return [
            'app_name' => 'Sistem Manajemen Sekolah',
            'app_version' => '1.0.0',
            'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => $this->getDatabaseVersion()
        ];
    }

    private function getDatabaseVersion()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT VERSION() as version");
        $result = $query->getRowArray();
        return $result['version'] ?? 'Unknown';
    }

    private function getBackupFiles()
    {
        $backupDir = WRITEPATH . 'backups/';
        $files = [];

        if (is_dir($backupDir)) {
            $fileList = scandir($backupDir);
            foreach ($fileList as $file) {
                if ($file != '.' && $file != '..' && pathinfo($file, PATHINFO_EXTENSION) == 'sql') {
                    $files[] = [
                        'name' => $file,
                        'size' => filesize($backupDir . $file),
                        'date' => date('Y-m-d H:i:s', filemtime($backupDir . $file))
                    ];
                }
            }
        }

        return $files;
    }
}
