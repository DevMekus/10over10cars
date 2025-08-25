<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="verificationPage">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:12px">

                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="search" role="search"><i class="bi bi-search muted"></i><input id="qSearch" placeholder="Search VIN, user, dealer..." style="border:none;background:transparent;outline:none;padding-left:6px" /></div>
                        <div style="display:flex;gap:8px;align-items:center">
                            <select id="statusFilter">
                                <option value="all">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="declined">Declined</option>
                            </select>
                            <input type="date" id="fromDate" />
                            <input type="date" id="toDate" />
                            <a href="<?= BASE_URL ?>dashboard/new-verify" class="btn btn-primary">Verify VIN</a>
                        </div>
                    </div>
                </div>
            </header>
            <main class="content">
                <section class="cards">
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Pending</div>
                        <div class="stat" id="statPending">0</div>
                    </div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Approved</div>
                        <div class="stat" id="statApproved">0</div>
                    </div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Declined</div>
                        <div class="stat" id="statDeclined">0</div>
                    </div>
                    <div class="card" data-aos="fade-up">
                        <div class="muted">Total Requests</div>
                        <div class="stat" id="statTotal">0</div>
                    </div>
                </section>

                <section class="table-wrap" data-aos="fade-up">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <strong>Verification Requests</strong>
                        <div class="small muted">Showing <span id="showingCount">0</span> of <span id="totalCount">0</span></div>
                    </div>

                    <table id="reqTable" aria-label="Verification requests table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>VIN</th>
                                <th>Vehicle</th>
                                <th>User/Dealer</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="pager" style="margin-top:12px"><button class="btn btn-ghost" id="prevPage">Previous</button>
                        <div id="pageInfo" class="muted small"></div><button class="btn btn-ghost" id="nextPage">Next</button>
                    </div>
                </section>
                <?php require "footer.php"; ?>
            </main>

        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Verification.js"></script>
</body>

</html