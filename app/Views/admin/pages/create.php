<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Create New Page</h2>
    <form action="<?= site_url('/pages/store') ?>" method="post">
        <div class="form-group">
            <label for="name">Page Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="url_slug">URL Slug</label>
            <input type="text" class="form-control" id="url_slug" name="url_slug" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="is_active">Is Active</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Page</button>
        <a href="/pages" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script>
    tinymce.init({
        selector: 'textarea#content',
        menubar: true,
        branding: false,
        plugins: [
          'autosave', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
          'code', 'searchreplace', 'media', 'table', 'importcss', 'help', 'nonbreaking'
        ],
        toolbar: 'undo redo | blocks | bold italic forecolor backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent | removeformat code importcss link | table | image media',
        setup: function (editor) {
            editor.on('init', function () {
                // Remove the Promotion button if it is present
                const promoButton = document.querySelector('.tox-promotion');
                if (promoButton) {
                    promoButton.style.display = 'none';
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>