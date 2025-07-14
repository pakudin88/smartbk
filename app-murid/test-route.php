<?php

// Path to the front controller
$frontController = __DIR__ . '/public/index.php';

// Check if the front controller exists
if (!file_exists($frontController)) {
    die('Front controller not found. Please check the path.');
}

// Simulate a request to the /safe-space/konsul-cepat route
$_SERVER['REQUEST_URI']    = '/safe-space/konsul-cepat';
$_SERVER['SCRIPT_NAME']    = '/index.php';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['REQUEST_METHOD'] = 'GET';

echo "Testing route: /safe-space/konsul-cepat\n";

// Unset CLI arguments to force web mode
unset($argv, $argc);

// Include the front controller to handle the request
require $frontController;
