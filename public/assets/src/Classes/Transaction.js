import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import { CONFIG } from "../Utils/config.js";
import { clearAppData, decryptJsToken } from "../Utils/Session.js";
import { DataTransfer } from "../Utils/api.js";
/**
 * Transaction Management Class
 * --------------------------------------------
 * Handles transaction statistics, filtering, pagination,
 * revenue reporting, CRUD operations, and detailed views.
 *
 * Dependencies:
 *  - Utility (formatting, UI helpers, toasts, confirmation modals)
 *  - Application (global app state/data)
 *  - CONFIG (API configuration)
 *  - Session utilities (clearAppData, decryptJsToken)
 *  - DataTransfer (HTTP abstraction layer)
 */

export default class Transaction {
  static currentData = [];
  static revenueChartInstance = null;

  /**
   * Generate and display transaction statistics
   * (total, success, pending, failed, total revenue).
   */
  static statistics() {
    try {
      const { txns } = Application.DATA;
      if (!Array.isArray(txns)) return;

      const total = txns.length;
      const success = txns.filter((t) => t.status === "success").length;
      const pending = txns.filter((t) => t.status === "pending").length;
      const failed = txns.filter((t) => t.status === "failed").length;
      const revenue = txns.reduce(
        (sum, t) => sum + (t.status === "success" ? Number(t.amount) || 0 : 0),
        0
      );

      Utility.el("statTotal").textContent = total;
      Utility.el("statSuccess").textContent = success;
      Utility.el("statPending").textContent = pending;
      Utility.el("statFailed").textContent = failed;
      Utility.el("totalRevenue").textContent = Utility.fmtNGN(revenue);
    } catch (error) {
      console.error("Error generating transaction statistics:", error);
      Utility.toast("Failed to generate transaction statistics", "error");
    }
  }

