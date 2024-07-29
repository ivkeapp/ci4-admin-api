<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Edit Album Collection</h1>
    <form action="<?= site_url('admin/albums/edit/' . $album['id']) ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= esc($album['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            <small>Current Image:</small>
            <img src="<?= esc($album['image']) ?>" alt="Current Image" style="max-width: 100px;">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?= esc($album['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="publisher">Publisher</label>
            <input type="text" name="publisher" id="publisher" class="form-control" value="<?= esc($album['publisher']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<?= $this->endSection() ?>