<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body class="theme-light auth-container bg-login" data-page="signup">
    <?php require_once  'navbar.php'; ?>
    <div class="overlay"></div>
    <div class="form-area" data-aos="zoom-in">
        <div class="form-container">
            <h3>Create an Account </h3>
            <p>Create an Account using your email and password</p>
            <div class="feedback"></div>
            <form class="authForm tomselect-style" id="registerForm">
                <div class="form-group mb-2">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="brand-form" id="fullname" name="fullname" required />
                    <small>Error message</small>
                </div>

                <div class="form-group mb-2">
                    <label>Email address</label>
                    <input type="email" id="email" name="email_address" class="brand-form" placeholder="Email" required />
                    <small>Error message</small>
                </div>
                <input type="hidden" name="role" value="2" />

                <div class="form-group password-group mb-2">
                    <label>Password</label>
                    <input type="password" id="password" name="user_password" class="brand-form" placeholder="Password" required />
                    <i class="fas fa-eye" id="togglePassword"></i>
                    <small>Error message</small>
                </div>
                <div class="password-strength">
                    <div id="strengthBar"></div>
                    <small id="strengthText"></small>
                </div>
                <button class="submit-btn btn btn-primary" type="submit">Sign Up</button>
            </form>
            <div class="form-actions mt-2 text-center">
                <span>Already have an account?</span> <a href="login">Sign In</a>
            </div>

        </div>
    </div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/FormValidator.js"></script>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Authentication.js"></script>
</body>


</html>