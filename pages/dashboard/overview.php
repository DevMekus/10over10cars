<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="overviewPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <div class="dashboard">
                    <!-- Summary Header Card -->
                    <div class="summary-card" data-aos="fade-up">
                        <div>
                            <h1><?= $user['fullname']; ?></h1>
                            <p>Welcome back to <?= BRAND_NAME; ?> dashboard</p>
                        </div>
                        <div class="summary-icon" data-aos="zoom-in" data-aos-delay="200">
                            <i data-feather="bar-chart-2" width="36" height="36"></i>
                        </div>
                    </div>

                    <!-- Stat Cards Grid -->
                    <div class="stats-grid mt-2">
                        <div class="stats-card" data-aos="fade-up">
                            <div class="icon-box bg-primary"><i data-feather="shield"></i></div>
                            <h3 id="statVer"></h3>
                            <p>Car verifications</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box bg-accent"><i data-feather="user"></i></div>
                            <h3 id="statDeal"></h3>
                            <p>Active Dealers</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box bg-info"><i data-feather="truck"></i></div>
                            <h3 id="statVeh"></h3>
                            <p>Vehicle listings</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box bg-error"><i data-feather="dollar-sign"></i></div>
                            <h3 id="statRev"></h3>
                            <p>Transactions (NGN)</p>
                        </div>


                    </div>
                </div>


                <!-- Charts + Activity -->
                <section class="overview-activity">
                    <div class="brand-card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px"><strong>Verifications (30 days)</strong>
                            <div class="muted small">Last 30 days</div>
                        </div>
                        <div style="height:300px; width:100%; max-width:900px; margin:auto;">
                            <canvas id="chartVer"></canvas>
                        </div>

                    </div>

                    <div class="brand-card" data-aos="fade-up" data-aos-delay="80">
                        <strong>Recent activity</strong>

                        <div id="activityWidget">
                            <ul id="activityList"
                                style="list-style:none;padding:0;margin:12px 0;display:grid;gap:8px">
                            </ul>
                            <a href="#activity" class="small">View full activity →</a>
                        </div>

                    </div>
                </section>

                <?php if ($role == 'admin'): ?>
                    <!-- Verifications table -->
                    <section class="brand-card" data-aos="fade-up">
                        <div>
                            <strong>Recent verifications</strong>
                            <div class="muted small">Showing last 10</div>
                        </div>
                        <div class="table-responsives">

                            <table id="tableVer" class="brand-table">
                                <thead>
                                    <tr>
                                        <th>VIN</th>
                                        <th>Result</th>
                                        <th>Source</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="no-data"></div>
                        </div>
                    </section>

                    <!-- Vehicles grid (rich cards) -->



                <?php endif; ?>

                <?php if ($role == 'user'): ?>
                    <!-- Tables -->
                    <section style="display:grid;grid-template-columns:2fr 1fr;gap:2px">

                        <div class="brand-card" data-aos="fade-up">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                                <strong>Recent verifications</strong>
                                <div class="muted small">Showing last 10</div>
                            </div>
                            <div class="table-responsive">
                                <table class="brand-table" id="tableVer" role="table" aria-label="Recent verifications table">
                                    <thead>
                                        <tr>
                                            <th>VIN</th>
                                            <th>Result</th>
                                            <th>Plan</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="verTable"></tbody>
                                </table>
                                <div class="no-data"></div>
                            </div>
                        </div>

                        <div class="brand-card" data-aos="fade-up" data-aos-delay="80">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                                <strong>Transactions</strong>
                                <div class="muted small">Last 5</div>
                            </div>
                            <div style="overflow:auto">
                                <table role="table" aria-label="Transactions table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="txnTable"></tbody>
                                </table>
                                <div class="no-data2"></div>
                            </div>
                            <!-- <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <button class="action-btn" id="exportCsv">Export CSV</button>
                                <button class="action-btn" id="exportPdf">Export PDF</button>
                            </div> -->
                        </div>

                    </section>

                    <!-- My Vehicles -->
                    <!-- <section>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                            <strong>My vehicles</strong>
                            <div class="actions"><button class="action-btn" id="addVehicle">Add Vehicle</button><button class="action-btn" id="manageDealer">Become Dealer</button></div>
                        </div>
                        <div class="vehicles card" id="myVehicles"></div>
                    </section> -->
                <?php endif; ?>

                <?php require "footer.php"; ?>
            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/OverviewPage.js"></script>

</body>

</html