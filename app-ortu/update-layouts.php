<?php
// Update all view files to use modern layout

echo "=== UPDATING VIEW FILES TO MODERN LAYOUT ===\n";

$viewFiles = [
    'app/Views/invitation/access.php',
    'app/Views/invitation/invalid.php',
    'app/Views/invitation/error.php',
    'app/Views/partnership/summary.php',
    'app/Views/partnership/progress.php',
    'app/Views/test_page.php'
];

foreach ($viewFiles as $file) {
    $fullPath = __DIR__ . '/' . $file;
    
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        
        // Replace layout reference
        $updatedContent = str_replace(
            "<?= \$this->extend('layouts/partnership_layout') ?>",
            "<?= \$this->extend('layouts/modern_layout') ?>",
            $content
        );
        
        if ($content !== $updatedContent) {
            file_put_contents($fullPath, $updatedContent);
            echo "✓ Updated: $file\n";
        } else {
            echo "- No change needed: $file\n";
        }
    } else {
        echo "✗ File not found: $file\n";
    }
}

echo "\n=== UPDATE COMPLETE ===\n";
echo "All view files now use modern_layout!\n";
?>
