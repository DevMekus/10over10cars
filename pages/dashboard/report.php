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
                <section class="card-brand filters" data-aos="fade-up" aria-label="Report filters">
                    <div>
                        <label class="small muted">Date from</label><br>
                        <input type="date" id="fromDate" />
                    </div>
                    <div>
                        <label class="small muted">Date to</label><br>
                        <input type="date" id="toDate" />
                    </div>
                    <div>
                        <label class="small muted">Report type</label><br>
                        <select id="reportType">
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

                <!-- KPI Tiles -->
                <section class="kpis">
                    <div class="card-brand kpi" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#60a5fa,#34d399)"><i class="bi bi-bar-chart"></i></div>
                        <div>
                            <div class="small muted">Total Verifications</div>
                            <div id="kVerifs" class="value">0</div>
                        </div>
                    </div>
                    <div class="card-brand kpi" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#34d399,#22c55e)"><i class="bi bi-currency-dollar"></i></div>
                        <div>
                            <div class="small muted">Revenue (NGN)</div>
                            <div id="kRevenue" class="value">0</div>
                        </div>
                    </div>
                    <div class="card-brand kpi" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#fbbf24,#f59e0b)"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="small muted">Active Dealers</div>
                            <div id="kDealers" class="value">0</div>
                        </div>
                    </div>
                    <div class="card-brand kpi" data-aos="fade-up">
                        <div class="badge" style="background:linear-gradient(135deg,#f87171,#ef4444)"><i class="bi bi-car-front"></i></div>
                        <div>
                            <div class="small muted">Vehicles Listed</div>
                            <div id="kVehicles" class="value">0</div>
                        </div>
                    </div>
                </section>

                <!-- Charts & Top items -->
                <section class="cols">
                    <div class="card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                            <strong>Trends</strong>
                            <div class="muted small" id="trendLabel">Last 30 days</div>
                        </div>
                        <canvas id="trendChart" height="110" aria-label="Trends chart" role="img"></canvas>
                    </div>

                    <div class="card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                            <strong>Top Dealers</strong>
                            <div class="muted small">By revenue</div>
                        </div>
                        <ul id="topDealers" style="list-style:none;padding:0;margin:0;display:grid;gap:10px"></ul>
                    </div>
                </section>

                <!-- Detailed table -->
                <section class="card-brand" data-aos="fade-up">
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