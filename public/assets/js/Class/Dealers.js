import Utility from "./Utility.js";
import AppInit from "./Application.js";

export default class DealerInit {
  static VIEW = "grid";

  static SELECTED = new Set();
  static el = (id) => document.getElementById(id);
  static KEY = "10over10_dealer";
  static apps = JSON.parse(localStorage.getItem(DealerInit.KEY) || "[]");

  static getFiltered() {
    const q = (DealerInit.el("q").value || "").toLowerCase();
    const status = DealerInit.el("statusFilter").value;
    const sort = DealerInit.el("sortBy").value;
    let rows = AppInit.DATA.dealers.filter((d) => {
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
    return rows;
  }

  // ------ Grid view
  static renderGrid() {
    const mount = DealerInit.el("gridView");
    mount.innerHTML = "";
    const rows = DealerInit.getFiltered();
    rows.forEach((d) => {
      const card = document.createElement("div");
      card.className = "dealer";
      card.setAttribute("data-aos", "fade-up");
      card.innerHTML = `
        <div class='banner'>
          <img src='${d.banner}&sat=-20' alt='banner of ${d.company}'/>
          <div class='avatar'><img src='${d.avatar}' alt='${d.company}'/></div>
        </div>
        <div class='body' style='margin-top:12px'>
          <div style='display:flex;justify-content:space-between;align-items:center'>
            <div>
              <div class='name'>${d.company}</div>
              <div class='small muted'>${d.state} • ${d.contact}</div>
            </div>
            <span class='tag ${d.status}'>${d.status}</span>
          </div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'>
            <span><i class='bi bi-car-front'></i> ${AppInit.fmt(
              d.listings
            )} listings</span>
            <span><i class='bi bi-star-fill'></i> ${d.rating}</span>
            <span><i class='bi bi-calendar3'></i> Joined ${d.joined}</span>
          </div>
          <div class='actions'>
            <button class='ghost' data-view='${d.id}'>View</button>
            ${
              d.status !== "approved"
                ? `<button class='ghost' data-approve='${d.id}'>Approve</button>`
                : ""
            }
            ${
              d.status !== "suspended"
                ? `<button class='ghost' data-suspend='${d.id}'>Suspend</button>`
                : ""
            }
            <button class='ghost' data-delete='${d.id}'>Delete</button>
          </div>
        </div>`;
      mount.appendChild(card);
    });
  }

  static renderTable() {
    const wrap = document.querySelector("#dealersTable tbody");
    wrap.innerHTML = "";
    const rows = DealerInit.getFiltered();
    const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
    const slice = rows.slice(start, start + AppInit.PER_PAGE);
    slice.forEach((d) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><input type='checkbox' data-sel='${d.id}' ${
        DealerInit.SELECTED.has(d.id) ? "checked" : ""
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
        <td>${AppInit.fmt(d.listings)}</td>
        <td>${d.rating}</td>
        <td><span class='tag ${d.status}'>${d.status}</span></td>
        <td><button class='ghost' data-view='${d.id}'>View</button>${
        d.status !== "approved"
          ? `<button class='ghost' data-approve='${d.id}'>Approve</button>`
          : ""
      }${
        d.status !== "suspended"
          ? `<button class='ghost' data-suspend='${d.id}'>Suspend</button>`
          : ""
      }<button class='ghost' data-delete='${d.id}'>Delete</button></td>`;
      wrap.appendChild(tr);
    });
    DealerInit.el(
      "pgInfo"
    ).textContent = `Page ${AppInit.PAGE} • Showing ${slice.length} of ${rows.length}`;
  }

  static openDetail(id) {
    const d = AppInit.DATA.dealers.find((x) => x.id === id);
    if (!d) return;
    const body = DealerInit.el("detailBody");
    body.innerHTML = `
      <div style='display:grid;grid-template-columns:120px 1fr;gap:12px'>
        <img src='${
          d.avatar
        }' style='width:120px;height:120px;border-radius:14px;object-fit:cover' alt='${
      d.company
    }'/>
        <div>
          <div style='font-weight:800'>${d.company}</div>
          <div class='small muted'>${d.contact} • ${d.phone}</div>
          <div class='small muted'>${d.state} • Joined ${d.joined}</div>
          <div style='margin-top:8px' class='small'>${d.about}</div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'><span><i class='bi bi-car-front'></i> ${AppInit.fmt(
            d.listings
          )} listings</span><span><i class='bi bi-star-fill'></i> ${
      d.rating
    }</span><span>Status: <span class='tag ${d.status}'>${
      d.status
    }</span></span></div>
        </div>
      </div>`;
    DealerInit.el("approveBtn").dataset.id = id;
    DealerInit.el("suspendBtn").dataset.id = id;
    DealerInit.el("deleteBtn").dataset.id = id;
    DealerInit.el("detailModalDealer").classList.add("open");
    DealerInit.el("detailModalDealer").setAttribute("aria-hidden", "false");

    document
      .querySelectorAll("[data-close]")
      .forEach((b) =>
        b.addEventListener("click", () =>
          document.querySelector(".modal.open").classList.remove("open")
        )
      );
  }

  static openModal(id) {
    DealerInit.el(id).classList.add("open");
  }

  static closeModal(id) {
    DealerInit.el(id).classList.remove("open");
  }

  static approve(id) {
    const d = AppInit.DATA.dealers.find((x) => x.id === id);
    if (!d) return;
    d.status = "approved";
    AppInit.toast("Dealer approved", "success");
    new Dealer().renderStats();
    DealerInit.VIEW === "grid"
      ? DealerInit.renderGrid()
      : DealerInit.renderTable();
  }

  static suspend(id) {
    const d = AppInit.DATA.dealers.find((x) => x.id === id);
    if (!d) return;
    d.status = "suspended";
    AppInit.toast("Dealer suspended", "info");
    new Dealer().renderStats();
    DealerInit.VIEW === "grid"
      ? DealerInit.renderGrid()
      : DealerInit.renderTable();
  }

  static removeDealer(id) {
    const idx = AppInit.DATA.dealers.findIndex((x) => x.id === id);
    if (idx > -1) {
      AppInit.DATA.dealers.splice(idx, 1);
      AppInit.toast("Dealer deleted", "success");
      new Dealer().renderStats();
      DealerInit.VIEW === "grid"
        ? DealerInit.renderGrid()
        : DealerInit.renderTable();
    }
  }
}

class Dealer {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderDealerOverview() {
    const wrap = document.getElementById("dealerList");
    if (!wrap) return;
    wrap.innerHTML = "";

    AppInit.DATA.dealers.forEach((d) => {
      const row = document.createElement("div");
      row.style.display = "flex";
      row.style.justifyContent = "space-between";
      row.style.alignItems = "center";
      row.style.padding = "8px 0";
      row.innerHTML = `<div><strong>${
        d.company
      }</strong><div class='muted small'>${
        d.contact
      }</div></div><div style='display:flex;gap:8px'><span class='muted small' style='padding:.25rem .5rem;border-radius:6px'>${
        d.status
      }</span>${
        d.status === "pending"
          ? `<button class='btn btn-primary' data-approve='${d.id}'>Approve</button>`
          : ""
      }</div>`;
      wrap.appendChild(row);
    });
  }

  renderStats() {
    const domEl = document.getElementById("sTotal");
    if (!domEl) return;
    DealerInit.el("sTotal").textContent = AppInit.DATA.dealers.length;
    DealerInit.el("sApproved").textContent = AppInit.DATA.dealers.filter(
      (d) => d.status === "approved"
    ).length;
    DealerInit.el("sPending").textContent = AppInit.DATA.dealers.filter(
      (d) => d.status === "pending"
    ).length;
    DealerInit.el("sSuspended").textContent = AppInit.DATA.dealers.filter(
      (d) => d.status === "suspended"
    ).length;
  }

  renderDataSwitchView() {
    const toggleViewBtn = DealerInit.el("toggleView");
    if (!toggleViewBtn) return;

    DealerInit.renderGrid();
    console.log("running");
    toggleViewBtn.addEventListener("click", () => {
      DealerInit.VIEW = DealerInit.VIEW === "grid" ? "table" : "grid";
      DealerInit.el("gridView").style.display =
        DealerInit.VIEW === "grid" ? "grid" : "none";
      DealerInit.el("tableView").style.display =
        DealerInit.VIEW === "table" ? "block" : "none";
      toggleViewBtn.innerHTML =
        DealerInit.VIEW === "grid"
          ? '<i class="bi bi-grid"></i> Grid'
          : '<i class="bi bi-table"></i> Table';
      if (DealerInit.VIEW === "grid") DealerInit.renderGrid();
      else DealerInit.renderTable();
    });

    // ------ Search & filters
    ["q", "statusFilter", "sortBy"].forEach((id) =>
      DealerInit.el(id).addEventListener("input", () => {
        AppInit.PAGE = 1;
        DealerInit.VIEW === "grid"
          ? DealerInit.renderGrid()
          : DealerInit.renderTable();
      })
    );
  }

  dealerEventDelegation() {
    // table/grid event delegation
    document.addEventListener("click", (e) => {
      const v = e.target.closest("[data-view]");
      if (v) {
        DealerInit.openDetail(v.dataset.view);
        return;
      }
      const ap = e.target.closest("[data-approve]");
      if (ap) {
        DealerInit.approve(ap.dataset.approve);
        return;
      }
      const sp = e.target.closest("[data-suspend]");
      if (sp) {
        DealerInit.suspend(sp.dataset.suspend);
        return;
      }
      const del = e.target.closest("[data-delete]");
      if (del) {
        DealerInit.removeDealer(del.dataset.delete);
        return;
      }
      const sel = e.target.closest("[data-sel]");
      if (sel) {
        if (e.target.checked) DealerInit.SELECTED.add(sel.dataset.sel);
        else DealerInit.SELECTED.delete(sel.dataset.sel);
      }
    });

    DealerInit.el("approveBtn").addEventListener("click", () =>
      DealerInit.approve(el("approveBtn").dataset.id)
    );
    DealerInit.el("suspendBtn").addEventListener("click", () =>
      DealerInit.suspend(el("suspendBtn").dataset.id)
    );
    DealerInit.el("deleteBtn").addEventListener("click", () =>
      DealerInit.removeDealer(el("deleteBtn").dataset.id)
    );
  }

  bulkActionsEvent() {
    // ------ Bulk actions

    DealerInit.el("selAll")?.addEventListener("change", (e) => {
      const rows = document.querySelectorAll("[data-sel]");
      rows.forEach((cb) => {
        cb.checked = e.target.checked;
        if (e.target.checked) DealerInit.SELECTED.add(cb.dataset.sel);
        else DealerInit.SELECTED.delete(cb.dataset.sel);
      });
    });
    DealerInit.el("bulkApprove")?.addEventListener("click", () => {
      if (!DealerInit.SELECTED.size)
        return AppInit.toast("Select dealers first", "error");

      DealerInit.SELECTED.forEach(window.approve);
      DealerInit.SELECTED.clear();
      DealerInit.renderTable();
    });
    DealerInit.el("bulkSuspend")?.addEventListener("click", () => {
      if (!DealerInit.SELECTED.size)
        return AppInit.toast("Select dealers first", "error");
      DealerInit.SELECTED.forEach(suspend);
      DealerInit.SELECTED.clear();
      DealerInit.renderTable();
    });
  }

  exportASCSV() {
    // ------ Export CSV (demo)
    DealerInit.el("exportCsv")?.addEventListener("click", () => {
      const headers = [
        "id",
        "name",
        "email",
        "phone",
        "state",
        "listings",
        "rating",
        "status",
        "joined",
      ];
      const rows = DealerInit.getFiltered().map((d) =>
        headers.map((h) => d[h])
      );
      const csv = [
        headers.join(","),
        ...rows.map((r) =>
          r.map((v) => `"${String(v).replace(/"/g, '""')}"`).join(",")
        ),
      ].join("\n");
      const blob = new Blob([csv], {
        type: "text/csv",
      });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "dealers.csv";
      a.click();
      URL.revokeObjectURL(url);
      toast("CSV downloaded (demo)", "success");
    });
  }

  // createADealer() {
  //   // ------ Add dealer flow (demo)
  //   const domEl = document.getElementById("addDealerBtn");
  //   if (!domEl) return;
  //   document
  //     .getElementById("addDealerBtn")
  //     .addEventListener("click", () =>
  //       DealerInit.el("addModal").classList.add("open")
  //     );
  //   DealerInit.el("addForm").addEventListener("submit", (e) => {
  //     e.preventDefault();
  //     const f = new FormData(e.target);
  //     const id = "DL-" + (1000 + AppInit.DATA.dealers.length + 1);
  //     AppInit.DATA.dealers.unshift({
  //       id,
  //       company: f.get("name"),
  //       contact: f.get("email"),
  //       phone: f.get("phone"),
  //       state: f.get("state"),
  //       listings: 0,
  //       rating: "4.0",
  //       status: "pending",
  //       banner:
  //         "https://images.unsplash.com/photo-1525609004556-c46c7d6cf023?q=80&w=1200&auto=format&fit=crop",
  //       avatar: `https://i.pravatar.cc/150?img=${
  //         Math.floor(Math.random() * 70) + 1
  //       }`,
  //       about: f.get("about") || "Newly added dealer",
  //       joined: new Date().toISOString().slice(0, 10),
  //     });
  //     AppInit.toast("Dealer added (pending approval)", "success");
  //     DealerInit.el("addModal").classList.remove("open");
  //     e.target.reset();
  //     new Dealer().renderStats();
  //     DealerInit.VIEW === "grid"
  //       ? DealerInit.renderGrid()
  //       : DealerInit.renderTable();
  //   });
  // }
  //_______Dealer Page
  openApplyRequirement() {
    const domEl = document.querySelector(".dealerPage");
    if (!domEl) return;
    document
      .getElementById("openApply")
      .addEventListener("click", () => DealerInit.openModal("editFormModal"));
    document
      .getElementById("viewReqs")
      .addEventListener("click", () => DealerInit.openModal("reqModal"));

    // There is no editFormModal defined — using confirm flow directly
    document
      .getElementById("openApply")
      .addEventListener("click", () => DealerInit.openModal("confirmModal"));
  }

  fileInputPreview() {
    // file input preview
    const docInput = document.getElementById("docInput");
    if (!docInput) return;

    docInput.addEventListener("change", (e) => {
      const list = DealerInit.el("preview");
      list.innerHTML = "";
      Array.from(e.target.files)
        .slice(0, 6)
        .forEach((file) => {
          const ext = file.name.split(".").pop().toLowerCase();
          if (ext === "pdf") {
            const div = document.createElement("div");
            div.textContent = file.name;
            div.style.padding = "8px";
            div.style.border = "1px solid rgba(15,23,36,0.06)";
            div.style.borderRadius = "8px";
            list.appendChild(div);
          } else {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);
            list.appendChild(img);
          }
        });
    });
  }
  newDealerFormSubmitFlow() {
    // form submit flow
    const form = document.getElementById("dealerForm");
    if (!form) return;
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      DealerInit.openModal("confirmModal");
      // store form temporarily in dataset for confirm
      const fd = new FormData(form);
      const tmp = {};
      fd.forEach((v, k) => (tmp[k] = v));
      document.body.dataset._dealer_tmp = JSON.stringify(tmp);
    });

    document.getElementById("confirmSubmit").addEventListener("click", () => {
      const tmp = JSON.parse(document.body.dataset._dealer_tmp || "{}");
      if (!tmp.fullname || !tmp.business || !tmp.email || !tmp.phone) {
        AppInit.toast("Please complete required fields", "error");
        DealerInit.closeModal("confirmModal");
        return;
      }
      const app = {
        id: "A" + Math.random().toString(36).slice(2, 9).toUpperCase(),
        status: "Pending",
        submitted: new Date().toISOString(),
        data: tmp,
      };
      DealerInit.apps.unshift(app);
      localStorage.setItem(DealerInit.KEY, JSON.stringify(DealerInit.apps));
      this.renderApps();
      AppInit.toast("Application submitted (demo)", "success");
      DealerInit.closeModal("confirmModal");
      // update status badge
      DealerInit.el("statusBadge").textContent = "Pending review";
    });
  }
  saveToDraft() {
    // save draft
    const form = document.getElementById("dealerForm");
    if (!form) return;
    DealerInit.el("saveDraft")?.addEventListener("click", () => {
      const fd = new FormData(form);
      const tmp = {};
      fd.forEach((v, k) => (tmp[k] = v));
      localStorage.setItem("dealer_draft", JSON.stringify(tmp));
      AppInit.toast("Draft saved locally", "info");
    });
  }

  loadDraft() {
    const d = localStorage.getItem("dealer_draft");
    if (d) {
      try {
        const obj = JSON.parse(d);
        for (const k in obj) {
          if (form[k]) form[k].value = obj[k];
        }
        AppInit.toast("Loaded saved draft", "info");
      } catch (e) {}
    }
  }

  renderApps() {
    const mount = DealerInit.el("applications");
    const data = JSON.parse(localStorage.getItem(DealerInit.KEY) || "[]");
    if (!data.length) {
      mount.innerHTML = '<div class="muted small">No applications yet</div>';
      return;
    }
    mount.innerHTML = "";
    data.forEach((a) => {
      const div = document.createElement("div");
      div.style.display = "flex";
      div.style.justifyContent = "space-between";
      div.style.alignItems = "center";
      div.style.padding = "8px 0";
      div.innerHTML = `<div><strong>${
        a.id
      }</strong> <div class="muted small">${new Date(
        a.submitted
      ).toLocaleString()}</div></div><div><span class="muted small">${
        a.status
      }</span></div>`;
      mount.appendChild(div);
    });
  }

  outsideClickCLoseModal() {
    document.addEventListener("click", (e) => {
      if (e.target.classList.contains("modal"))
        e.target.classList.remove("open");
    });
  }

  howItWorksButtonClick() {
    DealerInit.el("howItWorks")?.addEventListener("click", () => {
      AppInit.toast(
        "Demo: Verification typically includes document review, KYC and contract execution."
      );
    });
  }
}

new Dealer();
