import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Accounts Management</h4>
          <p className="color-grey">
            Manage all the accounts in the application, admin and users
            included.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">User Management</h5>
          <p className="color-grey">
            Welcome to the User Management section of 10over10Cars, where you
            can efficiently manage user profiles, permissions, and access
            settings to ensure a seamless and secure user experience.
          </p>
          <div className="moveup-10">
            <Link href="/admin/accounts/users" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                users
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Admin Management</h5>
          <p className="color-grey">
            Welcome to the User Management section of 10over10Cars, where you
            can efficiently manage user profiles, permissions, and access
            settings to ensure a seamless and secure user experience.
          </p>
          <div className="moveup-10">
            <Link href="/admin/accounts/admins" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                admins
              </p>
            </Link>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
