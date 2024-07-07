<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800"><?= esc($cardAlbum['title']) ?></h1>
    <p><?= esc($cardAlbum['description']) ?></p>
    <a href="<?= site_url('my-collection') ?>" class="btn btn-secondary">Back to Collection</a>
    <h4 class="mt-4">Cards</h4>
    <pre><?= json_encode(json_decode($cards['cards']), JSON_PRETTY_PRINT) ?></pre>
</div>
<?= $this->endSection() ?>
