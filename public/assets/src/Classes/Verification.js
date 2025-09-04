import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Vehicle from "../Classes/Vehicle.js";
import { CONFIG } from "../Utils/config.js";
import { DataTransfer } from "../Utils/api.js";
import { clearAppData } from "../Utils/Session.js";

export default class Verification {
  static statistics() {
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
  }
  static renderTable(data) {
    const tbody = document.querySelector("#reqTable tbody");
    const noData = document.querySelector(".no-data");
    if (!tbody) return;
    tbody.innerHTML = "";
    noData.innerHTML = "";
    const q = (document.getElementById("qSearch").value || "").toLowerCase();
    const statusFilter = document.getElementById("statusFilter").value;
    const from = document.getElementById("fromDate").value;
    const to = document.getElementById("toDate").value;

    let filtered = data.filter((r) => {
      if (statusFilter !== "all" && r.status !== statusFilter) return false;
      if (q && !`${r.vin} ${r.title} ${r.user}`.toLowerCase().includes(q))
        return false;
      if (from && r.date < from) return false;
      if (to && r.date > to) return false;
      return true;
    });

    const totalFiltered = filtered.length;
    if (totalFiltered == 0) {
      Utility.renderEmptyState(noData);
      return;
    }

    document.getElementById("totalCount").textContent = totalFiltered;
    const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
    const slice = filtered.slice(start, start + Utility.PER_PAGE);
    document.getElementById("showingCount").textContent = slice.length;

    slice.forEach((r) => {
      const tr = document.createElement("tr");
      const images = JSON.parse(r.images);
      tr.innerHTML = `
          <td><code>${r.request_id}</code></td>
          <td><strong>${r.vin}</strong></td>
          <td>
          <div style="display:flex;gap:8px;align-items:center">
          <img src="${
            images[0]
          }" alt="thumb" style="width:84px;height:56px;object-fit:cover;border-radius:6px"> <div>
          <strong>${r.title}</strong><div class='muted small'>
          ${r.company ?? "---"}</div></div></div>
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
              <button class="btn btn-sm btn-primary" 
              data-view='${r.request_id}'>View</button>
              ${
                r.status === "pending"
                  ? `<button class="btn btn-sm btn-ghost" data-approve='${r.request_id}'>Approve</button>
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
  }

  static controlPagination(data) {
    // ---------- Pagination controls ----------
    document.getElementById("prevPage")?.addEventListener("click", () => {
      if (Utility.PAGE > 1) Utility.PAGE--;
      Verification.renderTable(data);
    });
    document.getElementById("nextPage")?.addEventListener("click", () => {
      if (Utility.PAGE < Utility.pageCount(data)) Utility.PAGE++;
      Verification.renderTable(data);
    });
  }

  static filterAndSearch(data) {
    // ---------- Search / filters ----------
    ["qSearch", "statusFilter", "fromDate", "toDate"].forEach((id) =>
      document.getElementById(id)?.addEventListener("input", () => {
        Utility.PAGE = 1;
        Verification.renderTable(data);
      })
    );
  }

  static async verificationResult(vin) {
    const find = await Vehicle.findParticularCar(vin);

    if (!find) {
      const notFound = document.getElementById("noResult");
      Utility.renderEmptyState(notFound);
      return false;
    }
    const data = find[0];
    const images = JSON.parse(data.images);

    document.getElementById("noResult").style.display = "none";
    document.getElementById("resultArea").style.display = "block";
    document.getElementById("vehTitle").innerHTML = data.title;
    document.getElementById("vehVin").textContent = data.vin;
    document.getElementById("vehOwner").textContent = data.company;
    document.getElementById("vehPrice").textContent =
      "NGN " + Number(data.price).toLocaleString();
    document.getElementById("vehYear").textContent = data.year;
    document.getElementById("vehMileage").textContent =
      data.mileage.toLocaleString();
    document.getElementById("vehEngine").textContent = data.engine;
    document.getElementById("vehStatus").textContent =
      data.status == "approved" ? "Clean" : "Flagged";
    document.getElementById("vehStatus").className =
      "status-pill " +
      (data.status == "approved" ? "status-clean" : "status-flag");

    document.getElementById(
      "vehMedia"
    ).innerHTML = `<img src="${images[0]}" alt="vehicle" />`;
    document.getElementById("actionButtons").innerHTML = `
          <div style="display:flex;gap:8px;margin-top:12px">
            <button id="saveToHistory" class="btn btn-sm btn-outline-error">Save to history</button>

            <a href="${CONFIG.BASE_URL}/secure/payment?vin=${vin}" class="btn" style="background:var(--primary);color:var(--text)">Start Verification</a>
        </div>
    `;

    return true;
  }

  static verificationHistory(filtered) {
    const list = document.getElementById("historyList");
    if (!list) return;
    list.innerHTML = "";

    filtered.slice(0, 12).forEach((it) => {
      const div = document.createElement("div");
      div.className = "history-item";
      div.innerHTML = `<div><strong>${Utility.escapeHtml(
        it.title
      )}</strong><div class='muted small'>${it.vin} • ${new Date(
        it.request_date
      ).toLocaleString()}</div></div><div style="display:flex;gap:6px"><button class="btn btn-sm btn-ghost" data-retry="${
        it.vin
      }"><i class='bi bi-arrow-repeat'></i></button></div>`;
      list.appendChild(div);
    });
    if (!filtered.length)
      list.innerHTML = '<div class="muted small">No matches</div>';
  }

  static saveHistoryButton() {
    // save to history button
    const vin = document.getElementById("vehVin").textContent;
    if (!vin || vin === "--") {
      Utility.toast("Nothing to save", "error");
      return;
    }
    const record = {
      vin,
      title: document.getElementById("vehTitle").textContent,
      when: new Date().toISOString(),
      raw: document.getElementById("rawDetail").textContent
        ? JSON.parse(document.getElementById("rawDetail").textContent)
        : {},
    };
    const items = Verification.loadHistory();
    items.unshift(record);
    Verification.saveHistory(items);
    Verification.verificationHistory();
    Utility.toast("Saved lookup to history");
  }

  static loadHistory() {
    try {
      return JSON.parse(localStorage.getItem(CONFIG.HISTORY_KEY)) || [];
    } catch (e) {
      return [];
    }
  }

  static saveHistory(items) {
    localStorage.setItem(Utility.HISTORY_KEY, JSON.stringify(items));
  }

  static async clearHistory() {
    const history = Verification.loadHistory();
    if (history.length == 0) {
      Utility.toast("You have no saved history");
      return;
    }
    // clear history
    const result = await Utility.confirm("Clear all local history?");
    if (result.isConfirmed) {
      Verification.saveHistory([]);
      Verification.verificationHistory([]);
      Utility.toast("History cleared");
    }
  }

  static openDetail(id) {
    const req = Application.DATA.verifications.find((r) => r.request_id === id);
    if (!req) {
      Utility.toast("Request not available", "error");
      return;
    }

    const domBody = Utility.el("detailModalBody");
    const images = req.images ? JSON.parse(req.images) : null;
    const docs = req.documents ? JSON.parse(req.documents) : null;
    let title = Utility.el("detailModalLabel");

    title.innerHTML = "";
    domBody.innerHTML = "";
    title.textContent = `Verification details: (${id})`;
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
                 <div style="margin-top:10px;display:flex;gap:8px">
                 <button class="btn btn-primary btn-pill"  data-target="${id}" id="approveBtn">Approve</button>
                 <button class="btn btn-ghost" data-target="${id}" id="declineBtn">Decline</button></div>
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
      if (e.target && e.target.id === "approveBtn") {
        Verification.processDecision(e.target.dataset.target, "approved", true);
      }
      if (e.target && e.target.id === "declineBtn") {
        Verification.processDecision(e.target.dataset.target, "declined", true);
      }
    });
  }

  static async processDecision(id, decision, fromModal = false) {
    const idx = Application.DATA.verifications.findIndex(
      (r) => r.request_id === id
    );
    if (idx === -1) {
      Utility.toast("Request not available", "error");
      return;
    }

    if (fromModal) $("#displayDetails").modal("hide");
    const result = await Utility.confirm("Update changes");

    if (result.isConfirmed) {
      const response = await DataTransfer(
        `${CONFIG.API}/admin/verification/${id}`,
        { status: decision },
        "PATCH"
      );

      console.log(response);

      Utility.toast(
        response.message,
        response.status == 200 ? "success" : "error"
      );

      if (response.status == 200) {
        await clearAppData();
        await Application.initializeData();
        Verification.statistics();
        Verification.renderTable(Application.DATA.verifications);
      }
    } else {
      if (fromModal) $("#displayDetails").modal("show");
    }
  }
}
