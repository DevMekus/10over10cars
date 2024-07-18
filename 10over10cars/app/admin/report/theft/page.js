"use client";
import Link from "next/link";
import React from "react";
import Modal from "@/components/Modal";
import TheftReportForm from "@/components/ModalComponents/TheftReportForm";
import { useState } from "react";

const page = () => {
  const [modal, setModal] = useState(false);
  function saveNewAdmin(event) {
    event.preventDefault();
    alert("Submitting form");
  }
  function modalClose() {
    setModal(false);
  }
  return (
    <>
      <div>
        <div className="dash-page">
          <div className="card-primary">
            <h4 class="color-primary">Theft Reports Management</h4>
            <p className="color-grey">
              Comprehensive table displaying all theft reports, allowing you to
              easily view, edit, and delete data.
            </p>
          </div>
        </div>
        <div className="mt-10 special-bg padding-20">
          <h5 className="color-white">New Report</h5>
          <p className="color-grey">
            Click on the button below to report a stolen vehicle.
          </p>

          <button
            className="button button-primary radius-5"
            onClick={() => {
              setModal(true);
            }}
          >
            New Report
          </button>
          {modal && (
            <Modal
              modalTitle="Theft Report"
              Component={TheftReportForm}
              modalAction={saveNewAdmin}
              modalClose={modalClose}
              size="modal-lg"
            />
          )}
        </div>
        <div className="mt-20">
          <h5 className="color-white">Report List</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search report list</label>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: Toyota Camry, 3782281, John Doe"
                required
              />
            </div>
          </div>
          <div className="mt-10 scrollable">
            <table className="btable">
              <thead>
                <tr>
                  <th scope="col">#Car Vin</th>
                  <th scope="col">Car Owner</th>
                  <th scope="col">Report Date</th>
                  <th scope="col">Theft Date</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">27HHKG278VGF88JK</th>
                  <td>John Doe</td>
                  <td>25-10-2021</td>
                  <td>25-10-2021</td>
                  <td>Not Found</td>
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
      </div>
    </>
  );
};

export default page;
