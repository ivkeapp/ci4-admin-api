<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Add Cards to Album</h1>
    <form action="<?= site_url('admin/albums/add-cards') ?>" method="post">
        <div class="form-group">
            <label for="album_id">Select Album</label>
            <select name="album_id" id="album_id" class="form-control">
                <option value="">Select an album...</option>
                <?php foreach ($albums as $album): ?>
                    <option value="<?= esc($album['id']) ?>"><?= esc($album['title']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if ($validation && $validation->getError('album_id')): ?>
                <div class="text-danger"><?= $validation->getError('album_id') ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="cards">Cards (JSON) - TODO: find better idea</label>
            <textarea name="cards" id="cards" class="form-control"><?= old('cards') ?></textarea>
            <?php if ($validation && $validation->getError('cards')): ?>
                <div class="text-danger"><?= $validation->getError('cards') ?></div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="<?= site_url('admin/albums') ?>" class="btn btn-secondary mt-3">Back to Collection</a>
</div>
<?= $this->endSection() ?>
