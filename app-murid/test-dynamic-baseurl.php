<?php
/**
 * Test Dynamic BaseURL Configuration
 */

// Simple test without requiring CodeIgniter framework
echo "=== TESTING DYNAMIC BASEURL CONFIGURATION ===\n";

// Simulate different server environments
$testCases = [
    [
        'name' => 'Port 8080',
        'HTTP_HOST' => 'localhost:8080',
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost:8080/'
    ],
    [
        'name' => 'Port 9000', 
        'HTTP_HOST' => 'localhost:9000',
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost:9000/'
    ],
    [
        'name' => 'Port 3000',
        'HTTP_HOST' => 'localhost:3000', 
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost:3000/'
    ],
    [
        'name' => 'Default port 80',
        'SERVER_NAME' => 'localhost',
        'SERVER_PORT' => '80',
        'expected' => 'http://localhost/'
    ]
];

foreach ($testCases as $test) {
    echo "\nTesting: " . $test['name'] . "\n";
    
    // Clear previous environment
    unset($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_SCHEME'], $_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'], $_SERVER['HTTPS']);
    
    // Set test environment
    foreach ($test as $key => $value) {
        if ($key !== 'name' && $key !== 'expected') {
            $_SERVER[$key] = $value;
        }
    }
    
    // Test the baseURL logic
    try {
        // Initialize CodeIgniter paths if not already set
        if (!defined('APPPATH')) {
            define('APPPATH', __DIR__ . '/app/');
        }
        if (!defined('FCPATH')) {
            define('FCPATH', __DIR__ . '/public/');
        }
        
        // Create new App config instance 
        $config = new \Config\App();
        
        echo "Expected: " . $test['expected'] . "\n";
        echo "Actual:   " . $config->baseURL . "\n";
        
        if ($config->baseURL === $test['expected']) {
            echo "✅ PASS\n";
        } else {
            echo "❌ FAIL\n";
        }
        
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\n=== TESTING CURRENT ENVIRONMENT ===\n";

// Test current server environment
echo "Current HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n";
echo "Current SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'not set') . "\n";
echo "Current SERVER_PORT: " . ($_SERVER['SERVER_PORT'] ?? 'not set') . "\n";
echo "Current REQUEST_SCHEME: " . ($_SERVER['REQUEST_SCHEME'] ?? 'not set') . "\n";

try {
    $config = new \Config\App();
    echo "Current baseURL: " . $config->baseURL . "\n";
} catch (Exception $e) {
    echo "Error getting current baseURL: " . $e->getMessage() . "\n";
}

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. Start server with: php spark serve --port=9000\n";
echo "2. Visit: http://localhost:9000/login\n";
echo "3. Check if redirects maintain port 9000\n";
echo "4. Test with different ports to verify dynamic baseURL\n";
?>
