import { clearAppData, clearPHPProfileSession } from "../Utils/Session.js";
import Application from "./Application.js";
import Utility from "./Utility.js";
import { CONFIG } from "../Utils/config.js";
import { DataTransfer } from "../Utils/api.js";

/**
 * Settings class handles user profile updates, activity logs,
 * session management, and account-related operations.
 */
export default class Settings {
  /**
   * Updates user profile or password depending on context.
   * @param {HTMLFormElement} formEl - The form element containing user inputs.
   * @param {string} message - Confirmation message to display before updating.
   * @param {boolean} [fromModal=false] - If true, indicates update came from a modal form.
   * @returns {Promise<Object|undefined>} Response object from API or undefined if cancelled.
   */
  static async updateUserprofile(formEl, message, fromModal = false) {
    try {
      const formData = new FormData(formEl);
      const userid = formEl.userid?.value.trim();

      if (!userid) {
        Utility.toast("Invalid user ID", "error");
        return;
      }

      if (fromModal) {
        $("#updatePassword").modal("hide");
      }

      const result = await Utility.confirm(message);
      if (!result.isConfirmed) return;

      const response = await DataTransfer(
        `${CONFIG.API}/user/${fromModal ? "password/" : ""}${userid}`,
        formData,
        "POST"
      );

      Utility.toast(
        response.message,
        response.status === 200 ? "success" : "error"
      );

      Swal.fire(
        response.status === 200 ? "Success!" : "Error",
        response.message,
        response.status === 200 ? "success" : "error"
      );

      if (response.status === 200) {
        await clearPHPProfileSession();
        await clearAppData();
        await Application.initializeData();
        Utility.reloadPage();
      }

      return response;
    } catch (error) {
      console.error("Error updating user profile:", error);
      Utility.toast("An error occurred while updating profile.", "error");
    }
  }

  /**
   * Renders activity timeline in a paginated table format.
   * @param {Array<Object>} activityItems - List of activity objects { type, period, title }.
   * @param {number} [page=1] - Current page.
   * @param {number} [perPage=10] - Items per page.
   */
  static activityTimeline(activityItems, page = 1, perPage = 10) {
    try {
      const activityList = document.getElementById("activityList");
      if (!activityList) return;

      activityList.innerHTML = "";

      // Pagination logic
      const start = (page - 1) * perPage;
      const end = start + perPage;
      const paginatedItems = activityItems.slice(start, end);

      // Build table
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
              <td>${it.type?.toUpperCase() ?? "N/A"}</td>
              <td>${it.period ?? "N/A"}</td>
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
            <a class="page-link btn btn-sm btn-primary" href="#" data-page="${
              page - 1
            }">Previous</a>
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
            <a class="page-link btn btn-sm btn-primary" href="#" data-page="${
              page + 1
            }">Next</a>
          </li>
        </ul>
      `;

      activityList.appendChild(pagination);

      // Handle page clicks
      pagination.querySelectorAll("a[data-page]").forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          const newPage = parseInt(e.target.dataset.page, 10);
          if (newPage > 0 && newPage <= totalPages) {
            this.activityTimeline(activityItems, newPage, perPage);
          }
        });
      });
    } catch (error) {
      console.error("Error rendering activity timeline:", error);
    }
  }

  /**
   * Loads active sessions for a user and renders them in the session table.
   * @param {string|number} userId - User ID whose sessions to load.
   */
  static async loadSessions(userId) {
    try {
      const tbody = document.querySelector("#sessionsTable tbody");
      const noData = Utility.el("no-data");

      if (!tbody || !noData) return;

      const response = await DataTransfer(
        `${CONFIG.API}/user/session/${userId}`
      );
      const sessions = response.status === 200 ? response.data : null;

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
          <td title="${session.device ?? "Unknown"}">
            ${
              session.device
                ? Utility.truncateText(session.device, 20)
                : "Unknown"
            }
          </td>
          <td>${session.ip_address ?? "N/A"}</td>
          <td>${session.last_active ?? "N/A"}</td>
          <td>
            <button class="btn btn-danger btn-sm" onclick="Settings.revokeSession(${
              session.id
            }, ${userId})">
              Revoke
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    } catch (error) {
      console.error("Error loading sessions:", error);
      Utility.toast("Unable to load sessions at this time.", "error");
    }
  }

  /**
   * Revokes a user session by ID.
   * @param {number} id - Session ID to revoke.
   * @param {string|number} userId - User ID owning the session.
   */
  static async revokeSession(id, userId) {
    try {
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
      await this.loadSessions(userId); // Refresh session table
    } catch (error) {
      console.error("Error revoking session:", error);
      alert("Failed to revoke session. Please try again.");
    }
  }
}
