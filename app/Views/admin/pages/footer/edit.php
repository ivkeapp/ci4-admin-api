<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Edit Footer</h2>
    
    <form action="/footer/update" method="post" enctype="multipart/form-data">
        <!-- Footer Columns -->
        <h3>Footer Columns</h3>
        <div id="columns-container">
            <?php if (!empty($columns)): ?>
                <?php foreach ($columns as $column): ?>
                    <div class="column-item mb-3">
                        <input type="text" class="form-control mb-2" name="columns[<?= $column['id'] ?>][title]" placeholder="Column Title" value="<?= esc($column['title']) ?>">
                        <textarea class="form-control mb-2" name="columns[<?= $column['id'] ?>][links]" placeholder="Links (JSON format)"><?= esc($column['links']) ?></textarea>
                        <button type="button" class="btn btn-sm btn-danger remove-column">Remove Column</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-success add-column">Add Column</button>

        <!-- Footer Images -->
        <h3>Footer Images</h3>
        <div id="images-container">
            <!-- Payment Images -->
            <h4>Payment Images</h4>
            <div id="payment-images">
                <?php foreach ($images as $image): ?>
                    <?php if ($image['type'] === 'payment'): ?>
                        <div class="form-group image-item" data-id="<?= esc($image['id']) ?>">
                            <!-- Display Image -->
                            <img src="<?= base_url($image['image']) ?>" alt="<?= esc($image['link']) ?>" class="img-thumbnail mb-2">
                            <!-- Input fields for image update -->
                            <input type="file" class="form-control mb-2" name="images[<?= $image['id'] ?>][image]">
                            <input type="text" class="form-control mb-2" name="images[<?= $image['id'] ?>][link]" placeholder="Image Link" value="<?= esc($image['link']) ?>">
                            <button type="button" class="btn btn-sm btn-danger remove-image">Remove Image</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-primary add-image" data-type="payment">Add Image to Payment Images</button>

            <!-- Social Images -->
            <h4>Social Images</h4>
            <div id="social-images">
                <?php foreach ($images as $image): ?>
                    <?php if ($image['type'] === 'social'): ?>
                        <div class="form-group image-item" data-id="<?= esc($image['id']) ?>">
                            <!-- Display Image -->
                            <img src="<?= base_url($image['image']) ?>" alt="<?= esc($image['link']) ?>" class="img-thumbnail mb-2">
                            <!-- Input fields for image update -->
                            <input type="file" class="form-control mb-2" name="images[<?= $image['id'] ?>][image]">
                            <input type="text" class="form-control mb-2" name="images[<?= $image['id'] ?>][link]" placeholder="Image Link" value="<?= esc($image['link']) ?>">
                            <button type="button" class="btn btn-sm btn-danger remove-image">Remove Image</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-primary add-image" data-type="social">Add Image to Social Images</button>
        </div>

        <!-- Footer Text -->
        <h3>Footer Text</h3>
        <div class="form-group">
            <textarea class="form-control" name="footer_text" rows="3"><?= esc($footerText ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
</div>

<script>
    // Add a new column
    document.querySelector('.add-column').addEventListener('click', function () {
        const container = document.getElementById('columns-container');
        if (!container) return;

        const timestamp = Date.now(); // Unique identifier for new columns
        const template = 
            `<div class="column-item mb-3">
                <input type="text" class="form-control mb-2" name="columns[new_${timestamp}][title]" placeholder="Column Title">
                <textarea class="form-control mb-2" name="columns[new_${timestamp}][links]" placeholder="Links (JSON format)"></textarea>
                <button type="button" class="btn btn-sm btn-danger remove-column">Remove Column</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', template);
    });

    // Add new image logic
    document.querySelectorAll('.add-image').forEach(button => {
        button.addEventListener('click', function () {
            const type = this.getAttribute('data-type'); // Get type from button
            const container = type === 'payment' ? document.getElementById('payment-images') : document.getElementById('social-images');

            const timestamp = Date.now();
            const newImageHTML = `
                <div class="form-group image-item" data-id="new_${timestamp}">
                    <input type="file" class="form-control mb-2" name="images[new_${timestamp}][image]">
                    <input type="text" class="form-control mb-2" name="images[new_${timestamp}][link]" placeholder="Image Link">
                    <input type="hidden" name="images[new_${timestamp}][type]" value="${type}">
                    <button type="button" class="btn btn-sm btn-danger remove-image">Remove Image</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newImageHTML);
        });
    });

    // Remove an element (column or image)
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-column')) {
            event.target.closest('.column-item').remove();
        } else if (event.target.classList.contains('remove-image')) {
            event.target.closest('.image-item').remove();
        }
    });

    $(document).ready(function () {
        // Event listener for remove image button click
        $(document).on('click', '.remove-image', function () {
            // Get the image ID (passed as a data attribute)
            var imageId = $(this).closest('.image-item').data('id');
            
            // Confirm delete action
            if (confirm('Are you sure you want to delete this image?')) {
                // Make AJAX request to delete the image
                $.ajax({
                    url: '<?= site_url("footerimages/deleteImage/") ?>' + imageId, // The controller method URL
                    method: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Remove the image block from the DOM
                            $('div[data-id="' + imageId + '"]').remove();
                            alert('Image deleted successfully');
                        } else {
                            alert('Error deleting image: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('An error occurred while deleting the image');
                    }
                });
            }
        });
    });

</script>

<?= $this->endSection() ?>
