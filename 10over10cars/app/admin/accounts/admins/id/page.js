import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primarys">
          <h4 class="color-primary">Admin Management</h4>
          <p className="color-grey">
            Comprehensive table displaying all users, allowing you to easily
            view, edit, and manage their profiles and permissions.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">
            John Doe{" "}
            <span className="color-green">
              (<em>@JohnDoe</em>)
            </span>
          </h5>
          <p className="color-grey moveup-10">Profile Information</p>

          <div className="row">
            <div className="col-sm-6 special-bg padding-20">
              <div className="row">
                <div className="col-sm-3">
                  <div
                    className="profile-image-wrap"
                    style={{
                      backgroundImage: `url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcyI9Cvp53aaP9XeRn-ZKbJDH2QaWC72O26A&s)`,
                    }}
                  ></div>
                </div>
                <div className="col-sm-8">
                  <div className="profile info">
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-grey">#Admin ID</p>
                      <p className="color-white">36272HH8KJ</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-grey">Fullname</p>
                      <p className="color-white">Doe, John</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-grey">Username</p>
                      <p className="color-white">@JohnDoe</p>
                    </div>

                    <div className="f-width flex space-between align-center">
                      <p className="bold color-grey">Phone Number</p>
                      <p className="color-white">+234-08068822168</p>
                    </div>

                    <div className="f-width flex space-between align-center">
                      <p className="bold color-grey">Email Address</p>
                      <p className="color-white">Johndoe@gmail.com</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-grey">Account Date</p>
                      <p className="color-white">26-04-2024</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="col-sm-3">
              <div className="card-primary">
                <h5 className="color-primary">Administrative summary</h5>
                <div className="mts-5">
                  <p className="color-white">
                    <i className="fas fa-check-circle color-green"></i> User
                    active
                  </p>
                  <div className="ctr-wrapper col-sm-8">
                    <select className="form-input form-ctr ctr-no-bg">
                      <option>Active</option>
                      <option>Blocked</option>
                    </select>
                  </div>
                </div>
                <p>Click to view admin logs</p>
                <div className="moveup-10">
                  <Link
                    href="/admin/accounts/admins"
                    className="link decoration"
                  >
                    <p className="color-grey">
                      <i className="fas fa-arrow-right mr-10 color-primary"></i>
                      Manage logs
                    </p>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
