 <nav class="navbar" id="navbar">
     <div class="navbar-brand">
         <a href="<?php echo BASE_URL;  ?>home">
             <img src="<?php echo BASE_URL; ?>assets/images/dark-logo.jpg" alt="Brand Logo" class="logo" />
         </a>
         <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button>
     </div>

     <div class="navbar-links" id="navbarLinks">
         <div class="auth-actions">

             <?php if (isset($_SESSION['role'])): ?>
                 <a href="#" class="btn btn-outline-secondary btn-sm">Dashboard</a>
             <?php endif; ?>
             <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-outline-primary btn-sm">Create Account</button>
                 <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary btn-sm">Login</a>
         </div>
         <button class="theme-toggle-btn" id="themeToggle" title="Toggle theme">🌓</button>
     </div>
 </nav>