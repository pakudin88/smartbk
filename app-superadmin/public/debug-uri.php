<?php
echo "<h2>Debug URI String</h2>";
echo "<p>Current URI: <strong>" . uri_string() . "</strong></p>";
echo "<p>Base URL: <strong>" . base_url() . "</strong></p>";
echo "<p>Current URL: <strong>" . current_url() . "</strong></p>";

// Test conditions
$uri = uri_string();
echo "<h3>Menu Active Conditions:</h3>";
echo "<p>Dashboard active: " . ($uri == 'dashboard' ? 'YES' : 'NO') . "</p>";
echo "<p>Users active: " . (strpos($uri, 'users') === 0 ? 'YES' : 'NO') . "</p>";
echo "<p>Schools active: " . (strpos($uri, 'schools') === 0 ? 'YES' : 'NO') . "</p>";

echo "<h3>URL Segments:</h3>";
$segments = explode('/', $uri);
foreach ($segments as $index => $segment) {
    echo "<p>Segment $index: '$segment'</p>";
}
?>
