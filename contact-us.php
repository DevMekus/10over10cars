<?php
$title = "Welcome";
include("header.php");
include("navbar.php");
?>

<body>
    <main class="theme-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="sectionSpace card">
                        <div class="card-body">
                            <div class="section-titles">
                                <h1 class="card-title big-title">Contact Us</h1>
                            </div>
                            <h2 class="card-title"><span class="orange">How Can We Help You?</span></h2>
                            <h3 class="card-title sectionSpace">Looking for Customer Support?</h3>
                            <p class="text-justify sectionSpace p-20">
                                Feel free to send us an email using the contact form below or if you would like to speak to someone via phone give our Customer Support team a ring on our toll free number.
                            </p>
                        </div>
                    </div>
                    <div class="sectionSpace card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-wrap">
                                        <input type="text" class="form-item" placeholder="Enter your Name" required />
                                    </div>
                                    <div class="form-wrap">
                                        <input type="email" class="form-item" placeholder="Email Address" required />
                                    </div>
                                    <div class="form-wrap">
                                        <input type="tel" class="form-item" placeholder="Phone (Optional)" required />
                                    </div>
                                    <div class="form-wrap">
                                        <input type="text" class="form-item" placeholder="Subject" required />
                                    </div>
                                    <div class="form-wrap">
                                        <textarea class="form-item" rows="6" placeholder="Enter Your Message"></textarea>
                                    </div>
                                    <div class="form-wrap">
                                        <button class="btn pill primary">SEND</button>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="card-bodys">
                                        <h2 class="card-title text-centers">Will you like to get a <span class="orange">FREE</span>
                                            Vehicle <span class="orange">History Report?</span></h2>
                                        <p class="text-centers sectionSpace">Refer and get a free Vehicle History Report. It’s that easy. Every time a user purchases their first report using your referral link, you get a free vehicle history report. This is our way of saying thank you for telling people about our services.
                                        </p>
                                        <div class="sectionSpace form-wrap flex space-between gap_10">
                                            <input type="text" placeholder="Enter VIN Number" class="outline-input fullwidth" value="www.facebook.com/GDJ73632" />
                                            <button class="btn primary pill">Copy</button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="contact-link fullwidth">
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
                </div>
            </div>

        </div>

    </main>
    <?php include("footer.php");  ?>