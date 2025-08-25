<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="dealersPage">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <!-- Stats -->
                <section class="stats">
                    <div class="card stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#60a5fa,#34d399)"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="small muted">Total dealers</div>
                            <div id="sTotal" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                    <div class="card stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#34d399,#22c55e)"><i class="bi bi-patch-check"></i></div>
                        <div>
                            <div class="small muted">Approved</div>
                            <div id="sApproved" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                    <div class="card stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#fbbf24,#f59e0b)"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <div class="small muted">Pending</div>
                            <div id="sPending" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                    <div class="card stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#f87171,#ef4444)"><i class="bi bi-slash-circle"></i></div>
                        <div>
                            <div class="small muted">Suspended</div>
                            <div id="sSuspended" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                </section>

                <!-- Toolbar -->
                <section class="card" data-aos="fade-up" style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                    <div class="toolbar">
                        <select id="statusFilter">
                            <option value="all">All status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                        <select id="sortBy">
                            <option value="name">Sort: Name</option>
                            <option value="date">Sort: Date</option>
                            <option value="listings">Sort: Listings</option>
                            <option value="rating">Sort: Rating</option>
                        </select>
                        <button id="bulkApprove" class="btn">Bulk Approve</button>
                        <button id="bulkSuspend" class="btn">Bulk Suspend</button>
                        <button id="exportCsv" class="btn">Export CSV</button>
                        <a href="<?= BASE_URL ?>dashboard/dealer" id="addDealerBtn" class="btn btn-ghost"><i class="bi bi-person-plus"></i> Add Dealer</a>
                    </div>
                    <div>
                        <button id="toggleView" class="btn"><i class="bi bi-grid"></i> Grid</button>
                    </div>
                </section>

                <!-- Dealers Grid -->
                <section id="gridView" class="grid" aria-live="polite"></section>

                <!-- Dealers Table -->
                <section id="tableView" class="card" style="display:none">
                    <div class="table-wrap">
                        <table id="dealersTable">
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
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dealers.js"></script>
</body>

</html