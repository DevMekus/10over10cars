import Utility from "./Utility.js";
import AppInit from "./Application.js";

export default class VerifyStatic {
  static VEHICLE = {
    vin: "2HGFB2F50DH512345",
    make: "Toyota",
    model: "Corolla",
    year: 2016,
    status: "clean",
    lastUpdate: "2025-08-10",
    odometer: 82400,
    marketValue: 7800000,
    images: [], // empty -> placeholder
    ownership: [
      { from: "2016", to: "2018", owner: "Dealer (Imported)" },
      { from: "2018", to: "2021", owner: "Private — Lagos" },
      { from: "2021", to: "Present", owner: "Current owner — Abuja (FCT)" },
    ],
    accidents: [{ year: 2019, desc: "Minor bumper repair (insurance claim)" }],
  };

  static RELATED = [
    {
      id: "r1",
      title: "2015 Toyota Corolla — Lagos",
      price: 7200000,
      mileage: 88000,
    },
    {
      id: "r2",
      title: "2017 Honda Accord — Abuja",
      price: 11500000,
      mileage: 54000,
    },
    {
      id: "r3",
      title: "2016 Toyota Camry — Port Harcourt",
      price: 14500000,
      mileage: 41000,
    },
  ];

  static renderHistory() {
    const list = document.getElementById("historyList");
    list.innerHTML = "";
    const items = AppInit.loadHistory();
    if (!items.length) {
      list.innerHTML = '<div class="muted small">No history yet</div>';
      return;
    }
    items.slice(0, 12).forEach((it) => {
      const div = document.createElement("div");
      div.className = "history-item";
      div.innerHTML = `<div><strong>${AppInit.escapeHtml(
        it.title
      )}</strong><div class='muted small'>${it.vin} • ${new Date(
        it.when
      ).toLocaleString()}</div></div><div style="display:flex;gap:6px"><button class="btn ghost" data-retry="${
        it.vin
      }"><i class='bi bi-arrow-repeat'></i></button><button class="btn ghost" data-del="${
        it.when
      }"><i class='bi bi-trash'></i></button></div>`;
      list.appendChild(div);
    });
  }

  static processDecision(id, decision, fromModal = false) {
    const idx = AppInit.DATA.verifications.findIndex((r) => r.requestId === id);
    if (idx === -1) return;
    AppInit.DATA.verifications[idx].status = decision;

    new Verification().renderDashPageStats();
    new Verification().renderUserVerificationTable();
    AppInit.toast(`Request ${id} ${decision} success`);
    if (fromModal)
      document.getElementById("detailModal").classList.remove("open");
  }

  static showResult(data) {
    document.getElementById("noResult").style.display = "none";
    document.getElementById("resultArea").style.display = "block";
    document.getElementById("vehTitle").innerHTML = data.title;
    document.getElementById("vehVin").textContent = data.vin;
    document.getElementById("vehOwner").textContent = data.owner;
    document.getElementById("vehPrice").textContent =
      "NGN " + Number(data.price).toLocaleString();
    document.getElementById("vehYear").textContent = data.year;
    document.getElementById("vehMileage").textContent =
      data.mileage.toLocaleString();
    document.getElementById("vehEngine").textContent = data.engine;
    document.getElementById("vehStatus").textContent = data.clean
      ? "Clean"
      : "Flagged";
    document.getElementById("vehStatus").className =
      "status-pill " + (data.clean ? "status-clean" : "status-flag");
    document.getElementById("rawDetail").textContent = JSON.stringify(
      data.raw,
      null,
      2
    );
    const img = document.getElementById("vehMedia").querySelector("img");
    img.src = `https://images.unsplash.com/photo-1542362567-b07e54358753?q=80&w=1600&auto=format&fit=crop&sat=-20&sig=${Math.abs(
      AppInit.hashCode(data.vin)
    )}`;
    const hist = document.getElementById("vehHistory");
    hist.innerHTML = "";
    if (data.history && data.history.length) {
      data.history.forEach((h) => {
        const li = document.createElement("li");
        li.textContent = h;
        hist.appendChild(li);
      });
    } else {
      hist.innerHTML = '<li class="muted small">No notable history</li>';
    }
  }

