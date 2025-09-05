import { CONFIG } from "../Utils/config.js";
import Utility from "../Classes/Utility.js";
import { DataTransfer } from "../Utils/api.js";
import { clearAppData, startNewSession } from "../Utils/Session.js";

/**
 * @class AuthHelper
 * Provides utility methods for authentication forms, including loading state management.
 */
export default class AuthHelper {
  // DOM Elements
  static submitBtn = document.getElementById("submitBtn");
  static btnText = document.getElementById("btnText");
  static btnSpinner = document.getElementById("btnSpinner");

  static emailInput = document.getElementById("email");
  static emailError = document.getElementById("emailError");
  static pwError = document.getElementById("pwError");
  static password = document.getElementById("password");

  static loginForm = document.getElementById("loginForm");
  static register = document.getElementById("registerForm");
  static recoverForm = document.getElementById("recoverForm");
  static resetForm = document.getElementById("resetForm");

  static _originalLabel = null;

  /**
   * Toggle loading state for submit buttons.
   * @param {boolean} on
   */
  static setLoading(on) {
    try {
      if (!AuthHelper._originalLabel) {
        AuthHelper._originalLabel = AuthHelper.btnText?.textContent || "";
      }

      if (on) {
        AuthHelper.btnSpinner.style.display = "inline-block";
        AuthHelper.btnText.textContent = "Please wait...";
        AuthHelper.submitBtn.disabled = true;
      } else {
        AuthHelper.btnSpinner.style.display = "none";
        AuthHelper.btnText.textContent = AuthHelper._originalLabel;
        AuthHelper.submitBtn.disabled = false;
      }
    } catch (error) {
      console.error("Error toggling loading state:", error);
    }
  }
}

/**
 * @class AuthPage
 * Manages login, registration, password recovery, and reset forms.
 */
class AuthPage {
  constructor() {
    this.initialize();
  }

  /**
   * Initialize the page and bind all methods.
   */
  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  /**
   * Show/hide password toggle functionality.
   */
  showHidePassword() {
    try {
      const pwToggle = document.querySelector(".pw-toggle");
      if (!pwToggle || !AuthHelper.password) return;

      pwToggle.addEventListener("click", () => {
        const showing = AuthHelper.password.type === "text";
        AuthHelper.password.type = showing ? "password" : "text";
        pwToggle.setAttribute(
          "aria-label",
          showing ? "Show password" : "Hide password"
        );
        pwToggle.innerHTML = showing
          ? '<i class="bi bi-eye"></i>'
          : '<i class="bi bi-eye-slash"></i>';
      });
    } catch (error) {
      console.error("Error toggling password visibility:", error);
    }
  }

  /**
   * Bind login form events.
   */
  async login() {
    try {
      if (!AuthHelper.loginForm) return;

      AuthHelper.emailInput?.addEventListener("input", () =>
        Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError)
      );
      AuthHelper.password?.addEventListener("input", () =>
        Utility.validatePassword(AuthHelper.password, AuthHelper.pwError)
      );

      AuthHelper.loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const ok =
          Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError) &
          Utility.validatePassword(AuthHelper.password, AuthHelper.pwError);

        if (!ok) {
          Utility.toast("Please fix the errors in the form", "error");
          return;
        }

        AuthHelper.setLoading(true);
        const formData = Utility.toObject(new FormData(e.target));

        const { status, message, data } = await DataTransfer(
          `${CONFIG.API}/auth/login`,
          formData,
          "POST"
        );

        if (!status) {
          AuthHelper.setLoading(false);
          Utility.toast("An error has occurred", "error");
          return;
        }

        AuthHelper.setLoading(false);
        Utility.toast(message, status === 200 ? "success" : "error");

