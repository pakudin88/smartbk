<?php

namespace App\Models;

use CodeIgniter\Model;

class MuridModel extends Model
{
    protected $table = 'app_murid';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'nisn', 'nis', 'nama_lengkap', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_telepon',
        'email', 'nama_ayah', 'nama_ibu', 'kelas_id', 'tahun_ajaran_id',
        'status', 'foto', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get murid data by user_id
     */
    public function getMuridByUserId($user_id)
    {
        return $this->where('user_id', $user_id)->first();
    }

    /**
     * Get murid data with class and school year info
     */
    public function getMuridWithDetails($user_id)
    {
        $result = $this->db->table($this->table . ' m')
            ->select('m.*, k.nama_kelas, k.tingkat, ta.nama_tahun_ajaran, ta.tahun_mulai, ta.tahun_selesai')
            ->join('kelas k', 'k.id = m.kelas_id', 'left')
            ->join('tahun_ajaran ta', 'ta.id = m.tahun_ajaran_id', 'left')
            ->where('m.user_id', $user_id)
            ->get()
            ->getRowArray();
            
        return $result ?: null;
    }
    
    /**
     * Create murid profile for user if not exists
     */
    public function createMuridProfile($user_id, $user_data = [])
    {
        // Check if profile already exists
        $existing = $this->getMuridByUserId($user_id);
        if ($existing) {
            return $existing;
        }
        
        // Get active tahun ajaran
        $tahunAjaranQuery = $this->db->table('tahun_ajaran')
            ->where('is_active', 1)
            ->get()
            ->getRowArray();
        $tahunAjaranId = $tahunAjaranQuery['id'] ?? 1;
        
        // Generate NISN and NIS
        $nisn = '000' . str_pad($user_id, 7, '0', STR_PAD_LEFT);
        $nis = str_pad($user_id, 5, '0', STR_PAD_LEFT);
        
        $data = [
            'user_id' => $user_id,
            'nisn' => $nisn,
            'nis' => $nis,
            'nama_lengkap' => $user_data['full_name'] ?? 'Nama Lengkap',
            'jenis_kelamin' => 'L',
            'email' => $user_data['email'] ?? null,
            'tahun_ajaran_id' => $tahunAjaranId,
            'status' => 'aktif'
        ];
        
        $this->insert($data);
        return $this->getMuridByUserId($user_id);
    }

    /**
     * Update murid profile
     */
    public function updateProfile($user_id, $data)
    {
        return $this->where('user_id', $user_id)->set($data)->update();
    }
}