  static openDetail(id) {
    const req = AppInit.DATA.verifications.find((r) => r.requestId === id);
    if (!req) return;
    document.getElementById("detailImage").src = req.Vehicle.image[0];
    document.getElementById("detailTitle").textContent = req.Vehicle.title;
    document.getElementById(
      "detailMeta"
    ).textContent = `${req.Vehicle.dealer} • submitted ${req.date}`;
    document.getElementById("detailVin").textContent = req.vin;
    document.getElementById("detailUser").textContent = req.Vehicle.dealer;
    document.getElementById("detailDocs").innerHTML = req.Vehicle.docs
      .map((d) => `<li><a href="#">${d}</a></li>`)
      .join("");
    document.getElementById("detailNotes").textContent =
      req.Vehicle.notes || "—";
    document.getElementById("approveBtn").dataset.target = id;
    document.getElementById("declineBtn").dataset.target = id;
    document.getElementById("detailModal").classList.add("open");
    document.getElementById("detailModal").setAttribute("aria-hidden", "false");
  }

  // DOM refs
  static vinText = document.getElementById("vinText");
  static statusBadge = document.getElementById("statusBadge");
  static lastUpdate = document.getElementById("lastUpdate");
  static carouselMain = document.getElementById("carouselMain");
  static thumbs = document.getElementById("thumbs");
  static relatedList = document.getElementById("relatedList");

  static showToast(msg, type = "info", ttl = 3000) {
    const t = document.createElement("div");
    t.className = "toast";
    t.setAttribute("role", "status");
    t.innerHTML = `<div style="font-weight:700;margin-right:8px">${
      type === "error"
        ? '<i class="bi bi-exclamation-triangle-fill"></i>'
        : '<i class="bi bi-check2-circle"></i>'
    }</div><div style="min-width:160px">${msg}</div>`;
    document.getElementById("toastContainer").appendChild(t);
    setTimeout(() => {
      t.style.opacity = "0";
      setTimeout(() => t.remove(), 400);
    }, ttl);
  }
}

class Verification {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await AppInit.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderVehicleData() {
    const domEl = document.getElementById("VERIFIEDContainer");
    if (!domEl) return;
    function renderVehicle() {
      VerifyStatic.vinText.textContent = VerifyStatic.VEHICLE.vin;
      VerifyStatic.lastUpdate.textContent = VerifyStatic.VEHICLE.lastUpdate;
      VerifyStatic.statusBadge.textContent =
        VerifyStatic.VEHICLE.status === "clean" ? "Clean" : "Alert";
      VerifyStatic.statusBadge.className =
        VerifyStatic.VEHICLE.status === "clean"
          ? "status clean"
          : "status alert";

      // images
      if (VerifyStatic.VEHICLE.images && VerifyStatic.VEHICLE.images.length) {
        VerifyStatic.carouselMain.innerHTML = "";
        VerifyStatic.VEHICLE.images.forEach((src, i) => {
          const img = document.createElement("img");
          img.src = src;
          img.alt = `${VerifyStatic.VEHICLE.make} ${
            VerifyStatic.VEHICLE.model
          } image ${i + 1}`;
          img.style.maxHeight = "100%";
          img.style.objectFit = "cover";
          VerifyStatic.carouselMain.appendChild(img);
        });
        VerifyStatic.VEHICLE.images.forEach((src, i) => {
          const t = document.createElement("div");
          t.className = "thumb";
          t.innerHTML = `<img src="${src}" alt="thumb ${
            i + 1
          }" style="width:100%;height:100%;object-fit:cover;border-radius:8px">`;
          t.addEventListener("click", () => {
            VerifyStatic.carouselMain.innerHTML = `<img src="${src}" alt="image" style="width:100%;height:100%;object-fit:cover;border-radius:8px">`;
          });
          VerifyStatic.thumbs.appendChild(t);
        });
      } else {
        VerifyStatic.carouselMain.innerHTML =
          '<div style="color:var(--muted);text-align:center">No photos available</div>';
      }

      // related
      VerifyStatic.RELATED.forEach((r) => {
        const card = document.createElement("div");
        card.className = "related-card";
        card.innerHTML = `<div style=\"font-weight:800\">${
          r.title
        }</div><div class=\"muted\">${r.mileage.toLocaleString()} km</div><div class=\"price\">NGN ${r.price.toLocaleString()}</div><div style=\"margin-top:8px;display:flex;gap:8px\"><button class=\"action-btn\">View</button><button class=\"action-btn\">Contact</button></div>`;
        VerifyStatic.relatedList.appendChild(card);
      });
    }

