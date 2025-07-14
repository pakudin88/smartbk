<?php
// Quick test for app-ortu functionality
try {
    // Test database connection
    $host = 'srv1412.hstgr.io';
    $dbname = 'u809035070_simaklah';
    $username = 'u809035070_simaklah';
    $password = 'Simaklah88#';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connection successful\n";
    
    // Check for test token
    $stmt = $pdo->prepare("SELECT * FROM parent_invitations WHERE invitation_token LIKE 'test_%' ORDER BY created_at DESC LIMIT 1");
    $stmt->execute();
    $invitation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($invitation) {
        echo "✓ Test invitation found\n";
        echo "Token: " . $invitation['invitation_token'] . "\n";
        echo "Test URL: http://localhost/smartbk/app-ortu/public/?token=" . $invitation['invitation_token'] . "\n";
    } else {
        echo "✗ No test invitation found\n";
    }
    
    // Test file structure
    $files = [
        'app/Config/App.php',
        'app/Controllers/Partnership.php',
        'app/Views/layouts/partnership_layout.php',
        'app/Views/invitation/access.php',
        'app/Views/partnership/dashboard.php',
        'public/index.php'
    ];
    
    foreach ($files as $file) {
        if (file_exists(__DIR__ . '/' . $file)) {
            echo "✓ $file exists\n";
        } else {
            echo "✗ $file missing\n";
        }
    }
    
    echo "\n=== APP-ORTU STATUS ===\n";
    echo "Application should be accessible at:\n";
    echo "Main: http://localhost/smartbk/app-ortu/public/\n";
    echo "Test: http://localhost/smartbk/app-ortu/public/test\n";
    if ($invitation) {
        echo "Demo: http://localhost/smartbk/app-ortu/public/?token=" . $invitation['invitation_token'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
