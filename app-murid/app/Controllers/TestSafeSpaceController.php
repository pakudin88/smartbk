<?php

namespace App\Controllers;

class TestSafeSpaceController extends BaseController
{
    public function index()
    {
        echo "<h1>Test SafeSpace Controller Works!</h1>";
        echo "<p>If you see this, the controller system is working.</p>";
        echo "<a href='/safe-space/konsul-cepat'>Try Konsul Cepat</a>";
    }
    
    public function testKonsul()
    {
        echo "<h1>Test Konsul Method Works!</h1>";
        echo "<p>Controller and method are accessible.</p>";
        echo "<a href='/dashboard'>Back to Dashboard</a>";
    }
}
