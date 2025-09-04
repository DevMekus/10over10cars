import Application from "./Application.js";
import Utility from "./Utility.js";

export default class Report {
  static getRange() {
    const from = Utility.el("fromDate").value || Utility.dateStep(-29);
    const to = Utility.el("toDate").value || Utility.dateStep(0);
    return {
      from,
      to,
    };
  }

  static filterByDate(arr, range) {
    return arr.filter((x) => x.date >= range.from && x.date <= range.to);
  }

  static calcKPIs(range) {
    const verifs = Report.filterByDate(Application.DATA.verifications, range);
    const txns = Report.filterByDate(Application.DATA.txns, range);
    const vehicles = Report.filterByDate(Application.DATA.vehicles, range);

    const activeDealers = Application.DATA.dealers.filter(
      (d) => d.active
    ).length;

    const revenue = txns.reduce(
      (s, t) => s + (t.status === "success" ? t.amount : 0),
      0
    );

    Utility.el("kVerifs").textContent = Utility.fmt(verifs.length);
    Utility.el("kRevenue").textContent = Utility.fmtNGN(revenue);
    Utility.el("kDealers").textContent = Utility.fmt(activeDealers);
    Utility.el("kVehicles").textContent = Utility.fmt(vehicles.length);
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

  static buildTrend(range, type = "overview") {
    const labels = Report.rangeLabels(range);
    const dataSeries = (data, map) =>
      labels.map((lbl) => {
        const day = lbl.date;
        const rows = data.filter((r) => r.date === day);
        return map(rows);
      });

    let datasets = [];
    if (type === "overview" || type === "verifications") {
      const verifs = Report.filterByDate(Application.DATA.verifications, range);
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
      const txns = Report.filterByDate(Application.DATA.txns, range);
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
      const vehicles = Report.filterByDate(Application.DATA.vehicles, range);
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

    const ctx = document.getElementById("trendChart")?.getContext("2d");
    Report.trendChart?.destroy();
    Report.trendChart = new Chart(ctx, {
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
    Utility.el("trendLabel").textContent = Report.rangeLabelText(range);
  }

  static setTable(type, range) {
    let head = [],
      rows = [];
    let title = "";
    if (type === "transactions") {
      title = "Recent Transactions";
      head = ["ID", "Amount", "Status", "Method", "Date"];
      rows = Report.filterByDate(Application.DATA.txns, range).map((t) => [
        t.id,
        Utility.fmtNGN(t.amount),
        t.status,
        t.method,
        t.date,
      ]);
    } else if (type === "verifications") {
      title = "Recent Verifications";
      head = ["ID", "VIN", "Result", "Plan", "Date"];
      rows = Report.filterByDate(Application.DATA.verifications, range).map(
        (v) => [v.id, v.vin, v.result, v.plan, v.date]
      );
    } else if (type === "dealers") {
      title = "Dealers";
      head = ["ID", "Name", "Email", "Active", "Revenue"];
      rows = [...Application.DATA.dealers].map((d) => [
        d.id,
        d.company,
        d.contact,
        d.active ? "Yes" : "No",
        Utility.fmtNGN(d.revenue),
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
      rows = Report.filterByDate(Application.DATA.vehicles, range).map((v) => [
        v.id,
        v.make,
        v.model,
        v.year,
        Utility.fmt(v.mileage),
        Utility.fmtNGN(v.price),
        v.status,
        v.date,
      ]);
    } else {
      // overview
      title = "Overview Activity";
      head = ["Date", "Verifications", "Revenue (NGN)", "Vehicles Listed"];
      const labels = Report.rangeLabels(range);
      rows = labels.map((l) => {
        const ver = Application.DATA.verifications.filter(
          (x) => new Date(x.date) === new Date(l.date)
        ).length;
        const rev = Application.DATA.txns
          .filter(
            (x) =>
              new Date(x.date) === new Date(l.date) && x.status === "success"
          )
          .reduce((s, t) => s + t.amount, 0);
        const veh = Application.DATA.vehicles.filter(
          (x) => new Date(x.date) === new Date(l.date)
        ).length;
        return [l.date, ver, Utility.fmtNGN(rev), veh];
      });
    }
    Utility.el("tableTitle").textContent = title;
    Report.buildTable(head, rows);
  }

  static buildTable(headers, rows) {
    const thead = Utility.el("tableHead");
    const tbody = Utility.el("tableBody");
    thead.innerHTML = "";
    tbody.innerHTML = "";
    headers.forEach((h) => {
      const th = document.createElement("th");
      th.textContent = Utility.toTitleCase(h);
      thead.appendChild(th);
    });
    Report.CURRENT_ROWS = rows;
    Utility.PAGE = 1;
    Report.renderTablePage();
  }

  static renderTablePage() {
    const tbody = Utility.el("tableBody");
    const noData = document.querySelector(".no-data");

    noData.innerHTML = "";
    tbody.innerHTML = "";

    if (Report.CURRENT_ROWS.length == 0) {
      Utility.renderEmptyState(noData)     
      return;
    }

    const start = (Utility.PAGE - 1) * Utility.PER_PAGE;
    const slice = Report.CURRENT_ROWS.slice(start, start + Utility.PER_PAGE);
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
    Utility.el(
      "pgInfo"
    ).textContent = `Page ${Utility.PAGE} • Showing ${slice.length} of ${Report.CURRENT_ROWS.length}`;

    Utility.el("prevPg").addEventListener("click", () => {
      if (Utility.PAGE > 1) {
        Utility.PAGE--;
        Report.renderTablePage();
      }
    });
    Utility.el("nextPg").addEventListener("click", () => {
      if (Utility.PAGE * Utility.PER_PAGE < Report.CURRENT_ROWS.length) {
        Utility.PAGE++;
        Report.renderTablePage();
      }
    });
  }
}