  /**
   * Render paginated transaction table with filtering and search.
   * @param {Array} data - List of transactions.
   */
  static async transactionTable(data) {
    try {
      const tbody = document.querySelector("#txTable tbody");
      const noData = document.querySelector(".no-data");
      if (!tbody || !noData) return;

      tbody.innerHTML = "";
      noData.innerHTML = "";

      // --- Collect filters ---
      const q = (Utility.el("q").value || "").toLowerCase();
      const status = Utility.el("statusFilter").value;
      const method = Utility.el("methodFilter").value;
      const from = Utility.el("fromDate").value;
      const to = Utility.el("toDate").value;

      // --- Apply filters ---
      const filtered = data.filter((t) => {
        if (status !== "all" && t.status !== status) return false;
        if (method !== "all" && t.method !== method) return false;
        if (q && !`${t.id} ${t.user}`.toLowerCase().includes(q)) return false;
        if (from && t.date < from) return false;
        if (to && t.date > to) return false;
        return true;
      });

      const totalFiltered = filtered.length;
      if (totalFiltered === 0) {
        Utility.renderEmptyState(noData);
        return;
      }

      Transaction.currentData = data;
      const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
      const slice = filtered.slice(start, start + Utility.PER_PAGE);
      const token = await decryptJsToken();

      // --- Render rows ---
      slice.forEach((tx) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><code>${tx.txnsid}</code></td>
          <td>${tx.user}</td>
          <td>${Utility.fmtNGN(tx.amount)}</td>
          <td>${tx.method?.toUpperCase() ?? "---"}</td>
          <td class="small muted">${tx.desc ?? "---"}</td>
          <td class="small">${tx.date}</td>
          <td>
            ${
              tx.status === "success"
                ? `<span class="status-pill approved">Success</span>`
                : tx.status === "pending"
                ? `<span class="status-pill pending">Pending</span>`
                : `<span class="status-pill failed">Failed</span>`
            }
          </td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn btn-sm btn-primary" data-view="${
                tx.txnsid
              }">View</button>
              ${
                token?.role === "admin"
                  ? `<button class="btn btn-sm btn-outline-error" data-block="${tx.txnsid}">Delete</button>`
                  : ""
              }
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });

      Utility.el("pgInfo").textContent = `Page ${
        Utility.PAGE
      } of ${Utility.pageCount(data)}, showing ${
        slice.length
      } of ${totalFiltered}`;
    } catch (error) {
      console.error("Error rendering transaction table:", error);
      Utility.toast("Failed to render transactions", "error");
    }
  }

  /**
   * Set up pagination event listeners.
   */
  static paginationHandler(data) {
    try {
      Utility.el("prev").addEventListener("click", () => {
        if (Utility.PAGE > 1) {
          Utility.PAGE--;
          Transaction.transactionTable(data);
        }
      });

      Utility.el("next").addEventListener("click", () => {
        if (Utility.PAGE < Utility.pageCount(data)) {
          Utility.PAGE++;
          Transaction.transactionTable(data);
        }
      });
    } catch (error) {
      console.error("Pagination handler error:", error);
    }
  }

  /**
   * Attach filter & search input listeners.
   */
  static filterAndSearch(data) {
    try {
      ["q", "statusFilter", "methodFilter", "fromDate", "toDate"].forEach(
        (id) =>
          Utility.el(id)?.addEventListener("input", () => {
            Utility.PAGE = 1;
            Transaction.transactionTable(data);
          })
      );
    } catch (error) {
      console.error("Error binding filters:", error);
    }
  }

  /**
   * Calculate and display total revenue.
   * @param {HTMLElement} domElem - Target element to display revenue.
   */
  static revenueNGN(domElem) {
    try {
      const revenue =
        Application.DATA.txns?.reduce((sum, t) => {
          const amt = Number(t.amount || 0);
          return sum + (isNaN(amt) ? 0 : amt);
        }, 0) || 0;

      domElem.textContent = Utility.fmtNGN(revenue);
    } catch (error) {
      console.error("Error calculating revenue:", error);
      domElem.textContent = "₦0";
    }
  }

  /**
   * Generate revenue chart for last 30 days.
   */
  static revenueChart(transactions) {
    try {
      const canvas = Utility.el("revChart");
      if (!canvas) return;

      const ctx = canvas.getContext("2d");

      // Destroy old chart
      if (Transaction.revenueChartInstance) {
        Transaction.revenueChartInstance.destroy();
        Transaction.revenueChartInstance = null;
      }
      const existingChart = Chart.getChart("revChart");
      if (existingChart) existingChart.destroy();

      // Labels for last 30 days
      const today = new Date();
      const labels = Array.from({ length: 30 }, (_, i) => {
        const d = new Date(today);
        d.setDate(today.getDate() - (29 - i));
        return `${d.getMonth() + 1}/${d.getDate()}`;
      });

      // Revenue map
      const revenueMap = {};
      transactions.forEach((txn) => {
        if (txn.status === "success") {
          const d = new Date(txn.date);
          const key = `${d.getMonth() + 1}/${d.getDate()}`;
          const amt = parseFloat(txn.amount) || 0;
          revenueMap[key] = (revenueMap[key] || 0) + amt;
        }
      });

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
                label: (ctx) => `₦${ctx.raw.toLocaleString()}`,
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
    } catch (error) {
      console.error("Error rendering revenue chart:", error);
    }
  }

  /**
   * Update a transaction (refund, block, etc).
   * @param {string} id - Transaction ID.
   * @param {string} decision - Action to take.
   * @param {boolean} fromModal - Whether called from modal.
   */
  static async doUpdate(id, decision, fromModal = false) {
    try {
      const tx = Application.DATA.txns.find((t) => t.txnsid === id);
      if (!tx) {
        Utility.toast("Transaction not found", "error");
        return;
      }

      if (fromModal) $("#displayDetails").modal("hide");

      if (decision === "refund" && tx.status !== "success") {
        Utility.toast("Only successful transactions can be refunded", "error");
        return;
      }

      const result = await Utility.confirm("Update changes");
      if (!result.isConfirmed) {
        if (fromModal) $("#displayDetails").modal("show");
        return;
      }

      const response = await DataTransfer(
        `${CONFIG.API}/admin/transaction/${id}`,
        { status: decision },
        "PATCH"
      );

      Utility.toast(
        response.message,
        response.status === 200 ? "success" : "error"
      );

      if (response.status === 200) {
        await clearAppData();
        await Application.initializeData();
        Transaction.statistics();
        Transaction.transactionTable(Application.DATA.txns);
      }
    } catch (error) {
      console.error("Error updating transaction:", error);
      Utility.toast("Failed to update transaction", "error");
    }
  }

  /**
   * Delete a transaction.
   * @param {string} id - Transaction ID.
   * @param {boolean} fromModal - Whether called from modal.
   */
  static async deleteTransaction(id, fromModal = false) {
    try {
      const tx = Application.DATA.txns.find((t) => t.txnsid === id);
      if (!tx) {
        Utility.toast("Transaction not found", "error");
        return;
      }

      if (fromModal) $("#displayDetails").modal("hide");

      const result = await Utility.confirm(
        "Delete transaction?",
        "Action is not reversible"
      );
      if (!result.isConfirmed) {
        if (fromModal) $("#displayDetails").modal("show");
        return;
      }

      const response = await DataTransfer(
        `${CONFIG.API}/admin/transaction/${id}`,
        {},
        "DELETE"
      );

      Utility.toast(
        response.message,
        response.status === 200 ? "success" : "error"
      );

      if (response.status === 200) {
        await clearAppData();
        await Application.initializeData();
        Transaction.statistics();
        Transaction.transactionTable(Application.DATA.txns);
      }
    } catch (error) {
      console.error("Error deleting transaction:", error);
      Utility.toast("Failed to delete transaction", "error");
    }
  }

  /**
   * Open transaction details modal.
   * @param {string} id - Transaction ID.
   */
  static async openDetail(id) {
    try {
      const tx = Application.DATA.txns.find((t) => t.txnsid === id);
      if (!tx) {
        Utility.toast("Transaction not found", "error");
        return;
      }

      const domBody = Utility.el("detailModalBody");
      const title = Utility.el("detailModalLabel");
      const token = await decryptJsToken();

      title.textContent = `Transaction details: (${id})`;
      domBody.innerHTML = `
        <div id="detailModalTx">
          <div class="modal-card container">
            <div style="margin-top:12px" class="row">
              <div class="col-sm-6">
                <div style="background:#f3f6fb;padding:12px;border-radius:8px">
                  <strong id="txId">${id}</strong>
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
                  token?.role === "admin"
                    ? `
                    <div style="margin-top:12px"><strong>Action</strong>
                      <div style="display:flex;gap:8px;margin-top:8px">
                        <button class="btn btn-primary btn-sm btn-pill" data-target="${id}" id="refundBtn">Refund</button>
                        <button class="btn btn-sm btn-outline-error" data-target="${id}" id="blockBtn">Delete</button>
                      </div>
                    </div>
                  `
                    : ""
                }
              </div>
              <div class="col-sm-6">
                <div><strong>User/Dealer</strong>
                  <div id="txUser" class="muted small">${tx.fullname}</div>
                </div>
                <div style="margin-top:12px"><strong>Notes / Logs</strong>
                  <div id="txNotes" class="muted small">${
                    tx.notes ?? "---"
                  }</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;

      $("#displayDetails").modal("show");

      document.addEventListener("click", (e) => {
        if (e.target?.id === "blockBtn") {
          Transaction.deleteTransaction(e.target.dataset.target);
        }
      });
    } catch (error) {
      console.error("Error opening transaction details:", error);
      Utility.toast("Failed to open transaction details", "error");
    }
  }
}
