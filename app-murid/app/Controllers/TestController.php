<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestController extends BaseController
{
    public function test()
    {
        echo "Test controller works!";
        exit;
    }
}
