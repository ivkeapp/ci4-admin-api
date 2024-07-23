<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Manage Albums</h1>
    <a href="<?= site_url('admin/albums/add') ?>" class="btn btn-primary mb-3">Add Album</a>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Albums List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Publisher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($albums as $album): ?>
                            <tr data-id="<?= esc($album['id']) ?>">
                                <td><a href="<?= site_url('admin/album/show/' . $album['id']) ?>"><?= esc($album['title']) ?></a></td>
                                <td><?= esc($album['description']) ?></td>
                                <td><?= esc($album['publisher']) ?></td>
                                <td>
                                    <a href="<?= site_url('admin/albums/edit/' . $album['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="<?= site_url('admin/albums/delete/' . $album['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('custom_scripts') ?>
<script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
<?= $this->endSection() ?>
