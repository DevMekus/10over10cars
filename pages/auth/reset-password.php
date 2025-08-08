<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

$token = $_GET['token'] ?? null;

if (!$token) header('location: ' . BASE_URL . 'auth/login');

?>

<body class="theme-light auth-container bg-login" data-page="reset">
    <?php require_once  'navbar.php'; ?>
    <div class="overlay"></div>
    <div class="form-area" data-aos="zoom-in">

        <div class="form-container">
            <h3>Reset Your Password</h3>
            <p>Login to account using your email and password</p>
            <div id="message"></div>
            <form class="authForm tomselect-style" id="resetPassword">
                <div class="form-group password-group">
                    <label>New Password</label>
                    <input type="password" id="password" name="new_password" class="brand-form" placeholder="Enter New Password" required />
                    <i class="fas fa-eye" id="togglePassword"></i>
                    <small>Error message</small>
                </div>
                <div class="password-strength">
                    <div id="strengthBar"></div>
                    <small id="strengthText"></small>
                </div>

                <input type="hidden" name="token" value="<?= $token; ?>" />
                <button class="submit-btn btn btn-accent" type="submit">Sign In</button>
            </form>
            <div class="form-actions mt-2 text-center">
                <span>Don't have an account?</span> <a href="register">Create one</a>
            </div>

        </div>
    </div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/FormValidator.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Authentication.js"></script>
</body>


</html>