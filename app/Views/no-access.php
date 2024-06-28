<?= $this->extend('header') ?>

<?= $this->section('content') ?>
    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="404">403</div>
        <p class="lead text-gray-800 mb-5">Access Denied</p>
        <p class="text-gray-500 mb-0">It looks like you love to explore forbidden...</p>
        <a href="<?= base_url(); ?>">&larr; Back to Dashboard</a>
    </div>
<?= $this->endSection() ?>