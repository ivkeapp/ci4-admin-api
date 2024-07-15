<?= $this->extend('header') ?>

<?= $this->section('content') ?>
    <div class="container mt-5">
        <?php foreach ($messages as $message): ?>
            <?php
            // Determine the card's background color and status text based on the message status
            switch ($message['status']) {
                case 'unread':
                    $statusClass = 'bg-warning';
                    $statusText = 'Unread';
                    break;
                case 'read':
                    $statusClass = 'bg-light';
                    $statusText = 'Read';
                    break;
                case 'replied':
                    $statusClass = 'bg-success text-white';
                    $statusText = 'Responded';
                    break;
                default:
                    $statusClass = 'bg-light';
                    $statusText = 'Unknown Status';
                    break;
            }
            ?>
            <div class="card mb-3 <?= $statusClass ?>">
                <div class="card-header">
                    Message from ID: <?= esc($message['sender_user_id']) ?> on <?= esc($message['timestamp']) ?>
                    <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Message Preview:</h5>
                    <p class="card-text"><?= esc(implode(' ', array_slice(explode(' ', $message['content']), 0, 5))) ?>...</p>
                    <a href="<?= site_url('chat/' . $message['id']) ?>" class="btn btn-primary">View Chat</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?= $this->endSection() ?>