import { clearAppData } from "../Utils/Session.js";
import Application from "./Application.js";
import Utility from "./Utility.js";

export default class Settings {
  static async updateUserprofile(formEl, message) {
    const formData = new FormData(formEl);

    const result = await Utility.confirm(message);

    if (result.isConfirmed) {
      const response = await DataTransfer(
        `${CONFIG.API}/user/update`,
        formData,
        "POST"
      );

      Utility.toast(
        response.message,
        response.status == 200 ? "success" : "error"
      );

      if (response.status == 200) {
        await clearPHPProfileSession();
        await clearAppData();
        await Application.initializeData();
      }

      return response;
    }
  }

  static activityTimeline(activityItems) {
    const activityList = document.getElementById("activityList");
    activityList.innerHTML = "";

    activityItems.forEach((it, idx) => {
      const el = document.createElement("div");
      el.className = "timeline-item";

      el.innerHTML = `
      <div class="timeline-marker"></div>
      <div class="timeline-content">
        <div class="timeline-header">
          <h4 class="timeline-title">${it.type}</h4>
          <span class="timeline-period">${it.period}</span>
        </div>
        ${it.title ? `<p class="timeline-description">${it.title}</p>` : ""}
      </div>
    `;
      activityList.appendChild(el);
    });
  }

  static updatePassword() {}
}
