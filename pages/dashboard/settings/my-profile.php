<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';

?>

<body class="theme-light dashboard">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>

        <section class="mt-4">
            <div class="container py-5" id="profile-page">
                <div class="page-header" data-aos="fade-down">
                    <div class="welcome">Admin Profile Management</div>
                    <p>Welcome to your dashboard to manage your account, view recent transactions, and update your preferences for a seamless experience.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Profile Overview -->
                    <div class="col-md-4">
                        <div class="card text-center" data-aos="zoom-in">
                            <div class="w-100 d-flex justify-center">
                                <img src="<?php echo $user['avatar'] ?? "https://i.pravatar.cc/40"; ?>" alt="Profile" class="profile-pic text-center mb-3">
                            </div>
                            <h5 id="adminName">John Doe</h5>
                            <p class="text-muted" id="adminRole"><?php echo $_SESSION['role'] == '1' ? 'Admin' : 'User' ?></p>

                        </div>
                    </div>

                    <!-- Profile Settings -->
                    <div class="col-md-8" data-aos="fade-down">
                        <div class="card">
                            <h2>Personal Information</h2>
                            <form id="profileForm" class="tomselect-style" data-id="<?= $user['userid']; ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="fullname" value="<?= $user['fullname']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email_address" value="<?= $user['email_address']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone_number" value="<?= $user['phone_number']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Home Address</label>
                                        <input type="text" name="home_address" value="<?= $user['home_address']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">City</label>
                                        <input type="text" name="home_city" value="<?= $user['home_city']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">State / County</label>
                                        <input type="text" name="home_state" value="<?= $user['home_state']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Country</label>
                                        <input type="text" name="country" value="<?= $user['country']; ?>">
                                    </div>
                                    <?php if ($_SESSION['role'] === "1"): ?>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Account Status</label>
                                            <?php $selected = $_SESSION['role']  ?>
                                            <?php
                                            $status = ['active', 'pending', 'suspended'];
                                            ?>
                                            <select class="form-select" name="account_status">
                                                <?php foreach ($status as $option): ?>
                                                    <option value="<?= $option; ?>" <?= $user['account_status'] == $option ? 'selected' : ''; ?>><?= ucfirst($option); ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <input type="hidden" name="account_status" value="<?= $user['account_status']; ?>" />
                                    <?php endif; ?>

                                    <?php if ($_SESSION['role'] === "1"): ?>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Role</label>
                                            <?php $selected = $_SESSION['role']  ?>
                                            <select class="form-select" name="role_id">
                                                <option value="2" <?php echo $_SESSION['role'] == '2' ? 'selected' : '' ?>>User</option>
                                                <option value="1" <?php echo $_SESSION['role'] == '1' ? 'selected' : '' ?>>Admin</option>

                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <input type="hidden" name="role_id" value="<?= $user['role_id']; ?>" />
                                    <?php endif; ?>
                                    <div class="mb-3 text-center" id="dropzone">
                                        <label
                                            for="dp-upload">
                                            <img src="<?php echo $user['avatar'] ?? "../assets/images/default.png"; ?>" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                                            profile Image
                                        </label>
                                        <input type="file" id="dp-upload" name="dp-upload" class="form-control mt-2" accept="image/jpeg, image/png, image/jpg">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabs: Security / Activity / Sessions -->
                <div class="section-card mt-4" data-aos="fade-up">
                    <ul class="nav nav-tabs" id="adminTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#activity">Activity Logs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#sessions">Active Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#security">Security</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="activity">
                            <table class="table brand-table" id="activityTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2025-06-13</td>
                                        <td>Logged in</td>
                                        <td>192.168.0.1</td>
                                    </tr>
                                    <tr>
                                        <td>2025-06-12</td>
                                        <td>Updated Profile</td>
                                        <td>192.168.0.2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="sessions">
                            <table class="table dataTable" id="sessionTable">
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>IP</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Chrome (Windows)</td>
                                        <td>192.168.0.1</td>
                                        <td>Active</td>
                                        <td><button class="btn btn-sm btn-danger">Revoke</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="security">
                            <p>Enable 2FA, change password, view recent device logins.</p>
                            <button class="btn btn-outline-accent">Enable Two-Factor Authentication</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
</body>

</html