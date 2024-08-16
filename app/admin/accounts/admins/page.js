"use client";
import Link from "next/link";
import React from "react";
import Modal from "@/components/Modal";
import NewAdminForm from "@/components/ModalComponents/NewAdminForm";
import { useState } from "react";

const page = () => {
  const [modal, setModal] = useState(false);
  function saveNewAdmin(event) {
    event.preventDefault();
    alert("Submitting form");
  }
  function modalClose() {
    setModal(false);
  }
  return (
    <>
      <div>
        <div className="dash-page">
          <div className="card-primary">
            <h4 class="color-primary">Administrator Management</h4>
            <p className="color-grey">
              Comprehensive table displaying all users, allowing you to easily
              view, edit, and manage their profiles and permissions.
            </p>
          </div>
        </div>
        <div className="mt-10 special-bg padding-20">
          <h5 className="color-white">New Administrator</h5>
          <p className="color-grey">
            Click on the button below to add a new Administrator
          </p>

          <button
            className="button button-primary radius-5"
            onClick={() => {
              setModal(true);
            }}
          >
            New Admin
          </button>
          {modal && (
            <Modal
              modalTitle="New Administrator"
              Component={NewAdminForm}
              modalAction={saveNewAdmin}
              modalClose={modalClose}
            />
          )}
        </div>
        <div className="mt-20">
          <h5 className="color-white">Admin List</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search admin's list</label>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: John, John Doe"
                required
              />
            </div>
          </div>
          <div className="mt-10 scrollable">
            <table className="btable">
              <thead>
                <tr>
                  <th scope="col">#admin Id</th>
                  <th scope="col">Username</th>
                  <th scope="col">Fullname</th>
                  <th scope="col">Access</th>
                  <th scope="col">Create Date</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">12637</th>
                  <td>@JohnDoe</td>
                  <td>John Doe</td>
                  <td>5</td>
                  <td>25-10-2021</td>
                  <td>Active</td>
                  <td className="flex gap-10">
                    <Link
                      href="/admin/accounts/admins/id"
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
        </div>
      </div>
    </>
  );
};

export default page;
