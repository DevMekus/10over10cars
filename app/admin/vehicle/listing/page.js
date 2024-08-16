"use client";
import React from "react";
import Link from "next/link";
import StartVerification from "@/components/StartVerification";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <StartVerification />
        <div className="mt-20">
          <h5 className="color-white">Vehicle List</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search list</label>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: 3678HJU39"
                required
              />
            </div>
          </div>
          <div className="mt-10 scrollable">
            <table className="btable">
              <thead>
                <tr>
                  <th scope="col">#VIN</th>
                  <th scope="col">Last Update</th>
                  <th scope="col">Vehicle Name</th>
                  <th scope="col">Status</th>
                  <th scope="col">Verifying Agent</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">27HJJ937V</th>
                  <td>July 12, 2022</td>
                  <td>Toyota Avalon (2010 Skylight)</td>
                  <td>unverified</td>
                  <td>John Doe</td>
                  <td className="flex gap-10">
                    <Link
                      href="/admin/vehicle/id"
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
        <div className="icon-bottom">
          <div
            className="page-icon"
            style={{
              backgroundImage: `url(https://cdn1.iconfinder.com/data/icons/ionicons-sharp-vol-1/512/car-sport-sharp-256.png)`,
            }}
          ></div>
        </div>
      </div>
    </>
  );
};

export default page;
