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
            <label for="cards">My duplicates</label>
            <?php foreach ($albumCards as $card): ?>
                <div class="form-check">
                    <input type="checkbox" name="cards[]" value="<?= esc($card['id']) ?>" class="form-check-input" id="card<?= esc($card['id']) ?>" <?= $card['selected'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="card<?= esc($card['id']) ?>">Card ID: <?= esc($card['id']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="form-group">
            <label for="needed_cards">Needed Cards</label>
            <?php foreach ($neededAlbumCards as $neededCard): ?>
                <div class="form-check">
                    <input type="checkbox" name="needed_cards[]" value="<?= esc($neededCard['id']) ?>" class="form-check-input" id="neededCard<?= esc($neededCard['id']) ?>" <?= $neededCard['selected'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="neededCard<?= esc($neededCard['id']) ?>">Card ID: <?= esc($neededCard['id']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="<?= site_url('my-collection') ?>" class="btn btn-secondary mt-3">Back to Collection</a>
</div>
<?= $this->endSection() ?>