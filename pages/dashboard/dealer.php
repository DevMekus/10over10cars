<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="dealerPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <section class="hero">
                    <div class="card" data-aos="fade-up">
                        <h2 class="section-title" style="margin:0">Join 10over10 as a Dealer</h2>
                        <p class="muted">Get access to verified leads, priority listings, and dealer tools to manage inventory and sales. Apply below and complete verification.</p>

                        <div style="margin-top:12px" class="benefits">
                            <div class="benefit">
                                <div class="icon"><i class="bi bi-people-fill"></i></div>
                                <div><strong>More visibility</strong>
                                    <div class="muted small">Reach thousands of buyers</div>
                                </div>
                            </div>
                            <div class="benefit">
                                <div class="icon"><i class="bi bi-shield-check"></i></div>
                                <div><strong>Verified badge</strong>
                                    <div class="muted small">Build trust with buyers</div>
                                </div>
                            </div>
                            <div class="benefit">
                                <div class="icon"><i class="bi bi-graph-up"></i></div>
                                <div><strong>Analytics</strong>
                                    <div class="muted small">Track views & leads</div>
                                </div>
                            </div>
                            <div class="benefit">
                                <div class="icon"><i class="bi bi-gear-fill"></i></div>
                                <div><strong>Dealer tools</strong>
                                    <div class="muted small">Bulk upload & manage listings</div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top:16px" class="steps">
                            <div class="step">
                                <div class="muted small">Step 1</div>
                                <div style="font-weight:800">Apply</div>
                            </div>
                            <div class="step">
                                <div class="muted small">Step 2</div>
                                <div style="font-weight:800">Verify</div>
                            </div>
                            <div class="step">
                                <div class="muted small">Step 3</div>
                                <div style="font-weight:800">Approved</div>
                            </div>
                        </div>


                    </div>

                    <aside class="card" data-aos="fade-down">
                        <div style="display:flex;justify-content:space-between;align-items:center"><strong>Application status</strong>
                            <div class="muted small <?= $user['company_status'] ?? ''  ?> status-pill"><?= $user['company_status'] ?? ''  ?></div>
                        </div>
                        <div style="margin-top:12px">
                            <div class="notice"><strong id="statusBadge"><?= $user['company_status'] ? 'Applied' : 'Not applied' ?></strong>
                                <div class="muted small">
                                    <?= $user['company_status'] ? 'You have submitted an application.' : 'You have not submitted an application.' ?></div>
                            </div>
                        </div>

                        <div style="margin-top:12px">
                            <strong>Resources</strong>
                            <ul class="muted small" style="margin-top:8px">
                                <li>Dealer guide PDF</li>
                                <li>Listing rules</li>
                                <li>Pricing & commissions</li>
                            </ul>
                        </div>
                    </aside>
                </section>

                <?php if (!isset($user['company'])):  ?>
                    <section style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
                        <!-- Application Form -->
                        <div class="card" data-aos="zoom-in" style="padding: 20px;">
                            <h3 style="margin: 0;">Application Form</h3>
                            <p class="muted small">
                                Fill out the form to apply as a dealer. Attach required documents for verification.
                            </p>

                            <form id="dealerForm" enctype="multipart/form-data">
                                <!-- Row 1 -->
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Business name*</label>
                                        <input class="form-control" name="company" required placeholder="Your business name" />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Seller type*</label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="individual">Individual</option>
                                            <option value="dealer">Dealer</option>
                                            <option value="company">Company</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Phone*</label>
                                        <input class="form-control" name="phone" required placeholder="+234 81..." />
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Email*</label>
                                        <input class="form-control" name="contact" value="<?= $role !== 'admin' ? $user['email_address'] : '' ?>" type="email" required placeholder="email@company.com" />
                                    </div>


                                    <input class="form-control" name="userid" type="hidden"
                                        value="<?= $role !== 'admin' ? $userid : ''; ?>" required />



                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Location*</label>
                                        <input class="form-control" name="state" required placeholder="Enugu.." />
                                    </div>
                                    <div class="col-sm-6 mb-2" id="license">
                                        <label class="muted small">Dealer License / RC number</label>
                                        <input class="form-control" name="rc_number" placeholder="RC12345" />
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <label class="muted small">About us*</label>
                                        <textarea rows="3" class="form-control" name="about" required placeholder="We exist to.."></textarea>

                                    </div>
                                    <!-- Upload -->
                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Upload verification documents</label><br />
                                        <small class="muted">Accepted: ID, RC, proof of address (PDF or image)</small><br />
                                        <input id="docInput" name="docInput" type="file" multiple accept="application/pdf" style="margin-top: 6px;" />
                                        <div id="preview" class="file-preview"></div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label class="small muted">Upload Banner</label><br />
                                        <small class="muted">Upload your business banner for easy identification</small><br />
                                        <input id="banner" name="banner" type="file" accept="image/*" style="margin-top: 6px;" />
                                        <div id="preview" class="file-preview"></div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <label class="muted small">Upload Avatar</label><br />
                                        <small class="muted">Upload your image</small><br />
                                        <input id="avatar" name="avatar" type="file" accept="image/*" style="margin-top: 6px;" />
                                        <div id="preview" class="file-preview"></div>
                                    </div>
                                </div>



                                <!-- Actions -->
                                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 8px;">

                                    <button type="submit" class="btn btn-primary btn-pill">Submit Application</button>
                                </div>
                            </form>
                        </div>
                        <script>
                            function check_type() {
                                const dealer_type = document.getElementById("type")
                                const license = document.getElementById("license")
                                if (dealer_type.value == 'individual') {
                                    license.style.display = "none"
                                } else {
                                    license.style.display = "block"
                                }
                                dealer_type.addEventListener("change", check_type)
                            }
                            check_type()
                        </script>
                        <!-- FAQ Sidebar -->
                        <aside class="card" data-aos="fade-up" style="padding: 20px;">
                            <h4 style="margin: 0;">FAQ</h4>
                            <div class="faq" style="margin-top: 16px; display: grid; gap: 12px;">
                                <div class="q">
                                    <strong>What documents are required?</strong>
                                    <div class="muted small">ID, company RC (if applicable), proof of address.</div>
                                </div>
                                <div class="q">
                                    <strong>How long does verification take?</strong>
                                    <div class="muted small">Typically 2–5 business days in demo mode.</div>
                                </div>
                                <div class="q">
                                    <strong>Is there a fee?</strong>
                                    <div class="muted small">No fee in this demo — production may vary.</div>
                                </div>
                            </div>
                            <div style="margin-top: 16px;">
                                <button id="howItWorks" class="btn btn-sm btn-ghost">How it works</button>
                            </div>
                        </aside>
                    </section>
                <?php endif;  ?>




                <section class="card" data-aos="fade-up">
                    <h4 style="margin:0">Your applications</h4>
                    <div id="applications" style="margin-top:12px" class="muted small">No applications yet.</div>
                </section>


                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>

    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/DealerPage.js"></script>

</body>
<?php require "modals.php"; ?>

</html