<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-images text-primary"></i> Product Images Management
        </h1>
        <a href="<?= site_url('/products') ?>" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Back to Products
        </a>
    </div>

    <!-- Flash Messages -->
    <div id="flashMessages"></div>

    <div class="row">
        <!-- Upload Section -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Upload Product Images</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Actions:</div>
                            <a class="dropdown-item" href="#" id="clearSelection">Clear Selection</a>
                            <a class="dropdown-item" href="#" id="selectAll">Select All Images</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="imageUploadForm" action="<?= site_url('/products/storeImages') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- Product Selection -->
                        <div class="form-group">
                            <label for="product_id" class="font-weight-bold">
                                <i class="fas fa-box text-info"></i> Select Product
                            </label>
                            <select class="form-control form-control-lg" id="product_id" name="product_id" required>
                                <option value="">Choose a product to upload images...</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id'] ?>" data-sku="<?= $product['sku'] ?>">
                                        <?= $product['short_name'] ?> (SKU: <?= $product['sku'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- File Upload Area -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-cloud-upload-alt text-success"></i> Product Images
                            </label>
                            
                            <!-- Drag and Drop Zone -->
                            <div id="dropZone" class="border border-dashed rounded p-4 text-center" style="border-color: #d1d3e2; background-color: #f8f9fc; min-height: 200px; cursor: pointer;">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Drag & Drop Images Here</h5>
                                    <p class="text-muted mb-3">or click to browse files</p>
                                    <button type="button" class="btn btn-outline-primary" id="browseButton">
                                        <i class="fas fa-folder-open"></i> Browse Files
                                    </button>
                                </div>
                                <div class="drop-zone-overlay" style="display: none;">
                                    <i class="fas fa-download fa-3x text-primary"></i>
                                    <h5 class="text-primary">Drop images here</h5>
                                </div>
                            </div>
                            
                            <input type="file" class="d-none" id="product_images" name="product_images[]" multiple accept="image/*" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Supported formats: JPG, PNG, GIF, WebP. Maximum 10 images at once.
                            </small>
                        </div>

                        <!-- Image Preview Area -->
                        <div id="imagePreview" class="mt-4" style="display: none;">
                            <h6 class="font-weight-bold text-dark">
                                <i class="fas fa-eye text-info"></i> Image Preview
                            </h6>
                            <div id="previewContainer" class="row"></div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success btn-lg" id="uploadButton">
                                    <i class="fas fa-upload"></i> Upload Images
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg ml-2" id="clearPreview">
                                    <i class="fas fa-times"></i> Clear All
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Info Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Product Information
                    </h6>
                </div>
                <div class="card-body">
                    <div id="productInfo" style="display: none;">
                        <div class="text-center mb-3">
                            <div id="productAvatar" class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-box text-white"></i>
                            </div>
                        </div>
                        <h6 id="productName" class="text-dark font-weight-bold text-center"></h6>
                        <p id="productSku" class="text-muted text-center mb-3"></p>
                        <div class="progress mb-3">
                            <div id="uploadProgress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div id="imageStats" class="text-center">
                            <span class="badge badge-info" id="imageCount">0 images</span>
                        </div>
                    </div>
                    <div id="noProductSelected" class="text-center text-muted">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p>Select a product to view information</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar"></i> Quick Stats
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalProducts"><?= count($products) ?></div>
                            <small class="text-muted">Total Products</small>
                        </div>
                        <div class="col-6">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="selectedImages">0</div>
                            <small class="text-muted">Selected Images</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Images Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-images"></i> Existing Images
            </h6>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-danger" id="deleteSelected" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning" id="deleteAll" style="display: none;">
                    <i class="fas fa-trash-alt"></i> Delete All
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="existingImages" class="row">
                <div class="col-12 text-center text-muted">
                    <i class="fas fa-image fa-3x mb-3"></i>
                    <p>Select a product to view existing images</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <h5>Processing images...</h5>
                <p class="text-muted">Please wait while we upload your images.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .drop-zone-content {
        transition: opacity 0.3s ease;
    }
    
    .drop-zone-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(78, 115, 223, 0.1);
        border: 2px dashed #4e73df;
        border-radius: 0.375rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    #dropZone {
        position: relative;
        transition: all 0.3s ease;
    }
    
    #dropZone:hover {
        background-color: #e3f2fd !important;
        border-color: #4e73df !important;
    }
    
    #dropZone.drag-over {
        background-color: rgba(78, 115, 223, 0.1) !important;
        border-color: #4e73df !important;
        transform: scale(1.02);
    }
    
    .image-item {
        position: relative;
        margin: 10px;
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }
    
    .image-item:hover {
        border-color: #4e73df;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transform: translateY(-2px);
    }
    
    .image-item.selected {
        border-color: #1cc88a;
        box-shadow: 0 0 0 3px rgba(28, 200, 138, 0.3);
    }
    
    .image-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
    }
    
    .image-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 30px 10px 10px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    
    .image-item:hover .image-actions {
        transform: translateY(0);
    }
    
    .main-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
    }
    
    .image-checkbox {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
        width: 20px;
        height: 20px;
    }
    
    .preview-image {
        position: relative;
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        overflow: hidden;
        background: white;
        margin-bottom: 20px;
    }
    
    .preview-image img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .preview-actions {
        position: absolute;
        top: 5px;
        right: 5px;
    }
    
    .preview-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        font-size: 12px;
    }
