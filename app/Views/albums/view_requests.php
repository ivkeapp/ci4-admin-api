<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Exchange Requests</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Exchange Requests</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Album ID</th>
                        <th>Status</th>
                        <th>Cards Offered</th>
                        <th>Cards Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exchangeRequests as $request): ?>
                    <tr>
                        <td><?= esc($request['receiver_id']) ?></td>
                        <td><?= esc($request['album_id']) ?></td>
                        <td><?= esc($request['status']) ?></td>
                        <td><?= esc($request['cards_offered']) ?></td>
                        <td><?= esc($request['cards_requested']) ?></td>
                        <td>
                            <?php if ($request['status'] == 'pending'): ?>
                                <!-- Action buttons -->
                                <div class="btn btn-success btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="accept">Accept</div>
                                <div class="btn btn-warning btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="decline">Decline</div>
                                <div class="btn btn-danger btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="delete" onclick="return confirm('Are you sure?')">Delete</div>
                            <?php else: ?>
                                <div class="btn btn-danger btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="delete" onclick="return confirm('Are you sure?')">Delete</divz>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    $('.handleRequest').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        var type = btn.data('type');
        $.ajax({
            url: '/exchange-requests/'+type+'/'+id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    // TODO: Error handling logic here
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    });
</script>
<?= $this->endSection() ?>