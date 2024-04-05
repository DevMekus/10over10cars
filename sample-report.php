<?php
$title = "Sample report";
include("header.php");
include("navbar.php");
?>

<body>
    <main>
        <section class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">sample-report</li>
                                </ol>
                            </nav>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="flex fullwidth flex-end">
                                        <button class="btn btn-danger">Download Report <i class="fas fa-download"></i></button>
                                    </div>
                                    <div class="flex gap_10 sectionSpace">
                                        <h3 class="card-title">SAMPLE VEHICLE HISTORY REPORT</h3>
                                        <div class="flex gap_10">
                                            <span class="fas fa-check-circle greenColor icon-big"></span>
                                            <p>APPROVED <span class="greenColor bold">AUTOInspect
                                                </span>DATA PROVIDER</p>
                                        </div>
                                    </div>
                                    <div class="card" id="outline">
                                        <div class="card-body">
                                            <section class="sectionSpace">

                                                <div class="section-title">
                                                    <h1 class="card-title"><span class="orange">2018 BMW X5</span> - VIN 5UXKR0C58JL074657</h1>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="card-body">
                                                            <img src="https://img.vinchain.io/2019/05/31/60/59d841ca82c5e1fc_8409454596b09c.jpg" class="img-fluid" alt="car" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap sectionHover">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        speed
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Odometer</h5>
                                                                        <p>No problem found</p>
                                                                    </div>
                                                                </div>
                                                                <span class="material-symbols-outlined greenColor">
                                                                    task_alt
                                                                </span>
                                                            </div>
                                                            <div class="summary-wrap sectionHover">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        car_crash
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Accidents</h5>
                                                                        <p>3 problem found</p>
                                                                    </div>
                                                                </div>
                                                                <span class="material-symbols-outlined redColor redColor">
                                                                    warning
                                                                </span>
                                                            </div>
                                                            <div class="summary-wrap sectionHover">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        problem
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Sales History</h5>
                                                                        <p>7 records found</p>
                                                                    </div>
                                                                </div>
                                                                <span class="material-symbols-outlined greenColor">
                                                                    task_alt
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap sectionHover">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        safety_check
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Open Safety Recalls</h5>
                                                                        <p>No problem found</p>
                                                                    </div>
                                                                </div>
                                                                <span class="material-symbols-outlined greenColor">
                                                                    task_alt
                                                                </span>
                                                            </div>
                                                            <div class="summary-wrap sectionHover">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        distance
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Mileage</h5>
                                                                        <p>9,920 Last reading</p>
                                                                    </div>
                                                                </div>
                                                                <span class="material-symbols-outlined redColor">
                                                                    warning
                                                                </span>
                                                            </div>
                                                            <div class="summary-wrap sectionHover">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        group
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Owners</h5>
                                                                        <p>7 records found</p>
                                                                    </div>
                                                                </div>
                                                                <span class="material-symbols-outlined greenColor">
                                                                    task_alt
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row sectionSpace border-top-primary border-bottom-primary padding-default">
                                                    <div class="col-sm-2">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        calendar_month
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>2002</h5>
                                                                        <p>Year</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        brand_family
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>BMW</h5>
                                                                        <p>Make</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        model_training
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>X5</h5>
                                                                        <p>Model</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        content_cut
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>xDrive35i</h5>
                                                                        <p>Trim</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        developer_mode
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>3L</h5>
                                                                        <p>Engine</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="report-summary">
                                                            <div class="summary-wrap">
                                                                <div class="summary">
                                                                    <span class="material-symbols-outlined">
                                                                        engineering
                                                                    </span>
                                                                    <div class="info">
                                                                        <h5>Made</h5>

                                                                        <p>USA</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="ownership">
                                        <div class="card-body">
                                            <section class="bg-white">
                                                <div class="flex gap_10 space-between fullwidth">
                                                    <h2 class="card-title">Ownership history </h2>
                                                    <p class="p-20"><span class="badge bg-success bg-sm">7</span> records found</p>
                                                </div>
                                                <div class="padding-default sectionSpace">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="owner-wrap">
                                                                <div class="flex gap_10 fullwidth align-center">
                                                                    <div class="icon-wrap border-bottom-primary">
                                                                        <span class="material-symbols-outlined">
                                                                            person
                                                                        </span>
                                                                    </div>
                                                                    <h4 class="card-title">1st owner</h4>
                                                                </div>
                                                                <div class="flex fullwidth space-between align-center">
                                                                    <div class="data">
                                                                        <p>Miles driven per year:</p>
                                                                    </div>
                                                                    <div class="value">
                                                                        <p class="bold redColor">4,469 mi</p>
                                                                    </div>
                                                                </div>
                                                                <div class="flex fullwidth space-between align-center">
                                                                    <div class="data">
                                                                        <p>Odometer reading:</p>
                                                                    </div>
                                                                    <div class="value">
                                                                        <p class="bold greenColor">2,622 mi</p>
                                                                    </div>
                                                                </div>
                                                                <div class="flex fullwidth space-between align-center">
                                                                    <div class="data">
                                                                        <p>Purchased in:
                                                                        </p>
                                                                    </div>
                                                                    <div class="value">
                                                                        <p class="bold">2008</p>
                                                                    </div>
                                                                </div>
                                                                <div class="flex fullwidth space-between align-center">
                                                                    <div class="data">
                                                                        <p>Estimate length of use:
                                                                        </p>
                                                                    </div>
                                                                    <div class="value">
                                                                        <p class="bold">0yrs. 7mo.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="odometer">
                                        <div class="card-body">
                                            <section>
                                                <div class="flex gap_10 space-between  fullwidth">
                                                    <h2 class="card-title">Odometer check
                                                    </h2>
                                                    <p class="p-20 redColor">No report found</p>
                                                </div>
                                                <div class="odometer-check sectionSpace">
                                                    <div class="flex fullwidth space-between align-center">
                                                        <div class="data">
                                                            <p><span class="bold">Odometer:</span> Not Actual</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor icon"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex fullwidth space-between align-center">
                                                        <div class="data">
                                                            <p><span class="bold">Odometer:</span> Tampering Verified</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor icon"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex fullwidth space-between align-center">
                                                        <div class="data">
                                                            <p><span class="bold">Odometer:</span> Replaced</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor icon"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex fullwidth space-between align-center">
                                                        <div class="data">
                                                            <p><span class="bold">Odometer:</span> Reading at Time of Renewal</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor icon"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="safeRecall">
                                        <div class="card-body">
                                            <section>
                                                <div class="flex gap_10 space-between fullwidth">
                                                    <h2 class="card-title">Open safety recall check </h2>
                                                    <p class="p-20"><span class="badge bg-danger bg-sm">4</span> problems found</p>
                                                </div>
                                                <div class="sectionSpace">
                                                    <div class="check sectionSpace border-bottom-primary">
                                                        <p>
                                                            <span class="bold redColor"> Jul 30, 2021</span><br>
                                                            21V586000
                                                        </p>
                                                        <h5 class="greenColor">FUEL SYSTEM, DIESEL:DELIVERY:FUEL PUMP</h5>
                                                        <p class="sectionSpace">
                                                            BMW of North America, LLC (BMW) is recalling certain 2014-2018 328d, 328d xDrive, X5 xDrive35d, 2014-2016 535d, 535d xDrive, 2015 740Ld xDrive, and 2015-2017 X3 xDrive28d vehicles. The high-pressure fuel pump may fail.
                                                        </p>
                                                    </div>
                                                    <div class="check sectionSpace border-bottom-primary">
                                                        <p>
                                                            <span class="bold redColor"> Jul 30, 2021</span><br>
                                                            21V586000

                                                        </p>
                                                        <h5 class="greenColor">EQUIPMENT:ELECTRICAL</h5>
                                                        <p class="sectionSpace">
                                                            BMW of North America, LLC (BMW) is recalling certain 2018 BMW 330e iPerformance, i3 Rex, i3 Sport Rex, X5 xDrive40e, i3 BEV, i3 Sport BEV and 2019 i8 and i8 Roadster vehicles and 2018-2019 530e iPerformance, 530e xDrive iPerformance and 740Le xDrive iPerformance vehicles. Capacitors within the TurboCord Portable Chargers may fail, possibly resulting in a shock hazard or a fire.
                                                        </p>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="title">
                                        <div class="card-body">
                                            <section>
                                                <div class="flex gap_10 space-between  fullwidth">
                                                    <h2 class="card-title">Title History Information </h2>
                                                    <p class="p-20"><span class="badge bg-success bg-sm">3</span> records found</p>
                                                </div>
                                                <div class="sectionSpace">
                                                    <h5 class="greenColor">Current Title Information</h5>
                                                    <table class="table sectionSpace">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Title Issue Date</th>
                                                                <th scope="col">State</th>
                                                                <th scope="col">Mileage</th>
                                                                <th scope="col">Event</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Jun 11, 2019</th>
                                                                <td>Abuja</td>
                                                                <td>6,251 mi</td>
                                                                <td>Title and Registration</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="sectionSpace">
                                                    <h5 class="greenColor">Historical Title Information</h5>
                                                    <table class="table sectionSpace">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Title Issue Date</th>
                                                                <th scope="col">State</th>
                                                                <th scope="col">Mileage</th>
                                                                <th scope="col">Event</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Jun 11, 2019</th>
                                                                <td>Abuja</td>
                                                                <td>6,251 mi</td>
                                                                <td>Title and Registration</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <p>If you will to obtain additional title information from the state of title - please click <a href="#" class="bold">HERE</a></p>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="cartheft">
                                        <div class="card-body">
                                            <div class="flex gap_10 space-between  fullwidth">
                                                <h2 class="card-title">Stolen vehicle check
                                                </h2>
                                                <p class="p-20">No records found</p>
                                            </div>
                                            <div class="card-plain">
                                                <div class="card-body">
                                                    <p class="p-20"><i class="fas fa-check-circle greenColor margin-right-10"></i> No records found</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="brandcheck">
                                        <div class="card-body">
                                            <section>
                                                <div class="flex gap_10 space-between  fullwidth">
                                                    <h2 class="card-title">Title brand check </h2>
                                                    <p class="p-20">No problem reported</p>
                                                </div>
                                                <div class="sectionSpace">
                                                    <div class="flex fullwidth align-center space-between">
                                                        <div class="data">
                                                            <p class="bold">Salt water damage</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex fullwidth align-center space-between">
                                                        <div class="data">
                                                            <p class="bold">Vandalism</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex fullwidth align-center space-between">
                                                        <div class="data">
                                                            <p class="bold">Kit</p>
                                                        </div>
                                                        <div class="value">
                                                            <p><i class="fas fa-check-circle greenColor"></i> No problems found</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="sales">
                                        <div class="card-body">
                                            <section>
                                                <div class="flex gap_10 space-between  fullwidth">
                                                    <h3 class="card-title">Sales history
                                                    </h3>
                                                    <p class="p-20"><span class="badge bg-success">1</span> records found</p>
                                                </div>
                                                <div class="sectionSpace">
                                                    <h5>Jun 20, 2018 - <span class="orange">Classified</span></h5>
                                                    <p>Here is the information that was provided when the vehicle was put on sale in 2018</p>

                                                    <div class="row sectionSpace">
                                                        <div class="col-sm-2">
                                                            <div class="report-summary">
                                                                <div class="summary-wrap">
                                                                    <div class="summary">
                                                                        <span class="material-symbols-outlined">
                                                                            monetization_on
                                                                        </span>
                                                                        <div class="info">
                                                                            <h5>$61,795</h5>
                                                                            <p>Cost</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="report-summary">
                                                                <div class="summary-wrap">
                                                                    <div class="summary">
                                                                        <span class="material-symbols-outlined">
                                                                            explore
                                                                        </span>
                                                                        <div class="info">
                                                                            <h5>Abuja</h5>
                                                                            <p>Location</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="report-summary">
                                                                <div class="summary-wrap">
                                                                    <div class="summary">
                                                                        <span class="material-symbols-outlined">
                                                                            explore
                                                                        </span>
                                                                        <div class="info">
                                                                            <h5>2,607</h5>
                                                                            <p>Odometer</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="card sectionSpace" id="analysis">
                                        <div class="card-body">
                                            <section>
                                                <div class="flex gap_10  fullwidth">
                                                    <h2 class="card-title">Market price analysis</h2>
                                                </div>
                                                <p>
                                                    Market price analysis is based on a vehicle's history such as vehicle class and age, number of owners, accident and damage history, title brands, odometer readings, etc. This information is used to compare the vehicle's favorability against the entire market of vehicles with
                                                </p>
                                            </section>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-wrap">
                                                <input type="text" placeholder="ENTER VIN NUMBER" />
                                            </div>
                                            <div class="form-wrap">
                                                <button class="btn outline">Check vin</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="cards sectionSpace scrollSpy">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <a href="#outline" class="">
                                                    <li class="list-group-item">Outline</li>
                                                </a>
                                                <a href="#ownership">
                                                    <li class="list-group-item">Ownership History</li>
                                                </a>
                                                <a href="#odometer">
                                                    <li class="list-group-item">Odometer Check</li>
                                                </a>
                                                <a href="#safeRecall">
                                                    <li class="list-group-item">Open Safety Recall Check</li>
                                                </a>
                                                <a href="#title">
                                                    <li class="list-group-item">Title History Information</li>
                                                </a>
                                                <a href="#cartheft">
                                                    <li class="list-group-item">Stolen Vehicle Check</li>
                                                </a>
                                                <a href="#brandcheck">
                                                    <li class="list-group-item">Title Brand Check</li>
                                                </a>
                                                <a href="#sales">
                                                    <li class="list-group-item">Sales History</li>
                                                </a>
                                                <a href="#analysis">
                                                    <li class="list-group-item">Market Price Analysis</li>
                                                </a>
                                                <a href="#">
                                                    <li class="list-group-item" aria-disabled="true" disabled>Tech Service History <span class="orange">Coming soon</span></li>
                                                </a>


                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include("footer.php");  ?>