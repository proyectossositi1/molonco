<h2>Restablecer Contraseña</h2>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('reset-password') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="token" value="<?= esc($token) ?>">

    <div class="mb-3">
        <label for="password">Nueva Contraseña</label>
        <input type="password" name="password" class="form-control" placeholder="Nueva contraseña" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password">Confirmar Contraseña</label>
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirma tu contraseña"
            required>
    </div>

    <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
</form>