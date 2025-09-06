<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="verificationPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
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
                                <h1>Verification Requests</h1>
                                <p>As an administrator, you can oversee, approve, or reject all verification requests and ensure the system runs smoothly.</p>
                            <?php else: ?>
                                <!-- User View -->
                                <h1>My Verification Requests</h1>
                                <p>As a user, you can view, track, and manage your submitted verification requests from this page.</p>
                            <?php endif; ?>
                        </div>
                        <div class="summary-icon" data-aos="zoom-in" data-aos-delay="200">
                            <i data-feather="bar-chart-2" width="36" height="36"></i>
                        </div>
                    </div>

                    <!-- Stat Cards Grid -->
                    <div class="stats-grid mt-2">
                        <div class="stats-card" data-aos="fade-up">
                            <div class="icon-box bg-primary"><i data-feather="clock"></i></div>
                            <h3 id="statPending"></h3>
                            <p>Pending verifications</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box bg-accent"><i data-feather="check-circle"></i></div>
                            <h3 id="statApproved"></h3>
                            <p>Approved verifications</p>

                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box bg-error"><i data-feather="x-circle"></i></div>
                            <h3 id="statDeclined"></h3>
                            <p>Declined verifications</p>
                        </div>

                        <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box bg-info"><i data-feather="bar-chart-2"></i></div>
                            <h3 id="statTotal"></h3>
                            <p>Total Requests</p>
                        </div>


                    </div>
                </div>
                <section class="brand-card filters" data-aos="fade-up" aria-label="Report filters">
                    <div class="col-sm-6">
                        <input id="qSearch" class="form-control" placeholder="Search VIN, user, dealer..." />
                    </div>
                    <select class="select-tags" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="declined">Declined</option>
                    </select>
                    <input class="form-control datepicker" placeholder="Start" type="date" id="fromDate" />
                    <input class="form-control datepicker" placeholder="End" type="date" id="toDate" />
                    <?php if ($role !== 'admin'): ?>
                        <a href="<?= BASE_URL ?>dashboard/new-verify" class="btn btn-outline-primary">Verify VIN</a>
                    <?php endif; ?>
                </section>
                <!-- <div style="display:flex;align-items:center;gap:12px" class="brand-card">
                    <div class="search" role="search">
                        <i class="bi bi-search muted"></i>
                        <input id="qSearch" class="form-control" placeholder="Search VIN, user, dealer..."
                            style="border:none;background:transparent;outline:none;padding-left:6px" />
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <select class="select-tags w-50" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="declined">Declined</option>
                        </select>
                        <input class="form-control datepicker" placeholder="Start" type="date" id="fromDate" />
                        <input class="form-control datepicker" placeholder="End" type="date" id="toDate" />
                        <?php if ($role !== 'admin'): ?>
                            <a href="<?= BASE_URL ?>dashboard/new-verify" class="btn btn-outline-primary">Verify VIN</a>
                        <?php endif; ?>
                    </div>
                </div> -->
                <section class="table-wrap brand-card" data-aos="fade-up">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <strong>Verification Requests</strong>
                        <div class="small muted">Showing <span id="showingCount">0</span> of <span id="totalCount">0</span></div>
                    </div>

                    <div class="table-responsive">
                        <table id="reqTable" class="brand-table" aria-label="Verification requests table">
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

                    </div>
                    <div class="no-data"></div>
                    <div class="pager" style="margin-top:12px"><button class="btn btn-sm btn-outline-primary" id="prevPage">Previous</button>
                        <div id="pageInfo" class="muted small"></div><button class="btn btn-sm btn-outline-primary" id="nextPage">Next</button>
                    </div>
                </section>
                <?php require "footer.php"; ?>
            </main>

        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/VerificationPage.js"></script>
</body>

</html