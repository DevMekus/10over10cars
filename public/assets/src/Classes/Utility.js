import { CONFIG } from "../Utils/config.js";

export default class Utility {
  static PAGE = 1;
  static PER_PAGE = 10;
  static userRole = document.body.dataset.role;
  static userid = document.body.dataset.id;
  static el = (id) => document.getElementById(id);

  // --- Helpers ---
  static strToBuffer(str) {
    return new TextEncoder().encode(str);
  }

  static bufToBase64(buf) {
    return btoa(String.fromCharCode(...new Uint8Array(buf)));
  }

  static base64ToBuf(b64) {
    return Uint8Array.from(atob(b64), (c) => c.charCodeAt(0));
  }

  static async deriveKey(passphrase, salt) {
    const baseKey = await crypto.subtle.importKey(
      "raw",
      Utility.strToBuffer(passphrase),
      { name: "PBKDF2" },
      false,
      ["deriveKey"]
    );

    return crypto.subtle.deriveKey(
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
  }

  // --- Encrypt + Store ---
  static async encryptAndStoreArray(keyName, arrayData, passphrase, meta = {}) {
    const salt = crypto.getRandomValues(new Uint8Array(16));
    const iv = crypto.getRandomValues(new Uint8Array(12));
    const aesKey = await Utility.deriveKey(passphrase, salt);

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
  }

  // --- Decrypt + Get ---
  static async decryptAndGetArray(keyName, passphrase) {
    const stored = sessionStorage.getItem(keyName);
    if (!stored) return null;

    try {
      const { ct, iv, salt } = JSON.parse(stored);
      const aesKey = await Utility.deriveKey(
        passphrase,
        Utility.base64ToBuf(salt)
      );

      const decrypted = await crypto.subtle.decrypt(
        { name: "AES-GCM", iv: Utility.base64ToBuf(iv) },
        aesKey,
        Utility.base64ToBuf(ct)
      );

      const decoded = new TextDecoder().decode(decrypted);
      return JSON.parse(decoded);
    } catch (e) {
      console.error("Decryption failed:", e);
      return null;
    }
  }

  static runClassMethods(instance, excludeMethods = []) {
    const prototype = Object.getPrototypeOf(instance);

    if (!prototype) {
      console.error("Prototype is undefined or null.");
      return;
    }

    const methodNames = Object.getOwnPropertyNames(prototype).filter(
      (name) =>
        typeof instance[name] === "function" &&
        name !== "constructor" &&
        !excludeMethods.includes(name)
    );

    methodNames.forEach((name) => {
      try {
        instance[name]();
      } catch (error) {
        console.error(`Error executing method ${name}:`, error);
      }
    });
  }

  static encodeUserData(data) {
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
  }

  static inlineLoader(size = "spinner-border-sm") {
    return `
      <div class="spinner-border ${size}" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    `;
  }

  static timeAgo(dateString) {
    // Convert to ISO format for cross-browser compatibility
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
  }

  static generateId(prefix = "Tx") {
    const part1 = Math.floor(100000 + Math.random() * 900000); // 6-digit
    const part2 = Math.floor(1000 + Math.random() * 9000); // 4-digit

    return `${prefix}-${part1}-${part2}`;
  }

  static truncateText(text, maxLength) {
    if (text.length > maxLength) {
      const truncated = text.substring(0, maxLength);
      return truncated.substring(0, truncated.lastIndexOf(" ")) + "...";
    }
    return text;
  }

  static toObject(formData) {
    const obj = {};
    for (const [key, value] of formData.entries()) {
      if (key.endsWith("[]")) {
        const cleanKey = key.slice(0, -2);
        if (!obj[cleanKey]) {
          obj[cleanKey] = [];
        }
        obj[cleanKey].push(value);
      } else {
        obj[key] = value;
      }
    }
    return obj;
  }

  static pathId() {
    const path = window.location.pathname;
    const pathParts = path.split("/");
    return pathParts[pathParts.length - 1];
  }

  static printContent() {
    const printButton = document.querySelector(".printBtn");
    const container = document.querySelector(".print-section");
    if (!printButton || !container) return;

    printButton.addEventListener("click", () => {
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
    });
  }

  static exportToCSV(data, filename = "export.csv") {
    Utility.toast("Creating csv file....", "info");

    if (!Array.isArray(data) || data.length === 0) {
      Utility.toast("Invalid data provided for CSV export.", "error");
      return;
    }

    // Extract headers from keys of the first object
    const headers = Object.keys(data[0]);
    const csvRows = [];

    // Add header row
    csvRows.push(headers.join(","));

    // Add data rows
    data.forEach((obj) => {
      const row = headers.map((key) => {
        let cell = obj[key] ?? "";
        // Escape quotes by doubling them
        cell = String(cell).replace(/"/g, '""');
        return `"${cell}"`; // Wrap each cell in quotes
      });
      csvRows.push(row.join(","));
    });

    // Create CSV string and download
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
  }

  static downloadPDF(name = "file", orient = "portrait") {
    const pdfButton = document.querySelector(".pdfBtn");
    if (!pdfButton) return;

    pdfButton.addEventListener("click", () => {
      const element = document.querySelector(".download-section");
      const id = pdfButton.getAttribute("data-loading-id");

      const opt = {
        margin: 0.5,
        filename: `${name}_${Utility.generateId(5)}.pdf`,
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: orient },
      };
      html2pdf().from(element).set(opt).save();

      Utility.stopButtonLoading(id);
    });
  }

  static cardSkelecton(dom, type = "card", pageSize = 10) {
    const container = document.getElementById(dom);
    container.innerHTML = "";
    for (let i = 0; i < pageSize; i++) {
      container.innerHTML += `<div class="skeleton-${type} skeleton"></div>`;
    }
  }

  static paginate(dataArray, currentPage = 1, perPage = 10, maxButtons = 10) {
    const totalItems = dataArray.length;
    const totalPages = Math.ceil(totalItems / perPage);
    const safePage = Math.max(1, Math.min(currentPage, totalPages || 1));

    const start = (safePage - 1) * perPage;
    const end = start + perPage;
    const pagedData = dataArray.slice(start, end);

    const hasNext = safePage < totalPages;
    const hasPrev = safePage > 1;

    function generateButtons(onClickHandlerName = "onPageClick") {
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
        if (startPage > 2) {
          html += `<span class="pagination-ellipsis">...</span>`;
        }
      }

      for (let i = startPage; i <= endPage; i++) {
        html += `<button class="pagination-btn btn btn-sm ${
          i === safePage ? "active" : ""
        }" onclick="${onClickHandlerName}(${i})">${i}</button>`;
      }

      if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
          html += `<span class="pagination-ellipsis">...</span>`;
        }
        html += `<button class="pagination-btn btn btn-sm" onclick="${onClickHandlerName}(${totalPages})">${totalPages}</button>`;
      }

