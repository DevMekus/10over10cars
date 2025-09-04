import { decryptJsToken, loadAppData, saveAppData } from "../Utils/Session.js";
import { CONFIG } from "../Utils/config.js";
import { DataTransfer } from "../Utils/api.js";

export default class Application {
  static DATA = null;

  static STATE_LIST = [
    "Lagos",
    "Abuja (FCT)",
    "Rivers",
    "Oyo",
    "Anambra",
    "Kaduna",
  ];

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

  static debounce(fn, delay = 300) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), delay);
    };
  }

  static FAQS = [
    {
      q: "What is a VIN?",
      a: "A Vehicle Identification Number is a unique 17‑character code that identifies a specific vehicle.",
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

  static BLOG_POSTS = [
    {
      title: "How to spot a flood‑damaged car",
      tag: "Guides",
    },
    {
      title: "Negotiating car prices with data",
      tag: "Tips",
    },
    {
      title: "Importing cars to Nigeria: basics",
      tag: "Importing",
    },
  ];

  static async initializeData() {
    try {
      // Try load cached AppData
      const cached = await loadAppData();

      if (cached) {
        Application.DATA = cached;
        console.log("✅ Using cached AppData:", Application.DATA);
        return;
      }
    } catch (err) {
      console.warn("⚠️ Cached AppData invalid, will fetch fresh:", err);
    }

    // ❌ Either no cache, expired, or decryption failed → fetch fresh
    await Application.loadApplicationData();

    // reloading data
    const fresh = await loadAppData();
    Application.DATA = fresh || null;
  }

  static async loadApplicationData() {
    const currentLocation = window.location.href;
    let url;

    if (currentLocation.includes("dashboard")) {
      const token = await decryptJsToken();
      url =
        token?.role === "admin"
          ? `${CONFIG.API}/admin/application/admin/${token?.userid}`
          : `${CONFIG.API}/application/user/${token?.userid}`;
    } else {
      url = `${CONFIG.API}/application/guest`;
    }

    const { status, data } = await DataTransfer(url);
    const appData = status === 200 ? data : null;

    if (appData) {
      await saveAppData(appData);
    }

    return appData;
  }
}
