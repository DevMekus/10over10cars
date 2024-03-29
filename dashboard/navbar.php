<nav class="navbar navbar-expand-lg nav-container nav-shadow  theme-primary">
    <div class="container">
        <a class="navbar-brand " href="#"><?php echo $site_name; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="report.php">My Report</a>
                </li>

                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="transactions.php">Transaction</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="search.php">Saved Search</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="#">Subscriptions</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="#">Settings <i class="fas fa-cog"></i></a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <a href="auth/login.php" class="btn outline btn-sm nav-btn">Logout</a>
            </form>

        </div>
    </div>
</nav>