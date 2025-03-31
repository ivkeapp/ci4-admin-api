<?= $this->extend('header') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2>Add New Product</h2>
    <form action="<?= site_url('/products/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku" required>
        </div>
        <div class="form-group">
            <label for="short_name">Short Name</label>
            <input type="text" class="form-control" id="short_name" name="short_name" required>
        </div>
        <div class="form-group">
            <label for="long_name">Long Name</label>
            <input type="text" class="form-control" id="long_name" name="long_name">
        </div>
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="price_in">Price</label>
            <input type="number" class="form-control" id="price_in" name="price_in" required>
        </div>
        <div class="form-group">
            <label for="price_with_margin">Price with Margin</label>
            <input type="number" class="form-control" id="price_with_margin" name="price_with_margin">
        </div>
        <div class="form-group">
            <label for="regular_price">Regular Price</label>
            <input type="number" class="form-control" id="regular_price" name="regular_price">
        </div>
        <div class="form-group">
            <label for="package_size">Package Size</label>
            <input type="text" class="form-control" id="package_size" name="package_size">
        </div>
        <div class="form-group">
            <label for="package_weight">Package Weight</label>
            <input type="number" class="form-control" id="package_weight" name="package_weight">
        </div>
        <div class="form-group">
            <label for="metadata">Metadata</label>
            <textarea class="form-control" id="metadata" name="metadata" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="subcategory">Subcategory</label>
            <select class="form-control" id="subcategory" name="subcategory">
                <option value="">Select Subcategory</option>
            </select>
        </div>
        <div class="form-group">
            <label for="subsubcategory">Subsubcategory</label>
            <select class="form-control" id="subsubcategory" name="subsubcategory">
                <option value="">Select Subsubcategory</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        const categorySelect = $('#category');
        const subcategorySelect = $('#subcategory');
        const subsubcategorySelect = $('#subsubcategory');

        categorySelect.on('change', function() {
            const categoryId = $(this).val();
            updateSubcategories(categoryId);
            updateSubsubcategoriesBasedOnCategory(categoryId);
        });

        subcategorySelect.on('change', function() {
            const subcategoryId = $(this).val();
            updateSubsubcategories(subcategoryId);
        });

        function updateSubcategories(categoryId) {
            // Fetch subcategories based on categoryId
            $.ajax({
                url: `/products/get-subcategory/${categoryId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    subcategorySelect.empty();
                    $.each(data, function(index, subcategory) {
                        subcategorySelect.append(new Option(subcategory.name, subcategory.id));
                    });
                    // Trigger change event to update subsubcategories
                    subcategorySelect.trigger('change');
                }
            });
        }

        function updateSubsubcategories(subcategoryId) {
            // Fetch subsubcategories based on subcategoryId
            $.ajax({
                url: `/products/get-subsubcategory/${subcategoryId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    subsubcategorySelect.empty();
                    $.each(data, function(index, subsubcategory) {
                        subsubcategorySelect.append(new Option(subsubcategory.name, subsubcategory.id));
                    });
                }
            });
        }

        function updateSubsubcategoriesBasedOnCategory(categoryId) {
            // Fetch subsubcategories based on categoryId
            $.ajax({
                url: `/products/getSubsubcategoriesByCategory/${categoryId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    subsubcategorySelect.empty();
                    $.each(data, function(index, subsubcategory) {
                        subsubcategorySelect.append(new Option(subsubcategory.name, subsubcategory.id));
                    });
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>