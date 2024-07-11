<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Groups Preview</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Groups List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="groupsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Title</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $groupName => $groupDetails): ?>
                        <tr>
                            <td><?= esc($groupName); ?></td>
                            <td><?= esc($groupDetails['title']); ?></td>
                            <td><?= esc($groupDetails['description']); ?></td>
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
    $('#groupsTable').DataTable();
});
</script>
<?= $this->endSection() ?>