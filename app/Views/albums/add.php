<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800"><?= esc($title) ?></h1>
    <form action="<?= site_url('albums/store') ?>" method="post">
        <div class="form-group">
            <label for="album_id">Select Album</label>
            <select name="album_id" id="album_id" class="form-control">
                <?php foreach ($albums as $album): ?>
                    <option value="<?= esc($album['id']) ?>"><?= esc($album['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="<?= site_url('my-collection') ?>" class="btn btn-secondary mt-3">Back to Collection</a>
</div>
<?= $this->endSection() ?>
