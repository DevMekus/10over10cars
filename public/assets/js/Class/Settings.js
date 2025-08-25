import Utility from "./Utility.js";
import AppInit from "./Application.js";

export default class SettingsInit {
  static el = (id) => document.getElementById(id);
  static audit = [];
  static PROFILE_KEY = "tenoverten_profile_v1";
  static ACT_KEY = "tenoverten_activity_v1";

  static profile =
    JSON.parse(localStorage.getItem(SettingsInit.PROFILE_KEY) || "null") ||
    AppInit.DATA.profile;

  static activity =
    JSON.parse(localStorage.getItem(SettingsInit.ACT_KEY) || "null") ||
    AppInit.DATA.loginActivity.slice();

  static logAction(s) {
    SettingsInit.audit.unshift({
      when: new Date().toISOString().slice(0, 19).replace("T", " "),
      text: s,
    });
    new Settings().renderAudit();
  }

  static openModal(id) {
    SettingsInit.el(id).classList.add("open");
  }
  static closeModal(id) {
    SettingsInit.el(id).classList.remove("open");
  }

  static saveProfile() {
    localStorage.setItem(
      SettingsInit.PROFILE_KEY,
      JSON.stringify(SettingsInit.profile)
    );
  }
  static saveActivity() {
    localStorage.setItem(
      SettingsInit.ACT_KEY,
      JSON.stringify(SettingsInit.activity)
    );
  }

  static applyTheme(t) {
    document.documentElement.setAttribute("data-theme", t);
    localStorage.setItem("admin_theme", t);
  }
}

class Settings {
  constructor() {
    this.initialize();
    window.closeModal = SettingsInit.closeModal;
    window.openModal = SettingsInit.openModal;
    SettingsInit.saveProfile();
    SettingsInit.saveActivity();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  tabSwitcher() {
    document.querySelectorAll(".tab").forEach((tab) =>
      tab.addEventListener("click", () => {
        document
          .querySelectorAll(".tab")
          .forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");
        const name = tab.dataset.tab;
        document
          .querySelectorAll(".tab-panel")
          .forEach((p) => (p.style.display = p.id === name ? "block" : "none"));
      })
    );
  }

  profileAvartarPreview() {
    SettingsInit.el("avatarInput")?.addEventListener("change", (e) => {
      const f = e.target.files[0];
      if (!f) return;
      const url = URL.createObjectURL(f);
      SettingsInit.el("avatarPreview").src = url;
      AppInit.toast("Avatar preview updated", "info");
    });
  }

  changePasswordModal() {
    SettingsInit.el("changePasswordBtn")?.addEventListener("click", () => {
      SettingsInit.el("passwordModal").classList.add("open");
      SettingsInit.el("passwordModal").setAttribute("aria-hidden", "false");
    });
    document.querySelectorAll("[data-close]").forEach((b) =>
      b.addEventListener("click", () => {
        document.getElementById(b.dataset.close).classList.remove("open");
      })
    );
  }

  passwordValidation() {
    // password form validation
    SettingsInit.el("passwordForm")?.addEventListener("submit", (e) => {
      e.preventDefault();
      const cur = SettingsInit.el("curPass").value.trim();
      const n = SettingsInit.el("newPass").value.trim();
      const c = SettingsInit.el("confirmPass").value.trim();
      if (!cur || !n) {
        AppInit.toast("Fill all fields", "error");
        return;
      }
      if (n.length < 8) {
        AppInit.toast("New password must be at least 8 characters", "error");
        return;
      }
      if (n !== c) {
        toast("Passwords do not match", "error");
        return;
      }
      // demo: pretend to change
      SettingsInit.el("passwordModal").classList.remove("open");
      AppInit.toast("Password changed (demo)", "success");
      SettingsInit.el("passwordForm").reset();
    });
  }

  renderLoginActivity() {
    const t = SettingsInit.el("loginActivity");
    if (!t) return;
    t.innerHTML = "";
    AppInit.DATA.loginActivity.forEach((l) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td>${l.when}</td><td>${l.ip}</td><td>${l.device}</td><td><button class=\"btn btn-ghost\" data-revoke='${l.ip}'>Revoke</button></td>`;
      t.appendChild(tr);
    });
  }

