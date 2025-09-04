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

                <div class="container-app">
                    <div class="layout">
                        <!-- Center column -->
                        <div class="main-col">

                            <!-- Profile header card -->
                            <div class="card-panel" data-aos="fade-up">
                                <div class="profile-hero">
                                    <div class="avatar"><img id="avatarPreview" src="<?= $user['avatar'] ?? 'https://i.pravatar.cc/200?img=32' ?>" alt="Avatar"></div>
                                    <div>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <h3 style="margin:0"></h3>
                                            <div class="chip"></div>
                                        </div>
                                        <div class="muted" style="margin-top:6px"><?= $user['email_address']; ?></div>

                                        <div class="progress-wrap" style="margin-top:12px;max-width:420px">
                                            <label class="form-label">Profile completion</label>
                                            <div class="progress" style="height:10px;border-radius:999px;overflow:hidden">
                                                <div id="profileProgress" class="progress-bar" role="progressbar" style="width:72%;background:linear-gradient(90deg,var(--accent), var(--primary));"></div>
                                            </div>
                                        </div>

                                    </div>

                                    <div style="margin-left:auto;display:flex;flex-direction:column;gap:8px;align-items:flex-end">
                                        <div class="muted small">Last login: <strong>2 hours ago</strong></div>
                                        <div style="display:flex;gap:8px">
                                            <button class="btn btn-outline-secondary btn-sm btn-pill" id="editProfileBtn">Edit</button>
                                            <button class="btn btn-primary btn-sm btn-pill" id="changePasswordBtn" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs content container -->
                            <div class="card-panel" data-aos="fade-up">
                                <div class="tabs-header" role="tablist">
                                    <button class="active" data-tabbtn="profile">Profile</button>
                                    <button data-tabbtn="preferences">Preferences</button>
                                    <button data-tabbtn="security">Security</button>
                                    <button data-tabbtn="platform">Platform</button>
                                </div>

                                <!-- Profile tab -->
                                <div id="profile" class="tab-panel" role="tabpanel">
                                    <form id="profileForm" novalidate>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Full name</label>
                                                <input type="text" name="fullname" id="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" required />
                                                <div class="invalid-feedback">Please provide your full name.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email_address'] ?? '') ?>" required />
                                                <div class="invalid-feedback">Enter a valid email.</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" />
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Location</label>
                                                <input type="text" name="location" id="location" class="form-control" value="<?= htmlspecialchars($user['location'] ?? '') ?>" />
                                            </div>

                                            <div class="col-12 d-flex gap-3 align-items-center">
                                                <div style="width:84px;height:84px;border-radius:12px;overflow:hidden;background:#eef2f7"><img id="avatarPreviewSmall" src="<?= $user['avatar'] ?? 'https://i.pravatar.cc/200?img=32' ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover" /></div>
                                                <div style="flex:1">
                                                    <label class="form-label small muted">Profile picture</label>
                                                    <input type="file" id="avatarInput" accept="image/*" class="form-control form-control-sm" />
                                                    <div class="helper">PNG, JPG — max 2MB</div>
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end gap-2" style="margin-top:6px">
                                                <button type="button" id="profileReset" class="btn btn-outline-secondary">Reset</button>
                                                <button type="submit" id="profileSave" class="btn btn-primary">Save profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Preferences tab -->
                                <div id="preferences" class="tab-panel d-none" role="tabpanel">
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
                                <div id="security" class="tab-panel d-none" role="tabpanel">
                                    <form id="securityForm">
                                        <div class="mb-3">
                                            <label class="form-label">Two-factor authentication (2FA)</label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="toggle2fa" />
                                                <label class="form-check-label" for="toggle2fa">Enable 2FA</label>
                                            </div>
                                            <div class="helper">We recommend enabling 2FA for all admin accounts.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Recent login activity</label>
                                            <div class="card-panel mt-2" style="padding:0;">
                                                <table class="brand-table mb-0">
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

                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" id="revokeSessions" class="btn btn-outline-secondary">Revoke sessions</button>
                                            <button type="submit" id="securitySave" class="btn btn-primary">Save security</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Platform tab -->
                                <div id="platform" class="tab-panel d-none" role="tabpanel">
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

                            <!-- Audit & Danger (mobile stacked below) -->
                            <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                <div class="card-panel" data-aos="fade-up">
                                    <strong>Audit log</strong>
                                    <div class="muted small">Recent administrative actions</div>
                                    <div class="audit-list mt-2" id="auditLog"></div>
                                </div>

                                <div class="card-panel" data-aos="fade-up">
                                    <strong>Danger zone</strong>
                                    <div class="muted small">Account and system destructive actions</div>
                                    <div class="danger-zone mt-3">
                                        <div style="display:flex;flex-direction:column;gap:8px">
                                            <button id="resetPlatformBtn" class="btn btn-outline-secondary">Reset platform settings</button>
                                            <button id="exportBackup" class="btn btn-outline-secondary">Export system backup</button>
                                            <button id="deleteAccountBtn" class="btn btn-danger">Delete admin account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right rail -->
                        <aside class="right-rail">
                            <div class="card-panel" data-aos="fade-up">
                                <h6>Account actions</h6>
                                <div class="d-flex flex-column gap-2 mt-2">
                                    <button class="btn btn-outline-secondary">Download data</button>
                                    <button class="btn btn-warning">Deactivate account</button>
                                    <button class="btn btn-danger">Delete account</button>
                                </div>
                            </div>

                            <div class="card-panel" data-aos="fade-up">
                                <h6>Preferences</h6>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="prefDark" />
                                    <label class="form-check-label" for="prefDark">Dark mode</label>
                                </div>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="prefEmail" checked />
                                    <label class="form-check-label" for="prefEmail">Email notifications</label>
                                </div>
                            </div>

                            <div class="card-panel text-center" data-aos="fade-up">
                                <h6>Support</h6>
                                <p class="muted small">Need help? Contact support for assistance.</p>
                                <a href="<?= BASE_URL; ?>contact-us" class="btn btn-outline-primary">Contact support</a>
                            </div>
                        </aside>
                    </div>
                </div>

                <!-- Modals -->
                <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm action</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="confirmBody">Are you sure?</div>
                            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" id="confirmOk">Yes, proceed</button></div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Change password</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="pwdForm" novalidate>
                                    <div class="mb-3"><label class="form-label">Current password</label><input type="password" class="form-control" name="current" required></div>
                                    <div class="mb-3"><label class="form-label">New password</label><input type="password" class="form-control" name="new" id="newPwd" required></div>
                                    <div class="mb-3"><label class="form-label">Confirm password</label><input type="password" class="form-control" name="confirm" id="confirmPwd" required></div>
                                    <div class="mb-2">
                                        <div id="pwdStrength" style="height:8px;border-radius:8px;background:#eee;width:0%"></div>
                                    </div>
                                    <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Change password</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toasts container -->
                <div class="position-fixed top-0 end-0 p-3" style="z-index:1200">
                    <div id="toastArea"></div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
                <script>
                    // ---------- Initialization ----------
                    AOS.init({
                        duration: 600,
                        once: true
                    });

                    // Theme persistence
                    const html = document.documentElement;
                    const stored = localStorage.getItem('settings-theme');
                    if (stored === 'dark') {
                        html.classList.add('theme-dark');
                        document.getElementById('prefDark')?.setAttribute('checked', '');
                    }

                    document.getElementById('themeToggle')?.addEventListener('click', () => {
                        const dark = html.classList.toggle('theme-dark');
                        localStorage.setItem('settings-theme', dark ? 'dark' : 'light');
                        document.getElementById('prefDark').checked = dark;
                    });

                    document.getElementById('prefDark')?.addEventListener('change', (e) => {
                        const dark = e.target.checked;
                        html.classList.toggle('theme-dark', dark);
                        localStorage.setItem('settings-theme', dark ? 'dark' : 'light');
                    });

                    // Tabs (sidebar & top tabs) behavior
                    function activateTab(name) {
                        document.querySelectorAll('[data-tab]').forEach(b => b.classList.remove('active'));
                        document.querySelectorAll('[data-tabbtn]').forEach(b => b.classList.remove('active'));
                        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('d-none'));
                        const leftBtn = document.querySelector('[data-tab="' + name + '"]');
                        if (leftBtn) leftBtn.classList.add('active');
                        const topBtn = document.querySelector('[data-tabbtn="' + name + '"]');
                        if (topBtn) topBtn.classList.add('active');
                        const panel = document.getElementById(name);
                        if (panel) panel.classList.remove('d-none');
                    }

                    document.querySelectorAll('.nav-vert button[data-tab]').forEach(btn => {
                        btn.addEventListener('click', () => activateTab(btn.dataset.tab));
                    });
                    document.querySelectorAll('.tabs-header button').forEach(btn => btn.addEventListener('click', () => activateTab(btn.dataset.tabbtn)));

                    // Default active
                    activateTab('profile');

                    // Avatar upload preview (client-side)
                    const avatarInput = document.getElementById('avatarInput');
                    const avatarPreview = document.getElementById('avatarPreview');
                    const avatarPreviewSmall = document.getElementById('avatarPreviewSmall');
                    avatarInput?.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        if (!file) return;
                        if (file.size > 2 * 1024 * 1024) {
                            showToast('Image exceeds 2MB', 'danger');
                            avatarInput.value = '';
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = () => {
                            avatarPreview.src = reader.result;
                            avatarPreviewSmall.src = reader.result;
                        };
                        reader.readAsDataURL(file);
                    });

                    // Profile form validation & save (demo)
                    const profileForm = document.getElementById('profileForm');
                    profileForm?.addEventListener('submit', (e) => {
                        e.preventDefault();
                        if (!profileForm.checkValidity()) {
                            profileForm.classList.add('was-validated');
                            showToast('Please fix form errors', 'danger');
                            return;
                        }
                        showToast('Profile saved', 'success');
                        // TODO: submit via fetch to API
                    });
                    document.getElementById('profileReset')?.addEventListener('click', () => {
                        profileForm.reset();
                        showToast('Profile form reset', 'info');
                    });

                    // Preferences
                    document.getElementById('prefsForm')?.addEventListener('submit', e => {
                        e.preventDefault();
                        showToast('Preferences saved', 'success');
                    });
                    document.getElementById('prefsReset')?.addEventListener('click', () => {
                        document.getElementById('prefsForm').reset();
                        showToast('Preferences reset', 'info');
                    });

                    // Security: render login activity demo
                    const loginActivity = document.getElementById('loginActivity');
                    const sampleLogins = [{
                            when: '2025-08-25 14:02',
                            ip: '41.58.12.5',
                            device: 'Chrome — Windows',
                            action: 'Successful'
                        },
                        {
                            when: '2025-08-20 09:10',
                            ip: '41.58.12.5',
                            device: 'Mobile Safari',
                            action: 'Failed'
                        },
                    ];

                    function renderLogins() {
                        if (!loginActivity) return;
                        loginActivity.innerHTML = '';
                        sampleLogins.forEach(l => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `<td>${l.when}</td><td>${l.ip}</td><td>${l.device}</td><td><span class=\"badge text-bg-${l.action==='Successful'?'success':'danger'}\">${l.action}</span></td>`;
                            loginActivity.appendChild(tr);
                        });
                    }
                    renderLogins();

                    // Audit log
                    const auditLog = document.getElementById('auditLog');
                    const auditItems = ['Created dealer account - Admin', 'Updated verification rules', 'Exported backup'];

                    function renderAudit() {
                        if (!auditLog) return;
                        auditLog.innerHTML = '';
                        auditItems.forEach(a => {
                            const div = document.createElement('div');
                            div.className = 'audit-item';
                            div.innerHTML = `<div>${a}</div><div class=\"muted\">just now</div>`;
                            auditLog.appendChild(div);
                        });
                    }
                    renderAudit();

                    // Danger zone confirmation
                    document.getElementById('deleteAccountBtn')?.addEventListener('click', () => {
                        showConfirm('Delete admin account? This cannot be undone', () => showToast('Account deleted (demo)', 'success'));
                    });
                    document.getElementById('resetPlatformBtn')?.addEventListener('click', () => showConfirm('Reset all platform settings to defaults?', () => showToast('Platform reset (demo)', 'success')));
                    document.getElementById('exportBackup')?.addEventListener('click', () => showToast('Export started', 'info'));

                    // Confirm modal helper
                    function showConfirm(message, cb) {
                        const confirmBody = document.getElementById('confirmBody');
                        confirmBody.textContent = message;
                        const confirmOk = document.getElementById('confirmOk');
                        const modalEl = document.getElementById('confirmModal');
                        const bs = new bootstrap.Modal(modalEl);
                        bs.show();

                        function handle() {
                            cb();
                            bs.hide();
                            confirmOk.removeEventListener('click', handle);
                        }
                        confirmOk.addEventListener('click', handle);
                    }

                    // Toast helper
                    function showToast(msg, type = 'info') {
                        const area = document.getElementById('toastArea');
                        const toastId = 't' + Date.now();
                        const wrapper = document.createElement('div');
                        wrapper.innerHTML = `<div id="${toastId}" class=\"toast align-items-center text-bg-${type==='danger'?'danger':type==='success'?'success':type==='info'?'primary':'secondary'} border-0 show\" role=\"alert\" aria-live=\"assertive\" aria-atomic=\"true\"><div class=\"d-flex\"><div class=\"toast-body\">${msg}</div><button type=\"button\" class=\"btn-close btn-close-white me-2 m-auto\" data-bs-dismiss=\"toast\"></button></div></div>`;
                        area.appendChild(wrapper);
                        setTimeout(() => {
                            try {
                                wrapper.remove();
                            } catch (e) {}
                        }, 3500);
                    }

                    // Password strength simple meter
                    const newPwd = document.getElementById('newPwd');
                    const pwdStrength = document.getElementById('pwdStrength');
                    newPwd?.addEventListener('input', e => {
                        const v = e.target.value;
                        let s = 0;
                        if (v.length > 7) s++;
                        if (/[A-Z]/.test(v)) s++;
                        if (/[0-9]/.test(v)) s++;
                        if (/[^A-Za-z0-9]/.test(v)) s++;
                        const pct = (s / 4) * 100;
                        pwdStrength.style.width = pct + '%';
                        pwdStrength.style.background = s < 2 ? 'var(--error)' : s < 3 ? 'var(--warning)' : 'var(--accent)';
                    });

                    // Change password submit
                    document.getElementById('pwdForm')?.addEventListener('submit', e => {
                        e.preventDefault();
                        showToast('Password changed (demo)', 'success');
                        const m = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                        m.hide();
                    });

                    // Accessibility: keyboard shortcuts (T to toggle theme)
                    document.addEventListener('keydown', (e) => {
                        if (e.key.toLowerCase() === 't') {
                            const dark = !document.documentElement.classList.contains('theme-dark');
                            document.documentElement.classList.toggle('theme-dark', dark);
                            localStorage.setItem('settings-theme', dark ? 'dark' : 'light');
                            showToast('Theme toggled', 'info');
                        }
                    });
                </script>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Settings.js"></script>

</body>

</html