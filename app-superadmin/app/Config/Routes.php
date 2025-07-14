<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Set default controller
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');

// Debug route for testing
$routes->get('test-pengguna-murid', function() {
    echo "<h2>Debug: Pengguna Murid Route Test</h2>";
    echo "✅ Route is accessible<br>";
    echo "✅ CodeIgniter is working<br>";
    echo "<a href='/pengguna-murid'>Go to Pengguna Murid</a>";
});

$routes->get('test-controller', 'TestPenggunaMuridSimple::index');
$routes->get('test-pengguna-murid-direct', 'TestPenggunaMuridDirect::index');
$routes->get('debug-pengguna-murid', 'PenggunaMurid::debugIndex');
$routes->get('test-getdata', 'PenggunaMurid::testGetData');

// Temporary bypass route for testing (no auth filter)
$routes->get('pengguna-murid-bypass', 'PenggunaMurid::bypassAuth');
$routes->get('pengguna-murid-test', 'PenggunaMurid::index'); // Direct test without auth
$routes->get('pengguna-murid-simple', 'PenggunaMurid::simpleDebug'); // Simple debug method
$routes->get('pengguna-murid-data', 'PenggunaMurid::testWithData'); // Test with real data

// Test dashboard route (bypass auth)
$routes->get('dashboard-test', 'Home::dashboardTest');

// Test Simple Store routes
$routes->post('test-simple-store', 'TestSimpleStore::store');

// Test CSRF routes
$routes->get('test-csrf/users/create', 'TestCsrf::create');
$routes->post('test-csrf/users/store', 'TestCsrf::store');

// Test form routes
$routes->get('test-form/create', 'TestForm::create');
$routes->post('test-form/store', 'TestForm::store');

// Simple routes for basic testing
$routes->get('simple/users/create', 'SimpleUsers::create');
$routes->post('simple/users/store', 'SimpleUsers::store');

// Debug routes for troubleshooting
$routes->get('debug/users/create', 'DebugUsers::create');
$routes->post('debug/users/store', 'DebugUsers::store');

// Debug full routes                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
$routes->get('debug-full/users/create', 'DebugFull::createUser');
$routes->post('debug-full/users/store', 'DebugFull::storeUser');

// Test routes for debugging (put at top)
$routes->get('test', 'Test::index');
$routes->get('test/dashboard', 'Test::dashboard');
$routes->get('test/users/create', 'TestUsers::create');
$routes->post('test/users/store', 'TestUsers::store');
$routes->get('test/pengguna', 'TestPengguna::index');
$routes->get('test/auth', 'TestAuth::index');
$routes->get('test/auth/login', 'TestAuth::login');
$routes->get('test/pengguna-sekolah', 'TestPenggunaSekolah::index');
$routes->get('test-pengguna-murid-data', 'PenggunaMurid::testGetData');
$routes->post('test-pengguna-murid-data', 'PenggunaMurid::testGetData');
$routes->get('test-murid-bypass', 'PenggunaMurid::index');
$routes->get('test-murid-getdata', 'PenggunaMurid::getData');
$routes->post('test-murid-getdata', 'PenggunaMurid::getData');
$routes->get('debug-murid-bypass', 'PenggunaMurid::debugBypass');
$routes->get('debug-murid-getdata', 'PenggunaMurid::debugGetData');
$routes->post('debug-murid-getdata', 'PenggunaMurid::debugGetData');
$routes->get('test-murid-page', 'PenggunaMurid::testIndex');
$routes->get('test-murid-index-bypass', 'PenggunaMurid::testIndexBypass');

// Quick login for testing (remove in production)
$routes->get('debug-login', function() {
    session()->set([
        'isLoggedIn' => true,
        'user_id' => 1,
        'username' => 'superadmin',
        'role' => 'Superadmin',
        'full_name' => 'Super Administrator'
    ]);
    echo "<h2>Auto-login successful</h2>";
    echo "You are now logged in as superadmin<br>";
    echo "<a href='/pengguna-murid'>Go to Pengguna Murid</a><br>";
    echo "<a href='/dashboard'>Go to Dashboard</a>";
});

