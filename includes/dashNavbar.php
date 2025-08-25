<?php

use App\Utils\Utility;
?>
<nav class="navbar dashboard-nav" id="navbar">
    <div class="navbar-brand">
        <img src="<?php echo BASE_URL; ?>assets/images/dark-logo.jpg" alt="Brand Logo" class="logo" />
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button>
    </div>

    <div class="navbar-links" id="navbarLinks">
        <a href="<?php echo BASE_URL; ?>dashboard/overview">Overview</a>

        <?php if ($_SESSION['role'] == '1'): ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown pointer">
                    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Account Manager
                    </div>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/account/users">Users</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/account/dealers">Dealers</a></li>

                    </ul>
                </li>

            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown pointer">
                    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Report Manager
                    </div>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/reports/theft">Theft reports</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/reports/verification-reports">Verification reports</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/reports/sales-reports">services & sales</a></li>

                    </ul>
                </li>

            </ul>
            <a href="<?php echo BASE_URL; ?>dashboard/garage/vehicles">Vehicles</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == '2'): ?>
            <a href="<?php echo BASE_URL; ?>dashboard/reports/verification-reports">Verification reports</a>
            <a href="<?php echo BASE_URL; ?>dashboard/account/new-dealer">Dealers</a>
            <a href="<?php echo BASE_URL; ?>dashboard/reports/theft">Reports</a>
        <?php endif; ?>


        <div class="search-container">
            <input type="text" placeholder="Search…" class="search-input" />
        </div>

        <div class="auth-actions">
            <?php if (isset($_SESSION['role'])): ?>
                <a href="<?= BASE_URL;  ?>" class="btn btn-outline-secondary btn-sm">Home</a>
            <?php endif; ?>
            <div class="user-dropdown" id="userDropdown">
                <img src="<?= $user['avatar'] ?? 'https://i.pravatar.cc/150?img=5' ?>" alt="User Avatar" class="user-avatar">
                <span class="user-name"><?= Utility::truncateText($user['fullname'], 7) ?? 'User'; ?></span>

                <div class="dropdown-menu" id="dropdownMenu">               
                    <a href="<?= BASE_URL;  ?>dashboard/settings/my-profile">Profile</a>
                    <a href="<?= BASE_URL;  ?>dashboard/settings/settings">Settings</a>
                    <a href="#" class="logout" data-id="<?= $userid; ?>">Logout <i class="fas fa-power-off"></i></a>
                </div>
            </div>

        </div>
        <button class="btn btn-sm btn-outline-accent" id="themeToggle" title="Toggle theme">🌓</button>
    </div>
</nav>