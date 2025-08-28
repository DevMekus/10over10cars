import { CONFIG } from "../config.js";
import Utility from "./Utility.js";

export default class SessionManager {
  static async fetchEncryptionKey() {
    try {
      const response = await fetch(
        `${CONFIG.BASE_URL}/public/set-session.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
          body: JSON.stringify({
            action: "config",
          }),
        }
      );

      return await response.json();
    } catch (e) {
      console.log(e);
      console.warn("⚠️ Failed to fetch encryption key:", e);
      return null;
    }
  }

  static async startUserSession(token) {
    try {
      const decryptToken = jwt_decode(token);
      const { userid, email, role } = decryptToken;
      sessionStorage.setItem(CONFIG.TOKEN_KEY_NAME, token);
      sessionStorage.setItem("role", role);

      //---Setting PHP Session
      const response = await fetch(
        `${CONFIG.BASE_URL}/public/set-session.php`,
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
    } catch (e) {
      console.warn("⚠️ Failed to start user session:", e);
      return null;
    }
  }

  static async destroyUserSession() {
    try {
      sessionStorage.clear();
      const response = await fetch(
        `${CONFIG.BASE_URL}/public/set-session.php`,
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
        window.location.href = `${CONFIG.BASE_URL}/auth/login?f-bk=logout`;
      }
    } catch (e) {
      console.warn("⚠️ Failed to destroy user session:", e);
      return null;
    }
  }

  static async decryptAndGetToken() {
    const storedToken = sessionStorage.getItem(CONFIG.TOKEN_KEY_NAME);

    if (!storedToken) {
      throw new Error("No token found in sessionStorage");
    }

    try {
      const decryptToken = jwt_decode(storedToken);
      return decryptToken;
    } catch (e) {
      throw new Error("Invalid token format: " + e.message);
    }
  }

  static async clearPHPProfileSession() {
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

  static async saveAppData(data) {
    const getKey = await SessionManager.fetchEncryptionKey();

    if (getKey.success) {
      await Utility.encryptAndStoreArray(
        CONFIG.ENCRYPT_DATA_NAME,
        data,
        getKey.ENCRYPTION_KEY,
        {
          savedAt: new Date().toISOString(),
        }
      );
      console.log("✅ AppData cached :", data);
    }
  }

  static async loadAppData() {
    const stored = sessionStorage.getItem(CONFIG.ENCRYPT_DATA_NAME);
    if (!stored) return null;

    try {
      const payload = JSON.parse(stored);
      const getKey = await SessionManager.fetchEncryptionKey();
      if (getKey.success) {
        const decrypted = await Utility.decryptAndGetArray(
          CONFIG.ENCRYPT_DATA_NAME,
          getKey.ENCRYPTION_KEY
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
      }
    } catch (e) {
      console.warn("⚠️ Failed to load app session:", e);
      return null;
    }
  }
  static clearAppData() {
    sessionStorage.removeItem(CONFIG.ENCRYPT_DATA_NAME);
    console.warn("⚠️ App data cleared:");
  }
}