    renderVehicle();
  }

  tabBehaviourControl() {
    const domEl = document.getElementById("VERIFIEDContainer");
    if (!domEl) return;
    document.querySelectorAll(".tab-btn")?.forEach((btn) => {
      btn.addEventListener("click", () => {
        document.querySelectorAll(".tab-btn").forEach((b) => {
          b.classList.remove("active");
          b.setAttribute("aria-selected", "false");
        });
        document
          .querySelectorAll(".tab-panel")
          .forEach((p) => p.classList.remove("active"));
        btn.classList.add("active");
        btn.setAttribute("aria-selected", "true");
        const t = btn.getAttribute("data-tab");
        document.getElementById(t).classList.add("active");
        AOS.refresh();
      });
    });
  }

  copyVinAction() {
    const domEl = document.getElementById("VERIFIEDContainer");
    if (!domEl) return;
    document.getElementById("copyVin")?.addEventListener("click", async () => {
      try {
        await navigator.clipboard.writeText(VerifyStatic.VEHICLE.vin);
        showToast("VIN copied to clipboard", "success");
      } catch (e) {
        VerifyStatic.showToast("Unable to copy VIN", "error");
      }
    });
  }

  downloadAsPDF() {
    document.getElementById("downloadPdf")?.addEventListener("click", () => {
      VerifyStatic.showToast("Preparing PDF (demo)...", "info");
      // create simple text file as demo
      const blob = new Blob(
        [
          `Vehicle report for VIN ${VerifyStatic.VEHICLE.vin}\nMake: ${VerifyStatic.VEHICLE.make} ${VerifyStatic.VEHICLE.model} (${VerifyStatic.VEHICLE.year})\nStatus: ${VerifyStatic.VEHICLE.status}`,
        ],
        { type: "text/plain" }
      );
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = `${VerifyStatic.VEHICLE.vin}-report.txt`;
      a.click();
      URL.revokeObjectURL(url);
    });
  }

  shareInformation() {
    document.getElementById("shareBtn")?.addEventListener("click", async () => {
      const shareData = {
        title: `Vehicle report - ${VerifyStatic.VEHICLE.vin}`,
        text: `Check this vehicle: ${VerifyStatic.VEHICLE.make} ${VerifyStatic.VEHICLE.model} (${VerifyStatic.VEHICLE.year})`,
        url: window.location.href,
      };
      if (navigator.share) {
        try {
          await navigator.share(shareData);
          VerifyStatic.showToast("Shared successfully", "success");
        } catch (e) {
          VerifyStatic.showToast("Share cancelled", "info");
        }
      } else {
        // fallback
        await navigator.clipboard.writeText(
          `${shareData.text} - ${shareData.url}`
        );
        VerifyStatic.showToast("Report link copied to clipboard", "success");
      }
    });
  }

