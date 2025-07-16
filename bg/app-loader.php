<?php
/**
 * Smart BookKeeping - Dynamic App Loader
 * Loads applications dynamically based on folder structure and .env configuration
 * URL Format: /smartbk/app-guru/public (no redirect to ports)
 */

// Function to read .env file and get configuration
function getAppConfig($appPath) {
    $envFile = $appPath . '/.env';
    
    if (!file_exists($envFile)) {
        return null;
    }
    
    $config = [];
    $envContent = file_get_contents($envFile);
    $lines = explode("\n", $envContent);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip comments and empty lines
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        
        // Parse key=value pairs
        if (strpos($line, '=') !== false) {
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                // Remove quotes and trim whitespace
                $value = trim($value, "'\" \t\n\r\0\x0B");
                $config[$key] = $value;
            }
        }
    }
    
    return $config;
}

// Function to proxy request to application server
function proxyToApp($targetUrl, $subPath = '') {
    // Build full target URL
    $fullUrl = rtrim($targetUrl, '/');
    if (!empty($subPath)) {
        $fullUrl .= '/' . ltrim($subPath, '/');
    }
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $fullUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Smart BookKeeping Dynamic Loader',
        CURLOPT_HTTPHEADER => [
            'X-Forwarded-For: ' . ($_SERVER['REMOTE_ADDR'] ?? ''),
            'X-Forwarded-Host: ' . ($_SERVER['HTTP_HOST'] ?? ''),
            'X-Original-URL: ' . ($_SERVER['REQUEST_URI'] ?? '')
        ]
    ]);
    
    // Forward original request method and data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
    }
    
    // Execute request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    // Check for errors
    if ($response === false || !empty($error)) {
        return false;
    }
    
    // Forward response headers
    if ($contentType) {
        header('Content-Type: ' . $contentType);
    }
    
    http_response_code($httpCode);
    
    // Return response content
    return $response;
}

// Get the requested app and subpath
$appName = $_GET['app'] ?? '';
$subPath = $_GET['subpath'] ?? '';

// Validate app name
$validApps = ['app-guru', 'app-ortu', 'app-superadmin'];
if (!in_array($appName, $validApps)) {
    // Invalid app, show main portal
    include __DIR__ . '/index.html';
    exit;
}

$appPath = __DIR__ . '/' . $appName;

// Check if app directory exists
if (!is_dir($appPath)) {
    include __DIR__ . '/error-app-not-found.html';
    exit;
}

// Get app configuration
$config = getAppConfig($appPath);

if (!$config || !isset($config['app.baseURL'])) {
    // Show error page if configuration not found
    $GLOBALS['error_app'] = $appName;
    include __DIR__ . '/error-config.html';
    exit;
}

$baseUrl = $config['app.baseURL'];

// Try to proxy the request to the application
$response = proxyToApp($baseUrl, $subPath);

if ($response === false) {
    // Show server not running page
    $GLOBALS['error_app'] = $appName;
    $GLOBALS['target_url'] = $baseUrl;
    
    // Debug: show detailed error information
    echo '<div style="background:#fee;padding:20px;margin:20px;border-radius:8px;">';
    echo '<h3>🔧 Debug Information</h3>';
    echo '<p><strong>App:</strong> ' . htmlspecialchars($appName) . '</p>';
    echo '<p><strong>Target URL:</strong> ' . htmlspecialchars($baseUrl) . '</p>';
    echo '<p><strong>Sub Path:</strong> ' . htmlspecialchars($subPath) . '</p>';
    echo '<p><strong>Status:</strong> Server not responding</p>';
    echo '<p><strong>Expected Server:</strong> Start server with <code>cd ' . $appName . ' && php spark serve --port=' . (strpos($baseUrl, '8081') ? '8081' : '8080') . '</code></p>';
    echo '</div>';
    
    include __DIR__ . '/error-server.html';
    exit;
}

// Output the response
echo $response;
?>
