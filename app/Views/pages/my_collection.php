<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">My Collections</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Card Albums</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cardAlbums as $album): ?>
                        <tr>
                            <td><?= esc($album['title']) ?></td>
                            <td><?= esc($album['description']) ?></td>
                            <td>
                                <a href="<?= site_url('albums/edit/' . $album['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= site_url('albums/show/' . $album['id']) ?>" class="btn btn-info btn-sm">View</a>
                                <div class="btn btn-danger btn-sm deleteAlbum" data-id="<?= $album['id'] ?>">Delete</div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
    $('.deleteAlbum').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        $.ajax({
            url: '/albums/delete/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    infoMessage(response.message, response.status);
                    btn.closest('tr').remove();
                } else {
                    infoMessage(response.message, response.status);
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
