<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/navbar.php';
?>

<body id="LANDINGPAGE">
    <!-- Hero -->
    <header id="home" class="hero" aria-labelledby="hero-title">
        <div class="container grid grid-2 hero-grid">
            <div data-aos="fade-right">
                <div class="hero-title-con">
                    <h1 id="hero-title"><span id="typed-headline"></h1>
                </div>
                <p class="lead">Check theft status, mileage anomalies, previous ownership, market value & more. Make confident decisions before you buy.</p>

                <form id="vinForm" class="vin-form" autocomplete="off" novalidate>
                    <label for="vin" class="sr-only">Enter VIN</label>
                    <input id="vin" class="vin-input" name="vin" maxlength="17" placeholder="Enter 17-character VIN (e.g., 2HGFB2F50DH512345)" inputmode="latin" aria-describedby="vinHint" />
                    <button class="btn btn-primary btn-pill" type="submit"><i class="bi bi-shield-check"></i> Verify Now</button>
                    <a class="btn btn-outline-accent btn-pill" href="#market"><i class="bi bi-search"></i> Browse Cars</a>
                    <div id="vinHint" class="vin-hint">VIN must be 17 characters, letters & numbers only. (I, O, Q not allowed)</div>
                </form>
                <div id="vinMsg" role="alert" aria-live="polite" style="margin-top:10px; color: var(--muted);"></div>

                <div class="hero-trust">
                    <span class="mini-badge"><i class="bi bi-lock"></i> Secure</span>
                    <span class="mini-badge"><i class="bi bi-check2-circle"></i> Reliable Data</span>
                    <span class="mini-badge"><i class="bi bi-lightning-charge"></i> Instant Results</span>
                    <span class="mini-badge"><i class="bi bi-globe2"></i> NG & Africa</span>
                </div>
            </div>
            <div data-aos="fade-left">
                <div class="hero-visual">
                    <div class="car"></div>
                    <div class="badge" style="position:absolute; bottom:14px; right:14px;"><i class="bi bi-shield-lock"></i> Paystack / Flutterwave Ready</div>
                </div>
            </div>
        </div>
    </header>
    <!-- How It Works -->
    <section class="section how-it-works" aria-labelledby="how-title" data-aos="fade-up">
        <div class="container">
            <h2 id="how-title" class="section-title">How it works</h2>
            <p class="section-sub">Enter VIN → We check multiple sources → Get instant report → Make informed decisions.</p>
            <div class="grid grid-4">
                <div class="feat-card card" data-aos="fade-up">
                    <div class="icon"><i class="bi bi-123"></i></div>
                    <div>
                        <h3>Enter VIN</h3>
                        <p class="section-sub">Type a 17‑char VIN or scan from your document.</p>
                    </div>
                </div>
                <div class="feat-card card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon"><i class="bi bi-database-check"></i></div>
                    <div>
                        <h3>We Check Sources</h3>
                        <p class="section-sub">We aggregate government, insurer & auction data.</p>
                    </div>
                </div>
                <div class="feat-card card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon"><i class="bi bi-graph-up"></i></div>
                    <div>
                        <h3>Instant Report</h3>
                        <p class="section-sub">Summary, alerts, odometer & ownership timeline.</p>
                    </div>
                </div>
                <div class="feat-card card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon"><i class="bi bi-cart-check"></i></div>
                    <div>
                        <h3>Decide & Buy</h3>
                        <p class="section-sub">Use insights to negotiate or buy with confidence.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Verification Features -->
    <section class="section" aria-labelledby="features-title" data-aos="zoom-in">
        <div class="container">
            <h2 id="features-title" class="section-title">Verification features</h2>
            <p class="section-sub">All the checks you need before buying or importing a car.</p>
            <div class="grid grid-3">
                <article class="feat-card card" data-aos="fade-up">
                    <div class="icon"><i class="bi bi-shield-exclamation"></i></div>
                    <div>
                        <h3>Theft Status</h3>
                        <p class="section-sub">Is the car flagged as stolen? Get immediate alerts.</p><span class="pill">Included</span>
                    </div>
                </article>
                <article class="feat-card card" data-aos="fade-up" data-aos-delay="80">
                    <div class="icon"><i class="bi bi-speedometer2"></i></div>
                    <div>
                        <h3>Mileage Anomalies</h3>
                        <p class="section-sub">Detect odometer rollbacks and inconsistencies.</p><span class="pill">Included</span>
                    </div>
                </article>
                <article class="feat-card card" data-aos="fade-up" data-aos-delay="120">
                    <div class="icon"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <h3>Ownership History</h3>
                        <p class="section-sub">Number of owners & usage type (private, fleet).</p><span class="pill">Included</span>
                    </div>
                </article>
                <article class="feat-card card" data-aos="fade-up" data-aos-delay="160">
                    <div class="icon"><i class="bi bi-cash-coin"></i></div>
                    <div>
                        <h3>Market Value</h3>
                        <p class="section-sub">Estimated fair price for Nigeria.</p><span class="pill">Included</span>
                    </div>
                </article>
                <article class="feat-card card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon"><i class="bi bi-water"></i></div>
                    <div>
                        <h3>Flood/Salvage</h3>
                        <p class="section-sub">Flood damage, salvage title & accident flags.</p><span class="pill">Add‑on</span>
                    </div>
                </article>
                <article class="feat-card card" data-aos="fade-up" data-aos-delay="240">
                    <div class="icon"><i class="bi bi-wrench-adjustable"></i></div>
                    <div>
                        <h3>Service Records</h3>
                        <p class="section-sub">Maintenance events when available.</p><span class="pill">Add‑on</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Sample Report Preview -->
    <section id="verify" class="section" aria-labelledby="report-title" data-aos="fade-down">
        <div class="container">
            <h2 id="report-title" class="section-title">Sample VIN report</h2>
            <p class="section-sub">A quick look at what you get after verification.</p>
            <div class="card" style="padding:16px;">
                <details>
                    <summary style="cursor:pointer; font-weight:700;">Summary</summary>
                    <div class="grid grid-3" style="margin-top:12px;">
                        <div class="feat-card">
                            <div class="icon"><i class="bi bi-shield-check"></i></div>
                            <div><strong>Status:</strong> Clean title</div>
                        </div>
                        <div class="feat-card">
                            <div class="icon"><i class="bi bi-geo"></i></div>
                            <div><strong>Country:</strong> Nigeria</div>
                        </div>
                        <div class="feat-card">
                            <div class="icon"><i class="bi bi-calendar2-week"></i></div>
                            <div><strong>Last Update:</strong> 10/08/2025</div>
                        </div>
                    </div>
                </details>
                <details>
                    <summary style="cursor:pointer; font-weight:700;">Odometer</summary>
                    <p class="section-sub">Last reading: 82,400 km. No rollback detected.</p>
                </details>
                <details>
                    <summary style="cursor:pointer; font-weight:700;">Alerts</summary>
                    <ul>
                        <li>No theft record found</li>
                        <li>No major accident reported</li>
                    </ul>
                </details>
                <button class="btn btn-outline" type="button" aria-label="View Sample PDF">View Sample PDF</button>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="section" aria-labelledby="pricing-title" data-aos="zoom-in">
        <div class="container">
            <h2 id="pricing-title" class="section-title">Simple pricing in NGN</h2>
            <p class="section-sub">Pay securely via Paystack or Flutterwave. No hidden fees.</p>
            <div class="pricing" id="pricingGrid" data-aos="fade-up"><!-- JS renders plans here --></div>
        </div>
    </section>

    <!-- Marketplace -->
    <section id="market" class="section" aria-labelledby="market-title" data-aos="zoom-in">
        <div class="container">
            <h2 id="market-title" class="section-title">Featured cars</h2>
            <p class="section-sub">Search verified listings. Negotiate confidently.</p>

            <div class="filters card" style="padding:12px;">
                <select id="filterMake" aria-label="Make">
                    <option value="">All Makes</option>
                    <option>Toyota</option>
                    <option>Honda</option>
                    <option>Mercedes-Benz</option>
                    <option>Lexus</option>
                    <option>Ford</option>
                </select>
                <select id="filterModel" aria-label="Model">
                    <option value="">All Models</option>
                </select>
                <select id="filterYear" aria-label="Year">
                    <option value="">Any Year</option>
                </select>
                <select id="filterState" aria-label="State">
                    <option value="">All States</option>
                    <option>Lagos</option>
                    <option>Abuja (FCT)</option>
                    <option>Rivers</option>
                    <option>Oyo</option>
                    <option>Anambra</option>
                    <option>Kaduna</option>
                </select>
                <input id="filterPrice" type="range" min="500000" max="50000000" step="500000" aria-label="Max price" />
                <input id="search" class="full" placeholder="Search by keyword (e.g., Corolla, low mileage, verified)" aria-label="Search listings" />
            </div>

            <div class="grid grid-3" id="carsGrid" data-aos="fade-up" aria-live="polite"><!-- JS renders cars --></div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section" aria-labelledby="why-title">
        <div class="container grid grid-3">
            <div class="card feat-card" data-aos="fade-up">
                <div class="icon"><i class="bi bi-patch-check"></i></div>
                <div>
                    <h3 id="why-title">Verified data sources</h3>
                    <p class="section-sub">Our checks combine reputable datasets with smart detection.</p>
                </div>
            </div>
            <div class="card feat-card" data-aos="fade-up" data-aos-delay="80">
                <div class="icon"><i class="bi bi-lightning"></i></div>
                <div>
                    <h3>Fast & secure</h3>
                    <p class="section-sub">Encryption, secure payments & instant results.</p>
                </div>
            </div>
            <div class="card feat-card" data-aos="fade-up" data-aos-delay="120">
                <div class="icon"><i class="bi bi-people"></i></div>
                <div>
                    <h3>Localized support</h3>
                    <p class="section-sub">We’re here for you across Nigeria & Africa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section" aria-labelledby="testimonials-title">
        <div class="container">
            <h2 id="testimonials-title" class="section-title">What buyers say</h2>
            <div class="grid grid-3">
                <article class="card" style="padding:16px;" data-aos="fade-up">
                    <p>“The VIN report saved me from buying a flooded car. Money well spent.”</p><strong>Chinedu · Lagos</strong>
                </article>
                <article class="card" style="padding:16px;" data-aos="fade-up" data-aos-delay="80">
                    <p>“Instant results and clear report sections. Highly recommend.”</p><strong>Aisha · Abuja</strong>
                </article>
                <article class="card" style="padding:16px;" data-aos="fade-up" data-aos-delay="120">
                    <p>“Negotiated a better price using the market value estimate.”</p><strong>Femi · Port Harcourt</strong>
                </article>
            </div>
        </div>
    </section>

    <!-- Data Sources & Coverage -->
    <section id="sources" class="section" aria-labelledby="sources-title">
        <div class="container">
            <h2 id="sources-title" class="section-title">Data sources & coverage</h2>
            <p class="section-sub">Powered by reliable partners. Availability may vary by country and vehicle.</p>
            <div class="grid grid-4">
                <div class="card" style="padding:16px; display:grid; place-items:center;">NIS Logo (placeholder)</div>
                <div class="card" style="padding:16px; display:grid; place-items:center;">FRSC Logo (placeholder)</div>
                <div class="card" style="padding:16px; display:grid; place-items:center;">Insurance DB</div>
                <div class="card" style="padding:16px; display:grid; place-items:center;">Auction Records</div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="section" aria-labelledby="faq-title">
        <div class="container">
            <h2 id="faq-title" class="section-title">Frequently asked questions</h2>
            <div id="faqList" class="grid" style="gap:12px;"><!-- JS renders FAQ --></div>
        </div>
    </section>

    <!-- Blog Teaser -->
    <section id="blog" class="section" aria-labelledby="blog-title">
        <div class="container">
            <h2 id="blog-title" class="section-title">From the blog</h2>
            <div class="grid grid-3" id="blogGrid"><!-- JS renders posts --></div>
        </div>
    </section>

    <!-- CTA Band -->
    <section class="section" aria-labelledby="cta-title">
        <div class="container">
            <div class="cta" data-aos="zoom-in">
                <h3 id="cta-title">Ready to verify a VIN?</h3>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="#verify" class="btn btn-primary"><i class="bi bi-shield-lock"></i> Verify Now</a>
                    <a href="#pricing" class="btn btn-outline"><i class="bi bi-credit-card2-front"></i> See Pricing</a>
                </div>
            </div>
        </div>
    </section>

    <?php require_once ROOT_PATH . '/includes/footer-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/LandingPage.js"></script>
</body>

</html