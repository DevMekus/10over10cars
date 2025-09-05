import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Transaction from "../Classes/Transaction.js";

/**
 * TransactionPage.js
 * Handles rendering and interaction of the transaction page including:
 * - Displaying transaction statistics
 * - Rendering transaction table with filters and pagination
 * - Exporting transaction data to CSV
 * - Displaying revenue charts and total revenue
 * - Delegating transaction actions and modal events
 *
 * Dependencies:
 * - Utility.js
 * - Application.js
 * - Transaction.js
 */

class TransactionPage {
  constructor() {
    this.revenueChartInstance = null;
    this.initialize();
  }

  /**
   * Initialize the transaction page
   * - Load application data
   * - Execute any class methods that need initialization
   */
  async initialize() {
    try {
      await Application.initializeData();
      Utility.runClassMethods(this, ["initialize"]);
    } catch (error) {
      console.error("Error initializing TransactionPage:", error);
      Utility.toast("Failed to initialize transaction page.", "error");
    }
  }

  /**
   * Change the search input placeholder text
   */
  changeSearchPlaceholder() {
    try {
      const searchInput = document.getElementById("q");
      if (!searchInput) return;

      searchInput.placeholder = "Search transaction id, user, dealer...";
    } catch (error) {
      console.error("Error changing search placeholder:", error);
    }
  }

  /**
   * Render transaction statistics
   */
  renderTransactionStats() {
    try {
      const domElem = document.querySelector(".transactionPage");
      if (!domElem) return;

      Transaction.statistics();
    } catch (error) {
      console.error("Error rendering transaction statistics:", error);
      Utility.toast("Failed to load transaction statistics.", "error");
    }
  }

  /**
   * Render transaction table with filters, search, and pagination
   */
  renderTransactionTable() {
    try {
      const data = Application.DATA.txns;
      if (!data) return;

      // Initial render
      Transaction.transactionTable(data);

      // Pagination handlers
      Transaction.paginationHandler(data);

      // Filters and search handlers
      Transaction.filterAndSearch(data);
    } catch (error) {
      console.error("Error rendering transaction table:", error);
      Utility.toast("Failed to render transaction table.", "error");
    }
  }

  /**
   * Export transaction data to CSV
   */
  exportAsCSV() {
    try {
      const exportBtn = document.getElementById("exportCsv");
      if (!exportBtn) return;

      exportBtn.addEventListener("click", () => {
        try {
          Utility.exportToCSV(Transaction.currentData, "transaction.csv");
        } catch (innerError) {
          console.error("Error exporting transaction CSV:", innerError);
          Utility.toast("Failed to export transactions.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing CSV export:", error);
    }
  }

  /**
   * Display revenue chart
   */
  displayRevenueChart() {
    try {
      Transaction.revenueChart(Application.DATA.txns);
    } catch (error) {
      console.error("Error displaying revenue chart:", error);
      Utility.toast("Failed to display revenue chart.", "error");
    }
  }

  /**
   * Display total revenue
   */
  displayTotalRevenue() {
    try {
      const domElem = Utility.el("totalRevenue");
      if (!domElem) return;

      Transaction.revenueNGN(domElem);
    } catch (error) {
      console.error("Error displaying total revenue:", error);
      Utility.toast("Failed to display total revenue.", "error");
    }
  }

  /**
   * Delegate table actions (view, block, delete)
   */
  transactionEventDelegates() {
    try {
      const table = document.querySelector("#txTable");
      if (!table) return;

      table.addEventListener("click", (e) => {
        try {
          const viewBtn = e.target.closest("[data-view]");
          if (viewBtn) {
            Transaction.openDetail(viewBtn.dataset.view);
            return;
          }

          const blockBtn = e.target.closest("[data-block]");
          if (blockBtn) {
            Transaction.deleteTransaction(blockBtn.dataset.block);
            return;
          }
        } catch (innerError) {
          console.error("Error handling table action:", innerError);
        }
      });
    } catch (error) {
      console.error("Error initializing transaction event delegates:", error);
    }
  }

  /**
   * Delegate modal actions (refund, block)
   */
  fromModalEventDelegates() {
    try {
      const refundBtn = document.getElementById("refundBtn");
      const blockBtn = document.getElementById("blockBtn");

      refundBtn?.addEventListener("click", () => {
        try {
          Transaction.doRefund(refundBtn.dataset.target);
        } catch (innerError) {
          console.error("Error performing refund:", innerError);
          Utility.toast("Failed to process refund.", "error");
        }
      });

      blockBtn?.addEventListener("click", () => {
        try {
          Transaction.doBlock(blockBtn.dataset.target);
        } catch (innerError) {
          console.error("Error blocking transaction:", innerError);
          Utility.toast("Failed to block transaction.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing modal event delegates:", error);
    }
  }
}

new TransactionPage();
