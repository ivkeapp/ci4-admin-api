<?= $this->extend('header_public') ?>
<?= $this->section('custom_styles') ?>
    <link rel="stylesheet" href="/css/login.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9">
                <div class="col-lg-12">
                    <div class="login-card">
                        <h1 class="heading-1"><?= lang('Auth.login') ?></h1>
                        <?php if (setting('Auth.allowRegistration')) : ?>
                            <span class="small"><?= lang('Auth.needAccount') ?></span> <a class="small-link" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
                        <?php endif ?>
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
                        <form class="user login-form" action="<?= url_to('login') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label class="login-label" for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                                <input type="email" class="form-control form-login-input"
                                    aria-describedby="emailHelp"
                                    id="floatingEmailInput" name="email" inputmode="email"
                                    autocomplete="email" placeholder="name@example.com"
                                    value="<?= old('email') ?>" required>
                            </div>
                            <div class="form-group form-group-purge-margin">
                                <label class="login-label" for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                                <input type="password" class="form-control form-login-input"
                                    id="floatingPasswordInput" name="password"
                                    inputmode="text" autocomplete="current-password"
                                    placeholder="<?= lang('Auth.password') ?>" required>
                            </div>
                            <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                <div class="form-group">
                                    <a class="x-small-link" href="<?= url_to('login-magic-link') ?>">Forgot password?</a>
                                </div>
                            <?php endif ?>
                            <button type="submit" class="btn btn-primary btn-login btn-block"><?= lang('Auth.login') ?></button>
                            <div class="or-continue">
                                <span>Or continue</span>
                            </div>
                            <!-- <a href="index.html" class="btn btn-login-google btn-block" disabled>
                                <i class="fab fa-google fa-fw"></i> Login with Google
                            </a> -->
                            <a href="index.html" class="btn btn-login-google btn-block" disabled>
                                <svg class="google-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.64 9.20478C17.64 8.56653 17.583 7.95228 17.4765 7.36353H9V10.845H13.8435C13.7434 11.3957 13.5326 11.9203 13.224 12.3872C12.9154 12.8541 12.5154 13.2536 12.048 13.5615V15.819H14.9565C16.6582 14.253 17.64 11.946 17.64 9.20478Z" fill="#4285F4"/>
                                    <path d="M9.00003 18C11.43 18 13.467 17.1938 14.9565 15.8198L12.048 13.5615C11.2418 14.1015 10.2105 14.4203 9.00003 14.4203C6.65628 14.4203 4.67253 12.8378 3.96378 10.71H0.957031V13.0425C1.70608 14.5334 2.85499 15.7866 4.27534 16.6621C5.6957 17.5376 7.33154 18.0008 9.00003 18Z" fill="#34A853"/>
                                    <path d="M3.96375 10.71C3.77872 10.1588 3.68375 9.58143 3.6825 9.00002C3.6825 8.40752 3.7845 7.83002 3.9645 7.29002V4.95752H0.957001C0.326989 6.2119 -0.000748199 7.59631 1.28256e-06 9.00002C1.28256e-06 10.452 0.348001 11.8275 0.957001 13.0425L3.96375 10.71Z" fill="#FBBC05"/>
                                    <path d="M9.00003 3.57975C10.3215 3.57975 11.508 4.0335 12.4403 4.92525L15.0218 2.34375C13.4633 0.8925 11.4263 0 9.00003 0C5.48253 0 2.43753 2.0175 0.957031 4.9575L3.96453 7.29C4.67103 5.163 6.65553 3.57975 9.00003 3.57975Z" fill="#EA4335"/>
                                </svg>
                                Continue with Google
                            </a>
                            <!-- <a href="index.html" class="btn btn-facebook btn-user btn-block" disabled>
                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                            </a> -->
                            <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" <?php if (old('remember')): ?> checked<?php endif ?>>
                                        <label class="custom-control-label" for="customCheck"><?= lang('Auth.rememberMe') ?></label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <span class="text-xs">Having trouble logging in?</span> <a class="x-small-link" href="<?= url_to('register') ?>">Contact support</a>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?= $this->endSection() ?>