        if (status === 200) {
          await clearAppData();
          const session = await startNewSession(data.token);
          if (session.success) {
            Utility.toast("Welcome back! Redirecting...", "success");
            setTimeout(() => {
              window.location.href = `${CONFIG.BASE_URL}/dashboard/overview`;
            }, CONFIG.TIMEOUT);
          }
        }
      });
    } catch (error) {
      console.error("Error in login process:", error);
      Utility.toast("Login failed. Please try again.", "error");
      AuthHelper.setLoading(false);
    }
  }

  /**
   * Bind registration form events.
   */
  async register() {
    try {
      if (!AuthHelper.register) return;

      AuthHelper.emailInput?.addEventListener("input", () =>
        Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError)
      );
      AuthHelper.password?.addEventListener("input", () =>
        Utility.validatePassword(AuthHelper.password, AuthHelper.pwError)
      );

      AuthHelper.register.addEventListener("submit", async (e) => {
        e.preventDefault();

        const ok =
          Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError) &
          Utility.validatePassword(AuthHelper.password, AuthHelper.pwError);

        if (!ok) {
          Utility.toast("Please fix the errors in the form", "error");
          return;
        }

        AuthHelper.setLoading(true);
        const formData = Utility.toObject(new FormData(e.target));

        const { status, message } = await DataTransfer(
          `${CONFIG.API}/auth/register`,
          formData,
          "POST"
        );

        AuthHelper.setLoading(false);

        if (!status) {
          Utility.toast("An error has occurred", "error");
          return;
        }

        if (status !== 200) {
          Utility.toast(message, "error");
          return;
        }

        Utility.toast("Registration successful. Please sign in.", "success");
        await clearAppData();
        setTimeout(() => {
          window.location.href = `${CONFIG.BASE_URL}/auth/login`;
        }, CONFIG.TIMEOUT);
      });
    } catch (error) {
      console.error("Error in registration process:", error);
      Utility.toast("Registration failed. Please try again.", "error");
      AuthHelper.setLoading(false);
    }
  }

  /**
   * Bind account recovery form events.
   */
  async recoverAccount() {
    try {
      if (!AuthHelper.recoverForm) return;

      AuthHelper.emailInput?.addEventListener("input", () =>
        Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError)
      );

      AuthHelper.recoverForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const ok = Utility.validateEmail(
          AuthHelper.emailInput,
          AuthHelper.emailError
        );
        if (!ok) {
          Utility.toast("Please fix the errors in the form", "error");
          return;
        }

        AuthHelper.setLoading(true);
        const formData = Utility.toObject(new FormData(e.target));

        const { status, message } = await DataTransfer(
          `${CONFIG.API}/auth/recover`,
          formData,
          "POST"
        );

        AuthHelper.setLoading(false);

        if (status) {
          Utility.toast(message, status === 200 ? "success" : "error");
          const messageContainer = document.getElementById("message");
          if (messageContainer) {
            messageContainer.innerHTML = `<p class="bold ${
              status === 200 ? "success" : "danger"
            }">${message}</p>`;
          }
        }
      });
    } catch (error) {
      console.error("Error in account recovery:", error);
      AuthHelper.setLoading(false);
    }
  }

  /**
   * Bind password reset form events.
   */
  async resetPassword() {
    try {
      if (!AuthHelper.resetForm) return;

      AuthHelper.password?.addEventListener("input", () =>
        Utility.validatePassword(AuthHelper.password, AuthHelper.pwError)
      );

      AuthHelper.resetForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const ok = Utility.validatePassword(
          AuthHelper.password,
          AuthHelper.pwError
        );
        if (!ok) {
          Utility.toast("Please fix the errors in the form", "error");
          return;
        }

        AuthHelper.setLoading(true);
        const formData = Utility.toObject(new FormData(e.target));

        const { status, message } = await DataTransfer(
          `${CONFIG.API}/auth/reset`,
          formData,
          "POST"
        );

        AuthHelper.setLoading(false);

        if (status) {
          Utility.toast(message, status === 200 ? "success" : "error");
          if (status === 200) {
            setTimeout(() => {
              window.location.href = `${CONFIG.BASE_URL}/auth/login`;
            }, 1000);
          }
        }
      });
    } catch (error) {
      console.error("Error resetting password:", error);
      AuthHelper.setLoading(false);
    }
  }

  /**
   * Show feedback messages based on URL parameters.
   */
  pageFeedback() {
    try {
      const params = new URLSearchParams(document.location.search);
      const urlParam = params.get("f-bk");
      if (!urlParam) return;

      if (urlParam === "UNAUTHORIZED")
        Utility.toast("UNAUTHORIZED! Please sign in", "error");
      if (urlParam === "logout") Utility.toast("Logout successful", "success");
      if (urlParam === "new")
        Utility.toast("Registration Successful", "success");
    } catch (error) {
      console.error("Error showing page feedback:", error);
    }
  }
}

// Initialize authentication page
new AuthPage();
