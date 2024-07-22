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
                        <th>User</th>
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
                        <td><?= esc($request['first_name']) . ' '. esc($request['last_name']); ?></td>
                        <td><?= esc($request['album_id']) ?></td>
                        <td><?= esc($request['status']) ?></td>
                        <td><?= esc($request['cards_offered']) ?></td>
                        <td><?= esc($request['cards_requested']) ?></td>
                        <td>
                            <?php if ($request['status'] == 'pending'): ?>
                                <div class="btn btn-danger btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="delete" onclick="return confirm('Are you sure?')">Delete</div>
                            <?php elseif ($request['status'] == 'accepted'): ?>
                                <?php if (!$request['sender_completed'] && $currentUser == $request['sender_id']): ?>
                                    <button onclick="markAsCompleted(<?= $request['id'] ?>, <?= $currentUser ?>)">Mark as Completed</button>
                                <?php endif; ?>
                                <?php if (!$request['receiver_completed'] && $currentUser == $request['receiver_id']): ?>
                                    <button onclick="markAsCompleted(<?= $request['id'] ?>, <?= $currentUser ?>)">Mark as Completed</button>
                                <?php endif; ?>
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
    function markAsCompleted(requestId, userId) {
        $.ajax({
            url: '/exchange-requests/mark-as-completed',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ requestId: requestId, userId: userId }),
            contentType: 'application/json',
            success: function(data) {
                if (data.status === 'success') {
                    alert('Marked as completed!');
                    // Optionally refresh the page or update the UI
                } else {
                    alert('Error marking as completed.');
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    }

</script>
<?= $this->endSection() ?>