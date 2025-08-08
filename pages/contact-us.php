<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/navbar.php';
?>

<body class="theme-light">
    <section id="contact-us" class="p-4">
        <div class="contact-section">
            <h2>Get in Touch</h2>
            <div class="contact-grid">
                <!-- Contact Form -->
                <form class="contact-form" id="contactForm">
                    <label for="name">Your Name *</label>
                    <input id="name" name="name" required />

                    <label for="email">Email Address *</label>
                    <input id="email" name="email" type="email" required />

                    <label for="message">Your Message *</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="submit">Send Message</button>
                </form>

                <!-- Info Column -->
                <div class="contact-info" id="contactInfo">
                    <h3>Our Info</h3>
                    <p><strong>Address:</strong> 123 Vehicle Ave, London</p>
                    <p><strong>Phone:</strong> <a href="tel:+44123456789">+44 1234 56789</a></p>
                    <p><strong>Email:</strong> <a href="mailto:support@verifycar.com">support@verifycar.com</a></p>
                    <p><strong>Hours:</strong> Mon–Fri 9am–6pm</p>

                    <iframe class="map" id="map"
                        src="https://www.google.com/maps/embed?pb=!1m18...etc"
                        height="250" allowfullscreen="" loading="lazy"></iframe>

                    <!-- Social Icons -->
                    <div class="social-icons" id="socialIcons">
                        <a href="#" title="Twitter" target="_blank">🐦</a>
                        <a href="#" title="Facebook" target="_blank">📘</a>
                        <a href="#" title="LinkedIn" target="_blank">💼</a>
                        <a href="#" title="Instagram" target="_blank">📸</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast notification -->
        <div class="toast" id="toast">Message sent successfully ✅</div>

    </section>
    <?php require_once ROOT_PATH . '/includes/footer-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/LandingPage.js"></script>
</body>

</html