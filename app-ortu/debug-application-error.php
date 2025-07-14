<?php
echo "=== DEBUGGING APPLICATION ERROR ===\n";

try {
    // Set up proper environment
    putenv('CI_ENVIRONMENT=development');
    
    // Set up web server environment
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['SCRIPT_NAME'] = '/simaklah-main/app-ortu/public/index.php';
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    $_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';
    $_SERVER['SERVER_PORT'] = '80';
    $_SERVER['HTTPS'] = '';
    
    chdir(__DIR__ . '/public');
    
    // Define FCPATH
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
    }
    
    echo "1. Loading CodeIgniter bootstrap...\n";
    require_once FCPATH . '../app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    
    echo "2. Loading environment...\n";
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
    }
    
    echo "3. Testing database connection...\n";
    try {
        $db = \Config\Database::connect();
        // Test with a simple query instead of checking connID
        $result = $db->query("SELECT 1 as test");
        if ($result) {
            echo "   ✓ Database connection successful\n";
        } else {
            echo "   ✗ Database query failed\n";
        }
    } catch (Exception $e) {
        echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
    }
    
    echo "4. Testing controller and routing...\n";
    
    // Get router and try to determine the route
    $router = \Config\Services::router();
    $request = \Config\Services::request();
    
    echo "   Request URI: " . $request->getUri() . "\n";
    
    // Try to manually instantiate the Partnership controller
    echo "5. Testing Partnership controller directly...\n";
    
    // First check if we can create a basic response
    $response = \Config\Services::response();
    echo "   ✓ Response service created\n";
    
    // Try to load the controller
    try {
        // Don't instantiate yet, just check if class exists
        if (class_exists('App\Controllers\Partnership')) {
            echo "   ✓ Partnership controller class exists\n";
            
            // Check if the index method exists
            $reflection = new ReflectionClass('App\Controllers\Partnership');
            if ($reflection->hasMethod('index')) {
                echo "   ✓ index method exists\n";
            } else {
                echo "   ✗ index method not found\n";
            }
            
        } else {
            echo "   ✗ Partnership controller class not found\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ Error checking controller: " . $e->getMessage() . "\n";
    }
    
    echo "\n6. Checking view files...\n";
    $viewPath = APPPATH . 'Views/invitation/access.php';
    if (file_exists($viewPath)) {
        echo "   ✓ View file exists: invitation/access.php\n";
    } else {
        echo "   ✗ View file missing: invitation/access.php\n";
    }
    
    $layoutPath = APPPATH . 'Views/layouts/partnership_layout.php';
    if (file_exists($layoutPath)) {
        echo "   ✓ Layout file exists: layouts/partnership_layout.php\n";
    } else {
        echo "   ✗ Layout file missing: layouts/partnership_layout.php\n";
    }
    
    echo "\n7. Checking writable directory...\n";
    $logPath = WRITEPATH . 'logs';
    if (is_dir($logPath)) {
        echo "   ✓ Logs directory exists\n";
        if (is_writable($logPath)) {
            echo "   ✓ Logs directory is writable\n";
        } else {
            echo "   ✗ Logs directory not writable\n";
        }
    } else {
        echo "   ✗ Logs directory missing\n";
    }
    
    // Check for any log files
    $logFiles = glob($logPath . '/*.log');
    if (!empty($logFiles)) {
        echo "   📋 Found " . count($logFiles) . " log file(s)\n";
        $latestLog = end($logFiles);
        echo "   📋 Latest log: " . basename($latestLog) . "\n";
        
        // Read last few lines of the log
        $logContent = file_get_contents($latestLog);
        $lines = explode("\n", $logContent);
        $lastLines = array_slice($lines, -10);
        echo "   📋 Last 10 lines of log:\n";
        foreach ($lastLines as $line) {
            if (trim($line)) {
                echo "      " . $line . "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
