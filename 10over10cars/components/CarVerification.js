"use client";
import React from "react";
import Modal from "@/components/Modal";
import RegisterVin from "@/components/ModalComponents/RegisterVin";
import { useState } from "react";
import { useRouter } from "next/navigation";

const CarVerification = ({ id }) => {
  const [vin, setVin] = useState(false);
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
      //router.push("/dashboard/vehicle/");
    }
  }

  function modalClose() {
    setVin(false);
  }
  return (
    <>
      <div className="f-width special-bg padding-20 summary-card summary-card-big">
        <p className="color-black title">
          Total number of <br />
          Vehicle verification by user
        </p>
        <h3>13</h3>
        <button
          className="button button-primary radius-5"
          onClick={() => {
            setVin(true);
          }}
        >
          <i className="fas fa-car mr-10"></i>New verification
        </button>
      </div>
      {vin && (
        <Modal
          modalTitle="Register Vin"
          Component={RegisterVin}
          modalAction={saveVin}
          modalClose={modalClose}
          size="modal-md"
        />
      )}
    </>
  );
};

export default CarVerification;
