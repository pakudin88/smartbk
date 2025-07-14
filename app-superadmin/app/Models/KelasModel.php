<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_kelas', 'sekolah_id', 'tingkat', 'jurusan', 'kapasitas', 'status', 'tahun_ajaran_id', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_kelas' => 'required|min_length[2]|max_length[50]',
        'sekolah_id' => 'required|numeric|greater_than[0]',
        'tingkat' => 'required|in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
        'kapasitas' => 'required|numeric|greater_than[0]',
        'status' => 'required|in_list[aktif,nonaktif]',
        'tahun_ajaran_id' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'nama_kelas' => [
            'required' => 'Nama kelas harus diisi',
            'min_length' => 'Nama kelas minimal 2 karakter',
            'max_length' => 'Nama kelas maksimal 50 karakter'
        ],
        'sekolah_id' => [
            'required' => 'Sekolah harus dipilih',
            'numeric' => 'Sekolah harus berupa angka',
            'greater_than' => 'Sekolah harus dipilih'
        ],
        'tingkat' => [
            'required' => 'Tingkat harus dipilih',
            'in_list' => 'Tingkat harus antara 1-12'
        ],
        'kapasitas' => [
            'required' => 'Kapasitas harus diisi',
            'numeric' => 'Kapasitas harus berupa angka',
            'greater_than' => 'Kapasitas harus lebih dari 0'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status harus aktif atau nonaktif'
        ],
        'tahun_ajaran_id' => [
            'required' => 'Tahun ajaran harus dipilih',
            'numeric' => 'Tahun ajaran harus berupa angka',
            'greater_than' => 'Tahun ajaran harus dipilih'
        ]
    ];

    /**
     * Get active school year ID
     */
    public function getActiveSchoolYearId()
    {
        $settingsModel = new \App\Models\SettingsModel();
        return $settingsModel->getActiveSchoolYearId();
    }

    /**
     * Auto-filter by active school year
     */
    protected function filterByActiveSchoolYear($builder = null)
    {
        if (!$builder) {
            $builder = $this->builder();
        }
        
        $activeSchoolYear = $this->getActiveSchoolYearId();
        if ($activeSchoolYear) {
            $builder->where('tahun_ajaran_id', $activeSchoolYear);
        }
        
        return $builder;
    }

    /**
     * Override insert to auto-assign active school year
     */
    public function insert($data = null, bool $returnID = true)
    {
        if (is_array($data) && !isset($data['tahun_ajaran_id'])) {
            $data['tahun_ajaran_id'] = $this->getActiveSchoolYearId();
        }
        
        return parent::insert($data, $returnID);
    }

    public function getClassesWithSchool()
    {
        $builder = $this->select('kelas.*, sekolah.nama_sekolah, sy.nama_tahun_ajaran')
                       ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                       ->join('school_years sy', 'sy.id = kelas.tahun_ajaran_id', 'left')
                       ->orderBy('kelas.id', 'DESC');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getClassesBySchool($sekolahId)
    {
        $builder = $this->where('sekolah_id', $sekolahId)
                       ->where('status', 'aktif');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getClassesByTingkat($tingkat)
    {
        $builder = $this->where('tingkat', $tingkat)
                       ->where('status', 'aktif');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getActiveClasses()
    {
        $builder = $this->where('status', 'aktif');
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getClassById($id)
    {
        return $this->find($id);
    }

    public function getClassStats()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $stats = [
            'total' => $this->where('tahun_ajaran_id', $activeSchoolYear)->countAllResults(),
            'aktif' => $this->where('status', 'aktif')->where('tahun_ajaran_id', $activeSchoolYear)->countAllResults(),
            'nonaktif' => $this->where('status', 'nonaktif')->where('tahun_ajaran_id', $activeSchoolYear)->countAllResults()
        ];

        return $stats;
    }

    public function getClassCountByTingkat()
    {
        $builder = $this->select('tingkat, COUNT(*) as jumlah')
                       ->groupBy('tingkat')
                       ->orderBy('tingkat', 'ASC');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getClassCountBySchool()
    {
        $builder = $this->select('sekolah.nama_sekolah, COUNT(*) as jumlah')
                       ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                       ->groupBy('kelas.sekolah_id')
                       ->orderBy('jumlah', 'DESC');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    /**
     * Get class with students count using pivot table
     */
    public function getClassesWithStudentCount()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $builder = $this->select('kelas.*, sekolah.nama_sekolah, sy.nama_tahun_ajaran, 
                                 COALESCE(COUNT(mk.murid_id), 0) as jumlah_siswa')
                       ->join('sekolah', 'sekolah.id = kelas.sekolah_id', 'left')
                       ->join('school_years sy', 'sy.id = kelas.tahun_ajaran_id', 'left')
                       ->join('murid_kelas mk', 'mk.kelas_id = kelas.id AND mk.tahun_ajaran_id = ' . $activeSchoolYear, 'left')
                       ->where('kelas.tahun_ajaran_id', $activeSchoolYear)
                       ->groupBy('kelas.id')
                       ->orderBy('kelas.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get classes by school year
     */
    public function getClassesBySchoolYear($schoolYearId)
    {
        return $this->where('tahun_ajaran_id', $schoolYearId)->findAll();
    }

    /**
     * Get class stats by school year
     */
    public function getClassStatsBySchoolYear($schoolYearId)
    {
        $stats = [
            'total' => $this->where('tahun_ajaran_id', $schoolYearId)->countAllResults(),
            'aktif' => $this->where('status', 'aktif')->where('tahun_ajaran_id', $schoolYearId)->countAllResults(),
            'nonaktif' => $this->where('status', 'nonaktif')->where('tahun_ajaran_id', $schoolYearId)->countAllResults()
        ];

        return $stats;
    }

    /**
     * Get students in a specific class using pivot table
     */
    public function getStudentsInClass($kelasId, $schoolYearId = null)
    {
        if ($schoolYearId === null) {
            $schoolYearId = $this->getActiveSchoolYearId();
        }
        
        $muridKelasModel = new \App\Models\MuridKelasModel();
        return $muridKelasModel->getStudentsInClass($kelasId, $schoolYearId);
    }

    /**
     * Check if class has available capacity for specific school year
     */
    public function hasAvailableCapacity($kelasId, $schoolYearId = null)
    {
        $class = $this->find($kelasId);
        if (!$class) return false;
        
        // If no school year provided, get active one
        if (!$schoolYearId) {
            $tahunAjaranModel = new \App\Models\TahunAjaranModel();
            $activeSchoolYear = $tahunAjaranModel->where('is_active', 1)->first();
            if (!$activeSchoolYear) return false;
            $schoolYearId = $activeSchoolYear['id'];
        }
        
        $muridKelasModel = new \App\Models\MuridKelasModel();
        $currentStudents = $muridKelasModel->getStudentCountByClassAndSchoolYear($kelasId, $schoolYearId);
        
        return $currentStudents < $class['kapasitas'];
    }

    /**
     * Get class capacity info for specific school year
     */
    public function getClassCapacityInfo($kelasId, $schoolYearId = null)
    {
        $class = $this->find($kelasId);
        if (!$class) return null;
        
        // If no school year provided, get active one
        if (!$schoolYearId) {
            $tahunAjaranModel = new \App\Models\TahunAjaranModel();
            $activeSchoolYear = $tahunAjaranModel->where('is_active', 1)->first();
            if (!$activeSchoolYear) return null;
            $schoolYearId = $activeSchoolYear['id'];
        }
        
        $muridKelasModel = new \App\Models\MuridKelasModel();
        $currentStudents = $muridKelasModel->getStudentCountByClassAndSchoolYear($kelasId, $schoolYearId);
        
        return [
            'kapasitas' => $class['kapasitas'],
            'terisi' => $currentStudents,
            'tersisa' => $class['kapasitas'] - $currentStudents,
            'persentase' => $class['kapasitas'] > 0 ? round(($currentStudents / $class['kapasitas']) * 100, 2) : 0
        ];
    }

    /**
     * Get classes for dropdown/select
     */
    public function getKelasForDropdown($sekolahId = null, $tahunAjaranId = null)
    {
        $builder = $this->select('id, nama_kelas, tingkat, kapasitas')
                       ->where('status', 'aktif');
        
        if ($sekolahId) {
            $builder->where('sekolah_id', $sekolahId);
        }
        
        if ($tahunAjaranId) {
            $builder->where('tahun_ajaran_id', $tahunAjaranId);
        } else {
            // Default to active school year
            $activeSchoolYear = $this->getActiveSchoolYearId();
            if ($activeSchoolYear) {
                $builder->where('tahun_ajaran_id', $activeSchoolYear);
            }
        }
        
        $result = $builder->orderBy('tingkat', 'ASC')
                         ->orderBy('nama_kelas', 'ASC')
                         ->findAll();
        
        $options = [];
        foreach ($result as $row) {
            $capacity = $this->getClassCapacityInfo($row['id']);
            $options[$row['id']] = $row['nama_kelas'] . ' (Tingkat ' . $row['tingkat'] . ') - ' . 
                                 $capacity['terisi'] . '/' . $capacity['kapasitas'] . ' siswa';
        }
        
        return $options;
    }

    /**
     * Add student to class
     */
    public function addStudentToClass($kelasId, $muridId)
    {
        // Check if class exists and has capacity
        if (!$this->hasAvailableCapacity($kelasId)) {
            return ['success' => false, 'message' => 'Kelas sudah penuh'];
        }
        
        // Update murid's kelas_id
        $muridModel = new \App\Models\MuridModel();
        $result = $muridModel->update($muridId, ['kelas_id' => $kelasId]);
        
        if ($result) {
            return ['success' => true, 'message' => 'Murid berhasil ditambahkan ke kelas'];
        } else {
            return ['success' => false, 'message' => 'Gagal menambahkan murid ke kelas'];
        }
    }

    /**
     * Remove student from class
     */
    public function removeStudentFromClass($muridId)
    {
        $muridModel = new \App\Models\MuridModel();
        $result = $muridModel->update($muridId, ['kelas_id' => null]);
        
        if ($result) {
            return ['success' => true, 'message' => 'Murid berhasil dikeluarkan dari kelas'];
        } else {
            return ['success' => false, 'message' => 'Gagal mengeluarkan murid dari kelas'];
        }
    }

    /**
     * Move student to different class
     */
    public function moveStudentToClass($muridId, $newKelasId)
    {
        // Check if new class has capacity
        if (!$this->hasAvailableCapacity($newKelasId)) {
            return ['success' => false, 'message' => 'Kelas tujuan sudah penuh'];
        }
        
        $muridModel = new \App\Models\MuridModel();
        $result = $muridModel->update($muridId, ['kelas_id' => $newKelasId]);
        
        if ($result) {
            return ['success' => true, 'message' => 'Murid berhasil dipindahkan ke kelas baru'];
        } else {
            return ['success' => false, 'message' => 'Gagal memindahkan murid ke kelas baru'];
        }
    }

    /**
     * Get students not in any class using pivot table
     */
    public function getStudentsWithoutClass($tahunAjaranId = null)
    {
        if ($tahunAjaranId === null) {
            $tahunAjaranId = $this->getActiveSchoolYearId();
        }
        
        $muridKelasModel = new \App\Models\MuridKelasModel();
        return $muridKelasModel->getStudentsWithoutClass($tahunAjaranId);
    }

    /**
     * Bulk assign students to class
     */
    public function bulkAssignStudentsToClass($kelasId, $muridIds)
    {
        if (empty($muridIds) || !is_array($muridIds)) {
            return ['success' => false, 'message' => 'Tidak ada murid yang dipilih'];
        }
        
        // Check capacity
        $class = $this->find($kelasId);
        if (!$class) {
            return ['success' => false, 'message' => 'Kelas tidak ditemukan'];
        }
        
        $currentCapacity = $this->getClassCapacityInfo($kelasId);
        $availableSlots = $currentCapacity['tersisa'];
        
        if (count($muridIds) > $availableSlots) {
            return ['success' => false, 'message' => "Kelas hanya memiliki $availableSlots slot tersisa, tetapi Anda mencoba menambahkan " . count($muridIds) . " murid"];
        }
        
        // Update all students
        $muridModel = new \App\Models\MuridModel();
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            foreach ($muridIds as $muridId) {
                $muridModel->update($muridId, ['kelas_id' => $kelasId]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return ['success' => false, 'message' => 'Gagal menambahkan murid ke kelas'];
            }
            
            $successCount = count($muridIds);
            return ['success' => true, 'message' => "$successCount murid berhasil ditambahkan ke kelas"];
            
        } catch (\Exception $e) {
            $db->transRollback();
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Get classes for active school year only
     */
    public function getClassesForActiveYear()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        if (!$activeSchoolYear) {
            return [];
        }
        
        try {
            // Check what columns are available in kelas table
            $columns = $this->db->getFieldNames('kelas');
            
            // Build select clause based on available columns
            $select_fields = [
                'k.id',
                'k.nama_kelas',
                'k.tingkat'
            ];
            
            // Add kapasitas_maksimal if exists, otherwise use default
            if (in_array('kapasitas_maksimal', $columns)) {
                $select_fields[] = 'k.kapasitas_maksimal';
            } else if (in_array('kapasitas', $columns)) {
                $select_fields[] = 'k.kapasitas as kapasitas_maksimal';
            } else {
                $select_fields[] = '35 as kapasitas_maksimal';
            }
            
            // Add status if exists, otherwise use default
            if (in_array('status', $columns)) {
                $select_fields[] = 'k.status';
            } else {
                $select_fields[] = '"aktif" as status';
            }
            
            // Add count fields
            $select_fields[] = 'COUNT(m.id) as jumlah_murid';
            $select_fields[] = 'COUNT(CASE WHEN m.jenis_kelamin = "L" THEN 1 END) as jumlah_laki';
            $select_fields[] = 'COUNT(CASE WHEN m.jenis_kelamin = "P" THEN 1 END) as jumlah_perempuan';
            
            $builder = $this->db->table('kelas k');
            $builder->select(implode(', ', $select_fields));
            
            $builder->join('murid m', 'k.id = m.kelas_id AND m.is_active = 1', 'left');
            
            // Add tahun_ajaran_id condition if column exists
            if (in_array('tahun_ajaran_id', $columns)) {
                $builder->where('k.tahun_ajaran_id', $activeSchoolYear);
            }
            
            // Add status condition if column exists
            if (in_array('status', $columns)) {
                $builder->where('k.status', 'aktif');
            }
            
            $builder->groupBy('k.id');
            $builder->orderBy('k.nama_kelas', 'ASC');
            
            $result = $builder->get()->getResultArray();
            
            // Ensure required fields are always present with defaults
            foreach ($result as &$row) {
                if (!isset($row['jumlah_murid'])) {
                    $row['jumlah_murid'] = 0;
                }
                if (!isset($row['kapasitas_maksimal'])) {
                    $row['kapasitas_maksimal'] = 35;
                }
                if (!isset($row['status'])) {
                    $row['status'] = 'aktif';
                }
            }
            
            return $result;
            
        } catch (\Exception $e) {
            log_message('error', 'Error in getClassesForActiveYear: ' . $e->getMessage());
            
            // Fallback: simple query without joins if complex query fails
            try {
                $simple_result = $this->where('status', 'aktif')
                                     ->orderBy('nama_kelas', 'ASC')
                                     ->findAll();
                
                // Add missing fields with defaults
                foreach ($simple_result as &$row) {
                    $row['jumlah_murid'] = 0;
                    if (!isset($row['kapasitas_maksimal'])) {
                        $row['kapasitas_maksimal'] = 35;
                    }
                }
                
                return $simple_result;
                
            } catch (\Exception $e2) {
                log_message('error', 'Fallback query also failed: ' . $e2->getMessage());
                return [];
            }
        }
    }
}
