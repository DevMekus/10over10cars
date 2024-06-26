<?php
$title = "Dashboard";
include("header.php");
include("navbar.php");
?>

<body>
    <main class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title sectionSpace">
                    <h1 class="card-title">Dashboard</h1>
                    <p>Welcome Nnaji Nnaemeka</p>
                </div>
                <div class="row sectionSpace">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">My Balance</h5>
                                <p class="text-center">Here you can view the number of prepaid vehicle history reports available to you.</p>
                                <div class="sectionSpace flex align-center space-between">
                                    <p>Prepaid Reports</p>
                                    <h4 class="card-title">0</h4>
                                </div>
                                <div class="sectionSpace">
                                    <button class="btn pill primary fullwidth">Buy More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title text-center">You haven’t checked any vehicles yet!</h2>
                                <p class="text-center">Don't miss your chance to get a complete vehicle history with EpicVIN</p>
                                <div class="sectionSpace form-wrap">
                                    <input type="text" placeholder="Enter VIN Number" class="outline-input fullwidth" />
                                </div>
                                <div class="sectionSpace">
                                    <button class="btn pill primary fullwidth">Check Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="cardj">
                            <div class="card-body">
                                <h2 class="card-title text-center">Will you like to get a <span class="orange">FREE</span>
                                    Vehicle History Report?</h2>
                                <p class="text-center">Refer and get a free Vehicle History Report. It’s that easy. Every time a user purchases their first report using your referral link, you get a free vehicle history report. This is our way of saying thank you for telling people about our services.


                                </p>
                                <div class="sectionSpace flex space-between gap_10">
                                    <div class="form-wrap">
                                        <input type="text" placeholder="Enter VIN Number" class="outline-input fullwidth" value="www.facebook.com/GDJ73632" />
                                    </div>
                                    <button class="btn primary pill">Copy</button>
                                </div>
                                <div class="sectionSpace">
                                    <h5 class="card-title text-center"> SHARE WITH SOCIAL</h5>
                                    <div class="sectionSpace socials">
                                        <a class="#" class="social-link">
                                            <span class="fab fa-facebook icon"></span>
                                        </a>
                                        <a class="#" class="social-link">
                                            <span class="fab fa-instagram icon"></span>
                                        </a>
                                        <a class="#" class="social-link">
                                            <span class="fab fa-twitter icon"></span>
                                        </a>
                                        <a class="#" class="social-link">
                                            <span class="fab fa-youtube icon"></span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sectionSpace">
                    <h2 class="card-title">Latest Reports</h2>
                    <div class="card sectionSpace">
                        <div class="card-body">
                            <p>You don’t have any purchased reports yet</p>
                            <button class="btn outline">Check your car</button>
                        </div>
                    </div>
                </div>

                <div class="sectionSpace cars-select">
                    <div class="page-title sectionSpace">
                        <h2 class="card-title">Don't know what are you looking for? Start with type</h2>
                    </div>
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

                <?php include("footer-links.php");  ?>
            </div>
        </div>
    </main>
    <?php include("footer.php");  ?>