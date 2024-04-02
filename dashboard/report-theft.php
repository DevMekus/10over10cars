<?php
$title = "Theft Reporting";
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
                                    <li class="breadcrumb-item active" aria-current="page">Theft report</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="sectionSpace">
                            <!-- <h2 class="card-title">Latest Reports</h2> -->
                            <div class="card sectionSpace">
                                <div class="card-body">
                                    <h5>Welcome to the Stolen Vehicle Report Portal</h5>
                                    <p>
                                        One of the functions of <?php echo $site_name;  ?> is to protect the properties of citizens. This service is created for members of the public to report their stolen and yet to be recovered vehicles.
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="sectionSpace account-setting">
                            <form>
                                <h5 class="card-title greenColor">Personal Information</h5>
                                <p>
                                    Provide us with some information about you.<br>
                                    This information will help us verify the authenticity of your claims and documents.
                                </p>
                                <div class="col-sm-4 sectionSpace">
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
                                </div>
                                <div class="sectionSpace">
                                    <h5 class="card-title greenColor">Car Information</h5>
                                    <p>
                                        Provide us with some information about you.<br>
                                        This information will help us verify the authenticity of your claims and documents.
                                    </p>
                                    <div class="col-sm-4 sectionSpace">
                                        <div class="col-sm-12">
                                            <div class="form-wrap">
                                                <label class="bold redColor">Provide Chassis number</label>
                                                <input type="text" class="form-item" placeholder="647GJDFH8738" required />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-wrap">
                                                    <label> Type</label>
                                                    <input type="text" class="form-item" placeholder="Sedan" required />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-wrap">
                                                    <label>Model</label>
                                                    <input type="text" class="form-item" placeholder="" required />
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <h5 class="card-title greenColor sectionSpace">Theft Information</h5>
                                    <p>
                                        Provide us with some information about you.<br>
                                        This information will help us verify the authenticity of your claims and documents.
                                    </p>
                                    <div class="sectionSpace col-sm-4">
                                        <div class="form-wrap">
                                            <label>Location</label>
                                            <input type="email" class="form-item" placeholder="23 Badagary Street, Abuja FCT" required />
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
                                </div>
                                <div class="sectionSpace card">
                                    <div class="card-body">
                                        <p>
                                            By submitting this form, You agree to the <a href="#">Terms & Conditions</a> guiding this exercise, and certify that the information provided is true and authentic
                                        </p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label bold" for="flexCheckDefault">
                                                I agree with <a href="#">Terms & Conditions</a>
                                            </label>
                                        </div>
                                        <button type="submit" class="btn primary sectionSpace">Report Theft</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include("footer.php");  ?>
    </section>
</main>