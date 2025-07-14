<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\OrangTuaModel;
use App\Models\KelasModel;

class MuridModel extends Model
{
    protected $table = 'murid';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nisn', 'nis', 'username', 'email', 'password', 'nama_lengkap', 'kelas_id',
        'no_telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'tempat_lahir',
        'agama', 'wali_kelas', 'profile_picture', 'is_active', 'last_login', 'tahun_ajaran_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nisn' => 'required|min_length[10]|max_length[20]|is_unique[murid.nisn,id,{id}]',
        'username' => 'required|min_length[3]|max_length[50]|is_unique[murid.username,id,{id}]',
        'email' => 'permit_empty|valid_email|is_unique[murid.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'jenis_kelamin' => 'required|in_list[L,P]'
    ];

    protected $validationMessages = [
        'nisn' => [
            'required' => 'NISN wajib diisi',
            'min_length' => 'NISN minimal 10 karakter',
            'max_length' => 'NISN maksimal 20 karakter',
            'is_unique' => 'NISN sudah digunakan'
        ],
        'username' => [
            'required' => 'Username wajib diisi',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 50 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan'
        ],
        'password' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'nama_lengkap' => [
            'required' => 'Nama lengkap wajib diisi',
            'min_length' => 'Nama lengkap minimal 3 karakter',
            'max_length' => 'Nama lengkap maksimal 100 karakter'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin wajib dipilih',
            'in_list' => 'Jenis kelamin harus L atau P'
        ]
    ];

    /**
     * Get murid dengan kelas information (filtered by active school year)
     */
    public function getMuridWithKelas()
    {
        // Get active school year
        $settingsModel = new \App\Models\SettingsModel();
        $activeSchoolYearId = $settingsModel->getActiveSchoolYearId();
        
        if (!$activeSchoolYearId) {
            return []; // No active school year, return empty array
        }
        
        return $this->select('murid.*, kelas.nama_kelas, kelas.tingkat, sy.nama_tahun_ajaran')
                   ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                   ->join('school_years sy', 'murid.tahun_ajaran_id = sy.id', 'left')
                   ->where('murid.is_active', 1)
                   ->where('murid.tahun_ajaran_id', $activeSchoolYearId) // Filter by active school year
                   ->orderBy('murid.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get murid by kelas
     */
    public function getMuridByKelas($kelasId)
    {
        return $this->select('murid.*, kelas.nama_kelas')
                   ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                   ->where('murid.kelas_id', $kelasId)
                   ->where('murid.is_active', 1)
                   ->orderBy('murid.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get murid by school year
     */
    public function getMuridBySchoolYear($schoolYearId)
    {
        return $this->select('murid.*, kelas.nama_kelas, kelas.tingkat')
                   ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                   ->where('murid.tahun_ajaran_id', $schoolYearId)
                   ->where('murid.is_active', 1)
                   ->orderBy('kelas.tingkat', 'ASC')
                   ->orderBy('kelas.nama_kelas', 'ASC')
                   ->orderBy('murid.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get murid dengan orang tua
     */
    public function getMuridWithOrangTua($muridId)
    {
        $murid = $this->select('murid.*, kelas.nama_kelas, kelas.tingkat')
                     ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                     ->where('murid.id', $muridId)
                     ->first();

        if ($murid) {
            // Get orang tua
            $orangTuaModel = new OrangTuaModel();
            $orangTua = $orangTuaModel->select('orang_tua.*, orang_tua_murid.hubungan, orang_tua_murid.is_primary')
                                     ->join('orang_tua_murid', 'orang_tua.id = orang_tua_murid.orang_tua_id')
                                     ->where('orang_tua_murid.murid_id', $muridId)
                                     ->orderBy('orang_tua_murid.is_primary', 'DESC')
                                     ->findAll();

            $murid['orang_tua'] = $orangTua;
        }

        return $murid;
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $stats = [];
        
        // Total murid
        $stats['total'] = $this->countAll();
        
        // Murid aktif
        $stats['active'] = $this->where('is_active', 1)->countAllResults();
        
        // Murid per kelas
        $result = $this->select('kelas.nama_kelas, kelas.tingkat, COUNT(murid.id) as count')
                       ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                       ->where('murid.is_active', 1)
                       ->groupBy('kelas.id')
                       ->orderBy('kelas.tingkat', 'ASC')
                       ->orderBy('kelas.nama_kelas', 'ASC')
                       ->findAll();
        
        $stats['by_kelas'] = $result;
        
        // Murid per jenis kelamin
        $result = $this->select('jenis_kelamin, COUNT(id) as count')
                       ->where('is_active', 1)
                       ->groupBy('jenis_kelamin')
                       ->findAll();
        
        foreach ($result as $row) {
            $stats['by_gender'][$row['jenis_kelamin']] = $row['count'];
        }
        
        return $stats;
    }

    /**
     * Check login credentials
     */
    public function checkLogin($username, $password)
    {
        $murid = $this->select('murid.*, kelas.nama_kelas')
                     ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                     ->where('murid.username', $username)
                     ->where('murid.is_active', 1)
                     ->first();

        if ($murid && password_verify($password, $murid['password'])) {
            // Update last login
            $this->update($murid['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $murid;
        }

        return false;
    }

    /**
     * Create murid with hashed password
     */
    public function createMurid($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->insert($data);
    }

    /**
     * Update murid
     */
    public function updateMurid($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        return $this->update($id, $data);
    }

    /**
     * Generate NISN
     */
    public function generateNISN()
    {
        $year = date('Y');
        $lastMurid = $this->select('nisn')
                         ->like('nisn', $year, 'after')
                         ->orderBy('nisn', 'DESC')
                         ->first();

        if ($lastMurid) {
            $lastNumber = intval(substr($lastMurid['nisn'], -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get murid for dropdown
     */
    public function getMuridForDropdown($kelasId = null)
    {
        $builder = $this->select('murid.id, murid.nama_lengkap, murid.nisn, kelas.nama_kelas')
                        ->join('kelas', 'murid.kelas_id = kelas.id', 'left')
                        ->where('murid.is_active', 1);

        if ($kelasId) {
            $builder->where('murid.kelas_id', $kelasId);
        }

        $result = $builder->orderBy('murid.nama_lengkap', 'ASC')->findAll();
        
        $options = [];
        foreach ($result as $row) {
            $options[$row['id']] = $row['nama_lengkap'] . ' (' . $row['nisn'] . ')';
        }
        
        return $options;
    }

    /**
     * Assign student to class
     */
    public function assignStudentToClass($studentId, $classId)
    {
        // Start database transaction
        $this->db->transStart();

        // 1. Update the 'users' table
        $userModel = new \App\Models\UserModel();
        $userUpdateResult = $userModel->update($studentId, ['kelas_id' => $classId]);

        if (!$userUpdateResult) {
            log_message('error', 'Assign Student: Failed to update users table for student ID: ' . $studentId);
            $this->db->transRollback();
            return false;
        }

        // 2. Update the 'murid' table
        // Find the student in 'murid' table by user_id which should be the same as studentId
        $muridData = $this->where('id', $studentId)->first();
        if ($muridData) {
            $muridUpdateResult = $this->update($muridData['id'], ['kelas_id' => $classId]);
            if (!$muridUpdateResult) {
                log_message('error', 'Assign Student: Failed to update murid table for murid ID: ' . $muridData['id']);
                $this->db->transRollback();
                return false;
            }
        } else {
            // This case might happen if a 'user' with role 'Siswa' doesn't have a corresponding entry in 'murid' table.
            // We can log this for monitoring.
            log_message('info', 'Assign Student: No corresponding record in murid table for user ID: ' . $studentId);
        }

        // Complete the transaction
        $this->db->transComplete();

        // Check transaction status
        if ($this->db->transStatus() === false) {
            log_message('error', 'Assign Student: Transaction failed for student ID: ' . $studentId);
            return false;
        }

        return true;
    }

    /**
     * Remove student from class
     */
    public function removeStudentFromClass($studentId)
    {
        $this->db->transStart();

        // 1. Update users table
        $userModel = new \App\Models\UserModel();
        $userModel->update($studentId, ['kelas_id' => null]);

        // 2. Update murid table
        $muridData = $this->where('id', $studentId)->orWhere('username', $studentId)->first();
        if ($muridData) {
            $this->update($muridData['id'], ['kelas_id' => null]);
        }

        // 3. (Optional) Remove from murid_kelas table
        // $muridKelasModel = new \App\Models\MuridKelasModel();
        // $muridKelasModel->where('murid_id', $studentId)->delete();

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Bulk assign students to class
     */
    public function bulkAssignStudentsToClass($muridIds, $kelasId)
    {
        if (empty($muridIds)) {
            return false;
        }
        
        $settingsModel = new \App\Models\SettingsModel();
        $activeSchoolYearId = $settingsModel->getActiveSchoolYearId();
        
        $success = true;
        foreach ($muridIds as $muridId) {
            $result = $this->update($muridId, [
                'kelas_id' => $kelasId,
                'tahun_ajaran_id' => $activeSchoolYearId
            ]);
            if (!$result) {
                $success = false;
            }
        }
        
        return $success;
    }

    /**
     * Move student to different class
     */
    public function moveStudentToClass($muridId, $fromKelasId, $toKelasId)
    {
        // Get active school year
        $settingsModel = new \App\Models\SettingsModel();
        $activeSchoolYearId = $settingsModel->getActiveSchoolYearId();
        
        // Verify student is currently in the from class
        $currentMurid = $this->find($muridId);
        if (!$currentMurid || $currentMurid['kelas_id'] != $fromKelasId) {
            return false;
        }
        
        // Move to new class
        return $this->update($muridId, [
            'kelas_id' => $toKelasId,
            'tahun_ajaran_id' => $activeSchoolYearId
        ]);
    }

    /**
     * Get students available for class assignment (not assigned to any class in active year)
     */
    public function getAvailableStudentsForClass()
    {
        $settingsModel = new \App\Models\SettingsModel();
        $activeSchoolYearId = $settingsModel->getActiveSchoolYearId();
        
        return $this->select('id, nama_lengkap, nisn')
                   ->where('tahun_ajaran_id', $activeSchoolYearId)
                   ->where('kelas_id', null)
                   ->where('is_active', 1)
                   ->orderBy('nama_lengkap', 'ASC')
                   ->findAll();
    }
}
