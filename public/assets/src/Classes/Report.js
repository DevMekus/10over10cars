import Application from "./Application.js";
import Utility from "./Utility.js";
/**
 * Report.js
 *
 * Handles reporting logic: KPI calculation, trends, and tabular data.
 * Integrates with Application.DATA and Utility for UI rendering and formatting.
 *
 * Dependencies:
 *  - Application: Provides application-wide data sources.
 *  - Utility: Provides UI helpers and formatting utilities.
 */

export default class Report {
  /**
   * Get current date range for reports.
   * Defaults to last 30 days if user input is missing.
   *
   * @returns {{from: string, to: string}} Range object with "from" and "to" dates.
   */
  static getRange() {
    try {
      const from = Utility.el("fromDate")?.value || Utility.dateStep(-29);
      const to = Utility.el("toDate")?.value || Utility.dateStep(0);
      return { from, to };
    } catch (err) {
      console.error("Error getting range:", err);
      return { from: Utility.dateStep(-29), to: Utility.dateStep(0) };
    }
  }

  /**
   * Filters an array by a given date range.
   *
   * @param {Array} arr - Array of objects with "date" field.
   * @param {{from: string, to: string}} range - Date range object.
   * @returns {Array} Filtered array.
   */
  static filterByDate(arr, range) {
    if (!Array.isArray(arr)) return [];
    return arr.filter((x) => x.date >= range.from && x.date <= range.to);
  }

  /**
   * Calculate and render KPIs (Key Performance Indicators).
   *
   * @param {{from: string, to: string}} range - Date range for KPI calculation.
   */
  static calcKPIs(range) {
    try {
      const verifs = Report.filterByDate(
        Application.DATA?.verifications ?? [],
        range
      );
      const txns = Report.filterByDate(Application.DATA?.txns ?? [], range);
      const vehicles = Report.filterByDate(
        Application.DATA?.vehicles ?? [],
        range
      );

      const activeDealers = (Application.DATA?.dealers ?? []).filter(
        (d) => d.active
      ).length;

      const revenue = txns.reduce(
        (sum, t) => sum + (t.status === "success" ? t.amount : 0),
        0
      );

      Utility.el("kVerifs") &&
        (Utility.el("kVerifs").textContent = Utility.fmt(verifs.length));
      Utility.el("kRevenue") &&
        (Utility.el("kRevenue").textContent = Utility.fmtNGN(revenue));
      Utility.el("kDealers") &&
        (Utility.el("kDealers").textContent = Utility.fmt(activeDealers));
      Utility.el("kVehicles") &&
        (Utility.el("kVehicles").textContent = Utility.fmt(vehicles.length));
    } catch (err) {
      console.error("Error calculating KPIs:", err);
    }
  }

  /**
   * Builds an array of day labels within a date range.
   *
   * @param {{from: string, to: string}} range - Date range.
   * @returns {Array<{label: string, date: string}>} Array of date labels.
   */
  static rangeLabels(range) {
    const days = [];
    try {
      const d1 = new Date(range.from);
      const d2 = new Date(range.to);

      for (let d = new Date(d1); d <= d2; d.setDate(d.getDate() + 1)) {
        days.push({
          label: `${d.getMonth() + 1}/${d.getDate()}`,
          date: d.toISOString().slice(0, 10),
        });
      }
    } catch (err) {
      console.error("Error generating range labels:", err);
    }
    return days;
  }

  /**
   * Creates a human-readable text label for a date range.
   *
   * @param {{from: string, to: string}} range - Date range.
   * @returns {string} Label string.
   */
  static rangeLabelText(range) {
    return `${range.from} → ${range.to}`;
  }

  /**
   * Builds and renders a trend chart using Chart.js.
   *
   * @param {{from: string, to: string}} range - Date range.
   * @param {"overview"|"verifications"|"transactions"|"vehicles"} type - Trend type.
   */
  static buildTrend(range, type = "overview") {
    try {
      const labels = Report.rangeLabels(range);

      const dataSeries = (data, mapFn) =>
        labels.map((lbl) => {
          const day = lbl.date;
          const rows = data.filter((r) => r.date === day);
          return mapFn(rows);
        });

      const datasets = [];

      // Verifications
      if (type === "overview" || type === "verifications") {
        const verifs = Report.filterByDate(
          Application.DATA?.verifications ?? [],
          range
        );
        datasets.push({
          label: "Verifications",
          data: dataSeries(verifs, (rows) => rows.length),
          tension: 0.3,
          borderColor: "rgba(14,165,233,.9)",
          backgroundColor: "rgba(14,165,233,.08)",
          fill: true,
          pointRadius: 0,
        });
      }

      // Transactions / Revenue
      if (type === "overview" || type === "transactions") {
        const txns = Report.filterByDate(Application.DATA?.txns ?? [], range);
        datasets.push({
          label: "Revenue",
          data: dataSeries(txns, (rows) =>
            rows.reduce(
              (s, t) => s + (t.status === "success" ? t.amount : 0),
              0
            )
          ),
          yAxisID: "y1",
          tension: 0.3,
          borderColor: "rgba(34,197,94,.9)",
          backgroundColor: "rgba(34,197,94,.08)",
          fill: true,
          pointRadius: 0,
        });
      }

      // Vehicles
      if (type === "overview" || type === "vehicles") {
        const vehicles = Report.filterByDate(
          Application.DATA?.vehicles ?? [],
          range
        );
        datasets.push({
          label: "Vehicles Listed",
          data: dataSeries(vehicles, (rows) => rows.length),
          tension: 0.3,
          borderColor: "rgba(99,102,241,.9)",
          backgroundColor: "rgba(99,102,241,.08)",
          fill: true,
          pointRadius: 0,
        });
      }

      const ctx = document.getElementById("trendChart")?.getContext("2d");
      if (!ctx) {
        console.warn("Trend chart canvas not found.");
        return;
      }

      Report.trendChart?.destroy();
      Report.trendChart = new Chart(ctx, {
        type: "line",
        data: { labels: labels.map((l) => l.label), datasets },
        options: {
          responsive: true,
          interaction: { mode: "index", intersect: false },
          stacked: false,
          plugins: { legend: { display: true } },
          scales: {
            y: { beginAtZero: true },
            y1: {
              beginAtZero: true,
              position: "right",
              grid: { drawOnChartArea: false },
            },
          },
        },
      });

      Utility.el("trendLabel") &&
        (Utility.el("trendLabel").textContent = Report.rangeLabelText(range));
    } catch (err) {
      console.error("Error building trend chart:", err);
    }
  }

