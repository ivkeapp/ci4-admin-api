<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.addUser') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5"><?= lang('Auth.addUser') ?></h5>

            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?><br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <form action="<?= base_url('admin/add-user') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="form-floating mb-4">
                    <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                    <label for="email">Email</label>
                </div>

                <!-- Username -->
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                    <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                </div>

                <!-- Password -->
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                    <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                </div>

                <!-- First Name -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingFirstNameInput" name="first_name" inputmode="text" autocomplete="given-name" placeholder="First Name" value="<?= old('first_name') ?>" required>
                    <label for="floatingFirstNameInput">First Name</label>
                </div>

                <!-- Last Name -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingLastNameInput" name="last_name" inputmode="text" autocomplete="family-name" placeholder="Last Name" value="<?= old('last_name') ?>" required>
                    <label for="floatingLastNameInput">Last Name</label>
                </div>

                <!-- Mobile Phone -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingMobilePhoneInput" name="mobile_phone" inputmode="tel" autocomplete="tel" placeholder="Mobile Phone" value="<?= old('mobile_phone') ?>" required>
                    <label for="floatingMobilePhoneInput">Mobile Phone</label>
                </div>

                <!-- Address -->
                <div class="form-floating mb-5">
                    <input type="text" class="form-control" id="floatingAddressInput" name="address" inputmode="text" autocomplete="street-address" placeholder="Address" value="<?= old('address') ?>" required>
                    <label for="floatingAddressInput">Address</label>
                </div>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
