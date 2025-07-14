<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password_hash', 'role_id', 
        'is_active', 'last_login'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validasi rules
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password_hash' => 'required|min_length[6]',
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
        'password_hash' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'role_id' => [
            'required' => 'Role wajib dipilih',
            'numeric' => 'Role harus berupa angka'
        ]
    ];

    /**
     * Mendapatkan user berdasarkan username atau email
     */
    public function getUserByLogin($login)
    {
        return $this->select('users.*, roles.name as role_name')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.username', $login)
                   ->orWhere('users.email', $login)
                   ->where('users.is_active', 1)
                   ->first();
    }

    /**
     * Mendapatkan user dengan role
     */
    public function getUserWithRole($userId)
    {
        return $this->select('users.*, roles.name as role_name, roles.description as role_description')
                   ->join('roles', 'roles.id = users.role_id')
                   ->where('users.id', $userId)
                   ->first();
    }

    /**
     * Mendapatkan semua user berdasarkan role
     */
    public function getUsersByRole($roleId)
    {
        return $this->select('users.*, roles.name as role_name')
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
        $roleStats = $this->select('roles.name as role_name, COUNT(*) as count')
                          ->join('roles', 'roles.id = users.role_id')
                          ->groupBy('users.role_id')
                          ->findAll();

        foreach ($roleStats as $stat) {
            $stats['by_role'][$stat['role_name']] = $stat['count'];
        }

        return $stats;
    }
}
