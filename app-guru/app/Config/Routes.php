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

// Dashboard dan menu utama
$routes->get('/dashboard', 'GuruAuth::dashboard');
$routes->get('/profile', 'GuruAuth::profile');

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
