<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/exchange-requests.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    function generateRatingStars($isRated, $rating, $requestId, $receiverId, $senderId)
    {
        $stars = '<div class="rating-system" data-id="' . $requestId . '" data-receiver="' . $receiverId . '" data-sender="' . $senderId . '">';
        if ($isRated) {
            for ($i = 1; $i <= 5; $i++) {
                $stars .= '<span class="rating-star-disabled ' . ($i <= $rating ? 'filled' : '') . '" data-value="' . $i . '"><i class="fa fa-star"></i></span>';
            }
        } else {
            for ($i = 1; $i <= 5; $i++) {
                $stars .= '<span class="rating-star" data-value="' . $i . '"><i class="fa fa-star"></i></span>';
            }
        }
        $stars .= '</div>';
        return $stars;
    } 
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Albums Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Albums</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($totalAlbumsCount) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Cards Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Cards</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($totalDuplicateCardsCount) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-th fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($pendingRequestsCount) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Completed Exchanges Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completed Exchanges</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($completedExchangesCount) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informational Text -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Welcome to the Ultimate Sticker Exchange Platform!</h6>
                </div>
                <div class="card-body">
                    <p>Our web application is designed to make the process of collecting and trading stickers for your albums seamless and enjoyable. Whether you're a passionate collector or just getting started, our platform provides all the tools you need to manage your albums and complete your collections. Explore the features we offer:</p>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>View All Possible Exchanges:</strong> Discover available sticker exchanges with other users. Find the stickers you need and offer your duplicates for trade.</li>
                        <li class="list-group-item"><strong>Add Album:</strong> Easily create and manage your sticker albums. Keep track of your collections and add new albums as you expand your hobby.</li>
                        <li class="list-group-item"><strong>Add Cards to Album:</strong> Keep your albums up-to-date by adding your newly acquired stickers. Ensure your collection is always current.</li>
                        <li class="list-group-item"><strong>Remove Album:</strong> If you no longer wish to track a specific album, you can remove it from your collection with a few simple clicks.</li>
                        <li class="list-group-item"><strong>Remove Cards from Album:</strong> Organize your albums by removing stickers that are no longer part of your collection.</li>
                        <li class="list-group-item"><strong>Send Exchange Request:</strong> Found a sticker you need? Send an exchange request to the owner and propose a trade.</li>
                        <li class="list-group-item"><strong>Receive Exchange Request:</strong> Get notified when another user wants to trade stickers with you. Review their offer and decide how to proceed.</li>
                        <li class="list-group-item"><strong>Accept, Decline, or Delete Requests:</strong> Manage your exchange requests with ease. Accept or decline offers, or delete requests that no longer interest you.</li>
                        <li class="list-group-item"><strong>Mark Exchange Request as Completed:</strong> Once an exchange is successfully completed, mark it as such to keep your exchange history organized.</li>
                        <li class="list-group-item"><strong>Rate Other Users:</strong> After completing an exchange, rate the other user based on your experience. Help build a trustworthy community of collectors.</li>
                        <li class="list-group-item"><strong>View My Albums:</strong> Access and manage all your sticker albums from one convenient location. Track your progress and plan future exchanges.</li>
                    </ul>
                    <p class="mt-3">This application is your one-stop solution for managing sticker exchanges, making it easier than ever to complete your collections. Happy collecting!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Exchange Requests -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Exchange Requests</h6>
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
                            <?php foreach ($recentRequests as $request): ?>
                            <tr>
                                <td><?= esc($request['first_name']) . ' '. esc($request['last_name']); ?></td>
                                <td><?= esc($request['album_id']) ?></td>
                                <td><?= esc($request['status']) ?></td>
                                <td><?= esc($request['cards_offered']) ?></td>
                                <td><?= esc($request['cards_requested']) ?></td>
                                <td class="cell-action">
                                    <?php if ($request['status'] == 'pending'): ?>
                                        <!-- Action buttons for pending requests -->
                                        <div class="btn btn-success btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="accept">Accept</div>
                                        <div class="btn btn-warning btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="decline">Decline</div>
                                        <div class="btn btn-danger btn-sm handleRequest" data-id="<?= $request['id']; ?>" data-type="delete" onclick="return confirm('Are you sure?')">Delete</div>
                                    <?php elseif ($request['status'] == 'accepted'): ?>
                                        <!-- Additional check for completion status -->
                                        <?php if (!$request['sender_completed'] && $currentUser == $request['sender_id']): ?>
                                            <button class="btn btn-info btn-sm markAsCompleteBtn" onclick="markAsCompleted(<?= $request['id']; ?>, <?= $currentUser; ?>, this)">Mark as Completed</button>
                                        <?php elseif (!$request['receiver_completed'] && $currentUser == $request['receiver_id']): ?>
                                            <button class="btn btn-info btn-sm markAsCompleteBtn" onclick="markAsCompleted(<?= $request['id']; ?>, <?= $currentUser; ?>, this)">Mark as Completed</button>
                                        <?php else: ?>
                                            <?= generateRatingStars($request['is_rated'], $request['rating']['rating'], $request['id'], $request['receiver_id'], $request['sender_id']) ?>
                                        <?php endif; ?>
                                    <?php elseif ($request['status'] == 'completed'): ?>
                                        <?= generateRatingStars($request['is_rated'], $request['rating']['rating'], $request['id'], $request['receiver_id'], $request['sender_id']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">User2 added a new card to Album 3</li>
                        <li class="list-group-item">User3 sent an exchange request for Card 8</li>
                        <!-- More items as needed -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Albums Overview Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Albums Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="albumsOverviewChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Exchanges Overview Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exchanges Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="exchangesOverviewChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= site_url('logout') ?>">Logout</a>
            </div>
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
<script>
    $(document).ready(function() {
        $('.handleRequest').click(function() {
            var btn = $(this);
            var id = btn.data('id');
            var type = btn.data('type');
            $.ajax({
                url: '/exchange-requests/' + type + '/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        infoMessage(response.message, response.status);
                        location.reload();
                    } else {
                        infoMessage(response.message, 'danger');
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        });
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
    });
    function generateRatingStars(isRated, rating, requestId, receiverId, senderId) {
        let stars = `<div class="rating-system" data-id="${requestId}" data-receiver="${receiverId}" data-sender="${senderId}">`;
        if (isRated) {
            for (let i = 1; i <= 5; i++) {
                stars += `<span class="rating-star-disabled ${i <= rating ? 'filled' : ''}" data-value="${i}"><i class="fa fa-star"></i></span>`;
            }
        } else {
            stars += `
                <span class="rating-star" data-value="1"><i class="fa fa-star"></i></span>
                <span class="rating-star" data-value="2"><i class="fa fa-star"></i></span>
                <span class="rating-star" data-value="3"><i class="fa fa-star"></i></span>
                <span class="rating-star" data-value="4"><i class="fa fa-star"></i></span>
                <span class="rating-star" data-value="5"><i class="fa fa-star"></i></span>
            `;
        }
        stars += '</div>';
        return stars;
    }
    function markAsCompleted(requestId, userId, btnRef) {
            $.ajax({
                url: '/exchange-requests/mark-as-completed',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify({ requestId: requestId, userId: userId }),
                contentType: 'application/json',
                success: function(data) {
                    if (data.status === 'success') {
                        infoMessage(data.message, 'success');
                        var parentCellAction = $(btnRef).closest('.cell-action');
                        $(btnRef).remove();
                        let rateElem = generateRatingStars(false, 0, requestId, userId, userId);
                        $(parentCellAction).append(rateElem);
                    } else {
                        infoMessage(data.message, 'danger');
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        }
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
                        location.reload();
                    } else {
                        infoMessage(response.message, 'danger');
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        });
</script>
<?= $this->endSection() ?>