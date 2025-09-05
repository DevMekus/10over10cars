import { CONFIG } from "../Utils/config.js";

/**
 * Utility Class
 * -----------------------------
 * A collection of helper methods for encryption, storage, formatting, validation,
 * DOM manipulation, UI utilities, and client-side data handling.
 *
 * This class provides reusable static methods to:
 * - Handle cryptographic operations (encryption, decryption, key derivation).
 * - Manage user data (encode, decode, validation).
 * - Support UI feedback (toast notifications, loaders, skeletons, modals).
 * - Format numbers, dates, and text consistently.
 * - Export and print data (CSV, PDF, print views).
 * - Provide pagination and empty state rendering.
 *
 * All methods include strict error handling to prevent application crashes.
 */

export default class Utility {
  // ------------------------------
  // Static Properties
  // ------------------------------
  static PAGE = 1;
  static PER_PAGE = 10;
  static userRole = document.body.dataset.role || null;
  static userid = document.body.dataset.id || null;

  /**
   * Shortcut for getElementById
   * @param {string} id
   * @returns {HTMLElement|null}
   */
  static el(id) {
    try {
      return document.getElementById(id);
    } catch (err) {
      console.error(`Error getting element by ID "${id}":`, err);
      return null;
    }
  }

  // ------------------------------
  // Encoding / Encryption Helpers
  // ------------------------------

  /** Convert string to ArrayBuffer */
  static strToBuffer(str) {
    try {
      return new TextEncoder().encode(str);
    } catch (err) {
      console.error("Error converting string to buffer:", err);
      return null;
    }
  }

  /** Convert ArrayBuffer to Base64 string */
  static bufToBase64(buf) {
    try {
      return btoa(String.fromCharCode(...new Uint8Array(buf)));
    } catch (err) {
      console.error("Error converting buffer to base64:", err);
      return "";
    }
  }

  /** Convert Base64 string to Uint8Array */
  static base64ToBuf(b64) {
    try {
      return Uint8Array.from(atob(b64), (c) => c.charCodeAt(0));
    } catch (err) {
      console.error("Error converting base64 to buffer:", err);
      return new Uint8Array();
    }
  }

  /**
   * Derive AES-GCM key using PBKDF2
   * @param {string} passphrase
   * @param {Uint8Array} salt
   * @returns {Promise<CryptoKey|null>}
   */
  static async deriveKey(passphrase, salt) {
    try {
      const baseKey = await crypto.subtle.importKey(
        "raw",
        Utility.strToBuffer(passphrase),
        { name: "PBKDF2" },
        false,
        ["deriveKey"]
      );

      return await crypto.subtle.deriveKey(
        {
          name: "PBKDF2",
          salt: salt,
          iterations: 100000,
          hash: "SHA-256",
        },
        baseKey,
        { name: "AES-GCM", length: 256 },
        false,
        ["encrypt", "decrypt"]
      );
    } catch (err) {
      console.error("Error deriving key:", err);
      return null;
    }
  }

  /**
   * Encrypt array data and store in sessionStorage
   * @param {string} keyName
   * @param {Array} arrayData
   * @param {string} passphrase
   * @param {Object} meta
   */
  static async encryptAndStoreArray(keyName, arrayData, passphrase, meta = {}) {
    try {
      const salt = crypto.getRandomValues(new Uint8Array(16));
      const iv = crypto.getRandomValues(new Uint8Array(12));
      const aesKey = await Utility.deriveKey(passphrase, salt);

      if (!aesKey) throw new Error("Failed to derive encryption key.");

      const encoded = new TextEncoder().encode(JSON.stringify(arrayData));
      const ciphertext = await crypto.subtle.encrypt(
        { name: "AES-GCM", iv },
        aesKey,
        encoded
      );

      const payload = {
        ct: Utility.bufToBase64(ciphertext),
        iv: Utility.bufToBase64(iv),
        salt: Utility.bufToBase64(salt),
        ...meta,
      };

      sessionStorage.setItem(keyName, JSON.stringify(payload));
    } catch (err) {
      console.error(`Error encrypting and storing array "${keyName}":`, err);
    }
  }

