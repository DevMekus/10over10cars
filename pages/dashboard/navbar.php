    <header class="topbar">
        <div style="display:flex;gap:10px;align-items:center">
            <button id="menuBtn" class="btn btn-sm btn-ghost" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
            <div class="search" role="search"><i class="bi bi-search muted"></i><input id="q" type="search" placeholder="Search VIN, Vehicle, dealer..." style="border:none;background:transparent;outline:none;padding-left:6px;flex:1" /></div>
        </div>
        <div style="display:flex;gap:10px;align-items:center">

            <button id="themeToggle" class="btn btn-sm btn-outline-accent" aria-pressed="false" title="Toggle theme"><i class="bi bi-moon-stars"></i></button>
            <a href="<?= BASE_URL; ?>dashboard/notification" id="notifBtn" class="btn btn-sm btn-ghost"><i class="bi bi-bell"></i></a>
        </div>
    </header>