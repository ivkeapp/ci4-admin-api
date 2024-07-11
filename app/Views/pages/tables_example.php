<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Field1</th>
                                <th>Field2</th>
                                <th>Field3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tableData as $row): ?>
                            <tr>
                                <td><?= $row['field1'] ?></td>
                                <td><?= $row['field2'] ?></td>
                                <td><?= $row['field3'] ?></td>
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
    });
    </script>
    <?= $this->endSection() ?>