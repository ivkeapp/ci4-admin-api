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
                <form method="get" action="/pages" class="form-inline mb-4">
                    <input type="text" name="search" value="<?= esc($search) ?>" class="form-control mr-2" placeholder="Search pages">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td><?= esc($page['name']) ?></td>
                                <td><?= esc($page['description']) ?></td>
                                <td><?= esc($page['datetime_created']) ?></td>
                                <td>
                                    <a href="/pages/view/<?= $page['id'] ?>" class="btn btn-info btn-sm">View</a>
                                    <a href="/pages/edit/<?= $page['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="/pages/delete/<?= $page['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?= $pager->links() ?>
            </div>
        </div>
    </div>

<?= $this->section('modals') ?>
<?= $this->endSection() ?>

<script>
// todo: add script here
</script>

<?= $this->endSection() ?>
