<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/reuse.php';
require_once ROOT_PATH . '/includes/header.php';

?>

<body id="Dashboard" class="notifcationPage"  data-role="<?= $role; ?>" data-userid="<?= $userid; ?>">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once "sidebar.php"; ?>
        <!-- Main area -->
        <div class="main">
            <?php require_once "navbar.php"; ?>
            <header>
                <div class="left-controls">
                    <div class="filters muted" style="margin-left:8px">
                        <select id="typeFilter" aria-label="Filter by type">
                            <option value="all">All types</option>
                            <option value="system">System</option>
                            <option value="user">User</option>
                            <option value="dealer">Dealer</option>
                            <option value="transaction">Transaction</option>
                        </select>
                        <select id="statusFilter" aria-label="Filter by status">
                            <option value="all">All</option>
                            <option value="unread">Unread</option>
                            <option value="read">Read</option>
                            <option value="archived">Archived</option>
                        </select>
                        <select id="priorityFilter" aria-label="Filter by priority">
                            <option value="all">All priorities</option>
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:10px">
                    <button id="simToggle" class="icon-btn" title="Toggle simulation" aria-pressed="false"><i class="bi bi-lightning-charge"></i></button>
                    <button id="createBtn" class="btn btn-primary btn-pill">Create</button>

                </div>
            </header>
            <main class="content">
                <section class="kpis">
                    <div class="card-dash kpi">
                        <div class="badge" style="background:linear-gradient(135deg,var(--primary),var(--accent))"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div class="muted small">Unread</div>
                            <div id="sUnread" style="font-weight:800;font-size:18px">0</div>
                        </div>
                    </div>
                    <div class="card-dash kpi">
                        <div class="badge" style="background:linear-gradient(135deg,#fbbf24,#f59e0b)"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div>
                            <div class="muted small">Alerts</div>
                            <div id="sAlerts" style="font-weight:800;font-size:18px">0</div>
                        </div>
                    </div>
                    <div class="card-dash kpi">
                        <div class="badge" style="background:linear-gradient(135deg,#60a5fa,#7dd3fc)"><i class="bi bi-gear-fill"></i></div>
                        <div>
                            <div class="muted small">System</div>
                            <div id="sSystem" style="font-weight:800;font-size:18px">0</div>
                        </div>
                    </div>
                    <div class="card-dash kpi">
                        <div class="badge" style="background:linear-gradient(135deg,#ef4444,#fb7185)"><i class="bi bi-archive-fill"></i></div>
                        <div>
                            <div class="muted small">Archived</div>
                            <div id="sArchived" style="font-weight:800;font-size:18px">0</div>
                        </div>
                    </div>
                </section>

                <section class="two-col">
                    <div>
                        <div class="card-dash" style="margin-bottom:8px;display:flex;justify-content:space-between;align-items:center">

                            <div style="display:flex;gap:10px;align-items:center">
                                <label style="display:flex;align-items:center;gap:8px"><input type="checkbox" id="selectAll"> Select</label>
                                <div class="bulk-bar" id="bulkBar" style="display:none">
                                    <button class="btn ghost" id="markRead">Mark read</button>
                                    <button class="btn ghost" id="markUnread">Mark unread</button>
                                    <button class="btn ghost" id="archive">Archive</button>
                                    <button class="btn ghost" id="del">Delete</button>
                                    <button class="btn ghost" id="exportSelected">Export CSV</button>
                                </div>
                            </div>
                            <div style="display:flex;gap:8px;align-items:center">
                                <button id="filterBtn" class="btn ghost"><i class="bi bi-funnel"></i> Filters</button>
                                <button id="loadMore" class="btn ghost">Load more</button>
                            </div>
                        </div>

                        <div class="list card" id="list" aria-live="polite"></div>

                        <div style="display:flex;justify-content:center;gap:8px;padding:10px">
                            <button id="prevPage" class="btn btn-sm btn-outline-accent">Prev</button>
                            <div id="pageInfo" class="muted small">Page 1</div><button id="nextPage" class="btn btn-sm btn-outline-accent">Next</button>
                        </div>
                    </div>

                    <aside>
                        <div class="card-dash">
                            <strong>Real-time simulation</strong>
                            <div class="muted small">Toggle demo notification injection</div>
                            <div style="display:flex;gap:8px;margin-top:8px">
                                <label style="display:flex;gap:6px;align-items:center"><input id="simEnable" type="checkbox"> Enable</label>
                                <label class="muted small">Interval (s)<input id="simInterval" type="number" min="5" value="12" style="width:70px;margin-left:6px;padding:6px;border-radius:6px;border:1px solid rgba(15,23,36,.06)"></label>
                            </div>
                        </div>

                        <div class="card-dash" style="margin-top:12px">
                            <strong>Notifications over time</strong>
                            <div class="chart-wrap"><canvas id="notifChart" height="160"></canvas></div>
                        </div>

                        <div class="card-dash" style="margin-top:12px">
                            <strong>Recent activity</strong>
                            <div class="recent-small" id="recentSmall"></div>
                        </div>
                    </aside>
                </section>
                <?php require "footer.php"; ?>

            </main>
        </div>
    </div>
    <?php require "modals.php"; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Notification.js"></script>

</body>

</html