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
    $routes->post('roles/update', 'RoleController::update');
    $routes->post('roles/edit', 'RoleController::edit');
    $routes->post('roles/destroy', 'RoleController::destroy'); 
    // ASIGNACION DE ROLES A MENUS
    $routes->get('roles/asignar', 'RoleController::index_assignRoles');
    $routes->post('roles/asignar/store', 'RoleController::store_roleAssignment');
    $routes->post('roles/asignar/destroy', 'RoleController::destroy_roleAssignment');  
    // PERMISOS
    $routes->get('permisos/', 'PermissionController::index');
    $routes->post('permisos/store', 'PermissionController::store');
    $routes->post('permisos/update', 'PermissionController::update');
    $routes->post('permisos/edit', 'PermissionController::edit');
    $routes->post('permisos/destroy', 'PermissionController::destroy');  
    // RUTAS
    $routes->get('routes/', 'RouteController::index');
    $routes->post('routes/store', 'RouteController::store');
    $routes->post('routes/edit', 'RouteController::edit');
    $routes->post('routes/destroy', 'RouteController::destroy');    
    // RUTAS - AJAX
    $routes->post('routes/ajax_empresas_menu', 'RouteController::ajax_empresas_menu');    
    // ASIGNACION DE RUTAS A ROLES
    $routes->get('routes/asignar', 'RouteController::index_assignRoles');
    $routes->post('routes/asignar/store', 'RouteController::store_roleAssignment');
    $routes->post('routes/asignar/destroy', 'RouteController::destroy_roleAssignment');
    // MENUS
    $routes->get('menus/', 'MenuController::index');
    $routes->post('menus/store', 'MenuController::store');
    $routes->post('menus/update', 'MenuController::update');
    $routes->post('menus/edit', 'MenuController::edit');
    $routes->post('menus/destroy', 'MenuController::destroy'); 
    // USERS
    $routes->get('users/', 'UserController::index');
    $routes->post('users/store', 'UserController::store');
    $routes->post('users/update', 'UserController::update');
    $routes->post('users/edit', 'UserController::edit');
    $routes->post('users/destroy', 'UserController::destroy'); 
});

$routes->group('catalogos', ['filter' => 'auth'], function($routes) {
    // EMPRESAS
    $routes->get('empresas/', 'CatEmpresaController::index');
    $routes->post('empresas/store', 'CatEmpresaController::store');
    $routes->post('empresas/update', 'CatEmpresaController::update');
    $routes->post('empresas/edit', 'CatEmpresaController::edit');
    $routes->post('empresas/destroy', 'CatEmpresaController::destroy'); 
     // CLIETNES
    $routes->get('clientes/', 'ClienteController::index');
    $routes->post('clientes/store', 'ClienteController::store');
    $routes->post('clientes/update', 'ClienteController::update');
    $routes->post('clientes/edit', 'ClienteController::edit');
    $routes->post('clientes/destroy', 'ClienteController::destroy'); 
    // TIPO DE PAGOS
    $routes->get('tipopagos/', 'CatTipoPagoController::index');
    $routes->post('tipopagos/store', 'CatTipoPagoController::store');
    $routes->post('tipopagos/update', 'CatTipoPagoController::update');
    $routes->post('tipopagos/edit', 'CatTipoPagoController::edit');
    $routes->post('tipopagos/destroy', 'CatTipoPagoController::destroy'); 
    // SERVICIOS
    $routes->get('servicios/', 'CatServicioController::index');
    $routes->post('servicios/store', 'CatServicioController::store');
    $routes->post('servicios/update', 'CatServicioController::update');
    $routes->post('servicios/edit', 'CatServicioController::edit');
    $routes->post('servicios/destroy', 'CatServicioController::destroy'); 
    // PRODUCTOS
    $routes->get('productos/', 'CatProductoController::index');
    $routes->post('productos/store', 'CatProductoController::store');
    $routes->post('productos/update', 'CatProductoController::update');
    $routes->post('productos/edit', 'CatProductoController::edit');
    $routes->post('productos/destroy', 'CatProductoController::destroy'); 
    // PRODUCTOS - AJAX
    $routes->post('productos/ajax_refresh_table', 'CatProductoController::ajax_refresh_table');     
    $routes->post('productos/ajax_onchange_categorias', 'CatProductoController::ajax_onchange_categorias');     
    
    // PRODUCTOS - CATEGORIAS
    // $routes->get('productos/categorias/', 'CatProductoCategoriaController::index');
    $routes->post('productos/categorias/store', 'CatProductoCategoriaController::store');
    $routes->post('productos/categorias/update', 'CatProductoCategoriaController::update');
    $routes->post('productos/categorias/edit', 'CatProductoCategoriaController::edit');
    $routes->post('productos/categorias/destroy', 'CatProductoCategoriaController::destroy'); 
    // PRODUCTOS - CATEGORIAS - AJAX
    $routes->post('productos/categorias/ajax_refresh_table', 'CatProductoCategoriaController::ajax_refresh_table');     
    // PRODUCTOS - SUBCATEGORIAS
    // $routes->get('productos/subcategorias/', 'CatProductoSubcategoriaController::index');
    $routes->post('productos/subcategorias/store', 'CatProductoSubcategoriaController::store');
    $routes->post('productos/subcategorias/update', 'CatProductoSubcategoriaController::update');
    $routes->post('productos/subcategorias/edit', 'CatProductoSubcategoriaController::edit');
    $routes->post('productos/subcategorias/destroy', 'CatProductoSubcategoriaController::destroy');
    // PRODUCTOS - SUBCATEGORIAS - AJAX
    $routes->post('productos/subcategorias/ajax_refresh_table', 'CatProductoSubcategoriaController::ajax_refresh_table');     
    // PRODUCTOS - MARCAS
    // $routes->get('productos/marcas/', 'CatProductoMarcaController::index');
    $routes->post('productos/marcas/store', 'CatProductoMarcaController::store');
    $routes->post('productos/marcas/update', 'CatProductoMarcaController::update');
    $routes->post('productos/marcas/edit', 'CatProductoMarcaController::edit');
    $routes->post('productos/marcas/destroy', 'CatProductoMarcaController::destroy'); 
    // PRODUCTOS - MARCAS - AJAX
    $routes->post('productos/marcas/ajax_refresh_table', 'CatProductoMarcaController::ajax_refresh_table');     
    // PRODUCTOS - TIPOS
    // $routes->get('productos/tipos/', 'CatProductoTipoController::index');
    $routes->post('productos/tipos/store', 'CatProductoTipoController::store');
    $routes->post('productos/tipos/update', 'CatProductoTipoController::update');
    $routes->post('productos/tipos/edit', 'CatProductoTipoController::edit');
    $routes->post('productos/tipos/destroy', 'CatProductoTipoController::destroy'); 
    // PRODUCTOS - TIPOS - AJAX
    $routes->post('productos/tipos/ajax_refresh_table', 'CatProductoTipoController::ajax_refresh_table');     
     // PRODUCTOS - PRECIOS
    // $routes->get('productos/precios/', 'CatProductoPrecioController::index');
    $routes->post('productos/precios/store', 'CatProductoPrecioController::store');
    $routes->post('productos/precios/update', 'CatProductoPrecioController::update');
    $routes->post('productos/precios/edit', 'CatProductoPrecioController::edit');
    $routes->post('productos/precios/destroy', 'CatProductoPrecioController::destroy'); 
    // PRODUCTOS - PREICOS - AJAX
    $routes->post('productos/precios/ajax_refresh_table', 'CatProductoPrecioController::ajax_refresh_table'); 
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