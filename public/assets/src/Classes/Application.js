import { decryptJsToken, loadAppData, saveAppData } from "../Utils/Session.js";
import { CONFIG } from "../Utils/config.js";
import { DataTransfer } from "../Utils/api.js";

/**
 * Application Module
 * -------------------
 * Provides global constants (pricing plans, states, FAQs, blog posts),
 * and utility methods for application-wide data handling.
 *
 * Handles:
 *  - Debouncing of functions
 *  - Application data initialization and caching
 *  - Fetching fresh data from API based on user role/context
 *
 * @module Application
 */

export default class Application {
  /**
   * Cached application data.
   * @type {object|null}
   */
  static DATA = null;

  /**
   * Supported Nigerian states.
   * @type {string[]}
   */
  static STATE_LIST = [
    "Lagos",
    "Abuja (FCT)",
    "Rivers",
    "Oyo",
    "Anambra",
    "Kaduna",
  ];

  /**
   * Pricing plans for vehicle verification services.
   * @type {Array<{name: string, price: number, features: string[], cta: string, popular?: boolean}>}
   */
  static PRICING_PLANS = [
    {
      name: "basic",
      price: 2500,
      features: ["VIN format check", "Title status", "Odometer snapshot"],
      cta: "Verify Now",
    },
    {
      name: "standard",
      price: 4500,
      features: [
        "Everything in Basic",
        "Ownership history",
        "Market value estimate",
      ],
      cta: "Verify Now",
      popular: true,
    },
    {
      name: "pro",
      price: 7000,
      features: [
        "Everything in Standard",
        "Flood/Salvage check",
        "Service records (if available)",
      ],
      cta: "Verify Now",
    },
  ];

  /**
   * Frequently Asked Questions (FAQs).
   * @type {Array<{q: string, a: string}>}
   */
  static FAQS = [
    {
      q: "What is a VIN?",
      a: "A Vehicle Identification Number is a unique 17-character code that identifies a specific vehicle.",
    },
    {
      q: "How fast is the report delivery?",
      a: "Typically instant after successful payment and verification.",
    },
    {
      q: "Which countries are supported?",
      a: "Nigeria first, with growing coverage across Africa and import markets (US/EU).",
    },
    {
      q: "Do you offer refunds?",
      a: "If we cannot generate a report after payment due to system issues, we’ll refund according to our policy.",
    },
    {
      q: "What payment methods are supported?",
      a: "Paystack and Flutterwave for cards, transfers, and wallets.",
    },
  ];

  /**
   * Blog posts metadata.
   * @type {Array<{title: string, tag: string}>}
   */
  static BLOG_POSTS = [
    { title: "How to spot a flood-damaged car", tag: "Guides" },
    { title: "Negotiating car prices with data", tag: "Tips" },
    { title: "Importing cars to Nigeria: basics", tag: "Importing" },
  ];

  /**
   * Creates a debounced version of a function.
   *
   * @param {Function} fn - The function to debounce.
   * @param {number} [delay=300] - Delay in milliseconds.
   * @returns {Function} - Debounced function.
   */
  static debounce(fn, delay = 300) {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => fn(...args), delay);
    };
  }

  /**
   * Initialize application data by attempting to load from cache,
   * falling back to fresh data from API if cache is invalid or unavailable.
   *
   * @returns {Promise<void>}
   */
  static async initializeData() {
    try {
      const cached = await loadAppData();

      if (cached) {
        Application.DATA = cached;
        console.log("✅ Using cached AppData:", Application.DATA);
        return;
      }
    } catch (err) {
      console.warn("⚠️ Cached AppData invalid, fetching fresh data:", err);
    }

    // Attempt to fetch fresh data safely
    const fresh = await Application.loadApplicationData();
    Application.DATA = fresh || null;

    if (!Application.DATA) {
      console.error(
        "❌ Failed to initialize AppData. Application.DATA is null."
      );
    }
  }

  /**
   * Fetch application data from the API.
   * Uses the user role to determine which API endpoint to call.
   *
   * @returns {Promise<object|null>} Application data or null if fetch fails.
   */
  static async loadApplicationData() {
    try {
      const currentLocation = window.location.href;
      let url;

      if (currentLocation.includes("dashboard")) {
        let token;
        try {
          token = await decryptJsToken();
        } catch (err) {
          console.error("❌ Failed to decrypt token:", err);
          return null;
        }

        url =
          token?.role === "admin"
            ? `${CONFIG.API}/admin/application/admin/${token?.userid}`
            : `${CONFIG.API}/application/user/${token?.userid}`;
      } else {
        url = `${CONFIG.API}/application/guest`;
      }

      const { status, data } = await DataTransfer(url);

      if (status === 200 && data) {
        try {
          await saveAppData(data);
        } catch (err) {
          console.error("⚠️ Failed to save AppData to cache:", err);
        }
        return data;
      } else {
        console.error(`❌ API request failed. Status: ${status}`, data);
        return null;
      }
    } catch (err) {
      console.error("❌ Unexpected error fetching application data:", err);
      return null;
    }
  }
}
