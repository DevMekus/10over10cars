<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="dealersPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">

                <div class="dashboard">
                    <!-- Summary Header Card -->
                    <div class="summary-card" data-aos="fade-up">
                        <div>
                            <?php if ($role == 'admin'): ?>
                                <!-- Admin View -->
                                <h1>Car Dealers</h1>
                                <p>As an administrator, you can manage all registered car dealers, verify their credentials, and ensure compliance with platform policies.</p>


                            <?php else: ?>
                                <!-- User View -->
                                <h1>Car Dealers</h1>
                                <p>As a user, you can browse, connect with, and interact with trusted car dealers available on the platform.</p>
                            <?php endif; ?>
                        </div>
                        <div class="summary-icon" data-aos="zoom-in" data-aos-delay="200">
                            <i data-feather="bar-chart-2" width="36" height="36"></i>
                        </div>
                    </div>

                    <!-- Stat Cards Grid -->
                    <div class="stats-grid mt-2">
                        <div class="stats-card" data-aos="fade-up">
                            <div class="icon-box bg-accent"><i data-feather="truck"></i></div>
                            <h3 id="sTotal"></h3>
                            <p>Total Dealers</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box bg-accent"><i data-feather="check-circle"></i></div>
                            <h3 id="sApproved"></h3>
                            <p>Approved Dealers</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box bg-primary"><i data-feather="clock"></i></div>
                            <h3 id="sPending"></h3>
                            <p>Pending Dealers</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box bg-error"><i data-feather="x-circle"></i></div>
                            <h3 id="sSuspended"></h3>
                            <p>Suspended Dealers</p>
                        </div>


                    </div>
                </div>
                <!-- Toolbar -->
                <section class="brand-card" data-aos="fade-up" style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                    <div class="filters">
                        <select id="statusFilter" class="select-tags">
                            <option value="all">All status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                        <select id="sortBy" class="select-tags">
                            <option value="name">Sort: Name</option>
                            <option value="date">Sort: Date</option>
                            <option value="listings">Sort: Listings</option>
                            <option value="rating">Sort: Rating</option>
                        </select>
                        <!-- <button id="bulkApprove" class="btn">Bulk Approve</button>
                        <button id="bulkSuspend" class="btn">Bulk Suspend</button> -->
                        <button id="exportCsv" class="btn btn-sm btn-ghost">Export CSV</button>
                        <a href="<?= BASE_URL ?>dashboard/dealer" id="addDealerBtn" class="btn btn btn-pill btn-primary"><i class="bi bi-person-plus"></i> Add Dealer</a>
                    </div>
                    <div>
                        <button id="toggleView" class="btn btn-sm btn-outline-primary"><i class="bi bi-grid"></i> Grid</button>
                    </div>
                </section>
                <section class="brand-card">


                    <!-- Dealers Grid -->
                    <section id="gridView" class="grid" aria-live="polite"></section>
                    <div id="pagination" style="margin-top:20px; display:flex; gap:6px; justify-content:center"></div>


                    <!-- Dealers Table -->
                    <section id="tableView" class="card-dash" style="display:none">
                        <div class="table-wrap table-responsive">
                            <table id="dealersTable" class="brand-table">
                                <thead>
                                    <tr>
                                        <th style="width:34px"><input type="checkbox" id="selAll"></th>
                                        <th>Dealer</th>
                                        <th>Contact</th>
                                        <th>Listings</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="small muted" id="pgInfo" style="padding:10px;text-align:center"></div>
                    </section>
                    <div class="no-data"></div>

                </section>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/DealerPage.js"></script>
</body>

</html