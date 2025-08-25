import Utility from "./Utility.js";
import AppInit from "./Application.js";

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

  static renderGrid() {
    const mount = VehicleStatic.el("gridView");
    mount.innerHTML = "";
    const rows = VehicleStatic.getFiltered();
    rows.forEach((v) => {
      const card = document.createElement("div");
      card.className = "v-card";
      card.setAttribute("data-aos", "fade-up");
      card.innerHTML = `
        <div class='media'>
          <img src='${v.image}' alt='${v.year} ${v.make} ${v.model}'/>
          <span class='status'>${v.status}</span>
        </div>
        <div class='body'>
          <div style='display:flex;justify-content:space-between;align-items:center'>
            <div>
              <div style='font-weight:800'>${v.year} ${v.make} ${v.model}</div>
              <div class='small muted'>VIN ${v.vin}</div>
            </div>
            <div class='price'>${AppInit.fmtNGN(v.price)}</div>
          </div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'>
            <span><i class='bi bi-speedometer2'></i> ${AppInit.fmt(
              v.mileage
            )} km</span>
            <span><i class='bi bi-person-badge'></i> ${v.owner}</span>
          </div>
          <div style='display:flex;gap:6px;margin-top:10px'>
            <span class='pill ${v.status}'>${v.status}</span>
          </div>
          <div style='display:flex;gap:6px;margin-top:10px'>
            <button class='toolbar btn' data-view='${v.id}'>View</button>
            ${
              v.status !== "approved"
                ? `<button class='toolbar btn' data-approve='${v.id}'>Approve</button>`
                : ""
            }
            ${
              v.status !== "rejected"
                ? `<button class='toolbar btn' data-reject='${v.id}'>Reject</button>`
                : ""
            }
            <button class='toolbar btn' data-edit='${v.id}'>Edit</button>
            <button class='toolbar btn' data-delete='${v.id}'>Delete</button>
          </div>
        </div>`;
      mount.appendChild(card);
    });
  }

  static renderTable() {
    const wrap = document.querySelector("#vehiclesTable tbody");
    wrap.innerHTML = "";
    const rows = VehicleStatic.getFiltered();
    const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
    const slice = rows.slice(start, start + AppInit.PER_PAGE);
    slice.forEach((v) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><input type='checkbox' data-sel='${v.id}' ${
        VehicleStatic.SELECTED.has(v.id) ? "checked" : ""
      }></td>
        <td><div style='display:flex;gap:8px;align-items:center'><img src='${
          v.image
        }' style='width:48px;height:34px;border-radius:8px;object-fit:cover' alt='${
        v.make
      } ${v.model}'/><div><div style='font-weight:700'>${v.year} ${v.make} ${
        v.model
      }</div><div class='small muted'>${v.owner}</div></div></div></td>
        <td><code>${v.vin}</code></td>
        <td>${v.owner}</td>
        <td>${v.year}</td>
        <td>${AppInit.fmt(v.mileage)}</td>
        <td>${AppInit.fmtNGN(v.price)}</td>
        <td><span class='pill ${v.status}'>${v.status}</span></td>
        <td><button class='toolbar btns' data-view='${
          v.id
        }'>View</button><button class='toolbar btns' data-edit='${
        v.id
      }'>Edit</button>${
        v.status !== "approved"
          ? `<button class='toolbar btns' data-approve='${v.id}'>Approve</button>`
          : ""
      }${
        v.status !== "rejected"
          ? `<button class='toolbar btns' data-reject='${v.id}'>Reject</button>`
          : ""
      }<button class='toolbar btns' data-delete='${v.id}'>Delete</button></td>`;
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
    const body = VehicleStatic.el("detailBodyVehi");
    body.innerHTML = `
      <div style='display:grid;grid-template-columns:220px 1fr;gap:12px'>
        <img src='${
          v.image
        }' style='width:100%;height:160px;border-radius:12px;object-fit:cover' alt='${
      v.year
    } ${v.make} ${v.model}'/>
        <div>
          <div style='font-weight:800;font-size:18px'>${v.year} ${v.make} ${
      v.model
    }</div>
          <div class='small muted'>VIN ${v.vin}</div>
          <div class='small muted'>Owner: ${v.owner}</div>
          <div class='small muted'>${AppInit.fmt(
            v.mileage
          )} km • ${AppInit.fmtNGN(v.price)}</div>
          <div style='margin-top:8px' class='small'>${v.notes || ""}</div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'><span>Status: <span class='pill ${
            v.status
          }'>${v.status}</span></span></div>
        </div>
      </div>`;
    VehicleStatic.el("approveBtn").dataset.id = id;
    VehicleStatic.el("rejectBtn").dataset.id = id;
    VehicleStatic.el("deleteBtn").dataset.id = id;
    VehicleStatic.el("detailModalVehi").classList.add("open");
    VehicleStatic.el("detailModalVehi").setAttribute("aria-hidden", "false");
  }

  static openForm(v) {
    VehicleStatic.el("formTitle").textContent = v
      ? "Edit vehicle"
      : "Add vehicle";
    const f = VehicleStatic.el("vehForm");
    f.reset();
    VehicleStatic.EDITING_ID = v?.id || null;
    if (v) {
      f.make.value = v.make;
      f.model.value = v.model;
      f.year.value = v.year;
      f.vin.value = v.vin;
      f.mileage.value = v.mileage;
      f.price.value = v.price;
      f.owner.value = v.owner;
      f.status.value = v.status;
      f.image.value = v.image;
      f.notes.value = v.notes || "";
    }
    VehicleStatic.el("formModal").classList.add("open");
  }

  static approve(id) {
    const v = AppInit.DATA.vehicles.find((x) => x.id === id);
    if (!v) return;
    v.status = "approved";
    AppInit.toast("Vehicle approved", "success");
    new Vehicle().renderStats();
    VehicleStatic.VIEW === "grid"
      ? VehicleStatic.renderGrid()
      : VehicleStatic.renderTable();
  }

  static reject(id) {
    const v = AppInit.DATA.vehicles.find((x) => x.id === id);
    if (!v) return;
    v.status = "rejected";
    AppInit.toast("Vehicle rejected", "info");
    new Vehicle().renderStats();
    VehicleStatic.VIEW === "grid"
      ? VehicleStatic.renderGrid()
      : VehicleStatic.renderTable();
  }

  static removeVehicle(id) {
    const idx = AppInit.DATA.vehicles.findIndex((x) => x.id === id);
    if (idx > -1) {
      AppInit.DATA.vehicles.splice(idx, 1);
      AppInit.toast("Vehicle deleted", "success");
      new Vehicle().renderStats();
      VehicleStatic.VIEW === "grid"
        ? VehicleStatic.renderGrid()
        : VehicleStatic.renderTable();
    }
  }
}

class Vehicle {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
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
    VehicleStatic.el("vehForm").addEventListener("submit", (e) => {
      e.preventDefault();
      const f = e.target;
      const data = {
        make: f.make.value.trim(),
        model: f.model.value.trim(),
        year: Number(f.year.value),
        vin: f.vin.value.trim().toUpperCase(),
        mileage: Number(f.mileage.value),
        price: Number(f.price.value),
        owner: f.owner.value.trim(),
        status: f.status.value,
        image:
          f.image.value ||
          `https://images.unsplash.com/photo-1525609004556-c46c7d6cf023?q=80&w=1200&auto=format&fit=crop&sat=-20&sig=${Math.floor(
            Math.random() * 1000
          )}`,
        notes: f.notes.value.trim(),
      };
      if (!/^[A-HJ-NPR-Z0-9]{11,17}$/.test(data.vin)) {
        AppInit.toast("VIN must be 11–17 chars (no I,O,Q)", "error");
        return;
      }
      if (VehicleStatic.EDITING_ID) {
        const v = AppInit.DATA.vehicles.find(
          (x) => x.id === VehicleStatic.EDITING_ID
        );
        Object.assign(v, data);
        AppInit.toast("Vehicle updated", "success");
      } else {
        AppInit.DATA.vehicles.unshift({
          id: "VH-" + (1000 + AppInit.DATA.vehicles.length + 1),
          ...data,
        });
        AppInit.toast("Vehicle added", "success");
      }
      VehicleStatic.el("formModal").classList.remove("open");
      this.renderStats();
      VehicleStatic.VIEW === "grid"
        ? VehicleStatic.renderGrid()
        : VehicleStatic.renderTable();
    });
  }

  openAndCloseModal() {
    // open add form
    document
      .getElementById("addVehicleBtn")
      .addEventListener("click", () => VehicleStatic.openForm(null));
    document
      .querySelectorAll("[data-close]")
      .forEach((b) =>
        b.addEventListener("click", () =>
          document.getElementById(b.dataset.close).classList.remove("open")
        )
      );
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
        VehicleStatic.approve(ap.dataset.approve);
        return;
      }
      const rj = e.target.closest("[data-reject]");
      if (rj) {
        VehicleStatic.reject(rj.dataset.reject);
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
