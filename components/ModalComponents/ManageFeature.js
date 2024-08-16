"use client";
import React from "react";
import Modal from "@/components/Modal";
import VehicleFeatures from "./VehicleFeatures";
import { useState } from "react";

const ManageFeature = () => {
  const [features, setFeatures] = useState(false);

  function saveCarInformation(event) {
    event.preventDefault();
    alert("Saving car Feature");
  }

  function modalClose() {
    setFeatures(false);
  }
  return (
    <>
      <div className="mt-10">
        <div className="col-sm-9">
          <button
            className="button button-primary radius-5"
            onClick={() => {
              setFeatures(true);
            }}
          >
            Get started
          </button>
        </div>

        {features && (
          <Modal
            modalTitle="Feature Manager"
            Component={VehicleFeatures}
            modalAction={saveCarInformation}
            modalClose={modalClose}
            size="modal-md"
          />
        )}
      </div>
    </>
  );
};

export default ManageFeature;
