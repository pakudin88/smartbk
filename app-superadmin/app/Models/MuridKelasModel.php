<?php

namespace App\Models;

use CodeIgniter\Model;

class MuridKelasModel extends Model
{
    protected $table = 'murid_kelas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'murid_id',
        'kelas_id', 
        'tahun_ajaran_id',
        'tanggal_masuk_kelas',
        'tanggal_keluar_kelas',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'murid_id' => 'required|integer',
        'kelas_id' => 'required|integer',
        'tahun_ajaran_id' => 'required|integer',
        'status' => 'required|in_list[aktif,pindah,lulus,dropout]'
    ];

    protected $validationMessages = [
        'murid_id' => [
            'required' => 'Murid harus dipilih',
            'integer' => 'ID murid harus berupa angka'
        ],
        'kelas_id' => [
            'required' => 'Kelas harus dipilih',
            'integer' => 'ID kelas harus berupa angka'
        ],
        'tahun_ajaran_id' => [
            'required' => 'Tahun ajaran harus dipilih',
            'integer' => 'ID tahun ajaran harus berupa angka'
        ]
    ];

    /**
     * Mendapatkan murid dengan kelas untuk tahun ajaran tertentu
     */
    public function getMuridWithKelasForYear($tahunAjaranId, $filters = [])
    {
        // Ambil semua siswa aktif dengan role 'Siswa'
        $userModel = new \App\Models\UserModel();
        $builder = $userModel->builder();
        $builder->select('users.id, users.full_name as nama_lengkap, users.email, users.username as nis, users.is_active, users.created_at, users.updated_at')
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.role_name', 'Siswa');

        // Filter status
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'aktif') {
                $builder->where('users.is_active', 1);
            } else {
                $builder->where('users.is_active', 0);
            }
        } else {
            $builder->where('users.is_active', 1);
        }

        // Filter search
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('users.full_name', $filters['search'])
                ->orLike('users.username', $filters['search'])
                ->orLike('users.email', $filters['search'])
                ->groupEnd();
        }

        $builder->orderBy('users.full_name', 'ASC');
        $students = $builder->get()->getResultArray();

        // Ambil semua data kelas aktif untuk tahun ajaran ini sekaligus (optimasi)
        $muridIds = array_column($students, 'id');
        $kelasMap = [];
        if (!empty($muridIds)) {
            $kelasRows = $this->select('murid_kelas.murid_id, murid_kelas.kelas_id, murid_kelas.status as status_kelas, murid_kelas.created_at as tanggal_masuk_kelas, kelas.nama_kelas, kelas.tingkat')
                ->join('kelas', 'kelas.id = murid_kelas.kelas_id', 'left')
                ->whereIn('murid_kelas.murid_id', $muridIds)
                ->where('murid_kelas.tahun_ajaran_id', $tahunAjaranId)
                ->where('murid_kelas.status', 'aktif')
                ->findAll();
            foreach ($kelasRows as $row) {
                $kelasMap[$row['murid_id']] = $row;
            }
        }

        // Gabungkan data kelas ke data siswa
        foreach ($students as &$student) {
            $student['nisn'] = '';
            $student['jenis_kelamin'] = '';
            $student['nama_kelas'] = '';
            $student['tingkat'] = '';
            $student['status_kelas'] = '';
            $student['tanggal_masuk_kelas'] = '';
            if (isset($kelasMap[$student['id']])) {
                $student['nama_kelas'] = $kelasMap[$student['id']]['nama_kelas'] ?? '';
                $student['tingkat'] = $kelasMap[$student['id']]['tingkat'] ?? '';
                $student['status_kelas'] = $kelasMap[$student['id']]['status_kelas'] ?? '';
                $student['tanggal_masuk_kelas'] = $kelasMap[$student['id']]['tanggal_masuk_kelas'] ?? '';
            }
            $student['nama'] = $student['nama_lengkap'];
            $student['status_murid'] = $student['is_active'] ? 'aktif' : 'tidak_aktif';
        }

        // Filter kelas jika diminta (perbaiki agar tidak filter apapun jika di halaman pengguna murid)
        // Di halaman pengguna murid, filter kelas_id biasanya kosong, jadi jangan filter apapun
        // Jika ingin filter kelas, pastikan $filters['kelas_id'] berisi ID kelas numerik, bukan nama kelas
        if (!empty($filters['kelas_id']) && is_numeric($filters['kelas_id'])) {
            $students = array_filter($students, function($student) use ($filters, $kelasMap) {
                return isset($student['status_kelas']) && $student['status_kelas'] === 'aktif' && isset($student['tingkat']) && $student['tingkat'] !== '' && isset($student['nama_kelas']) && $student['nama_kelas'] !== '' && isset($kelasMap[$student['id']]) && $kelasMap[$student['id']]['kelas_id'] == $filters['kelas_id'];
            });
            $students = array_values($students); // reindex array
        }

        // Pastikan data tetap dikembalikan meskipun tidak ada kelas
        return array_values($students);
    }

    /**
     * Mendapatkan statistik murid untuk tahun ajaran tertentu
     */
    public function getStatistikMurid($tahunAjaranId)
    {
        $userModel = new \App\Models\UserModel();
        
        // Total murid aktif dengan role 'Siswa'
        $total = $userModel->builder()
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.role_name', 'Siswa')
            ->where('users.is_active', 1)
            ->countAllResults();
        
        // Note: Karena tabel users tidak memiliki field jenis_kelamin,
        // kita set default values atau bisa ambil dari profil terpisah jika ada
        $laki = 0; // Placeholder, bisa diimplementasikan jika ada tabel profil
        $perempuan = 0; // Placeholder
        
        // Murid yang sudah ada kelas (menggunakan sistem pivot)
        $sudah_kelas = $userModel->builder()
            ->join('roles', 'roles.id = users.role_id')
            ->join('murid_kelas', 'murid_kelas.murid_id = users.id AND murid_kelas.tahun_ajaran_id = ' . intval($tahunAjaranId) . ' AND murid_kelas.status = "aktif"')
            ->where('roles.role_name', 'Siswa')
            ->where('users.is_active', 1)
            ->countAllResults();
        
        // Murid yang belum ada kelas
        $belum_kelas = $total - $sudah_kelas;
        
        return [
            'total' => $total,
            'laki_laki' => $laki,
            'perempuan' => $perempuan,
            'sudah_kelas' => $sudah_kelas,
            'belum_kelas' => $belum_kelas
        ];
    }

    /**
     * Assign murid ke kelas
     */
    public function assignMuridToKelas($muridId, $kelasId, $tahunAjaranId)
    {
        // Cek apakah murid sudah ada di kelas lain di tahun ajaran yang sama
        $existing = $this->where([
            'murid_id' => $muridId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'status' => 'aktif'
        ])->first();
        
        if ($existing) {
            // Update kelas yang sudah ada
            return $this->update($existing['id'], [
                'kelas_id' => $kelasId,
                'tanggal_masuk_kelas' => date('Y-m-d')
            ]);
        } else {
            // Insert baru
            return $this->insert([
                'murid_id' => $muridId,
                'kelas_id' => $kelasId,
                'tahun_ajaran_id' => $tahunAjaranId,
                'tanggal_masuk_kelas' => date('Y-m-d'),
                'status' => 'aktif'
            ]);
        }
    }

    /**
     * Pindahkan murid dari kelas
     */
    public function removeMuridFromKelas($muridId, $tahunAjaranId, $alasan = 'pindah')
    {
        return $this->where([
            'murid_id' => $muridId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'status' => 'aktif'
        ])->set([
            'status' => $alasan,
            'tanggal_keluar_kelas' => date('Y-m-d')
        ])->update();
    }

    /**
     * Mendapatkan historis kelas murid
     */
    public function getHistorisKelas($muridId)
    {
        $builder = $this->db->table('murid_kelas mk');
        
        $builder->select('
            mk.*,
            km.nama_kelas,
            km.tingkat,
            sy.year as tahun_ajaran
        ');
        
        $builder->join('kelas_master km', 'mk.kelas_id = km.id');
        $builder->join('school_years sy', 'mk.tahun_ajaran_id = sy.id');
        
        $builder->where('mk.murid_id', $muridId);
        $builder->orderBy('sy.year', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Mendapatkan daftar murid dalam kelas tertentu
     */
    public function getMuridInKelas($kelasId, $tahunAjaranId)
    {
        $builder = $this->db->table('murid_kelas mk');
        
        $builder->select('
            m.id,
            m.nis,
            m.nama,
            m.jenis_kelamin,
            mk.tanggal_masuk_kelas,
            mk.status
        ');
        
        $builder->join('murid m', 'mk.murid_id = m.id');
        
        $builder->where([
            'mk.kelas_id' => $kelasId,
            'mk.tahun_ajaran_id' => $tahunAjaranId,
            'mk.status' => 'aktif'
        ]);
        
        $builder->orderBy('m.nama', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Bulk assign murid ke kelas
     */
    public function bulkAssignToKelas($muridIds, $kelasId, $tahunAjaranId)
    {
        $data = [];
        $timestamp = date('Y-m-d H:i:s');
        
        foreach ($muridIds as $muridId) {
            // Cek apakah sudah ada
            $existing = $this->where([
                'murid_id' => $muridId,
                'tahun_ajaran_id' => $tahunAjaranId,
                'status' => 'aktif'
            ])->first();
            
            if (!$existing) {
                $data[] = [
                    'murid_id' => $muridId,
                    'kelas_id' => $kelasId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'tanggal_masuk_kelas' => date('Y-m-d'),
                    'status' => 'aktif',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
            }
        }
        
        if (!empty($data)) {
            return $this->insertBatch($data);
        }
        
        return true;
    }

    /**
     * Memeriksa apakah seorang siswa sudah terdaftar di kelas mana pun
     * pada tahun ajaran tertentu.
     *
     * @param int $studentId
     * @param int $schoolYearId
     * @return bool
     */
    public function isStudentInAnyClass(int $studentId, int $schoolYearId): bool
    {
        return $this->where('murid_id', $studentId)
                    ->where('tahun_ajaran_id', $schoolYearId)
                    ->where('status', 'aktif')
                    ->countAllResults() > 0;
    }

    /**
     * Mendapatkan daftar siswa di kelas tertentu untuk tahun ajaran tertentu.
     *
     * @param int $classId
     * @param int $schoolYearId
     * @return array
     */
    public function getStudentsByClassAndSchoolYear(int $classId, int $schoolYearId): array
    {
        return $this->select('users.*, murid_kelas.id as murid_kelas_id, murid_kelas.status as status_di_kelas, murid_kelas.created_at as tanggal_masuk_kelas')
                    ->join('users', 'users.id = murid_kelas.murid_id')
                    ->where('murid_kelas.kelas_id', $classId)
                    ->where('murid_kelas.tahun_ajaran_id', $schoolYearId)
                    ->where('murid_kelas.status', 'aktif')
                    ->orderBy('users.full_name', 'ASC')
                    ->findAll();
    }

    /**
     * Mendapatkan jumlah siswa di kelas tertentu untuk tahun ajaran tertentu
     *
     * @param int $classId
     * @param int $schoolYearId
     * @return int
     */
    public function getStudentCountByClassAndSchoolYear(int $classId, int $schoolYearId): int
    {
        return $this->where('kelas_id', $classId)
                    ->where('tahun_ajaran_id', $schoolYearId)
                    ->where('status', 'aktif')
                    ->countAllResults();
    }

    /**
     * Mendapatkan siswa yang belum memiliki kelas pada tahun ajaran tertentu
     *
     * @param int $schoolYearId
     * @return array
     */
    public function getStudentsWithoutClass(int $schoolYearId): array
    {
        $userModel = new \App\Models\UserModel();
        
        // Ambil semua siswa yang aktif
        $allStudents = $userModel->select('users.*')
                                ->join('roles', 'roles.id = users.role_id')
                                ->where('roles.role_name', 'Siswa')
                                ->where('users.is_active', 1)
                                ->findAll();

        // Filter siswa yang belum memiliki kelas pada tahun ajaran ini
        $studentsWithoutClass = [];
        foreach ($allStudents as $student) {
            $hasClass = $this->isStudentInAnyClass($student['id'], $schoolYearId);
            if (!$hasClass) {
                $studentsWithoutClass[] = $student;
            }
        }

        return $studentsWithoutClass;
    }
}
