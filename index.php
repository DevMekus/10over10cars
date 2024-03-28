<?php
$title = "Welcome";
include("header.php");
?>

<body class="theme-primary">
    <header class="index-header">
        <?php include("navbar.php"); ?>
        <div class="header-inner">
            <div class="main-title-area">
                <h4 class="card-title">Are you worried about buying a used car?</h4>
                <h1 class="card-title blur-background-content">
                    <span>Save Yourself</span> Thousands <span>With A</span> Comprehensive Vehicle <span>History Report</span>
                </h1>
                <h4 class="card-title">Your Free VIN Check is just a click away</h4>
                <div class="cta">
                    <a href="#" class="btn outline">Get Started</a>
                </div>
            </div>
        </div>
    </header>
    <main class="theme-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <section class="section">
                        <div class="section-title">
                            <h1 class="card-title text-center">Why <span class="orange"><?php echo $site_name; ?></span> ?</h1>
                            <p class="sub-title text-center">Market value monitor, history report, <span class="orange">theft alert</span>, sales</p>
                        </div>
                        <div class="row sectionSpace">
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="icon text-center">
                                            <img src="assets/icon-reason-1.svg" />
                                        </div>
                                        <p class="text-center sectionSpace">
                                            <?php echo $site_name; ?> customers save 3x on average on vehicle history reports compared to the leading competitor.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="icon text-center">
                                            <img src="assets/logo-nmvtis.webp" class="img-fluid" />
                                        </div>
                                        <p class="text-center sectionSpace">
                                            <?php echo $site_name; ?> is an approved NMVTIS Data Provider, and thousands of vehicle history reports are run weekly.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="icon text-center">
                                            <img src="assets/data.svg" />
                                        </div>
                                        <p class="text-center sectionSpace">
                                            Gain access to vehicle data from NMVTIS, JD Power, NHTSA, and many other auto industry leaders
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="section-title">
                            <h1 class="card-title text-center">Numerous <span class="orange">services and features</span> under the hood</h1>
                            <p class="sub-title text-center"><?php echo $site_name; ?>.com is here to modernize the vehicle ownership experience</p>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-wrapper">
                                    <div class="tabs-header">
                                        <button class="btn outline btn-sm tab" data-id="1"><?php echo $site_name; ?></button>
                                        <button class="btn outline btn-sm tab" data-id="1">Market</button>
                                        <button class="btn outline btn-sm tab" data-id="1">Connect</button>
                                        <button class="btn outline btn-sm tab" data-id="1">Value Tools</button>
                                        <button class="btn outline btn-sm tab" data-id="1">Theft Check</button>
                                    </div>
                                    <div class="tabs-body">
                                        <h2 class="cart-title text-center">Vehicle history reports
                                        </h2>
                                        <p class="sectionSpace text-center">
                                            Bumper compiles reliable, regularly updated information from NMVTIS, JD Power, NHTSA, and many other top industry data sources, including state-level government agencies, insurance providers and auto industry partners. Our affordable vehicle history reports may have accidents, recalls, market value data, in-depth ownership cost projections and more.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                    <section class="section">
                        <div class="row">
                            <div class="col-sm-6 getStarted">
                                <h1>Ready to get started?</h1>
                                <p>Learn about a vehicle, starting at just $1</p>
                                <a href="#" class="btn outline">GET STARTED</a>
                            </div>
                            <div class="col-sm-6">
                                <img src="assets/getstarted.webp" />
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="section-title">
                            <h1 class="card-title text-center">Why use our service</h1>
                            <p class="sub-title text-center"><?php echo $site_name; ?>.com is here to modernize the vehicle ownership experience</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center"><span class="orange">Save thousands</span> of dollars</h4>
                                        <p class="text-center sectionSpace">
                                            Spending just $14.99 on one VINinspect vehicle history report will help you to get to know the history of the vehicle that you want to buy and avoid potentially spending lots of money on future repairs.
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center"><span class="orange">Feel Sale</span> buying a Car</h4>

                                        <p class="text-center sectionSpace">
                                            Safety is everyone's priority behind the wheel. You can protect yourself from undisclosed damages and any other issues that may arise. All you need to do is check the history of the car before the purchase.
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center"><span class="orange">Impossible</span> to falsify</h4>

                                        <p class="text-center sectionSpace">
                                            Information about a vehicle's history can’t be falsified, changed or deleted due to the way the data is stored. We store the information on our partners blockchain which is where the data can be verified
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="row">
                            <div class="col-sm-6 getStarted">
                                <h1>Frequently Asked Questions</h1>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        What is VINinspect Vehicle History Report?
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        At <?php echo $site_name; ?>, we are committed to millions of customers and potential car owners with detailed and accurate information about their vehicle history reports. Using our platform and services, prospective car buyers can get comprehensive, up-to-date information about used vehicles.

                                                        Furthermore, the VINinspect Vehicle History Report will provide the following information: previous owners, odometer readings, damages, recalls, accidents, title information, photos, and more. With this, they can avoid buying a damaged vehicle and be confident about the car they intend to purchase
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Who Do We Provide The Vehicle History Reports for?
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        Our vehicle history reports at VINinspect are available to consumers who will like to know the history of a used car before purchasing the vehicle. When you decide to purchase a used car and will like to know the car’s history or any hidden issue with the vehicle, the VHR will be available to you.

                                                        In addition, individuals who will like to sell their car to a private party can also use the VINinspect’s vehicle history reports to show that the vehicle is in excellent condition and worth the price. When potential buyers see the vehicle history report, they feel more confident about making the purchase.

                                                        Check out our online reviews to see what some of our previous customers have to say about VINinspect Vehicle History Reports.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Do VINinspect Reports Contact Information on Every Vehicle?
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        VINinspect is a Certified and Approved NMVTIS Data Provider. We boast of a massive amount of vehicle data and information available in our database. Also, we have records on a huge collection of over 350 million VIN history records, covering most of the used cars in the United States.

                                                        What’s more, we provide detailed reports about vehicles manufactured after 1981. We can also offer comprehensive information about cars, sedans, and light trucks. With the help of VINinspect Vehicle History Reports, you can reduce the possibility of purchasing a used car that has hidden or unknown issues. Click here to check your VIN.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="card2 fullwidth">
                            <div class="card-body">
                                <div class="section-title">
                                    <h1 class="card-title text-center">Check your car and <span class="orange">save thousands of dollars</span></h1>
                                </div>
                                <div class="input-wrap sectionSpace">
                                    <input type="text" placeholder="ENTER YOUR VIN NUMBER" class="fullwidth" />
                                    <button class="btn outline">GET STARTED </button>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="previous_jobs">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="text-center"><i class="fas fa-check greenColor icon"></i>Free VIN Check</p>
                                    <h4 class="card-title text-center">By VIN Plate</h4>
                                </div>
                                <div class="col-sm-3">
                                    <p class="text-center"><i class="fas fa-check greenColor icon"></i>Daily VIN Searches</p>
                                    <h4 class="card-title text-center">45,000+</h4>
                                </div>
                                <div class="col-sm-3">
                                    <p class="text-center"><i class="fas fa-check greenColor icon"></i>VIN Сhecked On</p>
                                    <h4 class="card-title text-center">6 Databases</h4>
                                </div>
                                <div class="col-sm-3">
                                    <p class="text-center"><i class="fas fa-check greenColor icon"></i>Vehicle History Report</p>
                                    <h4 class="card-title text-center">Extensive History</h4>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="row">
                            <div class="col-sm-5 getStarted">
                                <h1>What Customers Say </h1>
                                <p>Diverse perspectives and genuine testimonials demonstrating the value of our services.</p>
                            </div>
                            <div class="col-sm-7"></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>




    <?php include("footer.php");  ?>