import AppInit from "./Application.js";
import SessionManager from "./SessionManager.js";
import Utility from "./Utility.js";
import VerifyStatic from "./Verification.js";
import PaystackPayment from "./Paystack.js";

export default class landingStatic {
  static STATE_LIST = [
    "Lagos",
    "Abuja (FCT)",
    "Rivers",
    "Oyo",
    "Anambra",
    "Kaduna",
  ];
  static MOCK_CARS = [
    {
      id: "c1",
      make: "Toyota",
      model: "Corolla",
      year: 2016,
      state: "Lagos",
      mileage: 72000,
      priceNGN: 7800000,
      badges: ["Verified", "Negotiable"],
      image: "",
      title: "2016 Toyota Corolla LE",
    },
    {
      id: "c2",
      make: "Honda",
      model: "Accord",
      year: 2018,
      state: "Abuja (FCT)",
      mileage: 54000,
      priceNGN: 11500000,
      badges: ["Verified"],
      image: "",
      title: "2018 Honda Accord Sport",
    },
    {
      id: "c3",
      make: "Lexus",
      model: "RX350",
      year: 2015,
      state: "Oyo",
      mileage: 88000,
      priceNGN: 17500000,
      badges: ["New"],
      image: "",
      title: "2015 Lexus RX 350 AWD",
    },
    {
      id: "c4",
      make: "Mercedes-Benz",
      model: "C300",
      year: 2017,
      state: "Rivers",
      mileage: 63000,
      priceNGN: 16500000,
      badges: ["Verified"],
      image: "",
      title: "2017 Mercedes-Benz C300",
    },
    {
      id: "c5",
      make: "Toyota",
      model: "Camry",
      year: 2019,
      state: "Lagos",
      mileage: 41000,
      priceNGN: 14500000,
      badges: ["Verified", "Negotiable"],
      image: "",
      title: "2019 Toyota Camry SE",
    },
    {
      id: "c6",
      make: "Ford",
      model: "Edge",
      year: 2016,
      state: "Anambra",
      mileage: 99000,
      priceNGN: 9800000,
      badges: ["Verified"],
      image: "",
      title: "2016 Ford Edge SEL",
    },
  ];

  static PRICING_PLANS = [
    {
      name: "Basic",
      price: 2500,
      features: ["VIN format check", "Title status", "Odometer snapshot"],
      cta: "Verify Now",
    },
    {
      name: "Standard",
      price: 4500,
      features: [
        "Everything in Basic",
        "Ownership history",
        "Market value estimate",
      ],
      cta: "Verify Now",
      popular: true,
    },
    {
      name: "Pro",
      price: 7000,
      features: [
        "Everything in Standard",
        "Flood/Salvage check",
        "Service records (if available)",
      ],
      cta: "Verify Now",
    },
  ];

  static FAQS = [
    {
      q: "What is a VIN?",
      a: "A Vehicle Identification Number is a unique 17‑character code that identifies a specific vehicle.",
    },
    {
      q: "How fast is the report delivery?",
      a: "Typically instant after successful payment and verification.",
    },
    {
      q: "Which countries are supported?",
      a: "Nigeria first, with growing coverage across Africa and import markets (US/EU).",
    },
    {
      q: "Do you offer refunds?",
      a: "If we cannot generate a report after payment due to system issues, we’ll refund according to our policy.",
    },
    {
      q: "What payment methods are supported?",
      a: "Paystack and Flutterwave for cards, transfers, and wallets.",
    },
  ];

  static BLOG_POSTS = [
    {
      title: "How to spot a flood‑damaged car",
      tag: "Guides",
    },
    {
      title: "Negotiating car prices with data",
      tag: "Tips",
    },
    {
      title: "Importing cars to Nigeria: basics",
      tag: "Importing",
    },
  ];

  static fmtNGN = (n) =>
    new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency: "NGN",
      maximumFractionDigits: 0,
    }).format(n);

  static debounce(fn, delay = 300) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), delay);
    };
  }
}

class LandingPage {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

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

  

