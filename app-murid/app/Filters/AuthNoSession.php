<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthNoSession implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Bypass auth untuk testing - nanti bisa dikembalikan ke session check
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }
        
        // if (session()->get('role') !== 'murid') {
        //     return redirect()->to('/login');
        // }
        
        // Untuk testing, kita bypass filter ini
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }
}
