<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="reportPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <!-- Filters / Controls -->

                <div class="dashboard">
                    <!-- Summary Header Card -->
                    <div class="summary-card" data-aos="fade-up">
                        <div>
                            <?php if ($role == 'admin'): ?>
                                <!-- Admin View -->
                                <h1>Reports</h1>
                                <p>As an administrator, you can generate, review, and analyze system-wide reports to monitor activities, performance, and compliance.</p>

                            <?php else: ?>
                                <!-- User View -->
                                <h1>My Reports</h1>
                                <p>As a user, you can view and download reports related to your activities, transactions, and vehicle interactions on the platform.</p>
                            <?php endif; ?>
                        </div>
                        <div class="summary-icon" data-aos="zoom-in" data-aos-delay="200">
                            <i data-feather="bar-chart-2" width="36" height="36"></i>
                        </div>
                    </div>

                    <!-- Stat Cards Grid -->
                    <div class="stats-grid mt-2">
                        <div class="stats-card" data-aos="fade-up">
                            <div class="icon-box bg-accent"><i data-feather="check-circle"></i></div>
                            <h3 id="kVerifs"></h3>
                            <p>Total Verifications
                            </p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box bg-accent"><i data-feather="dollar-sign"></i></div>
                            <h3 id="kRevenue"></h3>
                            <p>Transactions (NGN)</p>

                        </div>

                        <?php if ($role == 'admin'):  ?>
                            <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box bg-primary"><i data-feather="users"></i></div>
                                <h3 id="kDealers"></h3>
                                <p>Active Dealers
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box bg-error"><i data-feather="truck"></i></div>
                            <h3 id="kVehicles"></h3>
                            <p>Vehicles Listed
                            </p>
                        </div>


                    </div>
                </div>
                <section class="brand-card filters" data-aos="fade-up" aria-label="Report filters">
                    <input type="text" class="datepicker form-control" placeholder="Start date" id="fromDate" />
                    <input type="text" class="datepicker form-control" placeholder="End" id="toDate" />
                    <div>
                        <select id="reportType" class="select-tags">
                            <option value="overview">Overview</option>
                            <option value="verifications">Verifications</option>
                            <option value="transactions">Transactions</option>
                            <option value="dealers">Dealers</option>
                            <option value="vehicles">Vehicles</option>
                        </select>
                    </div>
                    <div style="margin-left:auto;display:flex;gap:8px;align-items:end">
                        <button id="applyFilters" class="btn btn-sm btn-primary">Apply</button>
                        <button id="resetFilters" class="btn btn-sm btn-ghost">Reset</button>
                        <button id="exportCsv" class="btn btn-sm btn-ghost">Export CSV</button>
                        <button id="exportPdf" class="btn btn-sm btn-ghost">Export PDF</button>
                    </div>
                </section>



                <!-- Charts & Top items -->
                <section class="cols">
                    <div class="brand-card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                            <strong>Trends</strong>
                            <div class="muted small" id="trendLabel">Last 30 days</div>
                        </div>
                        <canvas id="trendChart" height="110" aria-label="Trends chart" role="img"></canvas>
                    </div>

                    <div class="brand-card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                            <strong>Top Dealers</strong>
                            <div class="muted small">By revenue</div>
                        </div>
                        <ul id="topDealers" style="list-style:none;padding:0;margin:0;display:grid;gap:10px"></ul>
                    </div>
                </section>

                <!-- Detailed table -->
                <section class="brand-card" data-aos="fade-up">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <strong id="tableTitle">Recent Transactions</strong>
                        <div class="muted small" id="tableMeta">Showing last 20</div>
                    </div>
                    <div class="table-wrap table-responsive">
                        <table id="reportTable" class="brand-table">
                            <thead>
                                <tr id="tableHead"></tr>
                            </thead>
                            <tbody id="tableBody"></tbody>
                        </table>
                    </div>
                    <div class="no-data"></div>
                    <div style="display:flex;justify-content:center;gap:8px;padding:10px">
                        <button class="btn btn-sm btn-outline-primary" id="prevPg">Prev</button>
                        <div class="small muted" id="pgInfo"></div>
                        <button class="btn btn-sm btn-outline-primary" id="nextPg">Next</button>
                    </div>
                </section>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/ReportPage.js"></script>

</body>

</html