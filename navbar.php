<nav class="navbar navbar-expand-lg nav-container nav-shadow  theme-primary">
    <div class="container">
        <a class="navbar-brand bold" href="#">
            <img src="assets/logo/logo-white-edit.jpg" class="img-fluid logo-img" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link white-link" aria-current="page" href="./index.php">Home</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link white-link" href="./about.php">About us</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link white-link" href="./services.php">Services</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link white-link" href="./sample-report.php">Sample report</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link white-link" href="./cars.php">Search Car</a>
                </li>

                <li class="nav-item nav-link-wrap">
                    <a class="nav-link white-link" href="./contact-us.php">Contact us</a>
                </li>


            </ul>
            <form class="flex align-center gap_10" role="search">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="toggleTheme()">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dark theme</label>
                </div>
                <a href="auth/login.php" class="btn primary btn-sm nav-btn">Sign in</a>
            </form>

        </div>
    </div>
</nav>