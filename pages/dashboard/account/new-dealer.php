<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';
?>

<body class="theme-light dashboard">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>dashboard/overview">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dealers</li>
            </ol>
        </nav>
        <section id="dealer">
            <!-- Hero Section -->
            <section class="hero" data-aos="fade-up">
                <div class="container">
                    <h1 class="display-5 fw-bold">Partner with Us – Become a Car Dealer</h1>
                    <p class="lead">Join our network of trusted dealers and grow your business.</p>
                    <button class="btn btn-primary btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#registerModal">Register Now</button>
                </div>
            </section>

            <!-- Why Become a Dealer -->
            <section class="py-5" data-aos="fade-up">
                <div class="container">
                    <h2 class="section-title">Why Become a Dealer?</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Access to thousands of car buyers every month</li>
                        <li class="list-group-item">Easy-to-use dealer dashboard</li>
                        <li class="list-group-item">Trusted brand presence</li>
                        <li class="list-group-item">Affordable pricing plans</li>
                    </ul>
                </div>
            </section>


            <!-- Testimonials Carousel -->
            <section class="py-5" data-aos="fade-up">
                <div class="container">
                    <h2 class="section-title">What Our Dealers Say</h2>
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="d-flex justify-content-center">
                                    <div class="w-75">
                                        <blockquote class="blockquote text-center">
                                            <p class="mb-4">“Joining this platform increased our sales by 40%. It's a game changer!”</p>
                                            <footer class="blockquote-footer">John, AutoWorld</footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="d-flex justify-content-center">
                                    <div class="w-75">
                                        <blockquote class="blockquote text-center">
                                            <p class="mb-4">“Excellent support and intuitive interface. Highly recommended.”</p>
                                            <footer class="blockquote-footer">Linda, CityCars</footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="d-flex justify-content-center">
                                    <div class="w-75">
                                        <blockquote class="blockquote text-center">
                                            <p class="mb-4">“This has helped us reach more serious buyers without stress.”</p>
                                            <footer class="blockquote-footer">Samuel, PrimeMotors</footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- FAQ -->

            <section class="py-5" data-aos="fade-up">
                <div class="container">
                    <h2 class="section-title">Frequently Asked Questions</h2>
                    <div class="accordion" id="faqAccordion"></div>
                </div>
            </section>

            <!-- Bootstrap Modal for Dealer Registration -->
            <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lgs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerModalLabel">Register as a Dealer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="dealerForm" class="custom-form">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="dealerName" class="form-label">Dealership Name</label>
                                        <input type="text" class="form-control" name="dealerName" id="dealerName" placeholder="eg: AutoMax" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" placeholder="eg: 234 Press lane avenue" class="form-control" name="address" id="address" required>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" placeholder="eg: Houston" class="form-control" name="city" id="city" required>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="state" class="form-label">State / County</label>
                                        <input type="text" class="form-control" placeholder="eg: Texas" name="state" id="state" required>
                                    </div>
                                    <input type="hidden" name="userid" value="<?= $userid; ?>" />
                                    <div class="mb-3 col-sm-6">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control" placeholder="eg: USA" name="country" id="country" required>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="location" class="form-label">Select Logo</label>
                                        <input type="file" class="form-control" name="logo" id="logo" required>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
    <script>
        // Dynamic FAQ Content
        const faqs = [{
                question: "How much does it cost to join?",
                answer: "We offer flexible and affordable plans. You can start free and upgrade later."
            },
            {
                question: "How long does approval take?",
                answer: "Dealer applications are reviewed within 24–48 hours."
            },
            {
                question: "What documents are required?",
                answer: "You'll need a valid business registration and a proof of location."
            },
        ];

        const faqContainer = document.getElementById('faqAccordion');

        faqs.forEach((faq, index) => {
            const faqItem = document.createElement('div');
            faqItem.className = 'accordion-item';
            faqItem.innerHTML = `
        <h2 class="accordion-header" id="heading${index}">
          <button class="accordion-button ${index !== 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}">
            ${faq.question}
          </button>
        </h2>
        <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" data-bs-parent="#faqAccordion">
          <div class="accordion-body">${faq.answer}</div>
        </div>
      `;
            faqContainer.appendChild(faqItem);
        });
    </script>
</body>

</html