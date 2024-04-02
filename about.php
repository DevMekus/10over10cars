<?php
$title = "Welcome";
include("header.php");

?>

<body class="theme-primary">
    <section class="theme-black">
        <?php include("navbar.php"); ?>
        <div class="container padding-20">
            <div class="row">
                <div class="col-sm-8">
                    <div class="section-title">
                        <h1 class="card-title big-title"><?php echo $site_name; ?>, Your Go-To for <span class="orange">Buying, Selling and Owning</span> a Vehicle</h1>
                    </div>
                    <div class="sectionSpace">
                        <h5 class="card-title">What if you had a digital dashboard for your car ownership needs?</h5>
                        <p class="text-justify">
                            A place where you can access regularly updated vehicle history reports, compare vehicles, shop for the best auto insurance rates, get instant market value appraisal and so much more. Whether you’re shopping for a new car, comparing auto insurance policies or looking to sell an existing vehicle, Bumper has you covered every step of the way.
                        </p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <img src="assets/about-main-image.png" class="img-fluid" />
                </div>
            </div>
        </div>
        <section class="">
            <div class="section-title">
                <h1 class="card-title text-center">Car Ownership Made <span class="greenColor">Easy With <?php echo $site_name; ?></span></h1>
                <p class="text-center sectionSpace">
                    Bumper's mission is simple: make the car owning, buying and selling experience better and more affordable.
                </p>
                <div class="container">
                    <div class="row sectionSpace">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Reports</h5>
                                    <p class="text-center">Vehicle history reports for one low cost</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Information</h5>
                                    <p class="text-center">Access to reliable information on accidents, recalls, market value and more</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Tools</h5>
                                    <p class="text-center">Easy-to-use tools available online or through our mobile app</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>
    <section class="bg-grey">
        <div class="container padding-20">
            <div class="row">
                <div class="col-sm-7">
                    <div class="section-title">
                        <h1 class="card-title">Run vehicle history reports</h1>
                    </div>
                    <div class="sectionSpace">
                        <p class="text-justify p-20">
                            <?php echo $site_name; ?> compiles reliable, up-to-date information from NMVTIS, JD Power, NHTSA, and many other top industry leaders data sources, including government agencies, insurance providers and car industry partners. Search by license plate, vehicle identification number (VIN) or make and model to find vehicle history reports, market value data, in-depth ownership costs and more.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <img src="assets/history-reports.png" class="img-fluid" />
                </div>
            </div>
        </div>

        <div class="container padding-20">
            <div class="row">
                <div class="col-sm-5">
                    <img src="assets/exclusive-features.png" class="img-fluid" />
                </div>
                <div class="col-sm-7">
                    <div class="section-title">
                        <h1 class="card-title">Get exclusive features available through <?php echo $site_name; ?> </h1>
                    </div>
                    <div class="sectionSpace">

                        <p class="text-justify p-20">
                            Your <?php echo $site_name; ?> subscription includes access to Bumper Connect, a powerful tool that lets you monitor real-time data from your Wi-Fi enabled car. Get suggested car maintenance reminders, tire pressure gauge, odometer readings and so much more right from your smartphone.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="theme-black vh60 flex align-center">
        <div class="container padding-20">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h1 class="card-title text-center big-title">Shop <span class="orange">Marketplace</span> for your next vehicle</h1>

                    </div>
                    <div class="sectionSpace">
                        <p class="text-center p-20">Browse and monitor new and used cars from more than 50,000 dealerships nationwide.

                            Set up alerts to receive real-time updates on any vehicles you may be considering buying.</p>
                    </div>
                    <div class="sectionSpace fullwidth flex flex-center">
                        <a href="#" class="btn outline">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php include("footer.php");  ?>