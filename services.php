<?php
$title = "Welcome";
include("header.php");

?>

<body class="theme-primary">
    <section class="theme-black">
        <?php include("navbar.php"); ?>
        <div class="container padding-20">
            <div class="page-title sectionSpace">
                <h1 class="card-title">Services</h1>
                <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Market</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="section-title">
                        <h1 class="card-title big-title"> Stolen <span class="orange">Vehicles Check</span> & Ownership Verification</h1>
                    </div>
                    <div class="sectionSpace">

                        <p class="text-justify p-20">
                            This service is most suitable for users buying locally-used vehicles. Using a vehicle’s Vehicle Identification Number (VIN), a search can be made on our web application (legitcar.ng) to determine if a vehicle has been reported stolen. The vehicle’s License Plate Number is also required to verify the vehicle’s registration and confirm authorisation to sell the vehicle from the registered owner.
                        </p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <img src="assets/about-main-image.png" class="img-fluid" />
                </div>
            </div>
        </div>


    </section>
    <section class="bg-grey">
        <div class="container padding-20">
            <div class="row">
                <div class="col-sm-7">
                    <div class="section-title">
                        <h1 class="card-title big-title">Vehicle <span class="orange">History Report</span> </h1>
                    </div>
                    <div class="sectionSpace">
                        <p class="text-justify p-20">
                            We have the Carfax and ClearVin Vehicle History Reports available. This service is most suitable for buyers of foreign-used vehicles that have not been used locally. A vehicle history report chronicles the life of a vehicle abroad, and contains information such as Accident History, Actual Mileage, Maintenance History, Date of Shipping to Nigeria or another destination, type and number of users, etc.
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
                        <h1 class="card-title big-title">Vehicle <span class="orange">Pre-purchase Inspection</span></h1>
                    </div>
                    <div class="sectionSpace">

                        <p class="text-justify p-20">
                            This is the only service where physical contact with a vehicle by a LegitCar team member is required. Before a vehicle purchase is made, a LegitCar Vehicle Inspector physically examines the vehicle, scans all the electronic systems of the vehicle with our state-of-the-art OBD II equipment, and generates an initial report. After analysing the vehicle’s Carfax Report and registration data, a final report which also contains expert purchase advise is issued. This service is suitable for discerning car buyers who need every available information about a vehicle to make an informed vehicle purchase decision.
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