// Users routes - explicit mapping (put early)
$routes->get('users', 'Users::index');
$routes->get('users/index', 'Users::index');
$routes->get('users/create', 'Users::create');
$routes->post('users/store', 'Users::store');
$routes->get('users/view/(:num)', 'Users::view/$1');
$routes->get('users/edit/(:num)', 'Users::edit/$1');
$routes->post('users/update/(:num)', 'Users::update/$1');
$routes->get('users/delete/(:num)', 'Users::delete/$1');
$routes->get('users/toggle/(:num)', 'Users::toggle/$1');
$routes->post('users/toggle-status/(:num)', 'Users::toggleStatus/$1');
$routes->get('users/export', 'Users::export');
$routes->get('users/export/(:alpha)', 'Users::export/$1');
$routes->get('users/export-excel', 'Users::exportExcel');
$routes->get('users/export-csv', 'Users::exportCsv');
$routes->post('users/update-profile-picture', 'Users::updateProfilePicture');
$routes->post('users/update-profile', 'Users::updateProfile');
$routes->post('users/change-password', 'Users::changePassword');

// Route untuk halaman profile user
$routes->get('settings/profile', 'Users::profile');

// Route utama login dan dashboard
$routes->get('/', function() { return redirect()->to('/login'); });
$routes->get('/login', 'Auth::index');
$routes->get('/auth/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index');

// Schools routes
$routes->group('schools', static function($routes) {
    $routes->get('/', 'Schools::index');
    $routes->get('create', 'Schools::create');
    $routes->post('store', 'Schools::store');
    $routes->get('edit/(:num)', 'Schools::edit/$1');
    $routes->post('update/(:num)', 'Schools::update/$1');
    $routes->get('delete/(:num)', 'Schools::delete/$1');
});

// Classes routes
$routes->group('classes', static function($routes) {
    $routes->get('/', 'Classes::index');
    $routes->get('create', 'Classes::create');
    $routes->post('store', 'Classes::store');
    $routes->get('edit/(:num)', 'Classes::edit/$1');
    $routes->post('update/(:num)', 'Classes::update/$1');
    $routes->get('delete/(:num)', 'Classes::delete/$1');
    $routes->get('students/(:num)', 'Classes::viewStudents/$1');
    $routes->post('assign-student/(:num)', 'Classes::assignStudent/$1');
    $routes->get('remove-student/(:num)/(:num)', 'Classes::removeStudent/$1/$2');
});

// API routes
$routes->group('api', static function($routes) {
    $routes->get('students-without-class', 'Api::studentsWithoutClass');
    $routes->get('studentsWithoutClass', 'Api::studentsWithoutClass'); // Add camelCase version for consistency
    $routes->get('classes-with-capacity', 'Api::classesWithCapacity');
});

// Positions routes (Kelola Jabatan)
$routes->group('positions', static function($routes) {
    $routes->get('/', 'Positions::index');
    $routes->get('create', 'Positions::create');
    $routes->post('store', 'Positions::store');
    $routes->get('edit/(:num)', 'Positions::edit/$1');
    $routes->post('update/(:num)', 'Positions::update/$1');
    $routes->get('delete/(:num)', 'Positions::delete/$1');
    $routes->get('petugas/(:num)', 'Positions::viewPetugas/$1');
    $routes->post('assign-petugas/(:num)', 'Positions::assignPetugas/$1');
    $routes->get('remove-petugas/(:num)/(:num)', 'Positions::removePetugas/$1/$2');
    $routes->post('copy-from-previous-year', 'Positions::copyFromPreviousYear');
});

// School Years routes
$routes->group('school-years', static function($routes) {
    $routes->get('/', 'SchoolYears::index');
    $routes->get('create', 'SchoolYears::create');
    $routes->post('store', 'SchoolYears::store');
    $routes->get('edit/(:num)', 'SchoolYears::edit/$1');
    $routes->post('update/(:num)', 'SchoolYears::update/$1');
    $routes->get('delete/(:num)', 'SchoolYears::delete/$1');
    $routes->post('activate/(:num)', 'SchoolYears::activate/$1');
});

// Reports routes
$routes->group('reports', static function($routes) {
    $routes->get('/', 'Reports::index');
    $routes->get('users', 'Reports::users');
    $routes->get('schools', 'Reports::schools');
    $routes->get('classes', 'Reports::classes');
    $routes->get('subjects', 'Reports::subjects');
    $routes->get('export/(:alpha)', 'Reports::export/$1');
});

