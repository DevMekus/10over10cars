import Utility from "./Utility.js";
import SessionManager from "./SessionManager.js";
import { CONFIG } from "../config.js";

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
    const currentLocation = window.location.href;
    let url;

    if (currentLocation.includes("dashboard")) {
      const token = await SessionManager.decryptAndGetToken();
      url =
        token?.role === "admin"
          ? `${CONFIG.API}/admin/application/admin`
          : `${CONFIG.API}/application/user`;
    } else {
      url = `${CONFIG.API}/application/guest`;
    }

    const { status, data } = await Utility.fetchData(url);
    const appData = status === 200 ? data : null;

    if (appData) {
      await SessionManager.saveAppData(appData);
    }

    return appData;
  }

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
  }

  async initialize() {
    await AppInit.initializeData();
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
