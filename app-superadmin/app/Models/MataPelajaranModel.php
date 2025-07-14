<?php

namespace App\Models;

use CodeIgniter\Model;

class MataPelajaranModel extends Model
{
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_mapel', 'kode_mapel', 'kategori', 'tingkat', 'jam_pelajaran', 'deskripsi', 'status', 'tahun_ajaran_id', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_mapel' => 'required|min_length[3]|max_length[100]',
        'kode_mapel' => 'required|min_length[2]|max_length[10]',
        'kategori' => 'required|in_list[wajib,pilihan,muatan_lokal]',
        'tingkat' => 'required|in_list[SD,SMP,SMA,SMK]',
        'jam_pelajaran' => 'required|numeric|greater_than[0]',
        'status' => 'required|in_list[aktif,nonaktif]',
        'tahun_ajaran_id' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'nama_mapel' => [
            'required' => 'Nama mata pelajaran harus diisi',
            'min_length' => 'Nama mata pelajaran minimal 3 karakter',
            'max_length' => 'Nama mata pelajaran maksimal 100 karakter'
        ],
        'kode_mapel' => [
            'required' => 'Kode mata pelajaran harus diisi',
            'min_length' => 'Kode mata pelajaran minimal 2 karakter',
            'max_length' => 'Kode mata pelajaran maksimal 10 karakter'
        ],
        'kategori' => [
            'required' => 'Kategori harus dipilih',
            'in_list' => 'Kategori harus wajib, pilihan, atau muatan lokal'
        ],
        'tingkat' => [
            'required' => 'Tingkat harus dipilih',
            'in_list' => 'Tingkat harus SD, SMP, SMA, atau SMK'
        ],
        'jam_pelajaran' => [
            'required' => 'Jam pelajaran harus diisi',
            'numeric' => 'Jam pelajaran harus berupa angka',
            'greater_than' => 'Jam pelajaran harus lebih dari 0'
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

    public function getActiveSubjects()
    {
        $builder = $this->where('status', 'aktif');
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getSubjectsByKategori($kategori)
    {
        $builder = $this->where('kategori', $kategori)
                       ->where('status', 'aktif');
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getSubjectsByTingkat($tingkat)
    {
        $builder = $this->where('tingkat', $tingkat)
                       ->where('status', 'aktif');
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getSubjectStats()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $stats = [
            'total' => $this->where('tahun_ajaran_id', $activeSchoolYear)->countAllResults(),
            'aktif' => $this->where('status', 'aktif')->where('tahun_ajaran_id', $activeSchoolYear)->countAllResults(),
            'nonaktif' => $this->where('status', 'nonaktif')->where('tahun_ajaran_id', $activeSchoolYear)->countAllResults()
        ];

        return $stats;
    }

    public function getSubjectCountByKategori()
    {
        $builder = $this->select('kategori, COUNT(*) as jumlah')
                       ->groupBy('kategori')
                       ->orderBy('kategori', 'ASC');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getSubjectCountByTingkat()
    {
        $builder = $this->select('tingkat, COUNT(*) as jumlah')
                       ->groupBy('tingkat')
                       ->orderBy('tingkat', 'ASC');
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    public function getTotalJamPelajaran()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $result = $this->select('SUM(jam_pelajaran) as total')
                      ->where('status', 'aktif')
                      ->where('tahun_ajaran_id', $activeSchoolYear)
                      ->first();
        
        return $result['total'] ?? 0;
    }

    public function getSubjectsBySearch($search)
    {
        $builder = $this->like('nama_mapel', $search)
                       ->orLike('kode_mapel', $search)
                       ->orLike('kategori', $search)
                       ->orLike('tingkat', $search);
        
        return $this->filterByActiveSchoolYear($builder)->get()->getResultArray();
    }

    /**
     * Get subjects by school year
     */
    public function getSubjectsBySchoolYear($schoolYearId)
    {
        return $this->where('tahun_ajaran_id', $schoolYearId)->findAll();
    }

    /**
     * Get subject stats by school year
     */
    public function getSubjectStatsBySchoolYear($schoolYearId)
    {
        $stats = [
            'total' => $this->where('tahun_ajaran_id', $schoolYearId)->countAllResults(),
            'aktif' => $this->where('status', 'aktif')->where('tahun_ajaran_id', $schoolYearId)->countAllResults(),
            'nonaktif' => $this->where('status', 'nonaktif')->where('tahun_ajaran_id', $schoolYearId)->countAllResults()
        ];

        return $stats;
    }

    public function getSubjectById($id)
    {
        return $this->find($id);
    }

    public function getSubjectByKode($kode)
    {
        $builder = $this->where('kode_mapel', $kode);
        return $this->filterByActiveSchoolYear($builder)->get()->getRowArray();
    }

    /**
     * Get all subjects with their assigned teachers
     */
    public function getSubjectsWithTeachers()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $builder = $this->db->table($this->table);
        $builder->select('
            mata_pelajaran.*,
            sy.nama_tahun_ajaran,
            COALESCE(COUNT(DISTINCT gmp.user_id), 0) as jumlah_guru,
            GROUP_CONCAT(DISTINCT u.full_name SEPARATOR ", ") as nama_guru
        ');
        $builder->join('school_years sy', 'sy.id = mata_pelajaran.tahun_ajaran_id', 'left');
        $builder->join('guru_mata_pelajaran gmp', 'mata_pelajaran.id = gmp.mata_pelajaran_id AND gmp.is_active = 1 AND gmp.tahun_ajaran = ' . $activeSchoolYear, 'left');
        $builder->join('users u', 'gmp.user_id = u.id', 'left');
        $builder->where('mata_pelajaran.tahun_ajaran_id', $activeSchoolYear);
        $builder->groupBy('mata_pelajaran.id');
        $builder->orderBy('mata_pelajaran.nama_mapel');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get teachers assigned to a specific subject
     */
    public function getTeachersBySubject($subjectId)
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $builder = $this->db->table('guru_mata_pelajaran gmp');
        $builder->select('
            u.id, u.full_name, u.email,
            gp.nip, gp.specialization,
            k.nama_kelas,
            gmp.tahun_ajaran, gmp.is_active
        ');
        $builder->join('users u', 'gmp.user_id = u.id');
        $builder->join('guru_profiles gp', 'u.id = gp.user_id', 'left');
        $builder->join('kelas k', 'gmp.kelas_id = k.id', 'left');
        $builder->where('gmp.mata_pelajaran_id', $subjectId);
        $builder->where('gmp.tahun_ajaran', $activeSchoolYear);
        $builder->where('gmp.is_active', 1);
        $builder->orderBy('u.full_name');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get available teachers for assignment
     */
    public function getAvailableTeachers()
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $builder = $this->db->table('users u');
        $builder->select('
            u.id, u.full_name, u.email,
            gp.nip, gp.specialization,
            r.role_name
        ');
        $builder->join('roles r', 'u.role_id = r.id');
        $builder->join('guru_profiles gp', 'u.id = gp.user_id', 'left');
        $builder->where('r.role_name', 'Guru');
        $builder->where('u.is_active', 1);
        $builder->where('u.tahun_ajaran_id', $activeSchoolYear);
        $builder->orderBy('u.full_name');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Assign teacher to subject
     */
    public function assignTeacherToSubject($teacherId, $subjectId, $classId = null)
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $builder = $this->db->table('guru_mata_pelajaran');
        
        // Check if assignment already exists
        $builder->where('user_id', $teacherId);
        $builder->where('mata_pelajaran_id', $subjectId);
        $builder->where('tahun_ajaran', $activeSchoolYear);
        if ($classId) {
            $builder->where('kelas_id', $classId);
        }
        
        $existing = $builder->get()->getRowArray();
        
        if ($existing) {
            // Update existing assignment
            $builder->where('id', $existing['id']);
            return $builder->update([
                'is_active' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Create new assignment
            return $builder->insert([
                'user_id' => $teacherId,
                'mata_pelajaran_id' => $subjectId,
                'kelas_id' => $classId,
                'tahun_ajaran' => $activeSchoolYear,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Remove teacher from subject
     */
    public function removeTeacherFromSubject($teacherId, $subjectId, $classId = null)
    {
        $activeSchoolYear = $this->getActiveSchoolYearId();
        
        $builder = $this->db->table('guru_mata_pelajaran');
        $builder->where('user_id', $teacherId);
        $builder->where('mata_pelajaran_id', $subjectId);
        $builder->where('tahun_ajaran', $activeSchoolYear);
        if ($classId) {
            $builder->where('kelas_id', $classId);
        }
        
        return $builder->delete();
    }

    /**
     * Copy subjects from previous year (only subject names)
     */
    public function copyFromPreviousYear($previousYearId, $currentYearId)
    {
        try {
            // Get subjects from previous year
            $previousSubjects = $this->where('tahun_ajaran_id', $previousYearId)->findAll();
            
            if (empty($previousSubjects)) {
                return [
                    'success' => false,
                    'message' => 'Tidak ada mata pelajaran di tahun ajaran sebelumnya',
                    'copied_count' => 0
                ];
            }

            // Check if current year already has subjects
            $currentSubjects = $this->where('tahun_ajaran_id', $currentYearId)->findAll();
            
            if (!empty($currentSubjects)) {
                return [
                    'success' => false,
                    'message' => 'Tahun ajaran aktif sudah memiliki mata pelajaran. Hapus terlebih dahulu jika ingin menggunakan fitur copy.',
                    'copied_count' => 0
                ];
            }

            // Start transaction
            $db = \Config\Database::connect();
            $db->transStart();

            $copiedCount = 0;
            
            foreach ($previousSubjects as $subject) {
                // Copy only the subject name, reset other fields
                $newSubject = [
                    'nama_mapel' => $subject['nama_mapel'],
                    'kode_mapel' => $subject['kode_mapel'] . '_' . date('Y'), // Add year suffix to avoid duplicate
                    'kategori' => 'wajib', // Default category
                    'tingkat' => $subject['tingkat'],
                    'jam_pelajaran' => 2, // Default hours
                    'deskripsi' => 'Disalin dari tahun ajaran sebelumnya',
                    'status' => 'aktif',
                    'tahun_ajaran_id' => $currentYearId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->insert($newSubject)) {
                    $copiedCount++;
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return [
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyalin mata pelajaran',
                    'copied_count' => 0
                ];
            }

            return [
                'success' => true,
                'message' => 'Mata pelajaran berhasil disalin',
                'copied_count' => $copiedCount
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'copied_count' => 0
            ];
        }
    }
}
