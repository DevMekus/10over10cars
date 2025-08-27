import Utility from "./Utility.js";
import SessionManager from "./SessionManager.js";

export default class AppInit {
  static METHODS = ["card", "bank", "ussd", "wallet"];
  static STATUS = ["success", "pending", "failed"];
  static revenueChartInstance = null;
  static DATA = null;

  // --- INIT ---
  static async initializeData() {
    try {
      // Try load cached AppData
      const cached = await SessionManager.loadAppData();

      if (cached) {
        AppInit.DATA = cached;
        console.log("✅ Using cached AppData:", AppInit.DATA);
        return;
      }
    } catch (err) {
      console.warn("⚠️ Cached AppData invalid, will fetch fresh:", err);
    }

    // ❌ Either no cache, expired, or decryption failed → fetch fresh
    await AppInit.loadApplicationData();

    // Try load again (should succeed now)
    const fresh = await SessionManager.loadAppData();
    AppInit.DATA = fresh || null;
  }

  // --- FETCH ---
  static async loadApplicationData() {
    let url = null;
    const currentLocation = window.location.href;

    if (currentLocation.includes("dashboard")) {
      // TODO: check role and determine if User/Admin
    } else {
      // Guest
      url = `${Utility.API_ROUTE}/application/guest`;
    }

    const fetchData = await Utility.fetchData(url);
    const appData = fetchData.status === 200 ? fetchData.data : null;

    // Save encrypted + timestamp via SessionManager
    if (appData) {
      await SessionManager.saveAppData(appData);
    }

    return appData;
  }

  // ---------- Demo data ----------

