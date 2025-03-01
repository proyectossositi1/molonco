<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\RoleRutaModel;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = session()->get('usuario');
        $currentRoute = $request->uri->getPath();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión.');
        }

        $userRoles = session()->get('roles');

        $roleRutaModel = new RoleRutaModel();
        $allowedRoutes = $roleRutaModel->select('rutas.url')
            ->join('rutas', 'roles_rutas.ruta_id = rutas.id')
            ->whereIn('rol_id', $userRoles)
            ->findAll();

        $allowedUrls = array_column($allowedRoutes, 'url');

        if (!in_array($currentRoute, $allowedUrls)) {
            return redirect()->to('/dashboard')->with('error', 'No tienes permiso para acceder.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada por ahora
    }
}