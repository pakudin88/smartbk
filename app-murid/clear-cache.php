<?php

// Define the path to the cache directory
$cachePath = __DIR__ . '/writable/cache/';

echo "Attempting to clear cache at: {$cachePath}\n\n";

// Check if the cache directory exists
if (!is_dir($cachePath)) {
    echo "Cache directory not found. Nothing to clear.\n";
    exit;
}

// Recursively delete all files and subdirectories
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($cachePath, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
);

$success = true;
foreach ($files as $fileinfo) {
    $path = $fileinfo->getRealPath();
    if ($fileinfo->isDir()) {
        if (rmdir($path)) {
            echo "Removed directory: {$path}\n";
        } else {
            echo "ERROR: Failed to remove directory: {$path}\n";
            $success = false;
        }
    } else {
        if (unlink($path)) {
            echo "Deleted file: {$path}\n";
        } else {
            echo "ERROR: Failed to delete file: {$path}\n";
            $success = false;
        }
    }
}

echo "\nCache clearing process finished.\n";
if ($success) {
    echo "SUCCESS: Cache cleared successfully.\n";
} else {
    echo "FAILURE: Some files or directories could not be removed.\n";
}