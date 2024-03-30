<?php
$title = "Report";
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
                            <h1 class="card-title">Car Market</h1>
                            <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Market</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="sectionSpace">
                            <h2 class="card-title">My Saved searches</h2>
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
                                            <div class="fullwidth flex space-between">
                                                <label>Price </label>
                                                <h5 class="card-title">$ <span id="demo" class="greenColor"></span></h5>
                                            </div>
                                            <div class="slidecontainer">
                                                <input type="range" min="1000" max="10000" value="50" class="slider" id="myRange">
                                            </div>
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

                        <div class="product-wrapper sectionSpace">
                            <div class="product">
                                <div class="image-carousel section"></div>
                                <div class="information section">
                                    <div class="icon-wrap">
                                        <button class="btn btn-sm btn-light">
                                            <i class="fas fa-heart icon"></i>
                                        </button>
                                    </div>
                                    <h5 class="product-title">Used 2020 <span class="orange">Ford Ranger</span></h5>
                                    <div class="flex gap_10">
                                        <h4 class="product-price">$20,999</h4>
                                        <p>VIN: <span class="orange">1FTER4EH7LLA61477</span></p>
                                    </div>
                                    <div class="flex gap_10">
                                        <p>
                                            <i class="fas fa-certificate greenColor"></i>
                                            Authorized EpicVIN dealer
                                        </p>
                                        <h5>Enugu... | Car</h5>
                                    </div>

                                    <button class="btn fullwidth pill primary">Check details</button>
                                </div>
                            </div>
                            <div class="product">
                                <div class="image-carousel section"></div>
                                <div class="information section">
                                    <div class="icon-wrap">
                                        <button class="btn btn-sm btn-light">
                                            <i class="fas fa-heart icon"></i>
                                        </button>
                                    </div>
                                    <h5 class="product-title">Used 2020 <span class="orange">Ford Ranger</span></h5>
                                    <div class="flex gap_10">
                                        <h4 class="product-price">$20,999</h4>
                                        <p>VIN: <span class="orange">1FTER4EH7LLA61477</span></p>
                                    </div>
                                    <div class="flex gap_10">
                                        <p>
                                            <i class="fas fa-certificate greenColor"></i>
                                            Authorized EpicVIN dealer
                                        </p>
                                        <h5>Enugu... | Car</h5>
                                    </div>

                                    <button class="btn fullwidth pill primary">Check details</button>
                                </div>
                            </div>
                            <div class="product">
                                <div class="image-carousel section"></div>
                                <div class="information section">
                                    <div class="icon-wrap">
                                        <button class="btn btn-sm btn-light">
                                            <i class="fas fa-heart icon"></i>
                                        </button>
                                    </div>
                                    <h5 class="product-title">Used 2020 <span class="orange">Ford Ranger</span></h5>
                                    <div class="flex gap_10">
                                        <h4 class="product-price">$20,999</h4>
                                        <p>VIN: <span class="orange">1FTER4EH7LLA61477</span></p>
                                    </div>
                                    <div class="flex gap_10">
                                        <p>
                                            <i class="fas fa-certificate greenColor"></i>
                                            Authorized EpicVIN dealer
                                        </p>
                                        <h5>Enugu... | Car</h5>
                                    </div>

                                    <button class="btn fullwidth pill primary">Check details</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </section>
</main>

<?php include("footer.php");  ?>