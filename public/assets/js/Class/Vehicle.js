import Utility from "./Utility.js";
import AppInit from "./Application.js";
import SessionManager from "./SessionManager.js";
import { CONFIG } from "../config.js";

export default class VehicleStatic {
  static VIEW = "grid";
  static SELECTED = new Set();
  static EDITING_ID = null;
  static el = (id) => document.getElementById(id);

  static getFiltered() {
    const q = (VehicleStatic.el("q").value || "").toLowerCase();
    const status = VehicleStatic.el("statusFilter").value;
    const sort = VehicleStatic.el("sortBy").value;
    const min = Number(VehicleStatic.el("min").value || 0);
    const max = Number(VehicleStatic.el("max").value || 0);

    let rows = AppInit.DATA.vehicles.filter((v) => {
      const hay = `${v.make} ${v.model} ${v.vin} ${v.owner}`.toLowerCase();
      if (q && !hay.includes(q)) return false;
      if (status !== "all" && v.status !== status) return false;
      if (min && Number(v.price) < min) return false; // below min → hide
      if (max && Number(v.price) > max) return false; // above max → hide

      return true;
    });
    rows.sort((a, b) => {
      if (sort === "date") return a.id.localeCompare(b.id);
      if (sort === "price") return b.price - a.price;
      if (sort === "mileage") return b.mileage - a.mileage;
      if (sort === "year") return b.year - a.year;

      return 0;
    });
    return rows;
  }

