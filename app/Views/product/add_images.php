<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Add Product Images</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Upload Images for Product</h6>
        </div>
        <div class="card-body">
            <form id="imageUploadForm" action="<?= site_url('/products/storeImages') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="product_id">Select Product</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <option value="">Select a product</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>"><?= $product['short_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_images">Product Images</label>
                    <input type="file" class="form-control" id="product_images" name="product_images[]" multiple required>
                </div>
                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>
            <hr>
            <h6 class="m-0 font-weight-bold text-primary">Existing Images</h6>
            <div id="existingImages" class="mt-3"></div>
        </div>
    </div>
</div>

<script src="/vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#product_id').change(function() {
        var productId = $(this).val();
        if (productId) {
            $.ajax({
                url: '<?= site_url('/products/get-productimages') ?>/' + productId,
                method: 'GET',
                success: function(data) {
                    var imagesHtml = '';
                    data.forEach(function(image) {
                        imagesHtml += '<div class="image-item">';
                        imagesHtml += '<img src="<?= base_url() ?>/' + image.image_path + '" alt="Product Image" class="img-thumbnail" width="150">';
                        imagesHtml += '<button class="btn btn-danger btn-sm delete-image" data-id="' + image.id + '">Delete</button>';
                        if (image.is_main != 1) {
                            imagesHtml += '<button class="btn btn-primary btn-sm set-main-image" data-id="' + image.id + '">Set as Main</button>';
                        } else {
                            imagesHtml += '<span class="badge badge-success">Main Image</span>';
                        }
                        imagesHtml += '</div>';
                    });
                    $('#existingImages').html(imagesHtml);
                }
            });
        } else {
            $('#existingImages').html('');
        }
    });

    $('#existingImages').on('click', '.delete-image', function() {
        var imageId = $(this).data('id');
        $.ajax({
            url: '<?= site_url('/products/deleteImage') ?>/' + imageId,
            method: 'GET',
            success: function(data) {
                if (data.status === 'success') {
                    $('#product_id').trigger('change');
                }
            }
        });
    });

    $('#existingImages').on('click', '.set-main-image', function() {
        var imageId = $(this).data('id');
        $.ajax({
            url: '<?= site_url('/products/setMainImage') ?>/' + imageId,
            method: 'GET',
            success: function(data) {
                if (data.status === 'success') {
                    $('#product_id').trigger('change');
                }
            }
        });
    });

    $('#imageUploadForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status === 'success') {
                    $('#product_id').trigger('change');
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>