"use client";
import React from "react";
import CarVerification from "./CarVerification";
import { useState, useEffect } from "react";
import { getSession } from "@/library/utils/sessionManager";
import { fetchData } from "@/library/utils/fetchData";

const UserDashboard = ({ moreInfo = false }) => {
  const [data, setData] = useState(null);
  const [verifications, setVerifications] = useState(null);
  const [userverifications, setuserVerifications] = useState(null);
  const [pendingVerifications, setPendingVerifications] = useState(null);
  const [unpaidInvoice, setUnpaidInvoice] = useState(null);
  const [supportMessages, setSupportMessages] = useState(null);

  useEffect(() => {
    getSession().then((userid) => {
      if (userid) {
        getVerifications(userid);
        getUnpaidInvoice();
        getSupportMessages(userid);
      }
    });
  }, []);
  async function getVerifications(sessionId) {
    await fetchData(`verification`, "GET").then((data) => {
      console.log(data);
      getPendingVerification(sessionId, data);
      verificationByUser(sessionId, data);
      let count = 0;
      if (typeof data !== "string") {
        count = data.length;
      }
      setVerifications(count);
    });
  }

  function getPendingVerification(sessionId, data) {
    let pending = null;

    pending = data.filter(
      (item) => item.userid == sessionId && item.rstatus == "pending"
    );

    setPendingVerifications(pending.length);
  }

  function verificationByUser(sessionId, data) {
    const newData = data.filter((item) => item.userid == sessionId);
    setuserVerifications(newData.length);
  }

  function getUnpaidInvoice() {
    let cart = localStorage.getItem("cart")
      ? JSON.parse(localStorage.getItem("cart"))
      : [];

    setUnpaidInvoice(cart.length);
  }

  async function getSupportMessages(sessionId) {
    const data = await fetchData(`support/${sessionId}`, "GET");

    let count = 0;
    if (typeof data !== "string") {
      count = data.length;
    }
    setSupportMessages(count);
  }
  return (
    <>
      <div className="special-bgs padding-10">
        <div className="col-sm-9">
          <div className="row">
            <div className="col-sm-4">
              <CarVerification number={userverifications} />
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
                        <h3>{verifications}</h3>
                        <p className="color-grey title">
                          Cars verified by company!
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
                          <h3>{pendingVerifications}</h3>
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
                            <h3>{unpaidInvoice}</h3>
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
                            <h3>{supportMessages}</h3>
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
