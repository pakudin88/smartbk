<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAjaranModel extends Model
{
    protected $table = 'school_years';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_tahun_ajaran', 'tahun_mulai', 'tahun_selesai', 'year', 'semester', 'start_date', 'end_date', 'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_tahun_ajaran' => 'required|min_length[5]|max_length[50]',
        'tahun_mulai' => 'required|numeric|exact_length[4]',
        'tahun_selesai' => 'required|numeric|exact_length[4]',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'semester' => 'required|in_list[Ganjil,Genap]',
        'is_active' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'nama_tahun_ajaran' => [
            'required' => 'Nama tahun ajaran harus diisi',
            'min_length' => 'Nama tahun ajaran minimal 5 karakter',
            'max_length' => 'Nama tahun ajaran maksimal 50 karakter'
        ],
        'tahun_mulai' => [
            'required' => 'Tahun mulai harus diisi',
            'numeric' => 'Tahun mulai harus berupa angka',
            'exact_length' => 'Tahun mulai harus 4 digit'
        ],
        'tahun_selesai' => [
            'required' => 'Tahun selesai harus diisi',
            'numeric' => 'Tahun selesai harus berupa angka',
            'exact_length' => 'Tahun selesai harus 4 digit'
        ],
        'start_date' => [
            'required' => 'Tanggal mulai harus diisi',
            'valid_date' => 'Format tanggal mulai tidak valid'
        ],
        'end_date' => [
            'required' => 'Tanggal selesai harus diisi',
            'valid_date' => 'Format tanggal selesai tidak valid'
        ],
        'semester' => [
            'required' => 'Semester harus dipilih',
            'in_list' => 'Semester harus Ganjil atau Genap'
        ],
        'is_active' => [
            'required' => 'Status aktif harus dipilih',
            'in_list' => 'Status aktif harus 0 (nonaktif) atau 1 (aktif)'
        ]
    ];

    public function getActiveTahunAjaran()
    {
        return $this->where('is_active', 1)->first();
    }

    public function getTahunAjaranById($id)
    {
        return $this->find($id);
    }

    public function getTahunAjaranByYear($tahunMulai, $tahunSelesai)
    {
        return $this->where('tahun_mulai', $tahunMulai)
                   ->where('tahun_selesai', $tahunSelesai)
                   ->first();
    }

    public function getTahunAjaranStats()
    {
        $stats = [
            'total' => $this->countAll(),
            'aktif' => $this->where('is_active', 1)->countAllResults(),
            'nonaktif' => $this->where('is_active', 0)->countAllResults()
        ];

        return $stats;
    }

    public function getCurrentTahunAjaran()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        // Jika bulan >= Juli, maka tahun ajaran adalah tahun sekarang/tahun depan
        // Jika bulan < Juli, maka tahun ajaran adalah tahun lalu/tahun sekarang
        if ($currentMonth >= 7) {
            $tahunMulai = $currentYear;
            $tahunSelesai = $currentYear + 1;
        } else {
            $tahunMulai = $currentYear - 1;
            $tahunSelesai = $currentYear;
        }

        return $this->where('tahun_mulai', $tahunMulai)
                   ->where('tahun_selesai', $tahunSelesai)
                   ->first();
    }

    public function getUpcomingTahunAjaran()
    {
        $currentDate = date('Y-m-d');
        
        return $this->where('start_date >', $currentDate)
                   ->orderBy('start_date', 'ASC')
                   ->first();
    }

    public function getPreviousTahunAjaran()
    {
        $currentDate = date('Y-m-d');
        
        return $this->where('end_date <', $currentDate)
                   ->orderBy('end_date', 'DESC')
                   ->findAll();
    }

    public function activateOnly($id)
    {
        // Nonaktifkan semua tahun ajaran
        $this->where('id !=', $id)->set('is_active', 0)->update();
        
        // Aktifkan tahun ajaran yang dipilih
        return $this->update($id, ['is_active' => 1]);
    }

    public function getTahunAjaranByStatus($isActive)
    {
        return $this->where('is_active', $isActive)
                   ->orderBy('tahun_mulai', 'DESC')
                   ->findAll();
    }

    /**
     * Get active school year
     */
    public function getActiveSchoolYear()
    {
        return $this->where('is_active', 1)->first();
    }

    /**
     * Get all school years ordered by year
     */
    public function getAllOrdered()
    {
        return $this->orderBy('tahun_mulai', 'DESC')->findAll();
    }

    /**
     * Activate a school year and deactivate others
     */
    public function activateSchoolYear($id)
    {
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Deactivate all school years
            $this->where('is_active', 1)
                 ->set('is_active', 0)
                 ->update();

            // Activate selected school year
            $this->update($id, [
                'is_active' => 1
            ]);

            $db->transComplete();

            return $db->transStatus();

        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }

    /**
     * Get school years with statistics
     */
    public function getSchoolYearsWithStats()
    {
        $schoolYears = $this->getAllOrdered();
        
        foreach ($schoolYears as &$year) {
            // Get statistics for this school year
            $kelasModel = new \App\Models\KelasModel();
            $userModel = new \App\Models\UserModel();
            
            $year['jumlah_kelas'] = $kelasModel->where('tahun_ajaran_id', $year['id'])->countAllResults();
            $year['jumlah_siswa'] = $userModel->select('users.*')
                                            ->join('roles', 'users.role_id = roles.id')
                                            ->where('roles.role_name', 'Siswa')
                                            ->where('users.tahun_ajaran_id', $year['id'])
                                            ->countAllResults();
            $year['jumlah_guru'] = $userModel->select('users.*')
                                           ->join('roles', 'users.role_id = roles.id')
                                           ->where('roles.role_name', 'Guru')
                                           ->where('users.tahun_ajaran_id', $year['id'])
                                           ->countAllResults();
        }
        
        return $schoolYears;
    }

    /**
     * Get previous years (not active) for copy feature
     */
    public function getPreviousYears()
    {
        return $this->where('is_active', 0)
                   ->orderBy('tahun_mulai', 'DESC')
                   ->findAll();
    }

    /**
     * Get active year
     */
    public function getActiveYear()
    {
        return $this->where('is_active', 1)->first();
    }
}
