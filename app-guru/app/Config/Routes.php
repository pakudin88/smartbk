<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route utama - redirect ke login atau dashboard
$routes->get('/', 'GuruAuth::index');

// Auth routes
$routes->get('/login', 'GuruAuth::login');
$routes->post('/authenticate', 'GuruAuth::authenticate');
$routes->get('/logout', 'GuruAuth::logout');

// ============= DASHBOARD ROUTES =============
// Main dashboard 
$routes->get('/dashboard', 'GuruAuth::dashboard');

// Role-specific dashboard routes
$routes->group('dashboard', function($routes) {
    $routes->get('guru-bk', 'RoleDashboard::dashboardGuruBK');
    $routes->get('guru-kelas', 'RoleDashboard::dashboardGuruKelas');
    $routes->get('wali-kelas', 'RoleDashboard::dashboardWaliKelas');
    $routes->get('kepala-sekolah', 'RoleDashboard::dashboardKepalaSekolah');
});

// Profile and settings
$routes->get('/profile', 'GuruAuth::profile');
$routes->get('/settings', 'GuruAuth::settings');

// ============= GURU BK SPECIFIC ROUTES =============
$routes->group('konseling', ['filter' => 'role:guru_bk'], function($routes) {
    $routes->get('/', 'PusatKendaliKonseling::index');
    $routes->get('individual', 'PusatKendaliKonseling::individual');
    $routes->get('kelompok', 'PusatKendaliKonseling::kelompok');
    $routes->get('manajemen-kasus', 'PusatKendaliKonseling::manajemenKasus');
    $routes->get('manajemen-kasus/(:num)', 'PusatKendaliKonseling::manajemenKasus/$1');
    $routes->post('update-status', 'PusatKendaliKonseling::updateStatus');
    $routes->post('tambah-log-konseling', 'PusatKendaliKonseling::tambahLogKonseling');
    $routes->get('laporan-statistik', 'PusatKendaliKonseling::laporanStatistik');
});

$routes->group('asesmen', ['filter' => 'role:guru_bk'], function($routes) {
    $routes->get('/', 'AsesmenBakatMinat::index');
    $routes->get('siswa', 'AsesmenBakatMinat::asesmen');
    $routes->get('psikologi', 'AsesmenBakatMinat::tesOnline');
    $routes->get('hasil-tes', 'AsesmenBakatMinat::hasilTes');
    $routes->get('cepat', 'AsesmenBakatMinat::asesmenCepat');
});

// ============= GURU KELAS SPECIFIC ROUTES =============
$routes->group('pembelajaran', ['filter' => 'role:guru_kelas'], function($routes) {
    $routes->get('/', 'GuruKelas::pembelajaran');
    $routes->get('jadwal', 'GuruKelas::jadwal');
    $routes->get('materi', 'GuruKelas::materi');
    $routes->get('rpp', 'GuruKelas::rpp');
});

$routes->group('penilaian', ['filter' => 'role:guru_kelas'], function($routes) {
    $routes->get('/', 'GuruKelas::penilaian');
    $routes->get('input', 'GuruKelas::inputNilai');
    $routes->get('rekap', 'GuruKelas::rekapNilai');
    $routes->get('analisis', 'GuruKelas::analisisNilai');
});

$routes->group('tugas', ['filter' => 'role:guru_kelas'], function($routes) {
    $routes->get('/', 'GuruKelas::tugas');
    $routes->get('buat', 'GuruKelas::buatTugas');
    $routes->get('kelola', 'GuruKelas::kelolaTugas');
});

// ============= WALI KELAS SPECIFIC ROUTES =============
$routes->group('monitoring', ['filter' => 'role:wali_kelas'], function($routes) {
    $routes->get('/', 'WaliKelas::monitoring');
    $routes->get('kehadiran', 'WaliKelas::kehadiran');
    $routes->get('prestasi', 'WaliKelas::prestasi');
    $routes->get('perilaku', 'WaliKelas::perilaku');
    $routes->get('bermasalah', 'WaliKelas::siswabermasalah');
    $routes->get('real-time', 'WaliKelas::monitoringRealTime');
});

$routes->group('komunikasi', ['filter' => 'role:wali_kelas'], function($routes) {
    $routes->get('/', 'WaliKelas::komunikasi');
    $routes->get('orangtua', 'WaliKelas::kontakOrangTua');
    $routes->get('rapat', 'WaliKelas::rapatOrangTua');
    $routes->get('surat', 'WaliKelas::suratMenyurat');
});

$routes->group('siswa', ['filter' => 'role:wali_kelas'], function($routes) {
    $routes->get('/', 'WaliKelas::dataSiswa');
    $routes->get('profil', 'WaliKelas::profilSiswa');
    $routes->get('pribadi', 'WaliKelas::dataPribadi');
    $routes->get('orangtua', 'WaliKelas::dataOrangTua');
    $routes->get('monitoring', 'WaliKelas::monitoringSiswa');
});

