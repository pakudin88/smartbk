<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Main routes
$routes->get('/', 'Partnership::index');
$routes->get('test', 'Home::test');

// Authentication routes
$routes->get('login', 'Partnership::login');
$routes->post('authenticate', 'Partnership::authenticate');
$routes->get('logout', 'Partnership::logout');

// Partnership routes
$routes->get('dashboard', 'Partnership::dashboard');
$routes->get('summary', 'Partnership::summary');
$routes->get('progress', 'Partnership::progress');
$routes->get('notifications', 'Partnership::notifications');
$routes->get('profile', 'Partnership::profile');
$routes->get('academic', 'Partnership::academic');
$routes->get('finance', 'Partnership::finance');
$routes->post('submit-feedback', 'Partnership::submitFeedback');
$routes->get('logout', 'Partnership::logout');

// Test route
$routes->get('test', function() {
    return 'App-Ortu is working! ' . date('Y-m-d H:i:s');
});

// Simple status test
$routes->get('status', function() {
    return json_encode([
        'status' => 'OK',
        'timestamp' => date('Y-m-d H:i:s'),
        'environment' => ENVIRONMENT,
        'debug' => CI_DEBUG ? 'enabled' : 'disabled'
    ]);
});
