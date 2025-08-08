<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';
?>

<body id="verificationReport" class="theme-light dashboard"
    data-page="<?= $_SESSION['role']; ?>"
    data-id="<?= $_SESSION['userid']; ?>">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>dashboard/overview">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dealers</li>
            </ol>
        </nav>
        <div class="page-header mt-3 mb-3" data-aos="fade-down">
            <div class="welcome">Verification System Management
            </div>
            <div class="page-note accent" data-aos="fade-in">
                This page lists all verified and pending car dealers. You can update status, view performance, or remove a dealer.
            </div>
        </div>
        <section class="mt-4">
            <div class="top-controls">
                <div class="filters">
                    <input type="text" id="searchInput" placeholder="Search by VIN or Owner Name" />
                    <select id="statusFilter">
                        <option value="">All Status</option>
                        <option value="approve">Approve</option>
                        <option value="decline">Decline</option>
                        <option value="missing">Missing</option>
                        <option value="reported">Reported</option>
                        <option value="found">Found</option>

                    </select>
                </div>
                <div class="actions-bar">
                    <button class="btn btn-outline-primary btn-sm">Export CSV</button>
                    <button class="btn btn-outline-secondary btn-sm pdfBtn">Download PDF</button>
                    <?php if ($_SESSION['role'] !== '1'): ?>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verificationModal"><i class="fas fa-plus"></i>New Request</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="brand-table" id="theftTable">
                    <thead>
                        <tr>
                            <th>VIN</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Submitted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="verificationTbody" class="download-section"></tbody>
                </table>
                <div id="no-records" class="no-records text-center mt-4 text-muted" style="display:none">Record not found.</div>
                <div class="pagination" id="pagination"></div>
            </div>
        </section>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
</body>

</html