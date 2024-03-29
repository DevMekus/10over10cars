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

                        <div class="product-wrapper">
                            <div class="product">
                                <div class="image-carousel section"></div>
                                <div class="information section">
                                    <!-- <div class="icon-wrap">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-heart icon"></i>
                                        </button>
                                    </div> -->
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
                                        <h5>Dallas | Car</h5>
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