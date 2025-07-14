<?php
echo "=== CONFIG FILES CHECK ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

$config_dir = __DIR__ . '/app/Config';
$required_configs = [
    'App.php',
    'Database.php', 
    'Routes.php',
    'DocTypes.php',
    'Format.php',
    'Validation.php',
    'View.php',
    'Security.php',
    'Mimes.php',
    'Paths.php',
    'Services.php',
    'Autoload.php',
    'Constants.php',
    'Filters.php',
    'Toolbar.php'
];

echo "1. CHECKING REQUIRED CONFIG FILES:\n";
foreach ($required_configs as $config) {
    $path = $config_dir . '/' . $config;
    if (file_exists($path)) {
        echo "   ✓ $config exists\n";
    } else {
        echo "   ✗ $config MISSING\n";
    }
}

echo "\n2. TESTING APPLICATION BOOTSTRAP:\n";

try {
    // Clear any output
    if (ob_get_level()) ob_end_clean();
    
    // Test basic bootstrap
    require_once __DIR__ . '/vendor/autoload.php';
    echo "   ✓ Composer autoload successful\n";
    
    require_once __DIR__ . '/app/Config/Paths.php';
    echo "   ✓ Paths config loaded\n";
    
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/bootstrap.php';
    echo "   ✓ System bootstrap loaded\n";
    
    // Test environment
    require_once SYSTEMPATH . 'Config/DotEnv.php';
    (new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
    echo "   ✓ Environment loaded\n";
    
    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', 'development');
    }
    
    if (! defined('CI_DEBUG')) {
        define('CI_DEBUG', true);
    }
    
    // Test services
    $app = Config\Services::codeigniter();
    echo "   ✓ CodeIgniter service created\n";
    
    $app->initialize();
    echo "   ✓ Application initialized\n";
    
} catch (Throwable $e) {
    echo "   ✗ Bootstrap error: " . $e->getMessage() . "\n";
    echo "   ✗ File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n3. CREATING MISSING CONFIG FILES:\n";

// Check and create missing configs
$missing_configs = [
    'Toolbar.php' => '<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Toolbar extends BaseConfig
{
    public array $collectors = [
        \CodeIgniter\Debug\Toolbar\Collectors\Timers::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Database::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Logs::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Views::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Cache::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Files::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Routes::class,
        \CodeIgniter\Debug\Toolbar\Collectors\Events::class,
    ];

    public int $maxHistory = 20;
    public int $viewsPath = APPPATH . "Views/";
    public int $maxQueries = 100;
}',

    'Filters.php' => '<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        "csrf"          => \CodeIgniter\Filters\CSRF::class,
        "toolbar"       => \CodeIgniter\Filters\DebugToolbar::class,
        "honeypot"      => \CodeIgniter\Filters\Honeypot::class,
        "invalidchars"  => \CodeIgniter\Filters\InvalidChars::class,
        "secureheaders" => \CodeIgniter\Filters\SecureHeaders::class,
    ];

    public array $globals = [
        "before" => [
            // "honeypot",
            // "csrf",
            // "invalidchars",
        ],
        "after" => [
            "toolbar",
            // "honeypot",
            // "secureheaders",
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}',

    'Constants.php' => '<?php

defined("APP_NAMESPACE") || define("APP_NAMESPACE", "App");
defined("CI_DEBUG") || define("CI_DEBUG", true);
defined("EXIT_SUCCESS") || define("EXIT_SUCCESS", 0);
defined("EXIT_ERROR") || define("EXIT_ERROR", 1);
defined("EXIT_CONFIG") || define("EXIT_CONFIG", 3);
defined("EXIT_UNKNOWN_FILE") || define("EXIT_UNKNOWN_FILE", 4);
defined("EXIT_UNKNOWN_CLASS") || define("EXIT_UNKNOWN_CLASS", 5);
defined("EXIT_UNKNOWN_METHOD") || define("EXIT_UNKNOWN_METHOD", 6);
defined("EXIT_USER_INPUT") || define("EXIT_USER_INPUT", 7);
defined("EXIT_DATABASE") || define("EXIT_DATABASE", 8);
'
];

foreach ($missing_configs as $filename => $content) {
    $path = $config_dir . '/' . $filename;
    if (!file_exists($path)) {
        file_put_contents($path, $content);
        echo "   ✓ Created $filename\n";
    } else {
        echo "   - $filename already exists\n";
    }
}

echo "\n=== CHECK COMPLETED ===\n";