// Settings routes
$routes->group('settings', ['filter' => 'auth'], static function($routes) {
    $routes->get('/', 'Settings::index');
    $routes->get('profile', 'Users::profile'); // Redirect ke Users::profile
    $routes->post('profile', 'Settings::updateProfile');
    $routes->get('change-password', 'Settings::changePassword');
    $routes->post('change-password', 'Settings::updatePassword');
    $routes->get('system', 'Settings::system');
    $routes->get('backup', 'Settings::backup');
    $routes->post('backup', 'Settings::createBackup');
    $routes->get('backup/download/(:any)', 'Settings::downloadBackup/$1');
    $routes->get('backup/delete/(:any)', 'Settings::deleteBackup/$1');
});

// Pengguna Sekolah routes (Petugas)
$routes->group('pengguna-sekolah', ['filter' => 'auth'], static function($routes) {
    $routes->get('/', 'PenggunaSekolah::index');
    $routes->get('create', 'PenggunaSekolah::create');
    $routes->post('store', 'PenggunaSekolah::store');
    $routes->get('edit/(:num)', 'PenggunaSekolah::edit/$1');
    $routes->post('update/(:num)', 'PenggunaSekolah::update/$1');
    $routes->get('delete/(:num)', 'PenggunaSekolah::delete/$1');
    $routes->delete('delete/(:num)', 'PenggunaSekolah::delete/$1');
    $routes->get('view/(:num)', 'PenggunaSekolah::view/$1');
    $routes->get('toggle-status/(:num)', 'PenggunaSekolah::toggleStatus/$1');
    $routes->post('import-excel', 'PenggunaSekolah::importExcel');
    $routes->get('download-template', 'PenggunaSekolah::downloadTemplate');
});

// Pengguna Murid routes
$routes->group('pengguna-murid', ['filter' => 'auth'], static function($routes) {
    $routes->get('/', 'PenggunaMurid::index');
    $routes->get('getData', 'PenggunaMurid::getData');
    $routes->post('getData', 'PenggunaMurid::getData'); // Add POST route for AJAX
    $routes->get('create', 'PenggunaMurid::create');
    $routes->post('store', 'PenggunaMurid::store');
    $routes->get('edit/(:num)', 'PenggunaMurid::edit/$1');
    $routes->post('update/(:num)', 'PenggunaMurid::update/$1');
    $routes->put('update/(:num)', 'PenggunaMurid::update/$1');
    $routes->get('delete/(:num)', 'PenggunaMurid::delete/$1');
    $routes->delete('ajax-delete/(:num)', 'PenggunaMurid::ajaxDelete/$1');
    $routes->get('view/(:num)', 'PenggunaMurid::view/$1');
    $routes->post('import-excel', 'PenggunaMurid::importExcel');
    $routes->get('download-template', 'PenggunaMurid::downloadTemplate');
    $routes->get('toggle-status/(:num)', 'PenggunaMurid::toggleStatus/$1');
    $routes->get('orang-tua/(:num)', 'PenggunaMurid::orangTua/$1');
});

// Pengguna Orang Tua routes
$routes->group('pengguna-orang-tua', ['filter' => 'auth'], static function($routes) {
    $routes->get('/', 'PenggunaOrangTua::index');
    $routes->get('create', 'PenggunaOrangTua::create');
    $routes->post('store', 'PenggunaOrangTua::store');
    $routes->get('edit/(:num)', 'PenggunaOrangTua::edit/$1');
    $routes->post('update/(:num)', 'PenggunaOrangTua::update/$1');
    $routes->get('delete/(:num)', 'PenggunaOrangTua::delete/$1');
    $routes->get('view/(:num)', 'PenggunaOrangTua::view/$1');
    $routes->get('toggle-status/(:num)', 'PenggunaOrangTua::toggleStatus/$1');
    $routes->get('kelola-murid/(:num)', 'PenggunaOrangTua::kelolaMurid/$1');
    $routes->post('tambah-murid', 'PenggunaOrangTua::tambahMurid');
    $routes->post('hapus-murid', 'PenggunaOrangTua::hapusMurid');
    $routes->get('search-murid', 'PenggunaOrangTua::searchMurid');
    $routes->post('import-excel', 'PenggunaOrangTua::importExcel');
    $routes->get('download-template', 'PenggunaOrangTua::downloadTemplate');
});
