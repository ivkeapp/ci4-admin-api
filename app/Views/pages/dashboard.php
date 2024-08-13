<?= $this->extend('header') ?>

<?= $this->section('content') ?>

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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">120</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sender</th>
                                <th>Card</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>User1</td>
                                <td>Card 5</td>
                                <td>Pending</td>
                                <td>
                                    <button class="btn btn-success btn-sm">Accept</button>
                                    <button class="btn btn-danger btn-sm">Decline</button>
                                </td>
                            </tr>
                            <!-- More rows as needed -->
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
<?= $this->endSection() ?>