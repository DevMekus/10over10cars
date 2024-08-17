"use client";
import React from "react";
import GetLog from "@/app/libs/Log/GetLog";
import { useState, useEffect } from "react";
import { getSession } from "@/library/utils/sessionManager";
import { formatTimestamp } from "@/app/libs/Utility";

const page = () => {
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  const [log, setLog] = useState([]);

  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(0);
  const limit = 10; // Items per page

  useEffect(() => {
    getSession().then((sessionId) => {
      GetLog(sessionId).then((log) => {
        setLog(log);
        console.log(log);
      });
    });
  }, []);
  function logMessages(id) {
    alert("Showing log message iD: " + id);
  }
  return (
    <>
      <div className="dash-page">
        <div className="cards-primary">
          <h3 className="color-primary page-title">Activity log</h3>
          <p className="color-white small-p">
            Manage all the accounts activity including login, purchase and
            verification attempts.
          </p>
        </div>
        <div className="mt-20">
          {log ? (
            <div>
              <h4 className="color-white">Activity List</h4>
              <div className="mt-10 col-sm-3">
                <div className="ctr-wrapper">
                  <input
                    className="form-input form-ctr ctr-no-bg"
                    type="text"
                    placeholder="Ex: Login, Purchase, John Doe"
                    required
                  />
                </div>
              </div>
              <div className="row">
                <div className="col-sm-12">
                  <p className="color-white">
                    Click on a log to view its information
                  </p>
                  <div className="mt-10 scrollable">
                    <table className="btable">
                      <thead>
                        <tr>
                          <th scope="col">#Id</th>
                          <th scope="col">Time & date</th>
                          <th scope="col">Activity type</th>
                          <th scope="col">IP Address</th>
                        </tr>
                      </thead>
                      <tbody>
                        {log &&
                          log.map((item) => (
                            <tr
                              key={item.id}
                              onClick={() => logMessages(item.id)}
                            >
                              <th scope="row">{item.log_id}</th>
                              <td>{formatTimestamp(item.time_stamp)}</td>
                              <td>{item.log_type}</td>
                              <td>
                                {item.ip ? (
                                  <>
                                    item.ip
                                    <i
                                      className="fa fa-map-marker ml-10 color-green"
                                      aria-hidden="true"
                                    ></i>
                                  </>
                                ) : (
                                  ""
                                )}
                              </td>
                            </tr>
                          ))}
                      </tbody>
                    </table>
                  </div>
                </div>
                {/* <div className="col-sm-4">
                  <div className="special-bg padding-10">
                    <p className="color-white">
                      This is the activity message goten by hovering on an
                      activity
                    </p>
                    <p className="color-grey moveup-10">
                      July 12, 2021 12:02Pm
                    </p>
                  </div>
                </div> */}
              </div>
            </div>
          ) : (
            <div>
              <h5 className="color-primary">Not found!</h5>
              <p className="color-white">
                There are no user logs at the moment
              </p>
            </div>
          )}
        </div>
      </div>
    </>
  );
};

export default page;
