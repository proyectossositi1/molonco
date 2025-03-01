<?php
$session = session();
$userRole = $session->get('role_id');
$roleRouteModel = new \App\Models\RoleRouteModel();

// Obtener los permisos del usuario y organizarlos por controlador (para submenús)
$permisos = [];
$permisos = $roleRouteModel
    ->select('sys_routes.controller, sys_routes.method, sys_routes.name, sys_routes.route, sys_routes.icon, sys_menus.name AS menu, sys_menus.icon AS menu_icon')
    ->join('sys_roles', 'sys_roles.id = sys_role_routes.role_id')
    ->join('sys_routes', 'sys_routes.id = sys_role_routes.route_id')
    ->join('sys_menus', 'sys_menus.id = sys_routes.id_menu')
    ->where('sys_role_routes.role_id', $userRole)
    ->like('sys_routes.method', 'index')
    ->orderBy('sys_routes.name', 'ASC')
    ->findAll();
// Agrupar por controlador para los submenús
$menu = [];
foreach ($permisos as $key => $value) {
    $menu[$value['menu']] = [
        'name' => $value['menu'],
        'icon' => $value['menu_icon'],
        'routes' => []
    ];    
}

foreach ($permisos as $key => $value) {
    $menu[$value['menu']]['routes'][] = $value;
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url('/dashboard'); ?>" class="brand-link">
        <img src="<?= base_url('adminlte/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('adminlte/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('/dashboard'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Menú dinámico -->
                <?php $currentRoute = uri_string(); // Obtiene la ruta actual sin dominio ?>
                <?php foreach ($menu as $key => $value): ?>
                <li
                    class="nav-item <?= array_search($currentRoute, array_column($value['routes'], 'route')) !== false ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= array_search($currentRoute, array_column($value['routes'], 'route')) !== false ? 'active' : ''; ?>">
                        <i class="nav-icon <?= $value['icon']; ?>"></i> <!-- Icono general para módulos -->
                        <p>
                            <?= ucfirst($key) ?>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach ($value['routes'] as $key_route => $value_route): ?>
                        <?php $isActive = ($currentRoute == strtolower($value_route['route'])) ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url(strtolower($value_route['route'])); ?>"
                                class="nav-link <?= $isActive; ?>">
                                <i class="nav-icon <?= $value_route['icon']; ?>"></i>
                                <p><?= ucfirst($value_route['name']); ?></p>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="<?= site_url('/logout'); ?>" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Cerrar sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>