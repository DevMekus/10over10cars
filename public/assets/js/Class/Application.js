import Utility from "./Utility";
import SessionManager from "./SessionManager";

class Application {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  // loadButtons() {
  //   document.addEventListener("DOMContentLoaded", Utility.buttonLoading());
  // }

  themeToggle() {
    const themeToggle = document.getElementById("themeToggle");
    const body = document.body;
    if (!themeToggle) return;

    function loadTheme() {
      const theme = localStorage.getItem("theme") || "theme-light";
      body.classList.remove("theme-light", "dark-theme");
      body.classList.add(theme);
      themeToggle.textContent = theme === "dark-theme" ? "☀️" : "🌙";
    }

    function toggleTheme() {
      const isDark = body.classList.contains("dark-theme");
      const newTheme = isDark ? "theme-light" : "dark-theme";
      body.classList.remove("dark-theme", "theme-light");
      body.classList.add(newTheme);
      localStorage.setItem("theme", newTheme);
      themeToggle.textContent = newTheme === "dark-theme" ? "☀️" : "🌙";
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

  logout() {
    const logout = document.querySelector(".logout");
    if (!logout) return;

    logout.addEventListener("click", async () => {
      const result = await Swal.fire({
        title: "Logging User",
        text: "You are about to log out of your account. Do you want to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Logout!",
      });
      const userid = logout.dataset.id;
      if (result.isConfirmed) {
        const response = await Utility.fetchData(
          `${Utility.API_ROUTE}/auth/logout`,
          { userid },
          "POST"
        );
        if (response) {
          if (response.status == 200) {
            Swal.fire("Logged Out !", "Clearing sessions.", "success");
            SessionManager.clearSession();
          } else {
            Swal.fire(
              "Error!",
              response.message || "Something went wrong.",
              "error"
            );
          }
        }
      }
    });
  }

  vehicle_manager_collapsible() {
    const collapsibles = document.getElementsByClassName("collapsible");
    if (!collapsibles) return;

    for (let i = 0; i < collapsibles.length; i++) {
      collapsibles[i].addEventListener("click", function () {
        this.classList.toggle("active");
        const content = this.nextElementSibling;
        content.style.display =
          content.style.display === "block" ? "none" : "block";
      });
    }
  }
}

new Application();
