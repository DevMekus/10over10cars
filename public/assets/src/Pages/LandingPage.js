import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Verification from "../Classes/Verification.js";
import { CONFIG } from "../Utils/config.js";
import PaymentChannel from "../Classes/PaymentChannel.js";

/**
 * @class LandingPage
 * Handles landing page functionality including VIN validation, hero animations,
 * mobile menu, FAQ, blog posts, pricing, payments, and marketplace car listings.
 */
class LandingPage {
  constructor() {
    this.initialize();
  }

  /** Initialize application data and run class methods */
  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  /** Validate VIN input and fetch verification results */
  vinValidation() {
    const vinForm = document.getElementById("vinForm");
    const vinInput = document.getElementById("vin");
    const vinMsg = document.getElementById("vinMsg");
    const noResult = Utility.el("noResult");
    const resultArea = Utility.el("resultArea");
    if (!vinForm) return;

    vinForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const vin = vinInput.value.trim().toUpperCase();
      //   vinMsg.innerHTML = "";
      noResult.innerHTML = "";
      resultArea.style.display = "none";

      if (!Utility.validVIN(vin)) {
        Utility.toast(
          "VIN invalid — must be 11–17 chars and not include I,O,Q",
          "error"
        );

        Utility.renderEmptyState(noResult);

        // vinMsg.style.color = "var(--accent)";
        // vinMsg.innerHTML = `<a href="#pricing" class="badge" style="border-color:#c7e8d3; color:#16a34a; font-size: 20px"><i class="bi bi-shield-check"></i> VIN looks good. Select Payment</a>`;

        return;
      }

      const result = await Verification.verificationResult(vin);
    });
  }

  /** Animate hero headline typing */
  hero_typing() {
    const domElem = document.getElementById("typed-headline");
    if (!domElem) return;
    new Typed(domElem, {
      strings: [
        "Instant Vehicle Verification by VIN in Nigeria",
        "Verify Any Vehicle Instantly",
        "Check Ownership",
        "Get History Reports",
      ],
      typeSpeed: 50,
      backSpeed: 25,
      loop: true,
    });
  }

  /** Rotate hero car images */
  hero_cars() {
    const heroImage = document.querySelector(".hero-visual .car");
    if (!heroImage) return;
    console.log("running");
    const images = [
      "https://images.unsplash.com/photo-1494905998402-395d579af36f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
      "https://images.unsplash.com/photo-1566008885218-90abf9200ddb?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
      "https://images.unsplash.com/photo-1669235219888-a0f83616aad9?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
    ];

    let currentIndex = 0;

    setInterval(() => {
      heroImage.style.opacity = 0;
      setTimeout(() => {
        currentIndex = (currentIndex + 1) % images.length;
        heroImage.innerHTML = `<img src="${images[currentIndex]}" alt="Car illustration" />`;
        heroImage.style.opacity = 1;
      }, 500); // wait for fade-out before swapping image
    }, 5000);
  }

  /** Toggle mobile menu */
  mobileMenu() {
    // ---------- Mobile Menu ----------
    const mobileBtn = document.querySelector(".mobile-menu-btn");
    const mobileDrawer = document.getElementById("mobile-drawer");
    if (!mobileDrawer) return;
    mobileBtn.addEventListener("click", () => {
      const open = mobileDrawer.classList.toggle("open");
      mobileBtn.setAttribute("aria-expanded", String(open));
    });
  }

  /** Initialize AOS animations respecting reduced motion preferences */
  AOSMatchMedia() {
    AOS.init({
      duration: 700,
      once: true,
      disable: () =>
        window.matchMedia("(prefers-reduced-motion: reduce)").matches,
    });
  }

  /** Render FAQs from Application.FAQS */
  FAQRender() {
    const faqList = document.getElementById("faqList");
    if (!faqList) return;

    Application.FAQS.forEach(({ q, a }) => {
      const item = document.createElement("div");
      item.className = "accordion-item";
      item.setAttribute("aria-expanded", "false");
      item.innerHTML = `
        <div class="accordion-header" role="button" aria-controls="acc" tabindex="0">
          <strong>${q}</strong><i class="bi bi-chevron-down"></i>
        </div>
        <div class="accordion-content" id="acc"><p>${a}</p></div>
      `;
      const header = item.querySelector(".accordion-header");
      header.addEventListener("click", () => toggleAcc(item));
      header.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          toggleAcc(item);
        }
      });
      faqList.appendChild(item);
    });

    function toggleAcc(item) {
      const open = item.getAttribute("aria-expanded") === "true";
      item.setAttribute("aria-expanded", String(!open));
    }
  }

  /** Render blog posts */
  blogPostRendering() {
    const blogGrid = document.getElementById("blogGrid");
    if (!blogGrid) return;

    Application.BLOG_POSTS.forEach((p) => {
      const el = document.createElement("article");
      el.className = "card";
      el.style.padding = "14px";
      el.innerHTML = `<span class="pill">${p.tag}</span><h3>${p.title}</h3><p class="section-sub">Read more →</p>`;
      blogGrid.appendChild(el);
    });
  }

  /** Render pricing plans with optional payment buttons */
  pricingRendering() {
    const pricingGrid = document.getElementById("pricingGrid");
    if (!pricingGrid) return;

    const buttons = pricingGrid.dataset.btn == "true" ? true : false;

    Application.PRICING_PLANS.forEach((p) => {
      const el = document.createElement("article");
      el.className = "price-card card";
      el.setAttribute("data-aos", "zoom-in");
      el.innerHTML = `
        ${
          p.popular
            ? '<span class="badge" style="position:absolute; right:12px; top:12px; border-color:#a5f3fc; color:#0369a1;"><i class="bi bi-stars"></i> Most Popular</span>'
            : ""
        }
        <h3>${Utility.toTitleCase(p.name)}</h3>
        <div class="price">${Utility.fmtNGN(
          p.price
        )} <span class="ngn">/ report</span></div>
        <ul style="color:var(--muted); padding-left:18px;">
          ${p.features.map((f) => `<li>${f}</li>`).join("")}
        </ul>
        ${
          buttons
            ? `
        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">          
          <button class="btn btn-primary btn-pill paymentBtns" 
          data-price="${p.price}" data-plan="${p.name}" data-choice="paystack"  title="Paystack (placeholder)"><i class="bi bi-credit-card"></i> Paystack</button>
          
          <button class="btn btn-ghost paymentBtns" data-price="${p.price}" data-choice="flutterwave" data-plan="${p.name}" title="Flutterwave (placeholder)"><i class="bi bi-credit-card-2-back"></i> Flutterwave</button>
        </div>
            `
            : ``
        }
      `;
      pricingGrid.appendChild(el);
    });
  }

  /** Handle payment modal form and submission */
  prepareForPayment() {
    const emailField = Utility.el("emailField");
    const params = new URLSearchParams(window.location.search);
    const vin = params.get("vin");

    if (!emailField) return;

    if (!vin) {
      Utility.toast("Vin required to continue", "error");
      setTimeout(() => {
        location.href = CONFIG.BASE_URL;
      }, CONFIG.TIMEOUT);
      return;
    }

    // Instead of attaching to each button, delegate clicks
    document.addEventListener("click", (e) => {
      const btn = e.target.closest(".paymentBtns");
      if (!btn) return;

      const amount = btn.dataset.price;
      const choice = btn.dataset.choice;
      const plan = btn.dataset.plan;

      emailField.innerHTML = `
      <form class="vinForm">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Your Information</h1>
        <div data-btn="true" data-aos="fade-up">
          <div class="form-group">
            <label class="small muted">Fullname</label>
            <input type="text" class="form-control" name="fullname" placeholder="John Doe" required />
          </div>

          <input type="hidden" name="vin" value="${vin}" required />
          <input type="hidden" name="amount" value="${amount}" required />
          <input type="hidden" name="choice" value="${choice}" required />
          <input type="hidden" name="plan" value="${plan}" required />

          <div class="form-group">
            <label class="small muted">Enter your email address</label>
            <input type="email" class="form-control" name="email_address" placeholder="you@email.com" required/>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-pill">
          Pay with ${Utility.toTitleCase(choice)}
        </button>
      </form>
    `;
    });

    // Delegate submit event
    document.addEventListener("submit", async (e) => {
      const vinForm = e.target.closest(".vinForm");
      if (!vinForm) return;

      e.preventDefault();
      const data = Utility.toObject(new FormData(vinForm));
      data.choice == "paystack"
        ? await PaymentChannel.payWithPaystack(data)
        : null;
    });
  }

  async marketPlaceRendering() {
    const carsGrid = document.getElementById("carsGrid");
    const makeSel = document.getElementById("filterMake");
    const modelSel = document.getElementById("filterModel");
    const yearSel = document.getElementById("filterYear");
    const stateInput = document.getElementById("filterState");
    const priceRange = document.getElementById("filterPrice");
    const searchInput = document.getElementById("search");
    const paginationWrap = document.getElementById("paginationWrap");

    if (!carsGrid) return;

    await Application.initializeData();
    const CARS = Application.DATA.vehicles;

    let currentPage = 1;
    const perPage = 10;

    const unique = (arr) => [...new Set(arr.filter(Boolean))];

    // ------------------ Populate Filter Options ------------------
    const populateFilters = () => {
      makeSel.innerHTML = `<option value="">All Makes</option>`;
      modelSel.innerHTML = `<option value="">All Models</option>`;
      yearSel.innerHTML = `<option value="">Any Year</option>`;

      const MAKES = unique(CARS.map((c) => c.make)).sort();
      const MODELS = unique(CARS.map((c) => c.model)).sort();
      const YEARS = unique(CARS.map((c) => Number(c.year))).sort(
        (a, b) => b - a
      );

      makeSel.innerHTML += MAKES.map((m) => `<option>${m}</option>`).join("");
      modelSel.innerHTML += MODELS.map((m) => `<option>${m}</option>`).join("");
      yearSel.innerHTML += YEARS.map((y) => `<option>${y}</option>`).join("");
    };

    // ------------------ Create Car Card ------------------
    const carCard = (car) => {
      const wrap = document.createElement("article");
      wrap.className = "car-card";
      wrap.style.cssText = `
      width:300px;
      border:1px solid #eee;
      border-radius:12px;
      overflow:hidden;
      display:flex;
      flex-direction:column;
      background:#fff;
      box-shadow:0 2px 6px rgba(0,0,0,0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    `;

      const carImage = JSON.parse(car.images)[0] || "";
      wrap.innerHTML = `
      <div class="car-media" style="width:100%;height:180px;overflow:hidden;position:relative;">
        <img src="${carImage}" alt="${
        car.title
      }" style="width:100%;height:100%;object-fit:cover;display:block;" />
        <button class="btn btn-outline btn-fav btn-sm" aria-pressed="false" style="position:absolute;top:10px;right:10px;border-radius:50%;padding:6px;">
          <i class="bi bi-heart"></i>
        </button>
      </div>
      <div class="car-body" style="flex:1;padding:12px;display:flex;flex-direction:column;gap:8px;">
        <strong style="font-size:16px;line-height:1.3;">${car.title}</strong>
        <div style="color:#666; font-size:14px;">
          ${car.year} • ${Number(car.mileage).toLocaleString()} km • ${
        car.state ?? ""
      }
        </div>
        <div style="margin-top:auto;display:flex;align-items:center;justify-content:space-between;">
          <div style="font-weight:800;font-size:16px;color:#222;">${Utility.fmtNGN(
            car.price
          )}</div>
          <a href="${CONFIG.BASE_URL}/car-detail?vin=${
        car.vin
      }" class="btn btn-primary btn-pill btn-sm">
            <i class="bi bi-eye"></i> View
          </a>
        </div>
      </div>
    `;

      // Hover effect
      wrap.addEventListener("mouseenter", () => {
        wrap.style.transform = "translateY(-4px)";
        wrap.style.boxShadow = "0 6px 12px rgba(0,0,0,0.12)";
      });
      wrap.addEventListener("mouseleave", () => {
        wrap.style.transform = "translateY(0)";
        wrap.style.boxShadow = "0 2px 6px rgba(0,0,0,0.08)";
      });

      // Favorite toggle
      const favBtn = wrap.querySelector(".btn-fav");
      favBtn.addEventListener("click", () => {
        const pressed = favBtn.getAttribute("aria-pressed") === "true";
        favBtn.setAttribute("aria-pressed", String(!pressed));
        favBtn.innerHTML = !pressed
          ? '<i class="bi bi-heart-fill" style="color:red;"></i>'
          : '<i class="bi bi-heart"></i>';
      });

      return wrap;
    };

    // ------------------ Pagination ------------------
    const paginate = (array, page) => {
      const start = (page - 1) * perPage;
      return array.slice(start, start + perPage);
    };

    const renderPagination = (total) => {
      paginationWrap.innerHTML = "";
      const pages = Math.ceil(total / perPage);
      for (let i = 1; i <= pages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = `btn btn-sm btn-outline-accent page-btn ${
          i === currentPage ? "active" : ""
        }`;
        btn.addEventListener("click", () => {
          currentPage = i;
          renderCars();
        });
        paginationWrap.appendChild(btn);
      }
    };

    // ------------------ Render Cars ------------------
    const renderCars = () => {
      carsGrid.innerHTML = "";
      const q = searchInput.value.toLowerCase();
      const stateQ = stateInput.value.toLowerCase();
      const maxPrice = Number(priceRange.value);

      const filtered = CARS.filter(
        (c) =>
          (!makeSel.value || c.make === makeSel.value) &&
          (!modelSel.value || c.model === modelSel.value) &&
          (!yearSel.value || Number(c.year) === Number(yearSel.value)) &&
          (!stateQ || (c.state ?? "").toLowerCase().includes(stateQ)) &&
          c.price <= maxPrice &&
          (!q ||
            `${c.make} ${c.model} ${c.title} ${c.state}`
              .toLowerCase()
              .includes(q))
      );

      const paged = paginate(filtered, currentPage);
      if (paged.length) paged.forEach((c) => carsGrid.appendChild(carCard(c)));
      else {
        const empty = document.createElement("div");
        empty.className = "card";
        empty.style.padding = "16px";
        empty.textContent = "No cars match your filters.";
        carsGrid.appendChild(empty);
      }

      renderPagination(filtered.length);
    };

    // ------------------ Event Listeners ------------------
    [makeSel, modelSel, yearSel, priceRange].forEach((el) =>
      el.addEventListener("change", () => {
        currentPage = 1;
        renderCars();
      })
    );

    [searchInput, stateInput].forEach((el) =>
      el.addEventListener(
        "input",
        Application.debounce(() => {
          currentPage = 1;
          renderCars();
        }, 300)
      )
    );

    populateFilters();
    renderCars();
  }

  // toggleTheNavbarDrawer() {
  //   document.addEventListener("DOMContentLoaded", () => {
  //     const menuBtn = document.querySelector(".mobile-menu-btn");
  //     const drawer = document.getElementById("mobile-drawer");
  //     const icon = menuBtn.querySelector("i");

  //     if (!menuBtn || !drawer) return;
  //     menuBtn.setAttribute("type", "button");

  //     let isOpen = false;

  //     function openDrawer() {
  //       drawer.classList.add("open");
  //       drawer.style.maxHeight = drawer.scrollHeight + "px";
  //       menuBtn.setAttribute("aria-expanded", "true");
  //       drawer.setAttribute("aria-hidden", "false");
  //       if (icon) icon.classList.replace("bi-list", "bi-x");
  //       isOpen = true;
  //     }

  //     function closeDrawer() {
  //       drawer.style.maxHeight = drawer.scrollHeight + "px"; // start from current height
  //       drawer.offsetHeight; // force reflow
  //       drawer.style.maxHeight = "0";
  //       menuBtn.setAttribute("aria-expanded", "false");
  //       drawer.setAttribute("aria-hidden", "true");
  //       if (icon) icon.classList.replace("bi-x", "bi-list");

  //       // Remove .open after transition ends
  //       drawer.addEventListener("transitionend", function handler(e) {
  //         if (e.propertyName === "max-height") {
  //           drawer.classList.remove("open");
  //           drawer.style.maxHeight = "";
  //           drawer.removeEventListener("transitionend", handler);
  //         }
  //       });

  //       isOpen = false;
  //     }

  //     menuBtn.addEventListener("click", (e) => {
  //       e.preventDefault();
  //       if (!window.matchMedia("(max-width: 880px)").matches) return;

  //       if (isOpen) closeDrawer();
  //       else openDrawer();
  //     });

  //     // Close drawer when clicking any link inside
  //     drawer.querySelectorAll("a").forEach((link) => {
  //       link.addEventListener("click", () => {
  //         if (window.matchMedia("(max-width: 880px)").matches) closeDrawer();
  //       });
  //     });

  //     // Keep drawer state consistent on resize
  //     window.addEventListener("resize", () => {
  //       if (!window.matchMedia("(max-width: 880px)").matches) {
  //         drawer.classList.remove("open");
  //         drawer.style.maxHeight = "";
  //         menuBtn.setAttribute("aria-expanded", "false");
  //         if (icon) icon.classList.replace("bi-x", "bi-list");
  //         isOpen = false;
  //       } else {
  //         if (isOpen) drawer.style.maxHeight = drawer.scrollHeight + "px";
  //         else drawer.style.maxHeight = "0";
  //       }
  //     });
  //   });
  // }
}

new LandingPage();
