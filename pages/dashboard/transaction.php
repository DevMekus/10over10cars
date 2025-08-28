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
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:12px">

                    <div class="filters" style="margin-left:8px">
                        <select id="statusFilter">
                            <option value="all">All status</option>
                            <option value="success">Success</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                        <input type="date" id="fromDate" />
                        <input type="date" id="toDate" />
                        <select id="methodFilter">
                            <option value="all">All methods</option>
                            <option value="card">Card</option>
                            <option value="bank">Bank</option>
                            <option value="ussd">USSD</option>
                            <option value="wallet">Wallet</option>
                        </select>
                    </div>
                </div>

            </header>
            <main class="content">
                <section class="stats">
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Total transactions</div>
                        <div class="big" id="statTotal">0</div>
                    </div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Successful</div>
                        <div class="big" id="statSuccess">0</div>
                    </div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Pending</div>
                        <div class="big" id="statPending">0</div>
                    </div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Failed</div>
                        <div class="big" id="statFailed">0</div>
                    </div>
                </section>

                <section class="card" data-aos="fade-up">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                        <strong>Transactions</strong>
                        <div style="display:flex;gap:8px;align-items:center">
                            <button class="btn btn-ghost" id="exportCsv">Export CSV</button>
                            <button class="btn btn-ghost" id="exportPdf">Export PDF</button>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table id="txTable">
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

                    <div class="pager"><button class="btn btn-ghost" id="prev">Prev</button>
                        <div id="pgInfo" class="muted small"></div><button class="btn btn-ghost" id="next">Next</button>
                    </div>
                </section>

                <!-- mini chart + revenue summary -->
                <section style="display:grid;grid-template-columns:1fr 320px;gap:12px">
                    <div class="card" data-aos="fade-up"><strong>Revenue (last 30 days)</strong><canvas id="revChart" height="120"></canvas></div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Total revenue</div>
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
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Transaction.js"></script>
</body>

</html