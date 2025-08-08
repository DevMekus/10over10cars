<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';

use App\Utils\Utility;



$userid = $_GET['uid'] ?? null;

if (!$userid) header('location: ' . BASE_URL . 'dashboard/overview');

$role = $_SESSION['role'] == "1" ? "admin" : "user";
$url = BASE_URL  . "api/$role/profile/$userid";
$getProfile = Utility::requestClient($url);
$user = $getProfile['data'] ?? null;

?>

<body class="theme-light dashboard">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/dashboard/overview">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Overview</li>
            </ol>
        </nav>
        <div class="container-b">
            <div class="page-header mt-3 mb-3" data-aos="fade-down">
                <div class="welcome"><?= $user['fullname']; ?></div>
                <p>Welcome to your dashboard to manage your account, view recent transactions, and update your preferences for a seamless experience.
                </p>
            </div>
            <?php

            ?>
            <div class="info-list">
                <div class="info-item">
                    <label>Email</label>
                    <span><?= $user['email_address']; ?></span>
                </div>
                <div class="info-item">
                    <label>Phone</label>
                    <span><?= $user['phone_number']; ?></span>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <span><?= $user['account_status']; ?></span>
                </div>
                <div class="info-item">
                    <label>Created</label>
                    <span><?= $user['create_date']; ?></span>
                </div>
            </div>

        </div>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
</body>

</html