  /**
   * Decrypt stored array from sessionStorage
   * @param {string} keyName
   * @param {string} passphrase
   * @returns {Promise<Array|null>}
   */
  static async decryptAndGetArray(keyName, passphrase) {
    try {
      const stored = sessionStorage.getItem(keyName);
      if (!stored) return null;

      const { ct, iv, salt } = JSON.parse(stored);
      const aesKey = await Utility.deriveKey(
        passphrase,
        Utility.base64ToBuf(salt)
      );

      if (!aesKey) throw new Error("Failed to derive decryption key.");

      const decrypted = await crypto.subtle.decrypt(
        { name: "AES-GCM", iv: Utility.base64ToBuf(iv) },
        aesKey,
        Utility.base64ToBuf(ct)
      );

      return JSON.parse(new TextDecoder().decode(decrypted));
    } catch (err) {
      console.error(`Error decrypting array "${keyName}":`, err);
      return null;
    }
  }

  // ------------------------------
  // DOM / UI Helpers
  // ------------------------------

  /** Run all methods of a class instance except excluded */
  static runClassMethods(instance, excludeMethods = []) {
    try {
      const prototype = Object.getPrototypeOf(instance);
      if (!prototype) throw new Error("Prototype is undefined or null.");

      const methodNames = Object.getOwnPropertyNames(prototype).filter(
        (name) =>
          typeof instance[name] === "function" &&
          name !== "constructor" &&
          !excludeMethods.includes(name)
      );

      methodNames.forEach((name) => {
        try {
          instance[name]();
        } catch (err) {
          console.error(`Error executing method "${name}":`, err);
        }
      });
    } catch (err) {
      console.error("Error running class methods:", err);
    }
  }

  /**
   * Encode and store user data in sessionStorage
   * @param {Object} data
   */
  static encodeUserData(data) {
    try {
      const encodedData = btoa(
        JSON.stringify({
          id: data.userid,
          fullname: data.fullname,
          email: data.email_address,
          role: data.role_id,
        })
      );
      sessionStorage.setItem("user", encodedData);
      return true;
    } catch (err) {
      console.error("Error encoding user data:", err);
      return false;
    }
  }

  /**
   * Generate inline loading spinner HTML
   * @param {string} size
   */
  static inlineLoader(size = "spinner-border-sm") {
    return `
      <div class="spinner-border ${size}" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    `;
  }

