<?php
/**
 * Simple Test for Dynamic BaseURL Logic
 */

echo "=== TESTING DYNAMIC BASEURL LOGIC ===\n";

// Simulate the logic from App.php constructor
function getDynamicBaseURL($httpHost = null, $requestScheme = null, $serverName = null, $serverPort = null) {
    // Use provided values or fallback to $_SERVER
    $httpHost = $httpHost ?? ($_SERVER['HTTP_HOST'] ?? null);
    $requestScheme = $requestScheme ?? ($_SERVER['REQUEST_SCHEME'] ?? 'http');
    $serverName = $serverName ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');
    $serverPort = $serverPort ?? ($_SERVER['SERVER_PORT'] ?? '80');
    
    if ($httpHost) {
        return $requestScheme . '://' . $httpHost . '/';
    } else {
        $port = ($serverPort == '80' || $serverPort == '443') ? '' : ':' . $serverPort;
        return $requestScheme . '://' . $serverName . $port . '/';
    }
}

// Test cases
$testCases = [
    [
        'name' => 'Port 8080 with HTTP_HOST',
        'HTTP_HOST' => 'localhost:8080',
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost:8080/'
    ],
    [
        'name' => 'Port 9000 with HTTP_HOST', 
        'HTTP_HOST' => 'localhost:9000',
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost:9000/'
    ],
    [
        'name' => 'Port 3000 with HTTP_HOST',
        'HTTP_HOST' => 'localhost:3000', 
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost:3000/'
    ],
    [
        'name' => 'Default port 80 (no HTTP_HOST)',
        'HTTP_HOST' => null,
        'SERVER_NAME' => 'localhost',
        'SERVER_PORT' => '80',
        'REQUEST_SCHEME' => 'http',
        'expected' => 'http://localhost/'
    ],
    [
        'name' => 'HTTPS on 443 (no HTTP_HOST)',
        'HTTP_HOST' => null,
        'SERVER_NAME' => 'localhost',
        'SERVER_PORT' => '443',
        'REQUEST_SCHEME' => 'https',
        'expected' => 'https://localhost/'
    ]
];

foreach ($testCases as $test) {
    echo "\nTesting: " . $test['name'] . "\n";
    
    $actual = getDynamicBaseURL(
        $test['HTTP_HOST'] ?? null,
        $test['REQUEST_SCHEME'] ?? 'http',
        $test['SERVER_NAME'] ?? 'localhost',
        $test['SERVER_PORT'] ?? '80'
    );
    
    echo "Expected: " . $test['expected'] . "\n";
    echo "Actual:   " . $actual . "\n";
    
    if ($actual === $test['expected']) {
        echo "✅ PASS\n";
    } else {
        echo "❌ FAIL\n";
    }
}

echo "\n=== CURRENT ENVIRONMENT ===\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n";
echo "SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'not set') . "\n";
echo "SERVER_PORT: " . ($_SERVER['SERVER_PORT'] ?? 'not set') . "\n";
echo "REQUEST_SCHEME: " . ($_SERVER['REQUEST_SCHEME'] ?? 'not set') . "\n";

$currentBaseURL = getDynamicBaseURL();
echo "Current baseURL would be: " . $currentBaseURL . "\n";

echo "\n=== HELPER FUNCTIONS TEST ===\n";

// Test redirect helper functions logic
function current_base_url_logic() {
    $httpHost = $_SERVER['HTTP_HOST'] ?? null;
    $requestScheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
    $serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
    $serverPort = $_SERVER['SERVER_PORT'] ?? '80';
    
    if ($httpHost) {
        return $requestScheme . '://' . $httpHost;
    } else {
        $port = ($serverPort == '80' || $serverPort == '443') ? '' : ':' . $serverPort;
        return $requestScheme . '://' . $serverName . $port;
    }
}

echo "current_base_url() would return: " . current_base_url_logic() . "\n";

echo "\n=== READY FOR BROWSER TESTING ===\n";
echo "1. Run: php spark serve --port=9000\n";
echo "2. Visit: http://localhost:9000/login\n";
echo "3. Login with: siswa_001 / siswa123\n";
echo "4. Verify all pages stay on port 9000\n";
echo "5. Test with different ports (8080, 3000, etc.)\n";
?>
