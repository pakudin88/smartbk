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
     * Get complete user data for views including profile picture
     * 
     * @return array
     */
    protected function getUserDataForView()
    {
        // Default user data from session
        $userData = [
            'id' => session()->get('user_id') ?? 1,
            'name' => session()->get('username') ?? 'Administrator',
            'full_name' => session()->get('full_name') ?? 'Administrator',
            'username' => session()->get('username') ?? 'admin',
            'role' => session()->get('role_name') ?? 'Super Admin',
            'role_name' => session()->get('role_name') ?? 'Super Admin',
            'profile_picture' => session()->get('profile_picture') ?? null
        ];

        // If user is logged in, try to get complete data from database
        if (session()->get('isLoggedIn') && session()->get('user_id')) {
            try {
                $userModel = new \App\Models\UserModel();
                $fullUserData = $userModel->getUserWithRole(session()->get('user_id'));
                if ($fullUserData) {
                    $userData = array_merge($userData, $fullUserData);
                }
            } catch (\Exception $e) {
                // Continue with session data if database query fails
                log_message('error', 'Failed to get user data: ' . $e->getMessage());
            }
        }

        return $userData;
    }
}
