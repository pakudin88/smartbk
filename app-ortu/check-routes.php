<?php
echo "=== ROUTE TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Test what route / points to
echo "1. CHECKING ROUTE CONFIGURATION:\n";

// Read Routes.php
$routes_content = file_get_contents(__DIR__ . '/app/Config/Routes.php');

if (strpos($routes_content, "\$routes->get('/', 'Partnership::index');") !== false) {
    echo "✓ Root route points to Partnership::index\n";
} else if (strpos($routes_content, "\$routes->get('/', 'Home::index');") !== false) {
    echo "✗ Root route still points to Home::index\n";
} else {
    echo "? Root route configuration unclear\n";
}

echo "\n2. CHECKING PARTNERSHIP CONTROLLER:\n";
if (file_exists(__DIR__ . '/app/Controllers/Partnership.php')) {
    echo "✓ Partnership controller exists\n";
    
    $controller_content = file_get_contents(__DIR__ . '/app/Controllers/Partnership.php');
    if (strpos($controller_content, 'public function index()') !== false) {
        echo "✓ Partnership::index method exists\n";
    } else {
        echo "✗ Partnership::index method missing\n";
    }
} else {
    echo "✗ Partnership controller missing\n";
}

echo "\n3. CHECKING LOGIN VIEW:\n";
if (file_exists(__DIR__ . '/app/Views/invitation/login.php')) {
    echo "✓ Login view exists\n";
} else {
    echo "✗ Login view missing\n";
}

if (file_exists(__DIR__ . '/app/Views/layouts/modern_layout.php')) {
    echo "✓ Modern layout exists\n";
} else {
    echo "✗ Modern layout missing\n";
}

echo "\n4. MANUAL TEST INSTRUCTIONS:\n";
echo "Try these URLs in your browser:\n";
echo "- http://localhost:8080/ (should redirect to /login)\n";
echo "- http://localhost:8080/login (should show login panel)\n";
echo "- http://localhost:8080/test (should show 'App-Ortu is working!')\n";

echo "\n=== TEST COMPLETED ===\n";
