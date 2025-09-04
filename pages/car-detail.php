<?php

use App\Utils\Utility;

require_once ROOT_PATH . '/siteConfig.php';
$vin = $_GET['vin'] ?? null;
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/topbar.php';

if (!$vin) header('location: ' . BASE_URL);
$url        = BASE_URL . "api/v1/car/$vin";
$getCar = Utility::requestClient($url);
$carArray = $getCar['data'] ?? null;;

if ($carArray) {
    $car = $carArray[0];
    $images = json_decode($car['images'], true);
}


?>

<body id="LANDINGPAGE" class="carDetailsPage">
    <section id="pricing" class="section" aria-labelledby="pricing-title" data-aos="zoom-in">
        <div class="container">
            <h2 id="pricing-title" class="section-title">Simple pricing in NGN</h2>
            <p class="section-sub" id="section-sub">Pay securely via Paystack or Flutterwave. No hidden fees.</p>
            <button class="btn btn-outline-accent" onclick="window.history.back()">⬅ Back</button>
            <div class="container_" data-aos="fade-up">
                <!-- Gallery -->
                <div class="car-gallery">
                    <div class="carousel-main" id="carCarousel">
                        <div class="carousel-controls">
                            <button id="prevBtn"><i class="bi bi-chevron-left"></i></button>
                            <button id="nextBtn"><i class="bi bi-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="thumbnails" id="thumbnails"></div>
                </div>

                <!-- Info -->
                <div class="car-info">
                    <h2 id="carTitle">Car Title</h2>
                    <div class="car-meta" id="carMeta">Year • Mileage • State</div>
                    <div class="car-price" id="carPrice">₦0</div>
                    <p class="section-sub">Pay securely via Paystack or Flutterwave. No hidden fees.</p>
                    <div class="actions">
                        <button class="btn btn-primary btn-pill" id="purchaseBtn"><i class="bi bi-cart"></i> Purchase</button>

                        <a href="<?= BASE_URL ?>secure/payment?vin=<?= $vin; ?>" class="btn btn-outline-primary" id="verifyBtn"><i class="bi bi-shield-check"></i> Verify VIN</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/LandingPage.js"></script>

    <script>
        AOS.init();


        // const params = new URLSearchParams(window.location.search);
        // const vin = params.get("vin");


        const CAR = <?= json_encode($car, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
        const CAR_IMAGES = <?= json_encode($images, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;


        const carousel = document.getElementById("carCarousel");
        const thumbnails = document.getElementById("thumbnails");

        // Render main images
        CAR_IMAGES.forEach((img, i) => {
            const imageEl = document.createElement("img");
            imageEl.src = img;
            if (i === 0) imageEl.classList.add("active");
            carousel.insertBefore(imageEl, carousel.querySelector(".carousel-controls"));

            // thumbnails
            const thumb = document.createElement("img");
            thumb.src = img;
            if (i === 0) thumb.classList.add("active");
            thumb.addEventListener("click", () => {
                current = i;
                showImage(current);
            });
            thumbnails.appendChild(thumb);
        });

        // Info
        document.getElementById("carTitle").textContent = CAR.title;
        document.getElementById("pricing-title").textContent = CAR.title;
        document.getElementById("section-sub").textContent = CAR.notes ?? '';
        document.getElementById("carMeta").textContent = `${CAR.year} • ${CAR.mileage.toLocaleString()} km • ${CAR.state}`;
        document.getElementById("carPrice").textContent = "₦" + Number(CAR.price).toLocaleString();

        // Carousel logic
        const imgs = carousel.querySelectorAll("img");
        const thumbs = thumbnails.querySelectorAll("img");
        let current = 0;

        function showImage(index) {
            imgs.forEach((img, i) => img.classList.toggle("active", i === index));
            thumbs.forEach((t, i) => t.classList.toggle("active", i === index));
        }
        document.getElementById("prevBtn").addEventListener("click", () => {
            current = (current - 1 + imgs.length) % imgs.length;
            showImage(current);
        });
        document.getElementById("nextBtn").addEventListener("click", () => {
            current = (current + 1) % imgs.length;
            showImage(current);
        });

        // Buttons
        document.getElementById("purchaseBtn").addEventListener("click", () => {
            alert("Proceed to purchase flow...");
        });
    </script>
</body>

</html