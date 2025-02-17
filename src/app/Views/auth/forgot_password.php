<div class="login-box">
    <div class="login-logo">
        <a href="<?= site_url('login') ?>"><b>Admin</b> MOLONCO</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Olvidé mi contraseña</p>
            <form method="post" action="<?= site_url('forgot-password') ?>">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" />
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                <!--begin::Row-->
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Enviar enlace</button>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <p class="mt-5 mb-0">
                    <a href="<?= site_url('login'); ?>" class="text-center"> I already have a membership </a>
                </p>
                <!--end::Row-->
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mt-2"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mt-2"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

</div>
<!-- /.login-box -->