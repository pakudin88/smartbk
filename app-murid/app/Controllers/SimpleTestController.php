<?php

namespace App\Controllers;

class SimpleTestController extends BaseController
{
    public function index()
    {
        return "SimpleTestController::index() works!";
    }
    
    public function test()
    {
        return "SimpleTestController::test() works!";
    }
}
?>
