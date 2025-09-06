<?php include "topbar.php"; ?>
<!-- Navbar -->
<div class="navbar" role="navigation" aria-label="Main">
    <div class="container nav-inner">
        <a class="brand" href="<?= BASE_URL ?>">
            <img class="brand" src="<?= BASE_URL ?>assets/images/dark-logo.jpg" />
        </a>
        <nav class="nav-links" aria-label="Primary">
            <a href="#home">Home</a>
            <a href="#verify">Verify VIN</a>
            <a href="#market">Buy Cars</a>
            <a href="#pricing">Pricing</a>
            <a href="#sources">Data Sources</a>
            <a href="#faq">FAQs</a>
            <a href="#blog">Blog</a>

        </nav>
        <div class="nav-actions">
            <a href="<?= BASE_URL ?>auth/login" class="btn btn-outline-primary btn-pill">Sign In</a>
            <button class="mobile-menu-btn btn btn-outline-primary" aria-expanded="false" aria-controls="mobile-drawer"><i class="bi bi-list"></i><span class="sr-only">Menu</span></button>
        </div>
    </div>
    <div id="mobile-drawer" class="mobile-drawer container" role="region" aria-label="Mobile menu">
        <a href="#home">Home</a>
        <a href="#verify">Verify VIN</a>
        <a href="#market">Buy Cars</a>
        <a href="#sell">Sell Your Car</a>
        <a href="#pricing">Pricing</a>
        <a href="#sources">Data Sources</a>
        <a href="#faq">FAQs</a>
        <a href="#blog">Blog</a>
        <a href="#contact">Contact</a>
    </div>
</div>