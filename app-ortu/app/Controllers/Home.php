<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return 'App-Ortu is working! Welcome to Jendela Kemitraan. Time: ' . date('Y-m-d H:i:s');
    }
    
    public function test()
    {
        $data = [
            'status' => 'OK',
            'message' => 'App-Ortu Test Successful',
            'timestamp' => date('Y-m-d H:i:s'),
            'environment' => ENVIRONMENT,
            'debug' => CI_DEBUG ? 'enabled' : 'disabled',
            'php_version' => PHP_VERSION,
            'codeigniter_version' => \CodeIgniter\CodeIgniter::CI_VERSION
        ];
        
        return $this->response->setJSON($data);
    }
}
