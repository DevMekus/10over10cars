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
                <li class="breadcrumb-item active" aria-current="page">Overview</li>
            </ol>
        </nav>
        <div class="page-header mb-3" data-aos="fade-down">
            <div class="welcome">Welcome back <?= explode(" ", $user['fullname'])[0] ?? 'User'; ?>,</div>
            <p>Welcome to your dashboard to manage your account, view recent transactions, and update your preferences for a seamless experience.
            </p>
        </div>
        <?php if ($_SESSION['role'] == '1'): ?>
            <section class="mb-3 cards">
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
            </section>

        <?php endif; ?>
        <?php if ($_SESSION['role'] == '2'): ?>
            <section class="mt-3 mb-3 cards">
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
                <div class="card">
                    <h2>Total Verifications</h2>
                    <p>36 Vehicles</p>
                </div>
            </section>
            <section class="chart mb-3" data-aos="zoom-in">
                <canvas id="verificationsChart" height="100"></canvas>
            </section>
            <section class="mb-3" data-aos="fade-right">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">
                            <h2>Recent Vehicle Verifications</h3>
                                <div class="table-responsive">
                                    <table class="brand-table">
                                        <thead>
                                            <tr>
                                                <th>VIN</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>4T1BURHE7KU123456</td>
                                                <td>✔️ Verified</td>
                                                <td>2025-06-10</td>
                                            </tr>
                                            <tr>
                                                <td>2HGFB2F5XCH123789</td>
                                                <td>⏳ Pending</td>
                                                <td>2025-06-11</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card" data-aos="fade-up">
                            <h2> Quick VIN Lookup</h2>
                            <div class="vin-lookup tomselect-style">
                                <form>
                                    <input type="text" class="brand-form" placeholder="Enter VIN to verify quickly...">
                                    <div class="mt-2 d-grid">
                                        <button class="btn btn-primary">Lookup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="quick-links card mb-3" data-aos="fade-up">
                <h2>Quick Links</h2>
                <ul>
                    <li><i class="fas fa-plus"></i> <a href="#"> Verify New Vehicle</a></li>
                    <li><i class="fas fa-download"></i> <a href="#"> Download Reports</a></li>
                    <li><i class="fas fa-credit-card"></i> <a href="#"> Add Credits</a></li>
                    <li><i class="fas fa-envelope"></i> <a href="#"> Contact Support</a></li>
                </ul>
            </section>
        <?php endif; ?>

    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
</body>

</html