import { CONFIG } from "./config.js";

export async function DataTransfer(url, data = {}, method = "GET") {
  const token = sessionStorage.getItem(CONFIG.TOKEN_KEY_NAME)
    ? sessionStorage.getItem(CONFIG.TOKEN_KEY_NAME)
    : "";

  const options = {
    method: method,
    headers: {
      Accept: "application/json",
      Authorization: `Bearer ${token}`,
    },
  };

  if (method !== "GET") {
    if (data instanceof FormData) {
      options.body = data; // Let browser handle Content-Type for FormData
    } else {
      options.headers["Content-Type"] = "application/json";
      options.body = JSON.stringify(data);
    }
  }

  try {
    const response = await fetch(url, options);
    return await response.json();
  } catch (error) {
    console.error("Fetch Error:", error);
    return { error: "Request failed" };
  }
}
