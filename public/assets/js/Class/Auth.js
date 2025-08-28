import Utility from "./Utility.js";
import SessionManager from "./SessionManager.js";
import AppInit from "./Application.js";
import { CONFIG } from "../config.js";

export default class AuthStatic {
  static submitBtn = document.getElementById("submitBtn");
  static btnText = document.getElementById("btnText");
  static btnSpinner = document.getElementById("btnSpinner");
  static form = document.getElementById("loginForm");
  static emailInput = document.getElementById("email");
  static emailError = document.getElementById("emailError");
  static pwError = document.getElementById("pwError");

  static password = document.getElementById("password");

  static showToast(message, type = "info", ttl = 3500) {
    const t = document.createElement("div");
    t.className = "toast";
    t.setAttribute("role", "status");

    t.innerHTML = `<div style="font-weight:700; margin-right:8px">${
      type === "error"
        ? '<i class="bi bi-exclamation-triangle-fill"></i>'
        : '<i class="bi bi-check2-circle"></i>'
    }</div><div style="min-width:180px">${message}</div>`;
    const container = document.getElementById("toastContainer");
    container.appendChild(t);

    setTimeout(() => {
      t.style.opacity = "0";
      setTimeout(() => t.remove(), 400);
    }, ttl);
  }

  static setLoading(on) {
    if (on) {
      AuthStatic.btnSpinner.style.display = "inline-block";
      AuthStatic.btnText.textContent = "Signing in...";
      AuthStatic.submitBtn.disabled = true;
    } else {
      AuthStatic.btnSpinner.style.display = "none";
      AuthStatic.btnText.textContent = "Login";
      AuthStatic.submitBtn.disabled = false;
    }
  }
}
class Auth {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  dateHelper() {
    const el = document.getElementById("yr");
    if (!el) return;

    const yr = new Date().getFullYear();
    el.textContent = yr;
  }

  showHidePassword() {
    const pwToggle = document.querySelector(".pw-toggle");
    if (!pwToggle) return;

    pwToggle.addEventListener("click", () => {
      const showing = AuthStatic.password.type === "text";
      AuthStatic.password.type = showing ? "password" : "text";
      pwToggle.setAttribute(
        "aria-label",
        showing ? "Show password" : "Hide password"
      );
      pwToggle.innerHTML = showing
        ? '<i class="bi bi-eye"></i>'
        : '<i class="bi bi-eye-slash"></i>';
    });
  }

  formValidationLogin() {
    function validateEmail() {
      const v = AuthStatic.emailInput.value.trim();
      const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
      AuthStatic.emailError.style.display = ok ? "none" : "block";
      if (!ok)
        AuthStatic.emailError.textContent =
          "Please enter a valid email address.";
      return ok;
    }

    function validatePassword() {
      const v = AuthStatic.password.value || "";
      const ok = v.length >= 6;
      AuthStatic.pwError.style.display = ok ? "none" : "block";
      if (!ok)
        AuthStatic.pwError.textContent =
          "Password must be at least 6 characters.";
      return ok;
    }

    AuthStatic.emailInput.addEventListener("input", validateEmail);
    AuthStatic.password.addEventListener("input", validatePassword);

    AuthStatic.form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const ok = validateEmail() & validatePassword();
      if (!ok) {
        AuthStatic.showToast("Please fix the errors in the form", "error");
        return;
      }

      AuthStatic.setLoading(true);
      const data = Utility.toObject(new FormData(e.target));

      const response = await Utility.fetchData(
        `${CONFIG.API}/auth/login`,
        data,
        "POST"
      );

      if (response) {
        AuthStatic.setLoading(false);

        if (response.status !== 200) {
          AuthStatic.showToast(`${response.message}`, "error");
          return;
        }
        SessionManager.clearAppData();
        const session = await SessionManager.startUserSession(
          response.data.token
        );

        if (session.success) {
          AuthStatic.showToast("Welcome back! Redirecting...", "success");
          setTimeout(() => {
            window.location.href = `${CONFIG.BASE_URL}/dashboard/overview`;
          }, CONFIG.TIMEOUT);
        }
      }
    });
  }

  socialMediaLogin() {
    document.getElementById("googleBtn")?.addEventListener("click", () => {
      AuthStatic.showToast("Google sign-in (demo)", "info");
    });

    document.getElementById("fbBtn")?.addEventListener("click", () => {
      AuthStatic.showToast("Facebook sign-in (demo)", "info");
    });
    document.getElementById("guestBtn")?.addEventListener("click", () => {
      AuthStatic.showToast("Continuing as guest", "info");
      setTimeout(() => (window.location.href = "#market"), 600);
    });
  }

  pageFeedback() {
    const params = new URLSearchParams(document.location.search);
    const urlParam = params.get("f-bk");
    if (!urlParam) return;

    urlParam == "UNAUTHORIZED" &&
      AuthStatic.showToast("UNAUTHORIZED! Please sign in", "error");

    urlParam == "logout" &&
      AuthStatic.showToast("Logout successful", "success");

    urlParam == "new" &&
      AuthStatic.showToast("Registration Successful", "success");
  }
}

new Auth();
