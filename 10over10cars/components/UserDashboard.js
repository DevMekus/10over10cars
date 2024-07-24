"use client";
import React from "react";
import CarVerification from "./CarVerification";

const UserDashboard = ({ moreInfo = false }) => {
  return (
    <>
      <div className="special-bg padding-10">
        <div className="col-sm-9">
          <div className="row">
            <div className="col-sm-4">
              <CarVerification />
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
                        <h3>1200+</h3>
                        <p className="color-grey title">
                          Cars verified by comapny!
                        </p>
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
                          <p className="color-grey title">
                            User pending validations
                          </p>
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
                            <h3>8</h3>
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
                            <h3>7</h3>
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
      </div>
    </>
  );
};

export default UserDashboard;
