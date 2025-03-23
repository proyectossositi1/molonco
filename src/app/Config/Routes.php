<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ✅ Rutas Públicas (sin middleware)
$routes->group('', ['filter' => 'noauth'], function($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/login', 'AuthController::login');
    $routes->post('/login', 'AuthController::process_login');
    $routes->get('/register', 'AuthController::register');
    $routes->post('/register', 'AuthController::process_register');
    // Olvidé contraseña
    $routes->get('/forgot-password', 'AuthController::forgot_password');
    $routes->post('/forgot-password', 'AuthController::proccess_forgot_password');

    // Restablecer contraseña
    $routes->get('/reset-password', 'AuthController::show_reset_form');
    $routes->post('/reset-password', 'AuthController::reset_password');
    $routes->post('/sendmail', 'AuthController::enviar_correo');


    $routes->get('/email', 'AuthController::enviar_correo');
});


// Rutas Protegidas (con middleware 'auth')
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/logout', 'AuthController::logout');
});


$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // ROLES
    $routes->get('roles/', 'RoleController::index');
    $routes->post('roles/store', 'RoleController::store');
    $routes->post('roles/edit', 'RoleController::edit');
    $routes->post('roles/destroy', 'RoleController::destroy'); 
    // ASIGNACION DE ROLES A MENUS
    $routes->get('roles/asignar', 'RoleController::index_assignRoles');
    $routes->post('roles/asignar/store', 'RoleController::store_roleAssignment');
    $routes->post('roles/asignar/destroy', 'RoleController::destroy_roleAssignment');  
    // PERMISOS
    $routes->get('permisos/', 'PermissionController::index');
    $routes->post('permisos/store', 'PermissionController::store');
    $routes->post('permisos/edit', 'PermissionController::edit');
    $routes->post('permisos/destroy', 'PermissionController::destroy');  
    // RUTAS
    $routes->get('routes/', 'RouteController::index');
    $routes->post('routes/store', 'RouteController::store');
    $routes->post('routes/edit', 'RouteController::edit');
    $routes->post('routes/destroy', 'RouteController::destroy');    
    // ASIGNACION DE RUTAS A ROLES
    $routes->get('routes/asignar', 'RouteController::index_assignRoles');
    $routes->post('routes/asignar/store', 'RouteController::store_roleAssignment');
    $routes->post('routes/asignar/destroy', 'RouteController::destroy_roleAssignment');
    // MENUS
    $routes->get('menus/', 'MenuController::index');
    $routes->post('menus/store', 'MenuController::store');
    $routes->post('menus/edit', 'MenuController::edit');
    $routes->post('menus/destroy', 'MenuController::destroy'); 
    // USERS
    $routes->get('users/', 'UserController::index');
    $routes->post('users/store', 'UserController::store');
    $routes->post('users/edit', 'UserController::edit');
    $routes->post('users/destroy', 'UserController::destroy'); 
});

$routes->group('catalogos', ['filter' => 'auth'], function($routes) {
    // EMPRESAS
    $routes->get('empresas/', 'CatEmpresaController::index');
    $routes->post('empresas/store', 'CatEmpresaController::store');
    $routes->post('empresas/edit', 'CatEmpresaController::edit');
    $routes->post('empresas/destroy', 'CatEmpresaController::destroy'); 
     // ORGANIZACIONES
    $routes->get('organizaciones/', 'CatOrganizacionController::index');
    $routes->post('organizaciones/store', 'CatOrganizacionController::store');
    $routes->post('organizaciones/edit', 'CatOrganizacionController::edit');
    $routes->post('organizaciones/destroy', 'CatOrganizacionController::destroy'); 
     // CLIETNES
    $routes->get('clientes/', 'ClienteController::index');
    $routes->post('clientes/store', 'ClienteController::store');
    $routes->post('clientes/edit', 'ClienteController::edit');
    $routes->post('clientes/destroy', 'ClienteController::destroy'); 
    // PRODUCTOS
    $routes->get('productos/', 'CatProductoController::index');
    $routes->post('productos/store', 'CatProductoController::store');
    $routes->post('productos/edit', 'CatProductoController::edit');
    $routes->post('productos/destroy', 'CatProductoController::destroy'); 
    // TIPO DE PAGOS
    $routes->get('tipopagos/', 'CatTipoPagoController::index');
    $routes->post('tipopagos/store', 'CatTipoPagoController::store');
    $routes->post('tipopagos/edit', 'CatTipoPagoController::edit');
    $routes->post('tipopagos/destroy', 'CatTipoPagoController::destroy'); 
    // SERVICIOS
    $routes->get('servicios/', 'CatServicioController::index');
    $routes->post('servicios/store', 'CatServicioController::store');
    $routes->post('servicios/edit', 'CatServicioController::edit');
    $routes->post('servicios/destroy', 'CatServicioController::destroy'); 
});

// Rutas protegidas para Administradores
// $routes->group('admin', ['filter' => 'role:admin'], function($routes) {
//     $routes->get('usuarios', 'Admin::usuarios');
//     $routes->get('reportes', 'Admin::reportes');
// });

// Rutas protegidas para Editores
// $routes->group('editor', ['filter' => 'role:editor,admin'], function($routes) {
//     $routes->get('publicaciones', 'Editor::publicaciones');
// });


// ✅ Ruta Fallback (404)
$routes->set404Override(function() {
    return view('errors/404');
});