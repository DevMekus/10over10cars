import Utility from "./Utility.js";
import AppInit from "./Application.js";

export default class TransactInit {
  // ---------- Open detail modal ----------
  static openDetail(id) {
    const tx = AppInit.DATA.txns.find((t) => t.id === id);
    if (!tx) return;
    document.getElementById("txId").textContent = tx.id;
    document.getElementById("txDate").textContent = tx.date;
    document.getElementById("txAmount").textContent = AppInit.fmtNGN(tx.amount);
    document.getElementById("txMethod").textContent = tx.method.toUpperCase();
    document.getElementById("txStatus").textContent = tx.status;
    document.getElementById("txUser").textContent = tx.user;
    document.getElementById("txNotes").textContent = tx.notes || "—";
    document.getElementById("txLogs").textContent =
      "Logs and receipt links (demo)";
    document.getElementById("refundBtn").dataset.target = id;
    document.getElementById("blockBtn").dataset.target = id;
    document.getElementById("detailModalTx").classList.add("open");
    document
      .getElementById("detailModalTx")
      .setAttribute("aria-hidden", "false");
  }

  static doRefund(id) {
    // demo: mark as refunded/failed and notify
    const tx = AppInit.DATA.txns.find((t) => t.id === id);
    if (!tx) return;
    if (tx.status !== "success") {
      AppInit.toast("Only successful transactions can be refunded", "error");
      return;
    }
    tx.status = "pending";
    AppInit.toast("Refund initiated (demo)", "info");
    new Transaction().renderTransactionStats();
    new Transaction().renderTransactionTable();
  }

  static doBlock(id) {
    const tx = AppInit.DATA.txns.find((t) => t.id === id);
    if (!tx) return;
    tx.status = "failed";
    AppInit.toast("Transaction blocked (demo)", "success");
    new Transaction().renderTransactionStats();
    new Transaction().renderTransactionTable();
  }
}

class Transaction {
  constructor() {
    this.initialize();
    this.revenueChartInstance = null;
  }

  async initialize() {
    await AppInit.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }
  changeSearchPlacholder() {
    document.getElementById("q").placeholder =
      "Search transaction id, user, dealer...";
  }

  renderTransactionStats() {
    const domElem = document.querySelector(".transactionPage");
    if (!domElem) return;

    const total = AppInit.DATA.txns.length;
    const success = AppInit.DATA.txns.filter(
      (t) => t.status === "success"
    ).length;
    const pending = AppInit.DATA.txns.filter(
      (t) => t.status === "pending"
    ).length;
    const failed = AppInit.DATA.txns.filter(
      (t) => t.status === "failed"
    ).length;
    const revenue = AppInit.DATA.txns.reduce(
      (s, t) => s + (t.status === "success" ? t.amount : 0),
      0
    );
    document.getElementById("statTotal").textContent = total;
    document.getElementById("statSuccess").textContent = success;
    document.getElementById("statPending").textContent = pending;
    document.getElementById("statFailed").textContent = failed;
    document.getElementById("totalRevenue").textContent =
      AppInit.fmtNGN(revenue);
  }

