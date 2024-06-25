<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/user-profile.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="wrapper">
    <?= $this->include('layout/sidebar') ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <?= $this->include('layout/topbar') ?>
            <div class="user-profile">
                <h2>User Profile</h2>
                <p><strong>Username:</strong> <?= esc($userData->username) ?></p>
                <p><strong>Email:</strong> <?= esc($userData->email) ?></p>
                <p><strong>First Name:</strong> <?= esc($userData->first_name) ?></p>
                <p><strong>Last Name:</strong> <?= esc($userData->last_name) ?></p>
                <p><strong>Mobile Phone:</strong> <?= esc($userData->mobile_phone) ?></p>
                <p><strong>Address:</strong> <?= esc($userData->address) ?></p>
                <p><strong>Auth Group and Rights:</strong></p>
                <ul>
                    <?php foreach ($userGroups as $group): ?>
                        <li><?= esc($group) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="/user/edit-profile" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>