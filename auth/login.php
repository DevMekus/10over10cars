<?php
$title = "Login";
include("header.php");
?>

<body>
    <main class="auth-wrap">
        <div class="left-section section">
        </div>
        <div class="right-section section">
            <?php include("navbar.php");  ?>
            <div class="form-container">
                <div class="form-box">
                    <h1 class="card-title">Sign <span class="orange">in</span></h1>
                    <form class="auth-form">
                        <div class="form-wrap">
                            <label>Email address</label>
                            <input type="email" class="form-item" placeholder="You@email.com" required />
                        </div>
                        <div class="form-wrap">
                            <label>Password</label>
                            <input type="password" class="form-item" placeholder="*******" required />
                            <div class="sectionSpace">
                                <a href="./reset.php">Forgot your password?</a>
                            </div>
                        </div>
                        <div class="form-wrap">
                            <button class="btn pill primary">Sign In</button>
                        </div>
                    </form>
                    <div class="sectionSpace">
                        <p class="text-center">This site is protected by <span class="orange">Cloudflare Turnstile</span> and its Privacy Policy and Terms of Service apply.</p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="toggleTheme()">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Dark theme</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("footer.php");  ?>