  // static DATA = {
  //   verifications: [
  //     {
  //       id: "VER-" + Math.random().toString(11).slice(2, 9),
  //       vin: "2HGFB2F50DH512345",
  //       result: "Clean",
  //       source: "NIS",
  //       date: "2025-08-20",
  //       requestId: "R10001",
  //       Vehicle: {
  //         image: [
  //           "https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //           "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //         ],
  //         docs: ["registration.pdf", "insurance.jpg"],
  //         title: "Toyota Corolla",
  //         dealer: "Ace Motors",
  //         notes: "Mileage looks inconsistent.",
  //       },
  //       status: "approved",
  //       plan: "Basic",
  //     },
  //     {
  //       id: "VER-" + Math.random().toString(11).slice(2, 9),
  //       vin: "JH4KA8260MC000000",
  //       result: "Mileage anomaly",
  //       source: "InsuranceDB",
  //       date: "2025-08-18",
  //       requestId: "R10002",
  //       Vehicle: {
  //         image: [
  //           "https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //           "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //         ],
  //         docs: ["registration.pdf", "insurance.jpg"],
  //         title: "Toyota Corolla",
  //         dealer: "Ace Motors",
  //         notes: "Mileage looks inconsistent.",
  //       },
  //       status: "pending",
  //       plan: "Standard",
  //     },
  //     {
  //       id: "VER-" + Math.random().toString(11).slice(2, 9),
  //       vin: "1FTFW1E11AKD00000",
  //       result: "Stolen (flagged)",
  //       source: "Police",
  //       date: "2025-08-15",
  //       requestId: "R10003",
  //       Vehicle: {
  //         image: [
  //           "https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //           "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //         ],
  //         docs: ["registration.pdf", "insurance.jpg"],
  //         title: "Toyota Corolla",
  //         dealer: "Ace Motors",
  //         notes: "Mileage looks inconsistent.",
  //       },
  //       status: "declined",
  //       plan: "Pro",
  //     },
  //     {
  //       id: "VER-" + Math.random().toString(11).slice(2, 9),
  //       vin: "3FA6P0H74HR000000",
  //       result: "Clean",
  //       source: "Auction",
  //       date: "2025-08-12",
  //       requestId: "R10004",
  //       Vehicle: {
  //         image: [
  //           "https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //           "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //         ],
  //         docs: ["registration.pdf", "insurance.jpg"],
  //         title: "Toyota Corolla",
  //         dealer: "Ace Motors",
  //         notes: "Mileage looks inconsistent.",
  //       },
  //       status: "approved",
  //       plan: "Basic",
  //     },
  //     {
  //       id: "VER-" + Math.random().toString(11).slice(2, 9),
  //       vin: "KMHCT4AE1DU000000",
  //       result: "Accident history",
  //       source: "InsuranceDB",
  //       date: "2025-08-09",
  //       requestId: "R10005",
  //       Vehicle: {
  //         image: [
  //           "https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //           "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
  //         ],
  //         docs: ["registration.pdf", "insurance.jpg"],
  //         title: "Toyota Corolla",
  //         dealer: "Ace Motors",
  //         notes: "Mileage looks inconsistent.",
  //       },
  //       status: "approved",
  //       plan: "Pro",
  //     },
  //   ],
  //   vehicles: [
  //     {
  //       id: "VH-" + Math.random().toString(11),
  //       title: "2016 Toyota Corolla",
  //       price: 7800000,
  //       mileage: 72000,
  //       state: "Lagos",
  //       vin: "2HGFB2F50DH512345",
  //       status: "rejected",
  //       image: "https://source.unsplash.com/600x400/?toyota,corolla",
  //       make: "Toyota",
  //       model: "Corolla",
  //       year: "2012",
  //       owner: "AutoHub",
  //       notes: "Clean title, verified mileage.",
  //       date: "2025-08-20",
  //     },
  //     {
  //       id: "VH-" + Math.random().toString(11),
  //       title: "2018 Honda Accord",
  //       price: 11500000,
  //       mileage: 54000,
  //       state: "Abuja (FCT)",
  //       vin: "JH4KA8260MC000000",
  //       status: "approved",
  //       image: "https://source.unsplash.com/600x400/?honda,accord",
  //       make: "Toyota",
  //       model: "Corolla",
  //       year: "2012",
  //       date: "2025-08-20",
  //       owner: "AutoHub",
  //       notes: "Clean title, verified mileage.",
  //     },
  //     {
  //       id: "VH-" + Math.random().toString(11),
  //       title: "2015 Lexus RX 350",
  //       price: 17500000,
  //       mileage: 88000,
  //       state: "Oyo",
  //       vin: "1FTFW1E11AKD00000",
  //       status: "sold",
  //       image: "https://source.unsplash.com/600x400/?lexus,rx350",
  //       make: "Toyota",
  //       model: "Corolla",
  //       year: "2012",
  //       owner: "AutoHub",
  //       notes: "Clean title, verified mileage.",
  //       date: "2025-08-20",
  //     },
  //     {
  //       id: "VH-" + Math.random().toString(11),
  //       title: "2015 Lexus RX 350",
  //       price: 17500000,
  //       mileage: 88000,
  //       state: "Oyo",
  //       vin: "1FTFW1E11AKD00000",
  //       status: "sold",
  //       image: "https://source.unsplash.com/600x400/?lexus,rx350",
  //       make: "Toyota",
  //       model: "Corolla",
  //       year: "2012",
  //       owner: "AutoHub",
  //       notes: "Clean title, verified mileage.",
  //       date: "2025-08-20",
  //     },
  //     {
  //       id: "VH-" + Math.random().toString(11),
  //       title: "2015 Lexus RX 350",
  //       price: 17500000,
  //       mileage: 88000,
  //       state: "Oyo",
  //       vin: "1FTFW1E11AKD00000",
  //       status: "sold",
  //       image: "https://source.unsplash.com/600x400/?lexus,rx350",
  //       make: "Toyota",
  //       model: "Corolla",
  //       year: "2012",
  //       owner: "AutoHub",
  //       notes: "Clean title, verified mileage.",
  //       date: "2025-08-20",
  //     },
  //   ],
  //   dealers: [
  //     {
  //       id: "d1",
  //       company: "Ace Motors",
  //       contact: "ace@example.com",
  //       status: "pending",
  //       phone: "273633838",
  //       state: "Enugu",
  //       listings: Math.floor(Math.random() * 38),
  //       rating: (3 + Math.random() * 2).toFixed(1),
  //       banner: `https://images.unsplash.com/photo-1549921296-3b4a4f6d6df8?q=80&w=1200&auto=format&fit=crop`,
  //       avatar: `https://i.pravatar.cc/150?img=${
  //         ((3 + Math.random() * 2).toFixed(1) % 70) + 1
  //       }`,
  //       about:
  //         "Trusted dealer with nationwide delivery and transparent history checks.",
  //       joined: new Date(
  //         Date.now() - (3 + Math.random() * 2).toFixed(1) * 86400000 * 7
  //       )
  //         .toISOString()
  //         .slice(0, 10),
  //       revenue: 13000,
  //       active: true,
  //     },
  //     {
  //       id: "d2",
  //       company: "Prime Autos",
  //       contact: "prime@example.com",
  //       status: "pending",
  //       phone: "273633838",
  //       state: "Enugu",
  //       listings: Math.floor(Math.random() * 38),
  //       rating: (3 + Math.random() * 2).toFixed(1),
  //       banner: `https://images.unsplash.com/photo-1549921296-3b4a4f6d6df8?q=80&w=1200&auto=format&fit=crop`,
  //       avatar: `https://i.pravatar.cc/150?img=${
  //         ((3 + Math.random() * 2).toFixed(1) % 70) + 1
  //       }`,
  //       about:
  //         "Trusted dealer with nationwide delivery and transparent history checks.",
  //       joined: new Date(
  //         Date.now() - (3 + Math.random() * 2).toFixed(1) * 86400000 * 7
  //       )
  //         .toISOString()
  //         .slice(0, 10),
  //       revenue: 15000,
  //       active: false,
  //     },
  //   ],
  //   txns: [
  //     {
  //       id: "TXN-490676-4325",
  //       amount: 2500,
  //       status: "success",
  //       date: "2025-08-20",
  //       user: "Dealer 0",
  //       method: "card",
  //       notes: "Refunded previously",
  //       logs: "Logs and receipt links (demo)",
  //       desc: "VIN verification",
  //     },
  //     {
  //       id: "TXN-490676-4324",
  //       amount: 4500,
  //       status: "success",
  //       date: "2025-08-19",
  //       user: "Dealer 0",
  //       method: "card",
  //       notes: "Refunded previously",
  //       logs: "Logs and receipt links (demo)",
  //       desc: "VIN verification",
  //     },
  //     {
  //       id: "TXN-490676-4323",
  //       amount: 7000,
  //       status: "pending",
  //       date: "2025-08-17",
  //       user: "Dealer 0",
  //       method: "wallet",
  //       notes: "Refunded previously",
  //       logs: "Logs and receipt links (demo)",
  //       desc: "Dealer subscription",
  //     },
  //     {
  //       id: "TXN-490676-4322",
  //       amount: 2500,
  //       status: "failed",
  //       date: "2025-08-10",
  //       user: "Dealer 0",
  //       method: "ussd",
  //       notes: "Refunded previously",
  //       logs: "Logs and receipt links (demo)",
  //       desc: "Premium report",
  //     },
  //     {
  //       id: "TXN-490676-4321",
  //       amount: 2500,
  //       status: "failed",
  //       date: "2025-07-30",
  //       user: "Dealer 0",
  //       method: "bank",
  //       notes: "Refunded previously",
  //       logs: "Logs and receipt links (demo)",
  //       desc: "Dealer subscription",
  //     },
  //   ],
  //   loginActivity: [
  //     {
  //       id: "288HJS",
  //       type: "VIN",
  //       title: "Verified VIN 2HGFB2F...",
  //       status: "success",
  //       when: "2025-08-20 09:12",
  //       ip: "41.242.12.5",
  //       device: "Chrome on Windows",
  //     },
  //     {
  //       id: "288HJS",
  //       type: "VIN",
  //       title: "Verified VIN 2HGFB2F...",
  //       status: "success",
  //       when: "2025-08-18 22:01",
  //       ip: "197.210.12.9",
  //       device: "Safari on iPhone",
  //     },
  //     {
  //       id: "288HJS",
  //       type: "VIN",
  //       title: "Verified VIN 2HGFB2F...",
  //       status: "success",
  //       when: "2025-08-14 11:12",
  //       ip: "41.242.45.1",
  //       device: "Firefox on MacOS",
  //     },
  //   ],
  //   profile: {
  //     fullname: "Nnaemeka N.",
  //     email: "nnaemeka@example.com",
  //     phone: "+2348100000000",
  //     location: "Lagos, NG",
  //     avatar: "https://placehold.co/600x400?text=Profile+photo",
  //     role: "User",
  //     memberSince: 2024,
  //   },
  //   notification: [
  //     {
  //       id: AppInit.uid("N"),
  //       title: "system",
  //       message: "This is a demo notification #",
  //       type: "system",
  //       priority: "high",
  //       source: "system",
  //       timestamp: new Date(new Date()).toISOString(),
  //       read: 0,
  //       archived: false,
  //     },
  //     {
  //       id: AppInit.uid("N"),
  //       title: "dealer",
  //       message: "This is a demo notification #",
  //       type: "system",
  //       priority: "low",
  //       source: "system",
  //       timestamp: new Date(new Date()).toISOString(),
  //       read: 0,
  //       archived: false,
  //     },
  //     {
  //       id: AppInit.uid("N"),
  //       title: "user",
  //       message: "This is a demo notification #",
  //       type: "system",
  //       priority: "normal",
  //       source: "system",
  //       timestamp: new Date(new Date()).toISOString(),
  //       read: 0,
  //       archived: false,
  //     },
  //   ],
  // };

