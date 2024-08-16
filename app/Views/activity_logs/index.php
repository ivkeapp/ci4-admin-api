<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">User Activity Logs</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Activity Logs</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action Type</th>
                            <th>Description</th>
                            <th>Metadata</th>
                            <th>Created At</th>
                        </tr>
                        <tr>
                            <th><input type="text" placeholder="Search User ID" class="column-filter" data-column="0"></th>
                            <th><input type="text" placeholder="Search Name" class="column-filter" data-column="1"></th>
                            <th><input type="text" placeholder="Search Surname" class="column-filter" data-column="2"></th>
                            <th><input type="text" placeholder="Search Phone" class="column-filter" data-column="3"></th>
                            <th><input type="text" placeholder="Search Address" class="column-filter" data-column="4"></th>
                            <th><input type="text" placeholder="Search Action Type" class="column-filter" data-column="5"></th>
                            <th><input type="text" placeholder="Search Description" class="column-filter" data-column="6"></th>
                            <th><input type="text" placeholder="Search Metadata" class="column-filter" data-column="7"></th>
                            <th><input type="text" placeholder="Search Created At" class="column-filter" data-column="8"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $log['user_id'] ?></td>
                            <td><?= $log['first_name'] ?></td>
                            <td><?= $log['last_name'] ?></td>
                            <td><?= $log['mobile_phone'] ?></td>
                            <td><?= $log['address'] ?></td>
                            <td><?= $log['action_type'] ?></td>
                            <td><?= $log['description'] ?></td>
                            <td><?= $log['metadata'] ?></td>
                            <td><?= $log['created_at'] ?></td>
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
    var table = $('#dataTable').DataTable();

    // Apply the search
    $('.column-filter').on('keyup change', function() {
        table
            .column($(this).data('column'))
            .search(this.value)
            .draw();
    });
});
</script>
<?= $this->endSection() ?>
