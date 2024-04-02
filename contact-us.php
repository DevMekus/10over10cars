<?php
$title = "Welcome";
include("header.php");

?>

<body class="theme-primary">
    <?php include("navbar.php"); ?>
    <section class="theme-black">

        <div class="container padding-20">
            <div class="row">
                <div class="col-sm-8">
                    <div class="section-title">
                        <h1 class="card-title big-title">Contact Us</h1>
                    </div>
                    <div class="sectionSpace">
                        <h2 class="card-title"><span class="orange">How Can We Help You?</span></h2>
                        <h3 class="card-title sectionSpace">Looking for Customer Support?</h3>
                        <p class="text-justify sectionSpace">
                            Feel free to send us an email using the contact form below or if you would like to speak to someone via phone give our Customer Support team a ring on our toll free number.
                        </p>
                        <div class="row flex space-between">
                            <div class="col-sm-7">
                                <div class="form-wrap">
                                    <label>First & Last Name</label>
                                    <input type="text" class="form-item" placeholder="John Doe" required />
                                </div>
                                <div class="form-wrap">
                                    <label>Email address</label>
                                    <input type="email" class="form-item" placeholder="You@email.com" required />
                                </div>
                                <div class="form-wrap">
                                    <label>Phone (Optional)</label>
                                    <input type="email" class="form-item" placeholder="You@email.com" required />
                                </div>
                                <div class="form-wrap">
                                    <label>Subject</label>
                                    <input type="text" class="form-item" placeholder="You@email.com" required />
                                </div>
                                <div class="form-wrap">
                                    <label>Message</label>
                                    <textarea class="form-item" rows="6" placeholder="Enter Your Message"></textarea>
                                </div>
                                <div class="form-wrap">
                                    <button class="btn pill primary">SEND</button>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="contact-link">
                                    <a href="#" class="p-20">Help Center</a>
                                    <a href="#" class="p-20">Terms of Use</a>
                                    <a href="#" class="p-20">Privacy Policy</a>
                                    <a href="#" class="p-20">About us</a>
                                    <a href="#" class="p-20">FAQs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <!-- <div class="contact-link">
                        <a href="#" class="p-20">Help Center</a>
                        <a href="#" class="p-20">Terms of Use</a>
                        <a href="#" class="p-20">Privacy Policy</a>
                        <a href="#" class="p-20">About us</a>
                        <a href="#" class="p-20">FAQs</a>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <?php include("footer.php");  ?>