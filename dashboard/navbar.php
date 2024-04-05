<nav class="navbar navbar-expand-lg nav-container nav-shadow  theme-primary">
    <div class="container">
        <a class="navbar-brand bold" href="#">
            <img src="../assets/logo/logo-white-edit.jpg" class="img-fluid logo-img" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link active" aria-current="page" href="./index.php">Dashboard</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" aria-current="page" href="./report.php">My Reports</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="./transactions.php">Transactions</a>
                </li>

                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="./favourites.php">Favorite</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="./search.php">Search</a>
                </li>
                <li class="nav-item dropdown nav-link-wrap">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-link-wraps"><a class="dropdown-item" href="./sample-report.php">Sample Report</a></li>
                        <li class="nav-link-wraps"><a class="dropdown-item" href="./vin-decoder.php">Vin Decoder</a></li>
                        <li class="nav-link-wraps"><a class="dropdown-item" href="./report-theft.php">Report Theft</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="./dealers.php">For Dealers</a></li>
                        <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="./products.php">Cars for sale <span class="badge bg-success">new</span></a>
                </li>

            </ul>
            <form class="flex align-center gap_10" role="search">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="toggleTheme()">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dark theme</label>
                </div>
                <a href="#" class="btn danger btn-sm nav-btn">Logout</a>
            </form>

        </div>
    </div>
</nav>