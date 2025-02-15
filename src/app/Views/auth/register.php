<div class="login-container">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Registro</b> Usuario</a>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('register') ?>">
            <div class="input-group mb-3">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?= old('name') ?>"
                    required>
            </div>

            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?= old('email') ?>"
                    required>
            </div>

            <div class="input-group mb-3">
                <input type="password" name="pwd" class="form-control" placeholder="Contraseña" required>
            </div>

            <div class="input-group mb-3">
                <input type="password" name="confirm_pwd" class="form-control" placeholder="Confirmar Contraseña"
                    required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
        </form>

        <p class="mt-3 text-center">
            ¿Ya tienes cuenta? <a href="<?= site_url('login') ?>">Iniciar sesión</a>
        </p>
    </div>
</div>