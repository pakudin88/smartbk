<?php
echo "<h2>Simple Test - App Murid</h2>\n";

// Test 1: PHP Basic
echo "<h3>1. PHP Test</h3>";
echo "✅ PHP Version: " . phpversion() . "<br>\n";

// Test 2: File structure
echo "<h3>2. File Structure Test</h3>";
$required_dirs = ['app', 'public', 'vendor', 'writable'];
foreach ($required_dirs as $dir) {
    if (is_dir(__DIR__ . '/' . $dir)) {
        echo "✅ Directory '$dir' exists<br>\n";
    } else {
        echo "❌ Directory '$dir' missing<br>\n";
    }
}

// Test 3: Important files
echo "<h3>3. Important Files Test</h3>";
$required_files = [
    'app/Controllers/Auth.php',
    'app/Controllers/Dashboard.php', 
    'app/Views/layouts/minimal_layout.php',
    'app/Views/dashboard/index.php',
    '.env'
];

foreach ($required_files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ File '$file' exists<br>\n";
    } else {
        echo "❌ File '$file' missing<br>\n";
    }
}

// Test 4: Database connection (simple)
echo "<h3>4. Database Connection Test</h3>";
try {
    // Read .env file
    $env_content = file_get_contents(__DIR__ . '/.env');
    if (strpos($env_content, 'srv1412.hstgr.io') !== false) {
        echo "✅ Database config found in .env<br>\n";
        
        // Try to connect
        $hostname = 'srv1412.hstgr.io';
        $username = 'u809035070_simaklah';
        $password = 'Simaklah88#';
        $database = 'u809035070_simaklah';
        
        $conn = new mysqli($hostname, $username, $password, $database);
        if ($conn->connect_error) {
            echo "❌ Database connection failed: " . $conn->connect_error . "<br>\n";
        } else {
            echo "✅ Database connected successfully!<br>\n";
            
            // Test users table
            $result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 4");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "✅ Found " . $row['total'] . " student accounts<br>\n";
            }
            $conn->close();
        }
    } else {
        echo "❌ Database config not found<br>\n";
    }
} catch (Exception $e) {
    echo "❌ Database test error: " . $e->getMessage() . "<br>\n";
}

// Test 5: URL Access
echo "<h3>5. URL Test</h3>";
$base_url = "http://localhost/simaklah-main/app-murid/";
echo "🔗 Application URL: <a href='$base_url' target='_blank'>$base_url</a><br>\n";
echo "🔗 Dashboard URL: <a href='{$base_url}dashboard' target='_blank'>{$base_url}dashboard</a><br>\n";

echo "<h3>Test Complete!</h3>";
echo "If you see mostly ✅ marks, the system should be working properly.<br>\n";
?>
