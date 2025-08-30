<?php

require_once ROOT_PATH . '/includes/header.php';


?>

<body id="VERIFIEDContainer">
    <?php require_once ROOT_PATH . '/includes/topbar.php'; ?>
    <div class="container">

        <!-- LEFT: Summary + Carousel -->
        <div style="display:flex;flex-direction:column;gap:16px">

            <section class="summary" aria-labelledby="summaryTitle" data-aos="zoom-in">
                <div class="brand">
                    <a href="<?= BASE_URL  ?>">
                        <img class="brand" src="<?= BASE_URL ?>assets/images/dark-logo.jpg" />
                    </a>
                    <div>
                        <div style="font-weight:800">2016 Toyota Corolla</div>
                        <div class="muted">VIN verification summary</div>
                    </div>
                </div>

                <div class="vin-row">
                    <div><strong>VIN</strong></div>
                    <div class="vin" id="vinText">2HGFB2F50DH512345</div>
                    <button class="action-btn" id="copyVin" title="Copy VIN"><i class="bi bi-clipboard"></i></button>
                    <button class="action-btn" id="printBtn" title="Print report"><i class="bi bi-printer"></i></button>
                    <div style="margin-left:auto"><span class="status clean" id="statusBadge">Clean</span></div>
                </div>

                <div class="meta-grid">
                    <div class="meta-item">
                        <div class="muted">Make</div>
                        <div style="font-weight:700">Toyota</div>
                    </div>
                    <div class="meta-item">
                        <div class="muted">Model</div>
                        <div style="font-weight:700">Corolla</div>
                    </div>
                    <div class="meta-item">
                        <div class="muted">Year</div>
                        <div style="font-weight:700">2016</div>
                    </div>
                    <div class="meta-item">
                        <div class="muted">Last update</div>
                        <div style="font-weight:700" id="lastUpdate">2025-08-10</div>
                    </div>
                </div>

                <div style="display:flex;gap:8px;align-items:center;margin-top:6px">
                    <button class="action-btn" id="downloadPdf"><i class="bi bi-file-earmark-pdf"></i> Download PDF</button>
                    <button class="action-btn" id="shareBtn"><i class="bi bi-share"></i> Share</button>
                    <button class="action-btn" id="saveBtn"><i class="bi bi-bookmark"></i> Save</button>
                </div>
            </section>

            <section class="carousel" aria-labelledby="imagesTitle" data-aos="fade-up">
                <strong id="imagesTitle">Images</strong>
                <div class="carousel-main" id="carouselMain">No image available</div>
                <div class="thumbs" id="thumbs"></div>
            </section>

        </div>

        <!-- RIGHT: Tabs & Details -->
        <div style="display:flex;flex-direction:column;gap:16px">

            <section class="tabs" data-aos="fade-left">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <div class="tab-nav" role="tablist" aria-label="Report sections">
                        <button class="tab-btn active" role="tab" aria-selected="true" data-tab="overview">Overview</button>
                        <button class="tab-btn" role="tab" data-tab="ownership">Ownership</button>
                        <button class="tab-btn" role="tab" data-tab="accidents">Accidents</button>
                        <button class="tab-btn" role="tab" data-tab="specs">Specifications</button>
                        <button class="tab-btn" role="tab" data-tab="insurance">Insurance</button>
                    </div>
                    <div class="controls">
                        <span class="muted">Trust score</span>
                        <div class="kbd" id="trustScore">92%</div>
                    </div>
                </div>

                <div id="overview" class="tab-panel active">
                    <div class="card">
                        <strong>Summary</strong>
                        <p class="muted">This vehicle has no theft record, no serious accidents reported, and mileage appears consistent with age and usage.</p>
                    </div>

                    <div style="margin-top:10px" class="list">
                        <div class="card"><strong>Odometer</strong>
                            <div class="muted">82,400 km — no rollback detected</div>
                        </div>
                        <div class="card"><strong>Theft Status</strong>
                            <div class="muted">No theft records found across partnered sources</div>
                        </div>
                        <div class="card"><strong>Market Value</strong>
                            <div class="muted">Estimated NGN 7,800,000</div>
                        </div>
                    </div>
                </div>

                <div id="ownership" class="tab-panel">
                    <div class="card">
                        <strong>Ownership history</strong>
                        <ol class="muted" style="padding-left:18px;margin:8px 0">
                            <li>2016–2018: Dealer (Imported)</li>
                            <li>2018–2021: Private owner — Lagos</li>
                            <li>2021–Present: Current owner — Abuja (FCT)</li>
                        </ol>
                    </div>
                </div>

                <div id="accidents" class="tab-panel">
                    <div class="card">
                        <strong>Accident & Damage Reports</strong>
                        <div class="muted" style="margin-top:6px">No major structural damage reported. Minor insurance claim in 2019 for bumper repair.</div>
                    </div>
                </div>

                <div id="specs" class="tab-panel">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="muted">Engine</div>
                            <div style="font-weight:700">1.8L I4</div>
                        </div>
                        <div class="meta-item">
                            <div class="muted">Transmission</div>
                            <div style="font-weight:700">Automatic</div>
                        </div>
                        <div class="meta-item">
                            <div class="muted">Fuel</div>
                            <div style="font-weight:700">Petrol</div>
                        </div>
                        <div class="meta-item">
                            <div class="muted">Color</div>
                            <div style="font-weight:700">Silver</div>
                        </div>
                    </div>
                </div>

                <div id="insurance" class="tab-panel">
                    <div class="card">
                        <strong>Insurance</strong>
                        <div class="muted">Last known insurer: Example Insurance Plc — cover lapsed 2023-12-31</div>
                    </div>
                </div>

            </section>

            <!-- Related cars -->
            <section data-aos="fade-up">
                <strong>Related listings</strong>
                <div class="related" id="relatedList" aria-live="polite"></div>
            </section>

            <footer>
                © <span id="year"></span> 10over10 Cars • <a href="#">Privacy</a> • <a href="#">Terms</a>
            </footer>

        </div>

    </div>
    <div id="toastContainer" aria-live="polite" style="position:fixed;right:20px;top:20px;z-index:9999"></div>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Verification.js"></script>
</body>

</html