  renderAudit() {
    const a = SettingsInit.el("auditLog");
    if (!a) return;
    a.innerHTML = "";
    SettingsInit.audit.slice(0, 50).forEach((it) => {
      const div = document.createElement("div");
      div.style.padding = "8px 0";
      div.innerHTML = `<div style="font-weight:700">${it.text}</div><div class="small muted">${it.when}</div>`;
      a.appendChild(div);
    });
  }

  saveAllActions() {
    SettingsInit.el("profileSave")?.addEventListener("click", () => {
      // basic validation
      const name = SettingsInit.el("fullname").value.trim();
      const email = SettingsInit.el("email").value.trim();
      if (!name || !email) {
        AppInit.toast("Name and email required", "error");
        return;
      }
      // save to localStorage demo
      const profile = {
        name,
        email,
        phone: SettingsInit.el("phone").value.trim(),
        location: SettingsInit.el("location").value.trim(),
        avatar: SettingsInit.el("avatarPreview").src,
      };
      localStorage.setItem("admin_profile", JSON.stringify(profile));
      SettingsInit.logAction("Profile updated");
      AppInit.toast("Profile saved (demo)", "success");
    });
  }

  applyThemeAndPreference() {
    SettingsInit.el("themeSelect")?.addEventListener("change", () =>
      applyTheme(SettingsInit.el("themeSelect").value)
    );
    SettingsInit.el("prefsSave")?.addEventListener("click", () => {
      const prefs = {
        theme: SettingsInit.el("themeSelect").value,
        lang: SettingsInit.el("langSelect").value,
        email: SettingsInit.el("emailNotif").checked,
        sms: SettingsInit.el("smsNotif").checked,
        push: SettingsInit.el("pushNotif").checked,
      };
      localStorage.setItem("admin_prefs", JSON.stringify(prefs));
      applyTheme(prefs.theme);
      logAction("Preferences updated");
      toast("Preferences saved", "success");
    });
  }

  resetPreferences() {
    SettingsInit.el("prefsReset")?.addEventListener("click", () => {
      localStorage.removeItem("admin_prefs");
      SettingsInit.el("themeSelect").value = "light";
      SettingsInit.el("langSelect").value = "en";
      SettingsInit.el("emailNotif").checked = true;
      SettingsInit.el("smsNotif").checked = false;
      SettingsInit.el("pushNotif").checked = false;
      AppInit.toast("Preferences reset", "info");
    });
  }

  twoFactotAuthentication() {
    SettingsInit.el("securitySave")?.addEventListener("click", () => {
      const two = SettingsInit.el("toggle2fa").checked;
      localStorage.setItem("admin_2fa", two ? "1" : "0");
      SettingsInit.logAction(`2FA ${two ? "enabled" : "disabled"}`);
      AppInit.toast("Security settings saved", "success");
    });
  }

  revokeSessions() {
    SettingsInit.el("revokeSessions")?.addEventListener("click", () => {
      // demo revoke all
      SettingsInit.el("confirmTitle").textContent = "Revoke sessions";
      SettingsInit.el("confirmBody").textContent =
        "Revoke all active sessions for this account? This will sign out other devices.";
      SettingsInit.el("confirmModal").classList.add("open");
      SettingsInit.el("confirmOk").onclick = () => {
        SettingsInit.el("confirmModal").classList.remove("open");
        SettingsInit.logAction("Revoked sessions");
        AppInit.toast("All sessions revoked (demo)", "success");
      };
    });
  }

  savePlatForm() {
    SettingsInit.el("platformSave")?.addEventListener("click", () => {
      const cfg = {
        plan: SettingsInit.el("defaultPlan").value,
        limit: SettingsInit.el("txLimit").value,
        rules: SettingsInit.el("dealerRules").value,
      };
      localStorage.setItem("admin_platform", JSON.stringify(cfg));
      SettingsInit.logAction("Platform settings saved");
      AppInit.toast("Platform settings saved", "success");
    });
  }

  platformFormReset() {
    SettingsInit.el("platformReset")?.addEventListener("click", () => {
      SettingsInit.el("defaultPlan").value = "Standard";
      SettingsInit.el("txLimit").value = "";
      SettingsInit.el("dealerRules").value = "";
      localStorage.removeItem("admin_platform");
      AppInit.toast("Platform reset to defaults", "info");
    });
  }

