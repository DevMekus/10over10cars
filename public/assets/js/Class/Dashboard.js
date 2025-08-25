import Utility from "./Utility.js";
import AppInit from "./Application.js";

export default class DashboardInit {}

class Dashboard {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }
  overviewCounter() {
    const verifications = document.getElementById("statVer");
    const vehicles = document.getElementById("statVeh");
    const dealers = document.getElementById("statDeal");
    if (!dealers || !verifications) return;

    verifications.textContent = AppInit.DATA.verifications.length;
    vehicles.textContent = AppInit.DATA.vehicles.length;
    dealers.textContent = AppInit.DATA.dealers.length;
  }

  renderUserTransactions() {
    const txnTable = document.getElementById("txnTable");

    AppInit.DATA.txns.slice(0, 5).forEach((t) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td>${t.id}</td><td>${AppInit.fmtNGN(
        t.amount
      )}</td><td><span class=\"status-pill ${
        t.status === "Completed" ? "status-success" : "status-pending"
      }\">${t.status}</span></td><td>${t.date}</td>`;
      txnTable.appendChild(tr);
    });
  }
}

new Dashboard();
