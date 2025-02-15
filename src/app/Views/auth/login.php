<div class="login-container">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>ERP</a>
        </div>

        <div class="login-card-body">
            <p class="login-box-msg">Iniciar sesión</p>

            <!-- 🚨 ALERTAS (Errores o Éxitos) -->
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- 🚀 FORMULARIO DE LOGIN -->
            <form method="post" action="<?= site_url('login') ?>">
                <div class="input-group mb-3">
                    <input type="text" name="usr" class="form-control" placeholder="Usuario" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="pwd" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                </div>

                <!-- 🚀 Botón de Iniciar Sesión -->
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </form>

            <!-- 🚀 Botón para Registrarse -->
            <div class="mt-3 text-center">
                <p>¿No tienes cuenta?</p>
                <a href="<?= site_url('register') ?>" class="btn btn-secondary btn-block">
                    <i class="fas fa-user-plus"></i> Crear cuenta
                </a>
            </div>
        </div>
    </div>
</div>