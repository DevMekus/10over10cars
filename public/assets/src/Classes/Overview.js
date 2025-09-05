import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import { CONFIG } from "../Utils/config.js";

/**
 * Overview.js
 *
 * Responsible for rendering dashboard statistics, charts,
 * and recent activity for the application.
 *
 * Imports:
 *  - Utility: Common DOM and formatting helpers.
 *  - Application: Holds global application data (DATA).
 *  - CONFIG: Application configuration constants.
 */

export default class Overview {
  /**
   * Render top-level statistics (vehicles, verifications, dealers, revenue).
   */
  static renderStats() {
    try {
      const data = Application.DATA || {};

      const activeVehicle =
        data.vehicles?.filter((v) => v.status === "approved").length || 0;

      const verifications = data.verifications?.length || 0;
      const totalDealers = data.dealers?.length || 0;

      Utility.el("statVer").textContent = verifications;
      Utility.el("statVeh").textContent = activeVehicle;
      Utility.el("statDeal").textContent = totalDealers;

      const revEl = Utility.el("statRev");
      if (revEl) revEl.textContent = `NGN ${Overview.revenueNGN()}`;
    } catch (error) {
      console.error("Error rendering stats:", error);
    }
  }

  /**
   * Calculate total revenue in NGN.
   * @returns {number} Total revenue.
   */
  static revenueNGN() {
    try {
      return (
        Application.DATA.txns?.reduce((sum, t) => {
          const amt = Number(t.amount || 0);
          return sum + (isNaN(amt) ? 0 : amt);
        }, 0) || 0
      );
    } catch (error) {
      console.error("Error calculating revenue:", error);
      return 0;
    }
  }

  /**
   * Get verifications that occurred within the last 30 days.
   * @returns {Array} Filtered verification objects.
   */
  static verificationsLast30Days() {
    try {
      if (!Application.DATA.verifications) return [];

      const now = new Date();
      const cutoff = new Date();
      cutoff.setDate(now.getDate() - 30);

      return Application.DATA.verifications.filter((v) => {
        const date = new Date(v.period || v.created_at || v.date);
        return !isNaN(date) && date >= cutoff;
      });
    } catch (error) {
      console.error("Error fetching verifications (30 days):", error);
      return [];
    }
  }

  /**
   * Aggregate verifications by day for charting purposes.
   * @returns {Object} Map of date → count.
   */
  static verificationsByDay() {
    try {
      const logs = Overview.verificationsLast30Days();
      const daily = {};

      logs.forEach((v) => {
        const d = new Date(v.period || v.created_at || v.date)
          .toISOString()
          .split("T")[0];
        daily[d] = (daily[d] || 0) + 1;
      });

      return daily;
    } catch (error) {
      console.error("Error aggregating verifications by day:", error);
      return {};
    }
  }

  /**
   * Render line chart of verifications for the last 30 days.
   */
  static renderChart() {
    try {
      const ctx = document.getElementById("chartVer")?.getContext("2d");
      if (!ctx) return;

      const dailyData = Overview.verificationsByDay();
      const labels = Object.keys(dailyData).sort();
      const values = labels.map((d) => dailyData[d]);

      new Chart(ctx, {
        type: "line",
        data: {
          labels,
          datasets: [
            {
              label: "Verifications (30 days)",
              data: values,
              borderColor: "#007bff",
              backgroundColor: "rgba(0,123,255,0.2)",
              borderWidth: 2,
              pointBackgroundColor: "#007bff",
              tension: 0.3,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              labels: { color: "#333" },
            },
          },
          scales: {
            x: {
              ticks: { color: "#666" },
              grid: { display: false },
            },
            y: {
              ticks: { color: "#666" },
              grid: { color: "rgba(200,200,200,0.2)" },
            },
          },
        },
      });
    } catch (error) {
      console.error("Error rendering chart:", error);
    }
  }

  /**
   * Render recent activity logs.
   * @param {Array} logs - Array of log objects.
   */
  static renderRecent(logs) {
    try {
      const activityList = document.getElementById("activityList");
      if (!activityList) return;

      activityList.innerHTML = "";

      const recent = logs.slice(-10).reverse();
      recent.forEach((log) => {
        const li = document.createElement("li");
        li.className = "small";
        li.innerHTML = `
          <strong>${log.type?.toUpperCase() ?? "UNKNOWN"}</strong> 
          ${log.fullname ?? "Anonymous"} — 
          <span class="muted">${log.title ?? ""}</span>
        `;
        activityList.appendChild(li);
      });
    } catch (error) {
      console.error("Error rendering recent activity:", error);
    }
  }

  /**
   * Render recent verifications in table format.
   * @param {Array} verifications - Array of verification objects.
   */
  static renderRecentVerification(verifications) {
    try {
      const tbody = document.querySelector("#tableVer tbody");
      const noData = document.querySelector(".no-data");
      if (!tbody) return;

      noData.innerHTML = "";
      tbody.innerHTML = "";

      const recent = verifications.slice(-10).reverse();
      if (recent.length === 0) {
        Utility.renderEmptyState(noData);
        return;
      }

      recent.forEach((v) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><strong>${v.vin?.substring(0, 8) ?? "N/A"}...</strong></td>
          <td>${v.result ?? "—"}</td>
          <td>${v.source ?? "System"}</td>
          <td>${v.date ?? "—"}</td>
          <td>
            <a href="${CONFIG.BASE_URL}/dashboard/verification" 
               class="btn btn-sm btn-outline-primary" 
               data-vin="${v.vin}">
              View
            </a>
          </td>
        `;
        tbody.appendChild(tr);
      });
    } catch (error) {
      console.error("Error rendering recent verifications:", error);
    }
  }

  /**
   * Render recent transactions in table format.
   * @param {Array} txns - Array of transaction objects.
   */
  static renderRecentTransaction(txns) {
    try {
      const tbody = document.getElementById("txnTable");
      const noData = document.querySelector(".no-data2");
      if (!tbody) return;

      tbody.innerHTML = "";
      noData.innerHTML = "";

      const recent = txns.slice(-10).reverse();
      if (recent.length === 0) {
        Utility.renderEmptyState(noData);
        return;
      }

      recent.forEach((t) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><strong>${t.request_id ?? "—"}</strong></td>
          <td>${
            Utility.fmtNGN ? Utility.fmtNGN(t.amount) : t.amount ?? "—"
          }</td>
          <td>
            <span class="badge ${t.status ?? "unknown"}">
              ${t.status ?? "unknown"}
            </span>
          </td>
          <td>${t.date ?? "—"}</td>
        `;
        tbody.appendChild(tr);
      });
    } catch (error) {
      console.error("Error rendering recent transactions:", error);
    }
  }
}
