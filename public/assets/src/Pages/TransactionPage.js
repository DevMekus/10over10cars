import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Transaction from "../Classes/Transaction.js";

class TransactionPage {
  constructor() {
    this.initialize();
    this.revenueChartInstance = null;
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  changeSearchPlaceholder() {
    document.getElementById("q").placeholder =
      "Search transaction id, user, dealer...";
  }

  renderTransactionStats() {
    const domElem = document.querySelector(".transactionPage");
    if (!domElem) return;

    Transaction.statistics();
  }

  renderTransactionTable() {
    // ---------- Initial render ----------
    const data = Application.DATA.txns;
    Transaction.transactionTable(data);

    // ---------- Pagination handlers ----------
    Transaction.paginationHandler(data);

    // ---------- Filters/search handlers ----------
    Transaction.filterAndSearch(data);
  }

  exportAsCSV() {
    document.getElementById("exportCsv")?.addEventListener("click", () => {
      Utility.exportToCSV(Transaction.currentData, "transaction.csv");
    });
  }

  diplayRevenueChart() {
    Transaction.revenueChart(Application.DATA.txns);
  }

  displayTotalRevenue() {
    const domElem = Utility.el("totalRevenue");
    if (!domElem) return;

    Transaction.revenueNGN(domElem);
  }

  transactionEventDelegates() {
    // ---------- table actions (delegate) ----------
    document.querySelector("#txTable")?.addEventListener("click", (e) => {
      const view = e.target.closest("[data-view]");
      if (view) {
        Transaction.openDetail(view.dataset.view);
        return;
      }

      const block = e.target.closest("[data-block]");
      if (block) {
        Transaction.deleteTransaction(block.dataset.block);
        return;
      }
    });

    //--clear and close Modal
  }

  fromModalEventDelegates() {
    // Refund / Block from modal
    document
      .getElementById("refundBtn")
      ?.addEventListener("click", () =>
        Transaction.doRefund(
          document.getElementById("refundBtn").dataset.target
        )
      );
    document
      .getElementById("blockBtn")
      ?.addEventListener("click", () =>
        Transaction.doBlock(document.getElementById("blockBtn").dataset.target)
      );
  }
}

new TransactionPage();
