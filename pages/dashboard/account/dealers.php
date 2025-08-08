<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';
?>

<body class="theme-light dashboard">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
        <div class="page-header mt-3 mb-3" data-aos="fade-down">
            <div class="welcome">Car Dealers</div>
            <p>Welcome to your dashboard to manage your account, view recent transactions, and update your preferences for a seamless experience.
            </p>
        </div>
        <section class="cards" id="dealer_manager_summary"></section>

        <section class="mt-3 mb-3" id="data-container">
            <div class="top-controls">
                <div class="filters">
                    <input type="text" id="searchInput" placeholder="Search by dealer/email" />

                    <select id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div class="actions-bar">
                    <button class="btn btn-outline-primary btn-sm">Export CSV</button>
                    <button class="btn btn-outline-secondary btn-sm pdfBtn">Download PDF</button>
                </div>
            </div>
            <div class="table-responsive mb-3">
                <table id="userTable" class="brand-table default-form">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th><span class="sortData" data-name="name">Dealer</span></th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Listed</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="dealerTbody" class="download-section"></tbody>
                </table>
            </div>
            <div id="no-records" class="no-records text-center" style="display:none">No record match your criteria.</div>
            <div class="pagination" id="pagination"></div>
        </section>
        <div id="no-data" class="no-records text-center mt-4" style="display:none">You have no dealer at the moment</div>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
</body>

</html