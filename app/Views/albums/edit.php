<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Edit Card Album</h1>
    <form action="<?= site_url('albums/update/' . $cardAlbum['id']) ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= esc($cardAlbum['title']) ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"><?= esc($cardAlbum['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="cards">Select Cards</label>
            <?php foreach ($albumCards as $card): ?>
                <div class="form-check">
                    <input type="checkbox" name="cards[]" value="<?= esc($card) ?>" class="form-check-input" id="card<?= esc($card) ?>">
                    <label class="form-check-label" for="card<?= esc($card) ?>">Card <?= esc($card) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="<?= site_url('my-collection') ?>" class="btn btn-secondary mt-3">Back to Collection</a>
</div>
<?= $this->endSection() ?>
