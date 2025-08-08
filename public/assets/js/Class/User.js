import Utility from "./Utility";
import SessionManager from "./SessionManager";

export default class User {
  static user = null;
  static async getUser(id = "", route) {
    const url =
      id == ""
        ? `${Utility.API_ROUTE}/${route}/profile`
        : `${Utility.API_ROUTE}/${route}/profile/${id}`;

    return await Utility.fetchData(url);
  }

  static user_data() {
    return sessionStorage.getItem("user")
      ? JSON.parse(atob(sessionStorage.getItem("user")))
      : null;
  }

  static user_id() {
    const data = User.user_data();
    return data ? data.id : null;
  }

  static user_role() {
    const data = User.user_data();
    return data ? data.role : null;
  }

  static isLoggedIn() {
    return sessionStorage.getItem("token") ?? false;
  }

  static logout() {
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
      if (result.isConfirmed) {
        let data = new FormData();
        data.append("user", Users.user_id());

        const response = await Utility.fetchData(
          `${Utility.API_ROUTE}/logout`,
          data,
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
}