// ============= KEPALA SEKOLAH SPECIFIC ROUTES =============
$routes->group('sekolah', ['filter' => 'role:kepala_sekolah'], function($routes) {
    $routes->get('/', 'KepalaSekolah::manajemenSekolah');
    $routes->get('profil', 'KepalaSekolah::profilSekolah');
    $routes->get('visi-misi', 'KepalaSekolah::visiMisi');
    $routes->get('struktur', 'KepalaSekolah::strukturOrganisasi');
});

$routes->group('sdm', ['filter' => 'role:kepala_sekolah'], function($routes) {
    $routes->get('/', 'KepalaSekolah::manajemenSDM');
    $routes->get('guru', 'KepalaSekolah::dataGuru');
    $routes->get('staff', 'KepalaSekolah::dataStaff');
    $routes->get('kinerja', 'KepalaSekolah::penilaianKinerja');
    $routes->get('pengembangan', 'KepalaSekolah::pengembanganSDM');
});

$routes->group('analytics', ['filter' => 'role:kepala_sekolah'], function($routes) {
    $routes->get('/', 'KepalaSekolah::analytics');
    $routes->get('dashboard', 'KepalaSekolah::dashboardAnalytics');
    $routes->get('real-time', 'KepalaSekolah::monitoringRealTime');
});

$routes->group('laporan', ['filter' => 'role:kepala_sekolah'], function($routes) {
    $routes->get('/', 'KepalaSekolah::laporan');
    $routes->get('executive', 'KepalaSekolah::laporanExecutive');
    $routes->get('bulanan', 'KepalaSekolah::laporanBulanan');
    $routes->get('tahunan', 'KepalaSekolah::laporanTahunan');
    $routes->get('export', 'KepalaSekolah::exportData');
});

// ============= SHARED ROUTES (ALL ROLES) =============
$routes->group('absensi', function($routes) {
    $routes->get('/', 'Absensi::index');
    $routes->get('harian', 'Absensi::harian');
    $routes->get('rekap', 'Absensi::rekap');
    $routes->get('hari-ini', 'Absensi::hariIni');
});

$routes->group('kelas', function($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->get('siswa', 'Kelas::daftarSiswa');
    $routes->get('profil', 'Kelas::profilKelas');
});

// ============= LEGACY ROUTES (RADAR KELAS) =============

// ============= RADAR KELAS (GURU MAPEL) =============
$routes->group('radar-kelas', function($routes) {
    $routes->get('/', 'RadarKelas::index');
    $routes->get('lapor-cepat', 'RadarKelas::laporCepat');
    $routes->get('lapor-cepat/(:num)', 'RadarKelas::laporCepat/$1');
    $routes->post('simpan-laporan', 'RadarKelas::simpanLaporan');
    $routes->get('riwayat-sinyal', 'RadarKelas::riwayatSinyal');
    
    // Dashboard Wali Kelas
    $routes->get('dashboard-wali', 'RadarKelas::dashboardWali');
    $routes->get('detail-siswa/(:num)', 'RadarKelas::detailSiswa/$1');
    $routes->get('manajemen-kasus/(:num)', 'RadarKelas::manajemenKasus/$1');
    $routes->post('proses-tindakan', 'RadarKelas::prosesTindakan');
});

// ============= PUSAT KENDALI KONSELING (GURU BK) =============
$routes->group('konseling', function($routes) {
    $routes->get('/', 'PusatKendaliKonseling::index');
    $routes->get('manajemen-kasus', 'PusatKendaliKonseling::manajemenKasus');
    $routes->get('manajemen-kasus/(:num)', 'PusatKendaliKonseling::manajemenKasus/$1');
    $routes->post('update-status', 'PusatKendaliKonseling::updateStatus');
    $routes->post('tambah-log-konseling', 'PusatKendaliKonseling::tambahLogKonseling');
    $routes->get('laporan-statistik', 'PusatKendaliKonseling::laporanStatistik');
});

// ============= ASESMEN BAKAT MINAT =============
$routes->group('asesmen-bakat-minat', function($routes) {
    $routes->get('/', 'AsesmenBakatMinat::index');
    $routes->get('tes-online', 'AsesmenBakatMinat::tesOnline');
    $routes->get('hasil-tes', 'AsesmenBakatMinat::hasilTes');
    $routes->get('hasil-tes/(:num)', 'AsesmenBakatMinat::detailHasil/$1');
    $routes->get('analisis', 'AsesmenBakatMinat::analisis');
    $routes->get('rekomendasi', 'AsesmenBakatMinat::rekomendasi');
    $routes->get('rekomendasi/(:num)', 'AsesmenBakatMinat::detailRekomendasi/$1');
    $routes->get('laporan', 'AsesmenBakatMinat::laporan');
    $routes->post('mulai-sesi', 'AsesmenBakatMinat::mulaiSesi');
    $routes->post('simpan-hasil', 'AsesmenBakatMinat::simpanHasil');
});

// Test route
$routes->get('/test', 'Home::index');
