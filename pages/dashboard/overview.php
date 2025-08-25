<?php
require_once ROOT_PATH . '/includes/header.php';
$dashboarduser = 'user';
?>

<body id="Dashboard" class="overviewPage">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <!-- Overview -->
                <section class="grid-4">
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Total verifications</div>
                        <div class="stat" id="statVer">1,240</div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="80">
                        <div class="muted">Active vehicles</div>
                        <div class="stat" id="statVeh">312</div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="160">
                        <div class="muted">Dealers</div>
                        <div class="stat" id="statDeal">42</div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="240">
                        <div class="muted">Revenue (NGN)</div>
                        <div class="stat" id="statRev">NGN 8,420,000</div>
                    </div>
                </section>

                <!-- Charts + Activity -->
                <section style="display:grid;grid-template-columns:1fr 380px;gap:16px">
                    <div class="card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px"><strong>Verifications (30 days)</strong>
                            <div class="muted small">Last 30 days</div>
                        </div>
                        <canvas id="chartVer" height="120"></canvas>
                    </div>

                    <div class="card" data-aos="fade-up" data-aos-delay="80">
                        <strong>Recent activity</strong>
                        <ul style="list-style:none;padding:0;margin:12px 0;display:grid;gap:8px">
                            <li class="small"><strong>VIN</strong> 2HGFB2F... — <span class="muted">Verified (Clean)</span></li>
                            <li class="small"><strong>Dealer</strong> Ace Motors — <span class="muted">Applied (Pending)</span></li>
                            <li class="small"><strong>TXN</strong> TXN-4906 — <span class="muted">Completed</span></li>
                            <li class="small"><strong>VIN</strong> JH4KA8... — <span class="muted">Flagged: mileage anomaly</span></li>
                        </ul>
                        <a href="#activity" class="small">View full activity →</a>
                    </div>
                </section>

                <?php if ($dashboarduser == 'admin'): ?>
                    <!-- Verifications table -->
                    <section class="card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong>Recent verifications</strong>
                            <div class="muted small">Showing last 10</div>
                        </div>
                        <div style="overflow:auto">
                            <table id="tableVer">
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
                        </div>
                    </section>

                    <!-- Vehicles grid (rich cards) -->
                    <section>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px"><strong>Vehicles</strong>
                            <div><button class="btn btn-ghost" id="addVehicleBtn">+ Add Vehicle</button></div>
                        </div>
                        <div class="vehicles-grid" id="vehiclesGrid"></div>
                    </section>

                    <!-- Dealers management -->
                    <section class="card" data-aos="fade-up">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong>Dealer requests</strong>
                            <div class="muted small">Pending approvals</div>
                        </div>
                        <div id="dealerList"></div>
                    </section>
                <?php endif; ?>

                <?php if ($dashboarduser == 'user'): ?>
                    <!-- Tables -->
                    <section style="display:grid;grid-template-columns:2fr 1fr;gap:2px">

                        <div class="card" data-aos="fade-up">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                                <strong>Recent verifications</strong>
                                <div class="muted small">Showing last 10</div>
                            </div>
                            <div style="overflow:auto">
                                <table id="tableVer" role="table" aria-label="Recent verifications table">
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
                            </div>
                        </div>

                        <div class="card" data-aos="fade-up" data-aos-delay="80">
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
                            </div>
                            <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <button class="action-btn" id="exportCsv">Export CSV</button>
                                <button class="action-btn" id="exportPdf">Export PDF</button>
                            </div>
                        </div>

                    </section>

                    <!-- My Vehicles -->
                    <section>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                            <strong>My vehicles</strong>
                            <div class="actions"><button class="action-btn" id="addVehicle">Add Vehicle</button><button class="action-btn" id="manageDealer">Become Dealer</button></div>
                        </div>
                        <div class="vehicles card" id="myVehicles"></div>
                    </section>
                <?php endif; ?>

                <?php require "footer.php"; ?>
            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Verification.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Vehicle.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dealers.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>

</body>

</html