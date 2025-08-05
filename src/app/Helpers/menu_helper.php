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
                    ]
                ]
            ],  
            'catalogos' => [
                'role'   => ['super-admin', 'admin'],
                'icono'  => 'fas fa-list',
                'ruta'   => '#',
                'submenu'   => [
                    [
                        'nombre' => 'Clientes',
                        'ruta'   => '/catalogos/clientes',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Productos',
                        'ruta'   => '/catalogos/servicios-productos',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Metodos de Pagos',
                        'ruta'   => '/catalogos/metodos-de-pagos',
                        'icono'  => 'fas fa-users',
                        'role'   => ['super-admin', 'admin']
                    ]
                ]
            ],    
            'Agenda' => [
                'role'   => ['super-admin', 'admin'],
                'icono'  => 'fas fa-calendar',
                'ruta'   => '#',
                'submenu'   => [
                    [
                        'nombre' => 'Calendario',
                        'ruta'   => '/agenda',
                        'icono'  => 'fas fa-calendar-plus',
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
                        'ruta'   => '/admin/usuarios',
                        'icono'  => 'fas fa-user',
                        'role'   => ['super-admin', 'admin']
                    ],
                    [
                        'nombre' => 'Horario',
                        'ruta'   => '/agenda/horario-laboral',
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