      if (hasNext) {
        html += `<button class="pagination-btn btn btn-sm btn-outline-accent" onclick="${onClickHandlerName}(${
          safePage + 1
        })">Next &raquo;</button>`;
      }

      html += `</div>`;
      return html;
    }

    return {
      pagedData,
      totalPages,
      currentPage: safePage,
      hasNext,
      hasPrev,
      generateButtons,
    };
  }

  static toTitleCase(str) {
    return str
      .toLowerCase()
      .split(" ")
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
      .join(" ");
  }

  static reloadPage() {
    setTimeout(() => {
      window.location.reload();
    }, CONFIG.loadTimeout);
  }

  static validVIN(v) {
    if (!v) return false;
    const s = v.toUpperCase().trim();
    if (s.length < 11 || s.length > 17) return false;
    if (/[IOQ]/.test(s)) return false;
    if (!/^[A-Z0-9]+$/.test(s)) return false;
    return true;
  }

  static escapeHtml(s) {
    return String(s)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;");
  }

  static fmtNGN(n) {
    return "NGN " + Number(n).toLocaleString();
  }

  static uid(prefix = "N") {
    return prefix + Math.random().toString(36).slice(2, 9).toUpperCase();
  }

  static fmt(n) {
    return Number(n).toLocaleString();
  }

  static dateStep(delta) {
    const d = new Date();
    d.setDate(d.getDate() + delta);
    return d.toISOString().slice(0, 10);
  }

  static toast(msg, type = "info", ttl = 3000) {
    console.log("toast running");
    const toastDom = document.getElementById("toastWrap");
    toastDom.innerHTML = ``;

    const t = document.createElement("div");
    t.className = "toast";
    t.innerHTML = ``;
    t.innerHTML = `
      <div style="font-weight:700">${
        type === "error"
          ? '<i class="bi bi-exclamation-triangle-fill"></i>'
          : '<i class="bi bi-check2-circle"></i>'
      }</div>
      <div style="margin-left:8px">${msg}</div>
    `;
    toastDom?.appendChild(t);
    setTimeout(() => t.remove(), ttl);
  }

  static pageCount(REQUESTS) {
    return Math.ceil(REQUESTS.length / Utility.PER_PAGE);
  }

  static hashCode(s) {
    let h = 0;
    for (let i = 0; i < s.length; i++) {
      h = (h << 5) - h + s.charCodeAt(i);
      h |= 0;
    }
    return h;
  }

  static async confirm(title, message = "Do you wish to continue?") {
    //--Returns isConfirmed which is a Boolean
    return await Swal.fire({
      title: `${title}`,
      text: `${message}`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Continue!",
    });
  }

  static validateEmail(emailInput, emailError) {
    emailError.textContent = "";
    const v = emailInput.value.trim();
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    emailError.style.display = ok ? "none" : "block";
    if (!ok) emailError.textContent = "Please enter a valid email address.";
    return ok;
  }

  static validatePassword(password, pwError) {
    pwError.textContent = "";
    const v = password.value || "";
    const ok = v.length >= 6;
    pwError.style.display = ok ? "none" : "block";
    if (!ok) pwError.textContent = "Password must be at least 6 characters.";
    return ok;
  }

  static setLoading(on, btnText) {
    // Store the original label only once
    if (!Utility._originalLabel) {
      Utility._originalLabel = btnText.textContent;
    }

    if (on) {
      AuthStatic.btnSpinner.style.display = "inline-block";
      AuthStatic.btnText.textContent = "Please wait...";
      AuthStatic.submitBtn.disabled = true;
    } else {
      AuthStatic.btnSpinner.style.display = "none";
      AuthStatic.btnText.textContent = AuthStatic._originalLabel;
      AuthStatic.submitBtn.disabled = false;
    }
  }

  static renderEmptyState(
    container,
    {
      title = "Data not available",
      subtitle = "We couldn’t find anything to show here right now.",
      actionText = null,
      onAction = null,
    } = {}
  ) {
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

    const actions = wrapper.querySelector(".actions");
    if (actionText && typeof onAction === "function") {
      const btn = document.createElement("button");
      btn.className = "btn";
      btn.type = "button";
      btn.textContent = actionText;
      btn.addEventListener("click", onAction);
      actions.appendChild(btn);
    }

    container.innerHTML = "";
    container.appendChild(wrapper);
  }
}
