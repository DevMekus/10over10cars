import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Settings from "../Classes/Settings.js";

class ProfilePage {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await Application.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  displayUserActivities() {
    const activities = Application.DATA.loginActivity || [];
    const activityList = document.getElementById("activityList");
    if (!activityList) return;

    Settings.activityTimeline(activities);
  }

  updateUserprofile() {
    const formEl = Utility.el("profileForm");
    if (!formEl) return;
    formEl.addEventListener("submit", async (e) => {
      e.preventDefault();
      await Settings.updateUserprofile(e.target, "Update profile");
    });
  }

  updateUserPassword() {
    const formEl = Utility.el("passwordForm");
    if (!formEl) return;
    formEl.addEventListener("submit", async (e) => {
      e.preventDefault();
      await Settings.updateUserprofile(e.target, "Update password");
    });
  }
}

new ProfilePage();
