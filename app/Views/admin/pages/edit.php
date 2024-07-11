<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Edit Page</h2>
    <form action="/pages/update/<?= esc($page['id']) ?>" method="post">
        <div class="form-group">
            <label for="name">Page Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= esc($page['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= esc($page['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="url_slug">URL Slug</label>
            <input type="text" class="form-control" id="url_slug" name="url_slug" value="<?= esc($page['url_slug']) ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?= esc($page['content']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="is_active">Is Active</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" <?= $page['is_active'] ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= !$page['is_active'] ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <!-- Assuming user_created, datetime_created, datetime_updated, and user_updated are managed by the system and not editable by the user -->
        <button type="submit" class="btn btn-primary">Update</button>
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
    });
</script>
<?= $this->endSection() ?>