  saveToLocalStorage() {
    document.getElementById("saveBtn")?.addEventListener("click", () => {
      const key = "saved_vehicles";
      const list = JSON.parse(localStorage.getItem(key) || "[]");
      if (list.includes(VerifyStatic.VEHICLE.vin)) {
        VerifyStatic.showToast("Already saved", "info");
        return;
      }
      list.push(VerifyStatic.VEHICLE.vin);
      localStorage.setItem(key, JSON.stringify(list));
      VerifyStatic.showToast("Vehicle saved", "success");
    });
  }

  printInformation() {
    document.getElementById("printBtn")?.addEventListener("click", () => {
      window.print();
    });
  }

  renderVerificationTable() {
    const tbody = document.querySelector("#tableVer tbody");
    if (!tbody) return;

    tbody.innerHTML = "";
    AppInit.DATA.verifications.forEach((v) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td><code>${v.vin}</code></td><td>${v.result}</td><td>${v.source}</td><td>${v.date}</td><td><button class='btn btn-ghost' data-view-vin='${v.vin}'>View</button></td>`;
      tbody.appendChild(tr);
    });
  }

  renderVerificationChart() {
    const domElem = document.getElementById("chartVer");
    if (!domElem) return;
    const ctx = domElem.getContext("2d");
    const labels = Array.from(
      {
        length: 30,
      },
      (_, i) => {
        const d = new Date();
        d.setDate(d.getDate() - (29 - i));
        return `${d.getMonth() + 1}/${d.getDate()}`;
      }
    );
    const chart = new Chart(ctx, {
      type: "line",
      data: {
        labels,
        datasets: [
          {
            label: "Verifications",
            data: labels.map(() => Math.floor(20 + Math.random() * 80)),
            tension: 0.3,
            borderColor: "rgba(14,165,233,0.9)",
            backgroundColor: "rgba(14,165,233,0.08)",
            fill: true,
            pointRadius: 0,
          },
        ],
      },
      options: {
        plugins: {
          legend: {
            display: false,
          },
        },
        responsive: true,
      },
    });
  }

  renderDashPageStats() {
    const domEl = document.querySelector(".verificationPage");
    if (!domEl) return;

    const total = AppInit.DATA.verifications.length;
    const approved = AppInit.DATA.verifications.filter(
      (r) => r.status === "approved"
    ).length;
    const declined = AppInit.DATA.verifications.filter(
      (r) => r.status === "declined"
    ).length;
    const pending = AppInit.DATA.verifications.filter(
      (r) => r.status === "pending"
    ).length;
    document.getElementById("statTotal").textContent = total;
    document.getElementById("statApproved").textContent = approved;
    document.getElementById("statDeclined").textContent = declined;
    document.getElementById("statPending").textContent = pending;
  }

  renderUserVerificationTable() {
    function renderTable() {
      const tbody = document.querySelector("#reqTable tbody");
      if (!tbody) return;
      tbody.innerHTML = "";
      const q = (document.getElementById("qSearch").value || "").toLowerCase();
      const statusFilter = document.getElementById("statusFilter").value;
      const from = document.getElementById("fromDate").value;
      const to = document.getElementById("toDate").value;

      let filtered = AppInit.DATA.verifications.filter((r) => {
        if (statusFilter !== "all" && r.status !== statusFilter) return false;
        if (q && !`${r.vin} ${r.title} ${r.user}`.toLowerCase().includes(q))
          return false;
        if (from && r.date < from) return false;
        if (to && r.date > to) return false;
        return true;
      });

      const totalFiltered = filtered.length;
      document.getElementById("totalCount").textContent = totalFiltered;
      const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
      const slice = filtered.slice(start, start + AppInit.PER_PAGE);
      document.getElementById("showingCount").textContent = slice.length;

      slice.forEach((r) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td><code>${r.requestId}</code></td>
          <td><strong>${r.vin}</strong></td>
          <td><div style="display:flex;gap:8px;align-items:center"><img src="${
            r.Vehicle.image[0]
          }" alt="thumb" style="width:84px;height:56px;object-fit:cover;border-radius:6px"> <div><strong>${
          r.Vehicle.title
        }</strong><div class='muted small'>${
          r.Vehicle.dealer
        }</div></div></div></td>
          <td>${r.Vehicle.dealer}</td>
          <td class="small">${r.date}</td>
          <td>${
            r.status === "pending"
              ? '<span class="status-pill s-pending">Pending</span>'
              : r.status === "approved"
              ? '<span class="status-pill s-approved">Approved</span>'
              : '<span class="status-pill s-declined">Declined</span>'
          }</td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn btn-ghost" data-view='${
                r.requestId
              }'>View</button>
              ${
                r.status === "pending"
                  ? `<button class="btn btn-primary" data-approve='${r.requestId}'>Approve</button><button class="btn btn-ghost" data-decline='${r.requestId}'>Decline</button>`
                  : ""
              }
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });

      document.getElementById("pageInfo").textContent = `Page ${
        AppInit.PAGE
      } of ${AppInit.pageCount(AppInit.DATA.verifications)}`;
    }
    renderTable();
    // ---------- Search / filters ----------
    ["qSearch", "statusFilter", "fromDate", "toDate"].forEach((id) =>
      document.getElementById(id)?.addEventListener("input", () => {
        AppInit.PAGE = 1;
        renderTable();
      })
    );

    // ---------- Pagination controls ----------
    document.getElementById("prevPage")?.addEventListener("click", () => {
      if (AppInit.PAGE > 1) AppInit.PAGE--;
      renderTable();
    });
    document.getElementById("nextPage")?.addEventListener("click", () => {
      if (AppInit.PAGE < AppInit.pageCount(AppInit.DATA.verifications))
        AppInit.PAGE++;
      renderTable();
    });
  }

  delegateActions() {
    document.querySelector("#reqTable")?.addEventListener("click", (e) => {
      const vbtn = e.target.closest("[data-view]");
      if (vbtn) {
        const id = vbtn.dataset.view;
        VerifyStatic.openDetail(id);
        return;
      }
      const apro = e.target.closest("[data-approve]");
      if (apro) {
        const id = apro.dataset.approve;
        VerifyStatic.processDecision(id, "approved");
        return;
      }
      const dec = e.target.closest("[data-decline]");
      if (dec) {
        const id = dec.dataset.decline;
        VerifyStatic.processDecision(id, "declined");
        return;
      }
    });
  }

  modalActionDelegation() {
    document.querySelectorAll("[data-close]").forEach((b) =>
      b.addEventListener("click", () => {
        document.getElementById(b.dataset.close).classList.remove("open");
      })
    );

    // approve/decline from modal
    document
      .getElementById("approveBtn")
      .addEventListener("click", () =>
        VerifyStatic.processDecision(
          document.getElementById("approveBtn").dataset.target,
          "approved",
          true
        )
      );
    document
      .getElementById("declineBtn")
      .addEventListener("click", () =>
        VerifyStatic.processDecision(
          document.getElementById("declineBtn").dataset.target,
          "declined",
          true
        )
      );
  }

  verificationPendingChart() {
    //For Admins Only
    // initial chart (mini)
    const ctx = document.createElement("canvas");
    ctx.height = 80;
    document.querySelector(".cards .card")?.appendChild(ctx);
    new Chart(ctx.getContext("2d"), {
      type: "bar",
      data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        datasets: [
          {
            data: [12, 19, 8, 14, 22, 10, 16],
            backgroundColor: "rgba(14,165,233,0.8)",
          },
        ],
      },
      options: {
        plugins: {
          legend: {
            display: false,
          },
        },
        responsive: true,
      },
    });
  }

  userVerifiesVin() {
    const verifyBtn = document.getElementById("verify");
    if (!verifyBtn) return;

    verifyBtn.addEventListener("click", async () => {
      const vin = document
        .getElementById("vinInput")
        .value.trim()
        .toUpperCase();
      if (!AppInit.validVIN(vin)) {
        AppInit.toast(
          "VIN invalid — must be 11–17 chars and not include I,O,Q",
          "error"
        );
        return;
      }
      document.getElementById("verify").disabled = true;
      document.getElementById("verify").textContent = "Verifying...";
      try {
        const res = await AppInit.mockLookup(vin);
        VerifyStatic.showResult(res);
      } catch (e) {
        AppInit.toast("Lookup failed (demo)", "error");
      } finally {
        document.getElementById("verify").disabled = false;
        document.getElementById("verify").textContent = "Verify VIN";
      }
    });
  }

  quickRetryVINSearch() {
    // quick search retry/delete from history
    document.addEventListener("click", (e) => {
      const r = e.target.closest("[data-retry]");
      if (r) {
        const vin = r.dataset.retry;
        document.getElementById("vinInput").value = vin;
        document.getElementById("verify").click();
        return;
      }
      const d = e.target.closest("[data-del]");
      if (d) {
        const when = d.dataset.del;
        let items = AppInit.loadHistory();
        items = items.filter((x) => x.when !== when);
        AppInit.saveHistory(items);
        renderHistory();
        AppInit.toast("Removed");
        return;
      }
      if (e.target.matches("[data-close]")) {
        document
          .getElementById(e.target.dataset.close)
          .classList.remove("open");
        document
          .getElementById(e.target.dataset.close)
          .setAttribute("aria-hidden", "true");
      }
    });
  }

  saveHistoryButton() {
    // save to history button
    document.getElementById("saveToHistory")?.addEventListener("click", () => {
      const vin = document.getElementById("vehVin").textContent;
      if (!vin || vin === "--") {
        AppInit.toast("Nothing to save", "error");
        return;
      }
      const record = {
        vin,
        title: document.getElementById("vehTitle").textContent,
        when: new Date().toISOString(),
        raw: document.getElementById("rawDetail").textContent
          ? JSON.parse(document.getElementById("rawDetail").textContent)
          : {},
      };
      const items = AppInit.loadHistory();
      items.unshift(record);
      AppInit.saveHistory(items);
      VerifyStatic.renderHistory();
      AppInit.toast("Saved lookup to history");
    });
  }

  clearHistory() {
    // clear history
    document.getElementById("clearHistory")?.addEventListener("click", () => {
      if (!confirm("Clear all local history?")) return;
      AppInit.saveHistory([]);
      VerifyStatic.renderHistory();
      AppInit.toast("History cleared");
    });
  }

  reportIssuesModal() {
    // report issue modal
    document.getElementById("reportIssue")?.addEventListener("click", () => {
      document.getElementById("reportModal").classList.add("open");
      document
        .getElementById("reportModal")
        .setAttribute("aria-hidden", "false");
    });
    document.getElementById("reportForm")?.addEventListener("submit", (e) => {
      e.preventDefault();
      const issue = new FormData(e.target).get("issue");
      document.getElementById("reportModal").classList.remove("open");
      AppInit.toast("Report sent (demo)");
    });
  }

  quickSearchHistory() {
    document.getElementById("q")?.addEventListener("input", () => {
      const q = document.getElementById("q").value.trim().toLowerCase();
      const items = AppInit.loadHistory();
      const filtered = items.filter((i) =>
        (i.vin + " " + i.title).toLowerCase().includes(q)
      );
      const list = document.getElementById("historyList");
      list.innerHTML = "";
      filtered.slice(0, 12).forEach((it) => {
        const div = document.createElement("div");
        div.className = "history-item";
        div.innerHTML = `<div><strong>${AppInit.escapeHtml(
          it.title
        )}</strong><div class='muted small'>${it.vin} • ${new Date(
          it.when
        ).toLocaleString()}</div></div><div style="display:flex;gap:6px"><button class="btn ghost" data-retry="${
          it.vin
        }"><i class='bi bi-arrow-repeat'></i></button></div>`;
        list.appendChild(div);
      });
      if (!filtered.length)
        list.innerHTML = '<div class="muted small">No matches</div>';
    });
  }
}

new Verification();
