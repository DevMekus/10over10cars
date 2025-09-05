import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";

import { CONFIG } from "../Utils/config.js";
import { clearAppData } from "../Utils/Session.js";
import { DataTransfer } from "../Utils/api.js";

export default class Dealer {
  static VIEW = "grid";
  static SELECTED = new Set();
  static currentData = null;
  static currentPage = 1;
  static pageSize = 10; // dealers per page

  static getFiltered() {
    const q = (Utility.el("q").value || "").toLowerCase();
    const status = Utility.el("statusFilter").value;
    const sort = Utility.el("sortBy").value;
    let rows = Application.DATA.dealers.filter((d) => {
      if (
        q &&
        !(
          d.name.toLowerCase().includes(q) ||
          d.email.toLowerCase().includes(q) ||
          d.phone.includes(q)
        )
      )
        return false;
      if (status !== "all" && d.status !== status) return false;
      return true;
    });

    rows.sort((a, b) => {
      if (sort === "name") return a.company.localeCompare(b.company);
      if (sort === "date") return a.joined.localeCompare(b.joined);
      if (sort === "listings") return b.listings - a.listings;
      if (sort === "rating") return b.rating - a.rating;
      return 0;
    });

    Dealer.currentData = rows;
    return rows;
  }

  static renderStats(data) {
    Utility.el("sTotal").textContent = data.length;

    Utility.el("sApproved").textContent = data.filter(
      (d) => d.status === "approved"
    ).length;
    Utility.el("sPending").textContent = data.filter(
      (d) => d.status === "pending"
    ).length;
    Utility.el("sSuspended").textContent = data.filter(
      (d) => d.status === "suspended"
    ).length;
  }

  static renderGrid() {
    const mount = Utility.el("gridView");
    const noData = document.querySelector(".no-data");
    mount.innerHTML = "";
    noData.innerHTML = "";

    const rows = Dealer.getFiltered();
    const totalRows = rows.length;

    if (totalRows === 0) {
      Utility.renderEmptyState(noData);
      return;
    }

    // Pagination slice
    const start = (Dealer.currentPage - 1) * Dealer.pageSize;
    const end = start + Dealer.pageSize;
    const paginatedRows = rows.slice(start, end);

    paginatedRows.forEach((d) => {
      const card = document.createElement("div");
      card.className = "dealer";
      card.setAttribute("data-aos", "fade-up");
      card.innerHTML = `
      <div class='banner'>
        <img src='${d.banner}' alt='banner of ${d.company}'/>
        <div class='avatar'><img src='${d.avatar}' alt='${d.company}'/></div>
      </div>
      <div class='body' style='margin-top:12px'>
        <div style='display:flex;justify-content:space-between;align-items:center'>
          <div>
            <div class='name'>${d.company}</div>
            <div class='small muted'>${d.state} • ${d.contact}</div>
          </div>
          <span class='tag ${d.status}'>
          ${Utility.toTitleCase(d.status)}</span>
        </div>
        <div style='display:flex;gap:12px;margin-top:8px' class='small muted'>
          <span><i class='bi bi-car-front'></i> ${Utility.fmt(
            d.listings
          )} listings</span>
          <span><i class='bi bi-star-fill'></i> ${d.rating}</span>
          <span><i class='bi bi-calendar3'></i> Joined ${
            d.joined.split(" ")[0]
          }</span>
        </div>
        <div class='action_btns mt-3'>
          <button class='btn btn-sm btn-outline-primary' data-view='${
            d.id
          }'><i class="fas fa-eye"></i></button>
          ${
            d.status !== "approved"
              ? `<button class='btn btn-sm btn-primary' data-approve='${d.id}'><i class="fas fa-check-circle approve"></i></button>`
              : ""
          }
          ${
            d.status !== "suspended"
              ? `<button class='btn btn-sm btn-outline-error' data-suspend='${d.id}'><i class="fas fa-times danger"></i></button>`
              : ""
          }
          <button class='btn btn-sm btn-error' data-delete='${
            d.id
          }'><i class="fas fa-trash"></i></button>
        </div>
      </div>`;
      mount.appendChild(card);
    });

    // Render pagination
    Dealer.renderPagination(totalRows);
  }

