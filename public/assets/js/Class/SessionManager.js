import Utility from "./Utility.js";

export default class SessionManager {
  static APP_KEY = "xpr-HFJKSLLJ273839"; // random key for encrypted app data
  static SESSION_KEY = "x-29047729HJGD"; // random key for Session
  static SECRET = Utility.passPhrase;

  // --- AUTH TOKEN SESSION ---
  static async setSession(token) {
    const decryptToken = jwt_decode(token);

    const { userid, email, role } = decryptToken;
    sessionStorage.setItem(SessionManager.SESSION_KEY, token);

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
    sessionStorage.removeItem(SessionManager.APP_KEY); // also clear encrypted AppData

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

  static async unsetProfileSession() {
    return await fetch(`${Utility.APP_ROUTE}/public/set-session.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        action: "unset-p",
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

  // --- APP DATA SESSION (Encrypted) ---
  static async saveAppData(data) {
    await Utility.encryptAndStoreArray(
      SessionManager.APP_KEY,
      data,
      SessionManager.SECRET,
      {
        savedAt: new Date().toISOString(),
      }
    );
  }

  static async loadAppData() {
    const stored = sessionStorage.getItem(SessionManager.APP_KEY);
    if (!stored) return null;

    try {
      const payload = JSON.parse(stored);
      const decrypted = await Utility.decryptAndGetArray(
        SessionManager.APP_KEY,
        SessionManager.SECRET
      );

      if (!decrypted) return null;

      const now = new Date();
      const savedAt = new Date(payload.savedAt);
      const diffHours = (now - savedAt) / (1000 * 60 * 60);

      // valid only if same day and < 1 hr old
      if (now.toDateString() === savedAt.toDateString() && diffHours < 1) {
        return decrypted;
      }

      return null; // expired
    } catch (e) {
      console.warn("⚠️ Failed to load app session:", e);
      return null;
    }
  }

  static clearAppData() {
    sessionStorage.removeItem(SessionManager.APP_KEY);
  }
}
