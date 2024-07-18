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
          <h5 className="color-white">Vehicle feature manager</h5>
          <p className="color-grey">
            Add, and delete car feature, including colors, model, body etc.
          </p>

          <div className="moveup-10">
            <Link
              href="/admin/vehicle/gallery/features"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Get
                started
              </p>
            </Link>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
