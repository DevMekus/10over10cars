"use client";
import React from "react";
import Modal from "@/components/Modal";

import { useState } from "react";
import { useRouter } from "next/navigation";
import RequestVerification from "./ModalComponents/RequestVerification";

const CarVerification = ({ number }) => {
  const [modal, setModal] = useState(false);
  const router = useRouter();

  function saveVin(event) {
    event.preventDefault();
    const response = true;
    if (response) {
      /**Switch to the veicleInfo Component */
      alert("Send to a car verification page");
      /**
       * Save to cart
       */
    }
  }

  function modalClose() {
    setModal(false);
  }
  return (
    <>
      <div className="f-width special-bg padding-20 summary-card summary-card-big">
        <p className="color-black title">
          Total number of <br />
          Vehicle verification by user
        </p>
        <h3>{number}</h3>
        <button
          className="button button-primary radius-5"
          onClick={() => {
            setModal(true);
          }}
        >
          <i className="fas fa-car mr-10"></i>New verification
        </button>
      </div>
      {modal && (
        <Modal
          modalTitle="Request Verification"
          Component={RequestVerification}
          modalAction={saveVin}
          modalClose={modalClose}
          size="modal-sm"
        />
      )}
    </>
  );
};

export default CarVerification;
