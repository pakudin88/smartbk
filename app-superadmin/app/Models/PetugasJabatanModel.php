<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasJabatanModel extends Model
{
    protected $table = 'petugas_jabatan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'petugas_id', 'jabatan_id', 'tahun_ajaran_id', 'tanggal_mulai', 'tanggal_selesai', 'status', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'petugas_id' => 'required|numeric|greater_than[0]',
        'jabatan_id' => 'required|numeric|greater_than[0]',
        'tahun_ajaran_id' => 'required|numeric|greater_than[0]',
        'tanggal_mulai' => 'required|valid_date',
        'status' => 'required|in_list[aktif,nonaktif]'
    ];

    protected $validationMessages = [
        'petugas_id' => [
            'required' => 'Petugas harus dipilih',
            'numeric' => 'Petugas harus berupa angka',
            'greater_than' => 'Petugas tidak valid'
        ],
        'jabatan_id' => [
            'required' => 'Jabatan harus dipilih',
            'numeric' => 'Jabatan harus berupa angka',
            'greater_than' => 'Jabatan tidak valid'
        ],
        'tahun_ajaran_id' => [
            'required' => 'Tahun ajaran harus dipilih',
            'numeric' => 'Tahun ajaran harus berupa angka',
            'greater_than' => 'Tahun ajaran tidak valid'
        ],
        'tanggal_mulai' => [
            'required' => 'Tanggal mulai harus diisi',
            'valid_date' => 'Format tanggal mulai tidak valid'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status harus aktif atau nonaktif'
        ]
    ];

    public function getPetugasJabatan($jabatanId)
    {
        return $this->select('petugas_jabatan.*, petugas.nama_lengkap, petugas.nip, petugas.email, roles.role_name')
                    ->join('petugas', 'petugas_jabatan.petugas_id = petugas.id')
                    ->join('roles', 'petugas.role_id = roles.id', 'left')
                    ->where('petugas_jabatan.jabatan_id', $jabatanId)
                    ->where('petugas_jabatan.status', 'aktif')
                    ->findAll();
    }

    public function getJabatanPetugas($petugasId)
    {
        return $this->select('petugas_jabatan.*, jabatan.nama_jabatan, jabatan.kode_jabatan, jabatan.kategori, jabatan.departemen')
                    ->join('jabatan', 'petugas_jabatan.jabatan_id = jabatan.id')
                    ->where('petugas_jabatan.petugas_id', $petugasId)
                    ->where('petugas_jabatan.status', 'aktif')
                    ->findAll();
    }

    public function assignPetugasToJabatan($petugasId, $jabatanId, $tahunAjaranId, $tanggalMulai = null, $tanggalSelesai = null)
    {
        // Check if assignment already exists
        $existing = $this->where('petugas_id', $petugasId)
                         ->where('jabatan_id', $jabatanId)
                         ->where('tahun_ajaran_id', $tahunAjaranId)
                         ->where('status', 'aktif')
                         ->first();

        if ($existing) {
            return false; // Already assigned
        }

        $data = [
            'petugas_id' => $petugasId,
            'jabatan_id' => $jabatanId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'tanggal_mulai' => $tanggalMulai ?? date('Y-m-d'),
            'tanggal_selesai' => $tanggalSelesai,
            'status' => 'aktif',
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }

    public function removePetugasFromJabatan($petugasId, $jabatanId)
    {
        return $this->where('petugas_id', $petugasId)
                    ->where('jabatan_id', $jabatanId)
                    ->where('status', 'aktif')
                    ->set(['status' => 'nonaktif', 'tanggal_selesai' => date('Y-m-d'), 'updated_at' => date('Y-m-d H:i:s')])
                    ->update();
    }

    public function getAvailablePetugas($jabatanId = null)
    {
        $petugasModel = new \App\Models\PetugasModel();
        $query = $petugasModel->select('petugas.*, roles.role_name')
                              ->join('roles', 'petugas.role_id = roles.id', 'left')
                              ->where('petugas.is_active', 1);

        // Exclude petugas already assigned to this jabatan (if jabatanId provided)
        if ($jabatanId) {
            $assignedPetugasIds = $this->select('petugas_id')
                                      ->where('jabatan_id', $jabatanId)
                                      ->where('status', 'aktif')
                                      ->findColumn('petugas_id');
            
            if (!empty($assignedPetugasIds)) {
                $query->whereNotIn('petugas.id', $assignedPetugasIds);
            }
        }

        return $query->findAll();
    }

    public function getJabatanStats($jabatanId)
    {
        return [
            'total_petugas' => $this->where('jabatan_id', $jabatanId)->where('status', 'aktif')->countAllResults(),
            'petugas_aktif' => $this->where('jabatan_id', $jabatanId)->where('status', 'aktif')->countAllResults(),
            'petugas_nonaktif' => $this->where('jabatan_id', $jabatanId)->where('status', 'nonaktif')->countAllResults()
        ];
    }

    public function getPetugasJabatanHistory($petugasId)
    {
        return $this->select('petugas_jabatan.*, jabatan.nama_jabatan, jabatan.kode_jabatan, jabatan.kategori, tahun_ajaran.nama_tahun_ajaran')
                    ->join('jabatan', 'petugas_jabatan.jabatan_id = jabatan.id')
                    ->join('tahun_ajaran', 'petugas_jabatan.tahun_ajaran_id = tahun_ajaran.id', 'left')
                    ->where('petugas_jabatan.petugas_id', $petugasId)
                    ->orderBy('petugas_jabatan.tanggal_mulai', 'DESC')
                    ->findAll();
    }

    public function getJabatanPetugasHistory($jabatanId)
    {
        return $this->select('petugas_jabatan.*, petugas.nama_lengkap, petugas.nip, tahun_ajaran.nama_tahun_ajaran')
                    ->join('petugas', 'petugas_jabatan.petugas_id = petugas.id')
                    ->join('tahun_ajaran', 'petugas_jabatan.tahun_ajaran_id = tahun_ajaran.id', 'left')
                    ->where('petugas_jabatan.jabatan_id', $jabatanId)
                    ->orderBy('petugas_jabatan.tanggal_mulai', 'DESC')
                    ->findAll();
    }

    public function checkMultipleJabatan($petugasId, $tahunAjaranId)
    {
        return $this->select('petugas_jabatan.*, jabatan.nama_jabatan, jabatan.kategori')
                    ->join('jabatan', 'petugas_jabatan.jabatan_id = jabatan.id')
                    ->where('petugas_jabatan.petugas_id', $petugasId)
                    ->where('petugas_jabatan.tahun_ajaran_id', $tahunAjaranId)
                    ->where('petugas_jabatan.status', 'aktif')
                    ->findAll();
    }
}
