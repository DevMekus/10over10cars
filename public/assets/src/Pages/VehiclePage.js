import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Vehicle from "../Classes/Vehicle.js";
import Verification from "../Classes/Verification.js";

class VehiclePage {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderVehicleStats() {
    if (!Utility.el("sTotal")) return;
    Vehicle.renderStats(Application.DATA.vehicles);
  }

  changeSearchPlaceholder() {
    const searchElement = document.getElementById("q");
    if (!searchElement) return;

    searchElement.placeholder = "Search VIN, Make/Model, dealer...";
  }

  switchVehicleView() {
    const toggleViewBtn = Utility.el("toggleView");
    if (!toggleViewBtn) return;

    Vehicle.renderGrid();

    toggleViewBtn.addEventListener("click", () => {
      Vehicle.VIEW = Vehicle.VIEW === "grid" ? "table" : "grid";

      //--Handle Css
      Utility.el("gridView").style.display =
        Vehicle.VIEW === "grid" ? "grid" : "none";

      Utility.el("tableView").style.display =
        Vehicle.VIEW === "table" ? "block" : "none";

      toggleViewBtn.innerHTML =
        Vehicle.VIEW === "grid"
          ? '<i class="bi bi-table"></i> Table'
          : '<i class="bi bi-grid"></i> Grid';
      if (Vehicle.VIEW === "grid") Vehicle.renderGrid();
      else Vehicle.renderTable();
    });

    // ------ Search & filters & per page
    Vehicle.searchAndToggleFilter();

    // ------ Pagination
  }

  eventDelegations() {
    document.addEventListener("click", async (e) => {
      const v = e.target.closest("[data-view]");
      if (v) {
        Vehicle.openDetail(v.dataset.view);
        return;
      }
      const ap = e.target.closest("[data-approve]");
      if (ap) {
        Vehicle.updateInformation(ap.dataset.approve, {
          status: "approved",
          table: "vehicles_tbl",
        });
        return;
      }
      const rj = e.target.closest("[data-reject]");
      if (rj) {
        Vehicle.updateInformation(rj.dataset.reject, {
          status: "rejected",
          table: "vehicles_tbl",
        });
        return;
      }
      const ed = e.target.closest("[data-edit]");
      if (ed) {
        Vehicle.openForm(
          AppInit.DATA.vehicles.find((x) => x.id === ed.dataset.edit)
        );
        return;
      }
      const del = e.target.closest("[data-delete]");
      if (del) {
        Vehicle.deleteVehicle(del.dataset.delete);
        return;
      }

      const sel = e.target.closest("[data-sel]");
      if (sel) {
        if (e.target.checked) Vehicle.SELECTED.add(sel.dataset.sel);
        else Vehicle.SELECTED.delete(sel.dataset.sel);
      }
    });

    //---Details Modal Event delegations
    Utility.el("approveBtn")?.addEventListener("click", async () => {
      console.log("click");
      Vehicle.updateInformation(Utility.el("approveBtn").dataset.id, {
        status: "approved",
        table: "vehicles_tbl",
      });
    });
    Utility.el("rejectBtn")?.addEventListener("click", async () =>
      Vehicle.updateInformation(Utility.el("rejectBtn").dataset.id, {
        status: "rejected",
        table: "vehicles_tbl",
      })
    );

    Utility.el("deleteBtn")?.addEventListener("click", async () =>
      Vehicle.deleteVehicle(Utility.el("deleteBtn").dataset.id)
    );
  }

  saveANewVehicle() {
    const formEl = Utility.el("vehForm");
    if (!formEl) return;

    formEl.addEventListener("submit", async (e) => {
      e.preventDefault();
      const uploadData = new FormData(e.target);
      const temp = e.target;
      const vin = temp.vin.value.trim().toUpperCase();

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
        Vehicle.VIEW === "grid" ? Vehicle.renderGrid() : Vehicle.renderTable();
      }
    });
  }

  exportCSV() {
    Utility.el("exportCsv").addEventListener("click", () => {
      Utility.exportToCSV(Vehicle.CURRENT_DATA, "vehicle.csv");
    });
  }

  bulkActions() {}

  saveSearchToHostory() {
    document.getElementById("saveToHistory")?.addEventListener("click", () => {
      console.log("saving to history");
      Verification.saveHistoryButton();
    });
  }
}

new VehiclePage();
