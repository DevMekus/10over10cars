<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body class="theme-light auth-container bg-login" data-page="login">
    <?php require_once  'navbar.php'; ?>
    <div class="overlay"></div>
    <div class="form-area" data-aos="zoom-in">
        <div class="form-container">
            <h3>Login Account</h3>
            <p>Login to account using your email and password</p>
            <div class="feedback"></div>
            <form class="authForm tomselect-style" id="loginForm">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email_address" placeholder="Your email">
                    <span class="help-text">We'll never share your email.</span>
                    <small>Error message</small>
                </div>

                <div class="form-group password-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="user_password" class="brand-form" placeholder="Password" required />
                    <i class="fas fa-eye" id="togglePassword"></i>
                    <small>Error message</small>
                </div>
                <div class="form-actions recover mt-2">
                    <a href="recover-account">Forgot Password?</a>
                </div>
                <button class="submit-btn btn-primary" type="submit">Sign In</button>
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