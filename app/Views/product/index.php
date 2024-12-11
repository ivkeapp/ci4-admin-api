<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Product List</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Short Name</th>
                            <th>Long Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['sku'] ?></td>
                                <td><?= $product['short_name'] ?></td>
                                <td><?= $product['long_name'] ?></td>
                                <td><?= $product['slug'] ?></td>
                                <td><?= $product['description'] ?></td>
                                <td><?= $product['price_in'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($product['subsubcategory_id']) && isset($categoryMap[$product['subsubcategory_id']])) {
                                        echo $categoryMap[$product['subsubcategory_id']];
                                    } elseif (!empty($product['subcategory_id']) && isset($categoryMap[$product['subcategory_id']])) {
                                        echo $categoryMap[$product['subcategory_id']];
                                    } else {
                                        echo 'N/A'; // or any default value you prefer
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<?= $this->endSection() ?>