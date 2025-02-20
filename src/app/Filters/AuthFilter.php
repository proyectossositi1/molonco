<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\PermisoModel;
use App\Models\RoleModel;
use CodeIgniter\Session\Session;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('role_id');

        if (!$userRole) {
            return redirect()->to('/login')->with('error', 'Acceso denegado.');
        }

        $permisosModel = new PermissionModel();
        $currentController = service('router')->controllerName();
        $currentMethod = service('router')->methodName();

        $permiso = $permisosModel
            ->join('sys_user_roles', 'sys_permissions.id = sys_user_roles.permission_id')
            ->where('sys_roles_permissions.role_id', $userRole)
            ->where('sys_permissions.controller', $currentController)
            ->where('sys_permissions.method', $currentMethod)
            ->first();

        if (!$permiso) {
            return redirect()->to('/dashboard')->with('error', 'No tienes permiso para acceder aquí.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacemos nada aquí
    }
}