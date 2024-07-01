
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
        <a href="#" class="btn btn-primary mt-3" data-toggle="modal" data-target="#replyModal">Reply</a>
    </div>
    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('/chat/send-message') ?>" method="post">
                        <input type="hidden" name="receiver_user_id" value="<?= $message['sender_user_id']; ?>">
                        <div class="form-group">
                            <label for="message-content" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-content" name="content"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Attach a submit event handler to the form
            $("#replyModal form").submit(function(e) {
                // Prevent the form's default submission
                e.preventDefault();

                // Collect form data
                var formData = $(this).serialize(); // This collects all the form data

                // Make the AJAX call
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'), // or directly "<?= base_url('/chat/send-message') ?>"
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        // Handle success
                        alert("Reply sent successfully!");
                        $('#replyModal').modal('hide'); // Hide the modal
                        // Optionally, clear the form fields
                        $("#replyModal form")[0].reset();
                    },
                    error: function() {
                        // Handle error
                        alert("An error occurred. Please try again.");
                    }
                });
            });
        });
    </script>
<?= $this->endSection() ?>