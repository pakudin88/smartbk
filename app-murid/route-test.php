<?php
// Simple test script to check route responses
$routes_to_test = [
    'http://localhost:9000/direct-konsul-cepat',
    'http://localhost:9000/safe-space/konsul-cepat',
    'http://localhost:9000/test-konsul',
    'http://localhost:9000/',
    'http://localhost:9000/dashboard'
];

echo "<h2>Route Testing Results</h2>\n";

foreach ($routes_to_test as $url) {
    echo "<h3>Testing: $url</h3>\n";
    
    // Initialize curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HEADER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "<p style='color:red'>CURL Error: $error</p>\n";
    } else {
        $color = ($httpCode == 200) ? 'green' : 'red';
        echo "<p style='color:$color'>HTTP Status: $httpCode</p>\n";
        
        // Extract just the first few lines of response
        $lines = explode("\n", $response);
        $preview = implode("\n", array_slice($lines, 0, 5));
        echo "<pre style='background:#f0f0f0; padding:10px; max-height:100px; overflow:auto'>$preview</pre>\n";
    }
    echo "<hr>\n";
}
?>
