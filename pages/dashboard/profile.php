<?php
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
                <!-- Profile top -->
                <section class="profile-top card" data-aos="fade-up">
                    <div class="avatar">
                        <img id="avatarImg" src="https://placehold.co/600x400?text=Profile+photo" alt="avatar" />
                        <div class="meta">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <div>
                                    <div style="font-weight:900;font-size:18px" id="displayName">Nnaemeka N.</div>
                                    <div class="muted small" id="displayEmail">nnaemeka@example.com</div>
                                </div>
                                <div style="text-align:right">
                                    <div class="muted small">Role</div>
                                    <div style="font-weight:800">User</div>
                                </div>
                            </div>
                            <div style="display:flex;gap:8px;margin-top:8px" class="profile-actions">
                                <button class=" btn btn-primary action-btn" id="editProfileBtn"><i class="bi bi-pencil-square"></i> Profile</button>
                                <button class="btn btn-ghost" id="changePassBtn"><i class="bi bi-key-fill"></i> Password</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card" style="margin-bottom:12px">
                            <strong>Contact & Info</strong>
                            <div style="margin-top:8px" id="infoBlock">
                                <div class="muted small">Phone</div>
                                <div id="displayPhone">+234 810 000 0000</div>
                                <div class="muted small">Location</div>
                                <div id="displayLocation">Lagos, Nigeria</div>
                                <div class="muted small">Member since</div>
                                <div id="displayMember">2024</div>
                            </div>
                        </div>

                        <div class="card">
                            <strong>Settings</strong>
                            <div style="margin-top:8px" class="settings">
                                <div>
                                    <div class="muted small">Dark mode</div>
                                    <div class="switch" style="margin-top:8px">
                                        <div id="darkToggle" class="toggle">
                                            <div class="knob"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="muted small">Email notifications</div>
                                    <div class="switch" style="margin-top:8px">
                                        <div id="notifyToggle" class="toggle on">
                                            <div class="knob"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Activity & profile form -->
                <section style="display:grid;grid-template-columns:1fr 420px;gap:18px">

                    <div>
                        <div class="card" data-aos="fade-up">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <strong>Recent activity</strong>
                                <div class="muted small">Showing latest 10</div>
                            </div>
                            <div class="activity" id="activityList" style="margin-top:12px"></div>

                            <div style="display:flex;justify-content:flex-end;margin-top:12px"><button id="clearActivity" class="btn btn-ghost">Clear</button></div>
                        </div>

                        <div class="card" style="margin-top:12px" data-aos="fade-up">
                            <strong>Security</strong>
                            <div style="margin-top:10px" class="muted small">Review and manage your active sessions and connected devices (demo).</div>
                            <div style="margin-top:10px;display:flex;gap:8px;justify-content:flex-end"><button class="btn btn-ghost">Sign out other sessions</button></div>
                        </div>
                    </div>

                    <aside>
                        <div class="card" data-aos="fade-up">
                            <strong>Edit profile</strong>
                            <form id="profileForm">
                                <div class="mb-1">
                                    <label class="muted small">Full name</label>
                                    <input class="form-control" name="fullname" required />
                                </div>
                                <div class="mb-1">
                                    <label class="muted small">Email</label>
                                    <input class="form-control" name="email" type="email" required />
                                </div>
                                <div class="mb-1">
                                    <label class="muted small">Phone</label>
                                    <input class="form-control" name="phone" />
                                </div>
                                <div class="mb-1">
                                    <label class="muted small">Location</label>
                                    <input class="form-control" name="location" />
                                </div>
                                <div class="mb-1">
                                    <label class="muted small">Profile photo URL</label>
                                    <input class="form-control" name="avatar" placeholder="https://..." />
                                </div>
                                <div style="display:flex;justify-content:flex-end;gap:8px"><button type="button" class="btn btn-ghost" id="resetProfile">Reset</button><button type="submit" class="btn btn-primary btn-pill">Save</button></div>
                            </form>
                        </div>

                        <div class="card" style="margin-top:12px" data-aos="fade-up">
                            <strong>Account actions</strong>
                            <div>
                                <button class="btn btn-ghost mb-1 w-100">Download data</button>
                                <button class="btn btn-error w-100" id="deleteAccount">Delete account</button>
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
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Settings.js"></script>

</body>

</html