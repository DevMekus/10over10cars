import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Activity log Management</h4>
          <p className="color-grey">
            Manage all the accounts activity including login, purchase and
            verification attempts.
          </p>
        </div>
        <div className="mt-20">
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search list</label>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: Login, Purchase, John Doe"
                required
              />
            </div>
          </div>
          <div className="row">
            <div className="col-sm-8">
              <h4 className="color-grey">Activity List</h4>
              <div className="mt-10 scrollable">
                <table className="btable">
                  <thead>
                    <tr>
                      <th scope="col">#Id</th>
                      <th scope="col">Time & date</th>
                      <th scope="col">Activity type</th>
                      <th scope="col">IP Address</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">27HH</th>
                      <td>23 July, 2024 12:13 am</td>
                      <td>Purchase</td>

                      <td>
                        34:372:28:20{" "}
                        <i
                          className="fa fa-map-marker ml-10 color-green"
                          aria-hidden="true"
                        ></i>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">27HH</th>
                      <td>21 July, 2024 12:13 Pm</td>
                      <td>Login</td>

                      <td>
                        34:372:28:20{" "}
                        <i
                          className="fa fa-map-marker ml-10 color-green"
                          aria-hidden="true"
                        ></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div className="col-sm-4">
              <div className="special-bg padding-10">
                <p className="color-white">
                  This is the activity message goten by hovering on an activity
                </p>
                <p className="color-grey moveup-10">July 12, 2021 12:02Pm</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
