<?php

namespace App\Controllers;

use App\Models\MuridModel;
use App\Models\KelasModel;
use App\Models\KelasMasterModel;
use App\Models\MuridKelasModel;
use App\Models\TahunAjaranModel;
use App\Models\SettingsModel;
use CodeIgniter\Controller;

class PenggunaMuridBackup extends BaseController
{
    protected $muridModel;
    protected $kelasModel;
    protected $kelasMasterModel;
    protected $muridKelasModel;
    protected $tahunAjaranModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->muridModel = new MuridModel();
        $this->kelasModel = new KelasModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->settingsModel = new SettingsModel();
        
        // Try to initialize new models, fallback if they don't exist
        try {
            $this->kelasMasterModel = new KelasMasterModel();
            $this->muridKelasModel = new MuridKelasModel();
        } catch (\Exception $e) {
            // Models don't exist yet, will use fallback
            $this->kelasMasterModel = null;
            $this->muridKelasModel = null;
        }
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        try {
            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId();
            
            if (!$activeSchoolYearId) {
                // Jika tidak ada tahun ajaran aktif, redirect dengan pesan error
                session()->setFlashdata('error', 'Tahun ajaran aktif belum diatur. Silakan hubungi administrator.');
                return redirect()->to('/dashboard');
            }

            // Check if new structure is available
            if ($this->muridKelasModel && $this->kelasMasterModel) {
                // Use new structure
                $kelas = $this->kelasMasterModel->getKelasWithStatistik($activeSchoolYearId);
                $stats = $this->muridKelasModel->getStatistikMurid($activeSchoolYearId);
            } else {
                // Fallback to old structure
                $kelas = $this->kelasModel->getClassesForActiveYear();
                $stats = [
                    'total' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->countAllResults(),
                    'laki_laki' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'L')->countAllResults(),
                    'perempuan' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'P')->countAllResults(),
                    'sudah_kelas' => 0,
                    'belum_kelas' => 0
                ];
                
                $stats['sudah_kelas'] = $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('kelas_id IS NOT NULL')->countAllResults();
                $stats['belum_kelas'] = $stats['total'] - $stats['sudah_kelas'];
            }

            $tahunAjaran = $this->tahunAjaranModel->findAll();

            $data = [
                'title' => 'Kelola Pengguna Murid',
                'kelas' => $kelas,
                'tahun_ajaran' => $tahunAjaran,
                'stats' => $stats,
                'active_school_year_id' => $activeSchoolYearId,
                'use_new_structure' => ($this->muridKelasModel && $this->kelasMasterModel) ? true : false
            ];

            return view('pengguna_murid/index', $data);

        } catch (\Exception $e) {
            log_message('error', 'Error in PenggunaMurid::index: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to('/dashboard');
        }
    }

    public function getData()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        try {
            $search = $this->request->getGet('search');
            $kelasId = $this->request->getGet('kelas_id');
            $jenisKelamin = $this->request->getGet('jenis_kelamin');
            $status = $this->request->getGet('status');
            $page = $this->request->getGet('page') ?? 1;
            $limit = $this->request->getGet('limit') ?? 10;

            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId();
            
            if (!$activeSchoolYearId) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Tahun ajaran aktif belum diatur'
                ]);
            }

            // Check if new structure is available
            if ($this->muridKelasModel && $this->kelasMasterModel) {
                // Use new structure
                $filters = [];
                
                if ($search) {
                    $filters['search'] = $search;
                }
                
                if ($kelasId) {
                    $filters['kelas_id'] = $kelasId;
                }
                
                if ($jenisKelamin) {
                    $filters['jenis_kelamin'] = $jenisKelamin;
                }
                
                if ($status !== null && $status !== '') {
                    $filters['status'] = $status == '1' ? 'aktif' : 'tidak_aktif';
                } else {
                    $filters['status'] = 'aktif';
                }

                $allData = $this->muridKelasModel->getMuridWithKelasForYear($activeSchoolYearId, $filters);
                
            } else {
                // Fallback to old structure
                $builder = $this->muridModel
                    ->select('murid.*, kelas.nama_kelas')
                    ->join('kelas', 'kelas.id = murid.kelas_id', 'left');

                $builder->where('murid.tahun_ajaran_id', $activeSchoolYearId);

                if ($search) {
                    $builder->groupStart()
                        ->like('murid.nama_lengkap', $search)
                        ->orLike('murid.nisn', $search)
                        ->orLike('murid.nis', $search)
                        ->groupEnd();
                }

                if ($kelasId) {
                    $builder->where('murid.kelas_id', $kelasId);
                }

                if ($jenisKelamin) {
                    $builder->where('murid.jenis_kelamin', $jenisKelamin);
                }

                if ($status !== null && $status !== '') {
                    $builder->where('murid.is_active', $status);
                } else {
                    $builder->where('murid.is_active', 1);
                }

                $allData = $builder->findAll();
                
                // Transform data to match new structure format
                foreach ($allData as &$row) {
                    $row['nama'] = $row['nama_lengkap'];
                    $row['status_murid'] = $row['is_active'] ? 'aktif' : 'tidak_aktif';
                    $row['tingkat'] = null; // Not available in old structure
                    $row['status_kelas'] = $row['nama_kelas'] ? 'aktif' : null;
                }
            }
            
            $total = count($allData);
            $offset = ($page - 1) * $limit;
            $data = array_slice($allData, $offset, $limit);

            return $this->response->setJSON([
                'success' => true,
                'data' => $data,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in PenggunaMurid::getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    // Forward other methods to original controller if needed
    public function create()
    {
        return redirect()->to('/pengguna-murid/create');
    }

    public function store()
    {
        return redirect()->to('/pengguna-murid/store');
    }

    public function edit($id)
    {
        return redirect()->to('/pengguna-murid/edit/' . $id);
    }

    public function update($id)
    {
        return redirect()->to('/pengguna-murid/update/' . $id);
    }

    public function delete($id)
    {
        return redirect()->to('/pengguna-murid/delete/' . $id);
    }

    public function view($id)
    {
        return redirect()->to('/pengguna-murid/view/' . $id);
    }
}
