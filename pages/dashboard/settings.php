<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="settingsPage" data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <main class="content">
                <div class="card-dash">
                    <div class="tabs" role="tablist">
                        <div class="tab active" data-tab="profile">Profile</div>
                        <div class="tab" data-tab="preferences">Preferences</div>
                        <div class="tab" data-tab="security">Security</div>
                        <div class="tab" data-tab="platform">Platform</div>
                    </div>

                    <section id="profile" class="tab-panel">
                        <form id="profileForm">
                            <div class="row">
                                <div>
                                    <label>Full name</label>
                                    <input type="text" name="fullname" id="fullname" required />
                                </div>
                                <div>
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" required />
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <label>Phone</label>
                                    <input type="text" name="phone" id="phone" />
                                </div>
                                <div>
                                    <label>Location</label>
                                    <input type="text" name="location" id="location" />
                                </div>
                            </div>

                            <div style="display:flex;gap:12px;align-items:center;margin-top:6px">
                                <div style="width:84px;height:84px;border-radius:12px;overflow:hidden;background:#eef2f7"><img id="avatarPreview" src="https://i.pravatar.cc/200?img=32" alt="avatar" style="width:100%;height:100%;object-fit:cover" /></div>
                                <div style="flex:1">
                                    <label class="small muted">Profile picture</label>
                                    <input type="file" id="avatarInput" accept="image/*" />
                                    <div class="small muted">PNG, JPG — max 2MB</div>
                                </div>
                            </div>

                            <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <button type="button" id="profileSave" class="btn btn-primary btn-pill">Save profile</button>
                                <button type="button" id="changePasswordBtn" class="btn btn-ghost">Change password</button>
                            </div>
                        </form>
                    </section>

                    <section id="preferences" class="tab-panel" style="display:none">
                        <form id="prefsForm">
                            <div class="row">
                                <div>
                                    <label>Theme</label>
                                    <select id="themeSelect">
                                        <option value="light">Light</option>
                                        <option value="dark">Dark</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Language</label>
                                    <select id="langSelect">
                                        <option value="en">English</option>
                                        <option value="fr">Français</option>
                                        <option value="yo">Yorùbá</option>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-top:8px">
                                <label>Notifications</label>
                                <div class="inline" style="margin-top:6px">
                                    <label class="small"><input type="checkbox" id="emailNotif" /> Email</label>
                                    <label class="small"><input type="checkbox" id="smsNotif" /> SMS</label>
                                    <label class="small"><input type="checkbox" id="pushNotif" /> Push</label>
                                </div>
                            </div>

                            <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <button type="button" id="prefsSave" class="btn btn-primary btn-pill">Save preferences</button>
                                <button type="button" id="prefsReset" class="btn btn-ghost">Reset</button>
                            </div>
                        </form>
                    </section>

                    <section id="security" class="tab-panel" style="display:none">
                        <form id="securityForm">
                            <div style="margin-bottom:8px">
                                <label>Two-factor authentication (2FA)</label>
                                <div class="inline" style="margin-top:6px">
                                    <label class="small"><input type="checkbox" id="toggle2fa" /> Enable 2FA</label>
                                </div>
                                <div class="small muted" style="margin-top:6px">We recommend enabling 2FA for all admin accounts.</div>
                            </div>

                            <div style="margin-top:8px">
                                <label>Recent login activity</label>
                                <div class="activity card" style="margin-top:8px">
                                    <table class="brand-table">
                                        <thead>
                                            <tr>
                                                <th>When</th>
                                                <th>IP</th>
                                                <th>Device</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loginActivity"></tbody>
                                    </table>
                                </div>
                            </div>

                            <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <button type="button" id="securitySave" class="btn btn-primary">Save security</button>
                                <button type="button" id="revokeSessions" class="btn btn-ghost">Revoke sessions</button>
                            </div>
                        </form>
                    </section>

                    <section id="platform" class="tab-panel" style="display:none">
                        <form id="platformForm">
                            <div class="row">
                                <div>
                                    <label>Default verification plan</label>
                                    <select id="defaultPlan">
                                        <option>Standard</option>
                                        <option>Basic</option>
                                        <option>Pro</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Transaction limit (NGN)</label>
                                    <input type="number" id="txLimit" min="0" />
                                </div>
                            </div>

                            <div style="margin-top:8px">
                                <label>Dealer verification rules</label>
                                <textarea id="dealerRules" rows="4" style="width:100%;padding:10px;border-radius:10px;border:1px solid rgba(15,23,36,0.06);background:transparent"></textarea>
                            </div>

                            <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <button type="button" id="platformSave" class="btn primary">Save platform</button>
                                <button type="button" id="platformReset" class="btn ghost">Reset</button>
                            </div>
                        </form>
                    </section>
                </div>

                <div class="grid-2">
                    <div class="card" data-aos="fade-up">
                        <strong>Audit log</strong>
                        <div class="muted small">Recent administrative actions</div>
                        <div style="margin-top:10px;max-height:300px;overflow:auto;" id="auditLog"></div>
                    </div>

                    <div class="card" data-aos="fade-up">
                        <strong>Danger zone</strong>
                        <div class="muted small">Account and system destructive actions</div>
                        <div>
                            <button id="resetPlatformBtn" class="btn btn-ghost">Reset platform settings</button>
                            <button id="exportBackup" class="btn btn-ghost">Export system backup</button>
                            <button id="deleteAccountBtn" class="btn" style="background:var(--danger);color:#fff">Delete admin account</button>
                        </div>
                    </div>
                </div>

                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Settings.js"></script>

</body>

</html