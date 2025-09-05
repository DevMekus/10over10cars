import { CONFIG } from "./config.js";

/**
 * DataTransfer.js
 * A utility function to perform API requests using Fetch API
 * with support for GET/POST/PUT/DELETE methods, FormData, JSON payloads,
 * and Authorization via session token.
 *
 * @param {string} url - The API endpoint
 * @param {Object|FormData} data - The request payload (optional)
 * @param {string} method - HTTP method (GET, POST, PUT, DELETE, etc.)
 * @returns {Promise<Object>} - JSON response or error object
 */

export async function DataTransfer(url, data = {}, method = "GET") {
  try {
    if (!url) throw new Error("URL is required for DataTransfer.");

    // Retrieve token from session storage
    const token = sessionStorage.getItem(CONFIG.TOKEN_KEY_NAME) || "";

    // Initialize fetch options
    const options = {
      method: method.toUpperCase(),
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
    };

    // Add body for non-GET requests
    if (method.toUpperCase() !== "GET") {
      if (data instanceof FormData) {
        options.body = data; // Browser sets Content-Type automatically for FormData
      } else {
        options.headers["Content-Type"] = "application/json";
        options.body = JSON.stringify(data);
      }
    }

    // Perform fetch request
    const response = await fetch(url, options);

    // Check for HTTP errors
    if (!response.ok) {
      const errorText = await response.text();
      console.error(`HTTP Error: ${response.status} - ${errorText}`);
      return { error: `Request failed with status ${response.status}` };
    }

    // Parse JSON response
    const result = await response.json();
    return result;
  } catch (error) {
    console.error("DataTransfer Error:", error);
    return { error: error.message || "Request failed" };
  }
}