  static fmtNGN(n) {
    return "NGN " + Number(n).toLocaleString();
  }

  static uid(prefix = "N") {
    return prefix + Math.random().toString(36).slice(2, 9).toUpperCase();
  }

  static fmt(n) {
    return Number(n).toLocaleString();
  }

  static toast(msg, type = "info", ttl = 3000) {
    const t = document.createElement("div");
    t.className = "toast";
    t.innerHTML = `<div style="font-weight:700">${
      type === "error"
        ? '<i class="bi bi-exclamation-triangle-fill"></i>'
        : '<i class="bi bi-check2-circle"></i>'
    }</div><div style="margin-left:8px">${msg}</div>`;
    document.getElementById("toastWrap")?.appendChild(t);
    setTimeout(() => t.remove(), ttl);
  }

  static PAGE = 1;
  static PER_PAGE = 8;

  static pageCount(REQUESTS) {
    return Math.ceil(REQUESTS.length / AppInit.PER_PAGE);
  }

  static HISTORY_KEY = "10ov10_vin_history_v1";

  static loadHistory() {
    try {
      return JSON.parse(localStorage.getItem(AppInit.HISTORY_KEY)) || [];
    } catch (e) {
      return [];
    }
  }

  static saveHistory(arr) {
    localStorage.setItem(AppInit.HISTORY_KEY, JSON.stringify(arr));
  }

