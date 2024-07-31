
<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/chat.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="container chat-container">
        <div class="row">
            <div class="col-md-4">
                <div class="message-list border rounded bg-white p-3">
                    <h5>Messages</h5>
                    <div id="messages"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="chat-view border rounded bg-white p-3">
                    <div id="chatContent">
                        <h5>Select a message to view</h5>
                    </div>
                    <div class="mt-4" id="replySection" style="display: none;">
                        <form id="replyForm">
                            <div class="mb-3">
                                <label for="replyContent" class="form-label">Your Message</label>
                                <textarea class="form-control" id="replyContent" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Reply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Load messages list
            function loadMessages() {
                $.ajax({
                    url: '/chat/messages',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var messages = '';
                        data.forEach(function(message) {
                            messages += '<div class="chat-message" data-id="' + message.id + '">';
                            messages += '<strong>From: ' + message.sender_user_id + '</strong>';
                            messages += '<div class="timestamp">' + message.timestamp + '</div>';
                            messages += '<p>' + message.content.substring(0, 50) + '...</p>';
                            messages += '</div>';
                        });
                        $('#messages').html(messages);
                    }
                });
            }

            loadMessages();

            // Load selected message
            $(document).on('click', '.chat-message', function() {
                var messageId = $(this).data('id');
                $.ajax({
                    url: '/chat/message/' + messageId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#chatContent').html('');
                        $('#chatContent').append('<div class="d-flex justify-content-between align-items-center"><span class="fw-bold">From: ' + data.sender_user_id + '</span><span class="timestamp">' + data.timestamp + '</span></div>');
                        $('#chatContent').append('<div class="message-content">' + data.content + '</div>');
                        $('#replySection').show();
                        $('#replyForm').data('message-id', messageId);
                    }
                });
            });

            // Send reply
            $('#replyForm').submit(function(event) {
                event.preventDefault();
                var messageId = $(this).data('message-id');
                var replyContent = $('#replyContent').val();
                $.ajax({
                    url: '/chat/send-reply',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        messageId: messageId,
                        content: replyContent
                    }),
                    success: function(response) {
                        if (response.success) {
                            alert('Reply sent successfully!');
                            $('#replyContent').val('');
                            loadMessages();
                        } else {
                            alert('Error sending reply.');
                        }
                    }
                });
            });
        });
    </script>
<?= $this->endSection() ?>