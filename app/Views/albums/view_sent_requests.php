<?= $this->extend('header') ?>
<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/exchange-requests.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<input type="hidden" id="currentUser" value="<?= $currentUser ?>">
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Exchange Requests</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Exchange Requests</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Album ID</th>
                        <th>Status</th>
                        <th>Cards Offered</th>
                        <th>Cards Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exchangeRequests as $request): ?>
                    <tr>
                        <td><?= esc($request['first_name']) . ' '. esc($request['last_name']); ?></td>
                        <td><?= esc($request['album_id']) ?></td>
                        <td><?= esc($request['status']) ?></td>
                        <td><?= esc($request['cards_offered']) ?></td>
                        <td><?= esc($request['cards_requested']) ?></td>
                        <td class="cell-action">
                            <?php if ($request['status'] == 'pending'): ?>
                                <div class="btn btn-danger btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="delete" onclick="return confirm('Are you sure?')">Delete</div>
                            <?php elseif ($request['status'] == 'accepted'): ?>
                                <?php if (!$request['sender_completed'] && $currentUser == $request['sender_id']): ?>
                                    <button class="btn btn-info btn-sm markAsCompleteBtn" onclick="markAsCompleted(<?= $request['id'] ?>, <?= $currentUser ?>, this)">Mark as Completed</button>
                                <?php elseif (!$request['receiver_completed'] && $currentUser == $request['receiver_id']): ?>
                                    <button class="btn btn-info btn-sm markAsCompleteBtn" onclick="markAsCompleted(<?= $request['id'] ?>, <?= $currentUser ?>, this)">Mark as Completed</button>
                                <?php else: ?>
                                    <?php if ($request['is_rated']): ?>
                                        <div class="rating-system" data-id="<?= $request['id']; ?>" data-receiver="<?= $request['sender_id'] ?>" data-sender="<?= $request['receiver_id'] ?>">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="rating-star-disabled <?= $i <= $request['rating']['rating'] ? 'filled' : '' ?>" data-value="<?= $i ?>"><i class="fa fa-star"></i></span>
                                            <?php endfor; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="rating-system" data-id="<?= $request['id']; ?>" data-receiver="<?=$request['sender_id']?>" data-sender="<?=$request['receiver_id']?>">
                                            <span class="rating-star" data-value="1"><i class="fa fa-star"></i></span>
                                            <span class="rating-star" data-value="2"><i class="fa fa-star"></i></span>
                                            <span class="rating-star" data-value="3"><i class="fa fa-star"></i></span>
                                            <span class="rating-star" data-value="4"><i class="fa fa-star"></i></span>
                                            <span class="rating-star" data-value="5"><i class="fa fa-star"></i></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php elseif ($request['status'] == 'completed'): ?>
                                <?php if ($request['is_rated']): ?>
                                    <div class="rating-system" data-id="<?= $request['id']; ?>" data-receiver="<?= $request['sender_id'] ?>" data-sender="<?= $request['receiver_id'] ?>">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="rating-star-disabled <?= $i <= $request['rating']['rating'] ? 'filled' : '' ?>" data-value="<?= $i ?>"><i class="fa fa-star"></i></span>
                                        <?php endfor; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="rating-system" data-id="<?= $request['id']; ?>" data-receiver="<?=$request['sender_id']?>" data-sender="<?=$request['receiver_id']?>">
                                        <span class="rating-star" data-value="1"><i class="fa fa-star"></i></span>
                                        <span class="rating-star" data-value="2"><i class="fa fa-star"></i></span>
                                        <span class="rating-star" data-value="3"><i class="fa fa-star"></i></span>
                                        <span class="rating-star" data-value="4"><i class="fa fa-star"></i></span>
                                        <span class="rating-star" data-value="5"><i class="fa fa-star"></i></span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Rating Modal-->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Rate user</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    <div class="form-group">
                        <label for="ratingDescription">Rating Description *</label>
                        <textarea type="text" rows="4" class="form-control" id="ratingDescription" name="ratingDescription" required placeholder="Describe how your exchange went with this user."></textarea>
                    </div>
                    <input type="hidden" id="requestId" name="requestId">
                    <input type="hidden" id="sender" name="sender">
                    <input type="hidden" id="receiver" name="receiver">
                    <input type="hidden" id="selectedStars" name="selectedStars">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" form="ratingForm">Submit Rating</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    $('.handleRequest').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        var type = btn.data('type');
        $.ajax({
            url: '/exchange-requests/'+type+'/'+id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                infoMessage(response.message, response.status);
                if(response.status === 'success') {
                    refreshTableData();
                    // alert(response.message);
                } else {
                    // alert(response.message);
                    // TODO: Error handling logic here
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    });
    function markAsCompleted(requestId, userId, btn) {
        $.ajax({
            url: '/exchange-requests/mark-as-completed',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ requestId: requestId, userId: userId }),
            contentType: 'application/json',
            success: function(data) {
                if (data.status === 'success') {
                    infoMessage(data.message, 'success');
                    // Optionally refresh the page or update the UI
                    refreshTableData();
                } else {
                    infoMessage(data.message, 'danger');
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    }
    // Handle hover event using event delegation
    $(document).on('mouseenter', '.rating-star', function() {
        const value = $(this).data('value');
        const $currentRow = $(this).closest('tr'); // Adjust the selector to match your row class
        $currentRow.find('.rating-star').each(function() {
            if ($(this).data('value') <= value) {
                $(this).addClass('filled');
            } else {
                $(this).removeClass('filled');
            }
        });
    });

    $(document).on('mouseleave', '.rating-star', function() {
        $('.rating-star').removeClass('filled');
    });

    // Handle click event on rating stars
    $(document).on('click', '.rating-star', function() {
        let ratingHolder = $(this).closest('.rating-system');
        const id = $(ratingHolder).data('id');
        const receiver = $(ratingHolder).data('receiver');
        const sender = $(ratingHolder).data('sender');
        const selectedStars = $(this).data('value');
        $('#requestId').val(id);
        $('#receiver').val(receiver);
        $('#sender').val(sender);
        $('#selectedStars').val(selectedStars);
        $('#ratingModal').modal('show');
    });

    // Handle form submission
    $('#ratingForm').on('submit', function(event) {
        event.preventDefault();
        const ratingData = {
            exchange_request_id: $('#requestId').val(),
            rated_user_id: $('#sender').val(),
            rating_description: $('#ratingDescription').val(),
            rating: $('#selectedStars').val()
        };

        $.ajax({
            url: '/ratings/rate',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(ratingData),
            contentType: 'application/json',
            success: function(response) {
                console.log(response, 'response');
                if (response.status === 'success') {
                    infoMessage(response.message, 'success');
                    $('#ratingModal').modal('hide');
                    $('#ratingDescription').val('');
                    // Refresh the table data
                    refreshTableData();
                } else {
                    infoMessage(response.message, 'danger');
                }
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    });
    function refreshTableData() {
        $.ajax({
            url: '/exchange-requests/sent-requests',
            type: 'GET',
            success: function(data) {
                const $tableBody = $('#dataTable tbody');
                $tableBody.empty();
                var currentUser = $('#currentUser').val();

                // Assuming you have already initialized DataTables on your table
                var table = $('#dataTable').DataTable();
                table.clear();

                data.forEach(request => {
                    const isRated = request.is_rated;
                    const isSender = currentUser == request.sender_id;
                    const isReceiver = currentUser == request.receiver_id;
                    const isPending = request.status === 'pending';
                    const isAccepted = request.status === 'accepted';
                    const isCompleted = request.status === 'completed';

                    let ratingHtml = '';

                    if (isPending) {
                        // Pending status logic
                        if(!isSender) {
                            ratingHtml = `<div class="btn btn-success btn-sm handleRequest" data-id="${request.id}" data-type="accept">Accept</div>
                            <div class="btn btn-warning btn-sm handleRequest" data-id="${request.id}" data-type="decline">Decline</div>`;
                        }
                        ratingHtml = `
                            <div class="btn btn-danger btn-sm handleRequest" data-id="${request.id}" data-type="delete" onclick="return confirm('Are you sure?')">Delete</div>
                        `;
                    } else if (isAccepted) {
                        // Accepted status logic
                        if (request.sender_completed === "0" && isSender) {
                            ratingHtml = `<button class="btn testttt btn-info btn-sm markAsCompleteBtn" onclick="markAsCompleted(${request.id}, ${currentUser}, this)">Mark as Completed</button>`;
                        } else if (request.receiver_completed === "0" && isSender) {
                            ratingHtml = `<button class="btn testttt2 btn-info btn-sm markAsCompleteBtn" onclick="markAsCompleted(${request.id}, ${currentUser}, this)">Mark as Completed</button>`;
                        } else {
                            ratingHtml = generateRatingStars(isRated, request.rating ? request.rating.rating : 0, request.id, request.receiver_id, request.sender_id);
                        }
                    } else if (isCompleted) {
                        // Completed status logic
                        ratingHtml = generateRatingStars(isRated, request.rating ? request.rating.rating : 0, request.id, request.receiver_id, request.sender_id);
                    }

                    const row = [
                        escapeHtml(request.first_name) + ' ' + escapeHtml(request.last_name),
                        escapeHtml(request.album_id),
                        escapeHtml(request.status),
                        escapeHtml(request.cards_offered),
                        escapeHtml(request.cards_requested),
                        ratingHtml
                    ];

                    // Add the new row using DataTables API
                    table.row.add(row);
                });

                // Draw the table to update and recalculate paging, sorting, etc.
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching updated data:', error);
            }
        });
    }
    function generateRatingStars(isRated, rating, requestId, receiverId, senderId) {
        let stars = `<div class="rating-system" data-id="${requestId}" data-receiver="${senderId}" data-sender="${receiverId}">`;
        if (isRated) {
            for (let i = 1; i <= 5; i++) {
                stars += `<span class="rating-star-disabled ${i <= rating ? 'filled' : ''}" data-value="${i}"><i class="fa fa-star"></i></span>`;
            }
        } else {
            stars = `
                <div class="rating-system" data-id="${requestId}" data-receiver="${senderId}" data-sender="${receiverId}">
                    <span class="rating-star" data-value="1"><i class="fa fa-star"></i></span>
                    <span class="rating-star" data-value="2"><i class="fa fa-star"></i></span>
                    <span class="rating-star" data-value="3"><i class="fa fa-star"></i></span>
                    <span class="rating-star" data-value="4"><i class="fa fa-star"></i></span>
                    <span class="rating-star" data-value="5"><i class="fa fa-star"></i></span>
                </div>
            `;
        }
        stars += '</div>';
        return stars;
    }
    function escapeHtml(text) {
        return text.replace(/[\"&'\/<>]/g, function (a) {
            return {
                '"': '&quot;',
                '&': '&amp;',
                "'": '&#39;',
                '/': '&#47;',
                '<': '&lt;',
                '>': '&gt;'
            }[a];
        });
    }
</script>
<?= $this->endSection() ?>