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
    protected $helpers = ['view_helper', 'tools_helper'];

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
        helper(['url', 'form', 'cookie']);
        $this->session = session();
        $this->user_id = $this->session->get('user_id');
        
        if (!$this->session->get('isLoggedIn') && get_cookie('remember_token')) {
            $userId = base64_decode(get_cookie('remember_token'));
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($userId);
    
            if ($user) {
                $session->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['usr'],
                    'email'     => $user['email'],
                    'isLoggedIn'=> true,
                ]);
            }
        }

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }
}