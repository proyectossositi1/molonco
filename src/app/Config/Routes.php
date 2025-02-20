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

// ✅ Rutas Protegidas (con middleware 'auth')
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/logout', 'AuthController::logout');
});

$routes->group('routes', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'RouteController::index');
    $routes->post('store', 'RouteController::store');
    $routes->post('edit', 'RouteController::edit');
    $routes->post('destroy', 'RouteController::destroy');    
    $routes->get('asignar', 'RouteController::assignRoles');
    $routes->post('asignar/store', 'RouteController::storeRoleAssignment');
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