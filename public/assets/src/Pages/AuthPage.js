import { CONFIG } from "../Utils/config.js";
import Utility from "../Classes/Utility.js";
import { DataTransfer } from "../Utils/api.js";
import { clearAppData, startNewSession } from "../Utils/Session.js";

export default class AuthHelper {
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

  static setLoading(on) {
    // Store the original label only once
    if (!AuthHelper._originalLabel) {
      AuthHelper._originalLabel = AuthHelper.btnText.textContent;
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
  }
}

class AuthPage {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  showHidePassword() {
    const pwToggle = document.querySelector(".pw-toggle");
    if (!pwToggle) return;

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
  }

  async login() {
    if (!AuthHelper.loginForm) return;

    AuthHelper.emailInput.addEventListener("input", () => {
      Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError);
    });
    AuthHelper.password.addEventListener("input", () => {
      Utility.validateEmail(AuthHelper.password, AuthHelper.pwError);
    });

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
      const formdata = Utility.toObject(new FormData(e.target));

      const { status, message, data } = await DataTransfer(
        `${CONFIG.API}/auth/login`,
        formdata,
        "POST"
      );

      if (!status) {
        Utility.toast(`An error has occurred`, "error");
        return;
      }

      AuthHelper.setLoading(false);
      Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status == 200) {
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
  }

  async register() {
    if (!AuthHelper.register) return;
    AuthHelper.emailInput.addEventListener("input", () => {
      Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError);
    });
    AuthHelper.password.addEventListener("input", () => {
      Utility.validateEmail(AuthHelper.password, AuthHelper.pwError);
    });

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
      const formdata = Utility.toObject(new FormData(e.target));

      const { status, message, data } = await DataTransfer(
        `${CONFIG.API}/auth/register`,
        formdata,
        "POST"
      );

      if (!status) {
        Utility.toast(`An error has occurred`, "error");
        return;
      }

      AuthHelper.setLoading(false);
      Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status !== 200) {
        Utility.toast(`${response.message}`, "error");
        return;
      }

      Utility.toast("Registration successful. Please sign in..", "success");
      await clearAppData();
      setTimeout(() => {
        window.location.href = `${CONFIG.BASE_URL}/auth/login`;
      }, CONFIG.TIMEOUT);
    });
  }

  async recoverAccount() {
    if (!AuthHelper.recoverForm) return;

    AuthHelper.emailInput.addEventListener("input", () => {
      Utility.validateEmail(AuthHelper.emailInput, AuthHelper.emailError);
    });

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

      if (status) {
        AuthHelper.setLoading(false);
        Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);
        document.getElementById("message").innerHTML = `<p class="bold ${
          status == 200 ? "success" : "danger"
        }">${message}</p>`;
      }
    });
  }

  async resetPassword() {
    if (!AuthHelper.resetForm) return;
    AuthHelper.password.addEventListener("input", () => {
      Utility.validatePassword(AuthHelper.password, AuthHelper.pwError);
    });

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

      if (status) {
        AuthHelper.setLoading(false);
        Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);
        status == 200 &&
          setTimeout(() => {
            window.location.href = `${CONFIG.BASE_URL}/auth/login`;
          }, 1000);
      }
    });
  }

  pageFeedback() {
    const params = new URLSearchParams(document.location.search);
    const urlParam = params.get("f-bk");
    if (!urlParam) return;

    urlParam == "UNAUTHORIZED" &&
      Utility.toast("UNAUTHORIZED! Please sign in", "error");

    urlParam == "logout" && Utility.toast("Logout successful", "success");

    urlParam == "new" && Utility.toast("Registration Successful", "success");
  }
}

new AuthPage();
