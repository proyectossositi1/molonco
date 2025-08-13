<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\RoleModel;
use CodeIgniter\Session\Session;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('id_role');
        $userLoggedIn = $session->get('isLoggedIn');
        $userId = $this->user_id = $session->get('id_usuario');
        // $userEmpresaId = $this->user_empresa_id = $session->get('id_usuario_empresa');
        // $empresaId = $this->empresa_id = $session->get('id_empresa');
        $username = $this->username = $session->get('username');

        if (!$userLoggedIn) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión.');
        }

        if (!$userRole) {
            return redirect()->to('/login')->with('error', 'Acceso denegado.');
        }

        // $userRoute = new UserRouteModel();
        // $currentController = service('router')->controllerName();
        // $currentController = str_replace('\App\Controllers\\', '', $currentController);
        // $currentMethod = service('router')->methodName();
        // CREAMOS UN ARREGLO DE LOS CONTROLADORES DONDE TODOS LOS USUARIOS TENDRAN PERMISOS
        // $array_controller = ['DashboardController', 'RouteController'];
        // if(in_array($currentController, $array_controller)){
        //     $permiso = true;
        // }else{
        //     // VERIFICAMOS QUE PERMISOS TIENE EL USUARIO, RESPECTO A LA NAVEGACION
        //     $permiso = $userRoute
        //         ->join('sys_routes', 'sys_routes.id = sys_user_routes.route_id')
        //         ->where('sys_routes.controller', $currentController)
        //         ->where('sys_routes.method', $currentMethod)
        //         ->first();
        // }

        // if (!$permiso) {
        //     return redirect()->to('/dashboard')->with('error', 'No tienes permiso para acceder aquí.');
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacemos nada aquí
    }
}