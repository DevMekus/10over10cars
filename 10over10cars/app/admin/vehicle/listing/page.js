"use client";
import React from "react";
import Link from "next/link";
import Modal from "@/components/Modal";
import VehicleInformationForm from "@/components/ModalComponents/VehicleInformationForm";
import { useState } from "react";

const page = () => {
  const [modal, setModal] = useState(false);
  const componentArray = [];
  /**componentArray Will contain all the components containing new report form */
  function saveNewAdmin(event) {
    event.preventDefault();
    alert("Submitting form");
  }
  function modalClose() {
    setModal(false);
  }
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Vehicle Management</h4>
          <p className="color-grey">
            Manage all the car related reports: New cars, verification requests,
            product features, etc.
          </p>
        </div>
        <div className="mt-10 special-bg padding-10">
          <button
            className="button button-primary radius-5"
            onClick={() => {
              setModal(true);
            }}
          >
            New report
          </button>
          <p className="color-grey">
            Add a new car verification report by clicking the button
          </p>
          {modal && (
            <Modal
              modalTitle="Vehicle Report"
              Component={VehicleInformationForm}
              modalAction={saveNewAdmin}
              modalClose={modalClose}
              size="modal-lg"
            />
          )}
        </div>
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
                  <th scope="col">#InvoiceId</th>
                  <th scope="col">Owner</th>
                  <th scope="col">Save Date</th>
                  <th scope="col">Verification</th>
                  <th scope="col">Documentation</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">27HJJ937V</th>
                  <td>27HJJ937V</td>
                  <td>John Doe</td>
                  <td>25-10-2021</td>
                  <td>VERIFIED</td>
                  <td>YES</td>
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
