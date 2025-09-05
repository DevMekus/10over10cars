import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Vehicle from "../Classes/Vehicle.js";
import { CONFIG } from "../Utils/config.js";
import { DataTransfer } from "../Utils/api.js";
import { clearAppData, decryptJsToken } from "../Utils/Session.js";

/**
 * @class Verification
 * Handles vehicle verification management, including statistics,
 * rendering verification tables, search/filter, history, and admin actions.
 */
export default class Verification {
  /**
   * Update verification statistics in the DOM.
   */
  static statistics() {
    try {
      const total = Application.DATA.verifications.length;
      const approved = Application.DATA.verifications.filter(
        (r) => r.status === "approved"
      ).length;
      const declined = Application.DATA.verifications.filter(
        (r) => r.status === "declined"
      ).length;
      const pending = Application.DATA.verifications.filter(
        (r) => r.status === "pending"
      ).length;

      document.getElementById("statTotal").textContent = total;
      document.getElementById("statApproved").textContent = approved;
      document.getElementById("statDeclined").textContent = declined;
      document.getElementById("statPending").textContent = pending;
    } catch (error) {
      console.error("Error updating statistics:", error);
    }
  }

  /**
   * Render the verification table with pagination, filters, and search.
   * @param {Array} data - Array of verification objects.
   */
  static async renderTable(data) {
    try {
      const tbody = document.querySelector("#reqTable tbody");
      const noData = document.querySelector(".no-data");
      if (!tbody || !noData) return;

      tbody.innerHTML = "";
      noData.innerHTML = "";

      const query = (
        document.getElementById("qSearch")?.value || ""
      ).toLowerCase();
      const statusFilter = document.getElementById("statusFilter")?.value;
      const from = document.getElementById("fromDate")?.value;
      const to = document.getElementById("toDate")?.value;

      const filtered = data.filter((r) => {
        if (statusFilter !== "all" && r.status !== statusFilter) return false;
        if (
          query &&
          !`${r.vin} ${r.title} ${r.user}`.toLowerCase().includes(query)
        )
          return false;
        if (from && r.date < from) return false;
        if (to && r.date > to) return false;
        return true;
      });

      const totalFiltered = filtered.length;
      if (totalFiltered === 0) {
        Utility.renderEmptyState(noData);
        return;
      }

      document.getElementById("totalCount").textContent = totalFiltered;
      const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
      const slice = filtered.slice(start, start + Utility.PER_PAGE);
      document.getElementById("showingCount").textContent = slice.length;

      const token = await decryptJsToken();

      slice.forEach((r) => {
        const tr = document.createElement("tr");
        const images = JSON.parse(r.images || "[]");

        tr.innerHTML = `
          <td><code>${r.request_id}</code></td>
          <td><strong>${r.vin}</strong></td>
          <td>
            <div style="display:flex;gap:8px;align-items:center">
              <img src="${
                images[0] || ""
              }" alt="thumb" style="width:84px;height:56px;object-fit:cover;border-radius:6px">
              <div>
                <strong>${r.title}</strong>
                <div class='muted small'>${r.company ?? "---"}</div>
              </div>
            </div>
          </td>
          <td>${r.company ?? "---"}</td>
          <td class="small">${r.date}</td>
          <td>${
            r.status === "pending"
              ? '<span class="status-pill pending">Pending</span>'
              : r.status === "approved"
              ? '<span class="status-pill approved">Approved</span>'
              : '<span class="status-pill rejected">Declined</span>'
          }</td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn btn-sm btn-primary" data-view='${
                r.request_id
              }'>View</button>
              ${
                token?.role === "admin" && r.status === "pending"
                  ? `
                    <button class="btn btn-sm btn-ghost" data-approve='${r.request_id}'>Approve</button>
                    <button class="btn btn-sm btn-ghost" data-decline='${r.request_id}'>Decline</button>`
                  : ""
              }
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });

      document.getElementById("pageInfo").textContent = `Page ${
        Utility.PAGE
      } of ${Utility.pageCount(data)}`;
    } catch (error) {
      console.error("Error rendering verification table:", error);
    }
  }

  /**
   * Attach pagination controls to the DOM elements.
   * @param {Array} data - Array of verification objects.
   */
  static controlPagination(data) {
    try {
      document.getElementById("prevPage")?.addEventListener("click", () => {
        if (Utility.PAGE > 1) Utility.PAGE--;
        Verification.renderTable(data);
      });

      document.getElementById("nextPage")?.addEventListener("click", () => {
        if (Utility.PAGE < Utility.pageCount(data)) Utility.PAGE++;
        Verification.renderTable(data);
      });
    } catch (error) {
      console.error("Error setting pagination controls:", error);
    }
  }

  /**
   * Attach search and filter listeners to DOM elements.
   * @param {Array} data - Array of verification objects.
   */
  static filterAndSearch(data) {
    try {
      ["qSearch", "statusFilter", "fromDate", "toDate"].forEach((id) =>
        document.getElementById(id)?.addEventListener("input", () => {
          Utility.PAGE = 1;
          Verification.renderTable(data);
        })
      );
    } catch (error) {
      console.error("Error attaching filter/search listeners:", error);
    }
  }

  /**
   * Show verification result for a given VIN.
   * @param {string} vin
   * @returns {Promise<boolean>}
   */
  static async verificationResult(vin) {
    try {
      const find = await Vehicle.findParticularCar(vin);
      if (!find || !find.length) {
        Utility.renderEmptyState(document.getElementById("noResult"));
        return false;
      }

      const data = find[0];
      const images = JSON.parse(data.images || "[]");

      document.getElementById("noResult").style.display = "none";
      document.getElementById("resultArea").style.display = "block";
      document.getElementById("vehTitle").textContent = data.title;
      document.getElementById("vehVin").textContent = data.vin;
      document.getElementById("vehOwner").textContent = data.company;
      document.getElementById("vehPrice").textContent =
        "NGN " + Number(data.price).toLocaleString();
      document.getElementById("vehYear").textContent = data.year;
      document.getElementById("vehMileage").textContent =
        data.mileage.toLocaleString();
      document.getElementById("vehEngine").textContent = data.engine;
      document.getElementById("vehStatus").textContent =
        data.status === "approved" ? "Clean" : "Flagged";
      document.getElementById("vehStatus").className = `status-pill ${
        data.status === "approved" ? "status-clean" : "status-flag"
      }`;
      document.getElementById("vehMedia").innerHTML = `<img src="${
        images[0] || ""
      }" alt="vehicle" />`;

      document.getElementById("actionButtons").innerHTML = `
        <div style="display:flex;gap:8px;margin-top:12px">
          <button id="saveToHistory" class="btn btn-sm btn-outline-error">Save to history</button>
          <a href="${CONFIG.BASE_URL}/secure/payment?vin=${vin}" class="btn" style="background:var(--primary);color:var(--text)">Start Verification</a>
        </div>
      `;

      return true;
    } catch (error) {
      console.error("Error showing verification result:", error);
      return false;
    }
  }

  /**
   * Render a filtered verification history in the DOM.
   * @param {Array} filtered
   */
  static verificationHistory(filtered = Verification.loadHistory()) {
    try {
      const list = document.getElementById("historyList");
      if (!list) return;
      list.innerHTML = "";

      filtered.slice(0, 12).forEach((it) => {
        const div = document.createElement("div");
        div.className = "history-item";
        div.innerHTML = `
          <div>
            <strong>${Utility.escapeHtml(it.title)}</strong>
            <div class='muted small'>${it.vin} • ${new Date(
          it.request_date
        ).toLocaleString()}</div>
          </div>
          <div style="display:flex;gap:6px">
            <button class="btn btn-sm btn-ghost" data-retry="${
              it.vin
            }"><i class='bi bi-arrow-repeat'></i></button>
          </div>
        `;
        list.appendChild(div);
      });

      if (!filtered.length)
        list.innerHTML = '<div class="muted small">No matches</div>';
    } catch (error) {
      console.error("Error rendering verification history:", error);
    }
  }

  /**
   * Save the current vehicle verification to local history.
   */
  static saveHistoryButton() {
    try {
      const vin = document.getElementById("vehVin")?.textContent;
      if (!vin || vin === "--") {
        Utility.toast("Nothing to save", "error");
        return;
      }

      const record = {
        vin,
        title: document.getElementById("vehTitle")?.textContent,
        when: new Date().toISOString(),
        raw: document.getElementById("rawDetail")?.textContent
          ? JSON.parse(document.getElementById("rawDetail").textContent)
          : {},
      };

      const items = Verification.loadHistory();
      items.unshift(record);
      Verification.saveHistory(items);
      Verification.verificationHistory();
      Utility.toast("Saved lookup to history");
    } catch (error) {
      console.error("Error saving history:", error);
      Utility.toast("Failed to save history", "error");
    }
  }

  /**
   * Load history from local storage.
   * @returns {Array}
   */
  static loadHistory() {
    try {
      return JSON.parse(localStorage.getItem(CONFIG.HISTORY_KEY)) || [];
    } catch (error) {
      console.error("Error loading history:", error);
      return [];
    }
  }

  /**
   * Save history array to local storage.
   * @param {Array} items
   */
  static saveHistory(items) {
    try {
      localStorage.setItem(CONFIG.HISTORY_KEY, JSON.stringify(items));
    } catch (error) {
      console.error("Error saving history:", error);
    }
  }

  /**
   * Clear local history after confirmation.
   */
  static async clearHistory() {
    try {
      const history = Verification.loadHistory();
      if (!history.length) {
        Utility.toast("You have no saved history");
        return;
      }

      const result = await Utility.confirm("Clear all local history?");
      if (result.isConfirmed) {
        Verification.saveHistory([]);
        Verification.verificationHistory([]);
        Utility.toast("History cleared");
      }
    } catch (error) {
      console.error("Error clearing history:", error);
    }
  }

  /**
   * Open verification detail modal for a specific request ID.
   * @param {string} id
   */
  static async openDetail(id) {
    try {
      const req = Application.DATA.verifications.find(
        (r) => r.request_id === id
      );
      if (!req) {
        Utility.toast("Request not available", "error");
        return;
      }

      const domBody = Utility.el("detailModalBody");
      const titleEl = Utility.el("detailModalLabel");
      const images = req.images ? JSON.parse(req.images) : [];
      const docs = req.documents ? JSON.parse(req.documents) : [];

      const token = await decryptJsToken();

      titleEl.textContent = `Verification details: (${id})`;
      domBody.innerHTML = `
    <div id="detailModal">
    <div class="container">        
         <div  class="row">
             <div class="col-sm-6">
                 <div class="vehicle-media">
                  <img id="detailImage" src="${
                    images ? images[0] : ""
                  }" alt="vehicle image" />
                 </div>
                 ${
                   token?.role == "admin"
                     ? `
                  <div style="margin-top:10px;display:flex;gap:8px">
                    <button class="btn btn-primary btn-pill"  data-target="${id}" id="approveBtn">Approve</button>
                    <button class="btn btn-ghost" data-target="${id}" id="declineBtn">Decline</button>
                 </div>
                  `
                     : ``
                 }
                 
             </div>
             <div class="col-sm-6">
                 <div><strong id="detailTitle">${req.title}</strong>
                     <div class="muted small" id="detailMeta">${
                       req.company
                     } • submitted ${req.date}</div>
                     <div class="mt-2">
                     ${
                       req.status === "pending"
                         ? '<span class="status-pill pending">Pending</span>'
                         : req.status === "approved"
                         ? '<span class="status-pill approved">Approved</span>'
                         : '<span class="status-pill rejected">Declined</span>'
                     }
                     </div>
                 </div>
                 <div style="margin-top:10px"><strong>VIN</strong>
                     <div class="small" id="detailVin">${req.vin}</div>
                 </div>
                 <div style="margin-top:10px"><strong>Submitted by</strong>
                     <div class="small" id="detailUser">${
                       req.fullname
                     }. (dealer:${req.company})</div>
                 </div>

                 ${
                   req.status == "approved"
                     ? `
                  <div style="margin-top:10px"><strong>Documents</strong>
                     <ul id="detailDocs" style="margin:6px 0 0 14px">
                     ${
                       docs &&
                       docs
                         .map(
                           (d, i) =>
                             `<li><a href="${d}">Document ${i + 1}</a></li>`
                         )
                         .join("")
                     }
                     </ul>
                 </div>
                  
                  `
                     : ``
                 }
                 
                 <div style="margin-top:12px"><strong>Notes</strong>
                     <div id="detailNotes" class="muted small">
                     ${req.notes ?? "-"}</div>
                 </div>
             </div>
         </div>
     </div> 
     </div>   
    `;

      $("#displayDetails").modal("show");

      document.addEventListener("click", (e) => {
        if (e.target?.id === "approveBtn")
          Verification.processDecision(
            e.target.dataset.target,
            "approved",
            true
          );
        if (e.target?.id === "declineBtn")
          Verification.processDecision(
            e.target.dataset.target,
            "declined",
            true
          );
      });
    } catch (error) {
      console.error("Error opening detail modal:", error);
    }
  }

  /**
   * Process admin decision (approve/decline) for a verification request.
   * @param {string} id
   * @param {string} decision
   * @param {boolean} fromModal
   */
  static async processDecision(id, decision, fromModal = false) {
    try {
      const idx = Application.DATA.verifications.findIndex(
        (r) => r.request_id === id
      );
      if (idx === -1) {
        Utility.toast("Request not available", "error");
        return;
      }

      if (fromModal) $("#displayDetails").modal("hide");

      const result = await Utility.confirm("Update changes");
      if (!result.isConfirmed) {
        if (fromModal) $("#displayDetails").modal("show");
        return;
      }

      const response = await DataTransfer(
        `${CONFIG.API}/admin/verification/${id}`,
        { status: decision },
        "PATCH"
      );

      Utility.toast(
        response.message,
        response.status === 200 ? "success" : "error"
      );

      if (response.status === 200) {
        await clearAppData();
        await Application.initializeData();
        Verification.statistics();
        Verification.renderTable(Application.DATA.verifications);
      }
    } catch (error) {
      console.error("Error processing decision:", error);
      Utility.toast("Failed to update verification", "error");
    }
  }
}
