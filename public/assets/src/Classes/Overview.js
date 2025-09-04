import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";

export default class Overview {
  static renderStats() {
    const data = Application.DATA;

    const activeVehicle =
      data.vehicles?.filter((v) => v.status === "approved").length || 0;

    const verifications = data.verifications?.length || 0;
    const totalDealers = data.dealers?.length || 0;

    Utility.el("statVer").textContent = verifications;
    Utility.el("statVeh").textContent = activeVehicle;
    Utility.el("statVeh").textContent = activeVehicle;
    Utility.el("statDeal").textContent = activeVehicle;
    Utility.el("statRev")
      ? (Utility.el("statRev").textContent = `NGN ${Overview.revenueNGN()}`)
      : null;
  }

  // revenue (sum of txn.amount if available, fallback to 0)
  static revenueNGN() {
    return (
      Application.DATA.txns?.reduce((sum, t) => {
        const amt = Number(t.amount || 0);
        return sum + (isNaN(amt) ? 0 : amt);
      }, 0) || 0
    );
  }

  static verificationsLast30Days() {
    // Get verifications within last 30 days
    if (!Application.DATA.verifications) return [];

    const now = new Date();
    const cutoff = new Date();
    cutoff.setDate(now.getDate() - 30);

    return Application.DATA.verifications.filter((v) => {
      const date = new Date(v.period || v.created_at || v.date);
      return date >= cutoff;
    });
  }

  static verificationsByDay() {
    // Count per day (for charting)
    const logs = Overview.verificationsLast30Days();
    const daily = {};

    logs.forEach((v) => {
      const d = new Date(v.period || v.created_at || v.date)
        .toISOString()
        .split("T")[0];
      daily[d] = (daily[d] || 0) + 1;
    });

    return daily;
  }

  static renderChart() {
    const ctx = document.getElementById("chartVer").getContext("2d");

    const dailyData = Overview.verificationsByDay();
    const labels = Object.keys(dailyData).sort(); // sorted dates
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
  }

  static renderRecent(logs) {
    const activityList = document.getElementById("activityList");
    if (!activityList) return;

    activityList.innerHTML = "";

    // take last 10 logs (most recent)
    const recent = logs.slice(-10).reverse(); // reverse → newest first

    recent.forEach((log) => {
      const li = document.createElement("li");
      li.className = "small";
      li.innerHTML = `
        <strong>${log.type.toUpperCase()}</strong> 
        ${log.fullname} — 
        <span class="muted">${log.title}</span>
      `;
      activityList.appendChild(li);
    });
  }

  static renderRecentverification(verifications) {
    const tbody = document.querySelector("#tableVer tbody");
    const noData = document.querySelector(".no-data");
    if (!tbody) return;

    noData.innerHTML = "";
    tbody.innerHTML = "";

    // take last 10 verifications (newest first)
    const recent = verifications.slice(-10).reverse();

    if (recent.length == 0) {
      Utility.renderEmptyState(noData);
      return;
    }

    recent.forEach((v) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><strong>${v.vin.substring(0, 8)}...</strong></td>
        <td>${v.result ?? "—"}</td>
        <td>${v.source ?? "System"}</td>
        <td>${new Date(v.date).toLocaleString()}</td>
        <td>
          <button class="btn btn-sm btn-outline-primary" 
                  data-vin="${v.vin}">
            View
          </button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  static renderRecentTransaction(txns) {
    const tbody = document.getElementById("txnTable");
    const noData = document.querySelector(".no-data2");
    if (!tbody) return;

    tbody.innerHTML = "";
    noData.innerHTML = "";

    // take last 10 transactions (newest first)
    const recent = txns.slice(-10).reverse();
    if (recent.length == 0) {
      Utility.renderEmptyState(noData);
      return;
    }

    recent.forEach((t) => {
      const tr = document.createElement("tr");

      tr.innerHTML = `
        <td><strong>${t.id ?? "—"}</strong></td>
        <td>${Utility.fmtNGN ? Utility.fmtNGN(t.amount) : t.amount}</td>
        <td>
          <span class="badge ${
            t.status === "Completed" ? "bg-success" : "bg-warning"
          }">
            ${t.status}
          </span>
        </td>
        <td>${new Date(t.date).toLocaleString()}</td>
      `;

      tbody.appendChild(tr);
    });
  }
}
