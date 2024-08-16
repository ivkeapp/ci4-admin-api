
<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="container chat-container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= esc($page['name']) ?></h1>
                <p><strong>Description:</strong> <?= esc($page['description']) ?></p>
                <p><strong>Content:</strong> <?= esc($page['content']) ?></p>
                <p><strong>URL Slug:</strong> <?= esc($page['url_slug']) ?></p>
                <p><strong>Created At:</strong> <?= esc($page['datetime_created']) ?></p>
                <p><strong>Updated At:</strong> <?= esc($page['datetime_updated']) ?></p>
                <p><strong>Created By User ID:</strong> <?= esc($page['user_created']) ?></p>
                <p><strong>Updated By User ID:</strong> <?= esc($page['user_updated']) ?></p>
                <p><strong>Is Active:</strong> <?= esc($page['is_active']) ? 'Yes' : 'No' ?></p>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // TBD
        });
    </script>
<?= $this->endSection() ?>