import Utility from "./Utility.js";

class AllRoute {
  constructor() {
    this.initialize();
  }

  initialize() {
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

new AllRoute();