  static async renderGrid() {
    const mount = VehicleStatic.el("gridView");
    const notFound = VehicleStatic.el("no-data");
    mount.innerHTML = "";
    notFound.innerHTML = "";
    const rows = VehicleStatic.getFiltered();

    if (rows.length == 0) {
      notFound.innerHTML = `
      <div style="width:100%; display:flex; justify-content:center;">
          <p class="muted">Vehicle not available</p>
      </div>
    `;
    }
    const token = await SessionManager.decryptAndGetToken();
    const role = token.role;

    rows.forEach((v) => {
      const card = document.createElement("div");
      card.className = "v-card";
      const images = JSON.parse(v.images);
      card.setAttribute("data-aos", "fade-up");
      card.innerHTML = `
        <div class='media'>
          <img src='${images[0]}' alt='${v.title}'/>
          <span class='status'>${Utility.toTitleCase(v.status)}</span>
        </div>
        <div class='body'>
          <div style='display:flex;justify-content:space-between;align-items:center'>
            <div>
              <div style='font-weight:800'>${v.title}</div>
              <div class='small muted'>VIN ${v.vin}</div>
            </div>
            <div class='price'>${AppInit.fmtNGN(v.price)}</div>
          </div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'>
            <span><i class='bi bi-speedometer2'></i> ${AppInit.fmt(
              v.mileage
            )} km</span>
            <span><i class='bi bi-person-badge'></i> ${
              v.company ?? "---"
            }</span>
          </div>
          <div style='display:flex;gap:6px;margin-top:10px'>
            <span class='pill ${v.status}'>${Utility.toTitleCase(
        v.status
      )}</span>
          </div>
          <div class="action_btns">
            <button class='toolbar icon-btn' data-view='${
              v.id
            }'><i class="fas fa-eye"></i></button>

       
            ${
              role == "admin"
                ? `
                    <button class='toolbar icon-btn' data-edit='${
                      v.id
                    }'><i class="fas fa-pencil"></i></button>
            <button class='toolbar icon-btn' data-delete='${
              v.id
            }'><i class="fas fa-trash danger"></i>
            </button>
               ${
                 v.status !== "approved"
                   ? `<button class='toolbar icon-btn' data-approve='${v.id}'><i class="fas fa-check-circle approve"></i></button>`
                   : ""
               }
            ${
              v.status !== "rejected"
                ? `<button class='toolbar icon-btn' data-reject='${v.id}'><i class="fas fa-times danger"></i></button>`
                : ""
            }          
              
              `
                : ``
            }
           
          </div>
        </div>`;
      mount.appendChild(card);
    });
  }

  static async renderTable() {
    const wrap = document.querySelector("#vehiclesTable tbody");
    const notFound = VehicleStatic.el("no-data");
    wrap.innerHTML = "";
    notFound.innerHTML = "";
    const rows = VehicleStatic.getFiltered();
    if (rows.length == 0) {
      notFound.innerHTML = `
      <div style="width:100%; display:flex; justify-content:center;">
          <p class="muted">Vehicles not available</p>
      </div>
    `;
    }
    const token = await SessionManager.decryptAndGetToken();
    const role = token.role;

    const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
    const slice = rows.slice(start, start + AppInit.PER_PAGE);
    slice.forEach((v) => {
      const tr = document.createElement("tr");
      const images = JSON.parse(v.images);
      tr.innerHTML = `
        <td><input type='checkbox' data-sel='${v.id}' ${
        VehicleStatic.SELECTED.has(v.id) ? "checked" : ""
      }></td>
        <td><div style='display:flex;gap:8px;align-items:center'><img src='${
          images[0]
        }' style='width:48px;height:34px;border-radius:8px;object-fit:cover' alt='${
        v.title
      }'/><div><div style='font-weight:700'>${
        v.title
      }</div><div class='small muted'>${
        v.owner ?? "not available"
      }</div></div></div></td>
        <td><code>${v.vin}</code></td>
        <td>${v.company ?? "---"}</td>
        <td>${v.year}</td>
        <td>${AppInit.fmt(v.mileage)}</td>
        <td>${AppInit.fmtNGN(v.price)}</td>
        <td><span class='pill ${v.status}'>${Utility.toTitleCase(
        v.status
      )}</span></td>
        <td>
           <div class="action_btns">
            <button class='toolbar icon-btn' data-view='${
              v.id
            }'><i class="fas fa-eye"></i></button>

       
            ${
              role == "admin"
                ? `
                    <button class='toolbar icon-btn' data-edit='${
                      v.id
                    }'><i class="fas fa-pencil"></i></button>
            <button class='toolbar icon-btn' data-delete='${
              v.id
            }'><i class="fas fa-trash danger"></i>
            </button>
               ${
                 v.status !== "approved"
                   ? `<button class='toolbar icon-btn' data-approve='${v.id}'><i class="fas fa-check-circle approve"></i></button>`
                   : ""
               }
            ${
              v.status !== "rejected"
                ? `<button class='toolbar icon-btn' data-reject='${v.id}'><i class="fas fa-times danger"></i></button>`
                : ""
            }          
              
              `
                : ``
            }
           
          </div>
       </td>`;
      wrap.appendChild(tr);
    });
    VehicleStatic.el(
      "pgInfo"
    ).textContent = `Page ${AppInit.PAGE} • Showing ${slice.length} of ${rows.length}`;
  }

  // ------ Detail modal
  static openDetail(id) {
    const v = AppInit.DATA.vehicles.find((x) => x.id === id);
    if (!v) return;
    const images = JSON.parse(v.images);
    const body = VehicleStatic.el("detailModalBody");
    const btns = VehicleStatic.el("detailModalButtons");
    VehicleStatic.el("detailModalLabel").textContent = v.title;
    body.innerHTML = `
      <div style='display:grid;grid-template-columns:220px 1fr;gap:12px'>
        <img src='${
          images[0]
        }' style='width:100%;height:160px;border-radius:12px;object-fit:cover' alt='${
      v.title
    }'/>
        <div>
          <div style='font-weight:800;font-size:18px'>${v.title}</div>
          <div class='small muted'>VIN ${v.vin}</div>
          <div class='small muted'>Owner: ${v.company ?? "not available"}</div>
          <div class='small muted'>${AppInit.fmt(
            v.mileage
          )} km • ${AppInit.fmtNGN(v.price)}</div>
          <div style='margin-top:8px' class='small'>${v.notes || ""}</div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'><span>Status: <span class='pill ${
            v.status
          }'>${Utility.toTitleCase(v.status)}</span></span></div>
        </div>
      </div>`;
    btns.innerHTML = `    
      <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
             <button id="approveBtn" data-id=${id} class="btn btn-sm btn-primary">Approve</button>
             <button id="rejectBtn" data-id=${id} class="btn btn-sm btn-ghost">Reject</button>
             <button id="deleteBtn" data-id=${id} class="btn btn-sm btn-ghost">Delete</button>
         </div>`;
    $("#displayDetails").modal("show");
  }
  static async vehicleCoreInformation(v) {
    //--Get the upload Form and add to the overviewId
    const f = VehicleStatic.el("vehForm");
    f.reset();
    if (v) {
      f.title.value = v.title || "";
      f.price.value = v.price || "";
      f.mileage.value = v.mileage || "";
      f.vin.value = v.vin || "";
      f.make.value = v.make || "";
      f.model.value = v.model || "";
      f.trim.value = v.trim || "";
      f.body_type.value = v.body_type || "";
      f.fuel.value = v.fuel || "";
      f.drive_type.value = v.drive_type || "";
      f.engine_number.value = v.engine_number || "";
      f.transmission.value = v.transmission || "";
      f.exterior_color.value = v.exterior_color || "";
      f.interior_color.value = v.interior_color || "";
      f.year.value = v.year || "";
      f.notes.value = v.notes || "";
    }
  }
  static async vehicleOwnershipInformation(v, f) {}
  static async vehicleSpecsInformation(v) {}

  static openForm(v) {
    VehicleStatic.el("manageVehicleTitle").textContent = v
      ? v.title
      : "Add vehicle";

    VehicleStatic.EDITING_ID = v?.id || null;
    if (v) {
      VehicleStatic.vehicleCoreInformation(v);
    }

    $("#manageVehicle").modal("show");
  }

  static async updateInformation(id, data) {
    const v = AppInit.DATA.vehicles.find((x) => x.id === id);
    if (!v) return;

    //---Send to Server
    const result = await Swal.fire({
      title: "Update vehicle",
      text: "Do you wish to continue?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Continue!",
    });
    if (result.isConfirmed) {
      const update = new FormData();
      update.append("data", JSON.stringify(data));
      update.append("vin", v.vin);
      const { message, status } = await Utility.fetchData(
        `${CONFIG.API}/admin/car/${id}`,
        update,
        "POST"
      );

      AppInit.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status == 200) {
        SessionManager.clearAppData();
        await AppInit.initializeData();

        VehicleStatic.renderStats();
        VehicleStatic.VIEW === "grid"
          ? VehicleStatic.renderGrid()
          : VehicleStatic.renderTable();
      }
    }
  }

  static async removeVehicle(id) {
    const idx = AppInit.DATA.vehicles.findIndex((x) => x.id === id);
    if (idx > -1) {
      const result = await Swal.fire({
        title: "Delete vehicle",
        text: "Do you wish to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
      if (result.isConfirmed) {
        const { message, status } = await Utility.fetchData(
          `${CONFIG.API}/admin/car/${id}`,
          {},
          "DELETE"
        );

        AppInit.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

        if (status == 200) {
          SessionManager.clearAppData();
          await AppInit.initializeData();

          VehicleStatic.renderStats();
          VehicleStatic.VIEW === "grid"
            ? VehicleStatic.renderGrid()
            : VehicleStatic.renderTable();
        }
      }
    }
  }

  static renderStats() {
    VehicleStatic.el("sTotal").textContent = AppInit.DATA.vehicles.length;
    VehicleStatic.el("sApproved").textContent = AppInit.DATA.vehicles.filter(
      (v) => v.status === "approved"
    ).length;
    VehicleStatic.el("sPending").textContent = AppInit.DATA.vehicles.filter(
      (v) => v.status === "pending"
    ).length;
    VehicleStatic.el("sRejected").textContent = AppInit.DATA.vehicles.filter(
      (v) => v.status === "rejected"
    ).length;
  }
}

class Vehicle {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await AppInit.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderVehicleStats() {
    if (!VehicleStatic.el("sTotal")) return;
    VehicleStatic.renderStats();
  }

  renderVehiclesHomePageGrid() {
    const wrap = document.getElementById("vehiclesGrid");
    if (!wrap) return;

    wrap.innerHTML = "";
    AppInit.DATA.vehicles.forEach((v) => {
      const card = document.createElement("div");
      card.className = "vehicle-card";
      card.innerHTML = `
      <div class='vehicle-media'><img src='${v.image}' alt='${
        v.title
      }' loading='lazy' /></div>
      <div class='vehicle-body'>
        <div style='display:flex;justify-content:space-between;align-items:center'><div><strong>${
          v.title
        }</strong><div class='muted' style='font-size:13px'>${
        v.state
      } • ${v.mileage.toLocaleString()} km</div></div><div><span class='badge ${
        v.status === "available"
          ? "available"
          : v.status === "sold"
          ? "sold"
          : "available"
      }' style='padding:.35rem .5rem;border-radius:6px'>${v.status.toUpperCase()}</span></div></div>
        <div style='display:flex;justify-content:space-between;align-items:center;margin-top:8px'><div style='font-weight:800'>${AppInit.fmtNGN(
          v.price
        )}</div><div class='muted small'><code>${v.vin.slice(
        0,
        8
      )}…</code></div></div>
        <div style='display:flex;gap:8px;margin-top:10px'><button class='btn btn-primary' data-edit='${
          v.id
        }'>Edit</button><button class='btn btn-ghost' data-delete='${
        v.id
      }'>Delete</button><button class='btn btn-ghost' data-view='${
        v.id
      }'>View</button></div>
      </div>`;
      wrap.appendChild(card);
    });
  }

  changeSearchPlacholder() {
    const domEl = document.getElementById("q");
    if (!domEl) return;
    domEl.placeholder = "Search VIN, Make/Model, dealer...";
  }

  renderStats() {
    VehicleStatic.el("sTotal").textContent = AppInit.DATA.vehicles.length;
    VehicleStatic.el("sApproved").textContent = AppInit.DATA.vehicles.filter(
      (v) => v.status === "approved"
    ).length;
    VehicleStatic.el("sPending").textContent = AppInit.DATA.vehicles.filter(
      (v) => v.status === "pending"
    ).length;
    VehicleStatic.el("sRejected").textContent = AppInit.DATA.vehicles.filter(
      (v) => v.status === "rejected"
    ).length;
  }

  switchVehicleView() {
    // ------ Switch view
    const toggleViewBtn = VehicleStatic.el("toggleView");
    if (!toggleViewBtn) return;

    VehicleStatic.renderGrid();

    toggleViewBtn.addEventListener("click", () => {
      VehicleStatic.VIEW = VehicleStatic.VIEW === "grid" ? "table" : "grid";
      VehicleStatic.el("gridView").style.display =
        VehicleStatic.VIEW === "grid" ? "grid" : "none";
      VehicleStatic.el("tableView").style.display =
        VehicleStatic.VIEW === "table" ? "block" : "none";
      toggleViewBtn.innerHTML =
        VehicleStatic.VIEW === "grid"
          ? '<i class="bi bi-grid"></i> Grid'
          : '<i class="bi bi-table"></i> Table';
      if (VehicleStatic.VIEW === "grid") VehicleStatic.renderGrid();
      else VehicleStatic.renderTable();
    });

    // ------ Search & filters & per page
    ["q", "statusFilter", "sortBy", "min", "max"].forEach((id) =>
      VehicleStatic.el(id).addEventListener("input", () => {
        AppInit.PAGE = 1;
        VehicleStatic.VIEW === "grid"
          ? VehicleStatic.renderGrid()
          : VehicleStatic.renderTable();
      })
    );

    // ------ Pagination
    VehicleStatic.el("prevPg").addEventListener("click", () => {
      if (AppInit.PAGE > 1) {
        AppInit.PAGE--;
        VehicleStatic.renderTable();
      }
    });
    VehicleStatic.el("nextPg").addEventListener("click", () => {
      const total = VehicleStatic.getFiltered().length;
      if (AppInit.PAGE * AppInit.PER_PAGE < total) {
        AppInit.PAGE++;
        VehicleStatic.renderTable();
      }
    });
  }

  saveNewVehicle() {
    // save form
    VehicleStatic.el("vehForm").addEventListener("submit", async (e) => {
      e.preventDefault();
      const uploadData = new FormData(e.target);

      const f = e.target;
      const data = {
        vin: f.vin.value.trim().toUpperCase(),
      };

      if (!/^[A-HJ-NPR-Z0-9]{11,17}$/.test(data.vin)) {
        AppInit.toast("VIN must be 11–17 chars (no I,O,Q)", "error");
        document.querySelector(
          "#vin_error"
        ).innerHTML = `<p class="small" style="color:red">VIN must be 11–17 chars (no I,O,Q)</p>`;
        document.querySelector(".vin_border").classList.add("is-invalid");
        return;
      }

      if (VehicleStatic.EDITING_ID) {
        const v = AppInit.DATA.vehicles.find(
          (x) => x.id === VehicleStatic.EDITING_ID
        );
        Object.assign(v, data);
        AppInit.toast("Vehicle updated", "success");
      } else {
        $(".modal").modal("hide");
        const result = await Swal.fire({
          title: "Upload vehicle",
          text: "Do you wish to continue?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Continue!",
        });
        if (result.isConfirmed) {
          uploadData.append("vin", data.vin);
          const { status, message } = await Utility.fetchData(
            `${CONFIG.API}/car`,
            uploadData,
            "POST"
          );

          AppInit.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

          if (status == 200) {
            SessionManager.clearAppData();
            await AppInit.initializeData();
          }
        }
      }

      VehicleStatic.renderStats();
      VehicleStatic.VIEW === "grid"
        ? VehicleStatic.renderGrid()
        : VehicleStatic.renderTable();
    });
  }

  eventDelegation() {
    document.addEventListener("click", (e) => {
      const v = e.target.closest("[data-view]");
      if (v) {
        VehicleStatic.openDetail(v.dataset.view);
        return;
      }
      const ap = e.target.closest("[data-approve]");
      if (ap) {
        VehicleStatic.updateInformation(ap.dataset.approve, {
          status: "approved",
          table: "vehicles_tbl",
        });
        return;
      }
      const rj = e.target.closest("[data-reject]");
      if (rj) {
        VehicleStatic.updateInformation(rj.dataset.reject, {
          status: "rejected",
          table: "vehicles_tbl",
        });
        return;
      }
      const ed = e.target.closest("[data-edit]");
      if (ed) {
        VehicleStatic.openForm(
          AppInit.DATA.vehicles.find((x) => x.id === ed.dataset.edit)
        );
        return;
      }
      const del = e.target.closest("[data-delete]");
      if (del) {
        VehicleStatic.removeVehicle(del.dataset.delete);
        return;
      }
      const sel = e.target.closest("[data-sel]");
      if (sel) {
        if (e.target.checked) VehicleStatic.SELECTED.add(sel.dataset.sel);
        else VehicleStatic.SELECTED.delete(sel.dataset.sel);
      }
    });
  }

  modalActions() {
    VehicleStatic.el("approveBtn")?.addEventListener("click", () =>
      VehicleStatic.approve(VehicleStatic.el("approveBtn").dataset.id)
    );
    VehicleStatic.el("rejectBtn")?.addEventListener("click", () =>
      VehicleStatic.reject(VehicleStatic.el("rejectBtn").dataset.id)
    );
    VehicleStatic.el("deleteBtn")?.addEventListener("click", () =>
      VehicleStatic.removeVehicle(VehicleStatic.el("deleteBtn").dataset.id)
    );
  }

  bulkActions() {
    VehicleStatic.el("selAll")?.addEventListener("change", (e) => {
      const rows = document.querySelectorAll("[data-sel]");
      rows.forEach((cb) => {
        cb.checked = e.target.checked;
        if (e.target.checked) VehicleStatic.SELECTED.add(cb.dataset.sel);
        else VehicleStatic.SELECTED.delete(cb.dataset.sel);
      });
    });
    VehicleStatic.el("bulkApprove").addEventListener("click", () => {
      if (!VehicleStatic.SELECTED.size)
        return AppInit.toast("Select vehicles first", "error");
      VehicleStatic.SELECTED.forEach((id) => VehicleStatic.approve(id));
      VehicleStatic.SELECTED.clear();
      VehicleStatic.renderTable();
    });
    VehicleStatic.el("bulkReject").addEventListener("click", () => {
      if (!VehicleStatic.SELECTED.size)
        return AppInit.toast("Select vehicles first", "error");
      VehicleStatic.SELECTED.forEach((id) => VehicleStatic.reject(id));

      VehicleStatic.SELECTED.clear();
      VehicleStatic.renderTable();
    });
  }

  exportCSV() {
    // ------ Export CSV (demo)
    VehicleStatic.el("exportCsv").addEventListener("click", () => {
      const headers = [
        "id",
        "make",
        "model",
        "year",
        "vin",
        "owner",
        "mileage",
        "price",
        "status",
      ];
      const rows = VehicleStatic.getFiltered().map((v) =>
        headers.map((h) => v[h])
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
      a.download = "vehicles.csv";
      a.click();
      URL.revokeObjectURL(url);
      AppInit.toast("CSV downloaded (demo)", "success");
    });
  }
}

new Vehicle();
