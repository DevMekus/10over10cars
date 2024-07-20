"use client";
import React from "react";
import Modal from "@/components/Modal";
import VehicleInformationForm from "@/components/ModalComponents/VehicleInformationForm";
import RegisterVin from "@/components/ModalComponents/RegisterVin";
import { useState } from "react";

const StartVerification = ({ moreInfo = false }) => {
  const [vin, setVin] = useState(false);
  const [vehicleInfo, setVehicleInfo] = useState(false);
  const [features, setFeatures] = useState(false);

  function saveVin(event) {
    event.preventDefault();
    const response = true;
    if (response) {
      /**Switch to the veicleInfo Component */
      setVin(false);
      setVehicleInfo(true);
    }
  }

  function saveCarInformation(event) {
    event.preventDefault();
    alert("Saving car Information");
  }

  function modalClose() {
    setVin(false);
    setVehicleInfo(false);
  }
  return (
    <>
      <div className="mt-10 special-bg padding-10">
        <div className="col-sm-9">
          <div className="row">
            <div className="col-sm-4">
              <div className="f-width special-bg padding-20 summary-card summary-card-big">
                <p className="color-black title">
                  Total number of <br />
                  Vehicles registered
                </p>
                <h3>1,000</h3>
                <button
                  className="button button-primary radius-5"
                  onClick={() => {
                    setVin(true);
                  }}
                >
                  <i className="fas fa-plus mr-10"></i>New Registration
                </button>
              </div>
            </div>
            <div className="col-sm-8">
              <div className="row">
                <div className="col-sm-6">
                  <div className="f-width special-bg padding-10 summary-card summary-card-white">
                    <div className="flex gap-10">
                      <div className="icon-div">
                        <img
                          src="https://cdn4.iconfinder.com/data/icons/doodle-5/184/car-256.png"
                          alt="icon"
                        />
                      </div>
                      <div>
                        <h3>12</h3>
                        <p className="color-grey title">Awaiting validation</p>
                      </div>
                    </div>
                  </div>
                </div>
                {moreInfo && (
                  <div className="col-sm-6">
                    <div className="f-width special-bg padding-10 summary-card summary-card-white">
                      <div className="flex gap-10">
                        <div className="icon-div">
                          <img
                            src="https://cdn4.iconfinder.com/data/icons/liny/24/users-line-512.png"
                            alt="icon"
                          />
                        </div>
                        <div>
                          <h3>12</h3>
                          <p className="color-grey title">Registered users</p>
                        </div>
                      </div>
                    </div>
                  </div>
                )}
              </div>
              {moreInfo && (
                <div className="mt-20">
                  <div className="row">
                    <div className="col-sm-6">
                      <div className="f-width special-bg padding-10 summary-card summary-card-white">
                        <div className="flex gap-10">
                          <div className="icon-div">
                            <img
                              src="https://cdn4.iconfinder.com/data/icons/doodle-3/175/file-invoice-256.png"
                              alt="icon"
                            />
                          </div>
                          <div>
                            <h3>14</h3>
                            <p className="color-grey title">Unpaid invoice</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className="col-sm-6">
                      <div className="f-width special-bg padding-10 summary-card summary-card-white">
                        <div className="flex gap-10">
                          <div className="icon-div">
                            <img
                              src="https://cdn4.iconfinder.com/data/icons/multimedia-75/512/multimedia-02-512.png"
                              alt="icon"
                            />
                          </div>
                          <div>
                            <h3>18</h3>
                            <p className="color-grey title">Support Messages</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>
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
        {vehicleInfo && (
          <Modal
            modalTitle="Vehicle Information"
            Component={VehicleInformationForm}
            modalAction={saveCarInformation}
            modalClose={modalClose}
            size="modal-md"
          />
        )}
      </div>
    </>
  );
};

export default StartVerification;
