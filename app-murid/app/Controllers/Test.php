<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Test extends BaseController
{
    public function index()
    {
        return view('test_simple');
    }
    
    public function simple()
    {
        return view('test_simple');
    }
    
    public function info()
    {
        phpinfo();
    }
}
