<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nip', 'username', 'email', 'password', 'nama_lengkap', 'role_id',
        'jabatan', 'departemen', 'no_telepon', 'alamat', 'tanggal_lahir',
        'jenis_kelamin', 'profile_picture', 'is_active', 'last_login', 'tahun_ajaran_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[petugas.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[petugas.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
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
        'nama_lengkap' => [
            'required' => 'Nama lengkap wajib diisi',
            'min_length' => 'Nama lengkap minimal 3 karakter',
            'max_length' => 'Nama lengkap maksimal 100 karakter'
        ],
        'role_id' => [
            'required' => 'Role wajib dipilih',
            'numeric' => 'Role harus berupa angka'
        ]
    ];

    /**
     * Get petugas dengan role information
     */
    public function getPetugasWithRole()
    {
        return $this->select('petugas.*, roles.role_name, roles.description as role_description')
                   ->join('roles', 'petugas.role_id = roles.id', 'left')
                   ->where('petugas.is_active', 1)
                   ->orderBy('petugas.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get petugas by role
     */
    public function getPetugasByRole($roleName)
    {
        return $this->select('petugas.*, roles.role_name')
                   ->join('roles', 'petugas.role_id = roles.id', 'left')
                   ->where('roles.role_name', $roleName)
                   ->where('petugas.is_active', 1)
                   ->orderBy('petugas.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get petugas by active school year
     */
    public function getPetugasBySchoolYear($schoolYearId)
    {
        return $this->select('petugas.*, roles.role_name')
                   ->join('roles', 'petugas.role_id = roles.id', 'left')
                   ->where('petugas.tahun_ajaran_id', $schoolYearId)
                   ->where('petugas.is_active', 1)
                   ->orderBy('petugas.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $stats = [];
        
        // Total petugas
        $stats['total'] = $this->countAll();
        
        // Petugas aktif
        $stats['active'] = $this->where('is_active', 1)->countAllResults();
        
        // Petugas per role
        $result = $this->select('roles.role_name, COUNT(petugas.id) as count')
                       ->join('roles', 'petugas.role_id = roles.id', 'left')
                       ->where('petugas.is_active', 1)
                       ->groupBy('roles.role_name')
                       ->findAll();
        
        foreach ($result as $row) {
            $stats['by_role'][$row['role_name']] = $row['count'];
        }
        
        return $stats;
    }

    /**
     * Check login credentials
     */
    public function checkLogin($username, $password)
    {
        $petugas = $this->select('petugas.*, roles.role_name')
                       ->join('roles', 'petugas.role_id = roles.id', 'left')
                       ->where('petugas.username', $username)
                       ->where('petugas.is_active', 1)
                       ->first();

        if ($petugas && password_verify($password, $petugas['password'])) {
            // Update last login
            $this->update($petugas['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $petugas;
        }

        return false;
    }

    /**
     * Create petugas with hashed password
     */
    public function createPetugas($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->insert($data);
    }

    /**
     * Update petugas
     */
    public function updatePetugas($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        return $this->update($id, $data);
    }

    /**
     * Get petugas for dropdown
     */
    public function getPetugasForDropdown($roleNames = [])
    {
        $builder = $this->select('petugas.id, petugas.nama_lengkap, roles.role_name')
                        ->join('roles', 'petugas.role_id = roles.id', 'left')
                        ->where('petugas.is_active', 1);

        if (!empty($roleNames)) {
            $builder->whereIn('roles.role_name', $roleNames);
        }

        $result = $builder->orderBy('petugas.nama_lengkap', 'ASC')->findAll();
        
        $options = [];
        foreach ($result as $row) {
            $options[$row['id']] = $row['nama_lengkap'] . ' (' . $row['role_name'] . ')';
        }
        
        return $options;
    }
}
