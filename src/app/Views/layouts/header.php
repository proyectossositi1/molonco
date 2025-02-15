<header class="main-header navbar navbar-expand navbar-light navbar-white">
    <?php if (session()->has('user_id')): ?>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('/dashboard') ?>">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('/logout') ?>">Cerrar sesión</a>
        </li>
    </ul>
    <?php endif; ?>
</header>