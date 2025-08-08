 <?php
    session_start();
    ?>
 <nav class="navbar" id="navbar">
     <div class="navbar-brand">
         <img src="<?php echo BASE_URL; ?>assets/images/dark-logo.jpg" alt="Brand Logo" class="logo" />
         <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button>
     </div>

     <div class="navbar-links" id="navbarLinks">
         <a href="<?php echo BASE_URL; ?>home">Home</a>
         <a href="<?php echo BASE_URL; ?>about-us">About us </a>
         <a href="<?php echo BASE_URL; ?>about-us">Verify Vehicle </a>
         <a href="<?php echo BASE_URL; ?>services">Cars for Sale </a>

         <a href="<?php echo BASE_URL; ?>contact-us">Contact</a>

         <div class="search-container">
             <input type="text" placeholder="Search…" class="search-input" />
         </div>

         <div class="auth-actions">

             <?php if (isset($_SESSION['role'])): ?>
                 <a href="<?= BASE_URL; ?>dashboard/overview" class="btn btn-outline-secondary btn-sm">Dashboard</a>
             <?php endif; ?>
             <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-outline-primary btn-sm">Create Account</button>
                 <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary btn-sm">Login</a>
         </div>
         <button class="theme-toggle-btn" id="themeToggle" title="Toggle theme">🌓</button>
     </div>
 </nav>