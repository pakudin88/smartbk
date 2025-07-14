<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\MuridModel;
use App\Models\KelasModel;

class OrangTuaModel extends Model
{
    protected $table = 'orang_tua';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'nama_lengkap', 'no_telepon', 'alamat',
        'pekerjaan', 'pendidikan', 'penghasilan', 'hubungan_keluarga',
        'profile_picture', 'is_active', 'last_login', 'tahun_ajaran_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[orang_tua.username,id,{id}]',
        'email' => 'permit_empty|valid_email|is_unique[orang_tua.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'hubungan_keluarga' => 'required|in_list[Ayah,Ibu,Wali]'
    ];

    protected $validationMessages = [
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
        'hubungan_keluarga' => [
            'required' => 'Hubungan keluarga wajib dipilih',
            'in_list' => 'Hubungan keluarga harus Ayah, Ibu, atau Wali'
        ]
    ];

    /**
     * Get orang tua dengan murid
     */
    public function getOrangTuaWithMurid()
    {
        return $this->select('orang_tua.*, GROUP_CONCAT(murid.nama_lengkap SEPARATOR ", ") as nama_anak')
                   ->join('orang_tua_murid', 'orang_tua.id = orang_tua_murid.orang_tua_id', 'left')
                   ->join('murid', 'orang_tua_murid.murid_id = murid.id', 'left')
                   ->where('orang_tua.is_active', 1)
                   ->groupBy('orang_tua.id')
                   ->orderBy('orang_tua.nama_lengkap', 'ASC')
                   ->findAll();
    }

    /**
     * Get orang tua by murid
     */
    public function getOrangTuaByMurid($muridId)
    {
        return $this->select('orang_tua.*, orang_tua_murid.hubungan, orang_tua_murid.is_primary')
                   ->join('orang_tua_murid', 'orang_tua.id = orang_tua_murid.orang_tua_id')
                   ->where('orang_tua_murid.murid_id', $muridId)
                   ->where('orang_tua.is_active', 1)
                   ->orderBy('orang_tua_murid.is_primary', 'DESC')
                   ->findAll();
    }

    /**
     * Get murid yang terhubung dengan orang tua tertentu
     */
    public function getMuridByOrangTua($orangTuaId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('orang_tua_murid otm')
                 ->select('m.id, m.nama_lengkap, m.nisn, m.is_active, m.profile_picture, k.nama_kelas')
                 ->join('murid m', 'otm.murid_id = m.id', 'left')
                 ->join('murid_kelas mk', 'm.id = mk.murid_id', 'left')
                 ->join('kelas k', 'mk.kelas_id = k.id', 'left')
                 ->where('otm.orang_tua_id', $orangTuaId)
                 ->orderBy('m.nama_lengkap', 'ASC')
                 ->get()
                 ->getResultArray();
    }

    /**
     * Cek apakah hubungan orang tua - murid sudah ada
     */
    public function checkHubunganMurid($orangTuaId, $muridId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('orang_tua_murid')
                 ->where('orang_tua_id', $orangTuaId)
                 ->where('murid_id', $muridId)
                 ->get()
                 ->getRowArray();
    }

    /**
     * Tambah hubungan orang tua - murid
     */
    public function addHubunganMurid($orangTuaId, $muridId)
    {
        $db = \Config\Database::connect();
        
        $data = [
            'orang_tua_id' => $orangTuaId,
            'murid_id' => $muridId,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $db->table('orang_tua_murid')->insert($data);
    }

    /**
     * Hapus hubungan orang tua - murid
     */
    public function removeHubunganMurid($orangTuaId, $muridId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('orang_tua_murid')
                 ->where('orang_tua_id', $orangTuaId)
                 ->where('murid_id', $muridId)
                 ->delete();
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $stats = [];
        
        // Total orang tua
        $stats['total'] = $this->countAll();
        
        // Orang tua aktif
        $stats['active'] = $this->where('is_active', 1)->countAllResults();
        
        // Orang tua per hubungan keluarga
        $result = $this->select('hubungan_keluarga, COUNT(id) as count')
                       ->where('is_active', 1)
                       ->groupBy('hubungan_keluarga')
                       ->findAll();
        
        foreach ($result as $row) {
            $stats['by_relation'][$row['hubungan_keluarga']] = $row['count'];
        }
        
        // Orang tua dengan jumlah anak
        $result = $this->select('orang_tua.id, orang_tua.nama_lengkap, COUNT(orang_tua_murid.murid_id) as jumlah_anak')
                       ->join('orang_tua_murid', 'orang_tua.id = orang_tua_murid.orang_tua_id', 'left')
                       ->where('orang_tua.is_active', 1)
                       ->groupBy('orang_tua.id')
                       ->having('jumlah_anak > 1')
                       ->orderBy('jumlah_anak', 'DESC')
                       ->findAll();
        
        $stats['multiple_children'] = $result;
        
        return $stats;
    }

    /**
     * Check login credentials
     */
    public function checkLogin($username, $password)
    {
        $orangTua = $this->where('username', $username)
                        ->where('is_active', 1)
                        ->first();

        if ($orangTua && password_verify($password, $orangTua['password'])) {
            // Update last login
            $this->update($orangTua['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $orangTua;
        }

        return false;
    }

    /**
     * Create orang tua with hashed password
     */
    public function createOrangTua($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->insert($data);
    }

    /**
     * Update orang tua
     */
    public function updateOrangTua($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        return $this->update($id, $data);
    }

    /**
     * Assign murid to orang tua
     */
    public function assignMurid($orangTuaId, $muridId, $hubungan, $isPrimary = false)
    {
        $db = \Config\Database::connect();
        
        // Check if relationship already exists
        $existing = $db->table('orang_tua_murid')
                      ->where('orang_tua_id', $orangTuaId)
                      ->where('murid_id', $muridId)
                      ->get()
                      ->getRowArray();

        if ($existing) {
            // Update existing relationship
            return $db->table('orang_tua_murid')
                     ->where('id', $existing['id'])
                     ->update([
                         'hubungan' => $hubungan,
                         'is_primary' => $isPrimary ? 1 : 0,
                         'updated_at' => date('Y-m-d H:i:s')
                     ]);
        } else {
            // Create new relationship
            return $db->table('orang_tua_murid')
                     ->insert([
                         'orang_tua_id' => $orangTuaId,
                         'murid_id' => $muridId,
                         'hubungan' => $hubungan,
                         'is_primary' => $isPrimary ? 1 : 0,
                         'created_at' => date('Y-m-d H:i:s'),
                         'updated_at' => date('Y-m-d H:i:s')
                     ]);
        }
    }

    /**
     * Remove murid from orang tua
     */
    public function removeMurid($orangTuaId, $muridId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('orang_tua_murid')
                 ->where('orang_tua_id', $orangTuaId)
                 ->where('murid_id', $muridId)
                 ->delete();
    }

    /**
     * Get orang tua for dropdown
     */
    public function getOrangTuaForDropdown()
    {
        $result = $this->select('id, nama_lengkap, hubungan_keluarga')
                       ->where('is_active', 1)
                       ->orderBy('nama_lengkap', 'ASC')
                       ->findAll();
        
        $options = [];
        foreach ($result as $row) {
            $options[$row['id']] = $row['nama_lengkap'] . ' (' . $row['hubungan_keluarga'] . ')';
        }
        
        return $options;
    }
}
