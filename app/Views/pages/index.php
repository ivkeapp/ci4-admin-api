<!-- app/Views/admin/index.php -->

<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/user-profile.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Page Management</h2>
                <hr>
                <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPageModal">Add Page</a>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created By</th>
                                <th>Creation Date</th>
                                <th>Active</th>
                                <th>URL Slug</th>
                                <th>Last Updated</th>
                                <th>Updated By</th>
                                <th>Content</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $page) : ?>
                                <tr>
                                    <td><?= $page['id'] ?></td>
                                    <td><?= $page['name'] ?></td>
                                    <td><?= $page['description'] ?></td>
                                    <td><?= $page['user_created'] ?></td>
                                    <td><?= $page['datetime_created'] ?></td>
                                    <td><?= $page['is_active'] ? 'Yes' : 'No' ?></td>
                                    <td><?= $page['url_slug'] ?></td>
                                    <td><?= $page['datetime_updated'] ?></td>
                                    <td><?= $page['user_updated'] ?></td>
                                    <td><?= $page['content'] ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="editPageModal(<?= $page['id'] ?>)">Edit</button>
                                        <a href="<?= site_url('pages/delete/' . $page['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this page?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?= $this->section('modals') ?>
<?= $this->endSection() ?>

<script>
// todo: add script here
</script>

<?= $this->endSection() ?>
