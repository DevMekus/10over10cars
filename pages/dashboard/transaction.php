<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="transactionPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
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
                                <h1>Transactions</h1>
                                <p>As an administrator, you can monitor, review, and manage all transactions across the platform to ensure accuracy and security.</p>

                            <?php else: ?>
                                <!-- User View -->
                                <h1>My Transactions</h1>
                                <p>As a user, you can view and track your transaction history, check payment statuses, and keep records of your activities.</p>
                            <?php endif; ?>
                        </div>
                        <div class="summary-icon" data-aos="zoom-in" data-aos-delay="200">
                            <i data-feather="bar-chart-2" width="36" height="36"></i>
                        </div>
                    </div>

                    <!-- Stat Cards Grid -->
                    <div class="stats-grid mt-2">
                        <div class="stats-card" data-aos="fade-up">
                            <div class="icon-box bg-accent"><i data-feather="dollar-sign"></i></div>
                            <h3 id="statTotal"></h3>
                            <p>Total transactions</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box bg-accent"><i data-feather="check-circle"></i></div>
                            <h3 id="statSuccess">3.2k</h3>
                            <p>Successful transactions</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box bg-primary"><i data-feather="clock"></i></div>
                            <h3 id="statPending">8.4k</h3>
                            <p>Pending transactions</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box bg-error"><i data-feather="x-circle"></i></div>
                            <h3 id="statFailed">1.1k</h3>
                            <p>Failed Transactions</p>
                        </div>


                    </div>
                </div>

                <header class="brand-card">
                    <div class="mt-1">
                        <p class="muted">Filter transaction data</p>
                        <div class="filters">

                            <select id="statusFilter" class="select-tags">
                                <option value="all">All status</option>
                                <option value="success">Success</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                            <input type="date" class="form-control datepicker" placeholder="Start" type="date" id="fromDate" />
                            <input type="date" class="form-control datepicker" placeholder="End" type="date" id="toDate" />
                            <select id="methodFilter" class="select-tags">
                                <option value="all">All methods</option>
                                <option value="card">Card</option>
                                <option value="bank">Bank</option>
                                <option value="ussd">USSD</option>
                                <option value="wallet">Wallet</option>
                            </select>
                        </div>
                    </div>

                </header>
                <section class="brand-card" data-aos="fade-up">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                        <strong>Transaction Data</strong>
                        <div style="display:flex;gap:8px;align-items:center">
                            <button class="btn btn-sm btn-outline-primary" id="exportCsv">Export CSV</button>
                            <button class="btn btn-sm btn-outline-primary" id="exportPdf">Export PDF</button>
                        </div>
                    </div>

                    <div class="table-wrap table-responsive">
                        <table id="txTable" class="brand-table">
                            <thead>
                                <tr>
                                    <th data-sort="id">Txn ID</th>
                                    <th>User/Dealer</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th data-sort="desc">Description</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="no-data"></div>

                    <div class="pager"><button class="btn btn-sm btn-outline-primary" id="prev">Prev</button>
                        <div id="pgInfo" class="muted small"></div><button class="btn btn-sm btn-outline-primary" id="next">Next</button>
                    </div>
                </section>

                <!-- mini chart + revenue summary -->
                <section style="display:grid;grid-template-columns:1fr 320px;gap:12px">
                    <div class="brand-card" data-aos="fade-up"><strong><?= $role == 'admin' ? 'Revenue' : 'Transaction' ?> (last 30 days)</strong>
                        <canvas id="revChart" height="120"></canvas>

                    </div>
                    <div
                        class="brand-card" data-aos="fade-up">
                        <div class="muted">Total <?= $role == 'admin' ? 'Revenue' : 'Transaction' ?></div>
                        <div class="big" id="totalRevenue">NGN 0</div>
                        <div style="margin-top:8px" class="muted small">Includes refunds</div>
                    </div>
                </section>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/TransactionPage.js"></script>
</body>

</html