<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AsesmenBakatMinat extends BaseController
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    // Helper method untuk cek authorization Guru BK
    private function checkBKAuthorization()
    {
        if (!$this->session->get('guru_logged_in')) {
            return redirect()->to(base_url('/login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($this->session->get('user_role') !== 'guru_bk') {
            return redirect()->to(base_url('/dashboard'))->with('error', 'Akses ditolak. Fitur asesmen bakat minat khusus untuk Guru BK.');
        }

        return null; // No redirect needed
    }

    // Dashboard utama asesmen bakat minat
    public function index()
    {
        $authCheck = $this->checkBKAuthorization();
        if ($authCheck) return $authCheck;

        // Ambil statistik asesmen
        $stats = $this->getAsesmenStats();

        $data = [
            'title' => 'Dashboard Asesmen Bakat Minat - Smart BK',
            'user_name' => $this->session->get('full_name'),
            'user_role' => $this->session->get('user_role'),
            'stats' => $stats
        ];

        return view('layouts/dashboard_sidebar_layout', $data, ['content' => view('asesmen/dashboard', $data)]);
    }

    // Halaman tes bakat minat online
    public function tesOnline()
    {
        $authCheck = $this->checkBKAuthorization();
        if ($authCheck) return $authCheck;

        $data = [
            'title' => 'Tes Bakat Minat Online - Smart BK',
            'user_name' => $this->session->get('full_name'),
            'user_role' => $this->session->get('user_role')
        ];

        return view('layouts/dashboard_sidebar_layout', $data, ['content' => view('asesmen/tes_online', $data)]);
    }

    // Halaman hasil tes siswa
    public function hasilTes()
    {
        $authCheck = $this->checkBKAuthorization();
        if ($authCheck) return $authCheck;

        // Ambil hasil tes dari database
        $hasilTes = $this->getHasilTes();

        $data = [
            'title' => 'Hasil Tes Bakat Minat - Smart BK',
            'user_name' => $this->session->get('full_name'),
            'user_role' => $this->session->get('user_role'),
            'hasil_tes' => $hasilTes
        ];

        return view('layouts/dashboard_sidebar_layout', $data, ['content' => view('asesmen/hasil_tes', $data)]);
    }

    // Halaman analisis bakat minat
    public function analisis()
    {
        $authCheck = $this->checkBKAuthorization();
        if ($authCheck) return $authCheck;

        // Ambil data analisis
        $analisisData = $this->getAnalisisData();

        $data = [
            'title' => 'Analisis Bakat Minat - Smart BK',
            'user_name' => $this->session->get('full_name'),
            'user_role' => $this->session->get('user_role'),
            'analisis' => $analisisData
        ];

        return view('layouts/dashboard_sidebar_layout', $data, ['content' => view('asesmen/analisis', $data)]);
    }

    // Halaman rekomendasi jurusan
    public function rekomendasi()
    {
        $authCheck = $this->checkBKAuthorization();
        if ($authCheck) return $authCheck;

        $data = [
            'title' => 'Rekomendasi Jurusan - Smart BK',
            'user_name' => $this->session->get('full_name'),
            'user_role' => $this->session->get('user_role')
        ];

        return view('layouts/dashboard_sidebar_layout', $data, ['content' => view('asesmen/rekomendasi', $data)]);
    }

    // Halaman laporan asesmen
    public function laporan()
    {
        $authCheck = $this->checkBKAuthorization();
        if ($authCheck) return $authCheck;

        $data = [
            'title' => 'Laporan Asesmen - Smart BK',
            'user_name' => $this->session->get('full_name'),
            'user_role' => $this->session->get('user_role')
        ];

        return view('layouts/dashboard_sidebar_layout', $data, ['content' => view('asesmen/laporan', $data)]);
    }

    // Method untuk mendapatkan statistik asesmen
    private function getAsesmenStats()
    {
        try {
            // Total siswa yang sudah mengikuti tes
            $totalSiswaTes = $this->db->query("SELECT COUNT(DISTINCT siswa_id) as total FROM asesmen_bakat_minat")->getRow()->total ?? 0;
            
            // Total tes yang tersedia
            $totalTes = $this->db->query("SELECT COUNT(*) as total FROM jenis_asesmen WHERE is_active = 1")->getRow()->total ?? 0;
            
            // Hasil tes bulan ini
            $hasilBulanIni = $this->db->query("SELECT COUNT(*) as total FROM asesmen_bakat_minat WHERE MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())")->getRow()->total ?? 0;
            
            // Siswa yang perlu rekomendasi
            $perluRekomendasi = $this->db->query("SELECT COUNT(DISTINCT siswa_id) as total FROM asesmen_bakat_minat WHERE rekomendasi_jurusan IS NULL")->getRow()->total ?? 0;

            return [
                'total_siswa_tes' => $totalSiswaTes,
                'total_tes' => $totalTes,
                'hasil_bulan_ini' => $hasilBulanIni,
                'perlu_rekomendasi' => $perluRekomendasi
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error getting asesmen stats: ' . $e->getMessage());
            return [
                'total_siswa_tes' => 0,
                'total_tes' => 0,
                'hasil_bulan_ini' => 0,
                'perlu_rekomendasi' => 0
            ];
        }
    }

    // Method untuk mendapatkan hasil tes
    private function getHasilTes()
    {
        try {
            $query = $this->db->query("
                SELECT 
                    abm.*,
                    s.nama as nama_siswa,
                    s.nis,
                    k.nama as nama_kelas,
                    ja.nama_asesmen,
                    ja.deskripsi
                FROM asesmen_bakat_minat abm
                JOIN siswa s ON abm.siswa_id = s.id
                JOIN kelas k ON s.kelas_id = k.id
                JOIN jenis_asesmen ja ON abm.jenis_asesmen_id = ja.id
                ORDER BY abm.created_at DESC
                LIMIT 50
            ");
            
            return $query->getResult();
        } catch (\Exception $e) {
            log_message('error', 'Error getting hasil tes: ' . $e->getMessage());
            return [];
        }
    }

    // Method untuk mendapatkan data analisis
    private function getAnalisisData()
    {
        try {
            // Analisis berdasarkan kategori bakat
            $bakatQuery = $this->db->query("
                SELECT 
                    kategori_bakat,
                    COUNT(*) as jumlah,
                    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM asesmen_bakat_minat)), 2) as persentase
                FROM asesmen_bakat_minat 
                WHERE kategori_bakat IS NOT NULL
                GROUP BY kategori_bakat
                ORDER BY jumlah DESC
            ");

            // Analisis berdasarkan minat
            $minatQuery = $this->db->query("
                SELECT 
                    kategori_minat,
                    COUNT(*) as jumlah,
                    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM asesmen_bakat_minat)), 2) as persentase
                FROM asesmen_bakat_minat 
                WHERE kategori_minat IS NOT NULL
                GROUP BY kategori_minat
                ORDER BY jumlah DESC
            ");

            return [
                'bakat' => $bakatQuery->getResult(),
                'minat' => $minatQuery->getResult()
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error getting analisis data: ' . $e->getMessage());
            return [
                'bakat' => [],
                'minat' => []
            ];
        }
    }
}
