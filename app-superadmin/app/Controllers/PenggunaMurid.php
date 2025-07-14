<?php

namespace App\Controllers;

use App\Models\MuridModel;
use App\Models\KelasModel;
use App\Models\KelasMasterModel;
use App\Models\MuridKelasModel;
use App\Models\TahunAjaranModel;
use App\Models\SettingsModel;
use CodeIgniter\Controller;

class PenggunaMurid extends BaseController
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
        
        // Try to initialize new models with error handling
        try {
            // Check if tables exist first
            $db = \Config\Database::connect();
            
            // Check if kelas_master table exists
            if ($db->tableExists('kelas_master')) {
                $this->kelasMasterModel = new KelasMasterModel();
            } else {
                log_message('warning', 'Table kelas_master does not exist');
                $this->kelasMasterModel = null;
            }
            
            // Check if murid_kelas table exists
            if ($db->tableExists('murid_kelas')) {
                $this->muridKelasModel = new MuridKelasModel();
            } else {
                log_message('warning', 'Table murid_kelas does not exist');
                $this->muridKelasModel = null;
            }
            
        } catch (\Exception $e) {
            // Log error but continue with fallback
            log_message('error', 'Error initializing new models: ' . $e->getMessage());
            $this->kelasMasterModel = null;
            $this->muridKelasModel = null;
        }
    }

    public function index()
    {
        // Add debug logging
        log_message('info', 'PenggunaMurid::index - Method called');
        
        // Pastikan user sudah login - check multiple session keys
        if (!$this->isLoggedIn()) {
            log_message('info', 'PenggunaMurid::index - User not logged in, redirecting to login');
            return redirect()->to('/auth/login');
        }
        
        log_message('info', 'PenggunaMurid::index - User is logged in, proceeding');

        try {
            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId();
            log_message('info', 'PenggunaMurid::index - Active school year ID: ' . $activeSchoolYearId);
            
            if (!$activeSchoolYearId) {
                // Jika tidak ada tahun ajaran aktif, redirect dengan pesan error
                log_message('warning', 'PenggunaMurid::index - No active school year found');
                session()->setFlashdata('error', 'Tahun ajaran aktif belum diatur. Silakan hubungi administrator.');
                return redirect()->to('/dashboard');
            }

            // Check if new models are available
            if ($this->kelasMasterModel && $this->muridKelasModel) {
                try {
                    // Use new structure
                    $kelas = $this->kelasMasterModel->getKelasWithStatistik($activeSchoolYearId);
                    $stats = $this->muridKelasModel->getStatistikMurid($activeSchoolYearId);
                    log_message('info', 'PenggunaMurid::index - Using new structure successfully');
                } catch (\Exception $newStructureError) {
                    log_message('error', 'New structure failed: ' . $newStructureError->getMessage());
                    // Fall through to old structure
                    $this->kelasMasterModel = null;
                    $this->muridKelasModel = null;
                }
            }
            
            if (!$this->kelasMasterModel || !$this->muridKelasModel) {
                try {
                    // Fallback to old structure
                    log_message('info', 'PenggunaMurid::index - Using old structure');
                    $kelas = $this->kelasModel->getClassesForActiveYear();
                    $stats = [
                        'total' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->countAllResults(),
                        'laki_laki' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'L')->countAllResults(),
                        'perempuan' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'P')->countAllResults(),
                        'sudah_kelas' => 0,
                        'belum_kelas' => 0
                    ];
                    
                    // Calculate sudah_kelas and belum_kelas using pivot table if available
                    if ($this->muridKelasModel) {
                        $stats['sudah_kelas'] = $this->muridKelasModel
                            ->join('users', 'users.id = murid_kelas.murid_id')
                            ->join('roles', 'roles.id = users.role_id')
                            ->where('roles.role_name', 'Siswa')
                            ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                            ->where('murid_kelas.status', 'aktif')
                            ->where('users.is_active', 1)
                            ->countAllResults();
                    } else {
                        $stats['sudah_kelas'] = 0; // Fallback jika pivot table tidak ada
                    }
                    $stats['belum_kelas'] = $stats['total'] - $stats['sudah_kelas'];
                    log_message('info', 'PenggunaMurid::index - Old structure loaded successfully');
                } catch (\Exception $oldStructureError) {
                    log_message('error', 'Old structure also failed: ' . $oldStructureError->getMessage());
                    // Use empty data as last resort
                    $kelas = [];
                    $stats = [
                        'total' => 0,
                        'laki_laki' => 0,
                        'perempuan' => 0,
                        'sudah_kelas' => 0,
                        'belum_kelas' => 0
                    ];
                }
            }

            // Ensure kelas data has required fields
            foreach ($kelas as &$k) {
                if (!isset($k['jumlah_murid'])) {
                    $k['jumlah_murid'] = 0;
                }
                if (!isset($k['kapasitas_maksimal'])) {
                    $k['kapasitas_maksimal'] = 35;
                }
                if (!isset($k['nama_kelas'])) {
                    $k['nama_kelas'] = $k['nama'] ?? 'Unknown';
                }
            }

            try {
                $tahunAjaran = $this->tahunAjaranModel->findAll();
            } catch (\Exception $tahunAjaranError) {
                log_message('error', 'Error loading tahun ajaran: ' . $tahunAjaranError->getMessage());
                $tahunAjaran = [];
            }

            $data = [
                'title' => 'Kelola Pengguna Murid',
                'kelas' => $kelas,
                'tahun_ajaran' => $tahunAjaran,
                'stats' => $stats,
                'active_school_year_id' => $activeSchoolYearId
            ];

            log_message('info', 'PenggunaMurid::index - Data prepared, rendering view');
            
            // Try to render the main view with error handling
            try {
                return view('pengguna_murid/index', $data);
            } catch (\Exception $viewException) {
                log_message('error', 'Error rendering pengguna_murid/index view: ' . $viewException->getMessage());
                // Fallback to simple view
                return view('pengguna_murid/simple_test', $data);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error in PenggunaMurid::index: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to('/dashboard');
        }
    }

    public function getData()
    {
        // Pastikan user sudah login - check multiple session keys
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        try {
            // Handle both GET parameters and JSON body (DataTables format)
            $input = json_decode($this->request->getBody(), true);
            
            if ($input) {
                // DataTables format
                $draw = $input['draw'] ?? 1;
                $start = $input['start'] ?? 0;
                $length = $input['length'] ?? 10;
                $search = $input['search']['value'] ?? '';
                $kelasId = $input['kelas_filter'] ?? '';
                $jenisKelamin = $input['jenis_kelamin_filter'] ?? '';
                $status = $input['status_filter'] ?? '';
                
                $page = floor($start / $length) + 1;
                $limit = $length;
            } else {
                // GET parameters
                $draw = $this->request->getGet('draw') ?? 1;
                $search = $this->request->getGet('search');
                $kelasId = $this->request->getGet('kelas_id');
                $jenisKelamin = $this->request->getGet('jenis_kelamin');
                $status = $this->request->getGet('status');
                $page = $this->request->getGet('page') ?? 1;
                $limit = $this->request->getGet('limit') ?? 10;
                $start = ($page - 1) * $limit;
            }

            // Get active school year with fallback
            $activeSchoolYearId = null;
            try {
                $activeSchoolYearId = $this->settingsModel->getSetting('active_school_year_id');
            } catch (\Exception $e) {
                log_message('error', 'Error getting setting, using fallback: ' . $e->getMessage());
                // Direct database query as fallback
                $db = \Config\Database::connect();
                $query = $db->query("SELECT value FROM system_settings WHERE `key` = 'active_school_year_id'");
                $result = $query->getRow();
                $activeSchoolYearId = $result ? $result->value : null;
            }
            
            // If still no active year, set default
            if (!$activeSchoolYearId) {
                $activeSchoolYearId = 1; // Default fallback
                log_message('info', 'Using default school year ID: 1');
            }

            // Initialize data array
            $allData = [];
            
            // Check if new models are available
            if ($this->muridKelasModel) {
                try {
                    // Use new pivot structure - get all students with their class assignments
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

                    // Get students using the new pivot system
                    $allData = $this->muridKelasModel->getMuridWithKelasForYear($activeSchoolYearId, $filters);
                    
                    log_message('info', 'Using new pivot structure - found ' . count($allData) . ' students');
                    
                } catch (\Exception $e) {
                    log_message('error', 'Error using new structure, falling back to old: ' . $e->getMessage());
                    // Clear data to force fallback
                    $allData = [];
                }
            }
            
            // If no data from new structure, use fallback
            if (empty($allData)) {
                // Fallback: Use UserModel to get students from users table with role 'Siswa'
                try {
                    log_message('info', 'Using fallback structure');
                    
                    $userModel = new \App\Models\UserModel();
                    $builder = $userModel->builder();
                    
                    // Join with roles table to get only students
                    $builder->select('users.id, users.name as nama_lengkap, users.email, users.username as nis, 
                                     users.is_active, users.created_at, users.updated_at, 
                                     "" as nisn, "" as jenis_kelamin, "" as nama_kelas')
                            ->join('roles', 'roles.id = users.role_id')
                            ->where('roles.role_name', 'Siswa');
                    
                    // Apply basic filters
                    if ($search) {
                        $builder->groupStart()
                            ->like('users.name', $search)
                            ->orLike('users.email', $search)
                            ->orLike('users.username', $search)
                            ->groupEnd();
                    }
                    
                    if ($status !== null && $status !== '') {
                        $builder->where('users.is_active', $status);
                    } else {
                        $builder->where('users.is_active', 1);
                    }
                    
                    $allData = $builder->get()->getResultArray();
                    
                    log_message('info', 'Fallback query found ' . count($allData) . ' students');
                    
                    // For each student, check if they have class assignment in pivot table
                    foreach ($allData as &$row) {
                        $row['nama'] = $row['nama_lengkap'];
                        $row['status_murid'] = $row['is_active'] ? 'aktif' : 'tidak_aktif';
                        
                        // Check if student has class assignment in the active school year
                        if ($this->muridKelasModel) {
                            try {
                                $classAssignment = $this->muridKelasModel
                                    ->select('kelas.nama_kelas, kelas.tingkat')
                                    ->join('kelas', 'kelas.id = murid_kelas.kelas_id')
                                    ->where('murid_kelas.murid_id', $row['id'])
                                    ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                                    ->where('murid_kelas.status', 'aktif')
                                    ->first();
                                
                                if ($classAssignment) {
                                    $row['nama_kelas'] = $classAssignment['nama_kelas'];
                                    $row['tingkat'] = $classAssignment['tingkat'];
                                }
                            } catch (\Exception $e) {
                                log_message('error', 'Error getting class assignment: ' . $e->getMessage());
                            }
                        }
                    }
                    
                } catch (\Exception $e) {
                    log_message('error', 'Error in fallback query: ' . $e->getMessage());
                    $allData = [];
                }
            }
            
            $total = count($allData ?? []);
            $data = array_slice($allData ?? [], $start, $length);

            return $this->response->setJSON([
                'draw' => intval($draw ?? 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
                'debug' => [
                    'activeSchoolYearId' => $activeSchoolYearId,
                    'search' => $search,
                    'kelasId' => $kelasId,
                    'jenisKelamin' => $jenisKelamin,
                    'status' => $status,
                    'total' => $total,
                    'dataCount' => count($data),
                    'structure' => $this->muridKelasModel ? 'new' : 'old'
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in PenggunaMurid::getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => intval($draw ?? 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $tahunAjaran = $this->tahunAjaranModel->findAll();

        $data = [
            'title' => 'Tambah Pengguna Murid',
            'tahun_ajaran' => $tahunAjaran,
            'generated_nisn' => $this->muridModel->generateNISN(),
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_murid/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
            }
            return redirect()->to('/auth/login');
        }

        // Handle JSON data for AJAX requests
        $inputData = [];
        if ($this->request->isAJAX() && $this->request->getHeaderLine('Content-Type') === 'application/json') {
            $inputData = json_decode($this->request->getBody(), true);
        } else {
            $inputData = $this->request->getPost();
        }

        $rules = [
            'nisn' => 'required|min_length[10]|max_length[20]|is_unique[murid.nisn]',
            'username' => 'permit_empty|min_length[3]|max_length[50]|is_unique[murid.username]',
            'email' => 'permit_empty|valid_email|is_unique[murid.email]',
            'password' => 'permit_empty|min_length[6]',
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tahun_ajaran_id' => 'permit_empty|numeric'
        ];

        // For AJAX requests, use different field names
        if ($this->request->isAJAX()) {
            $rules = [
                'nisn' => 'required|min_length[10]|max_length[20]|is_unique[murid.nisn]',
                'email' => 'permit_empty|valid_email|is_unique[murid.email]',
                'nama' => 'required|min_length[3]|max_length[100]',
                'jenis_kelamin' => 'required|in_list[L,P]',
                'tahun_ajaran_id' => 'permit_empty|numeric'
            ];
        }

        if (!$this->validate($rules, $inputData)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Prepare data for database
        $data = [];
        
        if ($this->request->isAJAX()) {
            // For AJAX requests
            $data = [
                'nisn' => $inputData['nisn'] ?? '',
                'nis' => $inputData['nis'] ?? '',
                'username' => $inputData['username'] ?? $inputData['nisn'] ?? '',
                'email' => $inputData['email'] ?? '',
                'password' => $inputData['password'] ?? 'defaultpassword',
                'nama_lengkap' => $inputData['nama'] ?? '',
                'kelas_id' => null, // Kelas akan diatur dari pengelolaan kelas
                'no_telepon' => $inputData['no_telepon'] ?? '',
                'alamat' => $inputData['alamat'] ?? '',
                'tanggal_lahir' => $inputData['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $inputData['jenis_kelamin'] ?? '',
                'tempat_lahir' => $inputData['tempat_lahir'] ?? '',
                'agama' => $inputData['agama'] ?? '',
                'tahun_ajaran_id' => $inputData['tahun_ajaran_id'] ?? null,
                'is_active' => 1
            ];
        } else {
            // For form submissions
            $data = [
                'nisn' => $inputData['nisn'] ?? '',
                'nis' => $inputData['nis'] ?? '',
                'username' => $inputData['username'] ?? '',
                'email' => $inputData['email'] ?? '',
                'password' => $inputData['password'] ?? '',
                'nama_lengkap' => $inputData['nama_lengkap'] ?? '',
                'kelas_id' => null, // Kelas akan diatur dari pengelolaan kelas
                'no_telepon' => $inputData['no_telepon'] ?? '',
                'alamat' => $inputData['alamat'] ?? '',
                'tanggal_lahir' => $inputData['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $inputData['jenis_kelamin'] ?? '',
                'tempat_lahir' => $inputData['tempat_lahir'] ?? '',
                'agama' => $inputData['agama'] ?? '',
                'tahun_ajaran_id' => $inputData['tahun_ajaran_id'] ?? null,
                'is_active' => 1
            ];
        }

        try {
            $result = $this->muridModel->createMurid($data);
            if ($result) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Pengguna murid berhasil ditambahkan!',
                        'data' => ['id' => $result]
                    ]);
                }
                return redirect()->to('/pengguna-murid')->with('success', 'Pengguna murid berhasil ditambahkan!');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan pengguna murid!']);
                }
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna murid!');
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Get murid dengan informasi kelas - coba beberapa metode
        $murid = null;
        
        // Method 1: Coba dari tabel murid dulu (jika ada)
        try {
            if ($this->muridModel) {
                $murid = $this->muridModel->find($id);
            }
        } catch (\Exception $e) {
            log_message('warning', 'Error accessing murid table: ' . $e->getMessage());
        }
        
        // Method 2: Jika tidak ada di murid table, coba dari users dengan role Siswa
        if (!$murid) {
            try {
                $userModel = new \App\Models\UserModel();
                $murid = $userModel->select('users.id, users.full_name as nama_lengkap, users.email, users.username as nis, users.is_active, users.created_at, users.updated_at, "" as nisn, "" as jenis_kelamin')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('roles.role_name', 'Siswa')
                    ->where('users.id', $id)
                    ->first();
                    
                if ($murid) {
                    // Set default values for missing fields
                    $murid['nama'] = $murid['nama_lengkap'];
                    $murid['nama_kelas'] = '';
                    $murid['tingkat'] = '';
                }
            } catch (\Exception $e) {
                log_message('error', 'Error accessing users table: ' . $e->getMessage());
            }
        }
        
        // Method 3: Tambahkan info kelas jika murid ditemukan dan pivot table tersedia
        if ($murid && $this->muridKelasModel) {
            try {
                // Get active school year
                $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId() ?? 1;
                
                // Get class assignment from pivot table
                $classAssignment = $this->muridKelasModel
                    ->select('kelas.nama_kelas, kelas.tingkat')
                    ->join('kelas', 'kelas.id = murid_kelas.kelas_id')
                    ->where('murid_kelas.murid_id', $id)
                    ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                    ->where('murid_kelas.status', 'aktif')
                    ->first();
                    
                if ($classAssignment) {
                    $murid['nama_kelas'] = $classAssignment['nama_kelas'];
                    $murid['tingkat'] = $classAssignment['tingkat'];
                }
            } catch (\Exception $e) {
                log_message('warning', 'Error getting class assignment: ' . $e->getMessage());
            }
        }

        if (!$murid) {
            session()->setFlashdata('error', 'Data murid dengan ID ' . $id . ' tidak ditemukan.');
            return redirect()->to('/pengguna-murid');
        }

        $tahunAjaran = $this->tahunAjaranModel->findAll();

        $data = [
            'title' => 'Edit Pengguna Murid',
            'murid' => $murid,
            'tahun_ajaran' => $tahunAjaran,
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_murid/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
            }
            return redirect()->to('/auth/login');
        }

        $murid = $this->muridModel->find($id);

        if (!$murid) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Pengguna murid tidak ditemukan']);
            }
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna murid tidak ditemukan');
        }

        // Handle JSON data for AJAX requests
        $inputData = [];
        if ($this->request->isAJAX() && $this->request->getHeaderLine('Content-Type') === 'application/json') {
            $inputData = json_decode($this->request->getBody(), true);
        } else {
            $inputData = $this->request->getPost();
        }

        $rules = [
            'nisn' => "required|min_length[10]|max_length[20]|is_unique[murid.nisn,id,{$id}]",
            'username' => "permit_empty|min_length[3]|max_length[50]|is_unique[murid.username,id,{$id}]",
            'email' => "permit_empty|valid_email|is_unique[murid.email,id,{$id}]",
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tahun_ajaran_id' => 'permit_empty|numeric'
        ];

        // For AJAX requests, use different field names
        if ($this->request->isAJAX()) {
            $rules = [
                'nisn' => "required|min_length[10]|max_length[20]|is_unique[murid.nisn,id,{$id}]",
                'email' => "permit_empty|valid_email|is_unique[murid.email,id,{$id}]",
                'nama' => 'required|min_length[3]|max_length[100]',
                'jenis_kelamin' => 'required|in_list[L,P]',
                'tahun_ajaran_id' => 'permit_empty|numeric'
            ];
        }

        if (!$this->validate($rules, $inputData)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Prepare data for database
        $data = [];
        
        if ($this->request->isAJAX()) {
            // For AJAX requests - kelas_id tidak diubah, pertahankan yang ada
            $data = [
                'nisn' => $inputData['nisn'] ?? $murid['nisn'],
                'nis' => $inputData['nis'] ?? $murid['nis'],
                'username' => $inputData['username'] ?? $murid['username'],
                'email' => $inputData['email'] ?? $murid['email'],
                'nama_lengkap' => $inputData['nama'] ?? $murid['nama_lengkap'],
                // kelas_id tetap tidak diubah
                'no_telepon' => $inputData['no_telepon'] ?? $murid['no_telepon'],
                'alamat' => $inputData['alamat'] ?? $murid['alamat'],
                'tanggal_lahir' => $inputData['tanggal_lahir'] ?? $murid['tanggal_lahir'],
                'jenis_kelamin' => $inputData['jenis_kelamin'] ?? $murid['jenis_kelamin'],
                'tempat_lahir' => $inputData['tempat_lahir'] ?? $murid['tempat_lahir'],
                'agama' => $inputData['agama'] ?? $murid['agama'],
                'tahun_ajaran_id' => $inputData['tahun_ajaran_id'] ?? $murid['tahun_ajaran_id'],
            ];
        } else {
            // For form submissions - kelas_id tidak diubah, pertahankan yang ada
            $data = [
                'nisn' => $inputData['nisn'] ?? $murid['nisn'],
                'nis' => $inputData['nis'] ?? $murid['nis'],
                'username' => $inputData['username'] ?? $murid['username'],
                'email' => $inputData['email'] ?? $murid['email'],
                'nama_lengkap' => $inputData['nama_lengkap'] ?? $murid['nama_lengkap'],
                // kelas_id tetap tidak diubah
                'no_telepon' => $inputData['no_telepon'] ?? $murid['no_telepon'],
                'alamat' => $inputData['alamat'] ?? $murid['alamat'],
                'tanggal_lahir' => $inputData['tanggal_lahir'] ?? $murid['tanggal_lahir'],
                'jenis_kelamin' => $inputData['jenis_kelamin'] ?? $murid['jenis_kelamin'],
                'tempat_lahir' => $inputData['tempat_lahir'] ?? $murid['tempat_lahir'],
                'agama' => $inputData['agama'] ?? $murid['agama'],
                'tahun_ajaran_id' => $inputData['tahun_ajaran_id'] ?? $murid['tahun_ajaran_id'],
            ];
        }

        // Only update password if provided
        if (!empty($inputData['password'])) {
            $data['password'] = $inputData['password'];
        }

        try {
            $result = $this->muridModel->updateMurid($id, $data);
            if ($result) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Pengguna murid berhasil diperbarui!'
                    ]);
                }
                return redirect()->to('/pengguna-murid')->with('success', 'Pengguna murid berhasil diperbarui!');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui pengguna murid!']);
                }
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna murid!');
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Cari murid dari berbagai sumber
        $murid = null;
        
        // Method 1: Coba dari tabel murid dulu (jika ada)
        try {
            if ($this->muridModel) {
                $murid = $this->muridModel->find($id);
            }
        } catch (\Exception $e) {
            log_message('warning', 'Error accessing murid table: ' . $e->getMessage());
        }
        
        // Method 2: Jika tidak ada di murid table, coba dari users dengan role Siswa
        if (!$murid) {
            try {
                $userModel = new \App\Models\UserModel();
                $murid = $userModel->select('users.id, users.full_name as nama_lengkap, users.email, users.username as nis, users.is_active')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('roles.role_name', 'Siswa')
                    ->where('users.id', $id)
                    ->first();
            } catch (\Exception $e) {
                log_message('error', 'Error accessing users table: ' . $e->getMessage());
            }
        }

        if (!$murid) {
            session()->setFlashdata('error', 'Data murid dengan ID ' . $id . ' tidak ditemukan.');
            return redirect()->to('/pengguna-murid');
        }

        try {
            // Hapus dari tabel yang sesuai
            $deleted = false;
            
            if ($this->muridModel) {
                try {
                    $deleted = $this->muridModel->delete($id);
                } catch (\Exception $e) {
                    log_message('warning', 'Error deleting from murid table: ' . $e->getMessage());
                }
            }
            
            // Jika gagal atau tidak ada tabel murid, coba hapus dari users
            if (!$deleted) {
                $userModel = new \App\Models\UserModel();
                $deleted = $userModel->delete($id);
            }
            
            if ($deleted) {
                return redirect()->to('/pengguna-murid')->with('success', 'Pengguna murid berhasil dihapus!');
            } else {
                return redirect()->to('/pengguna-murid')->with('error', 'Gagal menghapus pengguna murid!');
            }
        } catch (\Exception $e) {
            return redirect()->to('/pengguna-murid')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function ajaxDelete($id)
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Cari murid dari berbagai sumber
        $murid = null;
        
        // Method 1: Coba dari tabel murid dulu (jika ada)
        try {
            if ($this->muridModel) {
                $murid = $this->muridModel->find($id);
            }
        } catch (\Exception $e) {
            log_message('warning', 'Error accessing murid table: ' . $e->getMessage());
        }
        
        // Method 2: Jika tidak ada di murid table, coba dari users dengan role Siswa
        if (!$murid) {
            try {
                $userModel = new \App\Models\UserModel();
                $murid = $userModel->select('users.id, users.full_name as nama_lengkap, users.email, users.username as nis, users.is_active')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('roles.role_name', 'Siswa')
                    ->where('users.id', $id)
                    ->first();
            } catch (\Exception $e) {
                log_message('error', 'Error accessing users table: ' . $e->getMessage());
            }
        }

        if (!$murid) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pengguna murid tidak ditemukan']);
        }

        try {
            // Hapus dari tabel yang sesuai
            $deleted = false;
            
            if ($this->muridModel) {
                try {
                    $deleted = $this->muridModel->delete($id);
                } catch (\Exception $e) {
                    log_message('warning', 'Error deleting from murid table: ' . $e->getMessage());
                }
            }
            
            // Jika gagal atau tidak ada tabel murid, coba hapus dari users
            if (!$deleted) {
                $userModel = new \App\Models\UserModel();
                $deleted = $userModel->delete($id);
            }
            
            if ($deleted) {
                return $this->response->setJSON(['success' => true, 'message' => 'Pengguna murid berhasil dihapus!']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pengguna murid!']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function view($id)
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Get murid dengan informasi kelas - coba beberapa metode
        $murid = null;
        
        // Method 1: Coba dari tabel murid dulu (jika ada)
        try {
            if ($this->muridModel) {
                $murid = $this->muridModel->find($id);
            }
        } catch (\Exception $e) {
            log_message('warning', 'Error accessing murid table: ' . $e->getMessage());
        }
        
        // Method 2: Jika tidak ada di murid table, coba dari users dengan role Siswa
        if (!$murid) {
            try {
                $userModel = new \App\Models\UserModel();
                $murid = $userModel->select('users.id, users.full_name as nama_lengkap, users.email, users.username, users.username as nis, users.is_active, users.created_at, users.updated_at, "" as nisn, "" as jenis_kelamin, "" as tempat_lahir, "" as tanggal_lahir, "" as agama, "" as no_telepon, 1 as tahun_ajaran_id')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('roles.role_name', 'Siswa')
                    ->where('users.id', $id)
                    ->first();
                    
                if ($murid) {
                    // Set default values for missing fields
                    $murid['nama'] = $murid['nama_lengkap'];
                    $murid['nama_kelas'] = '';
                    $murid['tingkat'] = '';
                    $murid['nama_tahun_ajaran'] = 'Tahun Ajaran Aktif';
                    $murid['kelas_name'] = '';
                    $murid['profile_picture'] = '';
                    $murid['wali_kelas'] = '';
                    $murid['alamat'] = '';
                    $murid['last_login'] = '';
                }
            } catch (\Exception $e) {
                log_message('error', 'Error accessing users table: ' . $e->getMessage());
            }
        }
        
        // Method 3: Tambahkan info kelas jika murid ditemukan dan pivot table tersedia
        if ($murid && $this->muridKelasModel) {
            try {
                // Get active school year
                $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId() ?? 1;
                
                // Get class assignment from pivot table
                $classAssignment = $this->muridKelasModel
                    ->select('kelas.nama_kelas, kelas.tingkat')
                    ->join('kelas', 'kelas.id = murid_kelas.kelas_id')
                    ->where('murid_kelas.murid_id', $id)
                    ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                    ->where('murid_kelas.status', 'aktif')
                    ->first();
                    
                if ($classAssignment) {
                    $murid['nama_kelas'] = $classAssignment['nama_kelas'];
                    $murid['tingkat'] = $classAssignment['tingkat'];
                }
                
                // Get school year info
                $schoolYear = $this->tahunAjaranModel->find($activeSchoolYearId);
                if ($schoolYear) {
                    $murid['nama_tahun_ajaran'] = $schoolYear['nama'] ?? $schoolYear['year'] ?? 'Tahun Ajaran Aktif';
                }
            } catch (\Exception $e) {
                log_message('warning', 'Error getting class assignment: ' . $e->getMessage());
            }
        }

        if (!$murid) {
            session()->setFlashdata('error', 'Data murid dengan ID ' . $id . ' tidak ditemukan.');
            return redirect()->to('/pengguna-murid');
        }

        $data = [
            'title' => 'Detail Pengguna Murid',
            'murid' => $murid,
            'user' => $this->getUserDataForView()
        ];

        return view('pengguna_murid/view', $data);
    }

    public function toggleStatus($id)
    {
        // Pastikan user sudah login
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $murid = $this->muridModel->find($id);

        if (!$murid) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna murid tidak ditemukan');
        }

        $newStatus = $murid['is_active'] ? 0 : 1;
        
        try {
            if ($this->muridModel->update($id, ['is_active' => $newStatus])) {
                $message = $newStatus ? 'Pengguna murid berhasil diaktifkan!' : 'Pengguna murid berhasil dinonaktifkan!';
                return redirect()->to('/pengguna-murid')->with('success', $message);
            } else {
                return redirect()->to('/pengguna-murid')->with('error', 'Gagal mengubah status pengguna murid!');
            }
        } catch (\Exception $e) {
            return redirect()->to('/pengguna-murid')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function debugIndex()
    {
        // Bypass authentication for debugging
        echo "<h2>Debug Pengguna Murid</h2>";
        echo "Bypassing authentication for debugging...<br><br>";

        try {
            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId();
            echo "Active School Year ID: " . $activeSchoolYearId . "<br>";
            
            if (!$activeSchoolYearId) {
                echo "❌ No active school year found - this would cause redirect<br>";
                return;
            }

            // Check if new models are available
            if ($this->kelasMasterModel && $this->muridKelasModel) {
                echo "✅ Using new structure<br>";
                try {
                    $kelas = $this->kelasMasterModel->getKelasWithStatistik($activeSchoolYearId);
                    $stats = $this->muridKelasModel->getStatistikMurid($activeSchoolYearId);
                    echo "✅ New structure data retrieved successfully<br>";
                } catch (\Exception $e) {
                    echo "❌ Error with new structure: " . $e->getMessage() . "<br>";
                    throw $e;
                }
            } else {
                echo "⚠️ Using fallback structure<br>";
                $kelas = $this->kelasModel->getClassesForActiveYear();
                $stats = [
                    'total' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->countAllResults(),
                    'laki_laki' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'L')->countAllResults(),
                    'perempuan' => $this->muridModel->where('tahun_ajaran_id', $activeSchoolYearId)->where('is_active', 1)->where('jenis_kelamin', 'P')->countAllResults(),
                    'sudah_kelas' => 0,
                    'belum_kelas' => 0
                ];
                
                // Calculate sudah_kelas and belum_kelas using fallback method
                try {
                    // If we can use pivot table even in fallback
                    if ($this->muridKelasModel) {
                        $stats['sudah_kelas'] = $this->muridKelasModel
                            ->join('users', 'users.id = murid_kelas.murid_id')
                            ->join('roles', 'roles.id = users.role_id')
                            ->where('roles.role_name', 'Siswa')
                            ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                            ->where('murid_kelas.status', 'aktif')
                            ->where('users.is_active', 1)
                            ->countAllResults();
                    } else {
                        $stats['sudah_kelas'] = 0; // Complete fallback
                    }
                } catch (\Exception $e) {
                    $stats['sudah_kelas'] = 0; // Complete fallback
                }
                $stats['belum_kelas'] = $stats['total'] - $stats['sudah_kelas'];
                echo "✅ Fallback structure data retrieved successfully<br>";
            }

            $tahunAjaran = $this->tahunAjaranModel->findAll();

            $data = [
                'title' => 'Kelola Pengguna Murid (Debug)',
                'kelas' => $kelas,
                'tahun_ajaran' => $tahunAjaran,
                'stats' => $stats,
                'active_school_year_id' => $activeSchoolYearId
            ];

            echo "✅ All data prepared successfully. View should load without redirect.<br>";
            echo "<h3>Data Summary:</h3>";
            echo "Kelas count: " . count($kelas) . "<br>";
            echo "Tahun Ajaran count: " . count($tahunAjaran) . "<br>";
            echo "Stats: " . json_encode($stats) . "<br>";
            
            echo "<h3>Loading View...</h3>";
            return view('pengguna_murid/index', $data);

        } catch (\Exception $e) {
            echo "<h3>❌ Exception caught - this would cause redirect:</h3>";
            echo "Message: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Line: " . $e->getLine() . "<br>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }

    public function testGetData()
    {
        // Simple test method to bypass authentication and test getData logic
        echo "<h2>Test getData Method</h2>";
        
        try {
            // Mock request data
            $_GET['search'] = '';
            $_GET['kelas_id'] = '';
            $_GET['jenis_kelamin'] = '';
            $_GET['status'] = '';
            $_GET['page'] = 1;
            $_GET['limit'] = 10;
            
            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId();
            echo "Active School Year ID: " . $activeSchoolYearId . "<br>";
            
            if (!$activeSchoolYearId) {
                echo "❌ No active school year found<br>";
                return;
            }
            
            // Test fallback structure using users table instead
            echo "Testing fallback structure with users table...<br>";
            
            try {
                $userModel = new \App\Models\UserModel();
                $builder = $userModel->builder();
                
                // Get students from users table
                $builder->select('users.id, users.name as nama_lengkap, users.email, users.username as nis, 
                                 users.is_active, users.created_at, users.updated_at, 
                                 "" as nisn, "" as jenis_kelamin, "" as nama_kelas')
                        ->join('roles', 'roles.id = users.role_id')
                        ->where('roles.role_name', 'Siswa')
                        ->where('users.is_active', 1);
                
                $allData = $builder->get()->getResultArray();
                
                // Get class assignments from pivot table if available
                if ($this->muridKelasModel) {
                    foreach ($allData as &$row) {
                        $classAssignment = $this->muridKelasModel
                            ->select('kelas.nama_kelas, kelas.tingkat')
                            ->join('kelas', 'kelas.id = murid_kelas.kelas_id')
                            ->where('murid_kelas.murid_id', $row['id'])
                            ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                            ->where('murid_kelas.status', 'aktif')
                            ->first();
                        
                        if ($classAssignment) {
                            $row['nama_kelas'] = $classAssignment['nama_kelas'];
                        }
                    }
                }
                
                echo "Query executed successfully<br>";
                
            } catch (\Exception $e) {
                echo "Error in fallback query: " . $e->getMessage() . "<br>";
                $allData = [];
            }
            echo "Data retrieved: " . count($allData) . " records<br>";
            
            if (count($allData) > 0) {
                echo "<h3>Sample Data:</h3>";
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Nama</th><th>NIS</th><th>NISN</th><th>Kelas</th><th>JK</th></tr>";
                
                for ($i = 0; $i < min(5, count($allData)); $i++) {
                    $row = $allData[$i];
                    echo "<tr>";
                    echo "<td>" . ($row['id'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['nama_lengkap'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['nis'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['nisn'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['nama_kelas'] ?? 'No Class') . "</td>";
                    echo "<td>" . ($row['jenis_kelamin'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                // Test JSON response format
                $total = count($allData);
                $page = 1;
                $limit = 10;
                $data = array_slice($allData, 0, $limit);
                
                $response = [
                    'success' => true,
                    'data' => $data,
                    'total' => $total,
                    'page' => $page,
                    'limit' => $limit,
                    'pages' => ceil($total / $limit)
                ];
                
                echo "<h3>JSON Response Sample:</h3>";
                echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>";
                
            } else {
                echo "❌ No data found. This explains why the table is empty.<br>";
                
                // Check murid table directly
                $directCount = $this->muridModel->where('is_active', 1)->countAllResults();
                echo "Direct murid count (active): $directCount<br>";
                
                $allMuridCount = $this->muridModel->countAllResults();
                echo "Total murid count: $allMuridCount<br>";
                
                if ($allMuridCount == 0) {
                    echo "⚠️ No murid records in database. Need to create sample data.<br>";
                }
            }
            
        } catch (\Exception $e) {
            echo "❌ Error in test: " . $e->getMessage() . "<br>";
            echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
        }
    }

    public function debugBypass()
    {
        // Debug method without auth check
        header('Content-Type: application/json');
        
        try {
            echo json_encode([
                'success' => true,
                'message' => 'Controller accessible',
                'timestamp' => date('Y-m-d H:i:s'),
                'data' => [
                    'muridModel' => $this->muridModel ? 'OK' : 'NULL',
                    'kelasModel' => $this->kelasModel ? 'OK' : 'NULL',
                    'muridKelasModel' => $this->muridKelasModel ? 'OK' : 'NULL',
                    'kelasMasterModel' => $this->kelasMasterModel ? 'OK' : 'NULL'
                ]
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    // Debug getData method without auth check
    public function debugGetData()
    {
        header('Content-Type: application/json');
        
        try {
            // Get request parameters
            $draw = $this->request->getVar('draw') ?? 1;
            $start = intval($this->request->getVar('start') ?? 0);
            $length = intval($this->request->getVar('length') ?? 10);
            $search = $this->request->getVar('search')['value'] ?? '';
            $kelasFilter = $this->request->getVar('kelas_filter') ?? '';
            $statusFilter = $this->request->getVar('status_filter') ?? '';
            
            log_message('info', "Debug getData - start: $start, length: $length, search: $search");
            
            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getSetting('active_school_year_id');
            log_message('info', "Active school year ID: $activeSchoolYearId");
            
            // If no school year set, use current year as fallback
            if (!$activeSchoolYearId) {
                $currentYear = date('Y');
                $activeSchoolYearId = $currentYear;
                log_message('info', "Using fallback school year: $activeSchoolYearId");
            }
            
            // Get data using new structure first, fallback to old if needed
            $data = [];
            $total = 0;
            $filtered = 0;
            
            try {
                if ($this->muridKelasModel && $this->kelasMasterModel) {
                    // Use new structure
                    log_message('info', 'Using new database structure for getData');
                    $data = $this->getDataNewStructure($start, $length, $search, $kelasFilter, $statusFilter, $activeSchoolYearId);
                    $total = $this->getTotalMuridNewStructure($activeSchoolYearId);
                    $filtered = $this->getFilteredMuridNewStructure($search, $kelasFilter, $statusFilter, $activeSchoolYearId);
                } else {
                    // Use old structure  
                    log_message('info', 'Using old database structure for getData');
                    $data = $this->getDataOldStructure($start, $length, $search, $kelasFilter, $statusFilter, $activeSchoolYearId);
                    $total = $this->getTotalMuridOldStructure($activeSchoolYearId);
                    $filtered = $this->getFilteredMuridOldStructure($search, $kelasFilter, $statusFilter, $activeSchoolYearId);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error in getData: ' . $e->getMessage());
                // Return basic data if query fails
                $data = [];
                $total = 0;
                $filtered = 0;
            }
            
            // Format response
            $response = [
                'draw' => intval($draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $data,
                'debug' => [
                    'activeSchoolYearId' => $activeSchoolYearId,
                    'start' => $start,
                    'length' => $length,
                    'search' => $search,
                    'kelasFilter' => $kelasFilter,
                    'statusFilter' => $statusFilter,
                    'dataCount' => count($data),
                    'structure' => $this->muridKelasModel ? 'new' : 'old',
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ];
            
            log_message('info', 'Debug getData response: ' . json_encode($response));
            echo json_encode($response);
            
        } catch (\Exception $e) {
            log_message('error', 'Exception in debugGetData: ' . $e->getMessage());
            echo json_encode([
                'draw' => intval($draw ?? 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage(),
                'debug' => [
                    'exception' => true,
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]);
        }
        exit;
    }

    // Test index method without auth check
    public function testIndex()
    {
        // Simulate session for testing
        session()->set([
            'logged_in' => true,
            'user_id' => 1,
            'username' => 'superadmin',
            'role' => 'superadmin'
        ]);
        
        return $this->index();
    }

    // Test method without auth for debugging
    public function testIndexBypass()
    {
        // Force login session for testing
        session()->set([
            'isLoggedIn' => true,
            'logged_in' => true,
            'user_id' => 1,
            'username' => 'superadmin',
            'role' => 'superadmin'
        ]);
        
        return $this->index();
    }

    // Simple debug method that bypasses auth and shows basic info
    public function simpleDebug()
    {
        try {
            $data = [
                'title' => 'Debug Pengguna Murid - Simple',
                'kelas' => [],
                'tahun_ajaran' => [],
                'stats' => [
                    'total' => 0,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'sudah_kelas' => 0,
                    'belum_kelas' => 0
                ],
                'active_school_year_id' => 2025
            ];
            
            return view('pengguna_murid/simple_test', $data);
            
        } catch (\Exception $e) {
            echo "<h2>❌ Error in simpleDebug: " . $e->getMessage() . "</h2>";
            echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }

    // Test method with real data but simple view
    public function testWithData()
    {
        try {
            // Get active school year
            $activeSchoolYearId = $this->settingsModel->getActiveSchoolYearId();
            log_message('info', 'testWithData - Active school year ID: ' . $activeSchoolYearId);
            
            if (!$activeSchoolYearId) {
                $activeSchoolYearId = 2025; // Fallback
            }

            // Check if new models are available
            if ($this->kelasMasterModel && $this->muridKelasModel) {
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
            }

            // Ensure kelas data has required fields
            foreach ($kelas as &$k) {
                if (!isset($k['jumlah_murid'])) {
                    $k['jumlah_murid'] = 0;
                }
                if (!isset($k['kapasitas_maksimal'])) {
                    $k['kapasitas_maksimal'] = 35;
                }
                if (!isset($k['nama_kelas'])) {
                    $k['nama_kelas'] = $k['nama'] ?? 'Unknown';
                }
            }

            $tahunAjaran = $this->tahunAjaranModel->findAll();

            $data = [
                'title' => 'Test With Real Data',
                'kelas' => $kelas,
                'tahun_ajaran' => $tahunAjaran,
                'stats' => $stats,
                'active_school_year_id' => $activeSchoolYearId
            ];
            
            return view('pengguna_murid/simple_test', $data);
            
        } catch (\Exception $e) {
            echo "<h2>❌ Error in testWithData: " . $e->getMessage() . "</h2>";
            echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }

    // Helper function to check if user is logged in
    private function isLoggedIn()
    {
        return session()->get('isLoggedIn') || session()->get('logged_in');
    }

    public function testGetDataSimple()
    {
        // Simple test method to bypass authentication
        header('Content-Type: application/json');
        
        try {
            // Get active school year
            $activeSchoolYearId = 1; // Default fallback
            try {
                $activeSchoolYearId = $this->settingsModel->getSetting('active_school_year_id') ?? 1;
            } catch (\Exception $e) {
                // Use default if settings fail
            }
            
            // Simple query to get students
            $userModel = new \App\Models\UserModel();
            $builder = $userModel->builder();
            
            $builder->select('users.id, users.name as nama_lengkap, users.email, users.username as nis, 
                             users.is_active, users.created_at, users.updated_at, 
                             "" as nisn, "" as jenis_kelamin, "" as nama_kelas, "" as tingkat')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('roles.role_name', 'Siswa')
                    ->where('users.is_active', 1)
                    ->orderBy('users.name', 'ASC')
                    ->limit(10);
            
            $allData = $builder->get()->getResultArray();
            
            // Add required fields
            foreach ($allData as &$row) {
                $row['nama'] = $row['nama_lengkap'];
                $row['status_murid'] = $row['is_active'] ? 'aktif' : 'tidak_aktif';
                
                // Try to get class assignment
                if ($this->muridKelasModel) {
                    try {
                        $classAssignment = $this->muridKelasModel
                            ->select('kelas.nama_kelas, kelas.tingkat')
                            ->join('kelas', 'kelas.id = murid_kelas.kelas_id')
                            ->where('murid_kelas.murid_id', $row['id'])
                            ->where('murid_kelas.tahun_ajaran_id', $activeSchoolYearId)
                            ->where('murid_kelas.status', 'aktif')
                            ->first();
                        
                        if ($classAssignment) {
                            $row['nama_kelas'] = $classAssignment['nama_kelas'];
                            $row['tingkat'] = $classAssignment['tingkat'];
                        }
                    } catch (\Exception $e) {
                        // Skip class assignment if error
                    }
                }
            }
            
            $response = [
                'draw' => 1,
                'recordsTotal' => count($allData),
                'recordsFiltered' => count($allData),
                'data' => $allData,
                'debug' => [
                    'activeSchoolYearId' => $activeSchoolYearId,
                    'total' => count($allData),
                    'dataCount' => count($allData),
                    'structure' => 'test_simple'
                ]
            ];
            
            echo json_encode($response);
            exit;
            
        } catch (\Exception $e) {
            echo json_encode([
                'draw' => 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Test error: ' . $e->getMessage(),
                'debug' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_trace' => $e->getTraceAsString()
                ]
            ]);
            exit;
        }
    }

    // Menampilkan data orang tua murid
    public function orangTua($muridId)
    {
        // TODO: Implementasi detail data orang tua murid
        return view('pengguna_murid/orang_tua', [
            'murid_id' => $muridId,
            'title' => 'Data Orang Tua Murid',
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }

    public function importExcel()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'excel_file' => [
                'rules' => 'uploaded[excel_file]|ext_in[excel_file,xlsx,xls]|max_size[excel_file,2048]',
                'errors' => [
                    'uploaded' => 'File Excel harus diunggah',
                    'ext_in' => 'File harus berformat Excel (.xlsx atau .xls)',
                    'max_size' => 'Ukuran file maksimal 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('excel_file');
        
        if (!$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid']);
        }

        try {
            // Load PHPSpreadsheet
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            // Skip header row
            array_shift($data);

            $imported = 0;
            $errors = [];
            $db = \Config\Database::connect();

            foreach ($data as $index => $row) {
                $rowNumber = $index + 2; // +2 karena index dimulai dari 0 dan kita skip header
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validasi data per baris
                $nisn = trim($row[0] ?? '');
                $nis = trim($row[1] ?? '');
                $username = trim($row[2] ?? '');
                $email = trim($row[3] ?? '');
                $password = trim($row[4] ?? '');
                $nama_lengkap = trim($row[5] ?? '');
                $jenis_kelamin = trim($row[6] ?? '');
                $tempat_lahir = trim($row[7] ?? '');
                $tanggal_lahir = trim($row[8] ?? '');
                $alamat = trim($row[9] ?? '');
                $nomor_telepon = trim($row[10] ?? '');
                $nama_ayah = trim($row[11] ?? '');
                $nama_ibu = trim($row[12] ?? '');

                // Validasi field required
                if (empty($nisn) || empty($username) || empty($password) || empty($nama_lengkap)) {
                    $errors[] = "Baris {$rowNumber}: Data tidak lengkap (NISN, username, password, dan nama lengkap harus diisi)";
                    continue;
                }

                // Validasi email format jika diisi
                if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Baris {$rowNumber}: Format email tidak valid";
                    continue;
                }

                // Validasi jenis kelamin
                if (!empty($jenis_kelamin) && !in_array($jenis_kelamin, ['L', 'P'])) {
                    $errors[] = "Baris {$rowNumber}: Jenis kelamin harus L atau P";
                    continue;
                }

                // Validasi format tanggal lahir
                if (!empty($tanggal_lahir)) {
                    $dateTime = \DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
                    if (!$dateTime || $dateTime->format('Y-m-d') !== $tanggal_lahir) {
                        $errors[] = "Baris {$rowNumber}: Format tanggal lahir harus YYYY-MM-DD (contoh: 2010-01-15)";
                        continue;
                    }
                }

                // Cek NISN dan username unik
                $existingNisn = $this->muridModel->where('nisn', $nisn)->first();
                if ($existingNisn) {
                    $errors[] = "Baris {$rowNumber}: NISN '{$nisn}' sudah digunakan";
                    continue;
                }

                $existingUsername = $this->muridModel->where('username', $username)->first();
                if ($existingUsername) {
                    $errors[] = "Baris {$rowNumber}: Username '{$username}' sudah digunakan";
                    continue;
                }

                // Cek email unik jika diisi
                if (!empty($email)) {
                    $existingEmail = $this->muridModel->where('email', $email)->first();
                    if ($existingEmail) {
                        $errors[] = "Baris {$rowNumber}: Email '{$email}' sudah digunakan";
                        continue;
                    }
                }

                // Siapkan data untuk insert
                $insertData = [
                    'nisn' => $nisn,
                    'nis' => !empty($nis) ? $nis : null,
                    'username' => $username,
                    'email' => !empty($email) ? $email : null,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'nama_lengkap' => $nama_lengkap,
                    'jenis_kelamin' => !empty($jenis_kelamin) ? $jenis_kelamin : null,
                    'tempat_lahir' => !empty($tempat_lahir) ? $tempat_lahir : null,
                    'tanggal_lahir' => !empty($tanggal_lahir) ? $tanggal_lahir : null,
                    'alamat' => !empty($alamat) ? $alamat : null,
                    'nomor_telepon' => !empty($nomor_telepon) ? $nomor_telepon : null,
                    'nama_ayah' => !empty($nama_ayah) ? $nama_ayah : null,
                    'nama_ibu' => !empty($nama_ibu) ? $nama_ibu : null,
                    'role_id' => 4, // Role Siswa
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Insert data
                if ($this->muridModel->save($insertData)) {
                    $imported++;
                } else {
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data";
                }
            }

            $message = "Import selesai. {$imported} data murid berhasil diimport.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " data gagal diimport.";
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'imported' => $imported,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadTemplate()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $headers = [
                'A1' => 'NISN',
                'B1' => 'NIS',
                'C1' => 'Username',
                'D1' => 'Email',
                'E1' => 'Password',
                'F1' => 'Nama Lengkap',
                'G1' => 'Jenis Kelamin (L/P)',
                'H1' => 'Tempat Lahir',
                'I1' => 'Tanggal Lahir (YYYY-MM-DD)',
                'J1' => 'Alamat',
                'K1' => 'Nomor Telepon',
                'L1' => 'Nama Ayah',
                'M1' => 'Nama Ibu'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $sheet->getStyle($cell)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E2E8F0');
            }

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(15); // NISN
            $sheet->getColumnDimension('B')->setWidth(12); // NIS
            $sheet->getColumnDimension('C')->setWidth(15); // Username
            $sheet->getColumnDimension('D')->setWidth(25); // Email
            $sheet->getColumnDimension('E')->setWidth(12); // Password
            $sheet->getColumnDimension('F')->setWidth(25); // Nama Lengkap
            $sheet->getColumnDimension('G')->setWidth(15); // Jenis Kelamin
            $sheet->getColumnDimension('H')->setWidth(15); // Tempat Lahir
            $sheet->getColumnDimension('I')->setWidth(20); // Tanggal Lahir
            $sheet->getColumnDimension('J')->setWidth(30); // Alamat
            $sheet->getColumnDimension('K')->setWidth(15); // Nomor Telepon
            $sheet->getColumnDimension('L')->setWidth(20); // Nama Ayah
            $sheet->getColumnDimension('M')->setWidth(20); // Nama Ibu

            // Add sample data
            $sampleData = [
                ['1234567890', '2024001', 'ahmad_rizki', 'ahmad@example.com', 'password123', 'Ahmad Rizki Pratama', 'L', 'Jakarta', '2010-01-15', 'Jl. Merdeka No. 123', '081234567890', 'Budi Pratama', 'Siti Nurhaliza'],
                ['1234567891', '2024002', 'sari_indah', 'sari@example.com', 'password123', 'Sari Indah Permata', 'P', 'Bandung', '2010-03-22', 'Jl. Sudirman No. 456', '081234567891', 'Andi Permata', 'Dewi Sartika']
            ];

            $row = 2;
            foreach ($sampleData as $data) {
                $col = 'A';
                foreach ($data as $value) {
                    $sheet->setCellValue($col . $row, $value);
                    $col++;
                }
                $row++;
            }

            // Add notes sheet
            $notesSheet = $spreadsheet->createSheet();
            $notesSheet->setTitle('Catatan Penting');
            $notesSheet->setCellValue('A1', 'CATATAN PENTING:');
            $notesSheet->getStyle('A1')->getFont()->setBold(true);
            
            $notes = [
                'A3' => '• Kolom yang wajib diisi: NISN, Username, Password, Nama Lengkap',
                'A4' => '• NISN dan Username harus unik (tidak boleh sama)',
                'A5' => '• Jenis Kelamin: L untuk Laki-laki, P untuk Perempuan',
                'A6' => '• Format Tanggal Lahir: YYYY-MM-DD (contoh: 2010-01-15)',
                'A7' => '• Email harus format yang valid jika diisi',
                'A8' => '• File maksimal 2MB dengan format .xlsx atau .xls',
                'A9' => '• Hapus baris contoh sebelum import data asli'
            ];
            
            foreach ($notes as $cell => $value) {
                $notesSheet->setCellValue($cell, $value);
                $notesSheet->getColumnDimension('A')->setWidth(60);
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            $filename = 'template_import_murid.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating template: ' . $e->getMessage());
        }
    }
}
