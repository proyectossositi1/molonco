<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\Session\Session;

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

    protected $empresa_id;
    protected $user_id;
    protected $user_empresa_id;
    
    protected function initUserSessionData(){
        $this->id_empresa           = session('id_empresa');
        $this->id_usuario           = session('id_usuario');
        $this->id_usuario_empresa   = session('id_usuario_empresa');
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->initUserSessionData();
        // Cargamos todas las librerias para heredar a todos los controladores
        helper(['url', 'form', 'cookie']);
        // Varaibles y Funciones globales
        $session = session();
        $cookie = request()->getCookie('remember_token');

        if ($cookie) {
            $data = json_decode(base64_decode($cookie), true);
        
            if (isset($data['id_usuario']) && isset($data['email'])) {
                // Validar si existe el usuario, o iniciar sesión automática                
                $session->set([
                    'id_usuario'         => $data['id_usuario'],
                    'id_usuario_empresa' => $data['id_usuario_empresa'],
                    'id_empresa'    => $data['id_empresa'],
                    'username'      => $data['username'],
                    'email'         => $data['email'],
                    'id_role'       => $data['id_role'],
                    'isLoggedIn'    => true,
                ]);

                // $this->user_id = $session->get('id_usuario');
                // $this->user_empresa_id = $session->get('id_usuario_empresa');
                // Redireccionar si lo deseas
            }
        }

        if($session->get('isLoggedIn')){
            tracker();
        }
        
        

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }
}