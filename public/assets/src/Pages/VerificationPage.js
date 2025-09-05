import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Verification from "../Classes/Verification.js";

/**
 * VerificationPage.js
 * Handles vehicle verification page functionalities including:
 * - Rendering verification statistics
 * - Displaying verification request table
 * - VIN verification by user
 * - Managing verification history
 * - Event delegation for approval/decline and quick retry
 *
 * Dependencies:
 * - Utility.js
 * - Application.js
 * - Verification.js
 * - Session.js (clearAppData)
 */

class VerificationPage {
  constructor() {
    this.initialize();
  }

  /**
   * Initialize the verification page
   */
  async initialize() {
    try {
      await Application.initializeData();
      Utility.runClassMethods(this, ["initialize"]);
    } catch (error) {
      console.error("Error initializing VerificationPage:", error);
      Utility.toast("Failed to initialize verification page.", "error");
    }
  }

  /**
   * Render verification statistics
   */
  renderStatistics() {
    try {
      const domEl = document.querySelector(".verificationPage");
      if (!domEl) return;

      Verification.statistics();
    } catch (error) {
      console.error("Error rendering verification statistics:", error);
      Utility.toast("Failed to load verification statistics.", "error");
    }
  }

  /**
   * Render verification request table with filters and pagination
   */
  renderRequestTable() {
    try {
      const data = Application.DATA.verifications;
      if (!data) return;

      Verification.renderTable(data);

      // Initialize search and filters
      Verification.filterAndSearch(data);

      // Initialize pagination controls
      Verification.controlPagination(data);
    } catch (error) {
      console.error("Error rendering verification request table:", error);
      Utility.toast("Failed to load verification requests.", "error");
    }
  }

  /**
   * Handle VIN verification by user
   */
  userVerifiesVin() {
    try {
      const verifyBtn = document.getElementById("verify");
      if (!verifyBtn) return;

      verifyBtn.addEventListener("click", async () => {
        try {
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

          verifyBtn.disabled = true;
          verifyBtn.textContent = "Verifying...";

          await Verification.verificationResult(vin);

          verifyBtn.disabled = false;
          verifyBtn.textContent = "Verify VIN";
        } catch (innerError) {
          console.error("Error during VIN verification:", innerError);
          verifyBtn.disabled = false;
          verifyBtn.textContent = "Verify VIN";
          Utility.toast("Failed to verify VIN.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing VIN verification:", error);
    }
  }

  /**
   * Display and filter recent VIN lookup history
   */
  recentVinLookup() {
    try {
      const history = Verification.loadHistory();
      Verification.verificationHistory(history);

      document.getElementById("q")?.addEventListener("input", () => {
        try {
          const query = document.getElementById("q").value.toLowerCase();
          const filtered = history.filter((i) =>
            (i.vin + " " + i.title).toLowerCase().includes(query)
          );
          Verification.verificationHistory(filtered);
        } catch (innerError) {
          console.error("Error filtering verification history:", innerError);
        }
      });
    } catch (error) {
      console.error("Error loading recent VIN history:", error);
    }
  }

  /**
   * Clear local verification history
   */
  clearLocalHistory() {
    try {
      document.getElementById("clearHistory")?.addEventListener("click", () => {
        try {
          Verification.clearHistory();
          Utility.toast("Verification history cleared.", "info");
        } catch (innerError) {
          console.error("Error clearing verification history:", innerError);
        }
      });
    } catch (error) {
      console.error("Error initializing clear history button:", error);
    }
  }

  /**
   * Quick retry or delete VIN search from history
   */
  quickRetryVINSearch() {
    try {
      document.addEventListener("click", (e) => {
        try {
          const retryBtn = e.target.closest("[data-retry]");
          if (retryBtn) {
            const vin = retryBtn.dataset.retry;
            document.getElementById("vinInput").value = vin;
            document.getElementById("verify").click();
            return;
          }

          const delBtn = e.target.closest("[data-del]");
          if (delBtn) {
            const when = delBtn.dataset.del;
            let items = Verification.loadHistory();
            items = items.filter((x) => x.when !== when);
            Verification.saveHistory(items);
            Verification.verificationHistory(Verification.loadHistory());
            Utility.toast("Removed from history.", "info");
            return;
          }

          if (e.target.matches("[data-close]")) {
            const targetEl = document.getElementById(e.target.dataset.close);
            targetEl.classList.remove("open");
            targetEl.setAttribute("aria-hidden", "true");
          }
        } catch (innerError) {
          console.error("Error handling quick retry VIN search:", innerError);
        }
      });
    } catch (error) {
      console.error("Error initializing quick retry VIN search:", error);
    }
  }

  /**
   * Delegate verification table events (view, approve, decline)
   */
  eventDelegation() {
    try {
      const table = document.querySelector("#reqTable");
      if (!table) return;

      table.addEventListener("click", (e) => {
        try {
          const viewBtn = e.target.closest("[data-view]");
          if (viewBtn) {
            Verification.openDetail(viewBtn.dataset.view);
            return;
          }

          const approveBtn = e.target.closest("[data-approve]");
          if (approveBtn) {
            Verification.processDecision(
              approveBtn.dataset.approve,
              "approved"
            );
            return;
          }

          const declineBtn = e.target.closest("[data-decline]");
          if (declineBtn) {
            Verification.processDecision(
              declineBtn.dataset.decline,
              "declined"
            );
          }
        } catch (innerError) {
          console.error(
            "Error handling verification table events:",
            innerError
          );
        }
      });
    } catch (error) {
      console.error(
        "Error initializing verification table event delegation:",
        error
      );
    }
  }
}

new VerificationPage();