</style>

<script src="/vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    let selectedImages = [];
    let dragCounter = 0;
    
    const productSelect = $('#product_id');
    const imageInput = $('#product_images');
    const dropZone = $('#dropZone');
    const imageUploadForm = $('#imageUploadForm');
    const uploadButton = $('#uploadButton');
    const loadingModal = $('#loadingModal');
    
    // Product selection handler
    productSelect.change(function() {
        const productId = $(this).val();
        const selectedOption = $(this).find('option:selected');
        
        if (productId) {
            showProductInfo(selectedOption);
            loadExistingImages(productId);
        } else {
            hideProductInfo();
            clearExistingImages();
        }
    });
    
    // File input change handler
    imageInput.change(function() {
        handleFileSelection(this.files);
    });
    
    // Browse button click
    $('#browseButton').click(function(e) {
        e.preventDefault();
        imageInput.click();
    });
    
    // Drop zone click
    dropZone.click(function(e) {
        if (e.target === this || $(e.target).hasClass('drop-zone-content')) {
            imageInput.click();
        }
    });
    
    // Drag and drop handlers
    dropZone.on('dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dragCounter++;
        $(this).addClass('drag-over');
        $('.drop-zone-content').hide();
        $('.drop-zone-overlay').show();
    });
    
    dropZone.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dragCounter--;
        if (dragCounter === 0) {
            $(this).removeClass('drag-over');
            $('.drop-zone-content').show();
            $('.drop-zone-overlay').hide();
        }
    });
    
    dropZone.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    dropZone.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dragCounter = 0;
        $(this).removeClass('drag-over');
        $('.drop-zone-content').show();
        $('.drop-zone-overlay').hide();
        
        const files = e.originalEvent.dataTransfer.files;
        handleFileSelection(files);
    });
    
    // Form submission
    imageUploadForm.submit(function(e) {
        e.preventDefault();
        
        if (!productSelect.val()) {
            showToast('error', 'Please select a product first.');
            return;
        }
        
        if (!imageInput[0].files.length) {
            showToast('error', 'Please select images to upload.');
            return;
        }
        
        uploadImages();
    });
    
    // Clear preview
    $('#clearPreview').click(function() {
        clearImagePreview();
    });
    
    // Image actions
    $(document).on('click', '.delete-image', function() {
        const imageId = $(this).data('id');
        deleteImage(imageId);
    });
    
    $(document).on('click', '.set-main-image', function() {
        const imageId = $(this).data('id');
        setMainImage(imageId);
    });
    
    $(document).on('change', '.image-checkbox', function() {
        updateSelectedImages();
    });
    
    $('#deleteSelected').click(function() {
        deleteSelectedImages();
    });
    
    $('#deleteAll').click(function() {
        const productId = productSelect.val();
        if (productId && confirm('Are you sure you want to delete ALL images for this product?')) {
            deleteAllImages(productId);
        }
    });
    
    function showProductInfo(option) {
        const productName = option.text().split(' (SKU:')[0];
        const productSku = option.data('sku');
        
        $('#productName').text(productName);
        $('#productSku').text(`SKU: ${productSku}`);
        $('#productInfo').show();
        $('#noProductSelected').hide();
    }
    
    function hideProductInfo() {
        $('#productInfo').hide();
        $('#noProductSelected').show();
    }
    
    function handleFileSelection(files) {
        if (files.length > 10) {
            showToast('warning', 'Maximum 10 images allowed at once.');
            return;
        }
        
        const validFiles = Array.from(files).filter(file => {
            return file.type.startsWith('image/');
        });
        
        if (validFiles.length !== files.length) {
            showToast('warning', 'Some files were skipped (only image files are allowed).');
        }
        
        if (validFiles.length > 0) {
            previewImages(validFiles);
            updateSelectedImagesCount(validFiles.length);
        }
    }
    
    function previewImages(files) {
        const previewContainer = $('#previewContainer');
        previewContainer.empty();
        
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewHtml = `
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="preview-image">
                            <img src="${e.target.result}" alt="Preview">
                            <div class="preview-actions">
                                <button type="button" class="btn btn-danger btn-sm remove-preview" data-index="${index}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="preview-label">
                                ${index === 0 ? '<i class="fas fa-star"></i> Main Image' : `Image ${index + 1}`}
                            </div>
                        </div>
                    </div>
                `;
                previewContainer.append(previewHtml);
            };
            reader.readAsDataURL(file);
        });
        
        $('#imagePreview').show();
    }
    
    function clearImagePreview() {
        $('#previewContainer').empty();
        $('#imagePreview').hide();
        imageInput.val('');
        updateSelectedImagesCount(0);
    }
    
    function loadExistingImages(productId) {
        $.ajax({
            url: `<?= site_url('/products/get-productimages') ?>/${productId}`,
            method: 'GET',
            success: function(data) {
                displayExistingImages(data);
                updateImageCount(data.length);
            },
            error: function() {
                showToast('error', 'Failed to load existing images.');
            }
        });
    }
    
    function displayExistingImages(images) {
        const container = $('#existingImages');
        container.empty();
        
        if (images.length === 0) {
            container.html(`
                <div class="col-12 text-center text-muted">
                    <i class="fas fa-image fa-3x mb-3"></i>
                    <p>No images found for this product</p>
                </div>
            `);
            $('#deleteAll').hide();
            return;
        }
        
        $('#deleteAll').show();
        
        images.forEach(image => {
            const imageHtml = `
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                    <div class="image-item" data-id="${image.id}">
                        <input type="checkbox" class="image-checkbox">
                        ${image.is_main == 1 ? '<span class="badge badge-warning main-badge"><i class="fas fa-star"></i> Main</span>' : ''}
                        <img src="<?= base_url() ?>/${image.image_path}" alt="Product Image">
                        <div class="image-actions">
                            <div class="btn-group btn-block">
                                <button class="btn btn-sm btn-danger delete-image" data-id="${image.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                ${image.is_main != 1 ? `<button class="btn btn-sm btn-primary set-main-image" data-id="${image.id}"><i class="fas fa-star"></i></button>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(imageHtml);
        });
    }
    
    function clearExistingImages() {
        $('#existingImages').html(`
            <div class="col-12 text-center text-muted">
                <i class="fas fa-image fa-3x mb-3"></i>
                <p>Select a product to view existing images</p>
            </div>
        `);
        $('#deleteAll').hide();
    }
    
    function uploadImages() {
        const formData = new FormData(imageUploadForm[0]);
        
        loadingModal.modal('show');
        uploadButton.prop('disabled', true);
        
        // Safety timeout to hide modal after 30 seconds
        const safetyTimeout = setTimeout(() => {
            console.warn('Upload taking too long, hiding modal');
            loadingModal.modal('hide');
            
            // Fallback to force hide modal
            setTimeout(() => {
                loadingModal.hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            }, 100);
            
            uploadButton.prop('disabled', false);
            showToast('warning', 'Upload is taking longer than expected. Please check if images were uploaded.');
        }, 30000);
        
        $.ajax({
            url: imageUploadForm.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Upload response:', response); // Debug log
                
                // Clear the safety timeout
                clearTimeout(safetyTimeout);
                
                // Always hide the modal first
                loadingModal.modal('hide');
                
                // Fallback to force hide modal if Bootstrap modal doesn't respond
                setTimeout(() => {
                    loadingModal.hide();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                }, 100);
                
                uploadButton.prop('disabled', false);
                
                if (response.status === 'success') {
                    showToast('success', 'Images uploaded successfully!');
                    clearImagePreview();
                    loadExistingImages(productSelect.val());
                } else {
                    showToast('error', 'Upload failed: ' + (response.errors ? response.errors.join(', ') : 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Upload error:', xhr, status, error); // Debug log
                
                // Clear the safety timeout
                clearTimeout(safetyTimeout);
                
                // Always hide the modal
                loadingModal.modal('hide');
                
                // Fallback to force hide modal if Bootstrap modal doesn't respond
                setTimeout(() => {
                    loadingModal.hide();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                }, 100);
                
                uploadButton.prop('disabled', false);
                showToast('error', 'Upload failed. Please try again.');
            }
        });
    }
    
    function deleteImage(imageId) {
        if (!confirm('Are you sure you want to delete this image?')) return;
        
        $.ajax({
            url: `<?= site_url('/products/deleteImage') ?>/${imageId}`,
            method: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', 'Image deleted successfully!');
                    loadExistingImages(productSelect.val());
                } else {
                    showToast('error', response.message);
                }
            },
            error: function() {
                showToast('error', 'Failed to delete image.');
            }
        });
    }
    
    function setMainImage(imageId) {
        $.ajax({
            url: `<?= site_url('/products/setMainImage') ?>/${imageId}`,
            method: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', 'Main image updated successfully!');
                    loadExistingImages(productSelect.val());
                } else {
                    showToast('error', response.message);
                }
            },
            error: function() {
                showToast('error', 'Failed to set main image.');
            }
        });
    }
    
    function updateSelectedImages() {
        selectedImages = $('.image-checkbox:checked').map(function() {
            return $(this).closest('.image-item').data('id');
        }).get();
        
        if (selectedImages.length > 0) {
            $('#deleteSelected').show();
        } else {
            $('#deleteSelected').hide();
        }
    }
    
    function deleteSelectedImages() {
        if (selectedImages.length === 0) return;
        
        if (!confirm(`Are you sure you want to delete ${selectedImages.length} selected images?`)) return;
        
        // Note: Batch delete endpoint needs to be implemented
        showToast('info', 'Batch delete functionality needs to be implemented.');
    }
    
    function deleteAllImages(productId) {
        $.ajax({
            url: `<?= site_url('/products/deleteAllImages') ?>/${productId}`,
            method: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', 'All images deleted successfully!');
                    loadExistingImages(productId);
                } else {
                    showToast('warning', response.message);
                }
            },
            error: function() {
                showToast('error', 'Failed to delete images.');
            }
        });
    }
    
    function updateSelectedImagesCount(count) {
        $('#selectedImages').text(count);
    }
    
    function updateImageCount(count) {
        $('#imageCount').text(`${count} images`);
    }
    
    function showToast(type, message) {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';
        
        const toastHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `;
        
        $('#flashMessages').html(toastHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }
    
    // Remove preview image
    $(document).on('click', '.remove-preview', function() {
        const index = $(this).data('index');
        $(this).closest('.col-md-3').remove();
        
        if ($('.preview-image').length === 0) {
            clearImagePreview();
        }
    });
});
</script>
<?= $this->endSection() ?>