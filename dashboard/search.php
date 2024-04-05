<?php
$title = "Search";
include("header.php");
include("navbar.php");
?>

<body>
    <main class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Search</li>
                    </ol>
                </nav>
                <div class="sectionSpace">
                    <h1 class="card-title">Saved searches</h1>
                    <div class="card sectionSpace">
                        <div class="card-body">
                            <h5>Are you looking to purchase a Pre-owned or Used car?</h5>
                            <p>Find the right car for the right price, connect with dealers, and get detailed vehicle history, all in a single place.</p>
                            <div class="btn-group sectionSpace" role="group" aria-label="Basic mixed styles example">
                                <button type="button" class="btn primary">Search by Make</button>
                                <button type="button" class="btn outline">Search by Dealer</button>
                            </div>
                            <div class="filterbox">
                                <div class="filter">
                                    <p>Make</p>
                                    <select>
                                        <option class="selected">All makes</option>
                                        <option>1</option>
                                        <option>1</option>
                                    </select>
                                </div>
                                <div class="filter">
                                    <p>Model</p>
                                    <select>
                                        <option class="selected">All models</option>
                                        <option>1</option>
                                        <option>1</option>
                                    </select>
                                </div>
                                <div class="filter">
                                    <p>Max price</p>
                                    <select>
                                        <option class="selected">All Prices</option>
                                        <option>1</option>
                                        <option>1</option>
                                    </select>
                                </div>
                                <div class="filter">
                                    <p>Location</p>
                                    <select>
                                        <option class="selected" selected>All States</option>
                                        <option>1</option>
                                        <option>1</option>
                                    </select>
                                </div>
                                <button class="btn outline">Search</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="filter-result sectionSpace"></div>

                <div class="sectionSpace card">
                    <div class="card-body">
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

                <?php include("footer-links.php");  ?>
            </div>
        </div>
    </main>
    <?php include("footer.php");  ?>