  static validVIN(v) {
    if (!v) return false;
    const s = v.toUpperCase().trim();
    if (s.length < 11 || s.length > 17) return false;
    if (/[IOQ]/.test(s)) return false;
    if (!/^[A-Z0-9]+$/.test(s)) return false;
    return true;
  }

  static mockLookup(vin) {
    return new Promise((res) => {
      setTimeout(() => {
        // Generate deterministic-ish mock by hashing vin char codes
        let score = 0;
        for (let i = 0; i < vin.length; i++) score += vin.charCodeAt(i);
        const clean = score % 5 !== 0; // some flagged
        const price = 3000000 + (score % 12) * 500000;
        const year = 2005 + (score % 18);
        const mileage = 20000 + (score % 120) * 1000;
        const engine = [
          "2.0L I4",
          "2.4L I4",
          "3.5L V6",
          "2.0L Turbo",
          "3.0L Diesel",
        ][score % 5];
        const owner = ["Private", "Dealer", "Fleet", "Imported"][score % 4];
        const history = [];
        const events = [
          "No accidents recorded",
          "Minor accident (rear)",
          "Salvage title",
          "Mileage rollback suspected",
          "Multiple owners",
        ];
        for (let i = 0; i < 3; i++) {
          if ((score + i * 7) % 4 === 0)
            history.push(events[(score + i) % events.length]);
        }
        res({
          vin,
          title: `<a class="active-link" href="${Utility.APP_ROUTE}/secure/verified?ids=${vin}">${year} MockMake MockModel</a>`,
          price,
          year,
          mileage,
          engine,
          owner,
          clean,
          history,
          raw: {
            score,
          },
        });
      }, 700 + Math.random() * 900);
    });
  }

