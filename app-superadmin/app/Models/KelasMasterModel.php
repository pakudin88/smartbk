<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasMasterModel extends Model
{
    protected $table = 'kelas_master';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama',
        'tingkat',
        'kapasitas',
        'deskripsi',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[1]|max_length[100]',
        'tingkat' => 'required|in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
        'kapasitas' => 'permit_empty|integer|greater_than[0]',
        'is_active' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama kelas harus diisi',
            'min_length' => 'Nama kelas minimal 1 karakter',
            'max_length' => 'Nama kelas maksimal 100 karakter'
        ],
        'tingkat' => [
            'required' => 'Tingkat harus diisi',
            'in_list' => 'Tingkat harus antara 1-12'
        ]
    ];

    /**
     * Mendapatkan semua kelas aktif
     */
    public function getKelasAktif()
    {
        return $this->where('is_active', 1)
                    ->orderBy('tingkat', 'ASC')
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Mendapatkan kelas berdasarkan tingkat
     */
    public function getKelasByTingkat($tingkat)
    {
        return $this->where([
                        'tingkat' => $tingkat,
                        'is_active' => 1
                    ])
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Mendapatkan kelas dengan statistik murid untuk tahun ajaran tertentu
     */
    public function getKelasWithStatistik($tahunAjaranId)
    {
        $builder = $this->db->table('kelas_master km');
        
        $builder->select('
            km.id,
            km.nama as nama_kelas,
            km.tingkat,
            km.kapasitas as kapasitas_maksimal,
            km.is_active as status,
            COUNT(mk.murid_id) as jumlah_murid,
            COUNT(CASE WHEN m.jenis_kelamin = "L" THEN 1 END) as jumlah_laki,
            COUNT(CASE WHEN m.jenis_kelamin = "P" THEN 1 END) as jumlah_perempuan
        ');
        
        $builder->join('murid_kelas mk', 'km.id = mk.kelas_master_id AND mk.tahun_ajaran_id = ' . $tahunAjaranId . ' AND mk.is_active = 1', 'left');
        $builder->join('murid m', 'mk.murid_id = m.id AND m.is_active = 1', 'left');
        
        $builder->where('km.is_active', 1);
        $builder->groupBy('km.id');
        $builder->orderBy('km.tingkat', 'ASC');
        $builder->orderBy('km.nama', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Cek apakah nama kelas sudah ada untuk tingkat tertentu
     */
    public function isKelasExists($namaKelas, $tingkat, $excludeId = null)
    {
        $builder = $this->where([
            'nama_kelas' => $namaKelas,
            'tingkat' => $tingkat
        ]);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Mendapatkan kelas yang tersedia (belum penuh) untuk tahun ajaran tertentu
     */
    public function getKelastersedia($tahunAjaranId)
    {
        $builder = $this->db->table('kelas_master km');
        
        $builder->select('
            km.id,
            km.nama_kelas,
            km.tingkat,
            km.kapasitas_maksimal,
            COUNT(mk.murid_id) as jumlah_murid,
            (km.kapasitas_maksimal - COUNT(mk.murid_id)) as sisa_kapasitas
        ');
        
        $builder->join('murid_kelas mk', 'km.id = mk.kelas_id AND mk.tahun_ajaran_id = ' . $tahunAjaranId . ' AND mk.status = "aktif"', 'left');
        
        $builder->where('km.status', 'aktif');
        $builder->groupBy('km.id');
        $builder->having('sisa_kapasitas >', 0);
        $builder->orderBy('km.tingkat', 'ASC');
        $builder->orderBy('km.nama_kelas', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Mendapatkan dropdown options untuk select
     */
    public function getDropdownOptions($tahunAjaranId = null)
    {
        if ($tahunAjaranId) {
            // Jika ada tahun ajaran, tampilkan dengan info kapasitas
            $kelas = $this->getKelasWithStatistik($tahunAjaranId);
            $options = [];
            
            foreach ($kelas as $k) {
                $sisa = $k['kapasitas_maksimal'] - $k['jumlah_murid'];
                $info = $k['jumlah_murid'] . '/' . $k['kapasitas_maksimal'];
                if ($sisa <= 0) {
                    $info .= ' (PENUH)';
                }
                
                $options[$k['id']] = $k['nama_kelas'] . ' (' . $k['tingkat'] . ') - ' . $info;
            }
            
            return $options;
        } else {
            // Dropdown sederhana
            $kelas = $this->getKelasAktif();
            $options = [];
            
            foreach ($kelas as $k) {
                $options[$k['id']] = $k['nama_kelas'] . ' (' . $k['tingkat'] . ')';
            }
            
            return $options;
        }
    }

    /**
     * Generate nama kelas otomatis berdasarkan tingkat
     */
    public function generateNamaKelas($tingkat)
    {
        // Cari kelas yang sudah ada untuk tingkat ini
        $existing = $this->where('tingkat', $tingkat)
                         ->orderBy('nama_kelas', 'ASC')
                         ->findAll();
        
        // Pola penamaan: [TINGKAT] A, [TINGKAT] B, dst
        $huruf = 'A';
        $tingkatRomawi = $this->convertToRoman($tingkat);
        
        foreach ($existing as $kelas) {
            $expectedName = $tingkatRomawi . ' ' . $huruf;
            
            if ($kelas['nama_kelas'] == $expectedName) {
                $huruf++;
            } else {
                break;
            }
        }
        
        return $tingkatRomawi . ' ' . $huruf;
    }

    /**
     * Convert angka ke romawi untuk nama kelas
     */
    private function convertToRoman($number)
    {
        $map = [
            1 => 'VII',  // Kelas 7
            2 => 'VIII', // Kelas 8
            3 => 'IX'    // Kelas 9
        ];
        
        return $map[$number] ?? 'X';
    }

    /**
     * Validasi kapasitas kelas
     */
    public function validateKapasitas($kelasId, $tahunAjaranId, $tambahMurid = 1)
    {
        $kelas = $this->find($kelasId);
        if (!$kelas) {
            return ['valid' => false, 'message' => 'Kelas tidak ditemukan'];
        }
        
        // Hitung jumlah murid saat ini
        $muridKelasModel = new \App\Models\MuridKelasModel();
        $currentCount = $muridKelasModel->where([
            'kelas_id' => $kelasId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'status' => 'aktif'
        ])->countAllResults();
        
        $newTotal = $currentCount + $tambahMurid;
        $kapasitas = $kelas['kapasitas_maksimal'];
        
        if ($newTotal > $kapasitas) {
            return [
                'valid' => false, 
                'message' => "Kapasitas kelas penuh. Saat ini: $currentCount/$kapasitas"
            ];
        }
        
        return [
            'valid' => true, 
            'message' => "Kapasitas tersedia. Akan menjadi: $newTotal/$kapasitas"
        ];
    }
}
