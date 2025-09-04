import { CONFIG } from "../Utils/config.js";
import Utility from "../Classes/Utility.js";
import { DataTransfer } from "../Utils/api.js";
import Overview from "../Classes/Overview.js";
import Application from "../Classes/Application.js";

class OverviewPage {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  renderPageStats() {
    Overview.renderStats();
    Overview.renderChart();
    //---recentActivity

    const logs = Application.DATA.loginActivity;
    Overview.renderRecent(logs);

    //---recent Verifications
    const verifications = Application.DATA.verifications;

    Overview.renderRecentverification(verifications);

    //---recent transactions
    const transactions = Application.DATA.verifications;

    Overview.renderRecentTransaction(transactions);
  }
}

new OverviewPage();
