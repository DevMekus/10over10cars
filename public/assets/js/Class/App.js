import { CONFIG } from "../../src/Utils/config.js";
import Utility from "../../src/Classes/Utility.js";
import { DataTransfer } from "../../src/Utils/api.js";
import { destroyCurrentSession } from "../../src/Utils/Session.js";

class App {
  constructor() {
    this.initialize();
  }

  async initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  themeToggle() {
    const themeToggle = document.getElementById("themeToggle");
    const body = document.body;
    if (!themeToggle) return;

    function loadTheme() {
      const theme = localStorage.getItem("theme") || "theme-light";
      body.classList.remove("theme-light", "dark-theme");
      body.classList.add(theme);
      themeToggle.innerHTML =
        theme === "dark-theme"
          ? `<i class="bi bi-sun"></i>`
          : `<i class="bi bi-moon-stars"></i>`;
    }

    function toggleTheme() {
      const isDark = body.classList.contains("dark-theme");
      const newTheme = isDark ? "theme-light" : "dark-theme";
      body.classList.remove("dark-theme", "theme-light");
      body.classList.add(newTheme);
      localStorage.setItem("theme", newTheme);
      themeToggle.innerHTML =
        newTheme === "dark-theme"
          ? `<i class="bi bi-sun"></i>`
          : `<i class="bi bi-moon-stars"></i>`;
    }
    themeToggle.addEventListener("click", toggleTheme);
    loadTheme();
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

  user_menu() {
    const dropdown = document.getElementById("userDropdown");
    const menu = document.getElementById("dropdownMenu");
    if (!dropdown || !menu) return;

    dropdown.addEventListener("click", (e) => {
      e.stopPropagation(); // prevent body click from closing it immediately
      menu.classList.toggle("show");
    });

    // Close if clicked outside
    document.body.addEventListener("click", () => {
      menu.classList.remove("show");
    });
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

  AOSMatchMedia() {
    AOS.init({
      duration: 700,
      once: true,
      disable: () =>
        window.matchMedia("(prefers-reduced-motion: reduce)").matches,
    });
  }

  dashboardSidebarToggle() {
    const sidebar = document.getElementById("sidebar");
    const menuBtn = document.getElementById("menuBtn");
    const overlay = document.getElementById("overlay");
    if (!sidebar || !menuBtn) return;

    menuBtn.addEventListener("click", () => {
      overlay.classList.add("active");
      document.getElementById("sidebar").classList.toggle("open");
    });

    document.addEventListener("click", (e) => {
      const sb = document.getElementById("sidebar");
      if (innerWidth <= 900 && sb.classList.contains("open")) {
        if (
          !sb.contains(e.target) &&
          !document.getElementById("menuBtn").contains(e.target)
        ) {
          sb.classList.remove("open");
          overlay.classList.remove("active");
        }
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

  logout() {
    const logout = document.querySelector(".logout");
    if (!logout) return;

    logout.addEventListener("click", async () => {
      const result = await Utility.confirm("Logging out?");
      const userid = logout.dataset.id;
      if (result.isConfirmed) {
        Utility.toast("Please wait...", "info");
        const { message, status } = await DataTransfer(
          `${CONFIG.API}/auth/logout`,
          { userid },
          "POST"
        );

        Swal.fire(
          `${status == 200 ? "Success" : "Error"}`,
          `${message}`,
          `${status == 200 ? "success" : "error"}`
        );

        status == 200 && destroyCurrentSession();
      }
    });
  }
}

new App();