  /**
   * Builds a data table for the given type.
   *
   * @param {"transactions"|"verifications"|"dealers"|"vehicles"|"overview"} type - Table type.
   * @param {{from: string, to: string}} range - Date range.
   */
  static setTable(type, range) {
    try {
      let head = [];
      let rows = [];
      let title = "";

      switch (type) {
        case "transactions":
          title = "Recent Transactions";
          head = ["ID", "Amount", "Status", "Method", "Date"];
          rows = Report.filterByDate(Application.DATA?.txns ?? [], range).map(
            (t) => [t.id, Utility.fmtNGN(t.amount), t.status, t.method, t.date]
          );
          break;

        case "verifications":
          title = "Recent Verifications";
          head = ["ID", "VIN", "Result", "Plan", "Date"];
          rows = Report.filterByDate(
            Application.DATA?.verifications ?? [],
            range
          ).map((v) => [v.id, v.vin, v.result, v.plan, v.date]);
          break;

        case "dealers":
          title = "Dealers";
          head = ["ID", "Name", "Email", "Active", "Revenue"];
          rows = (Application.DATA?.dealers ?? []).map((d) => [
            d.id,
            d.company,
            d.contact,
            d.active ? "Yes" : "No",
            Utility.fmtNGN(d.revenue),
          ]);
          break;

        case "vehicles":
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
          rows = Report.filterByDate(
            Application.DATA?.vehicles ?? [],
            range
          ).map((v) => [
            v.id,
            v.make,
            v.model,
            v.year,
            Utility.fmt(v.mileage),
            Utility.fmtNGN(v.price),
            v.status,
            v.date,
          ]);
          break;

        default: // Overview
          title = "Overview Activity";
          head = ["Date", "Verifications", "Revenue (NGN)", "Vehicles Listed"];
          const labels = Report.rangeLabels(range);
          rows = labels.map((l) => {
            const ver = (Application.DATA?.verifications ?? []).filter(
              (x) =>
                new Date(x.date).toDateString() ===
                new Date(l.date).toDateString()
            ).length;
            const rev = (Application.DATA?.txns ?? [])
              .filter(
                (x) =>
                  new Date(x.date).toDateString() ===
                    new Date(l.date).toDateString() && x.status === "success"
              )
              .reduce((s, t) => s + t.amount, 0);
            const veh = (Application.DATA?.vehicles ?? []).filter(
              (x) =>
                new Date(x.date).toDateString() ===
                new Date(l.date).toDateString()
            ).length;
            return [l.date, ver, Utility.fmtNGN(rev), veh];
          });
      }

      Utility.el("tableTitle") &&
        (Utility.el("tableTitle").textContent = title);
      Report.buildTable(head, rows);
    } catch (err) {
      console.error("Error setting table:", err);
    }
  }

  /**
   * Builds table headers and initializes rows.
   *
   * @param {string[]} headers - Table headers.
   * @param {Array[]} rows - Table rows.
   */
  static buildTable(headers, rows) {
    try {
      const thead = Utility.el("tableHead");
      const tbody = Utility.el("tableBody");

      if (!thead || !tbody) {
        console.warn("Table elements not found.");
        return;
      }

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
    } catch (err) {
      console.error("Error building table:", err);
    }
  }

  /**
   * Renders current page of table with pagination controls.
   */
  static renderTablePage() {
    try {
      const tbody = Utility.el("tableBody");
      const noData = document.querySelector(".no-data");

      if (!tbody || !noData) {
        console.warn("Table body or no-data element not found.");
        return;
      }

      noData.innerHTML = "";
      tbody.innerHTML = "";

      if (!Report.CURRENT_ROWS || Report.CURRENT_ROWS.length === 0) {
        Utility.renderEmptyState(noData);
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

      Utility.el("pgInfo") &&
        (Utility.el(
          "pgInfo"
        ).textContent = `Page ${Utility.PAGE} • Showing ${slice.length} of ${Report.CURRENT_ROWS.length}`);

      Utility.el("prevPg")?.addEventListener("click", () => {
        if (Utility.PAGE > 1) {
          Utility.PAGE--;
          Report.renderTablePage();
        }
      });

      Utility.el("nextPg")?.addEventListener("click", () => {
        if (Utility.PAGE * Utility.PER_PAGE < Report.CURRENT_ROWS.length) {
          Utility.PAGE++;
          Report.renderTablePage();
        }
      });
    } catch (err) {
      console.error("Error rendering table page:", err);
    }
  }
}
