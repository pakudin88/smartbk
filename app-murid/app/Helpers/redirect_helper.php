<?php

/**
 * Custom redirect helper that maintains current port
 */

if (!function_exists('redirect_with_port')) {
    /**
     * Redirect with current port maintained
     */
    function redirect_with_port($uri = '', $method = 'auto', $code = null)
    {
        // Get current request info
        $request = \Config\Services::request();
        $protocol = $request->isSecure() ? 'https' : 'http';
        $host = $request->getServer('HTTP_HOST') ?: $request->getServer('SERVER_NAME');
        
        // Fallback if no host
        if (!$host) {
            $host = 'localhost:8080';
        }
        
        $baseUrl = $protocol . '://' . $host;
        
        // Ensure URI starts with /
        if ($uri && $uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        
        $fullUrl = $baseUrl . $uri;
        
        // Use CodeIgniter's redirect service
        $redirectResponse = \Config\Services::redirectresponse();
        return $redirectResponse->to($fullUrl, $code, $method);
    }
}

if (!function_exists('current_base_url')) {
    /**
     * Get current base URL with port
     */
    function current_base_url()
    {
        $request = \Config\Services::request();
        $protocol = $request->isSecure() ? 'https' : 'http';
        $host = $request->getServer('HTTP_HOST') ?: $request->getServer('SERVER_NAME');
        
        if (!$host) {
            $host = 'localhost:8080';
        }
        
        return $protocol . '://' . $host . '/';
    }
}
