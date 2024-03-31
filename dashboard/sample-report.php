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
                            <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sample-report</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row sectionSpace">
                            <div class="col-sm-9">
                                <div class="sectionSpace">
                                    <div class="flex fullwidth flex-end">
                                        <button class="btn btn-danger">Download Report <i class="fas fa-download"></i></button>
                                    </div>
                                    <div class="flex gap_10 sectionSpace">
                                        <h3 class="card-title">SAMPLE VEHICLE HISTORY REPORT</h3>
                                        <div class="flex gap_10">
                                            <span class="fas fa-certificate greenColor icon-big"></span>
                                            <p>APPROVED <span class="orange bold">NMVTIS
                                                    DATA</span> PROVIDER</p>
                                        </div>
                                    </div>
                                    <h1 class="card-title"><span class="orange">2018 BMW X5</span> - VIN 5UXKR0C58JL074657</h1>

                                    <div class="row sectionSpace">
                                        <div class="col-sm-4">
                                            <div class="card-body">
                                                <img src="https://img.vinchain.io/2019/05/31/60/59d841ca82c5e1fc_8409454596b09c.jpg" class="img-fluid" alt="car" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="report-summary">
                                                <div class="summary-wrap">
                                                    <div class="summary">
                                                        <span class="material-symbols-outlined">
                                                            speed
                                                        </span>
                                                        <div class="info">
                                                            <h5>Odometer</h5>
                                                            <p>No problem found</p>
                                                        </div>
                                                    </div>
                                                    <span class="material-symbols-outlined">
                                                        task_alt
                                                    </span>
                                                </div>
                                                <div class="summary-wrap">
                                                    <div class="summary">
                                                        <span class="material-symbols-outlined">
                                                            car_crash
                                                        </span>
                                                        <div class="info">
                                                            <h5>Accidents</h5>
                                                            <p>3 problem found</p>
                                                        </div>
                                                    </div>
                                                    <span class="material-symbols-outlined redColor">
                                                        warning
                                                    </span>
                                                </div>
                                                <div class="summary-wrap">
                                                    <div class="summary">
                                                        <span class="material-symbols-outlined">
                                                            problem
                                                        </span>
                                                        <div class="info">
                                                            <h5>Sales History</h5>
                                                            <p>7 records found</p>
                                                        </div>
                                                    </div>
                                                    <span class="material-symbols-outlined">
                                                        task_alt
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="report-summary">
                                                <div class="summary-wrap">
                                                    <div class="summary">
                                                        <span class="material-symbols-outlined">
                                                            safety_check
                                                        </span>
                                                        <div class="info">
                                                            <h5>Open Safety Recalls</h5>
                                                            <p>No problem found</p>
                                                        </div>
                                                    </div>
                                                    <span class="material-symbols-outlined">
                                                        task_alt
                                                    </span>
                                                </div>
                                                <div class="summary-wrap">
                                                    <div class="summary">
                                                        <span class="material-symbols-outlined">
                                                            distance
                                                        </span>
                                                        <div class="info">
                                                            <h5>Mileage</h5>
                                                            <p>9,920 Last odometer reading</p>
                                                        </div>
                                                    </div>
                                                    <span class="material-symbols-outlined redColor">
                                                        warning
                                                    </span>
                                                </div>
                                                <div class="summary-wrap">
                                                    <div class="summary">
                                                        <span class="material-symbols-outlined">
                                                            group
                                                        </span>
                                                        <div class="info">
                                                            <h5>Owners</h5>
                                                            <p>7 records found</p>
                                                        </div>
                                                    </div>
                                                    <span class="material-symbols-outlined">
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
                                                            <h5>Made in
                                                            </h5>
                                                            <p>USA</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section>
                                    <div class="section-title flex gap_10 space-between fullwidth">
                                        <h2 class="card-title">Ownership history </h2>
                                        <p class="p-20"><span class="badge bg-success bg-sm">7</span> records found</p>
                                    </div>
                                    <div class="flex fullwidth flex-wrap">
                                        <div class="col-sm-4">
                                            <div class="card-plain">
                                                <div class="card-body">
                                                    <div class="flex gap_10">
                                                        <span class="material-symbols-outlined">
                                                            person
                                                        </span>
                                                        <h4 class="card-title">1st owner</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="sectionSpace">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="section-title flex gap_10  fullwidth">
                                                <h2 class="card-title">Odometer check
                                                </h2>
                                                <p class="p-20">No report found</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="section-title flex gap_10  fullwidth">
                                        <h2 class="card-title">Open safety recall check </h2>
                                        <p class="p-20"><span class="badge bg-danger bg-sm">4</span> problems found</p>
                                    </div>
                                </section>
                                <section>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="section-title flex gap_10  fullwidth">
                                                <h3 class="card-title">Junk / Insurance records
                                                </h3>
                                                <p class="p-20"><span class="badge bg-success bg-sm">2</span> records found</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <div class="section-title flex gap_10  fullwidth">
                                        <h2 class="card-title">Title History Information </h2>
                                        <p class="p-20"><span class="badge bg-success bg-sm">3</span> records found</p>
                                    </div>
                                </section>
                                <section>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="section-title flex gap_10 space-between  fullwidth">
                                                <h3 class="card-title">Stolen vehicle check
                                                </h3>
                                                <p class="p-20">No records found</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="section-title flex gap_10  fullwidth">
                                        <h2 class="card-title">Title brand check </h2>
                                        <p class="p-20">No problem reported</p>
                                    </div>
                                </section>
                                <section>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="section-title flex gap_10 space-between  fullwidth">
                                                <h3 class="card-title">Sales history
                                                </h3>
                                                <p class="p-20"><span class="badge bg-success">3</span> records found</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="section-title flex gap_10  fullwidth">
                                        <h2 class="card-title">Market price analysis</h2>
                                    </div>
                                    <p>
                                        Market price analysis is based on a vehicle's history such as vehicle class and age, number of owners, accident and damage history, title brands, odometer readings, etc. This information is used to compare the vehicle's favorability against the entire market of vehicles with
                                    </p>
                                </section>
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
                                <div class="cards sectionSpace">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <a href="#outline" class="">
                                                <li class="list-group-item">Outline</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Ownership History</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Odometer Check</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Open Safety Recall Check</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Junk / Insurance Record</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Title History Information</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Stolen Vehicle Check</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Title Brand Check</li>
                                            </a>
                                            <a href="#">
                                                <li class="list-group-item">Sales History</li>
                                            </a>
                                            <a href="#">
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
        </section>
    </section>
</main>

<?php include("footer.php");  ?>