  renderTransactionTable() {
    function renderTable() {
      const tbody = document.querySelector("#txTable tbody");
      if (!tbody) return;
      tbody.innerHTML = "";
      const q = (document.getElementById("q").value || "").toLowerCase();
      const status = document.getElementById("statusFilter").value;
      const method = document.getElementById("methodFilter").value;
      const from = document.getElementById("fromDate").value;
      const to = document.getElementById("toDate").value;

      let filtered = AppInit.DATA.txns.filter((t) => {
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
      const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
      const slice = filtered.slice(start, start + AppInit.PER_PAGE);
      slice.forEach((tx) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><code>${tx.id}</code></td>
          <td>${tx.user}</td>
          <td>${AppInit.fmtNGN(tx.amount)}</td>
          <td>${tx.method.toUpperCase()}</td>
           <td class="small muted">${tx.desc}</td>
          <td class='small'>${tx.date}</td>
          <td>${
            tx.status === "success"
              ? `<span class='status-pill s-success'>Success</span>`
              : tx.status === "pending"
              ? `<span class='status-pill s-pending'>Pending</span>`
              : `<span class='status-pill s-failed'>Failed</span>`
          }</td>
          <td><div style='display:flex;gap:6px'><button class='btn btn-ghost' data-view='${
            tx.id
          }'>View</button>${
          tx.status === "success"
            ? `<button class='btn btn-ghost' data-refund='${tx.id}'>Refund</button>`
            : ""
        }<button class='btn btn-ghost' data-block='${
          tx.id
        }'>Block</button></div></td>
        `;
        tbody.appendChild(tr);
      });
      document.getElementById("pgInfo").textContent = `Page ${
        AppInit.PAGE
      } of ${AppInit.pageCount(AppInit.DATA.txns)}, showing ${
        slice.length
      } of ${totalFiltered}`;
    }
    // ---------- Initial render ----------
    renderTable();

    // ---------- Pagination handlers ----------
    document.getElementById("prev").addEventListener("click", () => {
      if (AppInit.PAGE > 1) AppInit.PAGE--;
      renderTable();
    });
    document.getElementById("next").addEventListener("click", () => {
      if (AppInit.PAGE < AppInit.pageCount(AppInit.DATA.txns)) AppInit.PAGE++;
      renderTable();
    });

    // ---------- Filters/search handlers ----------
    ["q", "statusFilter", "methodFilter", "fromDate", "toDate"].forEach((id) =>
      document.getElementById(id).addEventListener("input", () => {
        AppInit.PAGE = 1;
        renderTable();
      })
    );
  }

  transactionDelegates() {
    // ---------- table actions (delegate) ----------
    document.querySelector("#txTable")?.addEventListener("click", (e) => {
      const view = e.target.closest("[data-view]");
      if (view) {
        TransactInit.openDetail(view.dataset.view);
        return;
      }
      const refund = e.target.closest("[data-refund]");
      if (refund) {
        TransactInit.doRefund(refund.dataset.refund);
        return;
      }
      const block = e.target.closest("[data-block]");
      if (block) {
        TransactInit.doBlock(block.dataset.block);
        return;
      }
    });

    document
      .querySelectorAll("[data-close]")
      .forEach((b) =>
        b.addEventListener("click", () =>
          document.getElementById(b.dataset.close).classList.remove("open")
        )
      );
  }

  fromModalDelegates() {
    // Refund / Block from modal
    document
      .getElementById("refundBtn")
      ?.addEventListener("click", () =>
        TransactInit.doRefund(
          document.getElementById("refundBtn").dataset.target
        )
      );
    document
      .getElementById("blockBtn")
      ?.addEventListener("click", () =>
        TransactInit.doBlock(document.getElementById("blockBtn").dataset.target)
      );

    document
      .querySelectorAll("[data-close]")
      .forEach((b) =>
        b.addEventListener("click", () =>
          document.getElementById("detailModalTx").classList.remove("open")
        )
      );
  }

  exportAsCSV() {
    // ---------- Export CSV / PDF (demo) ----------
    document.getElementById("exportCsv")?.addEventListener("click", () => {
      const headers = ["id", "user", "amount", "method", "date", "status"];
      const rows = AppInit.DATA.txns.map((t) => [
        t.id,
        t.user,
        t.amount,
        t.method,
        t.date,
        t.status,
      ]);
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
      a.download = "transactions.csv";
      a.click();
      URL.revokeObjectURL(url);
      AppInit.toast("CSV downloaded (demo)", "success");
    });

    document.getElementById("exportPdf").addEventListener("click", () => {
      AppInit.toast(
        "PDF export not implemented in-browser — integrate server-side generation for production",
        "info"
      );
    });
  }

  revenueChart() {
    const canvas = document.getElementById("revChart");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    // Destroy existing chart safely
    if (this.revenueChartInstance) {
      this.revenueChartInstance.destroy();
      this.revenueChartInstance = null;
    }

    // (Extra safety if Chart.js v3+)
    const existingChart = Chart.getChart("revChart");
    if (existingChart) {
      existingChart.destroy();
    }

    // Generate last 30 days labels
    const labels = Array.from({ length: 30 }, (_, i) => {
      const d = new Date();
      d.setDate(d.getDate() - (29 - i));
      return `${d.getMonth() + 1}/${d.getDate()}`;
    });

    const dataset = labels.map(() => Math.floor(2000 + Math.random() * 12000));

    this.revenueChartInstance = new Chart(ctx, {
      type: "line",
      data: {
        labels,
        datasets: [
          {
            label: "Revenue",
            data: dataset,
            tension: 0.3,
            borderColor: "rgba(14,165,233,0.9)",
            backgroundColor: "rgba(14,165,233,0.08)",
            fill: true,
            pointRadius: 0,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
        },
      },
    });
  }
}

new Transaction();
