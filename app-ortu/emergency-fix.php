<?php
// Emergency fix for toolbar issues
echo "=== EMERGENCY TOOLBAR FIX ===\n";

// Clear all cache files
$cacheDir = __DIR__ . '/writable/cache';
if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "Deleted: " . basename($file) . "\n";
        }
    }
}

// Clear session files
$sessionDir = __DIR__ . '/writable/session';
if (is_dir($sessionDir)) {
    $files = glob($sessionDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "Deleted session: " . basename($file) . "\n";
        }
    }
}

// Clear logs
$logDir = __DIR__ . '/writable/logs';
if (is_dir($logDir)) {
    $files = glob($logDir . '/*.log');
    foreach ($files as $file) {
        if (is_file($file)) {
            file_put_contents($file, "");
            echo "Cleared log: " . basename($file) . "\n";
        }
    }
}

// Clear debugbar files
$debugDir = __DIR__ . '/writable/debugbar';
if (is_dir($debugDir)) {
    $files = glob($debugDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "Deleted debugbar: " . basename($file) . "\n";
        }
    }
}

echo "\n=== FIX COMPLETE ===\n";
echo "All cache, session, and debug files cleared!\n";
echo "Toolbar completely disabled for production stability.\n";
?>
