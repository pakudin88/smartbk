<?php

// The URL to test, based on the screenshot
$url = 'http://localhost:8080/safe-space/konsul-cepat';

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Execute the request
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

// Close cURL
curl_close($ch);

// Output the results
echo "--- Testing URL: $url ---\n\n";

if ($error) {
    echo "cURL Error: " . $error . "\n";
} else {
    echo "HTTP Status Code: " . $http_code . "\n";
    echo "Response Body:\n";
    echo "------------------\n";
    echo $response . "\n";
    echo "------------------\n";
}

if ($http_code === 200 && strpos($response, 'Konsul Cepat Works!') !== false) {
    echo "\nSUCCESS: The route is working correctly and returns the expected content.\n";
} else {
    echo "\nFAILURE: The route is not working as expected. Please check the server is running and the routes are correct.\n";
}
