import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Settings from "../Classes/Settings.js";
import { decryptJsToken } from "../Utils/Session.js";

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
      await Settings.updateUserprofile(e.target, "Update profile", false);
    });
  }

  async displayUserSession() {
    const formEl = Utility.el("passwordForm");
    if (!formEl) return;
    const token = await decryptJsToken();
    Settings.loadSessions(token.userid);
  }

  updateUserPassword() {
    const formEl = Utility.el("passwordForm");
    if (!formEl) return;

    formEl.addEventListener("submit", async (e) => {
      e.preventDefault();
      await Settings.updateUserprofile(e.target, "Update password", true);
    });
  }

  editProfileButtonClick() {
    Utility.el("editBtn").addEventListener("click", () => {
      window.scrollTo({
        top: document.querySelector("#profileForm").offsetTop - 80,
        behavior: "smooth",
      });
      Utility.el("profileForm").querySelector('input[name="fullname"]').focus();
    });
  }

  profileAvartarPreview() {
    Utility.el("dp-upload")?.addEventListener("change", (e) => {
      const f = e.target.files[0];
      if (!f) return;
      const url = URL.createObjectURL(f);
      Utility.el("avatarPreview2").src = url;
      Utility.toast("Avatar preview updated", "info");
    });
  }
}

new ProfilePage();
