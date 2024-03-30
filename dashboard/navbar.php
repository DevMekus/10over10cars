<nav class="navbar navbar-expand-lg nav-container nav-shadow  theme-primary">
    <div class="container">
        <a class="navbar-brand bold" href="#"><?php echo $site_name; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link active" aria-current="page" href="#">Sample Report</a>
                </li>
                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="report.php">Vin Decoder</a>
                </li>

                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="transactions.php">For Dealers</a>
                </li>
                <li class="nav-item dropdown nav-link-wrap">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Our Services
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-link-wraps"><a class="dropdown-item" href="search.php">Search car</a></li>
                        <li class="nav-link-wraps"><a class="dropdown-item" href="favourites.php">My favourites</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-link-wrap">
                    <a class="nav-link" href="./products.php">Cars for sale</a>
                </li>

            </ul>
            <form class="d-flex" role="search">
                <a href="#" class="btn outline btn-sm nav-btn">Logout</a>
            </form>

        </div>
    </div>
</nav>