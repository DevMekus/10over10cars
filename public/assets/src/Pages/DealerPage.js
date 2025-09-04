import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";

import Dealer from "../Classes/Dealer.js";
import { clearAppData } from "../Utils/Session.js";

class DealerPage {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);

    //---make function available for onclick
    window.openDetail = Dealer.openDetail;
  }

  pageStatistics() {
    const domEl = document.getElementById("sTotal");
    if (!domEl) return;
    const data = Application.DATA.dealers;
    Dealer.renderStats(data);
  }

  switchDataView() {
    const toggleViewBtn = Utility.el("toggleView");
    if (!toggleViewBtn) return;
    Dealer.renderGrid();

    toggleViewBtn.addEventListener("click", () => {
      Dealer.VIEW = Dealer.VIEW === "grid" ? "table" : "grid";

      //---Applying CSS styles

      Utility.el("gridView").style.display =
        Dealer.VIEW === "grid" ? "grid" : "none";
      Utility.el("tableView").style.display =
        Dealer.VIEW === "table" ? "block" : "none";

      toggleViewBtn.innerHTML =
        Dealer.VIEW === "grid"
          ? '<i class="bi bi-grid"></i> Grid'
          : '<i class="bi bi-table"></i> Table';

      if (Dealer.VIEW === "grid") Dealer.renderGrid();
      else Dealer.renderTable();
    });

    // ------ Search & filters
    Dealer.searchAndFilter();
  }

  dealerEventDelegation() {
    document.addEventListener("click", (e) => {
      const v = e.target.closest("[data-view]");
      if (v) {
        Dealer.openDetail(v.dataset.view);
        return;
      }
      const ap = e.target.closest("[data-approve]");
      if (ap) {
        Dealer.updateDealerStatus(ap.dataset.approve, "approved");
        return;
      }
      const sp = e.target.closest("[data-suspend]");
      if (sp) {
        Dealer.updateDealerStatus(sp.dataset.suspend, "suspended");
        return;
      }
      const del = e.target.closest("[data-delete]");
      if (del) {
        Dealer.deleteDealer(del.dataset.delete);
        return;
      }
      const sel = e.target.closest("[data-sel]");
      if (sel) {
        if (e.target.checked) Dealer.SELECTED.add(sel.dataset.sel);
        else Dealer.SELECTED.delete(sel.dataset.sel);
      }
    });

    //---Exposing events to Modals too

    Utility.el("approveBtn").addEventListener("click", () =>
      Dealer.updateDealerStatus(Utility.el("approveBtn").dataset.id, "approved")
    );
    Utility.el("suspendBtn").addEventListener("click", () =>
      Dealer.updateDealerStatus(
        Utility.el("suspendBtn").dataset.id,
        "suspended"
      )
    );
    Utility.el("deleteBtn").addEventListener("click", () =>
      Dealer.deleteDealer(Utility.el("deleteBtn").dataset.id)
    );
  }

  bulkActionsEvent() {
    // ------ Bulk actions

    Utility.el("selAll")?.addEventListener("change", (e) => {
      const rows = document.querySelectorAll("[data-sel]");
      rows.forEach((cb) => {
        cb.checked = e.target.checked;
        if (e.target.checked) Dealer.SELECTED.add(cb.dataset.sel);
        else Dealer.SELECTED.delete(cb.dataset.sel);
      });
    });

    Utility.el("bulkApprove")?.addEventListener("click", () => {
      if (!Dealer.SELECTED.size)
        return Utility.toast("Select dealers first", "error");

      //--handle this better
      Dealer.SELECTED.forEach(window.approve);
      Dealer.SELECTED.clear();
      Dealer.renderTable();
    });

    Utility.el("bulkSuspend")?.addEventListener("click", () => {
      if (!Dealer.SELECTED.size)
        return Utility.toast("Select dealers first", "error");
      //--handle this better
      Dealer.SELECTED.forEach(suspend);
      Dealer.SELECTED.clear();
      Dealer.renderTable();
    });
  }

  exportASCSV() {
    Utility.el("exportCsv")?.addEventListener("click", () => {
      Utility.exportToCSV(Dealer.currentData, "dealer.csv");
    });
  }

  //_______New Dealer Page

  newDealerFormSubmitFlow() {
    const formEl = document.getElementById("dealerForm");
    let formData = null;
    if (!formEl) return;
    formEl.addEventListener("submit", async (e) => {
      e.preventDefault();

      formData = new FormData(formEl);
      const tmp = {};
      formData.forEach((v, k) => {
        if (!tmp[k] || tmp[k] == "") {
          Utility.toast("Please complete required fields", "error");
          return;
        }
      });

      const newDealer = await Dealer.saveNewDealer(formData);

      if (newDealer.status == 200) {
        await clearAppData();
        await Application.initializeData();
      }
    });
  }

  renderPendingApplications() {
    const mount = Utility.el("applications");
    if (!mount) return;
    const data = Application.DATA.dealers.filter(
      (apps) => apps.status === "pending"
    );

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
      div.innerHTML = `<div><strong>Apx-${
        a.id
      }</strong> <div class="muted small">${new Date(
        a.joined
      ).toLocaleString()}</div></div><div><span class="muted small">${
        a.status
      }</span></div>`;
      mount.appendChild(div);
    });
  }
}

new DealerPage();
