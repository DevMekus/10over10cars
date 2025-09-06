  <?php

    use App\Utils\Utility;

    $current = Utility::currentRoute();
    $route = explode("/", $current)[1];

    ?>
  <div id="overlay"></div>
  <aside class="sidebar" id="sidebar" aria-label="Main navigation">
      <div class="brand">
          <img class="brande" src="<?= BASE_URL ?>assets/images/dark-logo.jpg" />
          <!-- <div><strong>10over10</strong>
            <div class="muted small">Admin</div>
        </div> -->
      </div>

      <nav class="nav" style="margin-top:10px">

          <a href="<?= BASE_URL; ?>dashboard/overview" class="<?= $route == "overview" ? 'active' : '' ?>"><i class="bi bi-grid"></i> Dashboard</a>
          <a href="<?= BASE_URL; ?>dashboard/verification" class="<?= $route == "verification"  ? 'active' : '' ?>"><i class="bi bi-search"></i>VIN Verifications</a>
          <a href="<?= BASE_URL; ?>dashboard/transaction" class="<?= $route == "transaction"  ? 'active' : '' ?>"><i class="bi bi-currency-dollar"></i> Transactions</a>
          <?php if ($role == 'admin'): ?>
              <a href="<?= BASE_URL; ?>dashboard/dealers" class="<?= $route == "dealers"  ? 'active' : '' ?>"><i class="bi bi-people"></i> Dealers</a>
          <?php else: ?>
              <a href="<?= BASE_URL; ?>dashboard/dealer" class="<?= $route == "dealers"  ? 'active' : '' ?>"><i class="bi bi-people"></i> Become a Dealer</a>
          <?php endif; ?>

          <?php if ($role == 'admin' || $user['company'] !== null && $user['company_status'] == 'approved'): ?>
              <a href="<?= BASE_URL; ?>dashboard/vehicles" class="<?= $route == "vehicles"  ? 'active' : '' ?>"><i class="bi bi-car-front"></i> Vehicles</a>
          <?php endif; ?>

          <?php if ($role == 'admin'): ?>
              <a href="<?= BASE_URL; ?>dashboard/report" class="<?= $route == "report"  ? 'active' : '' ?>"><i class="bi bi-file-earmark-text"></i> Reports</a>
          <?php endif; ?>


      </nav>
      <div class="account" style="margin-top:auto">
          <div class="muted small">Signed in</div>
          <div style="display:flex;gap:10px;align-items:center;margin-top:8px">
              <div style="width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,var(--primary),var(--accent));display:grid;place-items:center;color:#fff">AD</div>
              <div>
                  <div style="font-weight:700">
                      <?= Utility::truncateText(!empty($user['fullname']) ? ucfirst($user['fullname']) : ucfirst($role), 7); ?></div>
                  <div class="small muted"><?= ucfirst($role); ?></div>
              </div>
          </div>
      </div>
  </aside>