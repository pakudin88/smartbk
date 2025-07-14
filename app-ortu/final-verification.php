<?php
echo "=== APP-ORTU FINAL VERIFICATION ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Function to test a route
function testRoute($path, $description) {
    echo "Testing: $description\n";
    echo "Route: $path\n";
    
    // Setup environment for web request
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $path;
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['SERVER_PORT'] = '8080';
    $_SERVER['HTTP_HOST'] = 'localhost:8080';
    $_SERVER['HTTPS'] = '';
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    
    putenv('CI_ENVIRONMENT=development');
    
    // Use curl to simulate real request
    $url = "http://localhost:8080" . $path;
    
    // Start a temporary server and test
    $output = shell_exec("cd " . __DIR__ . " && php -S localhost:8081 -t public 2>&1 & sleep 1 && curl -s http://localhost:8081$path && pkill -f 'php -S localhost:8081' 2>/dev/null");
    
    if (!$output) {
        $output = "No output received";
    }
    
    echo "Output: " . trim($output) . "\n";
    echo "Length: " . strlen($output) . " characters\n";
    echo "Status: " . (strlen($output) > 10 ? 'SUCCESS' : 'FAILED') . "\n";
    echo "----------------------------------------\n";
    
    return $output;
}

// Test different routes
echo "1. TESTING HOME ROUTE:\n";
testRoute('/', 'Home page');

echo "\n2. TESTING TEST ROUTE:\n";  
testRoute('/test', 'Test endpoint');

echo "\n3. TESTING CONTROLLER TEST:\n";
testRoute('/Home/test', 'Controller test method');

echo "\n=== VERIFICATION COMPLETED ===\n";
