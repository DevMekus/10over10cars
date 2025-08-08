import Utility from "./Utility";

export default class SessionManager {
  static async setSession({ token, role, userid }) {
    sessionStorage.setItem("token", token);

    try {
      const response = await fetch(
        `${Utility.APP_ROUTE}/public/set-session.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
          body: JSON.stringify({
            action: "set",
            token,
            role,
            userid,
          }),
        }
      );

      return await response.json();
    } catch (error) {
      console.error("Error:", error);
    }
  }

  static async clearSession() {
    sessionStorage.removeItem("token");
    sessionStorage.removeItem("user");

    const response = await fetch(
      `${Utility.APP_ROUTE}/public/set-session.php`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify({
          action: "clear",
        }),
      }
    );
    const data = await response.json();

    // Stop auto-refresh
    if (data.success) {
      clearInterval(SessionManager._refreshInterval);
      window.location.href = `${Utility.APP_ROUTE}/auth/login?f-bk=logout`;
    }
  }

  static getToken() {
    return sessionStorage.getItem("token");
  }

  static async refreshSession() {
    return await fetch(`${Utility.APP_ROUTE}/public/set-session.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        action: "refresh",
      }),
    }).then((res) => res.json());
  }

  static startAutoRefresh() {
    if (SessionManager._refreshInterval) {
      clearInterval(SessionManager._refreshInterval);
    }

    // Refresh every 10 minutes (600000 ms)
    SessionManager._refreshInterval = setInterval(() => {
      SessionManager.refreshSession();
    }, 600000);
  }
}
