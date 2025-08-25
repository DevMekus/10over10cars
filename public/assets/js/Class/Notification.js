import AppInit from "./Application.js";
import Utility from "./Utility.js";

export default class NoticeInit {
  static STORAGE_KEY = "10ov10_admin_notifications_v1";
  static SIM_KEY = "10ov10_notifications_sim";
  static el = (id) => document.getElementById(id);
  static SELECTED = new Set();
  static SIM_TIMER = null;
  static DATA = NoticeInit.load();

  static load() {
    const raw = localStorage.getItem(NoticeInit.STORAGE_KEY);
    if (raw) {
      try {
        return JSON.parse(raw);
      } catch (e) {}
    }
    localStorage.setItem(
      NoticeInit.STORAGE_KEY,
      JSON.stringify(AppInit.DATA.notification)
    );
    return AppInit.DATA.notification.slice();
  }

  static save() {
    localStorage.setItem(
      NoticeInit.STORAGE_KEY,
      JSON.stringify(NoticeInit.DATA)
    );
  }

  static filtered() {
    const q = NoticeInit.el("q").value.trim().toLowerCase();
    const type = NoticeInit.el("typeFilter").value;
    const status = NoticeInit.el("statusFilter").value;
    const pri = NoticeInit.el("priorityFilter").value;
    return NoticeInit.DATA.filter((n) => {
      if (type !== "all" && n.type !== type) return false;
      if (pri !== "all" && n.priority !== pri) return false;
      if (status === "unread" && n.read) return false;
      if (status === "read" && !n.read) return false;
      if (status === "archived" && !n.archived) return false;
      if (status === "all" && n.archived) {
      } // keep archived in all? we'll keep
      if (q) {
        const hay = (
          n.title +
          " " +
          n.message +
          " " +
          n.id +
          " " +
          n.source
        ).toLowerCase();
        if (!hay.includes(q)) return false;
      }
      return true;
    });
  }

  static setRead(ids, val) {
    ids.forEach((id) => {
      const it = NoticeInit.DATA.find((d) => d.id === id);
      if (it) {
        it.read = val;
      }
    });
    NoticeInit.save();
    new Notification().renderList();
  }

  static archive(ids) {
    ids.forEach((id) => {
      const it = NoticeInit.DATA.find((d) => d.id === id);
      if (it) {
        it.archived = true;
      }
    });
    NoticeInit.save();
    new Notification().renderList();
  }

  static del(ids) {
    ids.forEach((id) => {
      const idx = NoticeInit.DATA.findIndex((d) => d.id === id);
      if (idx > -1) NoticeInit.DATA.splice(idx, 1);
    });
    NoticeInit.save();
    new Notification().renderList();
  }

  static updateBulkBar() {
    const bar = NoticeInit.el("bulkBar");
    if (NoticeInit.SELECTED.size) {
      bar.style.display = "flex";
    } else bar.style.display = "none";
  }

  static openDetail(id) {
    const n = NoticeInit.DATA.find((x) => x.id === id);
    if (!n) return;
    NoticeInit.el("detailTitle").textContent = n.title;
    NoticeInit.el("detailBody").innerHTML = `<div class="muted small">${
      n.type
    } • ${new Date(
      n.timestamp
    ).toLocaleString()}</div><h4 style="margin-top:8px">${AppInit.escapeHtml(
      n.title
    )}</h4><p>${AppInit.escapeHtml(n.message)}</p>`;
    NoticeInit.el("detailModal").classList.add("open");
    NoticeInit.el("detailModal").setAttribute("aria-hidden", "false"); // wire detail buttons
    NoticeInit.el("detailMark").onclick = () => {
      NoticeInit.setRead([id], true);
      NoticeInit.el("detailModal").classList.remove("open");
      AppInit.toast("Marked read");
    };
    NoticeInit.el("detailArchive").onclick = () => {
      NoticeInit.archive([id]);
      NoticeInit.el("detailModal").classList.remove("open");
      AppInit.toast("Archived");
    };
    NoticeInit.el("detailDelete").onclick = () => {
      NoticeInit.del([id]);
      NoticeInit.el("detailModal").classList.remove("open");
      AppInit.toast("Deleted");
    };
  }

