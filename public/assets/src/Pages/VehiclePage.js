import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Vehicle from "../Classes/Vehicle.js";
import Verification from "../Classes/Verification.js";

/**
 * VehiclePage.js
 * Handles all vehicle management functionalities including:
 * - Rendering vehicle statistics
 * - Switching between grid and table views
 * - Search, filters, and pagination
 * - Event delegation for vehicle actions (view, approve, reject, edit, delete)
 * - Adding a new vehicle
 * - Exporting vehicle data to CSV
 * - Saving search history
 *
 * Dependencies:
 * - Utility.js
 * - Application.js
 * - Vehicle.js
 * - Verification.js
 */

class VehiclePage {
  constructor() {
    this.initialize();
  }

  /**
   * Initialize the vehicle page
   */
  async initialize() {
    try {
      await Application.initializeData();
      Utility.runClassMethods(this, ["initialize"]);
    } catch (error) {
      console.error("Error initializing VehiclePage:", error);
      Utility.toast("Failed to initialize vehicle page.", "error");
    }
  }

  /**
   * Render vehicle statistics
   */
  renderVehicleStats() {
    try {
      if (!Utility.el("sTotal")) return;
      Vehicle.renderStats(Application.DATA.vehicles);
    } catch (error) {
      console.error("Error rendering vehicle stats:", error);
      Utility.toast("Failed to load vehicle statistics.", "error");
    }
  }

  /**
   * Change search input placeholder
   */
  changeSearchPlaceholder() {
    try {
      const searchElement = document.getElementById("q");
      if (!searchElement) return;

      searchElement.placeholder = "Search VIN, Make/Model, dealer...";
    } catch (error) {
      console.error("Error changing search placeholder:", error);
    }
  }

  /**
   * Switch between grid and table views
   */
  switchVehicleView() {
    try {
      const toggleViewBtn = Utility.el("toggleView");
      if (!toggleViewBtn) return;

      Vehicle.renderGrid();

      toggleViewBtn.addEventListener("click", () => {
        Vehicle.VIEW = Vehicle.VIEW === "grid" ? "table" : "grid";

        // Handle CSS display
        Utility.el("gridView").style.display =
          Vehicle.VIEW === "grid" ? "grid" : "none";
        Utility.el("tableView").style.display =
          Vehicle.VIEW === "table" ? "block" : "none";

        toggleViewBtn.innerHTML =
          Vehicle.VIEW === "grid"
            ? '<i class="bi bi-table"></i> Table'
            : '<i class="bi bi-grid"></i> Grid';

        Vehicle.VIEW === "grid" ? Vehicle.renderGrid() : Vehicle.renderTable();
      });

      // Initialize search, filters, and pagination
      Vehicle.searchAndToggleFilter();
    } catch (error) {
      console.error("Error switching vehicle view:", error);
    }
  }

  /**
   * Delegate vehicle-related events
   */
  eventDelegations() {
    try {
      document.addEventListener("click", async (e) => {
        try {
          const viewBtn = e.target.closest("[data-view]");
          if (viewBtn) {
            Vehicle.openDetail(viewBtn.dataset.view);
            return;
          }

          const approveBtn = e.target.closest("[data-approve]");
          if (approveBtn) {
            Vehicle.updateInformation(approveBtn.dataset.approve, {
              status: "approved",
              table: "vehicles_tbl",
            });
            return;
          }

          const rejectBtn = e.target.closest("[data-reject]");
          if (rejectBtn) {
            Vehicle.updateInformation(rejectBtn.dataset.reject, {
              status: "rejected",
              table: "vehicles_tbl",
            });
            return;
          }

          const editBtn = e.target.closest("[data-edit]");
          if (editBtn) {
            Vehicle.openForm(
              Application.DATA.vehicles.find(
                (v) => v.id === editBtn.dataset.edit
              )
            );
            return;
          }

          const deleteBtn = e.target.closest("[data-delete]");
          if (deleteBtn) {
            Vehicle.deleteVehicle(deleteBtn.dataset.delete);
            return;
          }

          const selectChk = e.target.closest("[data-sel]");
          if (selectChk) {
            if (e.target.checked) Vehicle.SELECTED.add(selectChk.dataset.sel);
            else Vehicle.SELECTED.delete(selectChk.dataset.sel);
          }
        } catch (innerError) {
          console.error("Error handling vehicle click event:", innerError);
        }
      });

      // Details modal buttons
      Utility.el("approveBtn")?.addEventListener("click", async () => {
        try {
          Vehicle.updateInformation(Utility.el("approveBtn").dataset.id, {
            status: "approved",
            table: "vehicles_tbl",
          });
        } catch (innerError) {
          console.error("Error approving vehicle:", innerError);
        }
      });

      Utility.el("rejectBtn")?.addEventListener("click", async () => {
        try {
          Vehicle.updateInformation(Utility.el("rejectBtn").dataset.id, {
            status: "rejected",
            table: "vehicles_tbl",
          });
        } catch (innerError) {
          console.error("Error rejecting vehicle:", innerError);
        }
      });

      Utility.el("deleteBtn")?.addEventListener("click", async () => {
        try {
          Vehicle.deleteVehicle(Utility.el("deleteBtn").dataset.id);
        } catch (innerError) {
          console.error("Error deleting vehicle:", innerError);
        }
      });
    } catch (error) {
      console.error("Error setting up vehicle event delegations:", error);
    }
  }

  /**
   * Save a new vehicle via form submission
   */
  saveANewVehicle() {
    try {
      const formEl = Utility.el("vehForm");
      if (!formEl) return;

      formEl.addEventListener("submit", async (e) => {
        e.preventDefault();

        try {
          const uploadData = new FormData(e.target);
          const vin = e.target.vin.value.trim().toUpperCase();

          if (!Utility.validVIN(vin)) {
            Utility.toast("Invalid VIN", "error");
            document.querySelector(
              "#vin_error"
            ).innerHTML = `<p class="small" style="color:red">VIN must be 11–17 chars (no I,O,Q)</p>`;
            document.querySelector(".vin_border").classList.add("is-invalid");
            return;
          }

          $(".modal").modal("hide");

          const upload = await Vehicle.uploadNewVehicle(uploadData, vin);

          if (upload) {
            Vehicle.renderStats(Application.DATA.vehicles);
            Vehicle.VIEW === "grid"
              ? Vehicle.renderGrid()
              : Vehicle.renderTable();
          }
        } catch (innerError) {
          console.error("Error saving new vehicle:", innerError);
          Utility.toast("Failed to save new vehicle.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing saveANewVehicle form:", error);
    }
  }

  /**
   * Export vehicle data as CSV
   */
  exportCSV() {
    try {
      const exportBtn = Utility.el("exportCsv");
      if (!exportBtn) return;

      exportBtn.addEventListener("click", () => {
        try {
          Utility.exportToCSV(Vehicle.CURRENT_DATA, "vehicle.csv");
        } catch (innerError) {
          console.error("Error exporting CSV:", innerError);
          Utility.toast("Failed to export vehicle data.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing CSV export:", error);
    }
  }

  /**
   * Save search criteria to history
   */
  saveSearchToHistory() {
    try {
      document
        .getElementById("saveToHistory")
        ?.addEventListener("click", () => {
          try {
            Verification.saveHistoryButton();
          } catch (innerError) {
            console.error("Error saving search to history:", innerError);
            Utility.toast("Failed to save search history.", "error");
          }
        });
    } catch (error) {
      console.error("Error initializing save search to history:", error);
    }
  }
}

new VehiclePage();
