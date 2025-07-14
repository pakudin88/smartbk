<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'full_name', 'role_id', 'kelas_id',
        'profile_picture', 'is_active', 'last_login', 'tahun_ajaran_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validasi rules
    protected $validationRules = [
        'id' => 'permit_empty',
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'role_id' => 'required|numeric'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username wajib diisi',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 50 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'required' => 'Email wajib diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan'
        ],
        'password' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'role_id' => [
            'required' => 'Role wajib dipilih',
            'numeric' => 'Role harus berupa angka'
        ]
    ];

    /**
     * Mendapatkan user berdasarkan ID
     */
    public function getUser($userId)
    {
        return $this->select('users.*, roles.role_name as role')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.id', $userId)
                   ->first();
    }

    /**
     * Mendapatkan user berdasarkan username atau email
     */
    public function getUserByLogin($login)
    {
        return $this->select('users.*, roles.role_name as role_name')
                   ->join('roles', 'roles.id = users.role_id')
                   ->groupStart()
                   ->where('users.username', $login)
                   ->orWhere('users.email', $login)
                   ->groupEnd()
                   ->where('users.is_active', 1)
                   ->first();
    }

    /**
     * Mendapatkan user berdasarkan username atau email
     */
    public function getUserByUsernameOrEmail($usernameOrEmail)
    {
        return $this->where('username', $usernameOrEmail)
                   ->orWhere('email', $usernameOrEmail)
                   ->first();
    }

    /**
     * Mendapatkan user dengan role
     */
    public function getUsersWithRoles()
    {
        return $this->select('users.*, roles.role_name as role_name')
                   ->join('roles', 'roles.id = users.role_id', 'left')
                   ->findAll();
    }

    /**
     * Mendapatkan user dengan role
     */
    public function getUserWithRole($userId)
    {
        return $this->select('users.*, roles.role_name as role_name, roles.description as role_description')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.id', $userId)
                   ->first();
    }

    /**
     * Mendapatkan semua user berdasarkan role
     */
    public function getUsersByRole($roleId)
    {
        return $this->select('users.*, roles.role_name as role_name')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.role_id', $roleId)
                   ->where('users.is_active', 1)
                   ->findAll();
    }

    /**
     * Update last login
     */
    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    /**
     * Verifikasi password
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Hash password
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($userId, $roleName)
    {
        $user = $this->getUserWithRole($userId);
        return $user && $user['role_name'] === $roleName;
    }

    /**
     * Mendapatkan user dengan profile berdasarkan role
     */
    public function getUserWithProfile($userId)
    {
        $user = $this->getUserWithRole($userId);
        if (!$user) {
            return null;
        }

        // Jika role guru, ambil profile guru
        if ($user['role_name'] === 'guru') {
            $guruProfile = $this->db->table('guru_profiles')
                                   ->where('user_id', $userId)
                                   ->get()
                                   ->getRowArray();
            if ($guruProfile) {
                $user['profile'] = $guruProfile;
            }
        }

        // Jika role siswa, ambil profile siswa
        if ($user['role_name'] === 'siswa') {
            $siswaProfile = $this->db->table('siswa_profiles')
                                    ->select('siswa_profiles.*, classes.name as class_name')
                                    ->join('classes', 'classes.id = siswa_profiles.class_id', 'left')
                                    ->where('siswa_profiles.user_id', $userId)
                                    ->get()
                                    ->getRowArray();
            if ($siswaProfile) {
                $user['profile'] = $siswaProfile;
            }
        }

        return $user;
    }

    /**
     * Mendapatkan statistik users
     */
    public function getUserStats()
    {
        $stats = [
            'total' => $this->countAll(),
            'active' => $this->where('is_active', 1)->countAllResults(false),
            'inactive' => $this->where('is_active', 0)->countAllResults(false),
            'by_role' => []
        ];

        // Statistik per role
        $roleStats = $this->select('roles.role_name as role_name, COUNT(*) as count')
                          ->join('roles', 'roles.id = users.role_id')
                          ->groupBy('users.role_id')
                          ->findAll();

        foreach ($roleStats as $stat) {
            $stats['by_role'][$stat['role_name']] = $stat['count'];
        }

        return $stats;
    }

    /**
     * Get students by class ID
     */
    public function getStudentsByClass($kelasId)
    {
        return $this->select('users.*, roles.role_name')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.kelas_id', $kelasId)
                   ->where('roles.role_name', 'Siswa')
                   ->where('users.is_active', 1)
                   ->orderBy('users.full_name', 'ASC')
                   ->findAll();
    }

    /**
     * Get users with class and school information
     */
    public function getUsersWithClassAndSchool()
    {
        return $this->select('users.*, roles.role_name, kelas.nama_kelas, kelas.tingkat, sekolah.nama_sekolah')
                   ->join('roles', 'roles.id = users.role_id', 'left')
                   ->join('kelas', 'kelas.id = users.kelas_id', 'left')
                   ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                   ->orderBy('users.created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get students without class assigned
     */
    public function getStudentsWithoutClass()
    {
        return $this->select('users.*, roles.role_name')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.kelas_id IS NULL')
                   ->where('roles.role_name', 'Siswa')
                   ->where('users.is_active', 1)
                   ->orderBy('users.full_name', 'ASC')
                   ->findAll();
    }

    /**
     * Get class statistics
     */
    public function getClassStatistics()
    {
        return $this->select('kelas.nama_kelas, kelas.tingkat, sekolah.nama_sekolah, COUNT(users.id) as jumlah_siswa')
                   ->join('kelas', 'kelas.id = users.kelas_id', 'right')
                   ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                   ->join('roles', 'roles.id = users.role_id AND roles.role_name = "Siswa"', 'left')
                   ->groupBy('kelas.id')
                   ->orderBy('sekolah.nama_sekolah, kelas.tingkat, kelas.nama_kelas')
                   ->findAll();
    }

    /**
     * Assign student to class
     */
    public function assignStudentToClass($userId, $kelasId)
    {
        return $this->update($userId, ['kelas_id' => $kelasId]);
    }

    /**
     * Remove student from class
     */
    public function removeStudentFromClass($userId)
    {
        return $this->update($userId, ['kelas_id' => null]);
    }

    /**
     * Get active school year ID
     */
    public function getActiveSchoolYearId()
    {
        $settingsModel = new \App\Models\SettingsModel();
        return $settingsModel->getActiveSchoolYearId();
    }

    /**
     * Get users with class and school info for active school year
     */
    public function getUsersWithClassAndSchoolActiveYear($perPage = null, $role = null)
    {
        $activeSchoolYearId = $this->getActiveSchoolYearId();
        
        $builder = $this->select('
            users.*,
            roles.role_name,
            kelas.nama_kelas,
            kelas.tingkat,
            sekolah.nama_sekolah
        ');
        $builder->join('roles', 'users.role_id = roles.id', 'left');
        $builder->join('kelas', 'users.kelas_id = kelas.id', 'left');
        $builder->join('sekolah', 'kelas.sekolah_id = sekolah.id', 'left');
        $builder->where('users.tahun_ajaran_id', $activeSchoolYearId);
        
        if ($role) {
            $builder->where('roles.role_name', $role);
        }
        
        $builder->orderBy('users.created_at', 'DESC');
        
        if ($perPage) {
            return $builder->paginate($perPage);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get students by class for active school year
     */
    public function getStudentsByClassActiveYear($kelasId)
    {
        $activeSchoolYearId = $this->getActiveSchoolYearId();
        
        return $this->select('users.*, roles.role_name')
                   ->join('roles', 'users.role_id = roles.id')
                   ->where('roles.role_name', 'Siswa')
                   ->where('users.kelas_id', $kelasId)
                   ->where('users.tahun_ajaran_id', $activeSchoolYearId)
                   ->where('users.is_active', 1)
                   ->orderBy('users.full_name')
                   ->findAll();
    }

    /**
     * Get students without class for active school year
     */
    public function getStudentsWithoutClassActiveYear()
    {
        $activeSchoolYearId = $this->getActiveSchoolYearId();
        
        return $this->select('users.*, roles.role_name')
                   ->join('roles', 'users.role_id = roles.id')
                   ->where('roles.role_name', 'Siswa')
                   ->where('users.kelas_id IS NULL')
                   ->where('users.tahun_ajaran_id', $activeSchoolYearId)
                   ->where('users.is_active', 1)
                   ->orderBy('users.full_name')
                   ->findAll();
    }

    /**
     * Override the default insert to add active school year
     */
    public function insert($data = null, bool $returnID = true)
    {
        if (is_array($data) && !isset($data['tahun_ajaran_id'])) {
            $data['tahun_ajaran_id'] = $this->getActiveSchoolYearId();
        }
        
        return parent::insert($data, $returnID);
    }

    /**
     * Mendapatkan jumlah user per role
     */
    public function getUserCountByRole()
    {
        return $this->select('roles.role_name, COUNT(users.id) as count')
                   ->join('roles', 'roles.id = users.role_id', 'left')
                   ->groupBy('roles.role_name')
                   ->findAll();
    }
}
