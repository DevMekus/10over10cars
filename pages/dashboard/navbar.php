    <?php

    use App\Utils\Utility;
    ?>
    <header class="topbar dashboard-nav">
        <div style="display:flex;gap:10px;align-items:center">
            <button id="menuBtn" class="btn btn-sm btn-ghost" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
            <div class="search" role="search"><i class="bi bi-search muted"></i><input id="q" type="search" placeholder="Search VIN, Vehicle, dealer..." style="border:none;background:transparent;outline:none;padding-left:6px;flex:1" /></div>
        </div>
        <div style="display:flex;gap:10px;align-items:center">
            <a href="<?= BASE_URL; ?>dashboard/notification" id="notifBtn" class="btn btn-sm btn-ghost"><i class="bi bi-bell"></i></a>
            <div class="user-dropdown" id="userDropdown">
                <img
                    src="<?= !empty($user['avatar']) ? $user['avatar'] : 'https://i.pravatar.cc/150?img=5' ?>"
                    alt="User Avatar"
                    class="user-avatar" />


                <span class="user-name">
                    <?= Utility::truncateText(!empty($user['fullname']) ? ucfirst($user['fullname']) : ucfirst($role), 7); ?>
                </span>


                <div class="dropdown-menu" id="dropdownMenu" aria-haspopup="true" aria-expanded="false">
                    <?php if ($role !== 'admin'): ?>
                        <a href="<?= BASE_URL;  ?>dashboard/profile">Profile</a>
                    <?php endif; ?>
                    <?php if ($role == 'admin'): ?>
                        <a href="<?= BASE_URL;  ?>dashboard/settings">Settings</a>
                    <?php endif; ?>
                    <div class="">
                        <a href="#" class="logout btn btn-sm w-100 btn-ghostd" data-id="<?= $userid; ?>">Logout <i class="fas fa-power-off text-error"></i></a>
                    </div>

                </div>
            </div>

            <button id="themeToggle" class="btn btn-sm btn-outline-accent" aria-pressed="false" title="Toggle theme"><i class="bi bi-moon-stars"></i></button>

        </div>
    </header>