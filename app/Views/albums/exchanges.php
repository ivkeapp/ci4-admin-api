<?= $this->extend('header') ?>
<?= $this->section('custom_styles') ?>
    <link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="container">
        <h1 class="h3 mb-2 text-gray-800">Potential Card Exchanges</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Exchanges Overview</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Album</th>
                                <th>Cards You Can Get</th>
                                <th>Cards You Can Give</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($potentialExchanges as $exchange): ?>
                            <tr>
                                <td><?= esc($exchange['user_name']) ?></td>
                                <td><?= esc($exchange['album_name']) ?></td>
                                <td><?= implode(', ', $exchange['matchesForCurrentUser']) ?></td>
                                <td><?= implode(', ', $exchange['matchesForOtherUser']) ?></td>
                                <td>
                                    <button 
                                    class="btn btn-primary send-exchange-request"
                                    data-sender-id="<?= esc($currentUser) ?>"
                                    data-receiver-id="<?= esc($exchange['user_id']) ?>"
                                    data-album-id="<?= esc($exchange['album_id']) ?>"
                                    data-cards-offered='<?= json_encode($exchange['matchesForOtherUser']) ?>'
                                    data-cards-requested='<?= json_encode($exchange['matchesForCurrentUser']) ?>'>Send Exchange Request</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            $('.send-exchange-request').click(function() {
                var btn = $(this);
                var senderId = btn.data('sender-id');
                var receiverId = btn.data('receiver-id');
                var albumId = btn.data('album-id');
                var cardsOffered = btn.data('cards-offered');
                var cardsRequested = btn.data('cards-requested');

                $.ajax({
                    url: '/albums/send-request',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        sender_id: senderId,
                        receiver_id: receiverId,
                        album_id: albumId,
                        cards_offered: cardsOffered,
                        cards_requested: cardsRequested,
                    }),
                    success: function(response) {
                        // console.log(response, 'response');
                        infoMessage(response.message, response.status);
                        if(response.status === 'success') {
                            // TODO: Reload the table instead of the whole page
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        // console.log(error, 'error');
                        // console.log(status, 'status');3
                        infoMessage('Failed to send exchange request.', 'danger');
                    }
                });
            });
        });
    </script>
<?= $this->endSection() ?>