<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

use App\Utils\Utility;

Utility::verifySession();
$vin = $_GET['vin'] ?? null;
?>

<body class="theme-light" id="vehicleDetailPage">

    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h3 data-aos="fade-right">Vehicle Overview</h3>
            <button class="btn btn-outline-secondary" onclick="history.back()">
                <i class="bi bi-arrow-left"></i> Back
            </button>
        </div>

        <div class="row g-4">
            <div class="col-md-8" data-aos="zoom-in">
                <img src="" id="mainImage" class="main-image" alt="Vehicle">
            </div>
            <div class="col-md-4 d-flex flex-wrap gap-2" data-aos="fade-left" id="thumbnailContainer"> <!-- thumbnails -->

            </div>

            <div class="row my-5 g-4 align-items-center">
                <!-- Vehicle Info Card -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="card border-0 shadow p-4 h-100 rounded-4 bg-white">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4 text-primary">
                                <i class="bi bi-info-circle me-2"></i> Vehicle Information
                            </h5>
                            <ul class="list-unstyled fs-6">
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Price & Buy Now Card -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="card border-0 shadow p-4 h-100 rounded-4 bg-light">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold mb-4 text-success">
                                    <i class="bi bi-cash-stack me-2"></i> Price
                                </h5>
                                <h2 class="fw-bold text-dark">$15,000</h2>
                                <p class="text-muted small">Inclusive of all charges</p>
                            </div>
                            <button class="btn btn-success w-100 mt-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-cart-check me-2"></i> Buy This Vehicle
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center my-4">
                <button class="btn btn-primary px-5 py-3" onclick="unlockFullReport()">
                    <i class="bi bi-unlock"></i> Unlock Full Report
                </button>
            </div>

            <div id="paidContent" class="d-none" data-aos="fade-up">
                <h4 class="mt-5">Premium Report</h4>
                <div class="card p-4">
                    <p>Ownership Records: ...</p>
                    <p>Inspection Report: ...</p>
                    <p>Service History: ...</p>
                </div>
            </div>
        </div>
    </div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/LandingPage.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Vehicle.js"></script>

</body>

</html