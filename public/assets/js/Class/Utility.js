export default class Utility {
  static BASEURL = "http://localhost/10over10cars";
  static API_ROUTE = Utility.BASEURL + "/api";
  static APP_ROUTE = Utility.BASEURL;
  static loadTimeout = 500;
  static btnLoadingRegistry = {};
  static currentPage = document.body.dataset.page;
  static userid = document.body.dataset.id;

  static buttonLoading() {
    const btns = document.querySelectorAll(".btn");
    if (!btns) return;

    btns.forEach((btn, index) => {
      // Add listener once
      if (!btn.hasAttribute("data-loading-attached")) {
        btn.setAttribute("data-loading-attached", "true");

        btn.addEventListener("click", () => {
          if (btn.classList.contains("loading")) return;

          const id = `btn-${Date.now()}-${index}`;

          btn.setAttribute("data-loading-id", id);
          Utility.btnLoadingRegistry[id] = btn.innerHTML;

          btn.classList.add("loading");
          if (!btn.classList.contains("theme-toggle-btn")) btn.disabled = true;
          btn.innerHTML = `${btn.textContent} ${Utility.inlineLoader()}`;
        });
      }
    });
  }

  static stopButtonLoading(id) {
    const btn = document.querySelector(`button[data-loading-id="${id}"]`);
    if (!btn || !Utility.btnLoadingRegistry[id]) return;

    btn.innerHTML = Utility.btnLoadingRegistry[id];
    btn.classList.remove("loading");
    btn.removeAttribute("data-loading-id");
    btn.disabled = false;

    delete Utility.btnLoadingRegistry[id];
  }

  static async fetchData(url, data = {}, method = "GET") {
    const token = sessionStorage.getItem("token") ?? "";

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
        instance[name](); // Correctly invoking the method
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

  static copyText() {
    const copyText = document.getElementById("textToCopy");
    const copyMessage = document.getElementById("copyMessage");

    if (copyText) {
      const text = copyText.innerText;

      navigator.clipboard
        .writeText(text)
        .then(() => {
          copyMessage.innerHTML = `<p className="small-p color-primary">Text copied to clipboard!</p>`;
          setTimeout(() => {
            copyMessage.innerHTML = "";
          }, 1000);
        })
        .catch((err) => {
          console.error("Failed to copy text: ", err);
        });
    }
  }

  static truncateText(text, maxLength) {
    if (text.length > maxLength) {
      const truncated = text.substring(0, maxLength);
      return truncated.substring(0, truncated.lastIndexOf(" ")) + "...";
    }
    return text;
  }

  static parseJWT(token) {
    try {
      const base64Url = token.split(".")[1];
      const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
      const jsonPayload = decodeURIComponent(
        atob(base64)
          .split("")
          .map((c) => "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2))
          .join("")
      );

      return JSON.parse(jsonPayload);
    } catch (error) {
      console.error("Invalid Token:", error);
      return null;
    }
  }

  // static toObject(formData) {
  //   /**
  //    * Convert a FormData to an object
  //    */
  //   const formObject = {};

  //   formData.forEach((value, key) => {
  //     formObject[key] = value;
  //   });

  //   return formObject;
  // }

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
    const csvButton = document.querySelector(".csvButton");
    if (!csvButton) return;
    csvButton.addEventListener("click", () => {
      if (!Array.isArray(data) || data.length === 0) {
        console.error("Invalid data provided for CSV export.");
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
    });
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

  static validateForm(form) {
    let isValid = true;

    // Clear previous error states
    form
      .querySelectorAll(".is-invalid")
      .forEach((el) => el.classList.remove("is-invalid"));
    form
      .querySelectorAll(".invalid-feedback")
      .forEach((el) => (el.style.display = "none"));

    // Loop through inputs, textareas, selects
    form.querySelectorAll("input, textarea, select").forEach((input) => {
      const type = input.type;
      const value = input.value.trim();
      const required = input.hasAttribute("required");

      if (required) {
        if (type === "checkbox" && !input.checked) {
          markInvalid(input);
        } else if (type === "radio") {
          const name = input.name;
          const checked = form.querySelector(`input[name="${name}"]:checked`);
          if (!checked) {
            markInvalidGroup(form, name);
          }
        } else if (type === "email") {
          if (!value || !/^\S+@\S+\.\S+$/.test(value)) {
            markInvalid(input);
          }
        } else if (type === "select-one") {
          if (!value) {
            markInvalid(input);
          }
        } else {
          if (!value) {
            markInvalid(input);
          }
        }
      }
    });

    if (form.querySelector(".is-invalid")) {
      isValid = false;
    }

    return isValid;

    // Helper to mark single input
    function markInvalid(input) {
      input.classList.add("is-invalid");
      const feedback = input
        .closest(".form-floating, .mb-3, .form-check")
        ?.querySelector(".invalid-feedback");
      if (feedback) feedback.style.display = "block";
    }

    // Helper to mark radio group
    function markInvalidGroup(form, name) {
      const radios = form.querySelectorAll(`input[name="${name}"]`);
      radios.forEach((r) => r.classList.add("is-invalid"));
      const feedback =
        form.querySelector(`#${name}Feedback`) ||
        radios[0].closest(".mb-3")?.querySelector(".invalid-feedback");
      if (feedback) feedback.style.display = "block";
    }
  }

  static cardSkelecton(dom, type = "card", pageSize = 10) {
    const container = document.getElementById(dom);
    container.innerHTML = "";
    for (let i = 0; i < pageSize; i++) {
      container.innerHTML += `<div class="skeleton-${type} skeleton"></div>`;
    }
  }

  // utils/paginate.js
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
    }, Utility.loadTimeout);
  }
}
