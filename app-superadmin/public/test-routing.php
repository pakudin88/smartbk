<?php
// Test routing langsung
echo "<h2>Test Routing</h2>";

$routes = [
    '/dashboard' => 'Dashboard::index',
    '/users' => 'Users::index',
    '/users/create' => 'Users::create',
    '/login' => 'Auth::index'
];

foreach ($routes as $route => $controller) {
    echo "<p><a href='{$route}' target='_blank'>{$route}</a> -> {$controller}</p>";
}

// Test server info
echo "<h3>Server Info</h3>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>PHP: " . phpversion() . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";

// Test mod_rewrite
echo "<h3>Test mod_rewrite</h3>";
if (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules())) {
    echo "<p style='color:green'>mod_rewrite is enabled</p>";
} else {
    echo "<p style='color:red'>mod_rewrite status unknown</p>";
}

// Test .htaccess
echo "<h3>Test .htaccess</h3>";
if (file_exists('.htaccess')) {
    echo "<p style='color:green'>.htaccess file exists</p>";
} else {
    echo "<p style='color:red'>.htaccess file NOT found</p>";
}
?>
