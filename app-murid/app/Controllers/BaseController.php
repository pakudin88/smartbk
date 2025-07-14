<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * Get current base URL with correct port
     */
    protected function getCurrentBaseUrl()
    {
        $request = \Config\Services::request();
        $protocol = $request->isSecure() ? 'https' : 'http';
        $host = $request->getServer('HTTP_HOST') ?: $request->getServer('SERVER_NAME');
        
        // Fallback jika tidak ada HTTP_HOST
        if (!$host) {
            $host = 'localhost:8080';
        }
        
        return $protocol . '://' . $host;
    }

    /**
     * Create URL with current port
     */
    protected function urlTo($path)
    {
        $baseUrl = $this->getCurrentBaseUrl();
        return $baseUrl . ($path[0] === '/' ? $path : '/' . $path);
    }

    /**
     * Get current URL for views
     */
    protected function getCurrentUrlForView()
    {
        return $this->getCurrentBaseUrl();
    }

    /**
     * Get user data from session and database
     */
    protected function getUserData()
    {
        $session = \Config\Services::session();
        
        if (!$session->get('isLoggedIn')) {
            return null;
        }
        
        // Get basic data from session
        $userData = [
            'id' => $session->get('user_id'),
            'name' => $session->get('name'),
            'username' => $session->get('username'),
            'email' => $session->get('email'),
            'role' => $session->get('role'),
            'role_id' => $session->get('role_id')
        ];
        
        // Try to get additional data from database if needed
        try {
            $db = \Config\Database::connect();
            
            if ($userData['role'] === 'murid' && $userData['id']) {
                // Get data from users table (remote database structure)
                $query = $db->query("SELECT * FROM users WHERE id = ? AND role_id = 4", [$userData['id']]);
                $dbUser = $query->getRow();
                
                if ($dbUser) {
                    $userData = array_merge($userData, [
                        'full_name' => $dbUser->full_name ?? $userData['name'],
                        'kelas_id' => $dbUser->kelas_id ?? null,
                        'tahun_ajaran_id' => $dbUser->tahun_ajaran_id ?? null,
                        'is_active' => $dbUser->is_active ?? 1
                    ]);
                }
            }
        } catch (\Exception $e) {
            // If database connection fails, use session data only
            log_message('error', 'Database connection failed in getUserData: ' . $e->getMessage());
        }
        
        return $userData;
    }
}
