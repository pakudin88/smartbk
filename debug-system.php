<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug App Loader - SmartBK</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .debug-box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .error { background: #fee; border-left: 4px solid #f00; }
        .success { background: #efe; border-left: 4px solid #0f0; }
        .info { background: #eef; border-left: 4px solid #00f; }
        pre { background: #f8f8f8; padding: 10px; border-radius: 4px; overflow-x: auto; }
        .test-url { color: #0066cc; text-decoration: none; font-weight: bold; }
        .test-url:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>🔧 Debug App Loader System</h1>
    
    <div class="debug-box info">
        <h3>📋 System Status Check</h3>
        <p><strong>Timestamp:</strong> <?= date('Y-m-d H:i:s') ?></p>
        <p><strong>Server:</strong> <?= $_SERVER['SERVER_NAME'] ?? 'Unknown' ?></p>
        <p><strong>Document Root:</strong> <?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></p>
        <p><strong>Current URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'Unknown' ?></p>
    </div>

    <?php
    $smartbkPath = __DIR__;
    $appGuruPath = $smartbkPath . '/app-guru';
    $appOrtuPath = $smartbkPath . '/app-ortu';
    
    // Check directories
    echo '<div class="debug-box">';
    echo '<h3>📁 Directory Structure Check</h3>';
    echo '<p><strong>SmartBK Path:</strong> ' . $smartbkPath . '</p>';
    echo '<p><strong>App-Guru exists:</strong> ' . (is_dir($appGuruPath) ? '✅ Yes' : '❌ No') . '</p>';
    echo '<p><strong>App-Ortu exists:</strong> ' . (is_dir($appOrtuPath) ? '✅ Yes' : '❌ No') . '</p>';
    echo '</div>';
    
    // Check .env files
    echo '<div class="debug-box">';
    echo '<h3>⚙️ .env Configuration Check</h3>';
    
    $appGuruEnv = $appGuruPath . '/.env';
    $appOrtuEnv = $appOrtuPath . '/.env';
    
    echo '<h4>App-Guru .env:</h4>';
    if (file_exists($appGuruEnv)) {
        echo '<p>✅ File exists</p>';
        $envContent = file_get_contents($appGuruEnv);
        if (strpos($envContent, 'app.baseURL') !== false) {
            preg_match("/app\.baseURL\s*=\s*['\"]([^'\"]+)['\"]/", $envContent, $matches);
            if ($matches) {
                echo '<p><strong>Base URL:</strong> ' . $matches[1] . '</p>';
                
                // Test connection
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $matches[1]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);
                
                if ($httpCode === 200) {
                    echo '<p>✅ Server responding (HTTP ' . $httpCode . ')</p>';
                } else {
                    echo '<p>❌ Server not responding (HTTP ' . $httpCode . ')</p>';
                    if ($error) echo '<p>Error: ' . $error . '</p>';
                }
            }
        } else {
            echo '<p>❌ app.baseURL not found</p>';
        }
    } else {
        echo '<p>❌ File not found</p>';
    }
    
    echo '<h4>App-Ortu .env:</h4>';
    if (file_exists($appOrtuEnv)) {
        echo '<p>✅ File exists</p>';
        $envContent = file_get_contents($appOrtuEnv);
        if (strpos($envContent, 'app.baseURL') !== false) {
            preg_match("/app\.baseURL\s*=\s*['\"]([^'\"]+)['\"]/", $envContent, $matches);
            if ($matches) {
                echo '<p><strong>Base URL:</strong> ' . $matches[1] . '</p>';
                
                // Test connection
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $matches[1]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);
                
                if ($httpCode === 200) {
                    echo '<p>✅ Server responding (HTTP ' . $httpCode . ')</p>';
                } else {
                    echo '<p>❌ Server not responding (HTTP ' . $httpCode . ')</p>';
                    if ($error) echo '<p>Error: ' . $error . '</p>';
                }
            }
        } else {
            echo '<p>❌ app.baseURL not found</p>';
        }
    } else {
        echo '<p>❌ File not found</p>';
    }
    echo '</div>';
    
    // Check app-loader.php
    echo '<div class="debug-box">';
    echo '<h3>🔄 App Loader Status</h3>';
    $appLoaderPath = $smartbkPath . '/app-loader.php';
    echo '<p><strong>app-loader.php exists:</strong> ' . (file_exists($appLoaderPath) ? '✅ Yes' : '❌ No') . '</p>';
    echo '</div>';
    
    // Test URLs
    echo '<div class="debug-box">';
    echo '<h3>🔗 Test URLs</h3>';
    echo '<p><a href="/smartbk/app-guru/public" class="test-url" target="_blank">Test App-Guru</a> → /smartbk/app-guru/public</p>';
    echo '<p><a href="/smartbk/app-ortu/public" class="test-url" target="_blank">Test App-Ortu</a> → /smartbk/app-ortu/public</p>';
    echo '<p><a href="/smartbk/app-loader.php?app=app-guru" class="test-url" target="_blank">Direct App-Loader Test (Guru)</a></p>';
    echo '<p><a href="/smartbk/app-loader.php?app=app-ortu" class="test-url" target="_blank">Direct App-Loader Test (Ortu)</a></p>';
    echo '</div>';
    ?>
    
    <div class="debug-box info">
        <h3>📝 Instructions</h3>
        <p>1. Pastikan server berjalan:</p>
        <pre>cd app-guru && php spark serve --port=8081
cd app-ortu && php spark serve --port=8080</pre>
        <p>2. Test direct URLs above</p>
        <p>3. Check if both servers respond correctly</p>
    </div>
</body>
</html>
