<?= $this->extend('header') ?>

<?= $this->section('content') ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Total Products Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Products</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalProducts) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Categories Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Categories</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalCategories) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Posts Progress Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Blog Posts
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= number_format($totalBlogPosts) ?></div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <?php 
                                                    $blogProgress = $totalBlogPosts > 0 ? min(($recentActivity['posts_30d'] / max($totalBlogPosts, 1)) * 100, 100) : 0;
                                                    ?>
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                        style="width: <?= $blogProgress ?>%" aria-valuenow="<?= $blogProgress ?>" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-blog fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unread Messages Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Unread Messages</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($unreadMessages) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row of Stats -->
                <div class="row">
                    <!-- Total Users Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-dark shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            Total Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalUsers) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pages Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                            Total Pages</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalPages) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Products (30 days) -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            New Products (30d)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($recentActivity['products_30d']) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Pages (30 days) -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            New Pages (30d)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($recentActivity['pages_30d']) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->

                <div class="row">

                    <!-- Monthly Products Line Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Monthly Product Additions</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Chart Options:</div>
                                        <a class="dropdown-item" href="#" onclick="refreshChart()">Refresh Data</a>
                                        <a class="dropdown-item" href="#" onclick="toggleChartType()">Toggle Chart Type</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" onclick="exportChart()">Export Chart</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="monthlyProductsChart"></canvas>
                                </div>
                                <hr>
                                <div class="text-center text-muted">
                                    <small>Products added over the last 12 months</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Distribution Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Product Categories</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink2">
                                        <div class="dropdown-header">View Options:</div>
                                        <a class="dropdown-item" href="#" onclick="showAllCategories()">Show All</a>
                                        <a class="dropdown-item" href="#" onclick="showTopCategories()">Top 5 Only</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?= site_url('categories') ?>">Manage Categories</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="categoryDistributionChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small" id="categoryLegend">
                                    <!-- Dynamic legend will be populated by JavaScript -->
                                </div>
                                <hr>
                                <div class="text-center text-muted">
                                    <small>Distribution of products by category</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg-6 mb-4">

                        <!-- Content Progress Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Content Management Progress</h6>
                            </div>
                            <div class="card-body">
                                <?php 
                                // Calculate progress percentages
                                $productGoal = 100;
                                $blogGoal = 50;
                                $pageGoal = 25;
                                $categoryGoal = 20;
                                
                                $productProgress = min(($totalProducts / $productGoal) * 100, 100);
                                $blogProgress = min(($totalBlogPosts / $blogGoal) * 100, 100);
                                $pageProgress = min(($totalPages / $pageGoal) * 100, 100);
                                $categoryProgress = min(($totalCategories / $categoryGoal) * 100, 100);
                                ?>
                                
                                <h4 class="small font-weight-bold">Product Catalog <span
                                        class="float-right"><?= number_format($productProgress, 1) ?>% (<?= $totalProducts ?>/<?= $productGoal ?>)</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar <?= $productProgress < 50 ? 'bg-danger' : ($productProgress < 80 ? 'bg-warning' : 'bg-success') ?>" 
                                         role="progressbar" style="width: <?= $productProgress ?>%"
                                         aria-valuenow="<?= $productProgress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <h4 class="small font-weight-bold">Blog Content <span
                                        class="float-right"><?= number_format($blogProgress, 1) ?>% (<?= $totalBlogPosts ?>/<?= $blogGoal ?>)</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar <?= $blogProgress < 50 ? 'bg-danger' : ($blogProgress < 80 ? 'bg-warning' : 'bg-success') ?>" 
                                         role="progressbar" style="width: <?= $blogProgress ?>%"
                                         aria-valuenow="<?= $blogProgress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <h4 class="small font-weight-bold">Static Pages <span
                                        class="float-right"><?= number_format($pageProgress, 1) ?>% (<?= $totalPages ?>/<?= $pageGoal ?>)</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar <?= $pageProgress < 50 ? 'bg-danger' : ($pageProgress < 80 ? 'bg-warning' : 'bg-success') ?>" 
                                         role="progressbar" style="width: <?= $pageProgress ?>%"
                                         aria-valuenow="<?= $pageProgress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <h4 class="small font-weight-bold">Product Categories <span
                                        class="float-right"><?= $categoryProgress >= 100 ? 'Complete!' : number_format($categoryProgress, 1) . '%' ?> (<?= $totalCategories ?>/<?= $categoryGoal ?>)</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar <?= $categoryProgress >= 100 ? 'bg-success' : ($categoryProgress < 50 ? 'bg-info' : 'bg-primary') ?>" 
                                         role="progressbar" style="width: <?= min($categoryProgress, 100) ?>%"
                                         aria-valuenow="<?= $categoryProgress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <h4 class="small font-weight-bold">Recent Activity (30 days) <span
                                        class="float-right"><?= $recentActivity['products_30d'] + $recentActivity['posts_30d'] + $recentActivity['pages_30d'] ?> items</span></h4>
                                <div class="progress">
                                    <?php 
                                    $recentTotal = max($recentActivity['products_30d'] + $recentActivity['posts_30d'] + $recentActivity['pages_30d'], 1);
                                    $productPortion = ($recentActivity['products_30d'] / $recentTotal) * 100;
                                    $postPortion = ($recentActivity['posts_30d'] / $recentTotal) * 100;
                                    $pagePortion = ($recentActivity['pages_30d'] / $recentTotal) * 100;
                                    ?>
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $productPortion ?>%"
                                         title="Products: <?= $recentActivity['products_30d'] ?>"></div>
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?= $postPortion ?>%"
                                         title="Posts: <?= $recentActivity['posts_30d'] ?>"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pagePortion ?>%"
                                         title="Pages: <?= $recentActivity['pages_30d'] ?>"></div>
                                </div>
                                <div class="mt-2 text-center small">
                                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Products (<?= $recentActivity['products_30d'] ?>)</span>
                                    <span class="mr-2"><i class="fas fa-circle text-info"></i> Posts (<?= $recentActivity['posts_30d'] ?>)</span>
                                    <span class="mr-2"><i class="fas fa-circle text-warning"></i> Pages (<?= $recentActivity['pages_30d'] ?>)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Price Analysis -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Product Price Distribution</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php if (!empty($productsByPrice)): ?>
                                        <?php foreach ($productsByPrice as $index => $priceRange): ?>
                                            <?php 
                                            $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                                            $color = $colors[$index % count($colors)];
                                            ?>
                                            <div class="col-lg-6 mb-3">
                                                <div class="card bg-<?= $color ?> text-white shadow">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <div class="font-weight-bold"><?= esc($priceRange['price_range']) ?></div>
                                                                <div class="text-white-75 small"><?= number_format($priceRange['count']) ?> products</div>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-dollar-sign fa-2x"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <div class="alert alert-info" role="alert">
                                                <i class="fas fa-info-circle"></i> No product pricing data available yet. Add some products with prices to see the distribution.
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($productsByPrice)): ?>
                                <hr>
                                <div class="text-center">
                                    <canvas id="priceRangeChart" width="400" height="200"></canvas>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 mb-4">

                        <!-- Quick Actions -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <a href="<?= site_url('products/create') ?>" class="btn btn-primary btn-block">
                                            <i class="fas fa-plus fa-sm"></i> Add Product
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="<?= site_url('blog/create') ?>" class="btn btn-success btn-block">
                                            <i class="fas fa-edit fa-sm"></i> Write Post
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="<?= site_url('pages/create') ?>" class="btn btn-info btn-block">
                                            <i class="fas fa-file-alt fa-sm"></i> Create Page
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="<?= site_url('categories') ?>" class="btn btn-warning btn-block">
                                            <i class="fas fa-tags fa-sm"></i> Manage Categories
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <h6 class="font-weight-bold text-gray-900 mb-3">System Overview</h6>
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="h4 font-weight-bold text-primary"><?= date('M j, Y') ?></div>
                                            <div class="small text-muted">Today</div>
                                        </div>
                                        <div class="col">
                                            <div class="h4 font-weight-bold text-success"><?= number_format($totalProducts + $totalBlogPosts + $totalPages) ?></div>
                                            <div class="small text-muted">Total Content</div>
                                        </div>
                                        <div class="col">
                                            <div class="h4 font-weight-bold text-info"><?= $userData->username ?></div>
                                            <div class="small text-muted">Logged In</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Statistics -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">System Health</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-3">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Database</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <i class="fas fa-check-circle text-success"></i> Connected
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center mb-3">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cache</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <i class="fas fa-bolt text-info"></i> Active
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center mb-3">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Version</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <i class="fas fa-code text-warning"></i> CI4
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <small class="text-muted">Last updated: <?= date('H:i:s') ?></small>
                                    <br>
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="refreshDashboard()">
                                        <i class="fas fa-sync-alt"></i> Refresh Data
                                    </button>
                                </div>
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

<!-- Hidden data for JavaScript -->
<script type="text/javascript">
// Dashboard data for charts
window.dashboardData = {
    monthlyProductsData: <?= json_encode($monthlyProductsData) ?>,
    categoryDistribution: <?= json_encode($categoryDistribution) ?>,
    productsByPrice: <?= json_encode($productsByPrice) ?>,
    totalProducts: <?= $totalProducts ?>,
    totalCategories: <?= $totalCategories ?>,
    totalBlogPosts: <?= $totalBlogPosts ?>,
    totalUsers: <?= $totalUsers ?>,
    totalPages: <?= $totalPages ?>,
    unreadMessages: <?= $unreadMessages ?>,
    recentActivity: <?= json_encode($recentActivity) ?>
};
</script>

<?= $this->endSection() ?>