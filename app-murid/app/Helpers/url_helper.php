<?php

if (!function_exists('redirect_with_port')) {
    function redirect_with_port($uri = '')
    {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $port = $_SERVER['SERVER_PORT'] ?? '80';
        
        // Get hostname without port
        $host = $_SERVER['SERVER_NAME'] ?? 'localhost';
        if (isset($_SERVER['HTTP_HOST'])) {
            $hostParts = explode(':', $_SERVER['HTTP_HOST']);
            $host = $hostParts[0];
        }
        
        // Dynamic URL based on server configuration
        if ($port == '8080') {
            $baseURL = $protocol . '://' . $host . ':8080';
        } elseif ($port == '80' && $protocol == 'http') {
            $baseURL = $protocol . '://' . $host . '/simaklah-main/app-murid/public';
        } elseif ($port == '443' && $protocol == 'https') {
            $baseURL = $protocol . '://' . $host . '/simaklah-main/app-murid/public';
        } else {
            $baseURL = $protocol . '://' . $host . ':' . $port . '/simaklah-main/app-murid/public';
        }
        
        return redirect()->to($baseURL . $uri);
    }
}

if (!function_exists('get_current_url_for_view')) {
    function get_current_url_for_view()
    {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $port = $_SERVER['SERVER_PORT'] ?? '80';
        
        // Get hostname without port
        $host = $_SERVER['SERVER_NAME'] ?? 'localhost';
        if (isset($_SERVER['HTTP_HOST'])) {
            $hostParts = explode(':', $_SERVER['HTTP_HOST']);
            $host = $hostParts[0];
        }
        
        // Dynamic URL based on server configuration
        if ($port == '8080') {
            return $protocol . '://' . $host . ':8080';
        } elseif ($port == '80' && $protocol == 'http') {
            return $protocol . '://' . $host . '/simaklah-main/app-murid/public';
        } elseif ($port == '443' && $protocol == 'https') {
            return $protocol . '://' . $host . '/simaklah-main/app-murid/public';
        } else {
            return $protocol . '://' . $host . ':' . $port . '/simaklah-main/app-murid/public';
        }
    }
}
