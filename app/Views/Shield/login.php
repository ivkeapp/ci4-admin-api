<?= $this->extend('header') ?>

<?= $this->section('content') ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php if (session('error') !== null) : ?>
                                        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                                    <?php elseif (session('errors') !== null) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php if (is_array(session('errors'))) : ?>
                                                <?php foreach (session('errors') as $error) : ?>
                                                    <?= $error ?>
                                                    <br>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <?= session('errors') ?>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (session('message') !== null) : ?>
                                        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                                    <?php endif ?>
                                    <form class="user" action="<?= url_to('login') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                aria-describedby="emailHelp"
                                                id="floatingEmailInput" name="email" inputmode="email"
                                                autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                                                value="<?= old('email') ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="floatingPasswordInput" name="password"
                                                inputmode="text" autocomplete="current-password"
                                                placeholder="<?= lang('Auth.password') ?>" required>
                                        </div>
                                        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" <?php if (old('remember')): ?> checked<?php endif ?>>
                                                    <label class="custom-control-label" for="customCheck"><?= lang('Auth.rememberMe') ?></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.login') ?></button>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block" disabled>
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block" disabled>
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                        <div class="text-center">
                                            <a class="small" href="<?= url_to('login-magic-link') ?>">Forgot password?</a>
                                        </div>
                                    <?php endif ?>

                                    <?php if (setting('Auth.allowRegistration')) : ?>
                                        <div class="text-center">
                                            <span class="small"><?= lang('Auth.needAccount') ?></span> <a class="small" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?= $this->endSection() ?>
