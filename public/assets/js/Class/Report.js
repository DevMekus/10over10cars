import AppInit from "./Application.js";
import Utility from "./Utility.js";

export default class ReportStatic {
  static trendChart;
  static CURRENT_ROWS = [];
  static dateStep(delta) {
    const d = new Date();
    d.setDate(d.getDate() + delta);
    return d.toISOString().slice(0, 10);
  }
  static el = (id) => document.getElementById(id);
  static getRange() {
    const from =
      ReportStatic.el("fromDate").value || ReportStatic.dateStep(-29);
    const to = ReportStatic.el("toDate").value || ReportStatic.dateStep(0);
    return {
      from,
      to,
    };
  }
  static filterByDate(arr, range) {
    return arr.filter((x) => x.date >= range.from && x.date <= range.to);
  }

  static calcKPIs(range) {
    const verifs = ReportStatic.filterByDate(AppInit.DATA.verifications, range);
    const txns = ReportStatic.filterByDate(AppInit.DATA.txns, range);
    const vehicles = ReportStatic.filterByDate(AppInit.DATA.vehicles, range);
    const activeDealers = AppInit.DATA.dealers.filter((d) => d.active).length;
    const revenue = txns.reduce(
      (s, t) => s + (t.status === "success" ? t.amount : 0),
      0
    );
    ReportStatic.el("kVerifs").textContent = AppInit.fmt(verifs.length);
    ReportStatic.el("kRevenue").textContent = AppInit.fmtNGN(revenue);
    ReportStatic.el("kDealers").textContent = AppInit.fmt(activeDealers);
    ReportStatic.el("kVehicles").textContent = AppInit.fmt(vehicles.length);
  }

  static rangeLabels(range) {
    const days = [];
    const d1 = new Date(range.from),
      d2 = new Date(range.to);
    for (let d = new Date(d1); d <= d2; d.setDate(d.getDate() + 1)) {
      days.push({
        label: `${d.getMonth() + 1}/${d.getDate()}`,
        date: d.toISOString().slice(0, 10),
      });
    }
    return days;
  }

  static rangeLabelText(range) {
    return `${range.from} → ${range.to}`;
  }

  static exportCSV() {
    const headers = [...ReportStatic.el("tableHead").children].map(
      (th) => th.textContent
    );
    const rows = [...ReportStatic.el("tableBody").children].map((tr) =>
      [...tr.children].map((td) => td.textContent)
    );
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
    a.download = "report.csv";
    a.click();
    URL.revokeObjectURL(url);
    AppInit.toast("CSV downloaded (demo)", "success");
  }

