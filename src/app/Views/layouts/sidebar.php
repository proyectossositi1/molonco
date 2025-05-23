<?php
$session = session();
$userRole = $session->get('id_role');
$roleRouteModel = new \App\Models\RoleRouteModel();

// Obtener los permisos del usuario y organizarlos por controlador (para submenús)
$permisos = [];
$permisos = $roleRouteModel
    ->select('cat_sys_routes.controller, cat_sys_routes.method, cat_sys_routes.name, cat_sys_routes.route, cat_sys_routes.icon, cat_sys_menus.name AS menu, cat_sys_menus.icon AS menu_icon')
    ->join('cat_sys_roles', 'cat_sys_roles.id = sys_role_routes.id_role')
    ->join('cat_sys_routes', 'cat_sys_routes.id = sys_role_routes.id_route')
    ->join('cat_sys_menus', 'cat_sys_menus.id = cat_sys_routes.id_menu')
    ->where('sys_role_routes.id_role', $userRole)
    ->like('cat_sys_routes.method', 'index')
    ->orderBy('cat_sys_menus.order', 'ASC')
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
// dd($permisos);
foreach ($permisos as $key => $value) {
    $menu[$value['menu']]['routes'][] = $value;
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url('/dashboard'); ?>" class="brand-link text-center">
        <img src="<?= base_url('images/logo.png'); ?>" alt="" class="w-50" style="opacity: .8">
        <!-- <span class="brand-text font-weight-light">Molonko</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('adminlte/dist/img/avatar5.png'); ?>" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= session()->get('username'); ?></a>
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
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<? // site_url('/dashboard'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

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
                            <!-- <i class="nav-arrow bi bi-chevron-right"></i> -->
                            <i class="right fas fa-angle-left"></i>
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