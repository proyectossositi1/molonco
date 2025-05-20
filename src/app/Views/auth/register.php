<div class="register-box">
    <div class="register-logo">
        <a href="<?= 
        site_url('login')
        ?>"><b>Admin</b> MOLONCO</a>
    </div>
    <!-- /.register-logo -->
    <div class="card">
        <div class="card-body register-card-body">
            <p class="register-box-msg">Register a new membership</p>
            <form action="<?= site_url('register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full Name" name="nombre"
                        value="<?= old('nombre') ?>" />
                    <div class="input-group-text"><span class="bi bi-person"></span></div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email"
                        value="<?= old('email') ?>" />
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="pwd"
                        value="<?= old('pwd') ?>" />
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_pwd"
                        value="<?= old('confirm_pwd') ?>" />
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                <!--begin::Row-->
                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Sign In</button>
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
            <p class="mt-5 mb-0">
                <a href="<?= site_url('login'); ?>" class="text-center"> I already have a membership </a>
            </p>
        </div>
        <!-- /.register-card-body -->
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mt-2">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif; ?>
</div>