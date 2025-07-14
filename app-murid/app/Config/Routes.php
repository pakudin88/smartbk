<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');

// Safe Space feature routes (requires authentication)
$routes->group('safe-space', ['filter' => 'noauth'], function($routes) {
    $routes->get('konsul-cepat', 'Dashboard::konsulCepat');
    $routes->get('jadwal-konseling', 'Dashboard::jadwalKonseling');
    $routes->get('jurnal-digital', 'Dashboard::jurnalDigital');
    $routes->get('pusat-informasi', 'Dashboard::pusatInformasi');
});

// Alternative routes for easier access
$routes->get('konsul-cepat', 'Dashboard::konsulCepat');
$routes->get('jadwal-konseling', 'Dashboard::jadwalKonseling'); 
$routes->get('jurnal-digital', 'Dashboard::jurnalDigital');
$routes->get('pusat-informasi', 'Dashboard::pusatInformasi');

// Test routes (no auth required)
$routes->get('test', 'Test::index');
$routes->get('test/simple', 'Test::simple');
$routes->get('test/info', 'Test::info');
$routes->get('demo/notifications', function() {
    return view('notification_demo');
});

// Notification routes
$routes->group('notifications', ['filter' => 'noauth'], function($routes) {
    $routes->get('get', 'Notification::getNotifications');
    $routes->post('mark-read', 'Notification::markAsRead');
    $routes->post('mark-all-read', 'Notification::markAllAsRead');
    $routes->get('updates', 'Notification::getUpdates');
    $routes->post('test', 'Notification::sendTestNotification');
});

// Safe Space routes with noauth filter (for testing)
$routes->group('safe-space', ['filter' => 'noauth'], function($routes) {
    $routes->get('dashboard', 'Safespace::dashboard');
    $routes->get('konsul-cepat', 'Safespace::konsulCepat');
    $routes->get('jadwal-konseling', 'Safespace::jadwalKonseling');
    $routes->get('jurnal-digital', 'Safespace::jurnalDigital');
    $routes->get('pusat-informasi', 'Safespace::pusatInformasi');
    $routes->get('test-url', 'Safespace::testUrl');
    $routes->get('all-notifications-demo', 'Safespace::allNotificationsDemo');
    $routes->get('notification-overview', 'Safespace::notificationOverview');
    
    // API routes for AJAX calls
    $routes->post('send-message', 'Safespace::sendMessage');
    $routes->post('save-mood', 'Safespace::saveMood');
    $routes->post('save-journal', 'Safespace::saveJournalEntry');
    $routes->post('request-counseling', 'Safespace::requestCounseling');
    $routes->post('favorite-content', 'Safespace::favoriteContent');
    
    $routes->get('get-mood-history', 'Safespace::getMoodHistory');
    $routes->get('get-journal-entries', 'Safespace::getJournalEntries');
    $routes->get('get-available-slots', 'Safespace::getAvailableSlots');
    $routes->get('get-counseling-history', 'Safespace::getCounselingHistory');
    $routes->get('get-info-content', 'Safespace::getInfoContent');
    $routes->get('search-content', 'Safespace::searchContent');
    
    $routes->delete('delete-journal/(:num)', 'Safespace::deleteJournal/$1');
    $routes->put('update-journal/(:num)', 'Safespace::updateJournal/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
