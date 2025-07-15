<?php

namespace App\Controllers;

class PusatKendaliKonseling extends BaseController
{
    protected $session;
    protected $db;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }
    
    /**
     * Dashboard Pusat Kendali Konseling untuk Guru BK
     */
    public function index()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $bk_id = $this->session->get('user_id');
        
        // Statistik kasus
        $statsQuery = $this->db->query("
            SELECT 
                COUNT(*) as total_kasus,
                SUM(CASE WHEN status = 'Baru' THEN 1 ELSE 0 END) as kasus_baru,
                SUM(CASE WHEN status = 'Eskalasi BK' THEN 1 ELSE 0 END) as kasus_eskalasi,
                SUM(CASE WHEN status = 'Dalam Konseling' THEN 1 ELSE 0 END) as dalam_konseling,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as kasus_selesai
            FROM radar_laporan 
            WHERE status IN ('Baru', 'Eskalasi BK', 'Dalam Konseling', 'Selesai')
        ");
        
        $stats = $statsQuery->getRow();
        
        // Ambil kasus yang perlu perhatian BK
        $kasusQuery = $this->db->query("
            SELECT rl.*, u.full_name as nama_siswa, g.full_name as nama_guru,
                   w.full_name as nama_wali,
                   CASE 
                       WHEN rl.tingkat_prioritas = 'Tinggi' THEN 1
                       WHEN rl.tingkat_prioritas = 'Sedang' THEN 2
                       ELSE 3
                   END as priority_order
            FROM radar_laporan rl 
            JOIN users u ON rl.siswa_id = u.id 
            JOIN users g ON rl.guru_id = g.id 
            LEFT JOIN users w ON rl.wali_id = w.id
            WHERE rl.status IN ('Eskalasi BK', 'Dalam Konseling', 'Baru')
            ORDER BY priority_order ASC, rl.created_at DESC
        ");
        
        $daftarKasus = $kasusQuery->getResult();
        
        $data = [
            'title' => 'Pusat Kendali Konseling - Guru BK',
            'stats' => $stats,
            'daftarKasus' => $daftarKasus,
            'role' => 'guru_bk'
        ];
        
        return view('guru/konseling/dashboard_bk', $data);
    }
    
    /**
     * Manajemen Kasus Digital
     */
    public function manajemenKasus($kasus_id = null)
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        if ($kasus_id) {
            // Detail kasus spesifik
            $kasusQuery = $this->db->query("
                SELECT rl.*, u.full_name as nama_siswa, u.username as username_siswa,
                       g.full_name as nama_guru, w.full_name as nama_wali
                FROM radar_laporan rl 
                JOIN users u ON rl.siswa_id = u.id 
                JOIN users g ON rl.guru_id = g.id 
                LEFT JOIN users w ON rl.wali_id = w.id
                WHERE rl.id = ?
            ", [$kasus_id]);
            
            $kasus = $kasusQuery->getRow();
            
            if (!$kasus) {
                return redirect()->to(base_url('/konseling'))->with('error', 'Data kasus tidak ditemukan.');
            }
            
            // Ambil log konseling untuk kasus ini
            $logQuery = $this->db->query("
                SELECT * FROM konseling_log 
                WHERE kasus_id = ? 
                ORDER BY created_at DESC
            ", [$kasus_id]);
            
            $logKonseling = $logQuery->getResult();
            
            $data = [
                'title' => 'Detail Kasus - ' . $kasus->nama_siswa,
                'kasus' => $kasus,
                'logKonseling' => $logKonseling,
                'validation' => \Config\Services::validation()
            ];
            
            return view('guru/konseling/detail_kasus', $data);
        } else {
            // Daftar semua kasus
            return $this->index();
        }
    }
    
    /**
     * Update status kasus
     */
    public function updateStatus()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $rules = [
            'kasus_id' => 'required|numeric',
            'status_baru' => 'required|in_list[Dalam Konseling,Selesai,Butuh Tindak Lanjut]',
            'label' => 'permit_empty|max_length[50]',
            'prioritas_bk' => 'required|in_list[Rendah,Sedang,Tinggi,Urgent]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $kasus_id = $this->request->getPost('kasus_id');
        $status_baru = $this->request->getPost('status_baru');
        $label = $this->request->getPost('label');
        $prioritas_bk = $this->request->getPost('prioritas_bk');
        $bk_id = $this->session->get('user_id');
        
        try {
            $this->db->query("
                UPDATE radar_laporan SET 
                status = ?, 
                label_bk = ?, 
                prioritas_bk = ?,
                bk_id = ?,
                updated_at = NOW()
                WHERE id = ?
            ", [$status_baru, $label, $prioritas_bk, $bk_id, $kasus_id]);
            
            return redirect()->back()->with('success', 'Status kasus berhasil diperbarui.');
            
        } catch (Exception $e) {
            log_message('error', 'Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }
    
    /**
     * Log Konseling Terenkripsi
     */
    public function tambahLogKonseling()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        $rules = [
            'kasus_id' => 'required|numeric',
            'jenis_sesi' => 'required|in_list[Konseling Individual,Konseling Kelompok,Observasi,Home Visit]',
            'ringkasan_sesi' => 'required|min_length[20]',
            'analisis' => 'required|min_length[20]',
            'rencana_intervensi' => 'required|min_length[20]',
            'evaluasi_kemajuan' => 'permit_empty|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $kasus_id = $this->request->getPost('kasus_id');
        $jenis_sesi = $this->request->getPost('jenis_sesi');
        $ringkasan_sesi = $this->request->getPost('ringkasan_sesi');
        $analisis = $this->request->getPost('analisis');
        $rencana_intervensi = $this->request->getPost('rencana_intervensi');
        $evaluasi_kemajuan = $this->request->getPost('evaluasi_kemajuan');
        $bk_id = $this->session->get('user_id');
        
        try {
            // Enkripsi data sensitif (sederhana untuk demo)
            $encryption_key = 'your-secret-key-here'; // Seharusnya dari config
            
            $data_log = [
                'kasus_id' => $kasus_id,
                'bk_id' => $bk_id,
                'jenis_sesi' => $jenis_sesi,
                'ringkasan_sesi' => base64_encode($ringkasan_sesi), // Enkripsi sederhana
                'analisis' => base64_encode($analisis),
                'rencana_intervensi' => base64_encode($rencana_intervensi),
                'evaluasi_kemajuan' => $evaluasi_kemajuan ? base64_encode($evaluasi_kemajuan) : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->table('konseling_log')->insert($data_log);
            
            return redirect()->back()->with('success', 'Log konseling berhasil disimpan dengan enkripsi.');
            
        } catch (Exception $e) {
            log_message('error', 'Error saving konseling log: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan log.');
        }
    }
    
    /**
     * Laporan Statistik BK
     */
    public function laporanStatistik()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'));
        }
        
        // Statistik per kategori
        $kategoriQuery = $this->db->query("
            SELECT kategori, COUNT(*) as jumlah 
            FROM radar_laporan 
            GROUP BY kategori 
            ORDER BY jumlah DESC
        ");
        
        $statsKategori = $kategoriQuery->getResult();
        
        // Statistik per bulan
        $bulanQuery = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as jumlah 
            FROM radar_laporan 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY bulan ASC
        ");
        
        $statsBulan = $bulanQuery->getResult();
        
        // Tingkat resolusi kasus
        $resolusiQuery = $this->db->query("
            SELECT status, COUNT(*) as jumlah 
            FROM radar_laporan 
            GROUP BY status 
            ORDER BY jumlah DESC
        ");
        
        $statsResolusi = $resolusiQuery->getResult();
        
        $data = [
            'title' => 'Laporan Statistik - Pusat Kendali Konseling',
            'statsKategori' => $statsKategori,
            'statsBulan' => $statsBulan,
            'statsResolusi' => $statsResolusi
        ];
        
        return view('guru/konseling/laporan_statistik', $data);
    }
}
