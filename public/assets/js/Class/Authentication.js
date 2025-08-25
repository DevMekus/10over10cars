import Utility from "./Utility";
import SessionManager from "./SessionManager";
import User from "./User";

class Authentication {
  constructor() {
    this.page = document.querySelector(".auth-container");
    this.feedback = document.querySelector(".feedback");
    if (this.page) this.initialize();
  }

  initialize() {
    const currentPage = this.page.getAttribute("data-page");
    currentPage == "login" ? this.login() : null;
    currentPage == "signup" ? this.signup() : null;
    currentPage == "recover" ? this.recover() : null;
    currentPage == "reset" ? this.reset() : null;
    this.pageFeedback();
    sessionStorage.clear();
    sessionStorage.removeItem("token");
  }

  login() {
    const loginForm = document.querySelector("#loginForm");
    if (!loginForm) return;

    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const result = await Swal.fire({
        title: "Login Account!",
        text: "Do you wish to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
      if (result.isConfirmed) {
        const data = Utility.toObject(new FormData(e.target));

        const logIn = await Utility.fetchData(
          `${Utility.API_ROUTE}/login`,
          data,
          "POST"
        );

        if (logIn.status == 200) {
          this.setupDashboard(logIn.data.token);
          Swal.fire("Success!", `${logIn.message}`, "success");
        } else {
          Swal.fire(
            "Error!",
            `${logIn.message}` ||
              "Something went wrong while creating account.",
            "error"
          );
        }
      }
    });
  }

  async setupDashboard(data) {
    const token = jwt_decode(data);

    const session = await SessionManager.setSession({
      token: data,
      role: token.role,
      userid: token.id,
    });

    if (session.success) {
      const user = await User.getUser(token.id);
      if (user.status == 200) {
        Utility.encodeUserData(user.data);
        SessionManager.startAutoRefresh();
        window.location.href = `${Utility.APP_ROUTE}/dashboard/overview`;
      }
    }
  }

  signup() {
    const signupForm = document.getElementById("registerForm");
    if (!signupForm) return;

    signupForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const result = await Swal.fire({
        title: "New Registration!",
        text: "Do you wish to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
      if (result.isConfirmed) {
        const data = Utility.toObject(new FormData(e.target));
        const createUser = await Utility.fetchData(
          `${Utility.API_ROUTE}/register`,
          data,
          "POST"
        );

        if (createUser.status == 200) {
          Swal.fire(
            "Congratulations!",
            "Your registration was successful.",
            "success"
          );
          setTimeout(() => {
            window.location.href = `${Utility.APP_ROUTE}/auth/login`;
          }, 800);
        } else {
          Swal.fire(
            "Error!",
            `${createUser.message}` ||
              "Something went wrong while creating account.",
            "error"
          );
        }
      }
    });
  }
  recover() {
    const recoverForm = document.getElementById("recoverForm");
    if (!recoverForm) return;
    recoverForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const result = await Swal.fire({
        title: "Recover Account!",
        text: "Do you wish to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
      if (result.isConfirmed) {
        const data = Utility.toObject(new FormData(e.target));
        const response = await Utility.fetchData(
          `${Utility.API_ROUTE}/recover`,
          data,
          "POST"
        );
        if (response.status == 200) {
          Swal.fire("Success!", `${response.message}`, "success");
        } else {
          Swal.fire(
            "Error!",
            `${response.message}` ||
              "Something went wrong while creating account.",
            "error"
          );
        }
      }
    });
  }
  reset() {
    const reset_password = document.getElementById("resetPassword");
    if (!reset_password) return;

    reset_password.addEventListener("submit", async (e) => {
      e.preventDefault();

      const result = await Swal.fire({
        title: "Reset Password!",
        text: "Do you wish to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
      if (result.isConfirmed) {
        const data = Utility.toObject(new FormData(e.target));
        const response = await Utility.fetchData(
          `${Utility.API_ROUTE}/reset`,
          data,
          "POST"
        );
        if (response.status == 200) {
          Swal.fire("Success!", `${response.message}`, "success");
          setTimeout(() => {
            window.location.href = `${Utility.APP_ROUTE}/auth/login`;
          }, 800);
        } else {
          Swal.fire(
            "Error!",
            `${response.message}` ||
              "Something went wrong while creating account.",
            "error"
          );
        }
      }
    });
  }

  pageFeedback() {
    const params = new URLSearchParams(document.location.search);
    const urlParam = params.get("f-bk");
    if (!urlParam) return;

    urlParam == "UNAUTHORIZED"
      ? (this.feedback.innerHTML = `<p class="auth-error text-center bold">UNAUTHORIZED! Please sign in</p>`)
      : null;

    urlParam == "logout"
      ? (this.feedback.innerHTML = `<p class="auth-success color-green text-center bold">Logout is successful!</p>`)
      : null;

    urlParam == "new"
      ? (this.feedback.innerHTML = `<p class="auth-success color-green text-center bold">Registration successful. Please Login</p>`)
      : null;

    urlParam == "store"
      ? (this.feedback.innerHTML = `<p class="auth-success color-green text-center bold">Setup your business information</p>`)
      : null;

    urlParam == "cn"
      ? (this.feedback.innerHTML = `<p class="auth-success color-green text-center bold">Login to continue with checkout.</p>`)
      : null;
  }
}

new Authentication();
