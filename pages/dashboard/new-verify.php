<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="userVerify" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <div>
                    <div style="font-weight:800">VIN Verification</div>
                    <div class="muted small">Enter a VIN to verify vehicle details, status and history.</div>
                </div>

                <!-- VIN form -->
                <section class="card" data-aos="fade-up">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap">
                        <div style="flex:1">
                            <div class="vin-wrap">
                                <input id="vinInput" class="vin-input" placeholder="Enter VIN (11–17 chars) — e.g. JH4KA8260MC000000" aria-label="VIN input" />
                                <button id="verify" class="verify-btn">Verify VIN</button>
                            </div>
                            <div id="vinHelp" class="muted small" style="margin-top:8px">We validate format locally and run a mock lookup. In production replace mock with your API.</div>
                        </div>
                        <div style="width:320px">
                            <div class="muted small">Quick tips</div>
                            <ul style="margin:8px 0 0 16px" class="muted small">
                                <li>VIN length: 11–17 characters.</li>
                                <li>Avoid I, O, Q characters — they are not used in VINs.</li>
                                <li>Use the full VIN for best results.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Results + sidebar -->
                <section class="card result-grid" data-aos="fade-up">
                    <div>
                        <div id="noResult" class="muted">No verification yet — enter a VIN and click Verify.</div>
                        <div id="resultArea" style="display:none">
                            <div class="vehicle-card card" style="margin-bottom:12px">
                                <div class="vehicle-media" id="vehMedia"><img src="https://images.unsplash.com/photo-1542362567-b07e54358753?q=80&w=1200&auto=format&fit=crop&sat=-20" alt="vehicle" /></div>
                                <div>
                                    <div style="display:flex;justify-content:space-between;align-items:center">
                                        <div>
                                            <div style="font-weight:800;font-size:18px" id="vehTitle">2018 Honda Accord</div>
                                            <div class="muted small" id="vehSub">VIN: <code id="vehVin">--</code> • Owner: <span id="vehOwner">--</span></div>
                                        </div>
                                        <div style="text-align:right">
                                            <div id="vehPrice" style="font-weight:800">NGN 0</div>
                                            <div style="margin-top:8px"><span id="vehStatus" class="status-pill status-clean">Status</span></div>
                                        </div>
                                    </div>

                                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:12px">
                                        <div class="small muted">
                                            <div style="font-weight:700" id="vehYear">Year</div>
                                            <div>Year</div>
                                        </div>
                                        <div class="small muted">
                                            <div style="font-weight:700" id="vehMileage">Mileage</div>
                                            <div>Mileage</div>
                                        </div>
                                        <div class="small muted">
                                            <div style="font-weight:700" id="vehEngine">Engine</div>
                                            <div>Engine</div>
                                        </div>
                                    </div>

                                    <div style="margin-top:12px">
                                        <strong>History</strong>
                                        <ul id="vehHistory" style="margin-top:8px"></ul>
                                    </div>

                                    <div style="display:flex;gap:8px;margin-top:12px">
                                        <button id="saveToHistory" class="btn ghost">Save to history</button>
                                        <button id="reportIssue" class="btn" style="background:var(--danger);color:#fff">Report issue</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card" style="margin-bottom:12px"><strong>Verification details</strong>
                                <div id="rawDetail" class="muted small" style="margin-top:8px"></div>
                            </div>

                            <div class="card"><strong>Related records</strong>
                                <div id="related" style="margin-top:8px" class="muted small">No related records (demo).</div>
                            </div>
                        </div>
                    </div>

                    <aside>
                        <div class="card">
                            <strong>Verification history</strong>
                            <div class="muted small" style="margin-top:6px">Recent VIN lookups (local)</div>
                            <div class="history-list" id="historyList" style="margin-top:10px"></div>
                            <div style="display:flex;gap:8px;margin-top:10px;justify-content:flex-end"><button id="clearHistory" class="btn ghost">Clear</button></div>
                        </div>

                        <div class="card" style="margin-top:12px">
                            <strong>Helpful tips</strong>
                            <div class="tips small muted" style="margin-top:8px">
                                <div>• Always cross-check VIN characters: 0 (zero) vs O (letter O).</div>
                                <div>• If VIN is incomplete, fewer results will be found.</div>
                                <div>• For production, connect to authoritative VIN APIs or vehicle registries.</div>
                            </div>
                        </div>
                    </aside>
                </section>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Verification.js"></script>
</body>

</html