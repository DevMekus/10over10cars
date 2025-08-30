<?php
require_once ROOT_PATH . '/includes/header.php';
?>

<body id="LANDINGPAGE" class="paymentPage">
    <div class="vinBox">
        <div data-aos="fade-right">
            <form id="vinForm" class="vin-form" autocomplete="off" novalidate>
                <label for="vin" class="sr-only">Enter VIN</label>
                <input id="vin" class="vin-input" name="vin" maxlength="17" placeholder="Enter 17-character VIN (e.g., 2HGFB2F50DH512345)" inputmode="latin" aria-describedby="vinHint" />
                <button class="btn btn-primary btn-pill" type="submit"><i class="bi bi-shield-check"></i> Verify Now</button>

                <div id="vinHint" class="vin-hint">VIN must be 17 characters, letters & numbers only. (I, O, Q not allowed)</div>
            </form>
            <div id="vinMsg" role="alert" aria-live="polite" style="margin-top:10px; color: var(--muted);"></div>

            <div class="hero-trust">
                <span class="mini-badge"><i class="bi bi-lock"></i> Secure</span>
                <span class="mini-badge"><i class="bi bi-check2-circle"></i> Reliable Data</span>
                <span class="mini-badge"><i class="bi bi-lightning-charge"></i> Instant Results</span>
                <span class="mini-badge"><i class="bi bi-globe2"></i> NG & Africa</span>
            </div>
        </div>
    </div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/LandingPage.js"></script>
</body>

</html