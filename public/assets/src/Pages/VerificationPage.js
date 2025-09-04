import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Verification from "../Classes/Verification.js";
import { clearAppData } from "../Utils/Session.js";

class VerificationPage {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderStatistics() {
    const domEl = document.querySelector(".verificationPage");
    if (!domEl) return;
    Verification.statistics();
  }

  renderRequestTable() {
    const data = Application.DATA.verifications;
    Verification.renderTable(data);

    // ---------- Search / filters ----------
    Verification.filterAndSearch(data);

    // ---------- Pagination controls ----------
    Verification.controlPagination(data);
  }

  userVerifiesVin() {
    const verifyBtn = document.getElementById("verify");
    if (!verifyBtn) return;
    verifyBtn.addEventListener("click", async () => {
      const vin = document
        .getElementById("vinInput")
        .value.trim()
        .toUpperCase();

      if (!Utility.validVIN(vin)) {
        Utility.toast(
          "VIN invalid — must be 11–17 chars and not include I,O,Q",
          "error"
        );
        return;
      }

      document.getElementById("verify").disabled = true;
      document.getElementById("verify").textContent = "Verifying...";

      const result = await Verification.verificationResult(vin);

      if (result || !result) {
        document.getElementById("verify").disabled = false;
        document.getElementById("verify").textContent = "Verify VIN";
      }
    });
  }

  recentVinLookup() {
    const history = Verification.loadHistory();
    Verification.verificationHistory(history);

    document.getElementById("q")?.addEventListener("input", () => {
      const filtered = history.filter((i) =>
        (i.vin + " " + i.title).toLowerCase().includes(q)
      );
      Verification.verificationHistory(filtered);
    });
  }

  clearLocalHistory() {
    document.getElementById("clearHistory")?.addEventListener("click", () => {
      Verification.clearHistory();
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
        let items = Verification.loadHistory();
        items = items.filter((x) => x.when !== when);
        Verification.saveHistory(items);
        Verification.verificationHistory(Verification.loadHistory());
        Utility.toast("Removed");
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

  eventDelegation() {
    document.querySelector("#reqTable")?.addEventListener("click", (e) => {
      const vbtn = e.target.closest("[data-view]");
      if (vbtn) {
        const id = vbtn.dataset.view;
        Verification.openDetail(id);
        return;
      }

      const apro = e.target.closest("[data-approve]");
      if (apro) {
        const id = apro.dataset.approve;
        Verification.processDecision(id, "approved");
      }

      const dec = e.target.closest("[data-decline]");
      if (dec) {
        const id = dec.dataset.decline;
        Verification.processDecision(id, "declined");
      }
    });
  }
}

new VerificationPage();
