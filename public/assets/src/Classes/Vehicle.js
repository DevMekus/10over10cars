import { CONFIG } from "../Utils/config.js";
import Application from "./Application.js";
import Utility from "./Utility.js";
import { DataTransfer } from "../Utils/api.js";
import { clearAppData, decryptJsToken } from "../Utils/Session.js";

export default class Vehicle {
  static VIEW = "grid";
  static SELECTED = new Set();
  static CURRENT_DATA = null;

  static renderStats(data) {
    Utility.el("sTotal").textContent = data.length;
    Utility.el("sApproved").textContent = data.filter(
      (v) => v.status === "approved"
    ).length;
    Utility.el("sPending").textContent = data.filter(
      (v) => v.status === "pending"
    ).length;
    Utility.el("sRejected").textContent = data.filter(
      (v) => v.status === "rejected"
    ).length;
  }

  static getFiltered() {
    const q = (Utility.el("q").value || "").toLowerCase();
    const status = Utility.el("statusFilter").value;
    const sort = Utility.el("sortBy").value;
    const min = Number(Utility.el("min").value || 0);
    const max = Number(Utility.el("max").value || 0);

    let rows = Application.DATA.vehicles.filter((v) => {
      const hay =
        `${v.make} ${v.model} ${v.vin} ${v.company} ${v.contact}`.toLowerCase();
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
    Vehicle.CURRENT_DATA = rows;
    return rows;
  }

  static async renderGrid() {
    const mount = Utility.el("gridView");
    const noData = document.querySelector(".no-data");

    mount.innerHTML = "";
    noData.innerHTML = "";
    const rows = Vehicle.getFiltered();

    if (rows == 0) {
      noData.innerHTML = `<div class="w-100 mt-4 text-center text-error"><p>Data not available</p></div>`;
      return;
    }
    const token = await decryptJsToken();
    // const role = token.role;

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
            <div class='price'>${Utility.fmtNGN(v.price)}</div>
          </div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'>
            <span><i class='bi bi-speedometer2'></i> ${Utility.fmt(
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
          <div class="action_btns mt-3">
            <button class='toolbar btn btn-sm btn-outline-accent' 
            data-view='${v.id}'><i class="fas fa-eye"></i>
            </button>       
            ${
              token?.role == "admin"
                ? `
                    <button class='toolbar btn btn-sm btn-outline-accent' 
                    data-edit='${v.id}'><i class="fas fa-pencil"></i>
                    </button>
                    

                    <button class='toolbar btn btn-sm btn-outline-error' 
                    data-delete='${v.id}'><i class="fas fa-trash danger"></i>
                    </button>
               ${
                 v.status !== "approved"
                   ? `<button class='toolbar btn btn-sm btn-outline-accent' data-approve='${v.id}'>
                   <i class="fas fa-check-circle approve"></i> 
                   </button>`
                   : ""
               }
            ${
              v.status !== "rejected"
                ? `<button class='toolbar btn btn-sm btn-outline-error' data-reject='${v.id}'>
                <i class="fas fa-times danger"></i> 
                </button>`
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
    const noData = document.querySelector(".no-data");

    wrap.innerHTML = "";
    noData.innerHTML = "";
    const rows = Vehicle.getFiltered();
    if (rows == 0) {
      noData.innerHTML = `<div class="w-100 mt-4 text-center text-error"><p>Data not available</p></div>`;
      return;
    }

    const token = await decryptJsToken();

    const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
    const slice = rows.slice(start, start + Utility.PER_PAGE);
    slice.forEach((v) => {
      const tr = document.createElement("tr");
      const images = JSON.parse(v.images);
      tr.innerHTML = `
        <td><input type='checkbox' data-sel='${v.id}' 
        ${Vehicle.SELECTED.has(v.id) ? "checked" : ""}></td>
        <td>
          <div style='display:flex;gap:8px;align-items:center'>
            <img src='${
              images[0]
            }' style='width:48px;height:34px;border-radius:8px;object-fit:cover' 
            alt='${v.title}'/>

            <div>
              <div style='font-weight:700'>
                ${v.title}
              </div>
              <div class='small muted'>
                ${v.owner ?? "not available"}
              </div>
            </div>
          </div>
        </td>
        <td><code>${v.vin}</code></td>
        <td>${v.company ?? "---"}</td>
        <td>${v.year}</td>
        <td>${Utility.fmt(v.mileage)}</td>
        <td>${Utility.fmtNGN(v.price)}</td>
        <td><span class='pill ${v.status}'>
        ${Utility.toTitleCase(v.status)}</span></td>
        <td>
            <div class="action_btns mt-3">
            <button class='toolbar btn btn-sm btn-outline-accent' 
            data-view='${v.id}'><i class="fas fa-eye"></i>
            </button>       
            ${
              token?.role == "admin"
                ? `
                    <button class='toolbar btn btn-sm btn-outline-accent' 
                    data-edit='${v.id}'><i class="fas fa-pencil"></i>
                    </button>
                    

                    <button class='toolbar btn btn-sm btn-outline-error' 
                    data-delete='${v.id}'><i class="fas fa-trash danger"></i>
                    </button>
               ${
                 v.status !== "approved"
                   ? `<button class='toolbar btn btn-sm btn-outline-primary' data-approve='${v.id}'>
                   <i class="fas fa-check-circle approve"></i>
                   </button>`
                   : ""
               }
            ${
              v.status !== "rejected"
                ? `<button class='toolbar btn btn-sm btn-outline-error' data-reject='${v.id}'>
                <i class="fas fa-times danger"></i>
                </button>`
                : ""
            } 
              `
                : ``
            }           
          </div>
       </td>`;
      wrap.appendChild(tr);
    });
    Utility.el(
      "pgInfo"
    ).textContent = `Page ${Utility.PAGE} • Showing ${slice.length} of ${rows.length}`;
  }

  static searchAndToggleFilter() {
    ["q", "statusFilter", "sortBy", "min", "max"].forEach((id) =>
      Utility.el(id).addEventListener("input", () => {
        Utility.PAGE = 1;
        Vehicle.VIEW === "grid" ? Vehicle.renderGrid() : Vehicle.renderTable();
      })
    );
  }

  static handlePagination() {
    Utility.el("prevPg").addEventListener("click", () => {
      if (Utility.PAGE > 1) {
        Utility.PAGE--;
        Vehicle.renderTable();
      }
    });

    Utility.el("nextPg").addEventListener("click", () => {
      const total = Vehicle.getFiltered().length;
      if (Utility.PAGE * Utility.PER_PAGE < total) {
        Utility.PAGE++;
        Vehicle.renderTable();
      }
    });
  }

  static getAllCars() {
    return Application.DATA.vehicles;
  }

  static notFound() {
    return `<div
      id="no-vehicle"
      class="empty-state"
      style="text-align:center; padding:2rem;"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="120"
        height="120"
        fill="none"
        stroke="#999"
        stroke-width="2"
        viewBox="0 0 24 24"
      >
        <path d="M3 13h2l1.5-4.5h11L19 13h2" />
        <circle cx="7.5" cy="17.5" r="2.5" />
        <circle cx="16.5" cy="17.5" r="2.5" />
        <path d="M5 13h14v4H5z" />
      </svg>
      <p style="margin-top:1rem; color:#666;">No vehicles found</p>
    </div>`;
  }

  static async findParticularCar(id) {
    //--get all the vehicles from the API
    Utility.toast("Searching...", "info");

    const response = await DataTransfer(`${CONFIG.API}/car/${id}`);

    if (!response || response.status !== 200) {
      Utility.toast("Vehicle not found", "error");
      return null;
    }

    return response.data;
  }

  static async uploadNewVehicle(uploadData, vin) {
    try {
      const result = await Utility.confirm("Upload New Vehicle");

      if (result.isConfirmed) {
        uploadData.append("vin", vin);
        const response = await DataTransfer(
          `${CONFIG.API}/car`,
          uploadData,
          "POST"
        );

        Utility.toast(
          response.message,
          response.status == 200 ? "success" : "error"
        );

        if (response.status == 200) {
          await clearAppData();
          await Application.initializeData();
        }

        return response.status == 200 ? true : false;
      } else {
        return false; // user cancelled
      }
    } catch (error) {
      console.error(error);
      return false; // always return something
    }
  }

  static async updateInformation(id, data) {
    const v = Application.DATA.vehicles.find((x) => x.id === id);
    if (!v) {
      Utility.toast("Vehicle not found", "error");
      return;
    }

    //---Send to Server
    const result = await Utility.confirm("Update vehicle information");
    if (result.isConfirmed) {
      const update = new FormData();
      update.append("data", JSON.stringify(data));
      update.append("vin", v.vin);

      const { message, status } = await DataTransfer(
        `${CONFIG.API}/admin/car/${id}`,
        update,
        "POST"
      );

      Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status == 200) {
        await clearAppData();
        await Application.initializeData();
        Vehicle.renderStats(Application.DATA.vehicles);
        Vehicle.VIEW === "grid" ? Vehicle.renderGrid() : Vehicle.renderTable();
      }

      return { status, message };
    }
  }

  static async deleteVehicle(id) {
    const idx = Application.DATA.vehicles.findIndex((x) => x.id === id);
    if (!idx) {
      Utility.toast("Vehicle not found", "error");
      return;
    }

    const result = await Utility.confirm("Delete vehicle");

    if (result.isConfirmed) {
      const { message, status } = await DataTransfer(
        `${CONFIG.API}/admin/car/${id}`,
        {},
        "DELETE"
      );

      Utility.toast(`${message}`, `${status == 200 ? "success" : "error"}`);

      if (status == 200) {
        await clearAppData();
        await Application.initializeData();
        Vehicle.renderStats(Application.DATA.vehicles);
        Vehicle.VIEW === "grid" ? Vehicle.renderGrid() : Vehicle.renderTable();
      }

      return { status, message };
    }
  }

  static async openDetail(id) {
    const v = Application.DATA.vehicles.find((x) => x.id === id);
    if (!v) {
      Utility.toast("Vehicle not found", "error");
      return;
    }
    const token = await decryptJsToken();
    const images = JSON.parse(v.images);
    const body = Utility.el("detailModalBody");
    const btns = Utility.el("detailModalButtons");
    Utility.el("detailModalLabel").textContent = v.title;
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
          <div class='small muted'>${Utility.fmt(
            v.mileage
          )} km • ${Utility.fmtNGN(v.price)}</div>
          <div style='margin-top:8px' class='small'>${v.notes || ""}</div>
          <div style='display:flex;gap:12px;margin-top:8px' class='small muted'><span>Status: <span class='pill ${
            v.status
          }'>${Utility.toTitleCase(v.status)}</span></span></div>
        </div>
      </div>`;
    token?.role == "admin"
      ? (btns.innerHTML = `    
      <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
             <button id="approveBtn" data-id="${id}" class="btn btn-sm btn-primary btn-pill">Approve</button>
             <button id="rejectBtn" data-id="${id}" class="btn btn-sm btn-ghost">Reject</button>
             <button id="deleteBtn" data-id="${id}" class="btn btn-sm btn-ghost">Delete</button>
         </div>`)
      : "";

    $("#displayDetails").modal("show");
  }
}
