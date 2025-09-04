import { CONFIG } from "./config.js";
import Utility from "../Classes/Utility.js";

export async function fetchEncryptionKey() {
  try {
    const response = await fetch(`${CONFIG.BASE_URL}/public/set-session.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        action: "config",
      }),
    });
    return await response.json();
  } catch (error) {
    console.warn("⚠️ Failed to fetch encryption key:", error);
    return null;
  }
}

export async function startNewSession(token) {
  try {
    const decryptToken = jwt_decode(token);
    const { userid, email, role } = decryptToken;

    //---Setting JS Session
    sessionStorage.setItem(CONFIG.TOKEN_KEY_NAME, token);
    sessionStorage.setItem("user", JSON.stringify({ role, userid }));

    //---Setting PHP Session
    const response = await fetch(`${CONFIG.BASE_URL}/public/set-session.php`, {
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
    });

    return await response.json();
  } catch (error) {
    console.warn("⚠️ Failed to start user session:", error);
    return null;
  }
}

export async function destroyCurrentSession() {
  console.log("called destroy");
  try {
    const response = await fetch(`${CONFIG.BASE_URL}/public/set-session.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        action: "clear",
      }),
    });
    const data = await response.json();
    console.log(data);
    if (data.success) {
      sessionStorage.clear();
      window.location.href = `${CONFIG.BASE_URL}/auth/login?f-bk=logout`;
    }
  } catch (error) {
    console.warn("⚠️ Failed to destroy user session:", error);
    return null;
  }
}

export async function decryptJsToken() {
  const storedToken = sessionStorage.getItem(CONFIG.TOKEN_KEY_NAME);

  if (!storedToken) {
    throw new Error("No token found in sessionStorage");
  }

  try {
    const decryptToken = jwt_decode(storedToken);
    return decryptToken;
  } catch (error) {
    console.warn("⚠️ Invalid token format:", error);
  }
}

export async function clearPHPProfileSession() {
  return await fetch(`${CONFIG.BASE_URL}/public/set-session.php`, {
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

export async function saveAppData(data) {
  //---Cache app data for read
  try {
    const getKey = await fetchEncryptionKey();
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
  } catch (error) {
    console.warn("⚠️ Failed to cache data:", error);
  }
}

export async function loadAppData() {
  try {
    const stored = sessionStorage.getItem(CONFIG.ENCRYPT_DATA_NAME);
    if (!stored) return null;

    const payload = JSON.parse(stored);
    const getKey = await fetchEncryptionKey();
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
  } catch (error) {
    console.warn("⚠️ Failed to load app session:", error);
    return null;
  }
}

export async function clearAppData() {
  sessionStorage.removeItem(CONFIG.ENCRYPT_DATA_NAME);
  console.warn("⚠️ App data cleared:");
}
