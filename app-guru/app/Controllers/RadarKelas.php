<?php

namespace App\Controllers;

class RadarKelas extends BaseController
{
    protected $session;
    protected $db;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }
    
    // ============= GURU MATA PELAJARAN =============
    
    /**
     * Dashboard Radar Kelas untuk Guru Mapel
     */
    public function index()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $data = [
            'title' => 'Radar Kelas - Smart BookKeeping',
            'user_name' => $this->session->get('full_name'),
            'role' => 'guru_mapel'
        ];
        
        return view('guru/radar_kelas/index', $data);
    }
    
    /**
     * Form Lapor Cepat & Senyap
     */
    public function laporCepat($siswa_id = null)
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        // Ambil data siswa jika ada ID
        $siswa = null;
        if ($siswa_id) {
            $query = $this->db->query("SELECT * FROM users WHERE id = ? AND role_id = 3 AND is_active = 1", [$siswa_id]);
            $siswa = $query->getRow();
        }
        
        // Ambil daftar siswa untuk dropdown
        $siswaQuery = $this->db->query("SELECT id, full_name, username FROM users WHERE role_id = 3 AND is_active = 1 ORDER BY full_name");
        $daftarSiswa = $siswaQuery->getResult();
        
        $data = [
            'title' => 'Lapor Cepat & Senyap - Radar Kelas',
            'siswa' => $siswa,
            'daftarSiswa' => $daftarSiswa,
            'validation' => \Config\Services::validation()
        ];
        
        return view('guru/radar_kelas/lapor_cepat', $data);
    }
    
    /**
     * Proses simpan laporan cepat
     */
    public function simpanLaporan()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $rules = [
            'siswa_id' => 'required|numeric',
            'kategori' => 'required|in_list[Akademik,Sosial,Perilaku]',
            'deskripsi' => 'required|min_length[10]|max_length[500]',
            'tingkat_prioritas' => 'required|in_list[Rendah,Sedang,Tinggi]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $guru_id = $this->session->get('user_id');
        $siswa_id = $this->request->getPost('siswa_id');
        $kategori = $this->request->getPost('kategori');
        $deskripsi = $this->request->getPost('deskripsi');
        $tingkat_prioritas = $this->request->getPost('tingkat_prioritas');
        
        try {
            // Simpan laporan ke database
            $data_laporan = [
                'guru_id' => $guru_id,
                'siswa_id' => $siswa_id,
                'kategori' => $kategori,
                'deskripsi' => $deskripsi,
                'tingkat_prioritas' => $tingkat_prioritas,
                'status' => 'Baru',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->table('radar_laporan')->insert($data_laporan);
            
            // Ambil nama siswa untuk notifikasi
            $siswaQuery = $this->db->query("SELECT full_name FROM users WHERE id = ?", [$siswa_id]);
            $siswa = $siswaQuery->getRow();
            
            return redirect()->to(base_url('/radar-kelas'))->with('success', 
                'Laporan berhasil dikirim untuk siswa ' . $siswa->full_name . '. Wali Kelas dan Guru BK akan menerima notifikasi.');
            
        } catch (Exception $e) {
            log_message('error', 'Error saving laporan: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan laporan.');
        }
    }
    
    /**
     * Riwayat Sinyal Pribadi untuk Guru Mapel
     */
    public function riwayatSinyal()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $guru_id = $this->session->get('user_id');
        
        // Ambil riwayat laporan guru
        $query = $this->db->query("
            SELECT rl.*, u.full_name as nama_siswa, u.username 
            FROM radar_laporan rl 
            JOIN users u ON rl.siswa_id = u.id 
            WHERE rl.guru_id = ? 
            ORDER BY rl.created_at DESC
        ", [$guru_id]);
        
        $riwayat = $query->getResult();
        
        $data = [
            'title' => 'Riwayat Sinyal Pribadi - Radar Kelas',
            'riwayat' => $riwayat
        ];
        
        return view('guru/radar_kelas/riwayat_sinyal', $data);
    }
    
    // ============= WALI KELAS =============
    
    /**
     * Dashboard Pendampingan Kelas untuk Wali Kelas
     */
    public function dashboardWali()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $wali_id = $this->session->get('user_id');
        
        // Ambil siswa di kelas yang diampu wali kelas
        $siswaQuery = $this->db->query("
            SELECT u.id, u.full_name, u.username,
                   COUNT(rl.id) as total_laporan,
                   MAX(rl.created_at) as laporan_terakhir,
                   CASE 
                       WHEN COUNT(rl.id) = 0 THEN 'Normal'
                       WHEN COUNT(rl.id) <= 2 THEN 'Perhatian'
                       ELSE 'Prioritas'
                   END as status_radar
            FROM users u
            LEFT JOIN radar_laporan rl ON u.id = rl.siswa_id AND rl.status IN ('Baru', 'Dalam Proses')
            WHERE u.role_id = 3 AND u.is_active = 1
            GROUP BY u.id, u.full_name, u.username
            ORDER BY total_laporan DESC, u.full_name
        ");
        
        $daftarSiswa = $siswaQuery->getResult();
        
        $data = [
            'title' => 'Dashboard Pendampingan Kelas - Wali Kelas',
            'daftarSiswa' => $daftarSiswa,
            'role' => 'wali_kelas'
        ];
        
        return view('guru/radar_kelas/dashboard_wali', $data);
    }
    
    /**
     * Agregator Sinyal Kelas - Detail laporan untuk satu siswa
     */
    public function detailSiswa($siswa_id)
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        // Ambil data siswa
        $siswaQuery = $this->db->query("SELECT * FROM users WHERE id = ? AND role_id = 3", [$siswa_id]);
        $siswa = $siswaQuery->getRow();
        
        if (!$siswa) {
            return redirect()->to(base_url('/radar-kelas/dashboard-wali'))->with('error', 'Data siswa tidak ditemukan.');
        }
        
        // Ambil semua laporan untuk siswa ini
        $laporanQuery = $this->db->query("
            SELECT rl.*, u.full_name as nama_guru
            FROM radar_laporan rl 
            JOIN users u ON rl.guru_id = u.id 
            WHERE rl.siswa_id = ? 
            ORDER BY rl.created_at DESC
        ", [$siswa_id]);
        
        $daftarLaporan = $laporanQuery->getResult();
        
        $data = [
            'title' => 'Detail Siswa - ' . $siswa->full_name,
            'siswa' => $siswa,
            'daftarLaporan' => $daftarLaporan
        ];
        
        return view('guru/radar_kelas/detail_siswa', $data);
    }
    
    /**
     * Manajemen & Eskalasi Kasus
     */
    public function manajemenKasus($laporan_id)
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        // Ambil data laporan
        $laporanQuery = $this->db->query("
            SELECT rl.*, u.full_name as nama_siswa, g.full_name as nama_guru
            FROM radar_laporan rl 
            JOIN users u ON rl.siswa_id = u.id 
            JOIN users g ON rl.guru_id = g.id 
            WHERE rl.id = ?
        ", [$laporan_id]);
        
        $laporan = $laporanQuery->getRow();
        
        if (!$laporan) {
            return redirect()->back()->with('error', 'Data laporan tidak ditemukan.');
        }
        
        $data = [
            'title' => 'Manajemen Kasus - ' . $laporan->nama_siswa,
            'laporan' => $laporan,
            'validation' => \Config\Services::validation()
        ];
        
        return view('guru/radar_kelas/manajemen_kasus', $data);
    }
    
    /**
     * Proses tindakan wali kelas
     */
    public function prosesTindakan()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $rules = [
            'laporan_id' => 'required|numeric',
            'tindakan' => 'required|in_list[Pantau,Tindak Lanjut Pribadi,Eskalasi ke BK]',
            'catatan_wali' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $laporan_id = $this->request->getPost('laporan_id');
        $tindakan = $this->request->getPost('tindakan');
        $catatan_wali = $this->request->getPost('catatan_wali');
        $wali_id = $this->session->get('user_id');
        
        try {
            // Update status laporan
            $status_baru = ($tindakan == 'Eskalasi ke BK') ? 'Eskalasi BK' : 'Dalam Proses';
            
            $this->db->query("
                UPDATE radar_laporan SET 
                status = ?, 
                tindakan_wali = ?, 
                catatan_wali = ?, 
                wali_id = ?,
                updated_at = NOW()
                WHERE id = ?
            ", [$status_baru, $tindakan, $catatan_wali, $wali_id, $laporan_id]);
            
            return redirect()->to(base_url('/radar-kelas/dashboard-wali'))->with('success', 
                'Tindakan berhasil disimpan. Status kasus: ' . $status_baru);
            
        } catch (Exception $e) {
            log_message('error', 'Error processing tindakan: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan tindakan.');
        }
    }
}