  vinValidation() {
    const vinForm = document.getElementById("vinForm");
    const vinInput = document.getElementById("vin");
    const vinMsg = document.getElementById("vinMsg");
    if (!vinForm) return;

    vinForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const vin = vinInput.value.trim().toUpperCase();
      const verify = VerifyStatic.verify_VIN(vin);

      if (verify) {
        vinMsg.style.color = "var(--accent)";
        vinMsg.innerHTML = `<a href="#pricing" class="badge" style="border-color:#c7e8d3; color:#16a34a; font-size: 20px"><i class="bi bi-shield-check"></i> VIN looks good. Select Payment</a>`;
      }
    });
  }

  pricingRendering() {
    const pricingGrid = document.getElementById("pricingGrid");
    if (!pricingGrid) return;

    landingStatic.PRICING_PLANS.forEach((p) => {
      const el = document.createElement("article");
      el.className = "price-card card";
      el.setAttribute("data-aos", "zoom-in");
      el.innerHTML = `
        ${
          p.popular
            ? '<span class="badge" style="position:absolute; right:12px; top:12px; border-color:#a5f3fc; color:#0369a1;"><i class="bi bi-stars"></i> Most Popular</span>'
            : ""
        }
        <h3>${p.name}</h3>
        <div class="price">${landingStatic.fmtNGN(
          p.price
        )} <span class="ngn">/ report</span></div>
        <ul style="color:var(--muted); padding-left:18px;">
          ${p.features.map((f) => `<li>${f}</li>`).join("")}
        </ul>
        <div style="display:flex; justify-content: center; gap:10px; flex-wrap:wrap; margin-top:10px;">
         
        <a href="secure/payment?p${
          p.name
        }" class="btn btn-primary vin_payment" data-price="${
        p.price
      }"><i class="bi bi-shield-lock"></i> 
        ${p.cta}</a>
          
         
        </div>
      `;
      pricingGrid.appendChild(el);
    });
  }

  VerificationPayment() {
    const btns = document.querySelectorAll(".vin_payment");
    if (!btns) return;
    btns.forEach((btn) => {
      btn.addEventListener("click", async () => {
        const getKey = await SessionManager.fetchEncryptionKey();
        if (getKey.success) {
          const key = getKey.PAYSTACK_PK;
          const paystack = new PaystackPayment({
            publicKey: key,
          });
        }
      });
    });
  }

  marketPlaceRendering() {
    const carsGrid = document.getElementById("carsGrid");
    const makeSel = document.getElementById("filterMake");
    const modelSel = document.getElementById("filterModel");
    const yearSel = document.getElementById("filterYear");
    const stateSel = document.getElementById("filterState");
    const priceRange = document.getElementById("filterPrice");
    const searchInput = document.getElementById("search");

    if (!carsGrid) return;

    const unique = (arr) => [...new Set(arr)];
    const MODELS = unique(landingStatic.MOCK_CARS.map((c) => c.model)).sort();
    const YEARS = unique(landingStatic.MOCK_CARS.map((c) => c.year)).sort(
      (a, b) => b - a
    );
    modelSel.innerHTML += MODELS.map((m) => `<option>${m}</option>`).join("");
    yearSel.innerHTML += YEARS.map((y) => `<option>${y}</option>`).join("");

    function carCard(car) {
      const wrap = document.createElement("article");
      wrap.className = "car-card";
      wrap.innerHTML = `
        <div class="car-badges">${car.badges
          .map((b) => `<span class="pill">${b}</span>`)
          .join("")}</div>
        <div class="car-media" aria-label="${
          car.title
        } image placeholder"><i class="bi bi-car-front"></i></div>
        <div class="car-body">
          <strong>${car.title}</strong>
          <div style="color:var(--muted); font-size:14px;">${
            car.year
          } • ${car.mileage.toLocaleString()} km • ${car.state}</div>
          <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
            <div style="font-weight:800;">${landingStatic.fmtNGN(
              car.priceNGN
            )}</div>
            <div class="car-actions">
              <button class="btn btn-outline btn-fav btn-sm" aria-pressed="false" title="Add to favourites"><i class="bi bi-heart"></i></button>
              <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                <input type="checkbox" class="sr-only compare" value="${
                  car.id
                }" aria-label="Compare ${car.title}">
                <i class="bi bi-columns-gap"></i> Compare
              </label>
              <button class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> View Details</button>
            </div>
          </div>
        </div>
      `;

      // fav toggle
      const favBtn = wrap.querySelector(".btn-fav");
      favBtn.addEventListener("click", () => {
        const pressed = favBtn.getAttribute("aria-pressed") === "true";
        favBtn.setAttribute("aria-pressed", String(!pressed));
        favBtn.innerHTML = !pressed
          ? '<i class="bi bi-heart-fill"></i>'
          : '<i class="bi bi-heart"></i>';
      });

      // compare
      wrap.querySelector(".compare").addEventListener("change", (e) => {
        if (e.target.checked) addToCompare(car);
        else removeFromCompare(car.id);
      });

      return wrap;
    }

    function renderCars() {
      carsGrid.innerHTML = "";
      const q = searchInput.value.toLowerCase();
      const maxPrice = Number(priceRange.value);
      const filtered = landingStatic.MOCK_CARS.filter(
        (c) =>
          (!makeSel.value || c.make === makeSel.value) &&
          (!modelSel.value || c.model === modelSel.value) &&
          (!yearSel.value || c.year === Number(yearSel.value)) &&
          (!stateSel.value || c.state === stateSel.value) &&
          c.priceNGN <= maxPrice &&
          (!q ||
            `${c.make} ${c.model} ${c.title} ${c.state}`
              .toLowerCase()
              .includes(q))
      );
      filtered.forEach((c) => carsGrid.appendChild(carCard(c)));
      if (filtered.length === 0) {
        const empty = document.createElement("div");
        empty.className = "card";
        empty.style.padding = "16px";
        empty.textContent = "No cars match your filters.";
        carsGrid.appendChild(empty);
      }
    }

    [makeSel, modelSel, yearSel, stateSel, priceRange].forEach((el) =>
      el.addEventListener("change", renderCars)
    );

    searchInput.addEventListener(
      "input",
      landingStatic.debounce(renderCars, 300)
    );

    renderCars();
  }

  compareDrawer() {
    const compareDrawer = document.getElementById("compareDrawer");
    const compareBody = document.getElementById("compareBody");
    const compareClose = document.getElementById("compareClose");
    const compareList = new Map();

    function updateCompare() {
      compareBody.innerHTML = "";
      [...compareList.values()].slice(0, 3).forEach((c) => {
        const el = document.createElement("div");
        el.className = "card";
        el.style.padding = "10px";
        el.innerHTML = `
          <strong>${c.title}</strong>
          <div style="color:var(--muted); font-size:14px;">${
            c.year
          } • ${c.mileage.toLocaleString()} km • ${c.state}</div>
          <div style="font-weight:800;">${fmtNGN(c.priceNGN)}</div>
        `;
        compareBody.appendChild(el);
      });
      compareDrawer.classList.toggle("open", compareList.size > 0);
      compareDrawer.setAttribute("aria-modal", String(compareList.size > 0));
    }

    function addToCompare(car) {
      compareList.set(car.id, car);
      updateCompare();
    }

    function removeFromCompare(id) {
      compareList.delete(id);
      updateCompare();
    }

    compareClose.addEventListener("click", () => {
      compareList.clear();
      updateCompare();
      document
        .querySelectorAll(".compare:checked")
        .forEach((cb) => (cb.checked = false));
    });
  }

  FAQRender() {
    const faqList = document.getElementById("faqList");
    if (!faqList) return;

    landingStatic.FAQS.forEach(({ q, a }) => {
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

  blogPostRendering() {
    const blogGrid = document.getElementById("blogGrid");
    if (!blogGrid) return;

    landingStatic.BLOG_POSTS.forEach((p) => {
      const el = document.createElement("article");
      el.className = "card";
      el.style.padding = "14px";
      el.innerHTML = `<span class="pill">${p.tag}</span><h3>${p.title}</h3><p class="section-sub">Read more →</p>`;
      blogGrid.appendChild(el);
    });
  }
}

new LandingPage();
