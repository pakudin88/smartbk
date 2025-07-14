<?php
echo "=== APP-ORTU MANUAL TEST ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

echo "1. CHECKING CRITICAL FILES:\n";

$files_to_check = [
    'public/index.php' => 'Main entry point',
    'app/Controllers/Home.php' => 'Home controller',
    'app/Config/Routes.php' => 'Routes configuration',
    '.env' => 'Environment configuration',
    'spark' => 'CLI tool'
];

foreach ($files_to_check as $file => $description) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✓ $file ($description) - EXISTS\n";
    } else {
        echo "✗ $file ($description) - MISSING\n";
    }
}

echo "\n2. CHECKING COMPOSER:\n";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✓ Composer dependencies installed\n";
} else {
    echo "✗ Composer dependencies missing\n";
}

echo "\n3. TESTING SPARK COMMAND:\n";
$spark_test = shell_exec("cd " . __DIR__ . " && php spark list 2>&1 | head -5");
if (strpos($spark_test, 'CodeIgniter') !== false) {
    echo "✓ Spark command working\n";
    echo "Sample output: " . trim(explode("\n", $spark_test)[0]) . "\n";
} else {
    echo "✗ Spark command failed\n";
    echo "Error: " . trim($spark_test) . "\n";
}

echo "\n4. ENVIRONMENT CHECK:\n";
if (file_exists(__DIR__ . '/.env')) {
    $env_content = file_get_contents(__DIR__ . '/.env');
    if (strpos($env_content, 'CI_ENVIRONMENT = development') !== false) {
        echo "✓ Development environment configured\n";
    } else {
        echo "? Environment configuration unclear\n";
    }
    if (strpos($env_content, 'CI_DEBUG = true') !== false) {
        echo "✓ Debug mode enabled\n";
    } else {
        echo "? Debug mode configuration unclear\n";
    }
} else {
    echo "✗ Environment file missing\n";
}

echo "\n5. INSTRUCTIONS TO TEST:\n";
echo "To test the application manually:\n";
echo "1. Open command prompt in app-ortu directory\n";
echo "2. Run: php spark serve --port=8080\n";
echo "3. Open browser to: http://localhost:8080\n";
echo "4. You should see: 'App-Ortu is working! Welcome to Jendela Kemitraan. Time: [timestamp]'\n";
echo "5. Test route: http://localhost:8080/test\n";
echo "6. Test API: http://localhost:8080/Home/test\n";

echo "\n=== MANUAL TEST COMPLETED ===\n";
