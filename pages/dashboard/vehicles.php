<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="vehiclesPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <section class="stats">
                    <div class="card-dash stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#60a5fa,#34d399)"><i class="bi bi-car-front"></i></div>
                        <div>
                            <div class="small muted">Total vehicles</div>
                            <div id="sTotal" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                    <div class="card-dash stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#34d399,#22c55e)"><i class="bi bi-patch-check"></i></div>
                        <div>
                            <div class="small muted">Approved</div>
                            <div id="sApproved" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                    <div class="card-dash stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#fbbf24,#f59e0b)"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <div class="small muted">Pending</div>
                            <div id="sPending" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                    <div class="card-dash stat" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#f87171,#ef4444)"><i class="bi bi-slash-circle"></i></div>
                        <div>
                            <div class="small muted">Rejected</div>
                            <div id="sRejected" style="font-weight:800;font-size:20px">0</div>
                        </div>
                    </div>
                </section>

                <!-- Toolbar -->
                <section class="card-dash" data-aos="fade-up" style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                    <div class="filters">
                        <select id="statusFilter">
                            <option value="all">All status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                            <option value="draft">Draft</option>
                        </select>
                        <select id="sortBy">
                            <option value="date">Sort: Date</option>
                            <option value="price">Sort: Price</option>
                            <option value="mileage">Sort: Mileage</option>
                            <option value="year">Sort: Year</option>
                        </select>

                        <input class="input" id="min" type="number" min="0" step="50000" placeholder="Min price (₦)" />
                        <input class="input" id="max" type="number" min="0" step="50000" placeholder="Max price (₦)" />
                        <!-- <div class="field">
                            <label for="dateFrom">Listed from</label>
                            <input class="input" id="dateFrom" type="date" />
                        </div> -->
                        <button id="bulkApprove" class="btn btn-sm btn-outline-accent">Bulk Approve</button>
                        <button id="bulkReject" class="btn btn-sm btn-outline-accent">Bulk Reject</button>
                        <button id="exportCsv" class="btn btn-sm btn-outline-accent">Export CSV</button>
                        <button id="addVehicleBtns" class="btn btn-sm btn-primary btn-pill" data-bs-toggle="modal" data-bs-target="#uploadVehicleModal"><i class="bi bi-plus-circle"></i> Add Vehicle</button>
                    </div>
                    <div>
                        <button id="toggleView" class="btn btn-sm btn-outline-accent"><i class="bi bi-grid"></i> Grid</button>
                    </div>
                </section>

                <!-- Grid -->
                <section id="gridView" class="grid" aria-live="polite"></section>

                <!-- Table -->
                <section id="tableView" class="card-dash" style="display:none">
                    <div class="table-wrap">
                        <table id="vehiclesTable" class="brand-table">
                            <thead>
                                <tr>
                                    <th style="width:34px"><input type="checkbox" id="selAll"></th>
                                    <th>Vehicle</th>
                                    <th>VIN</th>
                                    <th>Dealer/Owner</th>
                                    <th>Year</th>
                                    <th>Mileage</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div style="display:flex;justify-content:center;gap:8px;padding:10px"><button class="btn btn-sm btn-outline-accent" id="prevPg">Prev</button>
                        <div class="small muted" id="pgInfo"></div><button class="btn btn-sm btn-outline-accent" id="nextPg">Next</button>
                    </div>
                </section>
                <div id="no-data"></div>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Vehicle.js"></script>

</body>

</html