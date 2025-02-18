<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ✅ Rutas Públicas (sin middleware)
$routes->group('', ['filter' => 'noauth'], function($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/login', 'Auth::login');
    $routes->post('/login', 'Auth::process_login');
    $routes->get('/register', 'Auth::register');
    $routes->post('/register', 'Auth::process_register');
    // Olvidé contraseña
    $routes->get('/forgot-password', 'Auth::forgot_password');
    $routes->post('/forgot-password', 'Auth::proccess_forgot_password');

    // Restablecer contraseña
    $routes->get('/reset-password', 'Auth::show_reset_form');
    $routes->post('/reset-password', 'Auth::reset_password');
    $routes->post('/sendmail', 'Auth::enviar_correo');


    $routes->get('/email', 'Auth::enviar_correo');
});

// ✅ Rutas Protegidas (con middleware 'auth')
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/logout', 'Auth::logout');
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