import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Report from "../Classes/Report.js";

class ReportPage {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderTopDealers() {
    const ul = Utility.el("topDealers");
    if (!ul) return;
    ul.innerHTML = "";
    const top = [...Application.DATA.dealers]
      .sort((a, b) => b.revenue - a.revenue)
      .slice(0, 5);
    top.forEach((d, i) => {
      const li = document.createElement("li");
      li.innerHTML = `
        <div style='display:flex;align-items:center;gap:10px'>
          <img class='avatar' src='${d.avatar}' alt='${d.company}'/>
          <div style='flex:1'>
            <div style='display:flex;justify-content:space-between;align-items:center'>
              <strong>${i + 1}. ${d.company}</strong>
              <span class='small muted'>${Utility.fmtNGN(d.revenue)}</span>
            </div>
            <div class='small muted'>${d.contact}</div>
          </div>
        </div>`;
      ul.appendChild(li);
    });
  }

  applyFiltersOnReport() {
    const range = Report.getRange();
    const type = Utility.el("reportType").value;
    Report.calcKPIs(range);
    Report.buildTrend(range, type);
    Report.setTable(type, range);

    Utility.el("applyFilters").addEventListener(
      "click",
      this.applyFiltersOnReport
    );

    Utility.el("resetFilters").addEventListener("click", () => {
      Utility.el("fromDate").value = "";
      Utility.el("toDate").value = "";
      Utility.el("reportType").value = "overview";
      this.applyFiltersOnReport;
    });
  }

  searchWithinTable() {
    Utility.el("q")?.addEventListener("input", () => {
      const q = Utility.el("q").value.toLowerCase();
      const filtered = Report.CURRENT_ROWS.filter((r) =>
        r.some((c) => String(c).toLowerCase().includes(q))
      );
      Report.buildTable(
        Array.from(Utility.el("tableHead").children).map(
          (th) => th.textContent
        ),
        filtered
      );
    });
  }

  exportCsv() {
    Utility.el("exportCsv").addEventListener("click", () => {
      Utility.exportToCSV(Report.CURRENT_ROWS, "report.csv");
    });
  }
}

new ReportPage();
