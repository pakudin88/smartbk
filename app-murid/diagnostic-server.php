<?php
/**
 * Diagnostic Tool untuk masalah php spark serve
 * Jalankan untuk mendiagnosis dan memperbaiki masalah server
 */

echo "<h1>🔧 Diagnostic Tool - App Murid Server Issues</h1>";
echo "<hr>";

$appDir = __DIR__;
$errors = [];
$warnings = [];
$solutions = [];

// 1. Check current directory
echo "<h2>1. Directory Check</h2>";
echo "<p><strong>Current Directory:</strong> $appDir</p>";

if (basename($appDir) !== 'app-murid') {
    $errors[] = "Script tidak dijalankan dari folder app-murid";
    $solutions[] = "Pastikan script ini berada di folder app-murid";
}

// 2. Check required files
echo "<h2>2. Required Files Check</h2>";
$requiredFiles = [
    'spark' => 'CodeIgniter CLI tool',
    'public/index.php' => 'Web entry point',
    'app/Config/App.php' => 'App configuration',
    'app/Config/Routes.php' => 'Routes configuration',
    'composer.json' => 'Composer configuration',
    '.env' => 'Environment configuration'
];

foreach ($requiredFiles as $file => $description) {
    $path = $appDir . '/' . $file;
    $exists = file_exists($path);
    $status = $exists ? '✅' : '❌';
    $color = $exists ? 'green' : 'red';
    
    echo "<p><span style='color: $color'><strong>$status $description</strong></span> ($file)</p>";
    
    if (!$exists) {
        $errors[] = "File missing: $file";
    }
}

// 3. Check PHP version and extensions
echo "<h2>3. PHP Environment Check</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";

$requiredExtensions = ['mbstring', 'intl', 'json', 'mysqli'];
echo "<p><strong>Required Extensions:</strong></p>";
echo "<ul>";
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? '✅' : '❌';
    $color = $loaded ? 'green' : 'red';
    echo "<li><span style='color: $color'><strong>$status $ext</strong></span></li>";
    
    if (!$loaded) {
        $warnings[] = "PHP extension missing: $ext";
    }
}
echo "</ul>";

// 4. Check permissions
echo "<h2>4. Directory Permissions Check</h2>";
$dirs = ['writable', 'writable/cache', 'writable/logs', 'writable/session'];
foreach ($dirs as $dir) {
    $path = $appDir . '/' . $dir;
    $writable = is_writable($path);
    $status = $writable ? '✅' : '❌';
    $color = $writable ? 'green' : 'red';
    echo "<p><span style='color: $color'><strong>$status $dir</strong></span></p>";
    
    if (!$writable) {
        $errors[] = "Directory not writable: $dir";
        $solutions[] = "Set write permissions for: $dir";
    }
}

// 5. Check if ports are available
echo "<h2>5. Port Availability Check</h2>";
$ports = [8080, 9000, 8082, 3000];
foreach ($ports as $port) {
    $connection = @fsockopen('localhost', $port, $errno, $errstr, 1);
    if ($connection) {
        echo "<p><span style='color: red'><strong>❌ Port $port is in use</strong></span></p>";
        fclose($connection);
        $warnings[] = "Port $port is already in use";
    } else {
        echo "<p><span style='color: green'><strong>✅ Port $port is available</strong></span></p>";
    }
}

// 6. Test CodeIgniter CLI
echo "<h2>6. CodeIgniter CLI Test</h2>";
$sparkPath = $appDir . '/spark';
if (file_exists($sparkPath)) {
    // Try to execute spark command
    $output = [];
    $returnVar = 0;
    exec("cd \"$appDir\" && php spark list", $output, $returnVar);
    
    if ($returnVar === 0) {
        echo "<p><span style='color: green'><strong>✅ CodeIgniter CLI is working</strong></span></p>";
        echo "<details><summary>Available commands:</summary>";
        echo "<pre>" . implode("\n", $output) . "</pre>";
        echo "</details>";
    } else {
        echo "<p><span style='color: red'><strong>❌ CodeIgniter CLI has issues</strong></span></p>";
        $errors[] = "CodeIgniter CLI not working properly";
        $solutions[] = "Try running: composer install";
    }
} else {
    echo "<p><span style='color: red'><strong>❌ Spark file not found</strong></span></p>";
    $errors[] = "Spark CLI file missing";
}

// 7. Generate solutions
echo "<h2>7. Solutions & Commands</h2>";

if (count($errors) > 0) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3 style='color: #721c24;'>❌ Critical Issues Found:</h3>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo "</div>";
}

if (count($warnings) > 0) {
    echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3 style='color: #856404;'>⚠️ Warnings:</h3>";
    echo "<ul>";
    foreach ($warnings as $warning) {
        echo "<li>$warning</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// Solutions
echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h3 style='color: #155724;'>🔧 Recommended Solutions:</h3>";

echo "<h4>Method 1: CodeIgniter Spark Serve</h4>";
echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 3px;'>";
echo "cd /d \"$appDir\"\n";
echo "php spark serve --port=9000\n";
echo "# Akses: http://localhost:9000";
echo "</pre>";

echo "<h4>Method 2: Built-in PHP Server (Alternative)</h4>";
echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 3px;'>";
echo "cd /d \"$appDir\"\n";
echo "php -S localhost:9000 -t public\n";
echo "# Akses: http://localhost:9000";
echo "</pre>";

echo "<h4>Method 3: Using Batch File</h4>";
echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 3px;'>";
echo "# Double-click file: run-app-murid.bat\n";
echo "# Atau jalankan dari terminal:\n";
echo "run-app-murid.bat";
echo "</pre>";

echo "<h4>Method 4: PowerShell Script</h4>";
echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 3px;'>";
echo "# Right-click -> Run with PowerShell:\n";
echo "# run-app-murid.ps1\n";
echo "# Atau dari PowerShell:\n";
echo ".\\run-app-murid.ps1";
echo "</pre>";

if (count($solutions) > 0) {
    echo "<h4>Fix Issues:</h4>";
    echo "<ul>";
    foreach ($solutions as $solution) {
        echo "<li>$solution</li>";
    }
    echo "</ul>";
}

echo "</div>";

// 8. Quick test commands
echo "<h2>8. Quick Test Commands</h2>";
echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px;'>";
echo "<h4>Test CodeIgniter installation:</h4>";
echo "<p><code>php spark --version</code></p>";

echo "<h4>List available commands:</h4>";
echo "<p><code>php spark list</code></p>";

echo "<h4>Test basic PHP server:</h4>";
echo "<p><code>php -S localhost:8080 -t public</code></p>";

echo "<h4>Check PHP configuration:</h4>";
echo "<p><code>php -m</code> (list loaded modules)</p>";
echo "<p><code>php --ini</code> (show PHP config files)</p>";
echo "</div>";

// 9. Create launcher batch if missing
$batchFile = dirname($appDir) . '/run-app-murid.bat';
if (!file_exists($batchFile)) {
    echo "<h2>9. Creating Launcher Script</h2>";
    echo "<p>Creating batch launcher script...</p>";
    
    $batchContent = '@echo off
cd /d "' . $appDir . '"
echo Starting SIMAKLAH App Murid...
echo.
php -S localhost:9000 -t public
pause';
    
    if (file_put_contents($batchFile, $batchContent)) {
        echo "<p style='color: green'>✅ Created: $batchFile</p>";
    } else {
        echo "<p style='color: red'>❌ Failed to create launcher script</p>";
    }
}

echo "<hr>";
echo "<p><em>Diagnostic completed at: " . date('Y-m-d H:i:s') . "</em></p>";
?>