  /**
   * Calculate "time ago" from a date string
   * @param {string} dateString
   * @returns {string}
   */
  static timeAgo(dateString) {
    try {
      const isoString = dateString.replace(" ", "T");
      const now = new Date();
      const then = new Date(isoString);

      const seconds = Math.floor((now - then) / 1000);

      const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60,
      };

      for (let unit in intervals) {
        const interval = Math.floor(seconds / intervals[unit]);
        if (interval >= 1) {
          return `${interval} ${unit}${interval !== 1 ? "s" : ""} ago`;
        }
      }
      return "just now";
    } catch (err) {
      console.error("Error calculating time ago:", err);
      return "";
    }
  }

  /**
   * Generate a unique ID
   * @param {string} prefix
   */
  static generateId(prefix = "Tx") {
    try {
      const part1 = Math.floor(100000 + Math.random() * 900000);
      const part2 = Math.floor(1000 + Math.random() * 9000);
      return `${prefix}-${part1}-${part2}`;
    } catch (err) {
      console.error("Error generating ID:", err);
      return `${prefix}-000000-0000`;
    }
  }

  /**
   * Truncate text to a max length
   * @param {string} text
   * @param {number} maxLength
   */
  static truncateText(text, maxLength) {
    try {
      if (text.length <= maxLength) return text;
      const truncated = text.substring(0, maxLength);
      return truncated.substring(0, truncated.lastIndexOf(" ")) + "...";
    } catch (err) {
      console.error("Error truncating text:", err);
      return text;
    }
  }

  // ------------------------------
  // Form Helpers
  // ------------------------------

  /** Convert FormData to plain object */
  static toObject(formData) {
    try {
      const obj = {};
      for (const [key, value] of formData.entries()) {
        if (key.endsWith("[]")) {
          const cleanKey = key.slice(0, -2);
          if (!obj[cleanKey]) obj[cleanKey] = [];
          obj[cleanKey].push(value);
        } else {
          obj[key] = value;
        }
      }
      return obj;
    } catch (err) {
      console.error("Error converting FormData to object:", err);
      return {};
    }
  }

  /**
   * Get the last segment of the current URL path.
   * @returns {string} Last path segment
   */
  static pathId() {
    try {
      const path = window.location.pathname;
      const pathParts = path.split("/");
      return pathParts[pathParts.length - 1];
    } catch (error) {
      console.error("Error getting pathId:", error);
      return "";
    }
  }

  /**
   * Adds print functionality to a button for a specific container.
   */
  static printContent() {
    try {
      const printButton = document.querySelector(".printBtn");
      const container = document.querySelector(".print-section");
      if (!printButton || !container) return;

      printButton.addEventListener("click", () => {
        try {
          const printContent = container.innerHTML;
          const win = window.open("", "", "height=800,width=1000");
          win.document.write("<html><head><title>Order Details</title>");
          win.document.write(
            '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">'
          );
          win.document.write("</head><body>");
          win.document.write(printContent);
          win.document.write("</body></html>");
          win.document.close();
          win.focus();
          win.print();
          win.close();
        } catch (err) {
          console.error("Error during print operation:", err);
        }
      });
    } catch (error) {
      console.error("Error initializing printContent:", error);
    }
  }

  /**
   * Export an array of objects to CSV and download.
   * @param {Array} data - Array of objects
   * @param {string} filename - CSV filename
   */
  static exportToCSV(data, filename = "export.csv") {
    try {
      Utility.toast("Creating CSV file....", "info");

      if (!Array.isArray(data) || data.length === 0) {
        Utility.toast("Invalid data provided for CSV export.", "error");
        return;
      }

      const headers = Object.keys(data[0]);
      const csvRows = [];

      csvRows.push(headers.join(",")); // Add header row

      data.forEach((obj) => {
        const row = headers.map((key) => {
          let cell = obj[key] ?? "";
          cell = String(cell).replace(/"/g, '""'); // Escape quotes
          return `"${cell}"`;
        });
        csvRows.push(row.join(","));
      });

      const csvString = csvRows.join("\n");
      const blob = new Blob([csvString], { type: "text/csv;charset=utf-8;" });
      const link = document.createElement("a");

      const url = URL.createObjectURL(blob);
      link.setAttribute("href", url);
      link.setAttribute("download", filename);
      link.style.display = "none";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      Utility.toast("CSV downloaded", "success");
    } catch (error) {
      console.error("Error exporting CSV:", error);
      Utility.toast("Failed to export CSV.", "error");
    }
  }

  /**
   * Download a PDF from a specific DOM element.
   * @param {string} name - File name
   * @param {string} orient - PDF orientation
   */
  static downloadPDF(name = "file", orient = "portrait") {
    try {
      const pdfButton = document.querySelector(".pdfBtn");
      if (!pdfButton) return;

      pdfButton.addEventListener("click", () => {
        try {
          const element = document.querySelector(".download-section");
          const id = pdfButton.getAttribute("data-loading-id");

          const options = {
            margin: 0.5,
            filename: `${name}_${Utility.generateId(5)}.pdf`,
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: "in", format: "a4", orientation: orient },
          };
          html2pdf().from(element).set(options).save();

          Utility.stopButtonLoading(id);
        } catch (err) {
          console.error("Error generating PDF:", err);
        }
      });
    } catch (error) {
      console.error("Error initializing PDF download:", error);
    }
  }

  /**
   * Render a skeleton loader inside a container.
   * @param {string} dom - Container DOM ID
   * @param {string} type - Skeleton type (card/list)
   * @param {number} pageSize - Number of skeleton items
   */
  static cardSkelecton(dom, type = "card", pageSize = 10) {
    try {
      const container = document.getElementById(dom);
      if (!container) return;
      container.innerHTML = "";
      for (let i = 0; i < pageSize; i++) {
        container.innerHTML += `<div class="skeleton-${type} skeleton"></div>`;
      }
    } catch (error) {
      console.error("Error rendering skeleton:", error);
    }
  }

  /**
   * Paginate an array of data.
   * @param {Array} dataArray - Array of data
   * @param {number} currentPage - Current page number
   * @param {number} perPage - Items per page
   * @param {number} maxButtons - Maximum pagination buttons
   * @returns {Object} Paginated result with navigation
   */
  static paginate(dataArray, currentPage = 1, perPage = 10, maxButtons = 10) {
    try {
      const totalItems = dataArray.length;
      const totalPages = Math.ceil(totalItems / perPage);
      const safePage = Math.max(1, Math.min(currentPage, totalPages || 1));

      const start = (safePage - 1) * perPage;
      const end = start + perPage;
      const pagedData = dataArray.slice(start, end);

      const hasNext = safePage < totalPages;
      const hasPrev = safePage > 1;

      const generateButtons = (onClickHandlerName = "onPageClick") => {
        try {
          let html = `<div class="pagination-group">`;

          if (hasPrev) {
            html += `<button class="pagination-btn btn btn-sm btn-outline-primary" onclick="${onClickHandlerName}(${
              safePage - 1
            })">&laquo; Prev</button>`;
          }

          const half = Math.floor(maxButtons / 2);
          let startPage = Math.max(1, safePage - half);
          let endPage = Math.min(totalPages, safePage + half);

          if (endPage - startPage + 1 > maxButtons) {
            endPage = startPage + maxButtons - 1;
          }

          if (endPage > totalPages) {
            startPage = Math.max(1, totalPages - maxButtons + 1);
            endPage = totalPages;
          }

          if (startPage > 1) {
            html += `<button class="pagination-btn btn btn-sm" onclick="${onClickHandlerName}(1)">1</button>`;
            if (startPage > 2)
              html += `<span class="pagination-ellipsis">...</span>`;
          }

          for (let i = startPage; i <= endPage; i++) {
            html += `<button class="pagination-btn btn btn-sm ${
              i === safePage ? "active" : ""
            }" onclick="${onClickHandlerName}(${i})">${i}</button>`;
          }

          if (endPage < totalPages) {
            if (endPage < totalPages - 1)
              html += `<span class="pagination-ellipsis">...</span>`;
            html += `<button class="pagination-btn btn btn-sm" onclick="${onClickHandlerName}(${totalPages})">${totalPages}</button>`;
          }

          if (hasNext) {
            html += `<button class="pagination-btn btn btn-sm btn-outline-accent" onclick="${onClickHandlerName}(${
              safePage + 1
            })">Next &raquo;</button>`;
          }

          html += `</div>`;
          return html;
        } catch (err) {
          console.error("Error generating pagination buttons:", err);
          return "";
        }
      };

      return {
        pagedData,
        totalPages,
        currentPage: safePage,
        hasNext,
        hasPrev,
        generateButtons,
      };
    } catch (error) {
      console.error("Error during pagination:", error);
      return {
        pagedData: [],
        totalPages: 0,
        currentPage: 1,
        hasNext: false,
        hasPrev: false,
        generateButtons: () => "",
      };
    }
  }

  /**
   * Convert a string to title case.
   * @param {string} str
   * @returns {string}
   */
  static toTitleCase(str) {
    try {
      return str
        .toLowerCase()
        .split(" ")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
    } catch (error) {
      console.error("Error converting to title case:", error);
      return str;
    }
  }

  /**
   * Reloads the page after a configurable timeout.
   */
  static reloadPage() {
    try {
      setTimeout(() => window.location.reload(), CONFIG.loadTimeout);
    } catch (error) {
      console.error("Error reloading page:", error);
    }
  }

  /**
   * Validate a Vehicle Identification Number (VIN).
   * @param {string} v - VIN string
   * @returns {boolean}
   */
  static validVIN(v) {
    try {
      if (!v) return false;
      const s = v.toUpperCase().trim();
      if (s.length < 11 || s.length > 17) return false;
      if (/[IOQ]/.test(s)) return false;
      if (!/^[A-Z0-9]+$/.test(s)) return false;
      return true;
    } catch (error) {
      console.error("Error validating VIN:", error);
      return false;
    }
  }

  /**
   * Escape HTML characters to prevent XSS.
   * @param {string} s
   * @returns {string}
   */
  static escapeHtml(s) {
    try {
      return String(s)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
    } catch (error) {
      console.error("Error escaping HTML:", error);
      return s;
    }
  }

  /**
   * Format number as Nigerian Naira.
   * @param {number|string} n
   * @returns {string}
   */
  static fmtNGN(n) {
    try {
      return "NGN " + Number(n).toLocaleString();
    } catch (error) {
      console.error("Error formatting NGN:", error);
      return n;
    }
  }

  /**
   * Generate a unique ID with optional prefix.
   * @param {string} prefix
   * @returns {string}
   */
  static uid(prefix = "N") {
    try {
      return prefix + Math.random().toString(36).slice(2, 9).toUpperCase();
    } catch (error) {
      console.error("Error generating UID:", error);
      return prefix + Date.now();
    }
  }

  /**
   * Format number with locale.
   * @param {number|string} n
   * @returns {string}
   */
  static fmt(n) {
    try {
      return Number(n).toLocaleString();
    } catch (error) {
      console.error("Error formatting number:", error);
      return n;
    }
  }

  /**
   * Get a date string offset by delta days.
   * @param {number} delta - Days to add/subtract
   * @returns {string} YYYY-MM-DD
   */
  static dateStep(delta) {
    try {
      const d = new Date();
      d.setDate(d.getDate() + delta);
      return d.toISOString().slice(0, 10);
    } catch (error) {
      console.error("Error computing dateStep:", error);
      return "";
    }
  }

  /**
   * Display a toast notification.
   * @param {string} msg - Message
   * @param {string} type - Type: info, success, error
   * @param {number} ttl - Time to live (ms)
   */
  static toast(msg, type = "info", ttl = 3000) {
    try {
      const toastDom = document.getElementById("toastWrap");
      if (!toastDom) return;
      toastDom.innerHTML = "";

      const t = document.createElement("div");
      t.className = "toast";
      t.innerHTML = `
        <div style="font-weight:700">${
          type === "error"
            ? '<i class="bi bi-exclamation-triangle-fill"></i>'
            : '<i class="bi bi-check2-circle"></i>'
        }</div>
        <div style="margin-left:8px">${msg}</div>
      `;
      toastDom.appendChild(t);
      setTimeout(() => t.remove(), ttl);
    } catch (error) {
      console.error("Error displaying toast:", error);
    }
  }

  /**
   * Calculate number of pages given a dataset and PER_PAGE.
   * @param {Array} REQUESTS
   * @returns {number}
   */
  static pageCount(REQUESTS) {
    try {
      return Math.ceil(REQUESTS.length / Utility.PER_PAGE);
    } catch (error) {
      console.error("Error computing pageCount:", error);
      return 0;
    }
  }

  /**
   * Generate a numeric hash code from a string.
   * @param {string} s
   * @returns {number}
   */
  static hashCode(s) {
    try {
      let h = 0;
      for (let i = 0; i < s.length; i++) {
        h = (h << 5) - h + s.charCodeAt(i);
        h |= 0; // Convert to 32-bit integer
      }
      return h;
    } catch (error) {
      console.error("Error generating hashCode:", error);
      return 0;
    }
  }

  /**
   * Display a confirmation dialog using SweetAlert.
   * @param {string} title
   * @param {string} message
   * @returns {Promise<Object>} Swal response
   */
  static async confirm(title, message = "Do you wish to continue?") {
    try {
      return await Swal.fire({
        title: `${title}`,
        text: `${message}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
    } catch (error) {
      console.error("Error showing confirm dialog:", error);
      return { isConfirmed: false };
    }
  }

  /**
   * Validate email input.
   * @param {HTMLInputElement} emailInput
   * @param {HTMLElement} emailError
   * @returns {boolean}
   */
  static validateEmail(emailInput, emailError) {
    try {
      emailError.textContent = "";
      const v = emailInput.value.trim();
      const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
      emailError.style.display = ok ? "none" : "block";
      if (!ok) emailError.textContent = "Please enter a valid email address.";
      return ok;
    } catch (error) {
      console.error("Error validating email:", error);
      return false;
    }
  }

  /**
   * Validate password input.
   * @param {HTMLInputElement} password
   * @param {HTMLElement} pwError
   * @returns {boolean}
   */
  static validatePassword(password, pwError) {
    try {
      pwError.textContent = "";
      const v = password.value || "";
      const ok = v.length >= 6;
      pwError.style.display = ok ? "none" : "block";
      if (!ok) pwError.textContent = "Password must be at least 6 characters.";
      return ok;
    } catch (error) {
      console.error("Error validating password:", error);
      return false;
    }
  }

  /**
   * Toggle loading state for a button.
   * @param {boolean} on - Whether to enable loading
   * @param {HTMLElement} btnText - The button's text element
   */
  static setLoading(on, btnText) {
    try {
      // Store the original label only once
      if (!UIHelper._originalLabel) {
        UIHelper._originalLabel = btnText.textContent;
      }

      if (on) {
        AuthStatic.btnSpinner.style.display = "inline-block";
        AuthStatic.btnText.textContent = "Please wait...";
        AuthStatic.submitBtn.disabled = true;
      } else {
        AuthStatic.btnSpinner.style.display = "none";
        AuthStatic.btnText.textContent = UIHelper._originalLabel;
        AuthStatic.submitBtn.disabled = false;
      }
    } catch (error) {
      console.error("Error toggling button loading state:", error);
    }
  }

  /**
   * Render a friendly empty state illustration with optional action.
   * @param {HTMLElement} container - DOM element to render empty state in
   * @param {Object} options - Configuration options
   * @param {string} [options.title="Data not available"] - Main title
   * @param {string} [options.subtitle="We couldn’t find anything to show here right now."] - Subtitle
   * @param {string|null} [options.actionText=null] - Text for action button
   * @param {Function|null} [options.onAction=null] - Callback for action button
   */
  static renderEmptyState(
    container,
    {
      title = "Data not available",
      subtitle = "We couldn’t find anything to show here right now.",
      actionText = null,
      onAction = null,
    } = {}
  ) {
    try {
      if (!container) {
        console.warn("renderEmptyState: container not provided.");
        return;
      }

      const wrapper = document.createElement("div");
      wrapper.className = "empty-state";
      wrapper.setAttribute("role", "status");
      wrapper.setAttribute("aria-live", "polite");

      wrapper.innerHTML = `
        <!-- Minimal, friendly illustration -->
        <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <defs>
            <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#e5e7eb"/>
              <stop offset="1" stop-color="#c7cdd6"/>
            </linearGradient>
          </defs>
          <!-- Card -->
          <rect x="20" y="38" width="120" height="80" rx="10" fill="url(#g1)" />
          <rect x="30" y="50" width="60" height="10" rx="5" fill="#d1d5db" />
          <rect x="30" y="68" width="100" height="8" rx="4" fill="#e5e7eb" />
          <rect x="30" y="82" width="80" height="8" rx="4" fill="#e5e7eb" />
          <!-- Magnifier -->
          <g transform="translate(92,92)">
            <circle cx="16" cy="16" r="12" fill="none" stroke="#9ca3af" stroke-width="3"/>
            <rect x="28" y="28" width="18" height="6" rx="3" transform="rotate(45 28 28)" fill="#9ca3af"/>
          </g>
          <!-- Dots -->
          <circle cx="50" cy="112" r="2" fill="#d1d5db"/>
          <circle cx="60" cy="112" r="2" fill="#d1d5db"/>
          <circle cx="70" cy="112" r="2" fill="#d1d5db"/>
        </svg>
        <h3>${title}</h3>
        <p>${subtitle}</p>
        <div class="actions"></div>
      `;

      // Add action button if provided
      const actions = wrapper.querySelector(".actions");
      if (actionText && typeof onAction === "function") {
        const btn = document.createElement("button");
        btn.className = "btn";
        btn.type = "button";
        btn.textContent = actionText;
        btn.addEventListener("click", onAction);
        actions.appendChild(btn);
      }

      // Clear container and append empty state
      container.innerHTML = "";
      container.appendChild(wrapper);
    } catch (error) {
      console.error("Error rendering empty state:", error);
    }
  }
}
