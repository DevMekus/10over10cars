<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body class="theme-light auth-container bg-login" data-page="recover">
    <?php require_once  'navbar.php'; ?>
    <div class="overlay"></div>
    <div class="form-area" data-aos="zoom-in">

        <div class="form-container">
            <h3>Recover Your Password</h3>
            <p>Login to account using your email and password</p>
            <div id="message"></div>
            <form class="authForm tomselect-style" id="recoverForm">

                <div class="form-group password-group">
                    <label>Email address</label>
                    <input type="email" id="email" name="email_address" class="brand-form" placeholder="Enter your email" required />
                    <small>Error message</small>
                </div>
                <button class="submit-btn btn btn-accent" type="submit">Send Reset Link</button>
            </form>
            <div class="form-actions mt-2 text-center">
                <p class="note">We'll email you a secure link to reset your password.</p>
            </div>

        </div>
    </div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/FormValidator.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Authentication.js"></script>
</body>


</html>