  resetPlatForm() {
    if (!SettingsInit.el("resetPlatformBtn")) return;

    SettingsInit.el("resetPlatformBtn").addEventListener("click", () => {
      SettingsInit.el("confirmTitle").textContent = "Reset platform settings";
      SettingsInit.el("confirmBody").textContent =
        "Are you sure you want to reset platform settings to defaults?";
      SettingsInit.el("confirmModal").classList.add("open");
      SettingsInit.el("confirmOk").onclick = () => {
        SettingsInit.el("confirmModal").classList.remove("open");
        localStorage.removeItem("admin_platform");
        SettingsInit.logAction("Platform settings reset");
        AppInit.toast("Platform settings reset (demo)", "success");
      };
    });
  }
  exportBackup() {
    SettingsInit.el("exportBackup")?.addEventListener("click", () => {
      const dump = {
        profile: localStorage.getItem("admin_profile"),
        prefs: localStorage.getItem("admin_prefs"),
        platform: localStorage.getItem("admin_platform"),
      };
      const blob = new Blob([JSON.stringify(dump, null, 2)], {
        type: "application/json",
      });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "10over10-backup.json";
      a.click();
      URL.revokeObjectURL(url);
      AppInit.toast("Backup exported (demo)", "success");
      SettingsInit.logAction("Exported system backup");
    });
  }

  deleteAccount() {
    if (!SettingsInit.el("deleteAccountBtn")) return;
    SettingsInit.el("deleteAccountBtn").addEventListener("click", () => {
      SettingsInit.el("confirmTitle").textContent = "Delete account";
      SettingsInit.el("confirmBody").textContent =
        "This will delete the admin account permanently (demo). Continue?";
      SettingsInit.el("confirmModal").classList.add("open");
      SettingsInit.el("confirmOk").onclick = () => {
        SettingsInit.el("confirmModal").classList.remove("open");
        AppInit.toast("Admin account deleted (demo)", "success");
        SettingsInit.logAction("Deleted admin account");
      };
    });
  }
  loadStored() {
    const p = JSON.parse(localStorage.getItem("admin_profile") || "{}");
    if (p.name) SettingsInit.el("fullname").value = p.name;
    if (p.email) SettingsInit.el("email").value = p.email;
    if (p.phone) SettingsInit.el("phone").value = p.phone;
    if (p.location) SettingsInit.el("location").value = p.location;
    if (p.avatar) SettingsInit.el("avatarPreview").src = p.avatar;
    const prefs = JSON.parse(localStorage.getItem("admin_prefs") || "{}");
    if (prefs.theme) SettingsInit.el("themeSelect").value = prefs.theme;
    if (prefs.lang) SettingsInit.el("langSelect").value = prefs.lang;

    if (!SettingsInit.el("emailNotif")) return;
    SettingsInit.el("emailNotif").checked = !!prefs.email;
    SettingsInit.el("smsNotif").checked = !!prefs.sms;
    SettingsInit.el("pushNotif").checked = !!prefs.push;
    const pf = JSON.parse(localStorage.getItem("admin_platform") || "{}");
    if (pf.plan) SettingsInit.el("defaultPlan").value = pf.plan;
    if (pf.limit) SettingsInit.el("txLimit").value = pf.limit;
    if (pf.rules) SettingsInit.el("dealerRules").value = pf.rules;
    const two = localStorage.getItem("admin_2fa");
    if (two) SettingsInit.el("toggle2fa").checked = two === "1";
  }

  revokeLoginAction() {
    document.addEventListener("click", (e) => {
      const r = e.target.closest("[data-revoke]");
      if (r) {
        const ip = r.dataset.revoke; // demo remove from activity
        const idx = AppInit.DATA.loginActivity.findIndex((x) => x.ip === ip);
        if (idx > -1) {
          AppInit.DATA.loginActivity.splice(idx, 1);
          this.renderLoginActivity();
          SettingsInit.logAction(`Revoked session ${ip}`);
          AppInit.toast("Session revoked", "success");
        }
      }
    });
  }

  //_____User profile Activity
  populateProfile() {
    const profile = SettingsInit.profile;

    SettingsInit.el("displayName").textContent = profile.fullname;
    SettingsInit.el("displayEmail").textContent = profile.email;
    SettingsInit.el("displayPhone").textContent = profile.phone;
    SettingsInit.el("displayLocation").textContent = profile.location;
    SettingsInit.el("displayMember").textContent = profile.memberSince;
    SettingsInit.el("avatarImg").src = profile.avatar;
    const f = SettingsInit.el("profileForm");
    f.fullname.value = profile.fullname;
    f.email.value = profile.email;
    f.phone.value = profile.phone;
    f.location.value = profile.location;
    f.avatar.value = profile.avatar;
  }

