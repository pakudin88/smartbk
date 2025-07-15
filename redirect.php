<?php
/**
 * Smart BookKeeping - Dynamic Redirect Handler
 * Handles dynamic redirection based on application configuration
 */

// Function to read .env file and get baseURL
function getBaseUrlFromEnv($appPath) {
    $envFile = $appPath . '/.env';
    
    if (!file_exists($envFile)) {
        return null;
    }
    
    $envContent = file_get_contents($envFile);
    $lines = explode("\n", $envContent);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip comments and empty lines
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        
        // Look for app.baseURL
        if (strpos($line, 'app.baseURL') === 0) {
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $baseUrl = trim($parts[1]);
                // Remove quotes
                $baseUrl = trim($baseUrl, "'\"");
                return $baseUrl;
            }
        }
    }
    
    return null;
}

// Function to check if server is running on a port
function isServerRunning($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode !== 0;
}

// Get the requested path
$requestPath = $_GET['path'] ?? '';
$appPath = '';
$appName = '';

// Determine which app based on path
switch ($requestPath) {
    case 'guru':
    case 'teacher':
    case 'app-guru':
        $appPath = __DIR__ . '/app-guru';
        $appName = 'Portal Guru';
        break;
        
    case 'ortu':
    case 'parent':
    case 'app-ortu':
        $appPath = __DIR__ . '/app-ortu';
        $appName = 'Portal Orang Tua';
        break;
        
    case 'admin':
    case 'superadmin':
    case 'app-superadmin':
        $appPath = __DIR__ . '/app-superadmin';
        $appName = 'Portal Super Admin';
        break;
        
    default:
        // Invalid path, redirect to main portal
        header('Location: /smartbk/');
        exit;
}

// Get dynamic baseURL from app's .env file
$baseUrl = getBaseUrlFromEnv($appPath);

if (!$baseUrl) {
    // Fallback to default ports if .env not found
    $fallbackUrls = [
        'app-guru' => 'http://localhost:8081',
        'app-ortu' => 'http://localhost:8080',
        'app-superadmin' => 'http://localhost:8082'
    ];
    
    $appDir = basename($appPath);
    $baseUrl = $fallbackUrls[$appDir] ?? 'http://localhost:8080';
}

// Check if the server is running
$isRunning = isServerRunning($baseUrl);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect - <?= htmlspecialchars($appName) ?> | Smart BookKeeping</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .redirect-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }
        
        .app-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .redirect-title {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .redirect-info {
            color: #718096;
            margin-bottom: 20px;
        }
        
        .status-box {
            background: #f7fafc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .status-success {
            border-left: 4px solid #48bb78;
        }
        
        .status-error {
            border-left: 4px solid #e53e3e;
        }
        
        .countdown {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin: 10px 0;
        }
        
        .btn-action {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 5px;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #718096, #4a5568);
        }
        
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .tech-info {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin: 20px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="redirect-container">
        <div class="app-icon">
            <i class="fas fa-<?= $requestPath === 'guru' || $requestPath === 'teacher' ? 'chalkboard-teacher' : ($requestPath === 'ortu' || $requestPath === 'parent' ? 'users' : 'user-shield') ?>"></i>
        </div>
        
        <h1 class="redirect-title"><?= htmlspecialchars($appName) ?></h1>
        <p class="redirect-info">Mengarahkan ke aplikasi...</p>
        
        <?php if ($isRunning): ?>
            <div class="status-box status-success">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong>Server Status:</strong> Running ✅<br>
                <small>Target URL: <code><?= htmlspecialchars($baseUrl) ?></code></small>
            </div>
            
            <div class="loading-spinner"></div>
            
            <p>Redirect otomatis dalam <span class="countdown" id="countdown">3</span> detik...</p>
            
            <div class="mt-3">
                <a href="<?= htmlspecialchars($baseUrl) ?>" class="btn-action">
                    <i class="fas fa-external-link-alt"></i>
                    Lanjutkan Manual
                </a>
            </div>
            
            <script>
                let count = 3;
                const countdownElement = document.getElementById('countdown');
                
                const timer = setInterval(() => {
                    count--;
                    if (countdownElement) {
                        countdownElement.textContent = count;
                    }
                    
                    if (count <= 0) {
                        clearInterval(timer);
                        window.location.href = '<?= htmlspecialchars($baseUrl) ?>';
                    }
                }, 1000);
            </script>
            
        <?php else: ?>
            <div class="status-box status-error">
                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                <strong>Server Status:</strong> Not Running ❌<br>
                <small>Target URL: <code><?= htmlspecialchars($baseUrl) ?></code></small>
            </div>
            
            <div class="alert alert-warning">
                <i class="fas fa-info-circle me-2"></i>
                Server belum berjalan. Silakan start server terlebih dahulu.
            </div>
            
            <div class="tech-info">
                <strong>Command untuk start server:</strong><br>
                cd <?= basename($appPath) ?><br>
                php spark serve --port=<?= parse_url($baseUrl, PHP_URL_PORT) ?>
            </div>
            
            <div class="mt-3">
                <a href="javascript:location.reload()" class="btn-action">
                    <i class="fas fa-redo"></i>
                    Refresh Status
                </a>
                <a href="/smartbk/" class="btn-action btn-secondary">
                    <i class="fas fa-home"></i>
                    Kembali ke Portal
                </a>
            </div>
        <?php endif; ?>
        
        <div class="mt-4">
            <small class="text-muted">
                <i class="fas fa-cog me-1"></i>
                Dynamic redirect berdasarkan konfigurasi .env
            </small>
        </div>
    </div>
</body>
</html>