  static buildTrend(range, type = "overview") {
    const labels = ReportStatic.rangeLabels(range);
    const dataSeries = (data, map) =>
      labels.map((lbl) => {
        const day = lbl.date;
        const rows = data.filter((r) => r.date === day);
        return map(rows);
      });

    let datasets = [];
    if (type === "overview" || type === "verifications") {
      const verifs = ReportStatic.filterByDate(
        AppInit.DATA.verifications,
        range
      );
      const d = dataSeries(verifs, (rows) => rows.length);
      datasets.push({
        label: "Verifications",
        data: d,
        tension: 0.3,
        borderColor: "rgba(14,165,233,.9)",
        backgroundColor: "rgba(14,165,233,.08)",
        fill: true,
        pointRadius: 0,
      });
    }
    if (type === "overview" || type === "transactions") {
      const txns = ReportStatic.filterByDate(AppInit.DATA.txns, range);
      const d = dataSeries(txns, (rows) =>
        rows.reduce((s, t) => s + (t.status === "success" ? t.amount : 0), 0)
      );
      datasets.push({
        label: "Revenue",
        data: d,
        yAxisID: "y1",
        tension: 0.3,
        borderColor: "rgba(34,197,94,.9)",
        backgroundColor: "rgba(34,197,94,.08)",
        fill: true,
        pointRadius: 0,
      });
    }
    if (type === "overview" || type === "vehicles") {
      const vehicles = ReportStatic.filterByDate(AppInit.DATA.vehicles, range);
      const d = dataSeries(vehicles, (rows) => rows.length);
      datasets.push({
        label: "Vehicles Listed",
        data: d,
        tension: 0.3,
        borderColor: "rgba(99,102,241,.9)",
        backgroundColor: "rgba(99,102,241,.08)",
        fill: true,
        pointRadius: 0,
      });
    }

    const ctx = document.getElementById("trendChart").getContext("2d");
    ReportStatic.trendChart?.destroy();
    ReportStatic.trendChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels.map((l) => l.label),
        datasets,
      },
      options: {
        responsive: true,
        interaction: {
          mode: "index",
          intersect: false,
        },
        stacked: false,
        plugins: {
          legend: {
            display: true,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
          },
          y1: {
            beginAtZero: true,
            position: "right",
            grid: {
              drawOnChartArea: false,
            },
          },
        },
      },
    });
    ReportStatic.el("trendLabel").textContent =
      ReportStatic.rangeLabelText(range);
  }

  static setTable(type, range) {
    let head = [],
      rows = [];
    let title = "";
    if (type === "transactions") {
      title = "Recent Transactions";
      head = ["ID", "Amount", "Status", "Method", "Date"];
      rows = ReportStatic.filterByDate(AppInit.DATA.txns, range).map((t) => [
        t.id,
        AppInit.fmtNGN(t.amount),
        t.status,
        t.method,
        t.date,
      ]);
    } else if (type === "verifications") {
      title = "Recent Verifications";
      head = ["ID", "VIN", "Result", "Plan", "Date"];
      rows = ReportStatic.filterByDate(AppInit.DATA.verifications, range).map(
        (v) => [v.id, v.vin, v.result, v.plan, v.date]
      );
    } else if (type === "dealers") {
      title = "Dealers";
      head = ["ID", "Name", "Email", "Active", "Revenue"];
      rows = [...AppInit.DATA.dealers].map((d) => [
        d.id,
        d.company,
        d.contact,
        d.active ? "Yes" : "No",
        AppInit.fmtNGN(d.revenue),
      ]);
    } else if (type === "vehicles") {
      title = "Vehicles";
      head = [
        "ID",
        "Make",
        "Model",
        "Year",
        "Mileage",
        "Price",
        "Status",
        "Date",
      ];
      rows = ReportStatic.filterByDate(AppInit.DATA.vehicles, range).map(
        (v) => [
          v.id,
          v.make,
          v.model,
          v.year,
          AppInit.fmt(v.mileage),
          AppInit.fmtNGN(v.price),
          v.status,
          v.date,
        ]
      );
    } else {
      // overview
      title = "Overview Activity";
      head = ["Date", "Verifications", "Revenue (NGN)", "Vehicles Listed"];
      const labels = ReportStatic.rangeLabels(range);
      rows = labels.map((l) => {
        const ver = AppInit.DATA.verifications.filter(
          (x) => new Date(x.date) === new Date(l.date)
        ).length;
        const rev = AppInit.DATA.txns
          .filter(
            (x) =>
              new Date(x.date) === new Date(l.date) && x.status === "success"
          )
          .reduce((s, t) => s + t.amount, 0);
        const veh = AppInit.DATA.vehicles.filter(
          (x) => new Date(x.date) === new Date(l.date)
        ).length;
        return [l.date, ver, AppInit.fmtNGN(rev), veh];
      });
    }
    ReportStatic.el("tableTitle").textContent = title;
    ReportStatic.buildTable(head, rows);
  }

  static buildTable(headers, rows) {
    const thead = ReportStatic.el("tableHead");
    const tbody = ReportStatic.el("tableBody");
    thead.innerHTML = "";
    tbody.innerHTML = "";
    headers.forEach((h) => {
      const th = document.createElement("th");
      th.textContent = Utility.toTitleCase(h);
      thead.appendChild(th);
    });
    ReportStatic.CURRENT_ROWS = rows;
    AppInit.PAGE = 1;
    ReportStatic.renderTablePage();
  }

  static renderTablePage() {
    const tbody = ReportStatic.el("tableBody");
    tbody.innerHTML = "";
    const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
    const slice = ReportStatic.CURRENT_ROWS.slice(
      start,
      start + AppInit.PER_PAGE
    );
    slice.forEach((r) => {
      const tr = document.createElement("tr");
      r.forEach((c, ci) => {
        const td = document.createElement("td");
        td.innerHTML =
          ci === 0 && String(c).startsWith("TXN-")
            ? `<button class='btn' data-detail='${c}'>${c}</button>`
            : String(c).startsWith("NGN")
            ? String(c)
            : Utility.toTitleCase(String(c));

        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
    ReportStatic.el(
      "pgInfo"
    ).textContent = `Page ${AppInit.PAGE} • Showing ${slice.length} of ${ReportStatic.CURRENT_ROWS.length}`;

    ReportStatic.el("prevPg").addEventListener("click", () => {
      if (AppInit.PAGE > 1) {
        AppInit.PAGE--;
        ReportStatic.renderTablePage();
      }
    });
    ReportStatic.el("nextPg").addEventListener("click", () => {
      if (AppInit.PAGE * AppInit.PER_PAGE < ReportStatic.CURRENT_ROWS.length) {
        AppInit.PAGE++;
        ReportStatic.renderTablePage();
      }
    });
  }
}

class ReportManager {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderTopDealers() {
    const ul = ReportStatic.el("topDealers");
    ul.innerHTML = "";
    const top = [...AppInit.DATA.dealers]
      .sort((a, b) => b.revenue - a.revenue)
      .slice(0, 5);
    top.forEach((d, i) => {
      const li = document.createElement("li");
      li.innerHTML = `
        <div style='display:flex;align-items:center;gap:10px'>
          <img class='avatar' src='https://images.unsplash.com/photo-1502685104226-ee32379fefbe?q=80&w=200&auto=format&fit=crop' alt='Dealer'/>
          <div style='flex:1'>
            <div style='display:flex;justify-content:space-between;align-items:center'>
              <strong>${i + 1}. ${d.company}</strong>
              <span class='small muted'>${AppInit.fmtNGN(d.revenue)}</span>
            </div>
            <div class='small muted'>${d.contact}</div>
          </div>
        </div>`;
      ul.appendChild(li);
    });
  }

  applyFiltersOnReport() {
    const range = ReportStatic.getRange();
    const type = ReportStatic.el("reportType").value;
    ReportStatic.calcKPIs(range);
    ReportStatic.buildTrend(range, type);
    ReportStatic.setTable(type, range);

    ReportStatic.el("applyFilters").addEventListener(
      "click",
      this.applyFiltersOnReport
    );

    ReportStatic.el("resetFilters").addEventListener("click", () => {
      ReportStatic.el("fromDate").value = "";
      ReportStatic.el("toDate").value = "";
      ReportStatic.el("reportType").value = "overview";
      this.applyFiltersOnReport();
    });
  }

  searchWithinTable() {
    ReportStatic.el("q")?.addEventListener("input", () => {
      const q = ReportStatic.el("q").value.toLowerCase();
      const filtered = ReportStatic.CURRENT_ROWS.filter((r) =>
        r.some((c) => String(c).toLowerCase().includes(q))
      );
      ReportStatic.buildTable(
        Array.from(ReportStatic.el("tableHead").children).map(
          (th) => th.textContent
        ),
        filtered
      );
    });
  }

  exportASCSV() {
    ReportStatic.el("exportCsv").addEventListener(
      "click",
      ReportStatic.exportCSV
    );
    ReportStatic.el("exportPdf").addEventListener("click", () => {
      window.print();
      AppInit.toast('Print dialog opened — use "Save as PDF"', "info");
    });
  }
}
new ReportManager();
