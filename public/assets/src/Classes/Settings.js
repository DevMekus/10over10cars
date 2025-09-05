import { clearAppData } from "../Utils/Session.js";
import Application from "./Application.js";
import Utility from "./Utility.js";
import { CONFIG } from "../Utils/config.js";
import { DataTransfer } from "../Utils/api.js";
import { clearPHPProfileSession } from "../Utils/Session.js";

export default class Settings {
  static async updateUserprofile(formEl, message, fromModal = false) {
    //--FormEl is e.target from the submit event listener

    const formData = new FormData(formEl);
    const userid = formEl.userid.value.trim();

    if (fromModal) {
      $("#updatePassword").modal("hide");
    }

    const result = await Utility.confirm(message);

    if (result.isConfirmed) {
      const response = await DataTransfer(
        `${CONFIG.API}/user/${fromModal ? "password/" : ""}${userid}`,
        formData,
        "POST"
      );

      Utility.toast(
        response.message,
        response.status == 200 ? "success" : "error"
      );

      Swal.fire(
        response.status == 200 ? "Success!" : "Error",
        `${response.message}`,
        response.status == 200 ? "success" : "error"
      );

      if (response.status == 200) {
        await clearPHPProfileSession();
        await clearAppData();
        await Application.initializeData();
        Utility.reloadPage();
      }

      return response;
    }
  }

  // static activityTimeline(activityItems) {
  //   const activityList = document.getElementById("activityList");
  //   activityList.innerHTML = "";

  //   activityItems.forEach((it, idx) => {
  //     const el = document.createElement("div");
  //     el.className = "timeline-item";

  //     el.innerHTML = `
  //     <div class="timeline-marker"></div>
  //     <div class="timeline-content">
  //       <div class="timeline-header">
  //         <h4 class="timeline-title">${it.type}</h4>
  //         <span class="timeline-period">${it.period}</span>
  //       </div>
  //       ${it.title ? `<p class="timeline-description">${it.title}</p>` : ""}
  //     </div>
  //   `;
  //     activityList.appendChild(el);
  //   });
  // }

  static activityTimeline(activityItems, page = 1, perPage = 10) {
    const activityList = document.getElementById("activityList");
    activityList.innerHTML = "";

    // Pagination logic
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const paginatedItems = activityItems.slice(start, end);

    // Build Table
    const table = document.createElement("table");
    table.className = "table table-sm table-striped table-hover";
    table.innerHTML = `
    <thead>
      <tr>
        <th>#</th>
        <th>Type</th>
        <th>Period</th>
        <th>Title</th>
      </tr>
    </thead>
    <tbody>
      ${paginatedItems
        .map(
          (it, idx) => `
        <tr>
          <td>${start + idx + 1}</td>
          <td>${it.type.toUpperCase()}</td>
          <td>${it.period}</td>
          <td>${Utility.toTitleCase(it.title) ?? ""}</td>
        </tr>
      `
        )
        .join("")}
    </tbody>
  `;

    activityList.appendChild(table);

    // Pagination controls
    const totalPages = Math.ceil(activityItems.length / perPage);
    const pagination = document.createElement("nav");
    pagination.innerHTML = `
    <ul class="pagination justify-content-center">
      <li class="page-item ${page === 1 ? "disabled" : ""}">
        <a class="page-link btn btn-sm btn-primary" href="#" 
        data-page="${page - 1}">Previous</a>
      </li>
      ${Array.from({ length: totalPages }, (_, i) => {
        const p = i + 1;
        return `
          <li class="page-item ${p === page ? "active" : ""}">
            <a class="page-link btn btn-sm btn-outline-primary" href="#" data-page="${p}">${p}</a>
          </li>
        `;
      }).join("")}
      <li class="page-item ${page === totalPages ? "disabled" : ""}">
        <a class="page-link btn btn-sm btn-primary" href="#" 
        data-page="${page + 1}">Next</a>
      </li>
    </ul>
  `;

    activityList.appendChild(pagination);

    // Handle page clicks
    pagination.querySelectorAll("a[data-page]").forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const newPage = parseInt(e.target.dataset.page);
        if (newPage > 0 && newPage <= totalPages) {
          this.activityTimeline(activityItems, newPage, perPage);
        }
      });
    });
  }

  static async loadSessions(userId) {
    const tbody = document.querySelector("#sessionsTable tbody");
    const noData = Utility.el("no-data");

    const response = await DataTransfer(`${CONFIG.API}/user/session/${userId}`);
    const sessions = response.status == 200 ? response.data : null;

    if (!sessions) {
      Utility.renderEmptyState(noData);
      return;
    }
    tbody.innerHTML = "";
    noData.innerHTML = "";

    sessions.forEach((session) => {
      const row = document.createElement("tr");
      row.innerHTML = `
      <td>${session.id}</td>
      <td title="${session.device}">
      ${
        session.device ? Utility.truncateText(session.device, 20) : "Unknown"
      }</td>
      <td>${session.ip_address}</td>
      <td>${session.last_active}</td>
      <td>
        <button class="btn btn-danger btn-sm" onclick="revokeSession(${
          session.id
        }, ${userId})">
          Revoke
        </button>
      </td>
    `;
      tbody.appendChild(row);
    });
  }

  static async revokeSession(id, userId) {
    if (!confirm("Are you sure you want to revoke this session?")) return;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("user_id", userId);

    const res = await fetch("revokeSession.php", {
      method: "POST",
      body: formData,
    });
    const result = await res.json();
    alert(result.message);

    loadSessions(); // refresh table
  }
}
