<?php
$session = session();
$userRole = $session->get('role_id');
$permisosModel = new \App\Models\PermissionModel();

// Obtener los permisos del usuario y organizarlos por controlador (para submenús)
$permisos = $permisosModel
    ->select('sys_permissions.controller, sys_permissions.method, sys_permissions.description')
    ->join('sys_roles_permissions', 'sys_permissions.id = sys_roles_permissions.permission_id')
    ->where('sys_roles_permissions.role_id', $userRole)
    ->orderBy('sys_permissions.controller', 'ASC')
    ->findAll();

// Agrupar por controlador para los submenús
$menu = [];
foreach ($permisos as $permiso) {
    $menu[$permiso['controlador']][] = $permiso;
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
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('/dashboard'); ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Menú dinámico -->
                <?php foreach ($menu as $controlador => $permisos): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-folder"></i> <!-- Icono general para módulos -->
                        <p>
                            <?= ucfirst($controlador) ?>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach ($permisos as $permiso): ?>
                        <li class="nav-item">
                            <a href="<?= site_url(strtolower($permiso['controlador']) . '/' . strtolower($permiso['metodo'])); ?>"
                                class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p><?= ucfirst($permiso['descripcion']); ?></p>
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