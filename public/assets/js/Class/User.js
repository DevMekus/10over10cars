import Utility from "./Utility.js";
import SessionManager from "./SessionManager.js";

export default class User {
  static user = null;
  static userData = null;

  static statuses = ["pending", "active", "suspended"];

  static async getUser(id = "") {
    const url =
      id == ""
        ? `${Utility.API_ROUTE}/admin/profile`
        : `${Utility.API_ROUTE}/user/profile/${id}`;

    return await Utility.fetchData(url);
  }

  static user_data() {
    return sessionStorage.getItem("user")
      ? JSON.parse(atob(sessionStorage.getItem("user")))
      : null;
  }

  static user_id() {
    const data = User.user_data();
    return data ? data.id : null;
  }

  static user_role() {
    const data = User.user_data();
    return data ? data.role : null;
  }

  static isLoggedIn() {
    return sessionStorage.getItem("token") ?? false;
  }

  static deleteUser() {
    const btns = document.querySelectorAll(".delete");
    btns.forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        const result = await Swal.fire({
          title: "Delete this User!",
          text: "Do you wish to continue?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Continue!",
        });
        if (result.isConfirmed) {
          const response = await Utility.fetchData(
            `${Utility.API_ROUTE}/admin/profile/${btn.dataset.id}`,
            {},
            "DELETE"
          );

          Swal.fire(
            response.status == 200 ? "Success!" : "Error",
            `${response.message}`,
            response.status == 200 ? "success" : "error"
          );

          if (response.status == 200) {
            const user = new UserManager();
            user.userDataManagement();
            user.security_management();
          }
        }
      });
    });
  }

  static updateStatus() {
    const btns = document.querySelectorAll(".change_status");

    btns.forEach((btn) => {
      btn.addEventListener("change", async (e) => {
        const result = await Swal.fire({
          title: "Update this User!",
          text: "Do you wish to continue?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Continue!",
        });
        if (result.isConfirmed) {
          const data = new FormData();
          data.append("account_status", btn.value);
          const response = await Utility.fetchData(
            `${Utility.API_ROUTE}/user/profile/${btn.dataset.id}`,
            data,
            "POST"
          );
          Swal.fire(
            response.status == 200 ? "Success!" : "Error",
            `${response.message}`,
            response.status == 200 ? "success" : "error"
          );

          if (response.status == 200) {
            const user = new UserManager();
            user.userDataManagement();
            user.security_management();
          }
        }
      });
    });
  }

  static renderUserTable(users) {
    const dataContainer = document.getElementById("data-container");

    if (users.length == 0) {
      dataContainer.style.display = "none";
      document.getElementById("no-data").style.display = "block";
    }

    const pageSize = 10;
    let currentPage = 1;

    function renderData(data) {
      const container = document.getElementById("userTbody");
      container.innerHTML =
        "<tr class='skeleton-row'><td colspan='7'></td></tr>";
      const pagination = document.getElementById("pagination");
      const noRecords = document.getElementById("no-records");
      const {
        pagedData,
        totalPages,
        currentPage: page,
        hasNext,
        hasPrev,
        generateButtons,
      } = Utility.paginate(data, currentPage, pageSize);

      currentPage = page; // update global page state

      setTimeout(() => {
        container.innerHTML = "";
        if (data.length === 0) {
          pagination.innerHTML = "";
          noRecords.style.display = "block";
          return;
        } else {
          noRecords.style.display = "none";
          pagedData.forEach((u) => {
            const statuses = ["pending", "active", "suspended"];
            const row = document.createElement("tr");
            row.innerHTML = `
              <td><input type="checkbox"></td>
              <td class="user-name"><img src="${
                u.avatar ??
                "https://www.shutterstock.com/image-vector/avatar-gender-neutral-silhouette-vector-600nw-2470054311.jpg"
              }" class="avatar" /> ${u.fullname}</td>
              <td>${u.email_address}</td>
              <td>${u.role_id == "1" ? "Admin" : "User"}</td>
              <td><span class="status ${u.account_status}">
              ${Utility.toTitleCase(u.account_status)}</span></td>
              <td>${u.create_date}</td>
              <td>
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
                  <select name="account_status" class="form-select change_status form-select-sm w-100 w-sm-auto" style="max-width: 80px; padding: 2px 4px;" 
                  data-id="${u.userid}">
                    ${User.statuses
                      .map(
                        (status) =>
                          `<option value="${status}" ${
                            u.account_status == status ? "selected" : ""
                          }>${status}</option>`
                      )
                      .join("")}
                  </select>

                  <a href="manage?uid=${
                    u.userid
                  }" class="btn btn-sm btn-primary">
                    <i class='fa fa-eye'></i> view
                  </a>

                  <button class="btn btn-sm btn-outline-error delete" data-id="${
                    u.userid
                  }">
                    <i class='fa fa-times'></i>
                  </button>
                </div>

              </td>
            `;
            container.appendChild(row);
            pagination.innerHTML = generateButtons("onPageClick");

            // Make this function global for onclick in generateButtons
            window.onPageClick = function (page) {
              currentPage = page;
              renderData(data);
            };

            Utility.downloadPDF("users", "landscape");
            Utility.exportToCSV(data, "users.csv");
            User.deleteUser();
            User.updateStatus();
          });
        }
      }, Utility.loadTimeout);
    }

    function filterRecords() {
      const search = document.getElementById("searchInput").value.toLowerCase();
      const role = document.getElementById("roleFilter").value;
      const status = document.getElementById("statusFilter").value;

      let filtered = users.filter(
        (u) =>
          (u.fullname.toLowerCase().includes(search) ||
            u.email_address.toLowerCase().includes(search)) &&
          (!role || u.role_id === role) &&
          (!status || u.account_status === status)
      );

      renderData(filtered);
    }

    document
      .getElementById("searchInput")
      .addEventListener("input", filterRecords);
    document
      .getElementById("roleFilter")
      .addEventListener("change", filterRecords);
    document
      .getElementById("statusFilter")
      .addEventListener("change", filterRecords);
    filterRecords();
  }

  static renderDealersTable(dealers) {
    const dataContainer = document.getElementById("data-container");
    if (dealers.length == 0) {
      dataContainer.style.display = "none";
      document.getElementById("no-data").style.display = "block";
    }
    const pageSize = 10;
    let currentPage = 1;

    function renderData(data) {
      const container = document.getElementById("dealerTbody");
      container.innerHTML =
        "<tr class='skeleton-row'><td colspan='11'></td></tr>";
      const pagination = document.getElementById("pagination");
      const noRecords = document.getElementById("no-records");
      const {
        pagedData,
        totalPages,
        currentPage: page,
        hasNext,
        hasPrev,
        generateButtons,
      } = Utility.paginate(data, currentPage, pageSize);

      currentPage = page; // update global page state

      setTimeout(() => {
        container.innerHTML = "";
        if (data.length === 0) {
          pagination.innerHTML = "";
          noRecords.style.display = "block";
          return;
        } else {
          noRecords.style.display = "none";
          pagedData.forEach((u) => {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td><input type="checkbox"></td>
              <td class="user-name"><img src="${
                u.logo ??
                "https://www.shutterstock.com/image-vector/avatar-gender-neutral-silhouette-vector-600nw-2470054311.jpg"
              }" class="avatar" /> ${u.dealer_name}</td>             
              <td>${u.city}</td>
              <td>${u.state_}</td>
              <td>${u.country}</td>
              <td>45</td>
              <td><span class="status ${u.status}">
              ${Utility.toTitleCase(u.status)}</span></td>
              <td>${u.create_date}</td>
              <td>
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
                  <select class="form-select change_status form-select-sm w-100 w-sm-auto" style="max-width: 80px; padding: 2px 4px;" 
                  data-id="${u.userid}">
                    ${User.statuses
                      .map(
                        (status) =>
                          `<option value="${status}" ${
                            u.status == status ? "selected" : ""
                          }>${Utility.toTitleCase(status)}</option>`
                      )
                      .join("")}
                  </select>

                  <a href="manage?uid=${
                    u.userid
                  }" class="btn btn-sm btn-primary">
                    <i class='fa fa-eye'></i> view
                  </a>

                  <button class="btn btn-sm btn-outline-error delete" data-id="${
                    u.userid
                  }">
                    <i class='fa fa-times'></i>
                  </button>
                </div>
              </td>
            `;
            container.appendChild(row);
            pagination.innerHTML = generateButtons("onPageClick");

            // Make this function global for onclick in generateButtons
            window.onPageClick = function (page) {
              currentPage = page;
              renderData(data);
            };
          });
        }
        Utility.downloadPDF("dealers", "landscape");
        User.updateDealer();
        User.deleteDealer();
        Utility.exportToCSV(data, "dealer.csv");
      }, Utility.loadTimeout);
    }
    function filterRecords() {
      const search = document.getElementById("searchInput").value.toLowerCase();
      const status = document.getElementById("statusFilter").value;

      let filtered = dealers.filter(
        (u) =>
          (u.dealer_name.toLowerCase().includes(search) ||
            u.email_address.toLowerCase().includes(search)) &&
          (!status || u.status === status)
      );

      renderData(filtered);
    }

    document
      .getElementById("searchInput")
      .addEventListener("input", filterRecords);

    document
      .getElementById("statusFilter")
      .addEventListener("change", filterRecords);
    filterRecords();
  }

  static deleteDealer() {
    const btns = document.querySelectorAll(".delete");
    btns.forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        const result = await Swal.fire({
          title: "Delete this User!",
          text: "Do you wish to continue?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Continue!",
        });
        if (result.isConfirmed) {
          const dealer = btn.dataset.id;

          const response = await Utility.fetchData(
            `${Utility.API_ROUTE}/admin/profile/dealers/${dealer}`,
            {},
            "DELETE"
          );

          Swal.fire(
            response.status == 200 ? "Success!" : "Error",
            `${response.message}`,
            response.status == 200 ? "success" : "error"
          );

          response.status == 200 && new UserManager().dealerDataManagement();
        }
      });
    });
  }

  static updateDealer() {
    const btns = document.querySelectorAll(".change_status");

    btns.forEach((btn) => {
      btn.addEventListener("change", async (e) => {
        const result = await Swal.fire({
          title: "Update this Dealer!",
          text: "Do you wish to continue?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Continue!",
        });
        if (result.isConfirmed) {
          const response = await Utility.fetchData(
            `${Utility.API_ROUTE}/user/profile/dealers/${btn.dataset.id}`,
            { status: btn.value },
            "PATCH"
          );

          Swal.fire(
            response.status == 200 ? "Success!" : "Error",
            `${response.message}`,
            response.status == 200 ? "success" : "error"
          );

          response.status == 200 && new UserManager().dealerDataManagement();
        }
      });
    });
  }

  static renderLogData(logData) {
    const pageSize = 10;
    let currentPage = 1;

    function renderData(data) {
      const container = document.getElementById("logTbody");
      container.innerHTML =
        "<tr class='skeleton-row'><td colspan='7'></td></tr>";
      const pagination = document.getElementById("paginationLog");
      const noRecords = document.getElementById("no-logRecords");
      const {
        pagedData,
        totalPages,
        currentPage: page,
        hasNext,
        hasPrev,
        generateButtons,
      } = Utility.paginate(data, currentPage, pageSize);

      currentPage = page; // update global page state

      setTimeout(() => {
        container.innerHTML = "";
        if (data.length === 0) {
          pagination.innerHTML = "";
          noRecords.style.display = "block";
          return;
        } else {
          noRecords.style.display = "none";
          pagedData.forEach((u) => {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td><input type="checkbox"></td>              
              <td>${Utility.toTitleCase(u.fullname)}</td>
              <td>${u.userid}</td>
              <td>${Utility.toTitleCase(u.actions)}</td>              
              <td>${u.action_time}</td>
            `;
            container.appendChild(row);
            pagination.innerHTML = generateButtons("onPageClick");

            // Make this function global for onclick in generateButtons
            window.onPageClick = function (page) {
              currentPage = page;
              renderData(data);
            };

            Utility.downloadPDF("logs", "landscape");
            Utility.exportToCSV(data, "logs.csv");
          });
        }
      }, Utility.loadTimeout);
    }

    function filterRecords() {
      const search = document.getElementById("searchInput").value.toLowerCase();
      const role = document.getElementById("roleFilter")?.value;

      let filtered = logData.filter(
        (u) =>
          ((u.fullname && u.fullname.toLowerCase().includes(search)) ||
            (u.email_address &&
              u.email_address.toLowerCase().includes(search))) &&
          (!role || u.role_id === role)
      );

      renderData(filtered);
    }
    const roleFilter = document.getElementById("roleFilter");

    document
      .getElementById("searchInput")
      .addEventListener("input", filterRecords);

    if (roleFilter) {
      roleFilter.addEventListener("change", filterRecords);
    }

    filterRecords();
  }

  static chartInstance = null;

  static loginTrends(logs) {
    const domElem = document.getElementById("loginTrends");
    if (!domElem) return;

    const dayMap = { Sun: 0, Mon: 0, Tue: 0, Wed: 0, Thu: 0, Fri: 0, Sat: 0 };

    logs.forEach((log) => {
      if (log.actions.toLowerCase() === "logged in") {
        const date = new Date(log.action_time);
        const day = date.toLocaleDateString("en-US", { weekday: "short" });
        if (dayMap[day] !== undefined) {
          dayMap[day]++;
        }
      }
    });

    const labels = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
    const data = labels.map((day) => dayMap[day]);

    if (this.chartInstance) {
      this.chartInstance.data.labels = labels;
      this.chartInstance.data.datasets[0].data = data;
      this.chartInstance.update();
      return;
    }

    const ctx = domElem.getContext("2d");
    this.chartInstance = new Chart(ctx, {
      type: "line",
      data: {
        labels,
        datasets: [
          {
            label: "Logins",
            data,
            borderColor: "rgba(75, 192, 192, 1)",
            tension: 0.3,
            fill: false,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
      },
    });
  }

  static renderAdminData(adminData) {
    const pageSize = 10;
    let currentPage = 1;

    function renderData(data) {
      const container = document.getElementById("adminTbody");
      container.innerHTML =
        "<tr class='skeleton-row'><td colspan='7'></td></tr>";
      const pagination = document.getElementById("paginationAdmin");
      const noRecords = document.getElementById("no-adminRecords");
      const {
        pagedData,
        totalPages,
        currentPage: page,
        hasNext,
        hasPrev,
        generateButtons,
      } = Utility.paginate(data, currentPage, pageSize);

      currentPage = page; // update global page state

      setTimeout(() => {
        container.innerHTML = "";
        if (data.length === 0) {
          pagination.innerHTML = "";
          noRecords.style.display = "block";
          return;
        } else {
          noRecords.style.display = "none";
          pagedData.forEach((u) => {
            const row = document.createElement("tr");
            row.innerHTML = `                   
              <td>${u.fullname}</td>
              <td>${u.userid}</td>                
               <td><span class="status ${u.account_status}">
              ${Utility.toTitleCase(u.account_status)}</span></td>         
              <td>
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
                  <select class="form-select change_status form-select-sm w-100 w-sm-auto" style="max-width: 100px; padding: 2px 4px;" 
                  data-id="${u.userid}">
                    ${User.statuses
                      .map(
                        (status) =>
                          `<option value="${status}" ${
                            u.account_status == status ? "selected" : ""
                          }>${status}</option>`
                      )
                      .join("")}
                  </select>                 
                  <button class="btn btn-sm btn-outline-error delete" 
                  data-id="${u.userid}">
                    <i class='fa fa-times'></i>
                  </button>
                </div>
              </td>
            `;
            container.appendChild(row);
            pagination.innerHTML = generateButtons("onPageClick");

            // Make this function global for onclick in generateButtons
            window.onPageClick = function (page) {
              currentPage = page;
              renderData(data);
            };

            User.updateStatus();
            User.deleteUser();
          });
        }
      }, Utility.loadTimeout);
    }

    function filterRecords() {
      const search = document
        .getElementById("adminSearchInput")
        .value.toLowerCase();

      let filtered = adminData.filter(
        (u) =>
          (u.fullname && u.fullname.toLowerCase().includes(search)) ||
          (u.email_address && u.email_address.toLowerCase().includes(search))
      );

      renderData(filtered);
    }

    document
      .getElementById("adminSearchInput")
      .addEventListener("input", filterRecords);

    filterRecords();
  }
}

class UserManager {
  constructor() {
    this.initialize();
  }

  initialize() {
    Utility.runClassMethods(this, ["initialize"]);
  }

  async userDataManagement() {
    const domEl = document.getElementById("user_manager_summary");
    if (!domEl) return;

    const response = await Utility.fetchData(
      `${Utility.API_ROUTE}/admin/profile`,
      "GET"
    );

    const users = response.status == 200 ? response.data : [];
    User.userData = users;
    User.renderUserTable(users);
  }

  async dealerDataManagement() {
    const domEl = document.getElementById("dealer_manager_summary");

    if (!domEl) return;
    const response = await Utility.fetchData(
      `${Utility.API_ROUTE}/admin/profile/dealers`,
      "GET"
    );
    const dealers = response.status == 200 ? response.data : [];
    User.renderDealersTable(dealers);
  }

  updateProfile() {
    const domEl = document.getElementById("profile-page");
    if (!domEl) return;
    const profileForm = document.getElementById("profileForm");

    profileForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const result = await Swal.fire({
        title: "Update Profile!",
        text: "Do you wish to continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Continue!",
      });
      if (result.isConfirmed) {
        const data = new FormData(e.target);

        const response = await Utility.fetchData(
          `${Utility.API_ROUTE}/user/profile/${profileForm.dataset.id}`,
          data,
          "POST"
        );

        Swal.fire(
          response.status == 200 ? "Success!" : "Error",
          `${response.message}`,
          response.status == 200 ? "success" : "error"
        );

        if (response.status == 200) {
          const data = response.data;
          await SessionManager.setSession({
            token: sessionStorage.getItem("token"),
            role: data.role_id,
            userid: data.userid,
          });
          Utility.encodeUserData(data);
          await SessionManager.unsetProfileSession();
          Utility.reloadPage();
        }
      }
    });
  }

  

}
new UserManager();
