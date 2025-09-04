<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/topbar.php';
?>

<body id="LANDINGPAGE">


    <!-- Pricing -->
    <section id="pricing" class="section" aria-labelledby="pricing-title" data-aos="zoom-in">
        <div class="container">
            <h2 id="pricing-title" class="section-title">Simple pricing in NGN</h2>
            <p class="section-sub">Pay securely via Paystack or Flutterwave. No hidden fees.</p>
            <button class="btn btn-outline-accent" onclick="window.history.back()">⬅ Back</button>

            <div class="pricing mt-4" id="pricingGrid" data-btn="true" data-aos="fade-up"></div>

            <div id="emailField" class="mt-4"></div>
        </div>
    </section>

    <script src="https://js.paystack.co/v1/inline.js"></script>

    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/LandingPage.js"></script>


</body>

</html