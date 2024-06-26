
<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="container">
        <h2>Read Message</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">From: <?= esc($message['sender_user_id']); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Sent: <?= \CodeIgniter\I18n\Time::parse($message['timestamp'])->toLocalizedString('MMMM d, yyyy HH:mm'); ?></h6>
                <p class="card-text"><?= esc($message['content']); ?></p>
            </div>
        </div>
        <a href="<?= base_url('/chat/reply-message/' . $message['id']) ?>" class="btn btn-primary mt-3">Reply</a>
    </div>
<?= $this->endSection() ?>