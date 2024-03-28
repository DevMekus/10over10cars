<!-- <nav class="nav-container theme-primary">
    <div class="nav-inner container">
        <div class="brand">
            <a href="index.php" class="brand-title"><?php echo $site_name; ?>
            </a>
        </div>
        <div class="nav-links">
            <div class="nav-link-wrap"><a href="#" class="nav-link">About</a></div>
            <div class="nav-link-wrap"><a href="#" class="nav-link">Product & services</a></div>
            <div class="nav-link-wrap"><a href="#" class="nav-link">Faqs & Samples</a></div>
            <div class="nav-link-wrap"><a href="#" class="nav-link">Contact us</a></div>
        </div>
        <div class="auth">
            <a href="auth/login.php" class="btn outline btn-sm nav-btn">Sign in</a>
        </div>
    </div>

</nav> -->

<nav class="navbar navbar-expand-lg nav-container  theme-primary">
    <div class="container">
        <a class="navbar-brand" href="#"><?php echo $site_name; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Product & services</a></li>
                        <li><a class="dropdown-item" href="#">Faqs & Samples</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                </li>


            </ul>
            <form class="d-flex" role="search">
                <a href="auth/login.php" class="btn outline btn-sm nav-btn">Sign in</a>
            </form>

        </div>
    </div>
</nav>