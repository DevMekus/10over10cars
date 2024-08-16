import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div>
        <div className="dash-page">
          <div className="card-primary">
            <h4 class="color-primary">Users Management</h4>
            <p className="color-grey">
              Comprehensive table displaying all users, allowing you to easily
              view, edit, and manage their profiles and permissions.
            </p>
          </div>
        </div>
        <div className="mt-20">
          <h5 className="color-white">User List</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search user's list</label>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: John, John Doe"
                required
              />
            </div>
          </div>
          <div className="mt-10 scrollable">
            <table className="btable">
              <thead>
                <tr>
                  <th scope="col">#userId</th>
                  <th scope="col">Username</th>
                  <th scope="col">Account Date</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">12637</th>
                  <td>John Doe</td>
                  <td>25-10-2021</td>
                  <td>Verified</td>
                  <td className="flex gap-10">
                    <Link
                      href="/admin/accounts/users/id"
                      className="button button-sm radius-5 button-primary"
                    >
                      <i className="fas fa-eye"></i>
                    </Link>
                    <button className="button button-sm radius-5 button-danger">
                      <i className="fas fa-times"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
