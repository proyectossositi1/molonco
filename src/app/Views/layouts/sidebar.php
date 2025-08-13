<script src="<?= base_url('js/layouts/sidebar/index.js?v='.time()); ?>"></script>

<?php $menu = menu(); ?>

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
                <a href="#" class="d-block"><?php if(!empty(session('username'))) echo session('username') ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <select class="form-control selectpicker form-control-sidebar" id="list_menu"
                    onchange="search_menu(this)">
                    <option value="">Buscar</option>
                    <?php
                        $role = strtolower(session('role')); 

                        foreach ($menu as $key => $value) {
                            if(in_array($role, $value['role'])){
                                echo '<optgroup label="'.ucfirst($key).'">';
                            
                                if(array_key_exists('submenu', $value)){
                                    foreach ($value['submenu'] as $key_submenu => $value_submenu) {
                                        if(in_array($role, $value_submenu['role'])) echo '<option value="'.$value_submenu['ruta'].'">'.$value_submenu['nombre'].'</option>';
                                    }
                                }else{
                                    echo '<option value="'.$value['ruta'].'">'.ucfirst($key).'</option>';
                                }
                                
                                echo '</optgroup>';
                            }                            
                        }
                    ?>
                </select>
                <div class="input-group-append">
                    <div class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </div>
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
                <?php 
                    $currentRoute = '/'.uri_string(); // Obtiene la ruta actual sin dominio 
                    $role = strtolower(session('role')); 
                    
                    foreach ($menu as $key => $value):
                        if(in_array($role, $value['role'])):
                ?>
                <li
                    class="nav-item <?= (isset($value['submenu']) && array_search($currentRoute, array_column($value['submenu'], 'ruta')) !== false) ? 'menu-open' : ''; ?>">
                    <?php $url_header = (!array_key_exists('submenu', $value)) ? $value['ruta'] : '#' ; ?>
                    <a href="<?= $url_header; ?>"
                        class="nav-link <?= (isset($value['submenu']) && array_search($currentRoute, array_column($value['submenu'], 'ruta')) !== false) ? 'active' : ''; ?>">
                        <i class="nav-icon <?= $value['icono']; ?>"></i> <!-- Icono general para módulos -->
                        <p>
                            <?= ucfirst($key) ?>
                            <!-- <i class="nav-arrow bi bi-chevron-right"></i> -->
                            <?php if(array_key_exists('submenu', $value)): ?>
                            <i class="right fas fa-angle-left"></i>
                            <?php endif; ?>
                        </p>
                    </a>
                    <?php if(array_key_exists('submenu', $value)): ?>
                    <ul class="nav nav-treeview">
                        <?php 
                            foreach ($value['submenu'] as $key_submenu => $value_submenu): 
                                if(in_array($role, $value_submenu['role'])):
                        ?>
                        <?php $isActive = ($currentRoute == strtolower($value_submenu['ruta'])) ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url(strtolower($value_submenu['ruta'])); ?>"
                                class="nav-link <?= $isActive; ?>">
                                <i class="nav-icon <?= $value_submenu['icono']; ?>"></i>
                                <p><?= ucfirst($value_submenu['nombre']); ?></p>
                            </a>
                        </li>
                        <?php 
                                endif;
                            endforeach; 
                        ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php 
                        endif;
                    endforeach; 
                ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>