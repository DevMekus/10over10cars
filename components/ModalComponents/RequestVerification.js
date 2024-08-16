"use client";
import React from "react";
import Link from "next/link";
import { useState } from "react";

const RequestVerification = () => {
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

  const handleNewRequest = (event) => {
    event.preventDefault();
    const vin = document.querySelector(".vin");

    const data = {
      itemDescription: "Vehicle verification",
      itemType: "VERIFICATION",
      vin: vin,
      price: 5000,
    };

    if (addToCart(data)) {
      setSuccess("Item added to cart");
    } else {
      setError("Item failed to register");
    }
  };

  function addToCart(data) {
    let cart = localStorage.getItem("cart")
      ? JSON.parse(localStorage.getItem("cart"))
      : [];

    cart = cart.push(data);
    const added = localStorage.setItem("cart", JSON.stringify(cart));
    console.log(added);
    return added;
  }
  return (
    <>
      <div className="wrapper padding-10">
        <p className="color-white small-p moveup-10">
          Enter a vehicle vin number to request for verification report.
        </p>
        {error && <p className="color-red">{error}</p>}
        {success && <p className="color-green">{success}</p>}

        <form onSubmit={handleNewRequest}>
          <div className="col-sm-8">
            <div className="ctr-wrapper">
              <label className="color-grey">Enter Vin Number</label>
              <input
                className="form-input form-ctr .ctr-no-bg vin"
                type="text"
                name="vin"
                placeholder="Ex: 378HJKS373GH"
                required
              />
            </div>
          </div>
          <div className="f-width flex flex-end ">
            <button className="button button-primary radius-5 mt-10">
              Get started
            </button>
          </div>
        </form>
      </div>
    </>
  );
};

export default RequestVerification;
