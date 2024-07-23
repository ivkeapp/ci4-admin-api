<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div style="display: flex; margin-top: 20px;">
    <!-- Left Column for Album Image -->
    <div style="flex: 1; padding: 10px;">
        <img src="<?= site_url(esc($cardAlbum['image'])) ?>" alt="<?= esc($cardAlbum['title']) ?>" style="max-width: 100%; height: auto;">
    </div>

    <!-- Right Column for Album Details -->
    <div style="flex: 1; padding: 10px;">
        <h2><?= esc($cardAlbum['title']) ?></h2>
        <p>Description: <?= esc($cardAlbum['description']) ?></p>
        <p>Publisher: <?= esc($cardAlbum['publisher']) ?></p>
        <p>Publishing Year: <?= esc($cardAlbum['publishing_year']) ?></p>
        <p>Added: <?= date('F j, Y', strtotime($cardAlbum['created_at'])) ?></p>
        <!-- Add more album details here -->
    </div>
</div>
<?= $this->endSection() ?>
