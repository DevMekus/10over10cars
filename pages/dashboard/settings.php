<?php

use App\Utils\Utility;

require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="profilePage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <div class="dashboard">
                    <!-- Summary Header Card -->
                    <div class="summary-card" data-aos="fade-up">

                        <div>
                            <h1>Settings</h1>
                            <p>As an administrator, you can configure system preferences, manage user permissions, and update platform-wide settings.</p>

                        </div>
                        <div class="summary-icon" data-aos="zoom-in" data-aos-delay="200">
                            <i data-feather="bar-chart-2" width="36" height="36"></i>
                        </div>
                    </div>
                </div>
                <div class="layout">
                    <!-- Left: Profile Overview & Tabs -->
                    <section>
                        <div class="card-panel mb-3" data-aos="fade-up">
                            <div class="profile-hero">
                                <div class="avatar"><img id="avatarPreview" src="<?= !empty($user['avatar']) ? $user['avatar'] : 'https://i.pravatar.cc/150?img=5' ?>" alt="Avatar preview"></div>
                                <div class="profile-meta">
                                    <h2><?= Utility::truncateText(ucfirst($user['fullname']), 20); ?> <span class="chip"><?= ucfirst($role); ?></span></h2>
                                    <div style="color:var(--muted);margin-top:6px"><?= ucfirst($user['email_address']); ?></div>
                                    <div class="progress-wrap">
                                        <label class="form-label">Profile completion</label>
                                        <div class="progress" style="height:10px;border-radius:999px;overflow:hidden">
                                            <div id="profileProgress" class="progress-bar" role="progressbar" style="width:72%;background:linear-gradient(90deg,var(--accent), var(--primary));"></div>
                                        </div>
                                    </div>
                                    <div style="margin-top:12px;display:flex;gap:8px">
                                        <button class="btn btn-primary pill" id="editBtn">Edit Profile</button>
                                        <button class="btn btn-outline-secondary pill" id="changePassBtn" data-bs-toggle="modal" data-bs-target="#updatePassword"><i class="bi bi-key-fill"></i> Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="card-panel" data-aos="fade-up">
                            <div class="tabs-nav" role="tablist" aria-label="Profile tabs">
                                <button class="active" data-tab="details">Profile Details</button>
                                <button data-tab="preferences">Preferences</button>
                                <button data-tab="security">Security</button>
                                <button data-tab="platform">Platform</button>
                            </div>

                            <!-- Tab: Profile Details -->
                            <div id="tab-details" class="tab-content">
                                <form id="profileForm" enctype="multipart/form-data">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full name</label>
                                            <input name="fullname" class="form-control" value="<?= ucfirst($user['fullname']) ?? ''; ?>" placeholder="John Doe" required />
                                            <div class="invalid-feedback">Please provide your full name.</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email_address" value="<?= ucfirst($user['email_address']) ?? ''; ?>" class="form-control" placeholder="You@email.com" <?= $role !== 'admin' ? 'disabled' : '' ?> />
                                            <div class="invalid-feedback">Enter a valid email address.</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input name="phone" value="<?= $user['phone'] ? ucfirst($user['phone']) : ""; ?>" class="form-control" placeholder="+1 555 555 555" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Location</label>
                                            <input name="location" value="<?= $user['location'] ? ucfirst($user['location']) : ""; ?>" class="form-control" placeholder="20 Dalas Avenue" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">City</label>
                                            <input name="city_state" value="<?= $user['city_state'] ? ucfirst($user['city_state']) : ""; ?>" class="form-control" placeholder="New Haven, Enugu state" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Country</label>
                                            <input name="country" value="<?= $user['country'] ? ucfirst($user['country']) : ""; ?>" class="form-control" placeholder="Nigeria" />
                                        </div>

                                        <input type="hidden" name="userid" value="<?= $user ? $user['userid'] : ''; ?>" required />


                                        <div class="col-md-12">

                                            <div class="mb-1" style="width:84px;height:84px;border-radius:12px;overflow:hidden;background:#eef2f7">
                                                <img id="avatarPreview2" src="<?= !empty($user['avatar']) ? $user['avatar'] : 'https://i.pravatar.cc/150?img=5' ?>" style="width:100%;height:100%;object-fit:cover" />
                                            </div>
                                            <label class="form-label">Select Avatar</label>
                                            <input type="file" name="dp-upload" accept="image/*" id="dp-upload" class="form-control" placeholder="https://..." />
                                            <div class="helper">Select an image PNG, JPG - Max 2MB</div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end" style="gap:8px;margin-top:6px">
                                            <button type="reset" id="resetProfile" class="btn btn-outline-secondary">Reset</button>
                                            <button type="submit" id="saveProfile" class="btn btn-primary btn-pill">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Preferences tab -->
                            <div id="tab-preferences" class="tab-content d-none">
                                <form id="prefsForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Theme</label>
                                            <select id="themeSelect" class="form-select">
                                                <option value="light">Light</option>
                                                <option value="dark">Dark</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Language</label>
                                            <select id="langSelect" class="form-select">
                                                <option value="en">English</option>
                                                <option value="fr">Français</option>
                                                <option value="yo">Yorùbá</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Notifications</label>
                                            <div class="d-flex gap-3 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="emailNotif" />
                                                    <label class="form-check-label" for="emailNotif">Email</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="smsNotif" />
                                                    <label class="form-check-label" for="smsNotif">SMS</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="pushNotif" />
                                                    <label class="form-check-label" for="pushNotif">Push</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                            <button type="button" id="prefsReset" class="btn btn-outline-secondary">Reset</button>
                                            <button type="submit" id="prefsSave" class="btn btn-primary">Save preferences</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Security tab -->
                            <div id="tab-security" class="tab-content d-none">
                                <form id="securityForm">
                                    <div class="mb-3">
                                        <label class="form-label">Two-factor authentication (2FA)</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="toggle2fa" />
                                            <label class="form-check-label" for="toggle2fa">Enable 2FA</label>
                                        </div>
                                        <div class="helper">We recommend enabling 2FA for all admin accounts.</div>
                                    </div>

                                    <div class="timeline" id="activityList">
                                    </div>
                                    <div class="d-flex justify-content-end mt-2"><button id="clearActivity" class="btn btn-outline-danger">Clear Activity</button></div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" id="revokeSessions" class="btn btn-outline-secondary">Revoke sessions</button>
                                        <button type="submit" id="securitySave" class="btn btn-primary">Save security</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Platform tab -->
                            <div id="tab-platform" class="tab-content d-none">
                                <form id="platformForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Default verification plan</label>
                                            <select id="defaultPlan" class="form-select">
                                                <option>Standard</option>
                                                <option>Basic</option>
                                                <option>Pro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Transaction limit (NGN)</label>
                                            <input type="number" id="txLimit" class="form-control" min="0" />
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Dealer verification rules</label>
                                            <textarea id="dealerRules" rows="4" class="form-control" placeholder="Enter verification rules..."></textarea>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end gap-2">
                                            <button type="button" id="platformReset" class="btn btn-outline-secondary">Reset</button>
                                            <button type="submit" id="platformSave" class="btn btn-primary">Save platform</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>

                    <!-- Right rail: Quick actions & preferences -->
                    <aside class="right-rail">
                        <div class="card-panel" data-aos="fade-up">
                            <h6>Account Actions</h6>
                            <div style="display:flex;flex-direction:column;gap:8px;margin-top:12px">
                                <button class="btn btn-outline-secondary">Download data</button>
                                <button class="btn btn-warning">Deactivate account</button>

                            </div>
                        </div>



                        <div class="card-panel text-center" data-aos="fade-up">
                            <h6>Support</h6>
                            <p class="text-muted" style="font-size:13px">Need help? Reach out to our support team.</p>
                            <a href="{{support_url}}" class="btn btn-outline-primary">Contact support</a>
                        </div>
                    </aside>
                </div>

                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/src/Pages/ProfilePage.js"></script>

    <script>
        /* ---------- Tabs ---------- */
        function activateTab(name) {
            document.querySelectorAll('.tabs-nav button').forEach(b => b.classList.toggle('active', b.dataset.tab === name));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('d-none'));
            const el = document.getElementById('tab-' + name);
            if (el) el.classList.remove('d-none');
        }
        document.querySelectorAll('.tabs-nav button').forEach(b => b.addEventListener('click', () => activateTab(b.dataset.tab)));
    </script>
</body>


</html>