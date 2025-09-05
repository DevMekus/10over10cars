import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import { CONFIG } from "../Utils/config.js";
import { clearAppData, decryptJsToken } from "../Utils/Session.js";
import { DataTransfer } from "../Utils/api.js";

export default class Transaction {
  static currentData = [];
  static revenueChartInstance = null;

  static statistics() {
    const total = Application.DATA.txns.length;
    const success = Application.DATA.txns.filter(
      (t) => t.status === "success"
    ).length;
    const pending = Application.DATA.txns.filter(
      (t) => t.status === "pending"
    ).length;
    const failed = Application.DATA.txns.filter(
      (t) => t.status === "failed"
    ).length;
    const revenue = Application.DATA.txns.reduce(
      (s, t) => s + (t.status === "success" ? t.amount : 0),
      0
    );
    document.getElementById("statTotal").textContent = total;
    document.getElementById("statSuccess").textContent = success;
    document.getElementById("statPending").textContent = pending;
    document.getElementById("statFailed").textContent = failed;
    document.getElementById("totalRevenue").textContent =
      Utility.fmtNGN(revenue);
  }

  static async transactionTable(data) {
    const tbody = document.querySelector("#txTable tbody");
    const noData = document.querySelector(".no-data");
    if (!tbody) return;
    tbody.innerHTML = "";
    noData.innerHTML = "";
    const q = (document.getElementById("q").value || "").toLowerCase();
    const status = document.getElementById("statusFilter").value;
    const method = document.getElementById("methodFilter").value;
    const from = document.getElementById("fromDate").value;
    const to = document.getElementById("toDate").value;

    let filtered = data.filter((t) => {
      if (
        status !== "all" &&
        status === "success" &&
        t.status !== "success" &&
        status !== "all"
      )
        return false;
      if (status !== "all" && status !== t.status && status !== "all")
        return false;
      if (method !== "all" && t.method !== method) return false;
      if (q && !`${t.id} ${t.user}`.toLowerCase().includes(q)) return false;
      if (from && t.date < from) return false;
      if (to && t.date > to) return false;

      return true;
    });
    const totalFiltered = filtered.length;

    if (totalFiltered == 0) {
      Utility.renderEmptyState(noData);
      return;
    }
    Transaction.currentData = data;

    const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
    const slice = filtered.slice(start, start + Utility.PER_PAGE);

    const token = await decryptJsToken();

    slice.forEach((tx) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
          <td><code>${tx.txnsid}</code></td>
          <td>${tx.user}</td>
          <td>${Utility.fmtNGN(tx.amount)}</td>
          <td>${tx.method.toUpperCase()}</td>
           <td class="small muted">${tx.desc ?? "---"}</td>
          <td class='small'>${tx.date}</td>
          <td>${
            tx.status === "success"
              ? `<span class='status-pill approved'>Success</span>`
              : tx.status === "pending"
              ? `<span class='status-pill pending'>Pending</span>`
              : `<span class='status-pill failed'>Failed</span>`
          }</td>
          <td>
          <div style='display:flex;gap:6px'>
          <button class='btn btn-sm btn-primary' 
          data-view='${tx.txnsid}'>View</button>

          ${
            token?.role == "admin"
              ? `
            <button class='btn btn-sm  btn-outline-error' 
              data-block='${tx.txnsid}'>Delete</button></div></td>
            `
              : ``
          }
         
        `;
      tbody.appendChild(tr);
    });

    document.getElementById("pgInfo").textContent = `Page ${
      Utility.PAGE
    } of ${Utility.pageCount(data)}, showing ${
      slice.length
    } of ${totalFiltered}`;
  }

  static paginationHandler(data) {
    // ---------- Pagination handlers ----------
    document.getElementById("prev").addEventListener("click", () => {
      if (Utility.PAGE > 1) Utility.PAGE--;
      Transaction.transactionTable(data);
    });

    document.getElementById("next").addEventListener("click", () => {
      if (Utility.PAGE < Utility.pageCount(data)) Utility.PAGE++;
      Transaction.transactionTable(data);
    });
  }

  static filterAndSearch(data) {
    ["q", "statusFilter", "methodFilter", "fromDate", "toDate"].forEach((id) =>
      document.getElementById(id).addEventListener("input", () => {
        Utility.PAGE = 1;
        Transaction.transactionTable(data);
      })
    );
  }

  static revenueNGN(domElem) {
    const revenue =
      Application.DATA.txns?.reduce((sum, t) => {
        const amt = Number(t.amount || 0);
        return sum + (isNaN(amt) ? 0 : amt);
      }, 0) || 0;

    domElem.textContent = `${Utility.fmtNGN(revenue)}`;
  }

  static revenueChart(transactions) {
    const canvas = document.getElementById("revChart");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    // Destroy existing chart safely
    if (Transaction.revenueChartInstance) {
      Transaction.revenueChartInstance.destroy();
      Transaction.revenueChartInstance = null;
    }

    const existingChart = Chart.getChart("revChart");
    if (existingChart) {
      existingChart.destroy();
    }

    // Generate last 30 days labels (MM/DD)
    const today = new Date();
    const labels = Array.from({ length: 30 }, (_, i) => {
      const d = new Date(today);
      d.setDate(today.getDate() - (29 - i));
      return `${d.getMonth() + 1}/${d.getDate()}`;
    });

    // Prepare a map of date => total revenue
    const revenueMap = {};
    transactions.forEach((txn) => {
      if (txn.status === "successful") {
        const d = new Date(txn.date);
        const key = `${d.getMonth() + 1}/${d.getDate()}`;
        const amt = parseFloat(txn.amount) || 0;
        revenueMap[key] = (revenueMap[key] || 0) + amt;
      }
    });

    // Build dataset aligned with labels
    const dataset = labels.map((lbl) => revenueMap[lbl] || 0);

    Transaction.revenueChartInstance = new Chart(ctx, {
      type: "line",
      data: {
        labels,
        datasets: [
          {
            label: "Revenue",
            data: dataset,
            tension: 0.3,
            borderColor: "var(--primary)",
            backgroundColor: "rgba(14,165,233,0.08)",
            fill: true,
            pointRadius: 3,
            pointBackgroundColor: "var(--primary)",
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (context) => `₦${context.raw.toLocaleString()}`,
            },
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value) => `₦${value}`,
            },
          },
        },
      },
    });
  }

  static async doUpdate(id, decision, fromModal = false) {
    const tx = Application.DATA.txns.find((t) => t.txnsid === id);
    if (!tx) {
      Utility.toast("Transaction not found", "error");
      return;
    }

    //----Send to API and send response
    if (fromModal) $("#displayDetails").modal("hide");

    if (decision == "refund" && tx.status !== "success") {
      Utility.toast("Only successful transactions can be refunded", "error");
      return;
    }

    const result = await Utility.confirm("Update changes");

    if (result.isConfirmed) {
      const response = await DataTransfer(
        `${CONFIG.API}/admin/transaction/${id}`,
        { status: decision },
        "PATCH"
      );

      Utility.toast(
        response.message,
        response.status == 200 ? "success" : "error"
      );
      if (response.status == 200) {
        await clearAppData();
        await Application.initializeData();
        Transaction.statistics();
        Transaction.transactionTable(Application.DATA.txns);
      }
    } else {
      $("#displayDetails").modal("show");
    }
  }

  static async deleteTransaction(id, fromModal = false) {
    const tx = Application.DATA.txns.find((t) => t.txnsid === id);
    
    if (!tx) {
      Utility.toast("Transaction not found", "error");
      return;
    }

    //----Send to API and send response
    if (fromModal) $("#displayDetails").modal("hide");

    const result = await Utility.confirm(
      "Delete transaction?",
      "Action is not reversible"
    );

    if (result.isConfirmed) {
      const response = await DataTransfer(
        `${CONFIG.API}/admin/transaction/${id}`,
        {},
        "DELETE"
      );

      Utility.toast(
        response.message,
        response.status == 200 ? "success" : "error"
      );
      if (response.status == 200) {
        await clearAppData();
        await Application.initializeData();
        Transaction.statistics();
        Transaction.transactionTable(Application.DATA.txns);
      }
    } else {
      if (fromModal) $("#displayDetails").modal("show");
    }
  }

  static async openDetail(id) {
    const tx = Application.DATA.txns.find((t) => t.txnsid === id);
    if (!tx) {
      Utility.toast("Transaction not found", "error");
      return;
    }

    const domBody = Utility.el("detailModalBody");
    let title = Utility.el("detailModalLabel");
    const token = await decryptJsToken();

    title.innerHTML = "";
    domBody.innerHTML = "";
    title.textContent = `Transaction details: (${id})`;
    domBody.innerHTML = `
      <div id="detailModalTx">
        <div class="modal-card container">        
         <div style="margin-top:12px" class="row">
             <div class="col-sm-6">
                 <div style="background:#f3f6fb;padding:12px;border-radius:8px"><strong id="txId">${id}</strong>
                     <div class="muted small" id="txDate">${tx.date}</div>
                 </div>
                 <div style="margin-top:12px"><strong>Amount</strong>
                     <div id="txAmount" class="big">${Utility.fmtNGN(
                       tx.amount
                     )}</div>
                 </div>
                 <div style="margin-top:12px"><strong>Method</strong>
                     <div id="txMethod" class="muted small">${tx.method}</div>
                 </div>
                 <div style="margin-top:12px"><strong>Status</strong>
                     <div id="txStatus" class="muted small">${tx.status}</div>
                 </div>
                 ${
                   token?.role == "admin"
                     ? `
                  <div style="margin-top:12px"><strong>Action</strong>
                     <div style="display:flex;gap:8px;margin-top:8px">
                     <button class="btn btn-primary btn-sm btn-pill" data-target="${id}" id="refundBtn">Refund</button>
                     <button class="btn btn-sm btn-outline-error" data-target="${id}" id="blockBtn">Delete</button></div>
                 </div>
                  
                  `
                     : ``
                 }
                 
             </div>
             <div class="col-sm-6">
                 <div><strong>User/Dealer</strong>
                     <div id="txUser" class="muted small">${tx.fullname}</div>
                 </div>
                 <div style="margin-top:12px"><strong>Notes /Logs</strong>
                     <div id="txNotes" class="muted small">${
                       tx.notes ?? "---"
                     }</div>
                 </div>
                 
             </div>
         </div>
     </div>
      </div>
    `;
    //---Event Delegations
    $("#displayDetails").modal("show");

    document.addEventListener("click", (e) => {
      if (e.target && e.target.id === "blockBtn") {
        Transaction.deleteTransaction(
          document.getElementById("blockBtn").dataset.target
        );
      }
    });
  }
}