  static escapeHtml(s) {
    return String(s)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;");
  }

  static hashCode(s) {
    let h = 0;
    for (let i = 0; i < s.length; i++) {
      h = (h << 5) - h + s.charCodeAt(i);
      h |= 0;
    }
    return h;
  }
}

class Application {
  constructor() {
    this.initialize();
    //AppInit.initializeData();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  // loadButtons() {
  //   document.addEventListener("DOMContentLoaded", Utility.buttonLoading());
  // }

  themeToggle() {
    const root = document.documentElement;
    const themeBtn = document.getElementById("themeToggle");

    if (!themeBtn) return;

    function setTheme(mode) {
      root.setAttribute("data-theme", mode);
      localStorage.setItem("theme", mode);
      themeBtn.setAttribute("aria-pressed", String(mode === "dark"));
      themeBtn.innerHTML =
        mode === "dark"
          ? '<i class="bi bi-sun"></i>'
          : '<i class="bi bi-moon-stars"></i>';
    }
    setTheme(
      localStorage.getItem("theme") ||
        (window.matchMedia("(prefers-color-scheme: dark)").matches
          ? "dark"
          : "light")
    );
    themeBtn.addEventListener("click", () =>
      setTheme(root.getAttribute("data-theme") === "dark" ? "light" : "dark")
    );
  }

  nav_onScroll() {
    const navbar = document.getElementById("navbar");
    if (!navbar) return;
    // Shrink on scroll
    window.addEventListener("scroll", () => {
      if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
      } else {
        navbar.classList.remove("scrolled");
      }
    });
  }

  nav_onMobile() {
    const menuToggle = document.getElementById("menuToggle");
    const navbarLinks = document.getElementById("navbarLinks");
    if (!menuToggle || !navbarLinks) return;

    // Toggle mobile menu
    menuToggle.addEventListener("click", () => {
      navbarLinks.classList.toggle("open");
    });
  }

  backToTheTop() {
    const backBtn = document.getElementById("backToTop");
    if (!backBtn) return;
    window.addEventListener("scroll", () => {
      backBtn.style.display = window.scrollY > 600 ? "inline-flex" : "none";
    });
    backBtn.addEventListener("click", () =>
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      })
    );
  }

  COOKIEManagement() {
    const cookieBanner = document.getElementById("cookieBanner");
    if (!cookieBanner) return;
    const COOKIE_KEY = "cookie-consent-10over10";
    if (!localStorage.getItem(COOKIE_KEY)) cookieBanner.style.display = "block";

    document.getElementById("cookieAccept").addEventListener("click", () => {
      localStorage.setItem(COOKIE_KEY, "accepted");
      cookieBanner.remove();
    });
    document.getElementById("cookieDecline").addEventListener("click", () => {
      localStorage.setItem(COOKIE_KEY, "declined");
      cookieBanner.remove();
    });
  }
  footerYear() {
    const domElem = document.getElementById("year");
    if (!domElem) return;
    domElem.textContent = new Date().getFullYear();
  }

  closeToastWithESCKey() {
    // Accessibility: close toasts with Escape
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        document.querySelectorAll(".toast")?.forEach((t) => t.remove());
      }
    });
  }

  dashboardSidebarToggle() {
    const sidebar = document.getElementById("sidebar");
    const menuBtn = document.getElementById("menuBtn");
    if (!sidebar || !menuBtn) return;

    menuBtn.addEventListener("click", () =>
      document.getElementById("sidebar").classList.toggle("open")
    );
    document.addEventListener("click", (e) => {
      const sb = document.getElementById("sidebar");
      if (innerWidth <= 900 && sb.classList.contains("open")) {
        if (
          !sb.contains(e.target) &&
          !document.getElementById("menuBtn").contains(e.target)
        )
          sb.classList.remove("open");
      }
    });
  }

  closeAllModalWithEsc() {
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        document
          .querySelectorAll(".modal.open")
          .forEach((m) => m.classList.remove("open"));
      }
    });
  }
}

new Application();
