import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Dealer from "../Classes/Dealer.js";
import { clearAppData, decryptJsToken } from "../Utils/Session.js";

/**
 * @class DealerPage
 * Handles dealer management page functionality including statistics, table/grid views,
 * bulk actions, individual dealer actions, new dealer submission, and pending applications.
 */
class DealerPage {
  constructor() {
    this.initialize();
  }

  /**
   * Initialize the page, load data, and bind global methods.
   */
  async initialize() {
    try {
      await Application.initializeData();
      Utility.runClassMethods(this, ["initialize"]);

      // Make Dealer.openDetail available globally for onclick usage
      window.openDetail = Dealer.openDetail;
    } catch (error) {
      console.error("Error initializing DealerPage:", error);
    }
  }

  /**
   * Render dealer page statistics.
   */
  pageStatistics() {
    try {
      const domEl = document.getElementById("sTotal");
      if (!domEl) return;

      const data = Application.DATA.dealers;
      Dealer.renderStats(data);
    } catch (error) {
      console.error("Error rendering page statistics:", error);
    }
  }

  /**
   * Switch between grid and table views.
   */
  switchDataView() {
    try {
      const toggleViewBtn = Utility.el("toggleView");
      if (!toggleViewBtn) return;

      Dealer.renderGrid();

      toggleViewBtn.addEventListener("click", () => {
        Dealer.VIEW = Dealer.VIEW === "grid" ? "table" : "grid";

        Utility.el("gridView").style.display =
          Dealer.VIEW === "grid" ? "grid" : "none";
        Utility.el("tableView").style.display =
          Dealer.VIEW === "table" ? "block" : "none";

        toggleViewBtn.innerHTML =
          Dealer.VIEW === "grid"
            ? '<i class="bi bi-grid"></i> Grid'
            : '<i class="bi bi-table"></i> Table';

        Dealer.VIEW === "grid" ? Dealer.renderGrid() : Dealer.renderTable();

        // Enable search and filter functionality
        Dealer.searchAndFilter();
      });
    } catch (error) {
      console.error("Error switching data view:", error);
    }
  }

  /**
   * Delegate dealer-related DOM events including approve, suspend, delete, and selection.
   */
  dealerEventDelegation() {
    try {
      document.addEventListener("click", (e) => {
        const target = e.target;

        const viewBtn = target.closest("[data-view]");
        if (viewBtn) {
          Dealer.openDetail(viewBtn.dataset.view);
          return;
        }

        const approveBtn = target.closest("[data-approve]");
        if (approveBtn) {
          Dealer.updateDealerStatus(approveBtn.dataset.approve, "approved");
          return;
        }

        const suspendBtn = target.closest("[data-suspend]");
        if (suspendBtn) {
          Dealer.updateDealerStatus(suspendBtn.dataset.suspend, "suspended");
          return;
        }

        const deleteBtn = target.closest("[data-delete]");
        if (deleteBtn) {
          Dealer.deleteDealer(deleteBtn.dataset.delete);
          return;
        }

        const selectBox = target.closest("[data-sel]");
        if (selectBox) {
          selectBox.checked
            ? Dealer.SELECTED.add(selectBox.dataset.sel)
            : Dealer.SELECTED.delete(selectBox.dataset.sel);
        }
      });

      // Modal buttons
      Utility.el("approveBtn")?.addEventListener("click", () =>
        Dealer.updateDealerStatus(
          Utility.el("approveBtn").dataset.id,
          "approved"
        )
      );
      Utility.el("suspendBtn")?.addEventListener("click", () =>
        Dealer.updateDealerStatus(
          Utility.el("suspendBtn").dataset.id,
          "suspended"
        )
      );
      Utility.el("deleteBtn")?.addEventListener("click", () =>
        Dealer.deleteDealer(Utility.el("deleteBtn").dataset.id)
      );
    } catch (error) {
      console.error("Error in dealer event delegation:", error);
    }
  }

  /**
   * Handle bulk actions like approve or suspend multiple dealers.
   */
  bulkActionsEvent() {
    try {
      Utility.el("selAll")?.addEventListener("change", (e) => {
        const rows = document.querySelectorAll("[data-sel]");
        rows.forEach((cb) => {
          cb.checked = e.target.checked;
          e.target.checked
            ? Dealer.SELECTED.add(cb.dataset.sel)
            : Dealer.SELECTED.delete(cb.dataset.sel);
        });
      });

      Utility.el("bulkApprove")?.addEventListener("click", () => {
        if (!Dealer.SELECTED.size)
          return Utility.toast("Select dealers first", "error");

        Dealer.SELECTED.forEach(window.approve);
        Dealer.SELECTED.clear();
        Dealer.renderTable();
      });

      Utility.el("bulkSuspend")?.addEventListener("click", () => {
        if (!Dealer.SELECTED.size)
          return Utility.toast("Select dealers first", "error");

        Dealer.SELECTED.forEach(suspend);
        Dealer.SELECTED.clear();
        Dealer.renderTable();
      });
    } catch (error) {
      console.error("Error handling bulk actions:", error);
    }
  }

  /**
   * Export dealer data as CSV.
   */
  exportASCSV() {
    try {
      Utility.el("exportCsv")?.addEventListener("click", () => {
        Utility.exportToCSV(Dealer.currentData, "dealer.csv");
      });
    } catch (error) {
      console.error("Error exporting CSV:", error);
    }
  }

  /**
   * Handle new dealer form submission.
   */
  newDealerFormSubmitFlow() {
    try {
      const formEl = document.getElementById("dealerForm");
      if (!formEl) return;

      formEl.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(formEl);
        const tmp = {};
        for (let [key, value] of formData.entries()) {
          if (!value || value.trim() === "") {
            Utility.toast("Please complete required fields", "error");
            return;
          }
          tmp[key] = value;
        }

        const newDealer = await Dealer.saveNewDealer(formData);
        if (newDealer.status === 200) {
          await clearAppData();
          await Application.initializeData();
        }
      });
    } catch (error) {
      console.error("Error submitting new dealer form:", error);
    }
  }

  /**
   * Render pending dealer applications based on role and ownership.
   */
  async renderPendingApplications() {
    try {
      const mount = Utility.el("applications");
      if (!mount) return;

      const token = await decryptJsToken();
      const data = Application.DATA.dealers.filter(
        (apps) =>
          token?.role === "admin" ||
          (token?.userid === apps.userid && apps.status === "pending")
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
        div.innerHTML = `<div><strong>Apx-${a.userid}</strong> 
          <div class="muted small">${a.joined}</div></div>
          <div class="${a.status} status-pill">
          <span class="muted small">${a.status}</span>
          </div>`;
        mount.appendChild(div);
      });
    } catch (error) {
      console.error("Error rendering pending applications:", error);
    }
  }
}

// Initialize Dealer Page
new DealerPage();
