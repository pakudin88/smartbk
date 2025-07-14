<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_jabatan', 'kode_jabatan', 'kategori', 'departemen', 'level', 'deskripsi', 'status', 'tahun_ajaran_id', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_jabatan' => 'required|min_length[3]|max_length[100]',
        'kode_jabatan' => 'required|min_length[2]|max_length[10]',
        'kategori' => 'required|in_list[guru_mapel,kepala_sekolah,wakil_kepala_sekolah,guru_bk,admin,staff]',
        'departemen' => 'required|in_list[akademik,administrasi,bimbingan_konseling,kepala_sekolah]',
        'level' => 'required|in_list[pimpinan,koordinator,pelaksana]',
        'status' => 'required|in_list[aktif,nonaktif]',
        'tahun_ajaran_id' => 'permit_empty|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'nama_jabatan' => [
            'required' => 'Nama jabatan harus diisi',
            'min_length' => 'Nama jabatan minimal 3 karakter',
            'max_length' => 'Nama jabatan maksimal 100 karakter'
        ],
        'kode_jabatan' => [
            'required' => 'Kode jabatan harus diisi',
            'min_length' => 'Kode jabatan minimal 2 karakter',
            'max_length' => 'Kode jabatan maksimal 10 karakter'
        ],
        'kategori' => [
            'required' => 'Kategori harus dipilih',
            'in_list' => 'Kategori harus guru_mapel, kepala_sekolah, wakil_kepala_sekolah, guru_bk, admin, atau staff'
        ],
        'departemen' => [
            'required' => 'Departemen harus dipilih',
            'in_list' => 'Departemen harus akademik, administrasi, bimbingan_konseling, atau kepala_sekolah'
        ],
        'level' => [
            'required' => 'Level harus dipilih',
            'in_list' => 'Level harus pimpinan, koordinator, atau pelaksana'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status harus aktif atau nonaktif'
        ],
        'tahun_ajaran_id' => [
            'required' => 'Tahun ajaran harus dipilih',
            'numeric' => 'Tahun ajaran harus berupa angka',
            'greater_than' => 'Tahun ajaran tidak valid'
        ]
    ];

    public function getJabatanWithPetugas()
    {
        return $this->select('jabatan.*, COUNT(petugas_jabatan.petugas_id) as jumlah_petugas, GROUP_CONCAT(petugas.nama_lengkap SEPARATOR ", ") as nama_petugas')
                    ->join('petugas_jabatan', 'jabatan.id = petugas_jabatan.jabatan_id', 'left')
                    ->join('petugas', 'petugas_jabatan.petugas_id = petugas.id', 'left')
                    ->groupBy('jabatan.id')
                    ->findAll();
    }

    public function getJabatanByKategori($kategori = null)
    {
        if ($kategori) {
            return $this->where('kategori', $kategori)->where('status', 'aktif')->findAll();
        }
        return $this->where('status', 'aktif')->findAll();
    }

    public function getJabatanGuruMapel()
    {
        return $this->where('kategori', 'guru_mapel')->where('status', 'aktif')->findAll();
    }

    public function getActiveJabatan()
    {
        // Get active school year first
        $tahunAjaranModel = new \App\Models\TahunAjaranModel();
        $activeTahunAjaran = $tahunAjaranModel->where('is_active', 1)->first();
        
        if (!$activeTahunAjaran) {
            return [];
        }
        
        return $this->where('tahun_ajaran_id', $activeTahunAjaran['id'])
                    ->where('status', 'aktif')
                    ->findAll();
    }

    public function copyFromPreviousYear($fromTahunAjaranId, $toTahunAjaranId)
    {
        $previousJabatan = $this->where('tahun_ajaran_id', $fromTahunAjaranId)->findAll();
        
        $insertedCount = 0;
        foreach ($previousJabatan as $jabatan) {
            // Check if jabatan already exists for this year
            $existing = $this->where('kode_jabatan', $jabatan['kode_jabatan'])
                            ->where('tahun_ajaran_id', $toTahunAjaranId)
                            ->first();
            
            if (!$existing) {
                $newJabatan = [
                    'nama_jabatan' => $jabatan['nama_jabatan'],
                    'kode_jabatan' => $jabatan['kode_jabatan'],
                    'kategori' => $jabatan['kategori'],
                    'departemen' => $jabatan['departemen'],
                    'level' => $jabatan['level'],
                    'deskripsi' => $jabatan['deskripsi'],
                    'status' => $jabatan['status'],
                    'tahun_ajaran_id' => $toTahunAjaranId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                if ($this->insert($newJabatan)) {
                    $insertedCount++;
                }
            }
        }
        
        return $insertedCount;
    }

    public function getJabatanStats()
    {
        return [
            'total' => $this->countAll(),
            'aktif' => $this->where('status', 'aktif')->countAllResults(),
            'nonaktif' => $this->where('status', 'nonaktif')->countAllResults(),
            'guru_mapel' => $this->where('kategori', 'guru_mapel')->countAllResults(),
            'kepala_sekolah' => $this->where('kategori', 'kepala_sekolah')->countAllResults(),
            'admin' => $this->where('kategori', 'admin')->countAllResults()
        ];
    }

    public function searchJabatan($search = '')
    {
        if (empty($search)) {
            return $this->getJabatanWithPetugas();
        }
        
        return $this->select('jabatan.*, COUNT(petugas_jabatan.petugas_id) as jumlah_petugas, GROUP_CONCAT(petugas.nama_lengkap SEPARATOR ", ") as nama_petugas')
                    ->join('petugas_jabatan', 'jabatan.id = petugas_jabatan.jabatan_id', 'left')
                    ->join('petugas', 'petugas_jabatan.petugas_id = petugas.id', 'left')
                    ->groupBy('jabatan.id')
                    ->like('nama_jabatan', $search)
                    ->orLike('kode_jabatan', $search)
                    ->orLike('kategori', $search)
                    ->orLike('departemen', $search)
                    ->findAll();
    }

    public function getPreviousYears()
    {
        $tahunAjaranModel = new \App\Models\TahunAjaranModel();
        return $tahunAjaranModel->where('is_active', 0)
                               ->orderBy('tahun_mulai', 'DESC')
                               ->findAll();
    }

    public function getJabatanForYear($tahunAjaranId)
    {
        return $this->where('tahun_ajaran_id', $tahunAjaranId)->findAll();
    }
}