  renderUserActivity(list = SettingsInit.activity) {
    const mount = SettingsInit.el("activityList");
    mount.innerHTML = "";
    list.slice(0, 20).forEach((a) => {
      const div = document.createElement("div");
      div.className = "activity-item";
      div.innerHTML = `<div class="left"><div style="width:48px;height:48px;border-radius:8px;background:linear-gradient(135deg,var(--primary),var(--accent));display:grid;place-items:center;color:#fff;font-weight:800">${
        a.type[0]
      }</div><div><strong style="display:block">${
        a.title
      }</strong><div class="muted small">${
        a.time
      }</div></div></div><div><span class="badge ${
        a.status === "success" ? "success" : "pending"
      }">${a.status}</span></div>`;
      mount.appendChild(div);
    });
  }

  userProfileFormSave() {
    SettingsInit.el("profileForm").addEventListener("submit", (e) => {
      e.preventDefault();
      const f = e.target;
      SettingsInit.profile.fullname = f.fullname.value.trim();
      SettingsInit.profile.email = f.email.value.trim();
      SettingsInit.profile.phone = f.phone.value.trim();
      SettingsInit.profile.location = f.location.value.trim();
      SettingsInit.profile.avatar = f.avatar.value.trim() || profile.avatar;
      SettingsInit.saveProfile();
      this.populateProfile();
      AppInit.toast("Profile saved", "success");
    });

    SettingsInit.el("resetProfile").addEventListener("click", () => {
      this.populateProfile();
      AppInit.toast("Changes reverted", "info");
    });
  }

  editProfileButtonClick() {
    SettingsInit.el("editProfileBtn").addEventListener("click", () => {
      window.scrollTo({
        top: document.querySelector("#profileForm").offsetTop - 80,
        behavior: "smooth",
      });
      SettingsInit.el("profileForm")
        .querySelector('input[name="fullname"]')
        .focus();
    });
  }

  userChangePassword() {
    SettingsInit.el("changePassBtn").addEventListener("click", () =>
      SettingsInit.openModal("passModal")
    );
    SettingsInit.el("passForm").addEventListener("submit", (e) => {
      e.preventDefault();
      const fd = new FormData(e.target);
      const cur = fd.get("current");
      const nw = fd.get("newp");
      const cn = fd.get("confirm");
      if (nw.length < 8) {
        AppInit.toast("Password must be at least 8 characters", "error");
        return;
      }
      if (nw !== cn) {
        AppInit.toast("Passwords do not match", "error");
        return;
      } // demo: accept
      AppInit.toast("Password updated (demo)", "success");
      SettingsInit.closeModal("passModal");
      e.target.reset();
    });
  }

  userDeleteAccount() {
    SettingsInit.el("deleteAccount").addEventListener("click", () =>
      SettingsInit.openModal("delModal")
    );
    SettingsInit.el("confirmDelete").addEventListener("click", () => {
      // demo: clear storage
      localStorage.removeItem(SettingsInit.PROFILE_KEY);
      localStorage.removeItem(SettingsInit.ACT_KEY);
      AppInit.toast("Account data cleared (demo)", "success");
      SettingsInit.closeModal("delModal");
      setTimeout(() => location.reload(), 800);
    });
  }

  userActivityControl() {
    if (!SettingsInit.el("q")) return;
    SettingsInit.el("q").placeholder = "Search activity";
    SettingsInit.el("q").addEventListener("input", (e) => {
      const q = e.target.value.trim().toLowerCase();
      if (!q) return this.renderUserActivity();
      this.renderUserActivity(
        SettingsInit.activity.filter((a) =>
          (a.title + " " + a.type).toLowerCase().includes(q)
        )
      );
    });
    SettingsInit.el("clearActivity").addEventListener("click", () => {
      if (!confirm("Clear activity (demo)?")) return;
      activity.length = 0;
      SettingsInit.saveActivity();
      this.renderUserActivity();
      AppInit.toast("Activity cleared", "info");
    });
  }

  avatarUploadViaURL() {
    SettingsInit.el("profileForm").avatar.addEventListener("change", (e) => {
      const v = e.target.value.trim();
      if (v) SettingsInit.el("avatarImg").src = v;
    });
  }
}

new Settings();
