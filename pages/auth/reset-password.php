<?php

require_once ROOT_PATH . '/includes/header.php';

$token = $_GET['token'] ?? null;

if (!$token) header('location: ' . BASE_URL . 'auth/login');
?>

<body id="AUTHContainer">
    <main class="card-auth" role="main" aria-labelledby="loginTitle">

        <!-- Right / Login form -->
        <section class="side-form" data-aos="fade-left">
            <div class="h">
                <div>
                    <h2 id="loginTitle">Rest Your Password</h2>
                    <div class="desc">Sign in to continue to your dashboard</div>
                </div>
                <div style="display:flex;gap:8px;align-items:center">
                    <button id="themeToggle" class="btn btn-sm" aria-pressed="false" title="Toggle theme"><i class="bi bi-moon-stars"></i></button>
                </div>
            </div>

            <form id="resetForm" novalidate>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="pw-wrap">
                        <input id="password" name="new_password" type="password" placeholder="Enter your new password" minlength="6" required aria-required="true" />
                        <button type="button" class="pw-toggle" aria-label="Show password" title="Show/hide password"><i class="bi bi-eye"></i></button>
                    </div>
                    <div id="pwError" class="muted" style="display:none;color:var(--danger);font-size:13px"></div>
                </div>
                <div id="message"></div>
                <input type="hidden" name="token" value="<?= $token; ?>" />
                <!-- Submit -->
                <div style="display:flex;gap:12px;align-items:center;margin-top:6px">
                    <button id="submitBtn" class="btn btn-primary" type="submit" aria-live="polite">
                        <span id="btnText">Reset Password</span>
                        <span id="btnSpinner" style="display:none;margin-left:8px;vertical-align:middle"><span class="spinner" aria-hidden="true"></span></span>
                    </button>
                </div>

                <div class="foot">
                    <div class="muted">Don't have an account? <a href="register">Sign Up</a></div>
                    <div class="muted">© <span id="yr"></span> 10over10 Cars</div>
                </div>
            </form>
        </section>
        <aside class="side-brand" aria-hidden="false" data-aos="fade-right">
            <div class="logo">
                <a href="<?= BASE_URL  ?>">
                    <img class="brand" src="<?= BASE_URL ?>assets/images/dark-logo.jpg" />
                </a>
                <div>
                    <div style="font-weight:800">10over10 Cars</div>
                    <div style="font-size:13px;color:var(--muted)">VIN verification & verified marketplace</div>
                </div>
            </div>

            <div class="side-ill" role="img" aria-label="Car illustration placeholder">Illustration / Visual</div>

            <p class="side-copy">Secure VIN verification for Nigeria & Africa. Know a vehicle's history before you buy — theft checks, mileage anomalies, ownership timeline and market value estimates.</p>

            <div class="muted">Need help? <a href="#" aria-label="Contact support">Contact support</a></div>
        </aside>
    </main>
    <!-- Toast container (hidden until needed) -->
    <div id="toastContainer" aria-live="polite" style="position:fixed;right:20px;top:20px;z-index:9999"></div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/AuthPage.js"></script>
</body>

</html