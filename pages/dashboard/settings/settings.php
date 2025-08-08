<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';

?>

<body class="theme-light dashboard" id="settingsManager" data-id="<?= $_SESSION['userid']; ?>" data-role="<?= $_SESSION['role']; ?>">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>

        <section class="mt-4 access-control">
            <div>
                <div class="page-header" data-aos="fade-down">
                    <div class="welcome">🔐 Security Management</div>
                    <p>Welcome to your dashboard to manage your account, view recent transactions, and update your preferences for a seamless experience.
                    </p>
                </div>

                <!-- Role Management -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card mb-4 custom-form">
                            <h2 class="section-header">Security Settings
                            </h2>
                            <form class="tomselect-style mt-4" id="updatePassword" data-id="<?= $_SESSION['userid']; ?>">
                                <div class="form-group">
                                    <label for="old_password">Current Password</label>
                                    <input type="password" id="old_password" name="old_password" class="brand-form" placeholder="Password" required />
                                </div>
                                <div class="form-group">
                                    <label for="password">New Current</label>
                                    <input type="password" id="password" name="new_password" class="brand-form" placeholder="Password" required />
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if ($_SESSION['role'] === '1'): ?>
                        <div class="col-sm-6">
                            <div class="card mb-4" id="addAdmin">
                                <h2 class="section-header">Admin Role Management</h2>
                                <div class="card-body">
                                    <section class="mt-3 mb-3" id="data-container">
                                        <div class="top-controls">
                                            <div class="filters">
                                                <input type="text" id="adminSearchInput" placeholder="Search by name/email" />

                                            </div>
                                            <div class="actions-bar">
                                                <button class="btn btn-primary btn-sm">New Admin</button>

                                            </div>
                                        </div>
                                        <div class="table-responsive mb-3">
                                            <table id="adminTable" class="brand-table default-form">
                                                <thead>
                                                    <tr>
                                                        <th><span class="sortData" data-name="name">Name</span></th>
                                                        <th>Userid</th>
                                                        <th>status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="adminTbody" class="download-section"></tbody>
                                            </table>
                                        </div>

                                        <div id="no-adminRecords" class="no-records text-center" style="display:none">No record match your criteria.</div>
                                        <div class="pagination" id="paginationAdmin"></div>
                                    </section>
                                    <div id="no-Adata" class="no-records text-center mt-4" style="display:none">You have no admin at the moment</div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-sm-<?= $_SESSION['role'] == '1' ? '12' : '6' ?>">
                        <div class="card p-3">
                            <h2>Login Trends</h2>
                            <canvas id="loginTrends" width="400" height="150"></canvas>
                        </div>
                    </div>
                    <!-- Activity Logs -->
                    <div class="col-sm-12">
                        <div class="card mb-4">
                            <h2 class="section-header">Activity Logs</h2>
                            <section class="mt-3 mb-3" id="data-container">
                                <div class="top-controls">
                                    <div class="filters">
                                        <input type="text" id="searchInput" placeholder="Search by name/email" />
                                        <?php if ($_SESSION['role'] === '1'): ?>
                                            <select id="roleFilter">
                                                <option value="">All Roles</option>
                                                <option value="2">Customer</option>
                                                <option value="1">Admin</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="actions-bar">
                                        <button class="btn btn-outline-primary btn-sm">Export CSV</button>
                                        <button class="btn btn-outline-secondary btn-sm pdfBtn">Download PDF</button>
                                    </div>
                                </div>
                                <div class="table-responsive mb-3">
                                    <table id="logTable" class="brand-table default-form">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"></th>
                                                <th><span class="sortData" data-name="name">Name</span></th>
                                                <th>id</th>
                                                <th>Action</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody id="logTbody" class="download-section"></tbody>
                                    </table>
                                </div>

                                <div id="no-logRecords" class="no-records text-center" style="display:none">No record match your criteria.</div>
                                <div class="pagination" id="paginationLog"></div>
                            </section>
                            <div id="no-data" class="no-records text-center mt-4" style="display:none">You have no activity log at the moment</div>

                        </div>
                    </div>
                </div>

                <?php if ($_SESSION['role'] === '1'): ?>
                    <!-- 2FA, IP & Backup Settings -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h2 class="card-header">2FA & Session Settings</h2>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable2FA">
                                        <label class="form-check-label" for="enable2FA">Enable Two-Factor Authentication</label>
                                    </div>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="enableTimeout">
                                        <label class="form-check-label" for="enableTimeout">Enable Session Timeout (15 min)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4 custom-form">
                                <h2 class="card-header">IP Restrictions & Backups</h2>
                                <div class="card-body">
                                    <label for="allowedIPs">Allowed IPs (comma separated)</label>
                                    <textarea id="allowedIPs" class="form-controls mb-3"></textarea>
                                    <button class="btn btn-outline-error w-100 backupDb" id="backupDb" data-id="<?= $_SESSION['userid']; ?>">Backup Data</button>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
</body>

</html