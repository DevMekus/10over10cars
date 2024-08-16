"use client";
import React from "react";
import Link from "next/link";
import Pagination from "@/components/Pagination";
import Modal from "@/components/Modal";
import { useState } from "react";
import NewSupport from "@/components/ModalComponents/NewSupport";

const page = () => {
  const [modal, setModal] = useState(false);

  function createsupport(event) {
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
          <h4 class="color-primary">Support Management</h4>
          <p className="color-grey">Manage all the support tickets</p>
          <div className="">
            <button
              className="mt-10 button button-primary radius-5"
              onClick={() => {
                setModal(true);
              }}
            >
              Start support
            </button>
            <p className="color-grey">
              Click on the button to start a new support message
            </p>
            {modal && (
              <Modal
                modalTitle="Support Message"
                Component={NewSupport}
                modalAction={createsupport}
                modalClose={modalClose}
                size="modal-md"
              />
            )}
          </div>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Support List</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search support</label>
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
                  <th scope="col">#Id</th>
                  <th scope="col">Subject</th>
                  <th scope="col">Date</th>
                  <th scope="col">Priority</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">27HHKG2</th>
                  <td>Account Unverified</td>

                  <td>25-10-2021</td>
                  <td>Urgent</td>
                  <td>Open</td>
                  <td className="flex gap-10">
                    <Link
                      href="/dashboard/messaging/support/id"
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
          <div className="f-width flex flex-end">
            <Pagination />
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
