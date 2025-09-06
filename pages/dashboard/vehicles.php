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
                <div class="dashboard">
                    <!-- Summary Header Card -->
                    <div class="summary-card" data-aos="fade-up">
                        <div>
                            <?php if ($role == 'admin'): ?>
                                <!-- Admin View -->
                                <h1>Vehicle Listings</h1>
                                <p>As an administrator, you can review, approve, or decline vehicle listings, and manage all cars displayed on the platform.</p>


                            <?php else: ?>
                                <!-- User View -->
                                <h1>My Vehicle Listings</h1>
                                <p>As a user, you can add, edit, and manage your vehicle listings, making them visible to potential buyers once approved.</p>
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
                            <p>Total Listings</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box bg-accent"><i data-feather="check-circle"></i></div>
                            <h3 id="sApproved"></h3>
                            <p>Approved Listings</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box bg-primary"><i data-feather="clock"></i></div>
                            <h3 id="sPending"></h3>
                            <p>Pending Listings</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box bg-error"><i data-feather="x-circle"></i></div>
                            <h3 id="sRejected"></h3>
                            <p>Rejected Listings</p>
                        </div>


                    </div>
                </div>

                <!-- Toolbar -->
                <div class="brand-card filters">
                    <select id="statusFilter" class="select-tags">
                        <option value="all">All status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                        <option value="draft">Draft</option>
                    </select>
                    <select id="sortBy" class="select-tags">
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

                    <button id="exportCsv" class="btn btn-sm btn-outline-primary">Export CSV</button>
                    <?php if ($user && $user['company'] !== null): ?>
                        <button id="addVehicleBtns" class="btn  btn-primary btn-pill" data-bs-toggle="modal" data-bs-target="#uploadVehicleModal"><i class="bi bi-plus-circle"></i> Add Vehicle</button>
                    <?php endif; ?>
                    <button id="toggleView" class="btn btn-sm btn-outline-accent"><i class="bi bi-grid"></i> Grid</button>
                </div>


                <section class="s">
                    <!-- Grid -->
                    <section id="gridView" class="grid" aria-live="polite"></section>
                    <div id="pagination" style="margin-top:20px; display:flex; gap:6px; justify-content:center"></div>

                    <!-- Table -->
                    <section id="tableView" class="brand-card" style="display:none">
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
                        <div style="display:flex;justify-content:center;gap:8px;padding:10px"><button class="btn btn-sm btn-outline-primary" id="prevPg">Prev</button>
                            <div class="small muted" id="pgInfo"></div><button class="btn btn-sm btn-outline-primary" id="nextPg">Next</button>
                        </div>
                    </section>
                    <div class="no-data"></div>
                </section>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/VehiclePage.js"></script>
</body>

</html