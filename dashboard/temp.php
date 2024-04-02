<?php
$title = "Settings";
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
                                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="sectionSpace">
                            <h2 class="card-title">Car Theft Report</h2>
                            <div class="card-plaina sectionSpace">
                                <div class="card-body">
                                    <p>
                                        One of the functions of <?php echo $site_name;  ?> is to protect the properties of citizens. This service is created for members of the public to report their stolen and yet to be recovered vehicles.
                                    </p>
                                    <div class="container">
                                        <div class="row account-setting">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-5">
                                                <form>
                                                    <p class="bold greenColor">Enter your personal Information</p>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-wrap">
                                                                <label>First Name</label>
                                                                <input type="text" class="form-item" placeholder="John" required />
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-wrap">
                                                                <label>Last Name</label>
                                                                <input type="text" class="form-item" placeholder="Doe" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-wrap">
                                                                <label>Email address</label>
                                                                <input type="email" class="form-item" placeholder="You@email.com" required />
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-wrap">
                                                                <label>Phone</label>
                                                                <input type="text" class="form-item" placeholder="+234-37**" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="sectionSpace">
                                                        <p class="bold greenColor">Subject car information</p>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-wrap">
                                                                    <label> Chassis number</label>
                                                                    <input type="text" class="form-item" placeholder="647GJDFH8738" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-wrap">
                                                                    <label>Model</label>
                                                                    <input type="text" class="form-item" placeholder="" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-wrap">
                                                                <label> Type</label>
                                                                <input type="text" class="form-item" placeholder="Sedan" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="sectionSpace">
                                                        <p class="bold greenColor">Theft details</p>
                                                        <div class="form-wrap">
                                                            <label>Location</label>
                                                            <input type="email" class="form-item" placeholder="You@email.com" required />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-wrap">
                                                                    <label>Day</label>
                                                                    <input type="email" class="form-item" placeholder="Monday" required />
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-wrap">
                                                                    <label>Month</label>
                                                                    <input type="text" class="form-item" placeholder="January" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-wrap">
                                                                    <label>Year</label>
                                                                    <input type="text" class="form-item" placeholder="2024" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-wrap">
                                                        <button class="btn pill primary">Save Settings</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-sm-4">
                                                <!-- <div class="card-bodys">
                                                    <h2 class="card-title text-centers">Will you like to get a <span class="orange">FREE</span>
                                                        Vehicle History Report?</h2>
                                                    <p class="text-centers">Refer and get a free Vehicle History Report. It’s that easy. Every time a user purchases their first report using your referral link, you get a free vehicle history report. This is our way of saying thank you for telling people about our services.


                                                    </p>
                                                    <div class="sectionSpace flex space-between gap_10">
                                                        <input type="text" placeholder="Enter VIN Number" class="outline-input fullwidth" value="www.facebook.com/GDJ73632" />
                                                        <button class="btn primary pill">Copy</button>
                                                    </div>
                                                    <div class="sectionSpace">
                                                        <h5 class="card-title text-centers"> SHARE WITH SOCIAL</h5>
                                                        <div class="sectionSpace fullwidth flex gap_10 align-center">
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
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include("footer.php");  ?>
    </section>
</main>