<footer class="dash-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 id-footer">
                <div class="fullwidth">
                    <a class="navbar-brand" href="../index.php">
                        <img src="../assets/logo/logo-black-edit.jpg" class="img-fluid logo-img" alt="logo" /></a>
                    <div class="sectionSpace">
                        <p class="text-center">7 am - 6 pm EST Monday - Friday
                            2035 NE 151st St. North Miami Beach, FL 33162 USA
                        </p>
                    </div>
                </div>
                <div class="sectionSpace socials">
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
                <div class="sectionSpace newsletter">
                    <h5 class="card-title text-center">Subscribe to Our Newsletter</h5>
                    <input class="border-bottom-grey" placeholder="Enter your email" />
                    <button class="btn pill primary">Subscribe</button>
                </div>
            </div>
            <div class="col-sm-3 footer-item">
                <h5 class="card-title footer-title">Links</h5>
                <a href="#" class="link">About us</a>
                <a href="#" class="link">Product & Services</a>
                <a href="#" class="link">Contact us</a>
                <a href="#" class="link">FAQs</a>
            </div>
            <div class="col-sm-3 footer-item">
                <h5 class="card-title footer-title">Resources</h5>
                <a href="#" class="link">Sample Report</a>
                <a href="#" class="link">Pre-purchase Inspection</a>
                <a href="#" class="link">Buy a Car</a>
            </div>
            <div class="col-sm-3 footer-item">
                <h5 class="card-title footer-title">Partnership</h5>
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo $site; ?>assets/sponsors/hiil-justice-accelerator.png" class="img-fluid" />
                    </div>
                    <div class="col-sm-6">
                        <img src="<?php echo $site; ?>assets/sponsors/microsoft-for-startups.png" class="img-fluid" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo $site; ?>assets/sponsors/ministry-of-communication-technology.png" class="img-fluid" />
                    </div>
                    <div class="col-sm-6">
                        <img src="<?php echo $site; ?>assets/sponsors/tef.png" class="img-fluid" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <h5 class="text-center date-footer">
        <?php echo date('Y', time());
        ?> <?php echo $site_name; ?>
    </h5>
</footer>