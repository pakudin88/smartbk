<?php
// Quick test to verify the current status
echo "=== APP-ORTU QUICK STATUS CHECK ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Test basic application structure
$checks = [
    'index.php exists' => file_exists(__DIR__ . '/public/index.php'),
    'Home controller exists' => file_exists(__DIR__ . '/app/Controllers/Home.php'),
    'Routes config exists' => file_exists(__DIR__ . '/app/Config/Routes.php'),
    '.env file exists' => file_exists(__DIR__ . '/.env'),
    'Writable directory' => is_writable(__DIR__ . '/writable')
];

foreach ($checks as $check => $result) {
    echo ($result ? "✓" : "✗") . " $check\n";
}

echo "\n=== ENVIRONMENT CHECK ===\n";
if (file_exists(__DIR__ . '/.env')) {
    $env = file_get_contents(__DIR__ . '/.env');
    preg_match('/CI_ENVIRONMENT\s*=\s*(.+)/', $env, $env_match);
    preg_match('/CI_DEBUG\s*=\s*(.+)/', $env, $debug_match);
    
    echo "Environment: " . (isset($env_match[1]) ? trim($env_match[1]) : 'Not set') . "\n";
    echo "Debug: " . (isset($debug_match[1]) ? trim($debug_match[1]) : 'Not set') . "\n";
}

echo "\n=== RECOMMENDATION ===\n";
echo "The application should now work properly.\n";
echo "Start the server with:\n";
echo "  php spark serve --port=8080\n";
echo "Then visit: http://localhost:8080\n";
echo "\nExpected: Clean 'App-Ortu is working!' message without errors.\n";
?>
