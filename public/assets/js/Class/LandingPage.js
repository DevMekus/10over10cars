import Utility from "./Utility";
class LandingPage {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  hero_typing() {
    const domElem = document.getElementById("typed-headline");
    if (!domElem) return;
    new Typed(domElem, {
      strings: [
        "Verify Any Vehicle Instantly",
        "Check Ownership",
        "Get History Reports",
      ],
      typeSpeed: 50,
      backSpeed: 25,
      loop: true,
    });
  }

  hero_video_modal() {
    const demoModal = document.getElementById("demoModal");
    if (!demoModal) return;
    document
      .getElementById("demoModalButton")
      .addEventListener("click", () => demoModal.classList.add("active"));
    function closeDemoModal() {
      demoModal.classList.remove("active");
    }
  }
  hero_particles() {
    const canvas = document.querySelector(".background-animation");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    canvas.width = innerWidth;
    canvas.height = innerHeight;
    let particles = Array.from({ length: 80 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      r: Math.random() * 2,
      dx: (Math.random() - 0.5) * 0.5,
      dy: (Math.random() - 0.5) * 0.5,
    }));
    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach((p) => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = "rgba(250,200,0,0.7)";
        ctx.fill();
        p.x += p.dx;
        p.y += p.dy;
        if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
      });
      requestAnimationFrame(draw);
    }
    draw();
  }
  hero_cars() {
    const heroImage = document.querySelector(".hero-illustration img");
    if (!heroImage) return;
    const images = [
      "public/assets/images/hero-1.png",
      "public/assets/images/hero-2.png",
      "public/assets/images/hero-3.png",
    ];

    let currentIndex = 0;

    setInterval(() => {
      heroImage.style.opacity = 0;
      setTimeout(() => {
        currentIndex = (currentIndex + 1) % images.length;
        heroImage.src = images[currentIndex];
        heroImage.style.opacity = 1;
      }, 500); // wait for fade-out before swapping image
    }, 5000);
  }

  how_it_works() {
    const domElem = document.getElementById("typed-headline-works");
    if (!domElem) return;
    new Typed(domElem, {
      strings: [
        "How It Works",
        "Verify a Vehicle",
        "Check Ownership & History",
      ],
      typeSpeed: 50,
      backSpeed: 30,
      backDelay: 2000,
      loop: true,
    });
  }

  how_it_work_swiper() {
    const domElem = document.querySelector(".swiper");
    if (!domElem) return;

    const swiper = new Swiper(".swiper", {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }

  trust_benefit() {
    const statNumbers = document.querySelectorAll(".number[data-target]");
    if (!statNumbers) return;
    statNumbers.forEach((num) => {
      const target = +num.getAttribute("data-target");
      let count = 0;
      const increment = target / 100;

      const counter = setInterval(() => {
        count += increment;
        if (count >= target) {
          num.textContent = target;
          clearInterval(counter);
        } else {
          num.textContent = Math.floor(count);
        }
      }, 20);
    });
  }

  paystack_payment() {
    const domElem = document.getElementById("payButton");
    if (!domElem) return;

    document.getElementById("payButton").addEventListener("click", function () {
      const email = document.getElementById("emailInput").value;
      if (!email) {
        alert("Please enter a valid email address.");
        return;
      }

      var handler = PaystackPop.setup({
        key: "pk_test_YOUR_PUBLIC_KEY_HERE", // <-- your Paystack public key
        email: email,
        amount: 999 * 100, // Amount in kobo
        currency: "GBP",
        ref: "VERIFY-" + Date.now(),
        callback: function (response) {
          // Success — you can save transaction and redirect
          window.location.href = "/confirmation.html?ref=" + response.reference;
        },
        onClose: function () {
          alert("Transaction was not completed.");
        },
      });

      handler.openIframe();
    });
  }
  testimonial_swiper() {
    const swiperDom = document.querySelector(".testimonial-carousel");
    if (!swiperDom) return;

    const testimonialSwiper = new Swiper(".testimonial-carousel", {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      autoplay: { delay: 5000 },
      pagination: { el: ".swiper-pagination", clickable: true },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }

  contact_us_page() {
    const domElem = document.getElementById("contact-us");
    const form = document.getElementById("contactForm");
    const toast = document.getElementById("toast");

    if (!domElem) return;
    const observerOptions = {
      threshold: 0.1,
    };
    const elementsToAnimate = document.querySelectorAll(
      "h2, #contactInfo, #map, #socialIcons"
    );

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
        }
      });
    }, observerOptions);

    elementsToAnimate.forEach((el) => observer.observe(el));

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      toast.classList.add("show");
      setTimeout(() => toast.classList.remove("show"), 3000);
      form.reset();
    });
  }
}

new LandingPage();
