<?php
echo "Test Apache Rewrite\n";
echo "RequestURI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "ScriptName: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "PathInfo: " . (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : 'Not set') . "\n";
echo "QueryString: " . $_SERVER['QUERY_STRING'] . "\n";

// Test if mod_rewrite is working
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "mod_rewrite: ENABLED\n";
    } else {
        echo "mod_rewrite: DISABLED\n";
    }
} else {
    echo "apache_get_modules() not available\n";
}
?>
