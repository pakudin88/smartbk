<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Partnership');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Main routes
$routes->get('/', 'Partnership::index');
$routes->get('dashboard', 'Partnership::dashboard');
$routes->get('summary', 'Partnership::summary');
$routes->get('progress', 'Partnership::progress');
$routes->post('submit-feedback', 'Partnership::submitFeedback');
$routes->get('logout', 'Partnership::logout');

// Test route
$routes->get('test', function() {
    return view('test_page');
});
