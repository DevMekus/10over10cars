import Utility from "../Classes/Utility.js";
import Application from "../Classes/Application.js";
import Settings from "../Classes/Settings.js";
import { decryptJsToken } from "../Utils/Session.js";

/**
 * ProfilePage.js
 * Handles all profile-related functionalities including:
 * - Displaying user activities
 * - Updating profile information
 * - Updating user password
 * - Previewing avatar changes
 * - Smooth scrolling to edit forms
 *
 * Dependencies:
 * - Utility.js
 * - Application.js
 * - Settings.js
 * - decryptJsToken() from Session.js
 */

class ProfilePage {
  constructor() {
    this.initialize();
  }

  /**
   * Initialize the profile page
   * - Load application data
   * - Execute any class methods that need initialization
   */
  async initialize() {
    try {
      await Application.initializeData();
      Utility.runClassMethods(this, ["initialize"]);
    } catch (error) {
      console.error("Error initializing ProfilePage:", error);
      Utility.toast("Failed to initialize profile page.", "error");
    }
  }

  /**
   * Display the user's login activities in the activity timeline
   */
  displayUserActivities() {
    try {
      const activities = Application.DATA.loginActivity || [];
      const activityList = document.getElementById("activityList");
      if (!activityList) return;

      Settings.activityTimeline(activities);
    } catch (error) {
      console.error("Error displaying user activities:", error);
      Utility.toast("Failed to load user activities.", "error");
    }
  }

  /**
   * Setup the profile update form
   */
  updateUserprofile() {
    try {
      const formEl = Utility.el("profileForm");
      if (!formEl) return;

      formEl.addEventListener("submit", async (e) => {
        e.preventDefault();
        try {
          await Settings.updateUserprofile(e.target, "Update profile", false);
        } catch (err) {
          console.error("Error updating profile:", err);
          Utility.toast("Profile update failed.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing profile update form:", error);
    }
  }

  /**
   * Display current user sessions
   */
  async displayUserSession() {
    try {
      const formEl = Utility.el("passwordForm");
      if (!formEl) return;

      const token = await decryptJsToken();
      if (!token || !token.userid) throw new Error("Invalid user token");

      Settings.loadSessions(token.userid);
    } catch (error) {
      console.error("Error displaying user session:", error);
      Utility.toast("Failed to load user sessions.", "error");
    }
  }

  /**
   * Setup password update form
   */
  updateUserPassword() {
    try {
      const formEl = Utility.el("passwordForm");
      if (!formEl) return;

      formEl.addEventListener("submit", async (e) => {
        e.preventDefault();
        try {
          await Settings.updateUserprofile(e.target, "Update password", true);
        } catch (err) {
          console.error("Error updating password:", err);
          Utility.toast("Password update failed.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing password form:", error);
    }
  }

  /**
   * Scroll smoothly to profile edit form on edit button click
   */
  editProfileButtonClick() {
    try {
      const editBtn = Utility.el("editBtn");
      const profileForm = Utility.el("profileForm");
      if (!editBtn || !profileForm) return;

      editBtn.addEventListener("click", () => {
        window.scrollTo({
          top: profileForm.offsetTop - 80,
          behavior: "smooth",
        });

        const fullnameInput = profileForm.querySelector(
          'input[name="fullname"]'
        );
        fullnameInput?.focus();
      });
    } catch (error) {
      console.error("Error setting up edit profile button:", error);
    }
  }

  /**
   * Preview avatar image when selected by the user
   */
  profileAvatarPreview() {
    try {
      const dpUpload = Utility.el("dp-upload");
      const avatarPreview = Utility.el("avatarPreview2");

      if (!dpUpload || !avatarPreview) return;

      dpUpload.addEventListener("change", (e) => {
        try {
          const file = e.target.files[0];
          if (!file) return;

          const url = URL.createObjectURL(file);
          avatarPreview.src = url;

          Utility.toast("Avatar preview updated", "info");
        } catch (innerError) {
          console.error("Error updating avatar preview:", innerError);
          Utility.toast("Failed to preview avatar.", "error");
        }
      });
    } catch (error) {
      console.error("Error initializing avatar preview:", error);
    }
  }
}

new ProfilePage();