  static exportCSV(ids = null) {
    let rows = [];
    if (!ids || !ids.length) {
      rows = NoticeInit.filtered();
    } else {
      rows = NoticeInit.DATA.filter((d) => ids.includes(d));
    }
    if (!rows.length) {
      AppInit.toast("No items to export", "error");
      return;
    }
    const headers = [
      "id",
      "title",
      "message",
      "type",
      "priority",
      "source",
      "timestamp",
      "read",
      "archived",
    ];
    const csv = [
      headers.join(","),
      ...rows.map((r) =>
        headers
          .map((h) => `"${String(r[h] || "").replace(/"/g, '""')}"`)
          .join(",")
      ),
    ].join("\n");
    const blob = new Blob([csv], {
      type: "text/csv",
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "notifications.csv";
    a.click();
    URL.revokeObjectURL(url);
    AppInit.toast("CSV downloaded (demo)", "success");
  }

  static renderSmall() {
    const r = NoticeInit.el("recentSmall");
    r.innerHTML = "";
    NoticeInit.DATA.slice(0, 6).forEach((it) => {
      const div = document.createElement("div");
      div.innerHTML = `<div style="display:flex;justify-content:space-between"><div><strong style="font-size:13px">${AppInit.escapeHtml(
        it.title
      )}</strong><div class="muted small">${new Date(
        it.timestamp
      ).toLocaleString()}</div></div><div class="tag ${
        it.priority === "high" ? "danger" : "info"
      }" style="height:28px">${it.priority}</div></div>`;
      r.appendChild(div);
    });
  }

  // ---------- Chart (notifications over last N days) ----------
  static chart;

  static renderChart() {
    const ctx = NoticeInit.el("notifChart").getContext("2d");
    const days = 14;
    const labels = [];
    const counts = [];
    for (let i = days - 1; i >= 0; i--) {
      const d = new Date();
      d.setDate(d.getDate() - i);
      const key = d.toISOString().slice(0, 10);
      labels.push(key);
      counts.push(
        NoticeInit.DATA.filter((n) => n.timestamp.slice(0, 10) === key).length
      );
    }
    NoticeInit.chart?.destroy();
    NoticeInit.chart = new Chart(ctx, {
      type: "bar",
      data: {
        labels,
        datasets: [
          {
            label: "Notifications",
            data: counts,
            backgroundColor: "rgba(14,165,233,0.7)",
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

  // ---------- Simulation (real-time demo) ----------
  static startSim() {
    const enabled = NoticeInit.el("simEnable").checked;
    if (!enabled) {
      NoticeInit.stopSim();
      return;
    }
    const interval =
      Math.max(5, Number(NoticeInit.el("simInterval").value) || 12) * 1000;
    NoticeInit.SIM_TIMER = setTimeout(() => {
      NoticeInit.pushMock();
      NoticeInit.startSim();
    }, interval);
    NoticeInit.el("simToggle").setAttribute("aria-pressed", "true");
  }

  static stopSim() {
    clearTimeout(NoticeInit.SIM_TIMER);
    NoticeInit.SIM_TIMER = null;
    NoticeInit.el("simToggle").setAttribute("aria-pressed", "false");
  }

  static pushMock() {
    const types = ["system", "user", "dealer", "transaction"];
    const t = types[Math.floor(Math.random() * types.length)];
    const pri =
      Math.random() < 0.15 ? "high" : Math.random() < 0.25 ? "low" : "normal";
    const item = {
      id: AppInit.uid("N"),
      title: `${t} event — ${new Date().toLocaleTimeString()}`,
      message: `Auto-generated ${t} notification (demo).`,
      type: t,
      priority: pri,
      source: t,
      timestamp: new Date().toISOString(),
      read: false,
      archived: false,
    };
    NoticeInit.DATA.unshift(item);
    NoticeInit.save();
    new Notification().renderList();
    AppInit.toast("New notification (demo)", "info");
  }
}

class Notification {
  constructor() {
    this.initialize();
    window._NOTIF_SAVE = NoticeInit.save;
    window._NOTIF_DATA = NoticeInit.DATA;
  }

  initialize() {
    NoticeInit.DATA = NoticeInit.load();
    NoticeInit.renderSmall();

    NoticeInit.renderChart();
    Utility.runClassMethods(this, ["initialize"]);
  }

  stats() {
    const unread = NoticeInit.DATA.filter((n) => !n.read && !n.archived).length;
    const alerts = NoticeInit.DATA.filter(
      (n) => n.priority === "high" && !n.archived
    ).length;
    const system = NoticeInit.DATA.filter(
      (n) => n.type === "system" && !n.archived
    ).length;
    const archived = NoticeInit.DATA.filter((n) => n.archived).length;
    NoticeInit.el("sUnread").textContent = unread;
    NoticeInit.el("sAlerts").textContent = alerts;
    NoticeInit.el("sSystem").textContent = system;
    NoticeInit.el("sArchived").textContent = archived;
  }

  renderList() {
    const mount = NoticeInit.el("list");
    mount.innerHTML = "";
    const rows = NoticeInit.filtered();
    const total = rows.length;
    const pages = Math.max(1, Math.ceil(total / AppInit.PER_PAGE));
    if (AppInit.PAGE > pages) AppInit.PAGE = pages;
    const start = (AppInit.PAGE - 1) * AppInit.PER_PAGE;
    const pageRows = rows.slice(start, start + AppInit.PER_PAGE);

    pageRows.forEach((n) => {
      const div = document.createElement("div");
      div.className = "note " + (n.read ? "read" : "unread");
      if (n.archived) div.style.opacity = 0.6;
      div.setAttribute("data-id", n.id);
      div.innerHTML = `
        <div style="display:flex;gap:12px;align-items:flex-start;width:100%">
          <label style="display:flex;align-items:center;gap:8px"><input type="checkbox" data-sel="${
            n.id
          }" ${NoticeInit.SELECTED.has(n.id) ? "checked" : ""}></label>
          <div class="icon">${n.type[0].toUpperCase()}</div>
          <div class="body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
              <div style="max-width:70%"><strong>${AppInit.escapeHtml(
                n.title
              )}</strong><div class="muted small">${AppInit.escapeHtml(
        n.source
      )} • ${new Date(n.timestamp).toLocaleString()}</div></div>
              <div style="text-align:right"><span class="tag ${
                n.priority === "high"
                  ? "danger"
                  : n.priority === "low"
                  ? "info"
                  : "info"
              }">${n.priority}</span><div class="muted small">${
        n.archived ? "Archived" : ""
      }</div></div>
            </div>
            <div class="meta">${AppInit.escapeHtml(n.message)}</div>
            <div class="actions" style="margin-top:8px"><button class="btn ghost" data-view="${
              n.id
            }">View</button><button class="btn ghost" data-toggle-read="${
        n.id
      }">${
        n.read ? "Mark unread" : "Mark read"
      }</button><button class="btn ghost" data-archive="${
        n.id
      }">Archive</button><button class="btn" data-delete="${
        n.id
      }" style="background:var(--danger);color:#fff">Delete</button></div>
          </div>
        </div>`;
      mount.appendChild(div);
    });

    NoticeInit.el(
      "pageInfo"
    ).textContent = `Page ${AppInit.PAGE} / ${pages} • ${total} items`;
    this.stats();
    NoticeInit.updateBulkBar();
    NoticeInit.renderSmall();
    NoticeInit.renderChart();
  }
  eventDelegations() {
    document.addEventListener("click", (e) => {
      // open detail
      const v = e.target.closest("[data-view]");
      if (v) {
        NoticeInit.openDetail(v.dataset.view);
        return;
      }
      const tr = e.target.closest("[data-toggle-read]");
      if (tr) {
        const id = tr.dataset.toggleRead;
        const it = DATA.find((d) => d.id === id);
        NoticeInit.setRead([id], !it.read);
        AppInit.toast("Status updated");
        return;
      }
      const ar = e.target.closest("[data-archive]");
      if (ar) {
        NoticeInit.archive([ar.dataset.archive]);
        AppInit.toast("Archived");
        return;
      }
      const dl = e.target.closest("[data-delete]");
      if (dl) {
        NoticeInit.del([dl.dataset.delete]);
        AppInit.toast("Deleted");
        return;
      }
      // modal closes
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

  checkBoxSelection() {
    document.addEventListener("change", (e) => {
      if (e.target.matches("[data-sel]")) {
        const id = e.target.dataset.sel;
        if (e.target.checked) NoticeInit.SELECTED.add(id);
        else NoticeInit.SELECTED.delete(id);
        NoticeInit.updateBulkBar();
      }
      if (e.target.id === "selectAll") {
        const checked = e.target.checked;
        document.querySelectorAll("[data-sel]").forEach((cb) => {
          cb.checked = checked;
          const id = cb.dataset.sel;
          if (checked) NoticeInit.SELECTED.add(id);
          else NoticeInit.SELECTED.delete(id);
        });
        NoticeInit.updateBulkBar();
      }
    });
  }

  bulkActions() {
    NoticeInit.el("markRead").addEventListener("click", () => {
      NoticeInit.setRead([...NoticeInit.SELECTED], true);
      NoticeInit.SELECTED.clear();
      document.getElementById("selectAll").checked = false;
      NoticeInit.updateBulkBar();
      AppInit.toast("Marked read");
    });
    NoticeInit.el("markUnread").addEventListener("click", () => {
      NoticeInit.setRead([...NoticeInit.SELECTED], false);
      NoticeInit.SELECTED.clear();
      document.getElementById("selectAll").checked = false;
      NoticeInit.updateBulkBar();
      AppInit.toast("Marked unread");
    });
    NoticeInit.el("archive").addEventListener("click", () => {
      archive([...NoticeInit.SELECTED]);
      NoticeInit.SELECTED.clear();
      document.getElementById("selectAll").checked = false;
      NoticeInit.updateBulkBar();
      AppInit.toast("Archived selected");
    });
    NoticeInit.el("del").addEventListener("click", () => {
      if (!confirm("Delete selected notifications?")) return;
      NoticeInit.del([...NoticeInit.SELECTED]);
      NoticeInit.SELECTED.clear();
      document.getElementById("selectAll").checked = false;
      NoticeInit.updateBulkBar();
      AppInit.toast("Deleted selected");
    });
    NoticeInit.el("exportSelected").addEventListener("click", () => {
      NoticeInit.exportCSV(Array.from(NoticeInit.SELECTED));
    });
  }

  pageNavigationControls() {
    NoticeInit.el("prevPage").addEventListener("click", () => {
      if (AppInit.PAGE > 1) {
        AppInit.PAGE--;
        this.renderList();
      }
    });
    NoticeInit.el("nextPage").addEventListener("click", () => {
      const total = NoticeInit.filtered().length;
      const pages = Math.max(1, Math.ceil(total / AppInit.PER_PAGE));
      if (AppInit.PAGE < pages) {
        AppInit.PAGE++;
        this.renderList();
      }
    });
  }

  loadMoreIncrement() {
    NoticeInit.el("loadMore").addEventListener("click", () => {
      AppInit.PER_PAGE += AppInit.PER_PAGE;
      this.renderList();
      AppInit.toast("Loaded more (demo)");
    });
  }

  createAndBroadcastModal() {
    NoticeInit.el("createBtn").addEventListener("click", () => {
      NoticeInit.el("createModal").classList.add("open");
      NoticeInit.el("createModal").setAttribute("aria-hidden", "false");
    });
    NoticeInit.el("createForm").addEventListener("submit", (e) => {
      e.preventDefault();
      const f = new FormData(e.target);
      const title = f.get("title").trim();
      const message = f.get("message").trim();
      const type = f.get("type");
      const priority = f.get("priority");
      const broadcast = f.get("broadcast") === "on";
      if (!title || !message) {
        AppInit.toast("Title and message required", "error");
        return;
      }
      const now = new Date();
      const item = {
        id: AppInit.uid("N"),
        title,
        message,
        type,
        priority,
        source: "admin",
        timestamp: now.toISOString(),
        read: false,
        archived: false,
      };
      NoticeInit.DATA.unshift(item);
      NoticeInit.save();
      this.renderList();
      NoticeInit.el("createModal").classList.remove("open");
      AppInit.toast("Notification created");
      e.target.reset(); // preview persistence
      if (broadcast) {
        AppInit.toast("Broadcast scheduled (demo)", "info");
      }
    });
  }

  quickExportAndFilters() {
    NoticeInit.el("exportSelected").addEventListener("click", () =>
      NoticeInit.exportCSV([...NoticeInit.SELECTED])
    );

    // search + filters
    ["q", "typeFilter", "statusFilter", "priorityFilter"].forEach((id) =>
      NoticeInit.el(id).addEventListener("input", () => {
        AppInit.PAGE = 1;
        this.renderList();
      })
    );
  }

  toggleEnableSim() {
    NoticeInit.el("simEnable").addEventListener("change", () => {
      if (NoticeInit.el("simEnable").checked) NoticeInit.startSim();
      else NoticeInit.stopSim();
    });
    NoticeInit.el("simToggle").addEventListener("click", () => {
      const en = (NoticeInit.el("simEnable").checked =
        !NoticeInit.el("simEnable").checked);
      if (en) NoticeInit.startSim();
      else NoticeInit.stopSim();
      AppInit.toast(`Simulation ${en ? "enabled" : "disabled"}`);
    });
  }
}

new Notification();
