/**
 * ReportPage.js
 * Handles rendering and interaction of the report page including:
 * - Displaying top dealers
 * - Applying filters on reports
 * - Searching within tables
 * - Exporting report data to CSV
 *
 * Dependencies:
 * - Utility.js
 * - Application.js
 * - Report.js
 */

import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Report from "../Classes/Report.js";

class ReportPage {
  constructor() {
    this.initialize();
  }

  /**
   * Initialize the report page
   * - Load application data
   * - Execute any class methods that need initialization
   */
  async initialize() {
    try {
      await Application.initializeData();
      Utility.runClassMethods(this, ["initialize"]);
    } catch (error) {
      console.error("Error initializing ReportPage:", error);
      Utility.toast("Failed to initialize report page.", "error");
    }
  }

  /**
   * Render the top 5 dealers by revenue
   */
  renderTopDealers() {
    try {
      const ul = Utility.el("topDealers");
      if (!ul) return;

      ul.innerHTML = "";

      const topDealers = [...Application.DATA.dealers]
        .sort((a, b) => b.revenue - a.revenue)
        .slice(0, 5);

      topDealers.forEach((dealer, index) => {
        const li = document.createElement("li");
        li.innerHTML = `
          <div style='display:flex;align-items:center;gap:10px'>
            <img class='avatar' src='${dealer.avatar}' alt='${dealer.company}'/>
            <div style='flex:1'>
              <div style='display:flex;justify-content:space-between;align-items:center'>
                <strong>${index + 1}. ${dealer.company}</strong>
                <span class='small muted'>${Utility.fmtNGN(
                  dealer.revenue
                )}</span>
              </div>
              <div class='small muted'>${dealer.contact}</div>
            </div>
          </div>`;
        ul.appendChild(li);
      });
    } catch (error) {
      console.error("Error rendering top dealers:", error);
      Utility.toast("Failed to load top dealers.", "error");
    }
  }

  /**
   * Apply filters on the report and update the KPIs, trend, and table
   */
  applyFiltersOnReport() {
    try {
      const applyBtn = Utility.el("applyFilters");
      const resetBtn = Utility.el("resetFilters");

      if (!applyBtn || !resetBtn) return;

      const range = Report.getRange();
      const type = Utility.el("reportType")?.value || "overview";

      Report.calcKPIs(range);
      Report.buildTrend(range, type);
      Report.setTable(type, range);

      // Event listeners
      applyBtn.addEventListener("click", () => this.applyFiltersOnReport());

      resetBtn.addEventListener("click", () => {
        try {
          Utility.el("fromDate").value = "";
          Utility.el("toDate").value = "";
          Utility.el("reportType").value = "overview";
          this.applyFiltersOnReport();
        } catch (innerError) {
          console.error("Error resetting filters:", innerError);
        }
      });
    } catch (error) {
      console.error("Error applying filters on report:", error);
      Utility.toast("Failed to apply report filters.", "error");
    }
  }

  /**
   * Search within the current report table
   */
  searchWithinTable() {
    try {
      const searchInput = Utility.el("q");
      if (!searchInput) return;

      searchInput.addEventListener("input", () => {
        try {
          const query = searchInput.value.toLowerCase();
          const filtered = Report.CURRENT_ROWS.filter((row) =>
            row.some((cell) => String(cell).toLowerCase().includes(query))
          );

          const headers = Array.from(Utility.el("tableHead").children).map(
            (th) => th.textContent
          );

          Report.buildTable(headers, filtered);
        } catch (innerError) {
          console.error("Error searching table:", innerError);
        }
      });
    } catch (error) {
      console.error("Error initializing table search:", error);
    }
  }

  /**
   * Export the current report data to CSV
   */
  exportCsv() {
    try {
      const exportBtn = Utility.el("exportCsv");
      if (!exportBtn) return;

      exportBtn.addEventListener("click", () => {
        try {
          Utility.exportToCSV(Report.CURRENT_ROWS, "report.csv");
        } catch (innerError) {
          console.error("Error exporting CSV:", innerError);
          Utility.toast("Failed to export report.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing CSV export:", error);
    }
  }
}

new ReportPage();