  static renderPagination(totalRows) {
    const paginationMount = Utility.el("pagination");
    if (!paginationMount) return;

    paginationMount.innerHTML = "";

    const totalPages = Math.ceil(totalRows / Dealer.pageSize);

    if (totalPages <= 1) return;

    // Prev button
    const prevBtn = document.createElement("button");
    prevBtn.textContent = "Prev";
    prevBtn.disabled = Dealer.currentPage === 1;
    prevBtn.onclick = () => {
      if (Dealer.currentPage > 1) {
        Dealer.currentPage--;
        Dealer.renderGrid();
      }
    };
    paginationMount.appendChild(prevBtn);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className = i === Dealer.currentPage ? "active" : "";
      btn.onclick = () => {
        Dealer.currentPage = i;
        Dealer.renderGrid();
      };
      paginationMount.appendChild(btn);
    }

    // Next button
    const nextBtn = document.createElement("button");
    nextBtn.textContent = "Next";
    nextBtn.disabled = Dealer.currentPage === totalPages;
    nextBtn.onclick = () => {
      if (Dealer.currentPage < totalPages) {
        Dealer.currentPage++;
        Dealer.renderGrid();
      }
    };
    paginationMount.appendChild(nextBtn);
  }

  static renderTable() {
    const wrap = document.querySelector("#dealersTable tbody");
    const noData = document.querySelector(".no-data");
    wrap.innerHTML = "";
    noData.innerHTML = "";

    const rows = Dealer.getFiltered();

    if (rows.length == 0) {
      Utility.renderEmptyState(noData);
      return;
    }
    const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
    const slice = rows.slice(start, start + Utility.PER_PAGE);
    slice.forEach((d) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><input type='checkbox' data-sel='${d.id}' ${
        Dealer.SELECTED.has(d.id) ? "checked" : ""
      }></td>
        <td><div style='display:flex;gap:8px;align-items:center'><img src='${
          d.avatar
        }' style='width:34px;height:34px;border-radius:8px;object-fit:cover' alt='${
        d.company
      }'/><div><div style='font-weight:700'>${
        d.company
      }</div><div class='small muted'>${d.state}</div></div></div></td>
        <td><div class='small'>${d.contact}</div><div class='small muted'>${
        d.phone
      }</div></td>
        <td>${Utility.fmt(d.listings)}</td>
        <td>${d.rating}</td>
        <td><span class='tag ${d.status}'>${d.status}</span></td>
        <td>
        <div class='action_btns mt-3'>
            <button class='btn btn-sm btn-outline-primary' data-view='${
              d.id
            }'><i class="fas fa-eye"></i></button>
            ${
              d.status !== "approved"
                ? `<button class='btn btn-sm btn-primary' data-approve='${d.id}'><i class="fas fa-check-circle approve"></i></button>`
                : ""
            }
            ${
              d.status !== "suspended"
                ? `<button class='btn btn-sm btn-outline-error' data-suspend='${d.id}'><i class="fas fa-times danger"></i></button>`
                : ""
            }
            <button class='btn btn-sm btn-error' data-delete='${
              d.id
            }'><i class="fas fa-trash"></i></button>
        </div>
      </td>`;
      wrap.appendChild(tr);
    });
    Utility.el(
      "pgInfo"
    ).textContent = `Page ${Utility.PAGE} • Showing ${slice.length} of ${rows.length}`;
  }

  static searchAndFilter() {
    ["q", "statusFilter", "sortBy"].forEach((id) =>
      Utility.el(id).addEventListener("input", () => {
        Utility.PAGE = 1;
        Dealer.VIEW === "grid" ? Dealer.renderGrid() : Dealer.renderTable();
      })
    );
  }

  static openDetail(id) {
    const d = Application.DATA.dealers.find((x) => x.id === id);
    if (!d) {
      Utility.toast("Dealer not found", "error");
      return;
    }
    const domBody = Utility.el("detailModalBody");
    const domFooter = Utility.el("detailModalButtons");
    let title = Utility.el("detailModalLabel");

    title.innerHTML = "";
    domBody.innerHTML = "";
    domFooter.innerHTML = "";

    title.textContent = `${d.company}`;
    domBody.innerHTML = `
      <div style='display:grid;grid-template-columns:120px 1fr;gap:12px'>
        <img src='${
          d.avatar
        }' style='width:120px;height:120px;border-radius:14px;object-fit:cover' 
        alt='${d.company}'/>
        <div>
          <div style='font-weight:800'>${d.company}</div>
          <div class='small muted'>${d.contact} • ${d.phone}</div>
          <div class='small muted'>${d.state} • Joined ${d.joined}</div>
          <div style='margin-top:8px' class='small'>${d.about}</div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'><span><i class='bi bi-car-front'></i> ${Utility.fmt(
            d.listings
          )} listings</span><span><i class='bi bi-star-fill'></i> ${
      d.rating
    }</span><span>Status: <span class='tag ${d.status}'>${
      d.status
    }</span></span></div>
        </div>
      </div>`;

    domFooter.innerHTML = `
     <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
             <button id="approveBtn" data-id="${id}" class="btn btn-pill btn-primary">Approve</button>
             <button id="suspendBtn" data-id="${id}" class="btn btn-ghost">Suspend</button>
             <button id="deleteBtn" data-id="${id}" class="btn btn-ghost">Delete</button>
      </div>
    
    `;
    //---Event Delegations
    $("#displayDetails").modal("show");

    document.addEventListener("click", (e) => {
      if (e.target && e.target.id === "approveBtn") {
        Dealer.updateDealerStatus(
          document.getElementById("approveBtn").dataset.id,
          "approved",
          true
        );
      }

      if (e.target && e.target.id === "suspendBtn") {
        Dealer.updateDealerStatus(
          document.getElementById("suspendBtn").dataset.id,
          "suspend",
          true
        );
      }

      if (e.target && e.target.id === "deleteBtn") {
        Dealer.deleteDealer(document.getElementById("deleteBtn").dataset.id);
      }
    });
  }

  static async updateDealerStatus(id, newStatus, fromModal = false) {
    const d = Application.DATA.dealers.find((x) => x.id === id);

    if (!d) {
      Utility.toast("Dealer not found", "error");
      return;
    }

    $("#displayDetails").modal("hide");

    const result = await Utility.confirm("Update Dealer");
    if (result.isConfirmed) {
      //---Send to Server
      const { status, message } = await DataTransfer(
        `${CONFIG.API}/admin/dealer/${id}`,
        { status: newStatus },
        "PATCH"
      );

      Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status == 200) {
        await clearAppData();
        await Application.initializeData();

        Dealer.renderStats(Application.DATA.dealers);
        Dealer.VIEW === "grid" ? Dealer.renderGrid() : Dealer.renderTable();
      }

      if (fromModal) $("#displayDetails").modal("hide");
    }
  }

  static async deleteDealer(id) {
    const d = Application.DATA.dealers.find((x) => x.id === id);

    if (!d) {
      Utility.toast("Dealer not found", "error");
      return;
    }

    $("#displayDetails").modal("hide");

    //---Send to Server
    const result = await Utility.confirm("Delete Dealer");
    if (result.isConfirmed) {
      const { status, message } = await DataTransfer(
        `${CONFIG.API}/admin/dealer/${id}`,
        {},
        "DELETE"
      );
      Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status == 200) {
        await clearAppData();
        await Application.initializeData();

        Dealer.renderStats(Application.DATA.dealers);
        Dealer.VIEW === "grid" ? Dealer.renderGrid() : Dealer.renderTable();
      }
    }
  }

  static async saveNewDealer(data) {
    //--- Send
    const result = await Utility.confirm(
      "New Dealer",
      "Do you want to save this dealer?"
    );

    if (result.isConfirmed) {
      const response = await DataTransfer(`${CONFIG.API}/dealer`, data, "POST");

      Utility.toast(
        `${response.message}`,
        `${response.status == 200 ? "success" : "error"}`
      );

      if (response.status == 200) {
        await clearAppData();
        await Application.initializeData();
      }

      Swal.fire(
        response.status == 200 ? "Success!" : "Error",
        `${response.message}`,
        response.status == 200 ? "success" : "error"
      );

      return response;
    }
  }
}
