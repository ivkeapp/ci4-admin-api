<?= $this->extend('header') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2>Add New Product</h2>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <form id="productForm" action="<?= site_url('/products/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <!-- Product Information Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sku">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" value="<?= old('sku') ?>" required>
                            <small class="form-text text-muted">Unique identifier for the product</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="short_name">Short Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="short_name" name="short_name" value="<?= old('short_name') ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="long_name">Long Name</label>
                            <input type="text" class="form-control" id="long_name" name="long_name" value="<?= old('long_name') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug') ?>">
                            <small class="form-text text-muted">Leave empty to auto-generate from name and SKU</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Pricing Information Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pricing Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price_in">Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="price_in" name="price_in" value="<?= old('price_in') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price_with_margin">Price with Margin</label>
                            <input type="number" step="0.01" class="form-control" id="price_with_margin" name="price_with_margin" value="<?= old('price_with_margin') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regular_price">Regular Price</label>
                            <input type="number" step="0.01" class="form-control" id="regular_price" name="regular_price" value="<?= old('regular_price') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Package Information Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Package Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_size">Package Size</label>
                            <input type="text" class="form-control" id="package_size" name="package_size" value="<?= old('package_size') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="package_weight">Package Weight</label>
                            <input type="number" step="0.01" class="form-control" id="package_weight" name="package_weight" value="<?= old('package_weight') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Categories Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= old('category') == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subcategory">Subcategory</label>
                            <select class="form-control" id="subcategory" name="subcategory">
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subsubcategory">Subsubcategory</label>
                            <select class="form-control" id="subsubcategory" name="subsubcategory">
                                <option value="">Select Subsubcategory</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Images Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Product Images (Optional)</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="product_images">Upload Images</label>
                    <input type="file" class="form-control-file" id="product_images" name="product_images[]" multiple accept="image/*">
                    <small class="form-text text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF. First image will be set as main image.</small>
                </div>
                
                <!-- Image Preview Area -->
                <div id="imagePreview" class="mt-3" style="display: none;">
                    <h6>Image Preview:</h6>
                    <div id="previewContainer" class="d-flex flex-wrap"></div>
                </div>
            </div>
        </div>
        
        <!-- Metadata Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Additional Information</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="metadata">Metadata (JSON format)</label>
                    <textarea class="form-control" id="metadata" name="metadata" rows="3" placeholder='{"key": "value"}'><?= old('metadata') ?></textarea>
                    <small class="form-text text-muted">Optional JSON metadata for additional product information</small>
                </div>
            </div>
        </div>
        
        <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Create Product
            </button>
            <a href="<?= site_url('/products') ?>" class="btn btn-secondary btn-lg ml-2">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        const categorySelect = $('#category');
        const subcategorySelect = $('#subcategory');
        const subsubcategorySelect = $('#subsubcategory');
        const productForm = $('#productForm');
        const imageInput = $('#product_images');

        // Category selection handlers
        categorySelect.on('change', function() {
            const categoryId = $(this).val();
            updateSubcategories(categoryId);
            updateSubsubcategoriesBasedOnCategory(categoryId);
        });

        subcategorySelect.on('change', function() {
            const subcategoryId = $(this).val();
            updateSubsubcategories(subcategoryId);
        });

        // Image preview functionality
        imageInput.on('change', function() {
            previewImages(this.files);
        });

        // Form submission with AJAX
        productForm.on('submit', function(e) {
            e.preventDefault();
            
            const submitButton = $(this).find('button[type="submit"]');
            const originalText = submitButton.html();
            
            // Disable submit button and show loading
            submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating Product...');
            
            // Clear any existing alerts
            $('.alert').remove();
            
            const formData = new FormData(this);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = '<?= site_url("/products") ?>';
                        }, 2000);
                    } else {
                        showAlert('danger', response.message);
                        submitButton.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'An error occurred while creating the product.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    showAlert('danger', errorMessage);
                    submitButton.prop('disabled', false).html(originalText);
                }
            });
        });

        function updateSubcategories(categoryId) {
            if (!categoryId) {
                subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                return;
            }
            
            $.ajax({
                url: `/products/get-subcategory/${categoryId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                    $.each(data, function(index, subcategory) {
                        subcategorySelect.append(new Option(subcategory.name, subcategory.id));
                    });
                    subcategorySelect.trigger('change');
                }
            });
        }

        function updateSubsubcategories(subcategoryId) {
            if (!subcategoryId) {
                subsubcategorySelect.empty().append('<option value="">Select Subsubcategory</option>');
                return;
            }
            
            $.ajax({
                url: `/products/get-subsubcategory/${subcategoryId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    subsubcategorySelect.empty().append('<option value="">Select Subsubcategory</option>');
                    $.each(data, function(index, subsubcategory) {
                        subsubcategorySelect.append(new Option(subsubcategory.name, subsubcategory.id));
                    });
                }
            });
        }

        function updateSubsubcategoriesBasedOnCategory(categoryId) {
            if (!categoryId) {
                subsubcategorySelect.empty().append('<option value="">Select Subsubcategory</option>');
                return;
            }
            
            $.ajax({
                url: `/products/getSubsubcategoriesByCategory/${categoryId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    subsubcategorySelect.empty().append('<option value="">Select Subsubcategory</option>');
                    $.each(data, function(index, subsubcategory) {
                        subsubcategorySelect.append(new Option(subsubcategory.name, subsubcategory.id));
                    });
                }
            });
        }

        function previewImages(files) {
            const previewArea = $('#imagePreview');
            const previewContainer = $('#previewContainer');
            
            previewContainer.empty();
            
            if (files.length > 0) {
                previewArea.show();
                
                Array.from(files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imagePreview = $(`
                                <div class="image-preview-item mr-3 mb-3 position-relative">
                                    <img src="${e.target.result}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                    <span class="badge badge-primary position-absolute" style="top: 5px; left: 5px;">
                                        ${index === 0 ? 'Main' : index + 1}
                                    </span>
                                    <button type="button" class="btn btn-danger btn-sm position-absolute remove-image" 
                                            style="top: 5px; right: 5px; padding: 2px 6px;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            `);
                            previewContainer.append(imagePreview);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                previewArea.hide();
            }
        }

        // Handle remove image from preview
        $(document).on('click', '.remove-image', function() {
            $(this).closest('.image-preview-item').remove();
            
            if ($('.image-preview-item').length === 0) {
                $('#imagePreview').hide();
                imageInput.val('');
            }
        });

        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
            
            $('.container h2').after(alertHtml);
            
            // Auto-hide success alerts after 5 seconds
            if (type === 'success') {
                setTimeout(function() {
                    $('.alert-success').fadeOut();
                }, 5000);
            }
        }
    });
</script>
<?= $this->endSection() ?>