<?= $this->extend('header') ?>

<?= $this->section('content') ?>

    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
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
                            <form class="user" action="<?= url_to('register') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text"
                                            class="form-control form-control-user"
                                            id="floatingFirstNameInput"
                                            name="first_name"
                                            inputmode="text"
                                            autocomplete="given-name"
                                            placeholder="First Name"
                                            value="<?= old('first_name') ?>"
                                            required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control form-control-user"
                                            id="floatingLastNameInput"
                                            name="last_name"
                                            inputmode="text"
                                            autocomplete="family-name"
                                            placeholder="Last Name"
                                            value="<?= old('last_name') ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                        class="form-control form-control-user"
                                        id="floatingEmailInput"
                                        name="email"
                                        inputmode="email"
                                        autocomplete="email"
                                        placeholder="<?= lang('Auth.email') ?>"
                                        value="<?= old('email') ?>"
                                        required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"
                                            class="form-control form-control-user"
                                            id="floatingPasswordInput"
                                            name="password"
                                            inputmode="text"
                                            autocomplete="new-password"
                                            placeholder="<?= lang('Auth.password') ?>"
                                            required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password"
                                            class="form-control form-control-user"
                                            id="floatingPasswordConfirmInput"
                                            name="password_confirm"
                                            inputmode="text"
                                            autocomplete="new-password"
                                            placeholder="<?= lang('Auth.passwordConfirm') ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text"
                                            class="form-control form-control-user"
                                            id="floatingUsernameInput"
                                            name="username"
                                            inputmode="text"
                                            autocomplete="username"
                                            placeholder="<?= lang('Auth.username') ?>"
                                            value="<?= old('username') ?>"
                                            required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="tel"
                                            class="form-control form-control-user"
                                            id="floatingMobilePhoneInput"
                                            name="mobile_phone"
                                            inputmode="tel"
                                            autocomplete="tel"
                                            placeholder="Mobile Phone"
                                            value="<?= old('mobile_phone') ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="floatingAddressInput" name="address" inputmode="text" autocomplete="street-address" placeholder="Address" value="<?= old('address') ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.register') ?></button>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <span class="small"><?= lang('Auth.haveAccount') ?> </span><a class="small" href="<?= url_to('login') ?>"><?= lang('Auth.login') ?>!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

