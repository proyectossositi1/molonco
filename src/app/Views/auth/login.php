<div class="login-box">
    <div class="login-logo">
        <!-- <a href="<? // site_url('login') 
                        ?>"><b>Admin</b> MOLONCO</a> -->
        <img src="<?= base_url('images/logo.png'); ?>" alt="" class="w-50">

    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <form action="<?= site_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <p class="login-box-msg">
                        Iniciar Sesión
                    </p>
                    <form action="<?= site_url('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Correo" name="usr" />
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Contraseña" name="pwd" />

                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        <!--begin::Row-->
                        <div class="row">
                            <!-- <div class="col-8">
                    </div> -->
                            <!-- /.col -->
                            <div class="col-4">
                                <div class="d-grid gap-2">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me"
                                                value="1" />
                                            <label class="form-check-label" for="remember_me"> Recuerdame </label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6 text-right">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Entrar</button>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!--end::Row-->
                    </form>
                    <!-- <div class="social-auth-links text-center mb-3 d-grid gap-2">
                <p>- OR -</p>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-facebook me-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-danger">
                    <i class="bi bi-google me-2"></i> Sign in using Google+
                </a>
            </div> -->
                    <!-- /.social-auth-links -->

                    <!-- <p class="mt-5 mb-1"><a href="<? // site_url('forgot-password'); 
                                                        ?>">I forgot my password</a></p>
            <p class="mb-0">
                <a href="<? // site_url('register') 
                            ?>" class="text-center"> Register a new membership </a>
            </p> -->
                </div>
                <!-- /.login-card-body -->
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
    <!-- /.login-box -->