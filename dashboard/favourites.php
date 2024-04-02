<?php
$title = "Favourites";
include("header.php");
?>
<main class="dash-wrap theme-primary">
    <section class="sidebar-section">
        <?php include("sidebar.php");  ?>
    </section>
    <section class="content-section">
        <?php include("navbar.php");  ?>
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title sectionSpace">
                            <h1 class="card-title">My Favorites</h1>
                            <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Favorites</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="sectionSpace">
                            <!-- <h2 class="card-title">Latest Reports</h2> -->
                            <div class="card sectionSpace">
                                <div class="card-body">
                                    <h5>No saved cars.</h5>
                                    <p>Thinking to buy a car? Saving your search helps you:</p>
                                    <ul>
                                        <li>Gather your favorite items</li>
                                        <li>Contrast features</li>
                                        <li>Keep track of availability</li>
                                    </ul>
                                    <p>To add a car, click “heart“ on any specific search result or car ad page.</p>
                                    <a href="./products.php" class="btn outline">Start Search</a>
                                </div>
                            </div>
                        </div>
                        <div class="sectionSpace">
                            <h2 class="card-title">Don't know what are you looking for? Start with type</h2>

                            <div class="row cars-select">
                                <div class="col-sm-2">
                                    <div>
                                        <img src="../assets/cars/hatchback.png" class="img-fluid" alt="car-hatchback" />
                                        <h5 class="card-title text-center">Hatchback</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <img src="../assets/cars/minivan.png" class="img-fluid" alt="car-minivan" />
                                        <h5 class="card-title text-center">Minivan</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <img src="../assets/cars/pickup.png" class="img-fluid" alt="car-pickup" />
                                        <h5 class="card-title text-center">Pickup</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <img src="../assets/cars/sedan.png" class="img-fluid" alt="car-sedan" />
                                        <h5 class="card-title text-center">Sedan</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <img src="../assets/cars/suv.png" class="img-fluid" alt="car-suv" />
                                        <h5 class="card-title text-center">Suv</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <img src="../assets/cars/wagon.png" class="img-fluid" alt="car-wagon" />
                                        <h5 class="card-title text-center">Wagon</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d fullwidth flex flex-center sectionSpace">
                                <a href="./products.php" class="btn outline">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include("footer.php");  ?>
    </section>
</main>