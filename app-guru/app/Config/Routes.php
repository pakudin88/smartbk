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

// Test route
$routes->get('/test', 'Home::index');
