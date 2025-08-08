<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/navbar.php';
?>

<body class="dark-theme">
    <!-- Hero Section -->
    <section id="landing-hero">
        <section class="hero" id="hero">
            <canvas class="background-animation"></canvas> <!-- particle canvas -->
            <div class="hero-content fade-in container">
                <h1><span id="typed-headline"></span></h1>
                <p>Get instant history, verify ownership, and check theft status — all in one click.</p>

                <div class="vin-search-box slide-in">
                    <input type="text" placeholder="Enter VIN or license plate..." />
                    <button class="btn btn-primary btn-lg">Verify Vehicle</button>
                </div>

                <div class="benefits fade-in">
                    <span>✅ Instant Report</span>
                    <span>✅ Ownership & Theft Check</span>
                    <span>✅ Secure Payment</span>
                </div>

                <button id="demoModalButton" class="btn btn-outline btn-lg demo-btn">
                    🎥 Watch Demo
                </button>
            </div>

            <div class="hero-illustration slide-in">
                <img src="public/assets/images/hero-1.png" alt="Car illustration" />
            </div>

            <a href="#main-content" class="scroll-down">↓</a>
        </section>
        <!-- Demo Video Modal -->
        <div id="demoModal" class="modal-overlay">
            <div class="modal-content">
                <button class="close-btn" onclick="closeDemoModal()">×</button>
                <!-- <iframe src="https://www.youtube.com/watch?v=3yY6N4cg3hw&ab_channel=TheTollywoodLife" title="Demo Video" allowfullscreen></iframe> -->
            </div>
        </div>
    </section>

    <section id="intro" class="p-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h2>We Provides Best Solution
                        for Vehicles verification</h2>
                    <p>ver 10 quisque sodales dui ut varius vestibulum drana tortor turpis porttiton tellus eu euismod nisl massa nutodio in the miss volume place urna lacinia eros nunta urna mauris vehicula rutrum in the miss on volume interdum.
                    </p>
                    <p> ver 10 quisque sodales dui ut varius vestibulum drana tortor turpis porttiton tellus eu euismod nisl massa nutodio in the miss volume place urna lacinia eros nunta urna mauris vehicula rutrum in the miss on volume interdum. Credibly impactful sources before frictionless.</p>
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid" src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="car-image">
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="p-4">
        <h2 class="typed-heading"><span id="typed-headline-works"></span></h2>
        <section class="how-it-works" id="how-it-works">
            <!-- Desktop grid -->
            <div class="steps-grid desktop-only">
                <div class="step fade-in">
                    <img src="https://img.icons8.com/?size=80&id=4fbhdBUDlq1r&format=png" alt="Enter VIN" />
                    <h3>1. Enter VIN</h3>
                    <p>Input the vehicle VIN or plate number into the search box.</p>
                </div>
                <div class="step fade-in" style="animation-delay: 0.1s;">
                    <img src="https://img.icons8.com/?size=80&id=wdxJWOrDjqia&format=png" alt="Pay Securely" />
                    <h3>2. Pay Securely</h3>
                    <p>Use our safe, encrypted checkout for instant access.</p>
                </div>
                <div class="step fade-in" style="animation-delay: 0.2s;">
                    <img src="https://img.icons8.com/?size=80&id=fdsDNoFBF4qC&format=png" alt="Get Report" />
                    <h3>3. Get Instant Report</h3>
                    <p>Receive a detailed report with history & ownership status.</p>
                </div>
            </div>

            <!-- Mobile carousel -->
            <div class="swiper mobile-only">
                <div class="swiper-wrapper">
                    <div class="swiper-slide step">
                        <img src="https://img.icons8.com/?size=80&id=4fbhdBUDlq1r&format=png" alt="Enter VIN" />
                        <h3>1. Enter VIN</h3>
                        <p>Input the vehicle VIN or plate number into the search box.</p>
                    </div>
                    <div class="swiper-slide step">
                        <img src="https://img.icons8.com/?size=80&id=wdxJWOrDjqia&format=png" alt="Pay Securely" />
                        <h3>2. Pay Securely</h3>
                        <p>Use our safe, encrypted checkout for instant access.</p>
                    </div>
                    <div class="swiper-slide step">
                        <img src="https://img.icons8.com/?size=80&id=fdsDNoFBF4qC&format=png" alt="Get Report" />
                        <h3>3. Get Instant Report</h3>
                        <p>Receive a detailed report with history & ownership status.</p>
                    </div>
                </div>
                <!-- Pagination & Nav -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

            <!-- Call to Action -->
            <a href="#" id="verifyVehicle" class="btn btn-primary btn-lg mt-4">Verify a Vehicle Now</a>
        </section>

    </section>

    <!-- Trust and benefits -->
    <section id="trust-section">
        <section class="trust-benefits" id="trust-benefits">
            <div class="container">
                <!-- Section title -->
                <h2 class="section-title fade-in">Why Trust Us</h2>

                <!-- Icon Benefits -->
                <div class="benefits-grid fade-in">
                    <div class="benefit-card">
                        <img src="https://cdn-icons-png.freepik.com/256/5831/5831933.png?ga=GA1.1.942621764.1718878728&semt=ais_hybrid" alt="Instant Reports" />
                        <h3>Instant Reports</h3>
                        <p>Get detailed history in seconds. No wait, no hassle.</p>
                    </div>
                    <div class="benefit-card">
                        <img src="https://cdn-icons-png.freepik.com/256/11526/11526537.png?ga=GA1.1.942621764.1718878728&semt=ais_hybrid" alt="Secure Payments" />
                        <h3>Secure Payments</h3>
                        <p>Your data and transactions are 100% encrypted & safe.</p>
                    </div>
                    <div class="benefit-card">
                        <img src="https://cdn-icons-png.freepik.com/256/17962/17962977.png?ga=GA1.1.942621764.1718878728&semt=ais_hybrid" alt="Privacy Protection" />
                        <h3>Privacy Protection</h3>
                        <p>We never share your personal info with third parties.</p>
                    </div>
                    <div class="benefit-card">
                        <img src="https://cdn-icons-png.freepik.com/256/4206/4206980.png?ga=GA1.1.942621764.1718878728&semt=ais_hybrid" alt="24/7 Support" />
                        <h3>24/7 Support</h3>
                        <p>Our friendly team is here anytime you need help.</p>
                    </div>
                    <div class="benefit-card">
                        <img src="https://cdn-icons-png.freepik.com/256/70/70727.png?ga=GA1.1.942621764.1718878728&semt=ais_hybrid" alt="Accurate Data" />
                        <h3>Accurate Data</h3>
                        <p>Our reports come from trusted official sources.</p>
                    </div>
                    <div class="benefit-card">
                        <img src="https://cdn-icons-png.freepik.com/256/17787/17787176.png?ga=GA1.1.942621764.1718878728&semt=ais_hybrid" alt="Affordable Pricing" />
                        <h3>Affordable Pricing</h3>
                        <p>Premium quality checks at a pocket-friendly price.</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="stats fade-in">
                    <div class="stat">
                        <span class="number" data-target="10000">0</span>
                        <p>Vehicles Checked</p>
                    </div>
                    <div class="stat">
                        <span class="number" data-target="99.9">0</span><span>%</span>
                        <p>Uptime</p>
                    </div>
                    <div class="stat">
                        <span class="number" data-target="98">0</span><span>%</span>
                        <p>Positive Rating</p>
                    </div>
                </div>

                <!-- Partner logos -->
                <div class="partner-logos fade-in">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9ZmoAF8zFSBAm4y8XDxB9KCR9CeVyyb6A_w&s" />
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkTStVVeOYY0mI6JFxfRtfBEZNXuDmaPInZQ&s" alt="Partner2" />
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0pV46NLveQH7-DZprdjsnYVzkJsTJWj9www&s" alt="SSL Secured" />
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKxw1w9oBgls03wWB0DFo9MwxDuVUJiIRGYw&s" alt="Visa Mastercard" />
                </div>

                <!-- Testimonials carousel -->
                <div class="testimonial-carousel swiper fade-in">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide testimonial">
                            <p>"This service is incredibly fast and accurate. Saved me a lot of hassle!"</p>
                            <span>- Alex J.</span>
                        </div>
                        <div class="swiper-slide testimonial">
                            <p>"Very trustworthy and the payment was super smooth. Highly recommended!"</p>
                            <span>- Maria R.</span>
                        </div>
                        <div class="swiper-slide testimonial">
                            <p>"Finally a place where I can verify my vehicle with zero stress."</p>
                            <span>- Daniel K.</span>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

            </div>
        </section>

    </section>

    <section id="demo-quick">
        <section class="quick-demo-section">
            <div class="container demo-flex">
                <!-- Intro / Benefits -->
                <div class="demo-info">
                    <h2>See It in Action</h2>
                    <ul>
                        <li>💡 Instant results & easy to use</li>
                        <li>🔐 Secure & encrypted process</li>
                        <li>📄 Comprehensive report in seconds</li>
                    </ul>
                    <button class="btn btn-primary btn-lg">Get Started</button>
                </div>

                <!-- Gallery -->
                <div class="demo-gallery-grid">
                    <a href="public/assets/images/car5.jpg" data-lightbox="demo-gallery" data-title="1. Enter your VIN">
                        <img src="public/assets/images/car5.jpg" alt="Enter your VIN" class="zoomable" />
                        <p class="caption">1. Enter your VIN</p>
                    </a>
                    <a href="public/assets/images/car4.jpg" data-lightbox="demo-gallery" data-title="2. Checkout securely">
                        <img src="public/assets/images/car4.jpg" alt="Checkout securely" class="zoomable" />
                        <p class="caption">2. Checkout securely</p>
                    </a>
                    <a href="public/assets/images/car3.jpg" data-lightbox="demo-gallery" data-title="3. Get full report">
                        <img src="public/assets/images/car3.jpg" alt="Get full report" class="zoomable" />
                        <p class="caption">3. Get full report</p>
                    </a>
                </div>
            </div>
        </section>
    </section>
    <section id="social-proof">
        <section class="social-proof" id="social-proof">
            <div class="container">
                <h2>Social Proof</h2>
                <p>Join <strong>10,000+</strong> satisfied customers who trust our reports.</p>

                <!-- Testimonials Carousel -->
                <div class="testimonials-carousel swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide testimonial">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS39PZmMFkK6rrYtI-9lvgfcggaiCPTAnORjA&s" alt="User 1" class="avatar" />
                            <p class="review">“Quick and accurate. Saved me a ton of time!”</p>
                            <span class="name">— Jane D.</span>
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                        </div>
                        <div class="swiper-slide testimonial">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuNhTZJTtkR6b-ADMhmzPvVwaLuLdz273wvQ&s" alt="User 2" class="avatar" />
                            <p class="review">“Smooth payment and instant report. Love it.”</p>
                            <span class="name">— Mike S.</span>
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                        </div>
                        <!-- add more testimonials -->
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

                <!-- Partner Logos -->
                <div class="partner-logos">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9ZmoAF8zFSBAm4y8XDxB9KCR9CeVyyb6A_w&s" />
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkTStVVeOYY0mI6JFxfRtfBEZNXuDmaPInZQ&s" alt="Partner2" />
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0pV46NLveQH7-DZprdjsnYVzkJsTJWj9www&s" alt="SSL Secured" />
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKxw1w9oBgls03wWB0DFo9MwxDuVUJiIRGYw&s" alt="Visa Mastercard" />
                </div>

                <!-- Count-up Statistics -->
                <div class="stats">
                    <div class="stat">
                        <span class="number" data-target="10000">0</span>
                        <p>Reports Generated</p>
                    </div>
                    <div class="stat">
                        <span class="number" data-target="99.8">0</span><span>%</span>
                        <p>Customer Satisfaction</p>
                    </div>
                    <div class="stat">
                        <span class="number" data-target="24">0</span>
                        <p>Countries Served</p>
                    </div>
                </div>

            </div>
        </section>

    </section>
    <?php require_once ROOT_PATH . '/includes/footer-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/LandingPage.js"></script>
</body>

</html