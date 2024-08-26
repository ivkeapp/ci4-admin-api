    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">WebTech Admin</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= site_url('/') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        
        <?php if (!empty($userGroups)): ?>
            <?php if (in_array('admin', $userGroups) || in_array('superadmin', $userGroups)): ?>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Content visible only to admin users -->
                <!-- Heading -->
                <div class="sidebar-heading">
                    Admin
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users Managment</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Users & Groups:</h6>
                            <a class="collapse-item" href="<?= site_url('admin/users') ?>">Users</a>
                            <a class="collapse-item" href="<?= site_url('admin/groups') ?>">Groups</a>
                        </div>
                    </div>
                </li>
                <!-- Nav Item - Admin Albums Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                        aria-expanded="true" aria-controls="collapseThree">
                        <i class="fas fa-fw fa-sticky-note"></i>
                        <span>Albums</span>
                    </a>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Albums Management:</h6>
                            <a class="collapse-item" href="<?= site_url('admin/albums') ?>">All Albums</a>
                            <a class="collapse-item" href="<?= site_url('admin/albums/add') ?>">Add Album</a>
                            <a class="collapse-item" href="<?= site_url('admin/albums/add-cards') ?>">Add Cards to Album</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (in_array('user', $userGroups)): ?>
                <!-- Content visible only to subscriber users -->
                <!-- Heading -->
                <div class="sidebar-heading">
                    User
                </div>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php if (!empty($userGroups)): ?>
            <?php if (in_array('admin', $userGroups) || in_array('superadmin', $userGroups)): ?>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Content visible only to admin users -->
                <!-- Heading -->
                <div class="sidebar-heading">
                    Pages
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapse"
                        aria-expanded="true" aria-controls="pagesCollapse">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Pages</span>
                    </a>
                    <div id="pagesCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Page administration:</h6>
                            <a class="collapse-item" href="<?= site_url('pages') ?>">All Pages</a>
                            <a class="collapse-item" href="<?= site_url('pages/create') ?>">Add Page</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (in_array('editor', $userGroups)): ?>
                <!-- Content visible only to editor users -->
                <!-- Heading -->
                <div class="sidebar-heading">
                    Editor
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <?php if (!empty($userGroups)): ?>
            <?php if (in_array('admin', $userGroups) || in_array('superadmin', $userGroups)): ?>
                <!-- Heading -->
                <div class="sidebar-heading">
                    Activity Logs
                </div>

                <!-- Nav Item - Messages -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('activity-logs') ?>">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>All Activity Logs</span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Utilities Collapse Menu -->
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
        </li> -->

        <!-- Divider -->
        <!-- <hr class="sidebar-divider"> -->

        <!-- Heading -->
        <div class="sidebar-heading">
            Messaging
        </div>

        <!-- Nav Item - Messages -->
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('chat') ?>">
                <i class="fas fa-fw fa-envelope"></i>
                <span>Messages</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            My Collection
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlbums"
                aria-expanded="true" aria-controls="collapseAlbums">
                <i class="fas fa-fw fa-folder"></i>
                <span>My Collection</span>
            </a>
            <div id="collapseAlbums" class="collapse" aria-labelledby="headingAlbums" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Albums:</h6>
                    <a class="collapse-item" href="<?= site_url('albums') ?>">View Albums</a>
                    <a class="collapse-item" href="<?= site_url('albums/add') ?>">Add Album</a>
                    <a class="collapse-item" href="<?= site_url('albums/exchange') ?>">Exchange Albums</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Requests:</h6>
                    <a class="collapse-item" href="<?= site_url('albums/received-requests') ?>">Received Requests</a>
                    <a class="collapse-item" href="<?= site_url('albums/sent-requests') ?>">Sent Requests</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <!-- <hr class="sidebar-divider"> -->

        <!-- Heading -->
        <!-- <div class="sidebar-heading">
            Addons
        </div> -->

        <!-- Divider -->
        <!-- <hr class="sidebar-divider"> -->

        <!-- Heading -->
        <!-- <div class="sidebar-heading">
            Addons
        </div> -->

        <!-- Nav Item - Pages Collapse Menu -->
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li> -->

        <!-- Nav Item - Charts -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li> -->

        <!-- Nav Item - Tables -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li> -->

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="<?= base_url('img/undraw_rocket.svg') ?>" alt="...">
            <p class="text-center mb-2"><strong>WebTech Admin</strong> made with love!</p>
            <a class="btn btn-success btn-sm" href="mailto:ivanzarkovic@yahoo.com">Contact dev</a>
        </div>

    </ul>
    <!-- End of Sidebar -->