<?php 

if (!function_exists('menu')) {
    function menu(): array {
        return [        
            'dashboard' => [
                'role'   => ['super-admin', 'admin'],
                'icono'  => 'fas fa-tachometer-alt',
                'ruta'   => '/dashboard',
                
            ],   
            'administración' => [
                'role'   => ['super-admin'],
                'icono'  => 'fas fa-lock',
                'ruta'   => '#',
                'submenu'   => [
                    [
                        'nombre' => 'Roles',
                        'ruta'   => '/admin/roles',
                        'icono'  => 'fas fa-lock',
                        'role'   => ['super-admin']
                    ],
                    [
                        'nombre' => 'Permisos',
                        'ruta'   => '/admin/permisos',
                        'icono'  => 'fas fa-lock',
                        'role'   => ['super-admin']
                    ],
                    [
                        'nombre' => 'Menu',
                        'ruta'   => '/admin/menus',
                        'icono'  => 'fas fa-lock',
                        'role'   => ['super-admin']
                    ]
                ]
            ],  
            'catalogos' => [
                'role'   => ['super-admin', 'admin'],
                'icono'  => 'fas fa-list',
                'ruta'   => '#',
                'submenu'   => [
                    [
                        'nombre' => 'Empresas',
                        'ruta'   => '/catalogos/empresas',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Clientes',
                        'ruta'   => '/catalogos/clientes',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Tipo de Pagos',
                        'ruta'   => '/catalogos/tipopagos',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Servicios',
                        'ruta'   => '/catalogos/servicios',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Productos',
                        'ruta'   => '/catalogos/productos',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ]
                ]
            ],    
            'configuraciones' => [
                'role'   => ['super-admin', 'admin'],
                'icono'  => 'fas fa-cogs',
                'ruta'   => '#',
                'submenu' => [                
                    [
                        'nombre' => 'Usuarios',
                        'ruta'   => '/admin/users',
                        'icono'  => 'fas fa-user',
                        'role'   => ['super-admin', 'admin']
                    ]
                ]
            ],
            'cerrar sesión' => [
                'role'   => ['super-admin', 'admin'],
                'icono'  => 'fas fa-window-close', 
                'ruta'   => '/logout',
            ]
        ];
    }
}

?>